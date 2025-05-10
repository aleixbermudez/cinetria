
<!-- Favoritas -->
<div id="slider-Favoritas" class="mt-6">
    <h3 class="text-center text-2xl font-extrabold mt-8 text-black">Mis peliculas favoritas</h3>
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
        new Swiper('.Favoritas-slider', {
            slidesPerView: 'auto',
            spaceBetween: 10
        });
    });
</script>






