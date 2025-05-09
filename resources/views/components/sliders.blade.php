@php
 if($tipo == 'peliculas'){
    $texto_mostrar = 'Proximos Estrenos';
 } else if($tipo == 'series'){
    $texto_mostrar = 'Proximas Emisiones';
 } else {
    $texto_mostrar = '';
 }
@endphp

<div class="mt-10 flex justify-center gap-4 w-full max-w-md mx-auto">
  <button id="btn-populares"
    class="flex-1 px-6 py-3 text-base font-semibold text-neutral-900 dark:text-white bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-md hover:bg-neutral-100 dark:hover:bg-neutral-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:z-10 shadow-sm">
    Populares
  </button>
  <button id="btn-mejores"
    class="flex-1 px-6 py-3 text-base font-semibold text-neutral-700 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-700 rounded-md hover:bg-neutral-200 dark:hover:bg-neutral-800 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:z-10 shadow-sm">
    Mejores
  </button>
  <button id="btn-estrenos"
    class="flex-1 px-6 py-3 text-base font-semibold text-neutral-700 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-700 rounded-md hover:bg-neutral-200 dark:hover:bg-neutral-800 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:z-10 shadow-sm">
    {{$texto_mostrar}}
  </button>
</div>


<!-- POPULARES -->
<div id="slider-populares" class="mt-6">
    <h3 class="text-center text-2xl font-extrabold mt-8 text-black">POPULARES</h3>
    <div class="swiper populares-slider mt-6 px-6">
        <div class="swiper-wrapper">
            @foreach(collect($populares["results"])->sortByDesc('vote_average') as $popular)
                <div class="swiper-slide p-4 text-center bg-white transition-transform duration-300 hover:scale-105" style="width: 250px !important;">
                    <a href="{{$tipo}}/detalles/{{$popular['id']}}">
                    <img src="https://image.tmdb.org/t/p/w200{{$popular['poster_path']}}" 
                         alt="{{$popular['title'] ?? $popular['name']}}" 
                         class="w-40 h-auto mx-auto mb-4 rounded-lg shadow-sm">
                    <h4 class="text-lg font-semibold text-gray-800">{{$popular['title'] ?? $popular['name']}}</h4>
                    <p class="text-yellow-500 font-bold mt-2">⭐ {{$popular['vote_average']}}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- MEJORES -->
<div id="slider-mejores" class="mt-6 hidden">
    <h3 class="text-center text-2xl font-extrabold mt-8 text-black">MEJORES</h3>
    <div class="swiper mejores-slider mt-6 px-6">
        <div class="swiper-wrapper">
            @foreach(collect($mejores["results"])->sortByDesc('vote_average') as $mejor)
                <div class="swiper-slide p-4 text-center bg-white transition-transform duration-300 hover:scale-105" style="width: 250px !important;">
                    <a href="{{$tipo}}/detalles/{{$mejor['id']}}">
                    <img src="https://image.tmdb.org/t/p/w200{{$mejor['poster_path']}}" 
                         alt="{{$mejor['title'] ?? $mejor['name']}}" 
                         class="w-40 h-auto mx-auto mb-4 rounded-lg shadow-sm">
                    <h4 class="text-lg font-semibold text-gray-800">{{$mejor['title'] ?? $mejor['name']}}</h4>
                    <p class="text-yellow-500 font-bold mt-2">⭐ {{$mejor['vote_average']}}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>


<!-- ESTRENOS -->
<div id="slider-estrenos" class="mt-6 hidden">
    <h3 class="text-center text-2xl font-extrabold mt-8 text-black">{{ strtoupper($texto_mostrar) }}</h3>
    <div class="swiper mejores-slider mt-6 px-6">
        <div class="swiper-wrapper">
            @foreach(collect($estrenos["results"])->sortByDesc('vote_average') as $estreno)
                <div class="swiper-slide p-4 text-center bg-white transition-transform duration-300 hover:scale-105" style="width: 250px !important;">
                    <a href="{{$tipo}}/detalles/{{$estreno['id']}}">
                    <img src="https://image.tmdb.org/t/p/w200{{$estreno['poster_path']}}" 
                         alt="{{$estreno['title'] ?? $estreno['name']}}" 
                         class="w-40 h-auto mx-auto mb-4 rounded-lg shadow-sm">
                    <h4 class="text-lg font-semibold text-gray-800">{{$estreno['title'] ?? $estreno['name']}}</h4>
                    <p class="text-yellow-500 font-bold mt-2">⭐ {{$estreno['vote_average']}}</p>
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
        new Swiper('.populares-slider', {
            slidesPerView: 'auto',
            spaceBetween: 10
        });

        new Swiper('.mejores-slider', {
            slidesPerView: 'auto',
            spaceBetween: 10
        });

        new Swiper('.estrenos-slider', {
            slidesPerView: 'auto',
            spaceBetween: 10
        });

        const btnPopulares = document.getElementById('btn-populares');
        const btnMejores = document.getElementById('btn-mejores');
        const btnEstrenos = document.getElementById('btn-estrenos');
        const sliderEstrenos = document.getElementById('slider-estrenos');
        const sliderPopulares = document.getElementById('slider-populares');
        const sliderMejores = document.getElementById('slider-mejores');

        btnPopulares.addEventListener('click', function () {
            sliderPopulares.classList.remove('hidden');
            sliderMejores.classList.add('hidden');
            sliderEstrenos.classList.add('hidden');
            btnPopulares.classList.add('bg-yellow-400', 'text-white');
            btnPopulares.classList.remove('bg-gray-100', 'text-gray-800');
            btnMejores.classList.add('bg-gray-100', 'text-gray-800');
            btnMejores.classList.remove('bg-yellow-400', 'text-white');
            btnEstrenos.classList.add('bg-gray-100', 'text-gray-800');
            btnEstrenos.classList.remove('bg-yellow-400', 'text-white');
        });

        btnMejores.addEventListener('click', function () {
            sliderMejores.classList.remove('hidden');
            sliderPopulares.classList.add('hidden');
            sliderEstrenos.classList.add('hidden');
            btnMejores.classList.add('bg-yellow-400', 'text-white');
            btnMejores.classList.remove('bg-gray-100', 'text-gray-800');
            btnPopulares.classList.add('bg-gray-100', 'text-gray-800');
            btnPopulares.classList.remove('bg-yellow-400', 'text-white');
            btnEstrenos.classList.add('bg-gray-100', 'text-gray-800');
            btnEstrenos.classList.remove('bg-yellow-400', 'text-white');
        });
        btnEstrenos.addEventListener('click', function () {
            sliderEstrenos.classList.remove('hidden');
            sliderPopulares.classList.add('hidden');
            sliderMejores.classList.add('hidden');
            btnEstrenos.classList.add('bg-yellow-400', 'text-white');
            btnEstrenos.classList.remove('bg-gray-100', 'text-gray-800');
            btnPopulares.classList.add('bg-gray-100', 'text-gray-800');
            btnPopulares.classList.remove('bg-yellow-400', 'text-white');
            btnMejores.classList.add('bg-gray-100', 'text-gray-800');
            btnMejores.classList.remove('bg-yellow-400', 'text-white');
        });
    });
</script>
