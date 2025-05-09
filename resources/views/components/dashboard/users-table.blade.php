<!-- Tabla de Usuarios -->
<div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-neutral-700">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
        <thead class="bg-gray-50 dark:bg-neutral-800">
            <tr>
                <th class="ps-6 py-3"></th>
                <th class="ps-6 py-3 text-start text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Nombre</th>
                <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Número de reseñas</th>
                <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Verificado</th>
                <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Fecha de alta</th>
                <th class="px-6 py-3 text-end"></th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
            @foreach ($users as $user)
                <tr>
                    <td class="ps-6 py-3">
                        <input type="checkbox" class="border-gray-300 rounded-sm text-blue-600 dark:bg-neutral-800 dark:border-neutral-600">
                    </td>
                    <td class="ps-6 py-3">
                        <div>
                            <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $user->name }}</span>
                            <span class="block text-sm text-gray-500 dark:text-neutral-500">{{ $user->email }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-3 text-sm font-semibold text-gray-800 dark:text-neutral-200">
                        {{ $user->reviews_count ?? 0 }}
                    </td>
                    <td class="px-6 py-3">
                        @if ($user->verified)
                            <span class="py-1 px-1.5 inline-flex items-center text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">Verificado</span>
                        @else
                            <span class="text-sm text-gray-500 dark:text-neutral-500">No verificado</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-500 dark:text-neutral-500">
                        {{ $user->created_at->format('d M, H:i') }}
                    </td>
                    <td class="px-6 py-3 text-end">
                        <a href="#"
                           onclick="editUser(
                               {{ $user->id }},
                               '{{ e($user->name) }}',
                               '{{ e($user->email) }}',
                               {{ $user->reviews_count ?? 0 }},
                               '{{ $user->created_at->format('Y-m-d H:i:s') }}'
                           )"
                           class="text-sm text-blue-600 hover:underline font-medium dark:text-blue-500">Edit
                        </a>
                        <a href="#" 
                            onclick="deleteUser({{ $user->id }})"
                            class="text-sm ml-4 text-red-600 hover:underline font-medium dark:text-red-500">Eliminar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="bg-gray-50 dark:bg-neutral-800 px-6 py-4 text-sm text-gray-700 dark:text-neutral-300 border-t border-gray-200 dark:border-neutral-700">
        Total de usuarios: <span class="font-semibold">{{ count($users) }}</span>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>


    function deleteUser(id) {
        Swal.fire({
            title: '¿Seguro que quieres eliminarlo?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            focusConfirm: false,
            customClass: {
                popup: 'text-left'
            },
            preConfirm: () => {
                return fetch(`/admin/users/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('No se pudo eliminar el usuario');
                    return response.json();
                })
                .then(() => {
                    Swal.fire('Eliminado', 'El usuario ha sido eliminado correctamente.', 'success')
                        .then(() => location.reload());
                })
                .catch(err => {
                    Swal.showValidationMessage(`Error: ${err.message}`);
                });
            }
        });
    }


    function editUser(id, name, email, reviewsCount, createdAt) {
        Swal.fire({
            title: 'Editar Usuario',
            html: `
                <div style="display: flex; flex-direction: column; gap: 1rem; text-align: left;">
                    <div>
                        <label style="font-weight: 600; font-size: 0.9rem;">Nombre</label>
                        <input id="swal-name" class="swal2-input" placeholder="Nombre completo" value="${name}">
                    </div>

                    <div>
                        <label style="font-weight: 600; font-size: 0.9rem;">Email</label>
                        <input id="swal-email" type="email" class="swal2-input" placeholder="Correo electrónico" value="${email}">
                    </div>

                    <div>
                        <label style="font-weight: 600; font-size: 0.9rem;">Número de reseñas</label>
                        <input id="swal-reviews" class="swal2-input" value="${reviewsCount}" disabled>
                    </div>

                    <div>
                        <label style="font-weight: 600; font-size: 0.9rem;">Fecha de alta</label>
                        <input id="swal-created" class="swal2-input" value="${createdAt}" disabled>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Guardar cambios',
            cancelButtonText: 'Cancelar',
            focusConfirm: false,
            customClass: {
                popup: 'text-left'
            },
            preConfirm: () => {
                const newName = document.getElementById('swal-name').value.trim();
                const newEmail = document.getElementById('swal-email').value.trim();

                if (!newName || !newEmail) {
                    Swal.showValidationMessage('Nombre y email no pueden estar vacíos');
                    return false;
                }

                return fetch(`/admin/users/edit/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: newName,
                        email: newEmail
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('No se pudo actualizar el usuario');
                    return response.json();
                })
                .then(() => {
                    Swal.fire('Actualizado', 'El usuario ha sido modificado correctamente.', 'success')
                        .then(() => location.reload());
                })
                .catch(err => {
                    Swal.showValidationMessage(`Error: ${err.message}`);
                });
            }
        });
    }
</script>
