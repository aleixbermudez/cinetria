<div class="flex flex-col md:flex-row justify-center gap-8 px-4 md:px-0 max-w-7xl mx-auto mt-8">
    <!-- Sidebar de filtros -->
    <aside class="w-full md:w-64 bg-white rounded-2xl shadow-sm p-6 sticky top-4 self-start border border-gray-200">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">Filtrar por géneros</h3>

        <div class="generos-container flex flex-wrap gap-2" id="generos-container">
            <!-- Carga dinámica de géneros -->
            <div class="w-full text-center py-4 text-gray-400 text-sm">Cargando géneros...</div>
        </div>

        <div class="mt-6">
            <button id="limpiar-filtros"
                class="w-full bg-gray-100 hover:bg-gray-200 transition text-gray-700 py-2 px-4 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-gray-300">
                Limpiar filtros
            </button>
        </div>
    </aside>

    <!-- Contenedor de resultados -->
    <section id="resultados-container" class="flex-1">
        <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-gray-200">
            <p class="text-base text-gray-500">Selecciona al menos un género para ver resultados</p>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const options = {
        method: 'GET',
        headers: {
            accept: 'application/json',
            Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4OGEzMjE5MTAxNTZiZWFlZWY1MzBlYzNhMmQxNTg5MSIsIm5iZiI6MTczODMxNjcyMS4yNjgsInN1YiI6IjY3OWM5YmIxODIyZTdkMzJmN2JkZTg2MiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.TnYuqSvLds-SafDDSVYFrCieAvhOqtG0kstT95IPt1s'
        }
    };

    const tipo = '{{ $tipo }}'; // 'peliculas' o 'series'
    let tipo_api = tipo === 'peliculas' ? 'movie' : 'tv';
    let idioma = tipo === 'peliculas' ? 'en' : 'es';

    const url = `https://api.themoviedb.org/3/genre/${tipo_api}/list?language=${idioma}`;

    const generosContainer = document.getElementById('generos-container');
    const btnLimpiar = document.getElementById('limpiar-filtros');
    const resultadosContainer = document.getElementById('resultados-container');

    let generosSeleccionados = [];
    let generosMap = {};

    const urlParams = new URLSearchParams(window.location.search);
    const generosUrl = urlParams.get('generos');

    function cargarGeneros() {
        fetch(url, options)
            .then(response => {
                if (!response.ok) throw new Error(`Error en la respuesta: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.genres?.length > 0) {
                    generosContainer.innerHTML = '';

                    data.genres.forEach(genero => {
                        generosMap[genero.id] = genero.name;
                    });

                    if (generosUrl) {
                        const nombreGeneros = generosUrl.split(',');
                        generosSeleccionados = nombreGeneros.map(nombre => {
                            for (const [id, name] of Object.entries(generosMap)) {
                                if (name.toLowerCase() === nombre.toLowerCase()) return id;
                            }
                            return null;
                        }).filter(id => id !== null);
                    }

                    data.genres.forEach(genero => {
                        const generoElement = document.createElement('div');
                        generoElement.className = 'genero-item border border-gray-200 rounded-md p-1 cursor-pointer hover:bg-gray-50 transition-colors duration-200 text-xs';
                        generoElement.dataset.id = genero.id;
                        generoElement.dataset.nombre = genero.name;
                        generoElement.textContent = genero.name;

                        if (generosSeleccionados.includes(genero.id.toString())) {
                            generoElement.classList.add('bg-yellow-200', 'border-yellow-500', 'font-medium');
                        }

                        generoElement.addEventListener('click', function() {
                            this.classList.toggle('bg-yellow-200');
                            this.classList.toggle('border-yellow-500');
                            this.classList.toggle('font-medium');

                            const generoId = this.dataset.id;
                            if (this.classList.contains('bg-yellow-200')) {
                                if (!generosSeleccionados.includes(generoId)) generosSeleccionados.push(generoId);
                            } else {
                                generosSeleccionados = generosSeleccionados.filter(id => id !== generoId);
                            }

                            actualizarURL();
                            generosSeleccionados.length > 0 ? cargarResultados() : mostrarMensajeSeleccion();
                        });

                        generosContainer.appendChild(generoElement);
                    });

                    if (generosSeleccionados.length > 0) {
                        cargarResultados();
                    }
                } else {
                    generosContainer.innerHTML = '<div class="w-full text-center py-4 text-gray-500">No se encontraron géneros disponibles.</div>';
                }
            })
            .catch(error => {
                console.error('Error al cargar los géneros:', error);
                generosContainer.innerHTML = '<div class="w-full text-center py-4 text-red-500">Error al cargar los géneros: ' + error.message + '</div>';
            });
    }

    function actualizarURL() {
        const urlActual = new URL(window.location.href);
        const params = new URLSearchParams(urlActual.search);

        if (generosSeleccionados.length > 0) {
            const nombreGeneros = generosSeleccionados.map(id => generosMap[id]);
            params.set('generos', nombreGeneros.join(','));
        } else {
            params.delete('generos');
        }

        const nuevaURL = urlActual.pathname + (params.toString() ? '?' + params.toString() : '');
        window.history.pushState({ path: nuevaURL }, '', nuevaURL);
    }

    function cargarResultados() {
        resultadosContainer.innerHTML = `
            <div class="text-center py-6">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div>
                <p class="mt-2">Cargando resultados...</p>
            </div>`;

        let searchApiUrl = tipo === 'peliculas'
            ? 'https://api.themoviedb.org/3/discover/movie?include_adult=false&include_video=false&language=es&sort_by=popularity.desc'
            : 'https://api.themoviedb.org/3/discover/tv?include_adult=false&language=es&sort_by=popularity.desc';

        if (generosSeleccionados.length > 0) {
            searchApiUrl += `&with_genres=${generosSeleccionados.join(',')}`;
        } else {
            mostrarMensajeSeleccion();
            return;
        }

        const pagina = urlParams.get('page') || 1;
        searchApiUrl += `&page=${pagina}`;

        fetch(searchApiUrl, options)
            .then(response => {
                if (!response.ok) throw new Error(`Error en la respuesta: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (!data.results || data.results.length === 0) {
                    resultadosContainer.innerHTML = '<div class="text-center py-8 bg-gray-50 rounded-lg"><p class="text-lg text-gray-600">No se encontraron resultados para los filtros seleccionados.</p></div>';
                    return;
                }
                mostrarResultados(data);
            })
            .catch(error => {
                console.error('Error al cargar resultados:', error);
                resultadosContainer.innerHTML = `<div class="text-center py-8 bg-red-50 rounded-lg"><p class="text-lg text-red-600">Error al cargar los resultados: ${error.message}</p></div>`;
            });
    }

    function mostrarResultados(data) {
        let html = '<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">';

        data.results.forEach(item => {
            const titulo = tipo === 'peliculas' ? item.title : item.name;
            const fecha = tipo === 'peliculas' ? item.release_date : item.first_air_date;
            const posterPath = item.poster_path ? `https://image.tmdb.org/t/p/w500${item.poster_path}` : '/img/no-poster.jpg';

            html += `
            <div class="relative group overflow-hidden rounded-lg shadow hover:shadow-lg transition duration-300">
                <a href="/${tipo}/${item.id}">
                    <img src="${posterPath}" alt="${titulo}" class="w-full h-auto object-cover block transition-transform duration-300 group-hover:scale-105">
                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white text-xs px-2 py-1 text-center truncate">
                        ${titulo} • ${fecha ? new Date(fecha).getFullYear() : 'Año desconocido'}
                    </div>
                </a>
            </div>`;
        });

        html += '</div>';
        html += crearPaginacion(data.page, data.total_pages);
        resultadosContainer.innerHTML = html;

        document.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                cambiarPagina(this.dataset.page);
            });
        });
    }

    function crearPaginacion(paginaActual, totalPaginas) {
        if (totalPaginas <= 1) return '';
        let html = '<div class="flex justify-center mt-6 space-x-1">';

        if (paginaActual > 1) {
            html += `<button class="pagination-btn px-3 py-1 rounded bg-gray-200 hover:bg-gray-300" data-page="${paginaActual - 1}">Anterior</button>`;
        }

        const maxPaginas = 5;
        let inicio = Math.max(1, paginaActual - Math.floor(maxPaginas / 2));
        let fin = Math.min(totalPaginas, inicio + maxPaginas - 1);

        if (fin - inicio + 1 < maxPaginas) {
            inicio = Math.max(1, fin - maxPaginas + 1);
        }

        for (let i = inicio; i <= fin; i++) {
            html += i === parseInt(paginaActual)
                ? `<button class="px-3 py-1 rounded bg-blue-500 text-white" disabled>${i}</button>`
                : `<button class="pagination-btn px-3 py-1 rounded bg-gray-200 hover:bg-gray-300" data-page="${i}">${i}</button>`;
        }

        if (paginaActual < totalPaginas) {
            html += `<button class="pagination-btn px-3 py-1 rounded bg-gray-200 hover:bg-gray-300" data-page="${paginaActual + 1}">Siguiente</button>`;
        }

        html += '</div>';
        return html;
    }

    function cambiarPagina(pagina) {
        const urlActual = new URL(window.location.href);
        const params = new URLSearchParams(urlActual.search);
        params.set('page', pagina);

        const nuevaURL = urlActual.pathname + '?' + params.toString();
        window.history.pushState({ path: nuevaURL }, '', nuevaURL);
        cargarResultados();
        window.scrollTo({ top: resultadosContainer.offsetTop - 20, behavior: 'smooth' });
    }

    function mostrarMensajeSeleccion() {
        resultadosContainer.innerHTML = '<div class="text-center py-8 bg-gray-50 rounded-lg"><p class="text-lg text-gray-500">Selecciona al menos un género para ver resultados</p></div>';
    }

    btnLimpiar.addEventListener('click', function() {
        document.querySelectorAll('.genero-item.bg-yellow-200').forEach(item => {
            item.classList.remove('bg-yellow-200', 'border-yellow-500', 'font-medium');
        });
        generosSeleccionados = [];
        actualizarURL();
        mostrarMensajeSeleccion();
    });

    cargarGeneros();
});
</script>
