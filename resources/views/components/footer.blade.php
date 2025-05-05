
@php
    $socialLinks = [
        [
            'href' => '#',
            'icon' => '<svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.31.975.975 1.248 2.242 1.31 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.31 3.608-.975.975-2.242 1.248-3.608 1.31-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.31-.975-.975-1.248-2.242-1.31-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.31-3.608.975-.975 2.242-1.248 3.608-1.31C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.015 7.052.072 5.773.129 4.548.392 3.5 1.44 2.452 2.488 2.189 3.713 2.132 4.992.015 8.332 0 8.741 0 12s.015 3.668.072 4.948c.057 1.279.32 2.504 1.368 3.552 1.048 1.048 2.273 1.311 3.552 1.368C8.332 23.985 8.741 24 12 24s3.668-.015 4.948-.072c1.279-.057 2.504-.32 3.552-1.368 1.048-1.048 1.311-2.273 1.368-3.552.057-1.279.072-1.688.072-4.948s-.015-3.668-.072-4.948c-.057-1.279-.32-2.504-1.368-3.552C19.452.392 18.227.129 16.948.072 15.668.015 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-7.998 3.999 3.999 0 0 1 0 7.998zm6.406-11.845a1.44 1.44 0 1 0 0-2.88 1.44 1.44 0 0 0 0 2.88z"/></svg>',
            'srText' => 'Instagram',
        ],
        [
            'href' => '#',
            'icon' => '<svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z" clip-rule="evenodd"/></svg>',
            'srText' => 'GitHub',
        ]
    ];

    $onHover = "relative after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-black after:transition-all after:duration-500 hover:after:w-full";

@endphp

<footer class="bg-white dark:bg-gray-900">

    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <div class="md:flex md:justify-between">
          <div class="mb-6 md:mb-0">
            <a href="/" class="flex items-center">
                <img src="{{ asset('images/cinetria.png') }}" alt="Cinetria" class="w-[150px]" />
            </a>  
          </div>
          <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Cinetria</h2>
                  <ul class="text-gray-500 dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="/peliculas" class="{{ $onHover }}">Peliculas</a>
                      </li>
                      <li>
                          <a href="/series" class="{{ $onHover }}">Series</a>
                      </li>
                  </ul>
              </div>
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Siguenos</h2>
                  <ul class="text-gray-500 dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="https://github.com/themesberg/flowbite" class="{{ $onHover }}">Github</a>
                      </li>
                      <li>
                          <a href="https://discord.gg/4eeurUVvTy" class="{{ $onHover }}">Instagram</a>
                      </li>
                  </ul>
              </div>
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
                  <ul class="text-gray-500 dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="#" class="{{ $onHover }}">Política de Privacidad</a>
                      </li>
                      <li>
                          <a href="#" class="{{ $onHover }}">Terminos &amp; Condiciones</a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
      <div class="sm:flex sm:items-center sm:justify-between">
          <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2025 <a href="https://flowbite.com/" class="hover:underline text-amber-500">Cinetria</a>. Todos los derechos reservados
          </span>
          <div class="flex mt-4 sm:justify-center sm:mt-0">


            @foreach ($socialLinks as $link)
                <a href="{{ $link['href'] }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                    {!! $link['icon'] !!}
                    <span class="sr-only">{{ $link['srText'] }}</span>
                </a>
            @endforeach  
      </div>
    </div>
</footer>
