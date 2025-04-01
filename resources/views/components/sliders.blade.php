<h3 class="text-center">POPULARES</h3>
<div class="slider-contenido flex justify-center items-center py-6">
    <table class="table-auto border-collapse border border-gray-300 shadow-lg">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">Imagen</th>
                <th class="border border-gray-300 px-4 py-2">Título</th>
                <th class="border border-gray-300 px-4 py-2">Valoración</th>
                <th class="border border-gray-300 px-4 py-2">ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach($populares["results"] as $popular)
                <tr class="hover:bg-gray-100">
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <img src="https://image.tmdb.org/t/p/w200{{$popular['poster_path']}}" 
                             alt="{{$popular['title'] ?? $popular['name']}}" 
                             class="w-16 h-auto mx-auto">
                    </td>
                    <td class="border border-gray-300 px-4 py-2">{{$popular['title'] ?? $popular['name']}}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">{{$popular['vote_average']}}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">{{$popular['id']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<h3 class="text-center">MEJORES</h3>
<div class="slider-contenido flex justify-center items-center py-6">

    <table class="table-auto border-collapse border border-gray-300 shadow-lg">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">Imagen</th>
                <th class="border border-gray-300 px-4 py-2">Título</th>
                <th class="border border-gray-300 px-4 py-2">Valoración</th>
                <th class="border border-gray-300 px-4 py-2">ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mejores["results"] as $mejor)
                <tr class="hover:bg-gray-100">
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <img src="https://image.tmdb.org/t/p/w200{{$mejor['poster_path']}}" 
                             alt="{{$mejor['title'] ?? $mejor['name']}}" 
                             class="w-16 h-auto mx-auto">
                    </td>
                    <td class="border border-gray-300 px-4 py-2">{{$mejor['title'] ?? $mejor['name']}}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">{{$mejor['vote_average']}}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">{{$mejor['id']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

