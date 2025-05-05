@php
  $data = [
    [
      'icon' => '<svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="10" height="14" x="3" y="8" rx="2"/><path d="M5 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2h-2.4"/><path d="M8 18h.01"/></svg>',
      'title' => 'PC, Tablet, Móvil...',
      'description' => 'Lee, debate y publica desde cualquier sitio.',
    ],
    [
      'icon' => '<svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7h-9"/><path d="M14 17H5"/><circle cx="17" cy="17" r="3"/><circle cx="7" cy="7" r="3"/></svg>',
      'title' => 'Tu perfil',
      'description' => 'Crea tu lista de favoritos y comparte tus opiniones.',
    ],
    [
      'icon' => '<svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>',
      'title' => 'Reseñas',
      'description' => 'Escribe reseñas de películas o series.',
    ],
    [
      'icon' => '<svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2v5Z"/><path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1"/></svg>',
      'title' => 'Foro',
      'description' => 'Consulta reseñas y perfiles de otros usuarios.',
    ],
    [
      'icon' => '<svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
      'title' => 'Amigos',
      'description' => 'Observa lo que publican tus amigos.',
    ],
    
  ];
@endphp

<!-- Icon Blocks -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <div class="grid sm:grid-cols-2 lg:grid-cols-5 items-center gap-6">
    @foreach ($data as $item)
      <div class="bg-white shadow-md rounded-lg p-6 dark:bg-neutral-800 transform transition-transform duration-500 hover:scale-110 hover:shadow-2xl h-full flex flex-col group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-300 opacity-0 group-hover:opacity-30 transition-opacity duration-700"></div>
        <div class="flex justify-center items-center w-16 h-16 bg-amber-300 rounded-xl mb-4 transform group-hover:scale-125 transition-transform duration-700 ease-out">
          {!! $item['icon'] !!}
        </div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2 group-hover:text-amber-500 transition-colors duration-500 ease-in-out">{{ $item['title'] }}</h3>
        <p class="text-gray-600 dark:text-neutral-400 flex-grow group-hover:translate-y-2 group-hover:opacity-90 transition-opacity duration-500 ease-in-out">{{ $item['description'] }}</p>
      </div>
    @endforeach
  </div>
</div>
