
<!-- Favoritas -->
<div id="slider-Favoritas" class="mt-6">
    <h3 class="text-center text-2xl font-extrabold mt-8 text-black">Mis peliculas y series favoritas</h3>
    <div class="swiper Favoritas-slider mt-6 px-6">
        <div class="swiper-wrapper">
            @foreach ($favoritas as $favorita)
                <div class="swiper-slide p-4 text-center bg-white transition-transform duration-300 hover:scale-105" style="width: 250px !important;">
                    <a href="{{$favorita->tipo_contenido}}/detalles/{{$favorita->id_contenido}}">
                    <img src="https://image.tmdb.org/t/p/w200{{$favorita->id_contenido}}" 
                         alt="{{$favorita->titulo_contenido}}" 
                         class="w-40 h-auto mx-auto mb-4 rounded-lg shadow-sm">
                    <h4 class="text-lg font-semibold text-gray-800">{{$favorita->titulo_contenido}}</h4>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>


<!-- Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializa el slider
        new Swiper('.Favoritas-slider', {
            slidesPerView: 'auto',
            spaceBetween: 10
        });

        // Procesa cada slide
        document.querySelectorAll('#slider-Favoritas .swiper-slide').forEach(slide => {
            const enlace = slide.querySelector('a');
            if (!enlace) return;

            const urlPartes = enlace.getAttribute('href').split('/');
            var tipo = urlPartes[0]; // "movie" o "tv"
            const id = urlPartes[urlPartes.length - 1]; // ID numérico
            if(tipo === 'peliculas'){
                tipo = 'movie';
            } else if(tipo === 'series'){
                tipo = 'tv';
            } else {
                console.error(`Tipo de contenido no reconocido: ${tipo}`);
                return;
            }
            fetch(`https://api.themoviedb.org/3/${tipo}/${id}?language=es-ES`, {
                method: 'GET',
                headers: {
                    accept: 'application/json',
                    Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4OGEzMjE5MTAxNTZiZWFlZWY1MzBlYzNhMmQxNTg5MSIsIm5iZiI6MTczODMxNjcyMS4yNjgsInN1YiI6IjY3OWM5YmIxODIyZTdkMzJmN2JkZTg2MiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.TnYuqSvLds-SafDDSVYFrCieAvhOqtG0kstT95IPt1s'
                }
            })
            .then(res => res.json())
            .then(data => {
                const poster = data.poster_path
                    ? `https://image.tmdb.org/t/p/w200${data.poster_path}`
                    : '';
                const imagenEl = slide.querySelector('img');
                if (poster && imagenEl) {
                    imagenEl.src = poster;
                    imagenEl.alt = data.title || data.name || 'Sin título';
                }
            })
            .catch(err => console.error(`Error al cargar datos de TMDB para ID ${id}:`, err));
        });
    });
</script>







