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
        } else {
            $tipoApi = 'tv';
        }
        // Obtener datos desde la API
        $mejores = $this->mejorContenido($tipoApi);
        $populares = $this->contenidoPopulares($tipoApi);
        $generos = $this->obtenerGeneros($tipoApi);


        // devolver la vista con los datos obtenidos
        return view('pages.contenido', compact('tipo','mejores', 'populares', 'generos'));
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
    public function abrirPaginaDetalle($id)
    {
        $detalles = $this->obtenerInfoId($id);
        // Cambiar el formato de la respuesta de la API
        $movie = [
            'titulo' => $detalles['title'] ?? $detalles['name'],
            'poster_url' => 'https://image.tmdb.org/t/p/w500' . $detalles['poster_path'],
            'anho' => substr($detalles['release_date'] ?? $detalles['first_air_date'], 0, 4),
            'valoracion' => $detalles['vote_average'],
            'resumen' => $detalles['overview'],
            'reparto' => collect($this->obtenerContenidoDesdeAPI("https://api.themoviedb.org/3/movie/{$id}/credits?language=es-ES")['cast'])
                ->take(10)
                ->map(function ($actor) {
                    return [
                        'nombre' => $actor['name'],
                        'personaje' => $actor['character'],
                        'foto' => $actor['profile_path'] ? 'https://image.tmdb.org/t/p/w500' . $actor['profile_path'] : null,
                    ];
                }),
            'production_company' => $detalles['production_companies'][0]['name'] ?? 'Desconocida',
            'original_language' => strtoupper($detalles['original_language']),
            'budget' => $detalles['budget'] ?? 0,
            'revenue' => $detalles['revenue'] ?? 0,
        ];

        return view('pages.contenido_detalle', compact('movie'));
    }

    private function obtenerDirector($crew)
    {
        foreach ($crew as $persona) {
            if ($persona['job'] === 'Director') {
                return $persona['name'];
            }
        }
        return 'Desconocido';
    }


    public function obtenerInfoId($id)
    {
        $url = "https://api.themoviedb.org/3/movie/{$id}?language=es-ES";

        return $this->obtenerContenidoDesdeAPI($url);
    }

}
