<!-- Hero Cine -->
<section class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('https://image.tmdb.org/t/p/original/8YFL5QQVPy3AgrEQxNYVSgiPEbe.jpg');">
  <div class="absolute inset-0 bg-black bg-opacity-60"></div>

  <div class="relative z-10 flex flex-col items-center justify-center text-center text-white py-24 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight mb-4">
      Descubre tus películas y series favoritas
    </h1>
    <p class="text-lg sm:text-xl max-w-2xl mb-8 text-neutral-200">
      Busca entre miles de títulos, actores y series de televisión. Actualizado con los últimos estrenos.
    </p>

    <!-- Buscador -->
    <form class="w-full max-w-xl relative" autocomplete="off">
      <div class="flex items-center gap-2 bg-white/90 dark:bg-neutral-900 rounded-lg shadow-lg p-2 backdrop-blur">
        <input
          id="buscador"
          type="text"
          placeholder="Buscar película, serie o persona..."
          class="flex-grow px-4 py-2 text-sm rounded-lg bg-transparent text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-neutral-400 focus:outline-none"
        />

      </div>

      <!-- Resultados -->
      <div id="resultados"
        class="absolute z-20 w-full mt-2 bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-lg shadow-lg hidden max-h-[400px] overflow-y-auto">
        <!-- JS inyecta aquí -->
      </div>
    </form>
  </div>
</section>

<!-- Script de búsqueda -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const buscador = document.querySelector('#buscador');
    buscador.addEventListener("keydown", function(event) {
      console.log(event.key);
      if (event.key == "Enter" || event.keyCode == 13) {
        event.preventDefault(); // Evita la recarga de la página al presionar Enter
      }
    });

    const resultadosDiv = document.querySelector('#resultados');
    buscador.addEventListener('keyup', function () {
      const query = buscador.value.trim();

      if (!query) {
        resultadosDiv.style.display = 'none';
        resultadosDiv.innerHTML = '';
        return;
      }

      resultadosDiv.style.display = 'block';

      fetch(`https://api.themoviedb.org/3/search/multi?query=${encodeURIComponent(query)}&include_adult=false&language=es-ES&page=1`, {
        method: 'GET',
        headers: {
          accept: 'application/json',
          Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4OGEzMjE5MTAxNTZiZWFlZWY1MzBlYzNhMmQxNTg5MSIsIm5iZiI6MTczODMxNjcyMS4yNjgsInN1YiI6IjY3OWM5YmIxODIyZTdkMzJmN2JkZTg2MiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.TnYuqSvLds-SafDDSVYFrCieAvhOqtG0kstT95IPt1s'
        }
      })
        .then(response => response.json())
        .then(data => {
          let html = '';

          data.results.slice(0, 10).forEach(item => {
            let tipo = item.media_type === 'movie' ? 'peliculas'
              : item.media_type === 'tv' ? 'series'
                : 'personas';

            let imagen = item.poster_path || item.profile_path;
            let nombre = item.title || item.name;

            html += `
              <div class="hover:bg-gray-100 dark:hover:bg-neutral-700 cursor-pointer p-2">
                <a href="/${tipo}/detalles/${item.id}" class="flex items-center gap-3">
                    <img src="${imagen ? `https://image.tmdb.org/t/p/w92${imagen}` : '/images/portada_404.png'}" class="w-12 h-auto rounded shadow-sm" alt="${nombre}">
                  <span class="text-sm font-medium text-gray-800 dark:text-white">${nombre}</span>
                </a>
              </div>
            `;
          });

          resultadosDiv.innerHTML = html;
        })
        .catch(error => {
          console.error('Error al buscar:', error);
          resultadosDiv.innerHTML = '<p class="p-4 text-red-500">Error al cargar resultados</p>';
        });
    });
  });
</script>
