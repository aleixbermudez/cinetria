<!-- Botones de selección -->
<div class="mt-6 flex justify-start gap-0 border border-gray-300 rounded-full overflow-hidden">
    <button id="btn-populares" class="w-1/2 px-6 py-3 bg-gray-300 text-gray-800 font-bold transition-all duration-300 focus:outline-none">
        Populares
    </button>
    <div class="w-px bg-gray-400"></div>
    <button id="btn-mejores" class="w-1/2 px-6 py-3 bg-gray-300 text-gray-800 font-bold transition-all duration-300 focus:outline-none">
        Mejores
    </button>
</div>


<div id="slider-populares" class="mt-6">
    <h3 class="text-center text-2xl font-extrabold mt-8 text-yellow-500">POPULARES</h3>
    <div class="swiper populares-slider mt-6 px-6">
        <div class="swiper-wrapper">
            @foreach(collect($populares["results"])->sortByDesc('vote_average') as $popular)
                <div class="swiper-slide p-2 text-center" style="width: 250px !important;">
                    <img src="https://image.tmdb.org/t/p/w200{{$popular['poster_path']}}" 
                         alt="{{$popular['title'] ?? $popular['name']}}" 
                         class="w-40 h-auto mx-auto mb-4 rounded-lg shadow-md">
                    <h4 class="text-lg font-bold text-gray-800">{{$popular['title'] ?? $popular['name']}}</h4>
                    <p class="text-yellow-500 font-semibold mt-2">⭐ {{$popular['vote_average']}}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- MEJORES -->
<div id="slider-mejores" class="mt-6 hidden">
    <h3 class="text-center text-2xl font-extrabold mt-8 text-yellow-500">MEJORES</h3>
    <div class="swiper mejores-slider mt-6 px-6">
        <div class="swiper-wrapper">
            @foreach(collect($mejores["results"])->sortByDesc('vote_average') as $mejor)
                <div class="swiper-slide p-2 text-center" style="width: 250px !important;">
                <img src="https://image.tmdb.org/t/p/w200{{$mejor['poster_path']}}" 
                     alt="{{$mejor['title'] ?? $mejor['name']}}" 
                     class="w-40 h-auto mx-auto mb-4 rounded-lg shadow-md">
                <h4 class="text-lg font-bold text-gray-800">{{$mejor['title'] ?? $mejor['name']}}</h4>
                <p class="text-yellow-500 font-semibold mt-2">⭐ {{$mejor['vote_average']}}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Include Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

<!-- Include Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializar sliders
        new Swiper('.populares-slider', {
            slidesPerView: 'auto',
            spaceBetween: 5
        });

        new Swiper('.mejores-slider', {
            slidesPerView: 'auto',
            spaceBetween: 5
        });

        // Botones y funcionalidad de alternancia
        const btnPopulares = document.getElementById('btn-populares');
        const btnMejores = document.getElementById('btn-mejores');
        const sliderPopulares = document.getElementById('slider-populares');
        const sliderMejores = document.getElementById('slider-mejores');

        btnPopulares.addEventListener('click', function () {
            sliderPopulares.classList.remove('hidden');
            sliderMejores.classList.add('hidden');
            btnPopulares.classList.add('bg-yellow', 'text-white');
            btnPopulares.classList.remove('bg-gray-300', 'text-gray-800');
            btnMejores.classList.add('bg-gray-300', 'text-gray-800');
            btnMejores.classList.remove('bg-yellow', 'text-white');
        });

        btnMejores.addEventListener('click', function () {
            sliderMejores.classList.remove('hidden');
            sliderPopulares.classList.add('hidden');
            btnMejores.classList.add('bg-amber-500', 'text-white');
            btnMejores.classList.remove('bg-gray-300', 'text-gray-800');
            btnPopulares.classList.add('bg-gray-300', 'text-gray-800');
            btnPopulares.classList.remove('bg-amber-500', 'text-white');
        });
    });
</script>