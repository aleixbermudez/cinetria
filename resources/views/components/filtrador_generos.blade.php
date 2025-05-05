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
