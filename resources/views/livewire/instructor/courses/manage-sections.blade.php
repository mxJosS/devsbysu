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
                handle: '.drag-handle',
                draggable: '.sortable-item',
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
    }" class="max-w-4xl mx-auto py-8 px-4" x-init="$nextTick(() => initSortable())">


        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Secciones del Curso</h2>
            <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                {{ count($sections) }} {{ count($sections) === 1 ? 'Sección' : 'Secciones' }}
            </span>
        </div>
        <hr class="border-gray-200 mb-6">

        <ul x-ref="sortableList" class="mb-4">

            @include('instructor.sections.create', ['position' => 1])

            @forelse ($sections as $section)
                <li wire:key="section-{{ $section->id }}" data-id="{{ $section->id }}" class="sortable-item">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-6 py-4">
                        @if ($sectionEdit['id'] == $section->id)
                            @include('instructor.sections.edit')
                        @else
                            @include('instructor.sections.show')
                        @endif
                    </div>

                    @include('instructor.sections.create', ['position' => $loop->iteration + 1])
                </li>
            @empty
                <li class="bg-gray-50 rounded-lg px-6 py-10 text-center border-2 border-dashed border-gray-300 ignore-sort">
                    <div class="text-gray-400 mb-2">
                        <i class="fas fa-folder-open text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Aún no hay secciones</h3>
                </li>
            @endforelse
        </ul>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.7/Sortable.min.js"></script>
    @endpush

    <style>
        [x-cloak] { display: none !important; }
        .sortable-ghost { opacity: 0.4; border: 2px dashed #818cf8 !important; background-color: #f3f4f6 !important; }
        .sortable-chosen { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important; border-color: #818cf8 !important; }
    </style>
</div>
