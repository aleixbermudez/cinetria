<!-- POPULARES -->
<h3 class="text-center text-xl font-bold mt-8">POPULARES</h3>
<div class="swiper populares-slider mt-4 px-6">
    <div class="swiper-wrapper">
        @foreach($populares["results"] as $popular)
            <div class="swiper-slide bg-white rounded-lg shadow-md p-4 text-center w-72">
                <img src="https://image.tmdb.org/t/p/w200{{$popular['poster_path']}}" 
                     alt="{{$popular['title'] ?? $popular['name']}}" 
                     class="w-32 h-auto mx-auto mb-2 rounded">
                <h4 class="text-lg font-semibold">{{$popular['title'] ?? $popular['name']}}</h4>
                <p class="text-gray-600">Valoración: {{$popular['vote_average']}}</p>
                <p class="text-sm text-gray-500">ID: {{$popular['id']}}</p>
            </div>
            
            <!-- Include Swiper CSS -->
            <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
            
            <!-- Include Swiper JS -->
            <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        @endforeach
    </div>
    <div class="swiper-button-next populares-next"></div>
    <div class="swiper-button-prev populares-prev"></div>
</div>

<!-- MEJORES -->
<h3 class="text-center text-xl font-bold mt-12">MEJORES</h3>
<div class="swiper mejores-slider mt-4 px-6">
    <div class="swiper-wrapper">
        @foreach($mejores["results"] as $mejor)
            <div class="swiper-slide bg-white rounded-lg shadow-md p-4 text-center w-72">
                <img src="https://image.tmdb.org/t/p/w200{{$mejor['poster_path']}}" 
                     alt="{{$mejor['title'] ?? $mejor['name']}}" 
                     class="w-32 h-auto mx-auto mb-2 rounded">
                <h4 class="text-lg font-semibold">{{$mejor['title'] ?? $mejor['name']}}</h4>
                <p class="text-gray-600">Valoración: {{$mejor['vote_average']}}</p>
                <p class="text-sm text-gray-500">ID: {{$mejor['id']}}</p>
            </div>
        @endforeach
    </div>
    <div class="swiper-button-next mejores-next"></div>
    <div class="swiper-button-prev mejores-prev"></div>
</div>




<script>
    new Swiper('.populares-slider', {
        slidesPerView: 3,
        spaceBetween: 20,
        navigation: {
            nextEl: '.populares-next',
            prevEl: '.populares-prev',
        },
        breakpoints: {
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        }
    });

    new Swiper('.mejores-slider', {
        slidesPerView: 3,
        spaceBetween: 20,
        navigation: {
            nextEl: '.mejores-next',
            prevEl: '.mejores-prev',
        },
        breakpoints: {
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        }
    });
</script>