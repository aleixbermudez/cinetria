<div class="container w-5/6 mx-auto mt-10 flex flex-row md:flex-row gap-6">
    <!-- Barra lateral de géneros -->
    <div class="w-1/4 md:w-1/4 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Filtrar por Género</h2>
        <h3 class="text-sm mb-2">Selecciona los géneros que deseas ver:</h3>
        <div id="genres-container" class="flex flex-col space-y-2">
            @foreach ($generos['genres'] as $genero)
                <div class="flex items-center space-x-2">
                    <input type="checkbox" value="{{ $genero['id'] }}" id="genre-{{ $genero['id'] }}" class="genre-checkbox">
                    <label for="genre-{{ $genero['id'] }}" class="text-sm">{{ $genero['name'] }}</label>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Resultados -->
    <div id="resultados-filtrado" class="w-3/4 md:w-3/4 bg-gray-800 text-white p-4 rounded-lg shadow-md min-h-[200px]">
        <p>Aquí se mostrarán los resultados filtrados...</p>
        <button id="loadMore" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Cargar Más
        </button>
    </div>

</div>
