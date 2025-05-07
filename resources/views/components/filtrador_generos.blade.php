<div class="container w-5/6 mx-auto mt-10 flex flex-row md:flex-row gap-6">
    <!-- Barra lateral de géneros -->
    <div class="w-1/4 md:w-1/4 bg-gradient-to-br from-gray-100 to-gray-200 p-6 rounded-xl shadow-lg transform transition-all duration-500 hover:scale-105 hover:shadow-2xl">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Filtrar por Género</h2>
        <h3 class="text-base mb-4 text-gray-600">Selecciona los géneros que deseas ver:</h3>
        <div id="genres-container" class="flex flex-col space-y-4">
            @foreach ($generos['genres'] as $genero)
                <div class="flex items-center space-x-3 group">
                    <input type="checkbox" value="{{ $genero['id'] }}" id="genre-{{ $genero['id'] }}" class="genre-checkbox w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 transition-transform duration-300 group-hover:scale-110">
                    <label for="genre-{{ $genero['id'] }}" class="text-base font-medium text-gray-700 transition-colors duration-300 group-hover:text-blue-600">{{ $genero['name'] }}</label>
                </div>
            @endforeach
{{-- Componente Filtrador de Géneros para Películas o Series usando Tailwind CSS --}}
<div class="flex flex-col md:flex-row justify-center">
    {{-- Sidebar para géneros --}}
    <div class="filtrador-generos w-full md:w-64 bg-white rounded-lg shadow p-4 sticky top-4 self-start">
        <h3 class="text-lg font-semibold mb-3 text-gray-800">Filtrar por géneros</h3>
        
        <div class="generos-container flex flex-wrap gap-1" id="generos-container">
            {{-- Los géneros se cargarán aquí dinámicamente --}}
            <div class="col-span-2 py-4 text-center text-gray-600">Cargando géneros...</div>
        </div>
        
        <div class="mt-4 flex">
            <button id="limpiar-filtros" class="bg-gray-200 hover:bg-gray-300 transition-colors duration-200 text-gray-700 py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                Limpiar todos los filtros
            </button>
        </div>
    </div>

    {{-- Contenedor de resultados --}}
    <div id="resultados-container" class="mt-4 md:mt-0 md:ml-4 md:flex-1">
        {{-- Aquí se cargarán los resultados mediante AJAX --}}
        <div class="text-center py-8 bg-gray-50 rounded-lg">
            <p class="text-lg text-gray-500">Selecciona al menos un género para ver resultados</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración de la API
    const options = {
            method: 'GET',
            headers: {
                accept: 'application/json',
                Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4OGEzMjE5MTAxNTZiZWFlZWY1MzBlYzNhMmQxNTg5MSIsIm5iZiI6MTczODMxNjcyMS4yNjgsInN1YiI6IjY3OWM5YmIxODIyZTdkMzJmN2JkZTg2MiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.TnYuqSvLds-SafDDSVYFrCieAvhOqtG0kstT95IPt1s'
            }
        };
    
    // Determinar el tipo de contenido y configurar la URL
    const tipo = '{{ $tipo }}'; // 'peliculas' o 'series'
    let tipo_api = tipo === 'peliculas' ? 'movie' : 'tv';
    let idioma = tipo === 'peliculas' ? 'en' : 'es';
    
    const url = `https://api.themoviedb.org/3/genre/${tipo_api}/list?language=${idioma}`;
    
    // Elementos del DOM
    const generosContainer = document.getElementById('generos-container');
    const btnLimpiar = document.getElementById('limpiar-filtros');
    const resultadosContainer = document.getElementById('resultados-container');
    
    // Variables para almacenar los géneros seleccionados y el mapeo de ID a nombre
    let generosSeleccionados = [];
    let generosMap = {}; // Para mapear IDs a nombres y viceversa
    
    // Parsear parámetros de URL actuales
    const urlParams = new URLSearchParams(window.location.search);
    const generosUrl = urlParams.get('generos');
    
    // Función para cargar géneros desde la API
    function cargarGeneros() {
        fetch(url, options)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error en la respuesta: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.genres && data.genres.length > 0) {
                    generosContainer.innerHTML = ''; // Limpiar el contenedor
                    
                    // Crear el mapeo de géneros
                    data.genres.forEach(genero => {
                        generosMap[genero.id] = genero.name;
                    });
                    
                    // Si hay géneros en la URL, procesar los nombres
                    if (generosUrl) {
                        const nombreGeneros = generosUrl.split(',');
                        // Convertir nombres a IDs
                        generosSeleccionados = nombreGeneros.map(nombre => {
                            for (const [id, name] of Object.entries(generosMap)) {
                                if (name.toLowerCase() === nombre.toLowerCase()) {
                                    return id;
                                }
                            }
                            return null;
                        }).filter(id => id !== null);
                    }
                    
                    // Crear elementos para cada género
                    data.genres.forEach(genero => {
                        const generoElement = document.createElement('div');
                        generoElement.className = 'genero-item border border-gray-200 rounded-md p-1 cursor-pointer hover:bg-gray-50 transition-colors duration-200 text-xs';
                        generoElement.dataset.id = genero.id;
                        generoElement.dataset.nombre = genero.name;
                        generoElement.textContent = genero.name;
                        
                        // Marcar géneros seleccionados previamente
                        if (generosSeleccionados.includes(genero.id.toString())) {
                            generoElement.classList.add('bg-yellow-200', 'border-yellow-500', 'font-medium');
                        }
                        
                        // Manejar el clic en los géneros
                        generoElement.addEventListener('click', function() {
                            this.classList.toggle('bg-yellow-200');
                            this.classList.toggle('border-yellow-500');
                            this.classList.toggle('font-medium');
                            
                            const generoId = this.dataset.id;
                            const generoNombre = this.dataset.nombre;
                            
                            if (this.classList.contains('bg-yellow-200')) {
                                // Añadir a seleccionados si no está ya
                                if (!generosSeleccionados.includes(generoId)) {
                                    generosSeleccionados.push(generoId);
                                }
                            } else {
                                // Eliminar de seleccionados
                                generosSeleccionados = generosSeleccionados.filter(id => id !== generoId);
                            }
                            
                            // Actualizar URL sin recargar la página
                            actualizarURL();
                            
                            // Cargar resultados filtrados automáticamente si hay géneros seleccionados
                            if (generosSeleccionados.length > 0) {
                                cargarResultados();
                            } else {
                                // Mostrar mensaje para seleccionar géneros
                                resultadosContainer.innerHTML = '<div class="text-center py-8 bg-gray-50 rounded-lg"><p class="text-lg text-gray-500">Selecciona al menos un género para ver resultados</p></div>';
                            }
                        });
                        
                        generosContainer.appendChild(generoElement);
                    });
                    
                    // Cargar resultados iniciales solo si hay géneros seleccionados
                    if (generosSeleccionados.length > 0) {
                        cargarResultados();
                    }
                } else {
                    generosContainer.innerHTML = '<div class="col-span-2 text-center py-4 text-gray-500">No se encontraron géneros disponibles.</div>';
                }
            })
            .catch(error => {
                console.error('Error al cargar los géneros:', error);
                generosContainer.innerHTML = '<div class="col-span-2 text-center py-4 text-red-500">Error al cargar los géneros: ' + error.message + '</div>';
            });
    }
    
    // Función para actualizar la URL sin recargar la página
    function actualizarURL() {
        const urlActual = new URL(window.location.href);
        const params = new URLSearchParams(urlActual.search);
        
        // Actualizar parámetro de géneros con nombres en lugar de IDs
        if (generosSeleccionados.length > 0) {
            // Convertir IDs a nombres
            const nombreGeneros = generosSeleccionados.map(id => generosMap[id]);
            params.set('generos', nombreGeneros.join(','));
        } else {
            params.delete('generos');
        }
        
        // Actualizar URL usando History API
        const nuevaURL = urlActual.pathname + (params.toString() ? '?' + params.toString() : '');
        window.history.pushState({ path: nuevaURL }, '', nuevaURL);
    }
    
    // Función para cargar resultados mediante AJAX
    function cargarResultados() {
        resultadosContainer.innerHTML = '<div class="text-center py-6"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div><p class="mt-2">Cargando resultados...</p></div>';
        
        // Construir URL para búsqueda de películas/series
        let searchApiUrl;
        if (tipo === 'peliculas') {
            searchApiUrl = 'https://api.themoviedb.org/3/discover/movie?include_adult=false&include_video=false&language=es&sort_by=popularity.desc';
        } else {
            searchApiUrl = 'https://api.themoviedb.org/3/discover/tv?include_adult=false&language=es&sort_by=popularity.desc';
        }
        
        // Añadir filtro de géneros si hay seleccionados
        if (generosSeleccionados.length > 0) {
            searchApiUrl += `&with_genres=${generosSeleccionados.join(',')}`;
        } else {
            // Si no hay géneros seleccionados, mostrar mensaje y salir
            resultadosContainer.innerHTML = '<div class="text-center py-8 bg-gray-50 rounded-lg"><p class="text-lg text-gray-500">Selecciona al menos un género para ver resultados</p></div>';
            return;
        }
        
        // Añadir parámetro de página
        const urlParams = new URLSearchParams(window.location.search);
        const pagina = urlParams.get('page') || 1;
        searchApiUrl += `&page=${pagina}`;
        
        // Realizar solicitud a la API
        fetch(searchApiUrl, options)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error en la respuesta: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data.results || data.results.length === 0) {
                    resultadosContainer.innerHTML = '<div class="text-center py-8 bg-gray-50 rounded-lg"><p class="text-lg text-gray-600">No se encontraron resultados para los filtros seleccionados.</p></div>';
                    return;
                }
                
                // Procesar y mostrar resultados
                mostrarResultados(data);
            })
            .catch(error => {
                console.error('Error al cargar resultados:', error);
                resultadosContainer.innerHTML = '<div class="text-center py-8 bg-red-50 rounded-lg"><p class="text-lg text-red-600">Error al cargar los resultados: ' + error.message + '</p></div>';
            });
    }
    
    // Función para mostrar los resultados en la página
    function mostrarResultados(data) {
        let html = '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">';
        
        data.results.forEach(item => {
            const titulo = tipo === 'peliculas' ? item.title : item.name;
            const fecha = tipo === 'peliculas' ? item.release_date : item.first_air_date;
            const posterPath = item.poster_path ? `https://image.tmdb.org/t/p/w300${item.poster_path}` : '/img/no-poster.jpg';
            
            html += `
            <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow group relative">
                <a href="/${tipo}/${item.id}">
                <img src="${posterPath}" alt="${titulo}" class="w-2/5 h-auto object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                    <div class="p-3 text-white">
                        <h3 class="font-semibold text-base">${titulo}</h3>
                        <p class="text-sm opacity-80">${fecha ? new Date(fecha).getFullYear() : 'Año desconocido'}</p>
                    </div>
                </div>
                </a>
            </div>`;
        });
        
        html += '</div>';
        
        // Añadir paginación
        html += crearPaginacion(data.page, data.total_pages);
        
        resultadosContainer.innerHTML = html;
        
        // Añadir event listeners a los botones de paginación
        document.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const pagina = this.dataset.page;
                cambiarPagina(pagina);
            });
        });
    }
    
    // Función para crear la paginación
    function crearPaginacion(paginaActual, totalPaginas) {
        if (totalPaginas <= 1) return '';
        
        let html = '<div class="flex justify-center mt-6 space-x-1">';
        
        // Botón anterior
        if (paginaActual > 1) {
            html += `<button class="pagination-btn px-3 py-1 rounded bg-gray-200 hover:bg-gray-300" data-page="${paginaActual - 1}">Anterior</button>`;
        }
        
        // Mostrar páginas
        const maxPaginas = 5;
        let inicio = Math.max(1, paginaActual - Math.floor(maxPaginas / 2));
        let fin = Math.min(totalPaginas, inicio + maxPaginas - 1);
        
        if (fin - inicio + 1 < maxPaginas) {
            inicio = Math.max(1, fin - maxPaginas + 1);
        }
        
        for (let i = inicio; i <= fin; i++) {
            if (i === parseInt(paginaActual)) {
                html += `<button class="px-3 py-1 rounded bg-blue-500 text-white" disabled>${i}</button>`;
            } else {
                html += `<button class="pagination-btn px-3 py-1 rounded bg-gray-200 hover:bg-gray-300" data-page="${i}">${i}</button>`;
            }
        }
        
        // Botón siguiente
        if (paginaActual < totalPaginas) {
            html += `<button class="pagination-btn px-3 py-1 rounded bg-gray-200 hover:bg-gray-300" data-page="${paginaActual + 1}">Siguiente</button>`;
        }
        
        html += '</div>';
        return html;
    }
    
    // Función para cambiar de página
    function cambiarPagina(pagina) {
        const urlActual = new URL(window.location.href);
        const params = new URLSearchParams(urlActual.search);
        
        params.set('page', pagina);
        
        // Actualizar URL
        const nuevaURL = urlActual.pathname + '?' + params.toString();
        window.history.pushState({ path: nuevaURL }, '', nuevaURL);
        
        // Cargar resultados de la nueva página
        cargarResultados();
        
        // Scroll hacia arriba
        window.scrollTo({
            top: resultadosContainer.offsetTop - 20,
            behavior: 'smooth'
        });
    }
    
    // Manejar el botón limpiar
    btnLimpiar.addEventListener('click', function() {
        // Limpiar selecciones visuales
        document.querySelectorAll('.genero-item.bg-yellow-200').forEach(item => {
            item.classList.remove('bg-yellow-200', 'border-yellow-500', 'font-medium');
        });
        
        // Limpiar array de seleccionados
        generosSeleccionados = [];
        
        // Actualizar URL
        actualizarURL();
        
        // Mostrar mensaje para seleccionar géneros
        resultadosContainer.innerHTML = '<div class="text-center py-8 bg-gray-50 rounded-lg"><p class="text-lg text-gray-500">Selecciona al menos un género para ver resultados</p></div>';
    });
    
    // Iniciar la carga de géneros
    cargarGeneros();
});
</script>