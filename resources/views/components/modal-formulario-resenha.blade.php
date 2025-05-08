<div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-yellow-100 rounded-lg shadow-lg p-6 w-full max-w-md">
        <div class="text-center mb-4">
            <!-- Imagen -->
            <img src="#" alt="Imagen de la película" class="mx-auto w-24 h-24 object-cover rounded-full">
            <!-- Nombre de la película -->
            <h2 class="text-xl font-bold text-yellow-800 mt-2">Nombre de la Película</h2>
        </div>
        <form>
            <!-- Opinión -->
            <div class="mb-4">
                <label for="opinion" class="block text-yellow-800 font-medium mb-2">Tu Opinión</label>
                <textarea id="opinion" name="opinion" rows="4" class="w-full p-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
            </div>
            <!-- Puntuación -->
            <div class="mb-4">
                <label for="puntuacion" class="block text-yellow-800 font-medium mb-2">Puntuación</label>
                <input type="range" id="puntuacion" name="puntuacion" min="0" max="10" class="w-full">
                <div class="text-yellow-800 text-sm text-center mt-1">0 - 10</div>
            </div>
            <!-- Favoritos -->
            <div class="mb-4 flex items-center">
                <input type="checkbox" id="favoritos" name="favoritos" class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-yellow-300 rounded">
                <label for="favoritos" class="ml-2 text-yellow-800">Añadir a Favoritos</label>
            </div>
            <!-- Botón de enviar -->
            <div class="text-center">
                <button type="submit" class="bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    Enviar
                </button>
            </div>
        </form>
    </div>
</div>