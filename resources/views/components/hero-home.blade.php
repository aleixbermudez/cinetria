@php

  $onHover = 'transition-transform duration-300 ease-in-out transform hover:scale-105';

@endphp

<div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
  <div class="grid md:grid-cols-2 gap-4 md:gap-8 xl:gap-20 md:items-center">
    <div>
      <h1 class="block text-3xl font-bold text-gray-800 sm:text-4xl lg:text-5xl lg:leading-tight dark:text-white"> Las grandes historias no terminan en los créditos. Vívelas en <span class="text-amber-300">Cinetria</span></h1>
      <p class="mt-3 text-lg text-gray-800 dark:text-neutral-400">Más que peliculas. Una comunidad que siente, analiza y comparte el cine.</p>

      <!-- Buttons -->
      <div class="mt-7 grid gap-3 w-full sm:inline-flex">
        <a class="py-3 w-[150px] inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-amber-300 text-black hover:bg-amber-500 focus:outline-hidden focus:bg-amber-500 disabled:opacity-50 disabled:pointer-events-none {{ $onHover }}" href="#">
          <span>Foro</span>
        </a>
        <a class="py-3 w-[150px] inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 {{ $onHover }}" href="/sobre-cinetria">
          <span>Sobre Cinetria</span>
        </a>
      </div>
    </div>

    <div class="relative ms-4">

      <img class="w-full rounded-md hidden md:block" src="{{ asset('images/hero-image.jpg') }}" alt="Hero Image" loading="lazy" decoding="async">

    </div>
  </div>
</div>
