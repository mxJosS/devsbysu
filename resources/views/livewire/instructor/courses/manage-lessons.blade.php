<div class="mt-2">
    <div x-data="{
        open: @entangle('lessonCreate.open'),
        platform: @entangle('lessonCreate.platform')
    }">

        <div>
            <button
                x-on:click="open = !open"
                class="group flex items-center px-3 py-2 text-xs font-bold text-indigo-600 uppercase tracking-wider transition-all duration-200 rounded-md hover:bg-indigo-50 active:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                <svg class="w-4 h-4 mr-2 transform transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Añadir Lección
            </button>
        </div>

        <form x-show="open"
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="opacity-0 transform -translate-y-2"
              x-transition:enter-end="opacity-100 transform translate-y-0"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100 transform translate-y-0"
              x-transition:leave-end="opacity-0 transform -translate-y-2"
              wire:submit="store"
              x-cloak
              class="mt-4 bg-white border border-gray-100 rounded-lg shadow-sm">

            <div class="p-4 sm:p-6">
                <div class="mb-4">
                    <x-input class="w-full" wire:model="lessonCreate.name" label="Nombre de la lección" placeholder="Ingrese el nombre de la lección" />
                    <x-input-error for="lessonCreate.name" />
                </div>

                <div>
                    <x-label class="mb-2 font-medium text-gray-700">
                        Plataformas
                    </x-label>

                    <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-6 md:items-center">

                        <div class="flex items-center space-x-4">
                            <button type="button"
                                    x-on:click="platform = 1"
                                    :class="platform == 1 ? 'border-indigo-500 bg-indigo-50 text-indigo-600 ring-1 ring-indigo-500' : 'border-gray-200 text-gray-500 hover:border-indigo-300 hover:bg-gray-50'"
                                    class="flex flex-col items-center justify-center w-20 h-20 sm:w-24 sm:h-24 transition-all duration-200 border-2 rounded-lg focus:outline-none">
                                <i class="text-2xl sm:text-3xl fas fa-video"></i>
                                <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-semibold">Video</span>
                            </button>

                            <button type="button"
                                    x-on:click="platform = 2"
                                    :class="platform == 2 ? 'border-red-500 bg-red-50 text-red-600 ring-1 ring-red-500' : 'border-gray-200 text-gray-500 hover:border-red-300 hover:bg-gray-50'"
                                    class="flex flex-col items-center justify-center w-20 h-20 sm:w-24 sm:h-24 transition-all duration-200 border-2 rounded-lg focus:outline-none">
                                <i class="text-2xl sm:text-3xl fab fa-youtube"></i>
                                <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-semibold">YouTube</span>
                            </button>
                        </div>

                        <p class="text-sm text-gray-500 leading-relaxed md:w-1/2">
                            Primero debes elegir una plataforma para subir tu contenido.
                        </p>
                    </div>

                    <div class="mt-4" x-show="platform == 1" x-cloak>
                        <x-label>Video</x-label>
                        <x-progress-indicators wire:model="video" />
                        <x-input-error for="video" class="mt-2" />
                    </div>

                    <div class="mt-4" x-show="platform == 2">
                        <x-input wire:model="url" class="w-full" placeholder="Ingresa la URL del video en YouTube" x-cloak />
                    </div>

                    <x-input-error for="lessonCreate.platform" class="mt-2" />
                </div>

                <div class="flex flex-col-reverse sm:flex-row sm:justify-end mt-6 gap-3 sm:space-x-3 sm:gap-0">
                    <x-danger-button type="button" x-on:click="open = false" >
                        Cancelar
                    </x-danger-button>
                    <x-button type="submit" >
                        Guardar
                    </x-button>
                </div>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('swal', event => {
            const data = event.detail[0] || event.detail;

            Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.icon
            });
        });
    </script>
</div>
