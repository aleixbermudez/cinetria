<div class="w-full flex flex-col items-center">
    <div class="w-full mt-10">
        <input type="text" id="buscador" placeholder="Buscar..." class="border p-2 rounded w-full">
        <div id="resultados" class="mt-4 bg-whiterounded p-4"></div>
    </div>
</div>
<script>
// Buscador
var buscador = document.querySelector('#buscador');
buscador.addEventListener('keyup', buscarApi);

function buscarApi(e) {
    let query = buscador.value.trim();
    let resultados = document.querySelector('#resultados');
    resultados.style.display = 'block';
    
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
            res.results.forEach(resultado => {
                if(resultado.media_type == 'movie') {
                    resultado.media_type = 'Película';
                } else if(resultado.media_type == 'tv') {
                    resultado.media_type = 'Serie';
                } else if(resultado.media_type == 'person') {
                    resultado.media_type = 'Persona';
                }

                html += `
                    <div class="resultado">
                        <a href="#">
                        <img src="https://image.tmdb.org/t/p/w500${resultado.poster_path || resultado.profile_path}" class="imagen-resultado" alt="No disponible">
                            <div class="info">
                                <h5 class="titulo-resultado">${resultado.title || resultado.name}</h5>
                                <p class="info-resultado">${resultado.media_type}</p>
                            </div>
                        </a>
                    </div>
                `;
            });
            resultados.innerHTML = html;
        })
        .catch(err => console.error(err));
}
</script>