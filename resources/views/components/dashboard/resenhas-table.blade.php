<!-- Tabla de Reseñas -->
<div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-neutral-700">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
        <thead class="bg-gray-50 dark:bg-neutral-800">
            <tr>
                <th class="ps-6 py-3"></th>
                <th class="ps-6 py-3 text-start text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Reseña de</th>
                <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Valoración</th>
                <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Tipo de contenido</th>
                <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Fecha de la reseña</th>
                <th class="px-6 py-3 text-end"></th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
            @foreach ($resenhas as $resenha)
                <tr>
                    <td class="ps-6 py-3">
                        <input type="checkbox" class="border-gray-300 rounded-sm text-blue-600 dark:bg-neutral-800 dark:border-neutral-600">
                    </td>
                    <td class="ps-6 py-3">
                        <div>
                            <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $resenha->usuario->name }}</span>
                            <span class="block text-sm text-gray-500 dark:text-neutral-500">{{ $resenha->usuario->email }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-3 text-sm font-semibold text-gray-800 dark:text-neutral-200">
                        {{ $resenha->valoracion }}
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-500 dark:text-neutral-500">
                        {{ $resenha->tipo_contenido }}
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-500 dark:text-neutral-500">
                        {{ $resenha->created_at->format('d M, H:i') }}
                    </td>
                    <td class="px-6 py-3 text-end">
                        <a href="#"
                           onclick="editResenha(
                               {{ $resenha->id }},
                               '{{ e($resenha->usuario->name) }}',
                               '{{ e($resenha->usuario->email) }}',
                               '{{ e($resenha->valoracion) }}',
                               '{{ e($resenha->opinion_texto) }}',
                               '{{ e($resenha->tipo_contenido) }}',
                               '{{ $resenha->created_at->format('Y-m-d H:i:s') }}'
                           )"
                           class="text-sm text-blue-600 hover:underline font-medium dark:text-blue-500">Editar
                        </a>
                        <a href="#" 
                            onclick="deleteResenha({{ $resenha->id }})"
                            class="text-sm ml-4 text-red-600 hover:underline font-medium dark:text-red-500">Eliminar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="bg-gray-50 dark:bg-neutral-800 px-6 py-4 text-sm text-gray-700 dark:text-neutral-300 border-t border-gray-200 dark:border-neutral-700">
        Total de reseñas: <span class="font-semibold">{{ count($resenhas) }}</span>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function deleteResenha(id) {
        Swal.fire({
            title: '¿Seguro que quieres eliminar esta reseña?',
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
                return fetch(`/admin/resenhas/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('No se pudo eliminar la reseña');
                    return response.json();
                })
                .then(() => {
                    Swal.fire('Eliminada', 'La reseña ha sido eliminada correctamente.', 'success')
                        .then(() => location.reload());
                })
                .catch(err => {
                    Swal.showValidationMessage(`Error: ${err.message}`);
                });
            }
        });
    }

    function editResenha(id, name, email, valoracion, opinionTexto, tipoContenido, createdAt) {
        Swal.fire({
            title: 'Editar Reseña',
            html: `
                <div style="display: flex; flex-direction: column; gap: 1rem; text-align: left;">
                    <div>
                        <label style="font-weight: 600; font-size: 0.9rem;">Nombre del autor</label>
                        <input id="swal-name" class="swal2-input" value="${name}" disabled>
                    </div>

                    <div>
                        <label style="font-weight: 600; font-size: 0.9rem;">Email del autor</label>
                        <input id="swal-email" type="email" class="swal2-input" value="${email}" disabled>
                    </div>

                    <div>
                        <label style="font-weight: 600; font-size: 0.9rem;">Valoración</label>
                        <input id="swal-valoracion" class="swal2-input" value="${valoracion}">
                    </div>

                    <div>
                        <label style="font-weight: 600; font-size: 0.9rem;">Texto de la opinión</label>
                        <textarea id="swal-opinion" class="swal2-textarea">${opinionTexto}</textarea>
                    </div>

                    <div>
                        <label style="font-weight: 600; font-size: 0.9rem;">Tipo de contenido</label>
                        <input id="swal-tipo" class="swal2-input" value="${tipoContenido}">
                    </div>

                    <div>
                        <label style="font-weight: 600; font-size: 0.9rem;">Fecha de la reseña</label>
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
                const newValoracion = document.getElementById('swal-valoracion').value.trim();
                const newOpinionTexto = document.getElementById('swal-opinion').value.trim();
                const newTipoContenido = document.getElementById('swal-tipo').value.trim();

                if (!newValoracion || !newOpinionTexto || !newTipoContenido) {
                    Swal.showValidationMessage('Todos los campos deben estar completos');
                    return false;
                }

                return fetch(`/admin/resenhas/edit/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        valoracion: newValoracion,
                        opinion_texto: newOpinionTexto,
                        tipo_contenido: newTipoContenido
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('No se pudo actualizar la reseña');
                    return response.json();
                })
                .then(() => {
                    Swal.fire('Actualizada', 'La reseña ha sido modificada correctamente.', 'success')
                        .then(() => location.reload());
                })
                .catch(err => {
                    Swal.showValidationMessage(`Error: ${err.message}`);
                });
            }
        });
    }
</script>
