<div>
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
        },
        initSortable() {
            new Sortable(this.$refs.sortableList, {
                animation: 150,
                handle: '.drag-handle', // Solo arrastra desde el icono
                draggable: '.sortable-item', // Solo arrastra los li de secciones
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                onEnd: (evt) => {
                    let sortedIds = Array.from(evt.to.children)
                        .filter(el => el.classList.contains('sortable-item'))
                        .map(el => el.getAttribute('data-id'));

                    $wire.updateSortOrder(sortedIds);
                }
            });
        }
    }" class="max-w-4xl mx-auto py-8 px-4" x-init="initSortable()">

        {{-- Cabecera con el <hr> --}}
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Secciones del Curso</h2>
            <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                {{ count($sections) }} {{ count($sections) === 1 ? 'Sección' : 'Secciones' }}
            </span>
        </div>
        <hr class="border-gray-200 mb-6">

        {{-- Lista de secciones --}}
        <ul x-ref="sortableList" class="mb-4">

            {{-- 1. Insertar al inicio --}}
            <li x-data="{ open: false }" class="relative py-1 ignore-sort">
                <div @click="open = !open"
                    class="group flex justify-center items-center cursor-pointer transition-all h-4">
                    <div class="h-[2px] w-full bg-transparent group-hover:bg-indigo-300 absolute transition-colors duration-300"></div>
                    <button class="z-10 bg-white border border-indigo-300 text-indigo-500 rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110 shadow-sm">
                        <i class="fas fa-plus text-[10px]"></i>
                    </button>
                </div>

                <div x-show="open" x-collapse x-cloak @click.away="open = false" class="mt-2 mb-4 bg-indigo-50 p-5 rounded-lg border border-indigo-100">
                    <x-input wire:model="name" class="w-full" placeholder="Nombre de la primera sección..." />
                    <div class="flex justify-end mt-3 space-x-3">
                        <x-danger-button type="button" @click="open = false">Cancelar</x-danger-button>
                        <x-button wire:click="store(1)" @click="open = false">Agregar al inicio</x-button>
                    </div>
                </div>
            </li>

            {{-- Bucle de Secciones --}}
            @forelse ($sections as $section)
                <li wire:key="section-{{ $section->id }}" data-id="{{ $section->id }}" class="sortable-item">

                    {{-- Tarjeta Blanca Estilizada --}}
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-6 py-4">
                        @if ($sectionEdit['id'] == $section->id)
                            {{-- Modo Edición --}}
                            <form wire:submit.prevent="update">
                                <div class="flex items-center space-x-3">
                                    <x-label class="whitespace-nowrap font-bold text-indigo-600">Sección {{ $loop->iteration }}</x-label>
                                    <x-input wire:model="sectionEdit.name" class="flex-1" />
                                </div>
                                <div class="flex justify-end mt-4 space-x-2">
                                    <x-button>Actualizar</x-button>
                                    <x-danger-button type="button" wire:click="$set('sectionEdit.id', null)">
                                        Cancelar
                                    </x-danger-button>
                                </div>
                            </form>
                        @else
                            {{-- Modo Vista --}}
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1">
                                    <i class="fas fa-grip-vertical text-gray-300 hover:text-indigo-500 cursor-grab active:cursor-grabbing mr-4 text-lg drag-handle"></i>
                                    <h1 class="flex-1 truncate text-base">
                                        <span class="font-bold text-indigo-600 mr-1">Sección {{ $loop->iteration }}:</span>
                                        <span class="font-medium text-gray-700">{{ $section->name }}</span>
                                    </h1>
                                </div>

                                <div class="flex items-center space-x-3 ml-4">
                                    <button wire:click="edit({{ $section->id }})" title="Editar sección" class="text-gray-400 hover:text-indigo-600 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button x-on:click="destroySection({{ $section->id }})" title="Eliminar sección" class="text-gray-400 hover:text-red-500 transition-colors">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Insertar en medio --}}
                    <div x-data="{ open: false }" class="relative py-2 ignore-sort">
                        <div @click="open = !open"
                            class="group flex justify-center items-center cursor-pointer transition-all h-4">
                            <div class="h-[2px] w-full bg-transparent group-hover:bg-indigo-300 absolute transition-colors duration-300"></div>
                            <button class="z-10 bg-white border border-indigo-300 text-indigo-500 rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110 shadow-sm">
                                <i class="fas fa-plus text-[10px]"></i>
                            </button>
                        </div>

                        <div x-show="open" x-collapse x-cloak @click.away="open = false" class="mt-2 mb-2 bg-indigo-50 p-5 rounded-lg border border-indigo-100">
                            <x-input wire:model="name" class="w-full" placeholder="Nombre de la nueva sección..." />
                            <div class="flex justify-end mt-3 space-x-3">
                                <x-danger-button type="button" @click="open = false">Cancelar</x-danger-button>
                                <x-button wire:click="store({{ $loop->iteration + 1 }})" @click="open = false">Agregar</x-button>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="bg-gray-50 rounded-lg px-6 py-10 text-center border-2 border-dashed border-gray-300 ignore-sort">
                    <div class="text-gray-400 mb-2">
                        <i class="fas fa-folder-open text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Aún no hay secciones</h3>
                    <p class="mt-1 text-sm text-gray-500">Comienza a estructurar tu curso agregando la primera sección usando el botón de arriba.</p>
                </li>
            @endforelse
        </ul>

    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.7/Sortable.min.js"></script>
    @endpush

    <style>
        [x-cloak] { display: none !important; }

        .sortable-ghost {
            opacity: 0.4;
            border: 2px dashed #818cf8 !important;
            background-color: #f3f4f6 !important;
        }
        .sortable-chosen {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            border-color: #818cf8 !important;
        }
    </style>
</div>
