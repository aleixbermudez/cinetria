<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContenidoController extends Controller
{
    public function abrirPagina($tipo)
    {
        // Cambio de idioma al tipo para que se haga la selección de la API correctamente
        if ($tipo == 'peliculas') {
            $tipoApi = 'movie';
        } else if ($tipo == 'series') {
            $tipoApi = 'tv';
        } 
        // Obtener datos desde la API
        $mejores = $this->mejorContenido($tipoApi);
        $populares = $this->contenidoPopulares($tipoApi);
        $estrenos = $this->proximosEstrenos($tipoApi);
        $generos = $this->obtenerGeneros($tipoApi);


        // devolver la vista con los datos obtenidos
        return view('pages.contenido', compact('tipo','mejores', 'populares','estrenos', 'generos'));
    }

    // Metodo que hace la llamada a la API segun la url que se le pase
    private function obtenerContenidoDesdeAPI($url)
    {
        //require_once('vendor/autoload.php');

        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', $url, [
        'headers' => [
            'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4OGEzMjE5MTAxNTZiZWFlZWY1MzBlYzNhMmQxNTg5MSIsIm5iZiI6MTczODMxNjcyMS4yNjgsInN1YiI6IjY3OWM5YmIxODIyZTdkMzJmN2JkZTg2MiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.TnYuqSvLds-SafDDSVYFrCieAvhOqtG0kstT95IPt1s',
            'accept' => 'application/json',
        ],
        ]);

        return json_decode($response->getBody(), true);
    }

    // Metodos que hacen la llamada a la API para obtener los mejores y populares
    private function mejorContenido($tipo)
    {
        $url = "https://api.themoviedb.org/3/{$tipo}/top_rated?language=es-ES&page=1";
        return $this->obtenerContenidoDesdeAPI($url);
    }

    private function contenidoPopulares($tipo)
    {
        $url = "https://api.themoviedb.org/3/{$tipo}/popular?language=es-ES&page=1";
        return $this->obtenerContenidoDesdeAPI($url);
    }

    private function proximosEstrenos($tipo)
    {
        if ($tipo == 'movie') {
            $url = "https://api.themoviedb.org/3/movie/upcoming?language=es-ES&page=1";
        } else if ($tipo == 'tv') {
            $url = "https://api.themoviedb.org/3/tv/on_the_air?language=es-ES&page=1";
        }
        return $this->obtenerContenidoDesdeAPI($url);
    }

    // Metodo para obtener los géneros desde la API
    private function obtenerGeneros($tipo)
    {

        $url = "https://api.themoviedb.org/3/genre/{$tipo}/list?language=es-ES";
        return $this->obtenerContenidoDesdeAPI($url);
    }

    // Metodo para obtener el contenido por género
    public function obtenerPeliculasPorGenero(Request $request)
    {
        $tipo = $request->input('tipo', 'movie');
        $generos = $request->input('generos', '');
        $pagina = $request->input('pagina', 1);

        $url = "https://api.themoviedb.org/3/discover/{$tipo}?language=es-ES&with_genres={$generos}&page={$pagina}&sort_by=popularity.desc&include_adult=false";

        return response()->json($this->obtenerContenidoDesdeAPI($url));
    }

    // Metodo para obtener la página concreta de una peli...
    public function abrirPaginaDetalle($tipo, $id)
    {
        if ($tipo == 'peliculas') {
            $tipo_api = 'movie';
        } else if ($tipo == 'series') {
            $tipo_api = 'tv';
        } else if ($tipo == 'personas') {
            $tipo_api = 'person';
        } else {
            abort(404); // Manejar otros tipos si es necesario
        }

        $detalles = $this->obtenerInfoId($tipo, $id);
        if ($tipo == 'personas') {
            $persona = [
                'nombre' => $detalles['name'],
                'foto_perfil' => $detalles['profile_path'] ? 'https://image.tmdb.org/t/p/w500' . $detalles['profile_path'] : null,
                'fecha_nacimiento' => $detalles['birthday'] ?? 'Desconocida',
                'lugar_nacimiento' => $detalles['place_of_birth'] ?? 'Desconocido',
                'biografia' => $detalles['biography'] ?? 'No disponible',
                'genero' => $detalles['gender'] == 1 ? 'Mujer' : ($detalles['gender'] == 2 ? 'Hombre' : 'Desconocido'),
                'conocido_por_departamento' => $detalles['known_for_department'] ?? 'Desconocido',
                'peliculas_series' => collect($this->obtenerContenidoDesdeAPI("https://api.themoviedb.org/3/{$tipo_api}/{$id}/combined_credits?language=es-ES")['cast'])
                    ->take(12)
                    ->map(function ($credito) {
                        return [
                            'id' => $credito['id'],
                            'titulo' => $credito['title'] ?? $credito['name'],
                            'poster_url' => $credito['poster_path'] ? 'https://image.tmdb.org/t/p/w200' . $credito['poster_path'] : null,
                            'tipo' => $credito['media_type'] == 'movie' ? 'peliculas' : 'series',
                            'personaje' => $credito['character'] ?? null,
                            'fecha' => $credito['release_date'] ?? $credito['first_air_date'] ?? null,
                        ];
                    }),
            ];
            return view('pages.persona_detalle', compact('persona')); // Asegúrate de tener una vista 'persona_detalle'
        } else {
            
            // Mantener el formato para películas y series
            $movie = [
                'titulo' => $detalles['title'] ?? $detalles['name'],
                'poster_url' => 'https://image.tmdb.org/t/p/original' . $detalles['poster_path'],
                'anho' => substr($detalles['release_date'] ?? $detalles['first_air_date'], 0, 4),
                'valoracion' => $detalles['vote_average'],
                'resumen' => $detalles['overview'],
                'reparto' => collect($this->obtenerContenidoDesdeAPI("https://api.themoviedb.org/3/{$tipo_api}/{$id}/credits?language=es-ES")['cast'])
                    ->take(10)
                    ->map(function ($actor) {
                        return [
                            'id' => $actor['id'],
                            'nombre' => $actor['name'],
                            'personaje' => $actor['character'],
                            'foto' => $actor['profile_path'] ? 'https://image.tmdb.org/t/p/w500' . $actor['profile_path'] : null,
                        ];
                    }),
                'generos' => collect($detalles['genres'])
                    ->map(function ($genero) {
                        return [
                            'nombre' => $genero['name'],
                            'id' => $genero['id'],
                        ];
                    }),
                'equipo' => collect($this->obtenerContenidoDesdeAPI("https://api.themoviedb.org/3/{$tipo_api}/{$id}/credits?language=es-ES")['crew'])
                    ->take(5)
                    ->map(function ($equipo) {
                        $cargoTraducido = match ($equipo['job']) {
                            'Writer' => 'Escritor',
                            'Producer' => 'Productor',
                            'Director' => 'Director',
                            default => $equipo['job'],
                        };
                        return [
                            'id' => $equipo['id'],
                            'nombre' => $equipo['name'],
                            'cargo' => $cargoTraducido,
                            'foto' => $equipo['profile_path'] ? 'https://image.tmdb.org/t/p/w500' . $equipo['profile_path'] : null,
                        ];
                    }),
                'trailer' => $this->obtenerContenidoDesdeAPI("https://api.themoviedb.org/3/{$tipo_api}/{$id}/videos?language=es-ES")['results'][0]['key'] ?? null,
                'duracion' => $detalles['runtime'] ?? $detalles['episode_run_time'][0] ?? 0,
                'productora' => $detalles['production_companies'][0]['name'] ?? 'Desconocida',
                'idioma_original' => strtoupper($detalles['original_language']),
                'presupuesto' => isset($detalles['budget']) && $detalles['budget'] > 0 ? number_format($detalles['budget'], 0, ',', '.') . ' €' : 'No disponible',
                'recaudacion' => isset($detalles['revenue']) && $detalles['revenue'] > 0 ? number_format($detalles['revenue'], 0, ',', '.') . ' €' : 'No disponible',
                'fecha_estreno' => $detalles['release_date'] ?? $detalles['first_air_date'],
                'temporadas' => $detalles['number_of_seasons'] ?? null,
                'episodios' => $detalles['number_of_episodes'] ?? null,
            ];
            //dd($detalles);
            return view('pages.contenido_detalle', compact('movie', 'tipo')); // Asegúrate de tener una vista 'contenido_detalle'
        }
    }

    public function obtenerInfoId($tipo, $id)
    {
        if ($tipo == 'peliculas') {
            $tipo_api = 'movie';
        } else if ($tipo == 'series') {
            $tipo_api = 'tv';
        } else if ($tipo == 'personas') {
            $tipo_api = 'person';
        } else {
            abort(404);
        }
        $url = "https://api.themoviedb.org/3/{$tipo_api}/{$id}?language=es-ES";

        return $this->obtenerContenidoDesdeAPI($url);
    }



}
