@php
  $onHover = "relative after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-black after:transition-all after:duration-500 hover:after:w-full";

  $navbarItems = [
    [
      'name' => 'Inicio',
      'href' => "/"
    ],
    [
      'name' => 'Peliculas',
      'href' => "/peliculas"
    ],
    [
      'name' => 'Series',
      'href' => "/series"
    ],
    [
      'name' => 'Sobre Cinetria',
      'href' => "/sobre-cinetria"
    ],
    [
      'name' => 'Foro',
      'href' => "/foro"
    ],
    [
      'name' => 'Login',
      'href' => "/login"
    ]
  ];
@endphp

<header class="flex flex-wrap lg:justify-start lg:flex-nowrap z-50 w-full py-7">
  <nav class="relative max-w-7xl w-full flex flex-wrap lg:grid lg:grid-cols-12 basis-full items-center px-4 md:px-6 lg:px-8 mx-auto">
    <div class="lg:col-span-3 flex items-center">
      <!-- Logo -->
      <a href="/">
        <img src="{{ asset('images/cinetria.png') }}" alt="Cinetria" class="w-[150px]" />
      </a>
    </div>

    <!-- Login -->
    <div class="flex items-center gap-x-1 lg:gap-x-2 ms-auto py-1 lg:ps-6 lg:order-3 lg:col-span-3">

      <div class="lg:hidden">
        <button type="button" class="hs-collapse-toggle flex justify-center items-center text-sm font-semibold rounded-xl border border-gray-200 text-black hover:bg-gray-100 focus:outline-none dark:text-white dark:border-neutral-700 dark:hover:bg-neutral-700" id="hs-navbar-hcail-collapse" aria-expanded="false" aria-controls="hs-navbar-hcail" aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-hcail">
          <svg class="hs-collapse-open:hidden w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
          <svg class="hs-collapse-open:block hidden w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
      </div>

    </div>

    <!-- Items -->
    <div id="hs-navbar-hcail" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow lg:block lg:w-auto lg:basis-auto lg:order-2 lg:col-span-9" aria-labelledby="hs-navbar-hcail-collapse">
      <div class="flex flex-col gap-y-4 gap-x-0 mt-5 lg:flex-row lg:justify-center lg:items-center lg:gap-y-0 lg:gap-x-7 lg:mt-0 text-xl">
        @foreach ($navbarItems as $item)
          <div>
            <a class="{{ $onHover }}" href="{{ $item['href'] }}">{{ $item['name'] }}</a>
          </div>
        @endforeach
      </div>
    </div>
  </nav>
</header>
