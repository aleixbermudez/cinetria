<div class="w-full flex flex-col items-center">
    <div class="w-full max-w-[600px] mt-10">
        <div class="relative">
            <input 
                type="text" 
                id="buscador" 
                placeholder="Buscar..." 
                class="border border-gray-300 p-4 pl-12 rounded-full w-full shadow-lg focus:outline-none focus:ring-4 focus:ring-amber-400 focus:border-amber-400 transition-all duration-300 ease-in-out !important"
            >
        </div>
    </div>
</div>
<script>
// Buscador
var buscador = document.querySelector('#buscador');
var resultadosDiv = document.querySelector('#resultados');

buscador.addEventListener('keyup', buscarApi);

function buscarApi(e) {
    let query = buscador.value.trim();
    resultadosDiv.style.display = query ? 'block' : 'none';

    if (query) {
        const options = {
            method: 'GET',
            headers: {
                accept: 'application/json',
                Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4OGEzMjE5MTAxNTZiZWFlZWY1MzBlYzNhMmQxNTg5MSIsIm5iZiI6MTczODMxNjcyMS4yNjgsInN1YiI6IjY3OWM5YmIxODIyZTdkMzJmN2JkZTg2MiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.TnYuqSvLds-SafDDSVYFrCieAvhOqtG0kstT95IPt1s'
            }
        };

        fetch('https://api.themoviedb.org/3/search/multi?query='+query+'&include_adult=false&language=es-ES&page=1', options)
            .then(res => res.json())
            .then(res => {
                console.log(res);
                let html = '';
                var tipoResultado = '';
                res.results.slice(0, 10).forEach(resultado => {
                    if(resultado.media_type == 'movie') {
                        tipoResultado = 'peliculas';
                    } else if(resultado.media_type == 'tv') {
                        tipoResultado = 'series';
                    } else if(resultado.media_type == 'person') {
                        tipoResultado = 'personas';
                    }

                    html += `

                        <div class="resultado hover:bg-gray-100 cursor-pointer p-2">
                            <a href="/${tipoResultado}/${resultado.id}" class="flex items-center">
                                <img src="https://image.tmdb.org/t/p/w92${resultado.poster_path || resultado.profile_path}" class="imagen-resultado w-12 h-auto rounded mr-2" alt="No disponible">
                                <div class="info">
                                    <h5 class="titulo-resultado text-sm font-semibold">${resultado.title || resultado.name}</h5>
                                </div>
                            </a>
                        </div>
                    `;
                });
                resultadosDiv.innerHTML = html;
            })
            .catch(err => console.error(err));
    } else {
        resultadosDiv.innerHTML = '';
    }
}
</script>