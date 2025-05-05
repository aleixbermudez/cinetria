@php
  $listData = [
    [
      'text' => 'Recomendaciones personalizadas',
    ],
    [
      'text' => 'Sigue a tus amigos y descubre sus opiniones',
    ],
    [
      'text' => 'Organiza tus películas, series, actores y directores en listas personalizables',
    ],
  ];
@endphp

<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">

  <div class="md:grid md:grid-cols-2 md:items-center md:gap-12 xl:gap-32">
    <div>
      <img class="rounded-xl" src={{ asset('images/hero-2.jpg') }} alt="Features Image">
    </div>

    <div class="mt-5 sm:mt-10 lg:mt-0">
      <div class="space-y-6 sm:space-y-8">
        <!-- Title -->
        <div class="space-y-2 md:space-y-4">
          <h2 class="font-bold text-3xl lg:text-4xl text-gray-800 dark:text-neutral-200">
            Explora, debate y comparte tu pasión por el cine
          </h2>
          <p class="text-gray-500 dark:text-neutral-500">
            Más que un simple foro, en Cinetria puedes discutir sobre películas y series, descubrir nuevas recomendaciones y estar al tanto de lo que ven tus amigos. Además, organiza y gestiona tus listas de contenido pendiente o visto en un solo lugar.
          </p>
        </div>


        <!-- Lista recorriendo dataList -->
        <ul class="space-y-2 sm:space-y-4">
          @foreach ($listData as $item)
            <li class="flex items-start gap-4 bg-white dark:bg-neutral-900 p-4 rounded-2xl shadow-md border border-gray-100 dark:border-neutral-800 transform transition-all duration-500 ease-in-out hover:shadow-2xl hover:scale-105 hover:-translate-y-2 hover:bg-gradient-to-r hover:from-amber-100 hover:to-amber-200 dark:hover:from-amber-300/10 dark:hover:to-amber-400/10">
              <div class="flex-shrink-0 h-10 w-10 rounded-full bg-amber-100 dark:bg-amber-300/10 flex items-center justify-center text-amber-400 dark:text-amber-300 transition-transform duration-500 ease-in-out hover:rotate-12 hover:scale-125">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <polyline points="20 6 9 17 4 12"/>
                </svg>
              </div>
              <p class="text-base text-gray-700 dark:text-gray-300 transition-opacity duration-500 ease-in-out hover:opacity-90">
                {{ $item['text'] }}
              </p>
            </li>
          @endforeach

        </ul>
      </div>
    </div>
  </div>
</div>