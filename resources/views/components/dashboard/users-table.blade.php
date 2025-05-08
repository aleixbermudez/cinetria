<!-- Contenedor principal con bordes redondeados -->
<div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-neutral-700">
    <!-- Table -->
    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
        <thead class="bg-gray-50 dark:bg-neutral-800">
            <tr>
                <th scope="col" class="ps-6 py-3 text-start">
                    <label for="hs-at-with-checkboxes-main" class="flex">
                        <input type="checkbox"
                            class="shrink-0 border-gray-300 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                            id="hs-at-with-checkboxes-main">
                        <span class="sr-only">Checkbox</span>
                    </label>
                </th>
                <th scope="col" class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                        <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                            Nombre
                        </span>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                        <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                            Número de reseñas
                        </span>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                        <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                            Verificado
                        </span>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                        <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                            Fecha de alta
                        </span>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 text-end"></th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
            @foreach ($users as $user)
            <tr>
                <td class="size-px whitespace-nowrap">
                    <div class="ps-6 py-3">
                        <label for="user-checkbox-{{ $user->id }}" class="flex">
                            <input type="checkbox"
                                class="shrink-0 border-gray-300 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                id="user-checkbox-{{ $user->id }}">
                            <span class="sr-only">Checkbox</span>
                        </label>
                    </div>
                </td>
                <td class="size-px whitespace-nowrap">
                    <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                        <div class="flex items-center gap-x-3">
                            <div class="grow">
                                <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                    {{ $user->name }}
                                </span>
                                <span class="block text-sm text-gray-500 dark:text-neutral-500">
                                    {{ $user->email }}
                                </span>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="h-px w-72 whitespace-nowrap">
                    <div class="px-6 py-3">
                        <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                            500
                        </span>
                    </div>
                </td>
                <td class="size-px whitespace-nowrap">
                    <div class="px-6 py-3">
                        @if ($user->verified)
                        <span
                            class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                            <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </svg>
                            Verificado
                        </span>
                        @else
                        <span class="text-sm text-gray-500 dark:text-neutral-500">No verificado</span>
                        @endif
                    </div>
                </td>
                <td class="size-px whitespace-nowrap">
                    <div class="px-6 py-3">
                        <span class="text-sm text-gray-500 dark:text-neutral-500">
                            {{ $user->created_at->format('d M, H:i') }}
                        </span>
                    </div>
                </td>
                <td class="size-px whitespace-nowrap">
                    <div class="px-6 py-1.5">
                        <a class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-hidden focus:underline font-medium dark:text-blue-500"
                            href="#">
                            Edit
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total de usuarios -->
    <div class="bg-gray-50 dark:bg-neutral-800 px-6 py-4 text-sm text-gray-700 dark:text-neutral-300 border-t border-gray-200 dark:border-neutral-700">
        Total de usuarios: <span class="font-semibold">{{ count($users) }}</span>
    </div>
</div>
