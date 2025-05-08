
  <!-- Content -->
  <div class="w-full lg:ps-96">
    <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

        <!-- Numero total de usuarios -->

        <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
          <div class="p-4 md:p-5">
            <div class="flex items-center gap-x-2">
              <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                Usuarios totales
              </p>
            </div>

            <div class="mt-1 flex items-center gap-x-2">
              <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                {{ \App\Models\User::count() }}   
              </h3>
            </div>
          </div>
        </div>

        <!-- Reseñas -->
        <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
          <div class="p-4 md:p-5">
            <div class="flex items-center gap-x-2">
              <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                Reseñas
              </p>
            </div>

            <div class="mt-1 flex items-center gap-x-2">
              <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                <!-- TODO: Aqui va el numero de reseñas -->
                 569
              </h3>
            </div>
          </div>
        </div>

        <!-- Card -->
        <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
          <div class="p-4 md:p-5">
            <div class="flex items-center gap-x-2">
              <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                Avg. Click Rate
              </p>
            </div>

            <div class="mt-1 flex items-center gap-x-2">
              <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                56.8%
              </h3>
              <span class="flex items-center gap-x-1 text-red-600">
                <svg class="inline-block size-4 self-center" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="22 17 13.5 8.5 8.5 13.5 2 7" />
                  <polyline points="16 17 22 17 22 11" />
                </svg>
                <span class="inline-block text-sm">
                  1.7%
                </span>
              </span>
            </div>
          </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
          <div class="p-4 md:p-5">
            <div class="flex items-center gap-x-2">
              <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                Pageviews
              </p>
            </div>

            <div class="mt-1 flex items-center gap-x-2">
              <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                92,913
              </h3>
            </div>
          </div>
        </div>
        <!-- End Card -->
      </div>
      <!-- End Grid -->
    </div>
  </div>
  <!-- End Content -->