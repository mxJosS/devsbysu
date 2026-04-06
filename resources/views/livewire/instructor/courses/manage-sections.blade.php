<div x-data="{
    destroySection(sectionId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $wire.destroy(sectionId);
            }
        });
    }
}" class="max-w-4xl mx-auto">

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Secciones del Curso</h2>
        <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
            {{ count($sections) }} {{ count($sections) === 1 ? 'Sección' : 'Secciones' }}
        </span>
    </div>
    <hr class="border-gray-200 mb-6">

    <ul class="mb-4">
        {{-- 1. Insertar al inicio (Posición 1) --}}
        <li x-data="{ open: false }" class="relative py-1">
            <div @click="open = !open"
                 class="group flex justify-center items-center cursor-pointer transition-all h-4">
                <div class="h-[2px] w-full bg-transparent group-hover:bg-indigo-300 absolute transition-colors duration-300"></div>
                <button class="z-10 bg-white border border-indigo-300 text-indigo-500 rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110 hover:bg-indigo-50 shadow-sm">
                    <i class="fas fa-plus text-[10px]"></i>
                </button>
            </div>

            <div x-show="open" x-collapse x-cloak @click.away="open = false" class="mt-2 mb-4 bg-indigo-50/50 p-5 rounded-xl border border-indigo-100 shadow-inner">
                <x-input wire:model="name" class="w-full border-indigo-200 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Nombre de la primera sección..." />
                <div class="flex justify-end mt-3 space-x-3">
                    <button type="button" @click="open = false" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancelar</button>
                    <x-button wire:click="store(1)" @click="open = false" class="bg-indigo-600 hover:bg-indigo-700">Agregar al inicio</x-button>
                </div>
            </div>
        </li>

        {{-- Bucle de Secciones --}}
        @forelse ($sections as $section)
            <li wire:key="section-{{ $section->id }}">

                {{-- Tarjeta de la Sección --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-6 py-5 hover:shadow-md transition-shadow duration-300">
                    @if ($sectionEdit['id'] == $section->id)
                        {{-- Modo Edición --}}
                        <form wire:submit.prevent="update">
                            <div class="flex items-center space-x-3">
                                <span class="text-sm font-bold text-indigo-600 whitespace-nowrap bg-indigo-50 px-3 py-2 rounded-lg">Sección {{ $loop->iteration }}</span>
                                <x-input wire:model="sectionEdit.name" class="flex-1 focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                            <div class="flex justify-end mt-4 space-x-3">
                                <button type="button" wire:click="$set('sectionEdit.id', null)" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancelar</button>
                                <x-button class="bg-indigo-600 hover:bg-indigo-700">Guardar cambios</x-button>
                            </div>
                        </form>
                    @else
                        {{-- Modo Vista --}}
                        <div class="flex items-center justify-between">
                            <h1 class="flex-1 truncate text-lg">
                                <span class="font-bold text-indigo-600 mr-2">Sección {{ $loop->iteration }}:</span>
                                <span class="font-medium text-gray-700">{{ $section->name }}</span>
                            </h1>
                            <div class="flex items-center space-x-2 ml-4">
                                <button wire:click="edit({{ $section->id }})" title="Editar sección" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button x-on:click="destroySection({{ $section->id }})" title="Eliminar sección" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Insertar en medio --}}
                <div x-data="{ open: false }" class="relative py-2">
                    <div @click="open = !open"
                         class="group flex justify-center items-center cursor-pointer transition-all h-4">
                        <div class="h-[2px] w-full bg-transparent group-hover:bg-indigo-300 absolute transition-colors duration-300"></div>
                        <button class="z-10 bg-white border border-indigo-300 text-indigo-500 rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110 hover:bg-indigo-50 shadow-sm">
                            <i class="fas fa-plus text-[10px]"></i>
                        </button>
                    </div>

                    <div x-show="open" x-collapse x-cloak @click.away="open = false" class="mt-2 mb-2 bg-indigo-50/50 p-5 rounded-xl border border-indigo-100 shadow-inner">
                        <x-input wire:model="name" class="w-full border-indigo-200 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Nombre de la nueva sección..." />
                        <div class="flex justify-end mt-3 space-x-3">
                            <button type="button" @click="open = false" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancelar</button>
                            <x-button wire:click="store({{ $loop->iteration + 1 }})" @click="open = false" class="bg-indigo-600 hover:bg-indigo-700">Insertar aquí</x-button>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="bg-gray-50 rounded-xl px-6 py-10 text-center border-2 border-dashed border-gray-300">
                <div class="text-gray-400 mb-2">
                    <i class="fas fa-folder-open text-4xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Aún no hay secciones</h3>
                <p class="mt-1 text-sm text-gray-500">Comienza a estructurar tu curso agregando la primera sección abajo.</p>
            </li>
        @endforelse
    </ul>



</div>
