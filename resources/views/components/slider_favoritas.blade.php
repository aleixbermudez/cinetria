<!-- POPULARES -->
<div id="slider-favoritas" class="mt-6">
    <h3 class="text-center text-2xl font-extrabold mt-8 text-black">POPULARES</h3>
    <div class="swiper favoritas-slider mt-6 px-6">
        <div class="swiper-wrapper">
            @foreach(collect($favoritas["results"])->sortByDesc('vote_average') as $favorita)
                <div class="swiper-slide p-4 text-center bg-white transition-transform duration-300 hover:scale-105" style="width: 250px !important;">
                    <a href="">
                    <img src="https://image.tmdb.org/t/p/w200{{$favorita['poster_path']}}" 
                         alt="{{$favorita['title'] ?? $favorita['name']}}" 
                         class="w-40 h-auto mx-auto mb-4 rounded-lg shadow-sm">
                    <h4 class="text-lg font-semibold text-gray-800">{{$favorita['title'] ?? $popular['name']}}</h4>
                    <p class="text-yellow-500 font-bold mt-2">⭐ {{$favorita['vote_average']}}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.favoritas-slider', {
            slidesPerView: 'auto',
            spaceBetween: 10
        });
    });
</script>
