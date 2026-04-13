<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-0">
    <div class="flex items-start sm:items-center flex-1 min-w-0"> <i class="mt-1 sm:mt-0 fas fa-grip-vertical text-gray-300 hover:text-indigo-500 cursor-grab active:cursor-grabbing mr-3 text-lg drag-handle"></i>
        <h1 class="flex-1 text-sm sm:text-base flex flex-col sm:flex-row sm:truncate">
            <span class="font-bold text-indigo-600 sm:mr-1">Sección {{ $loop->iteration }}:</span>
            <span class="font-medium text-gray-700 truncate" title="{{ $section->name }}">{{ $section->name }}</span>
        </h1>
    </div>

    <div class="flex items-center justify-end space-x-4 pl-7 sm:pl-4">
        <button wire:click="edit({{ $section->id }})" title="Editar sección" class="text-gray-400 hover:text-indigo-600 transition-colors">
            <i class="fas fa-edit"></i>
        </button>
        <button x-on:click="destroySection({{ $section->id }})" title="Eliminar sección" class="text-gray-400 hover:text-red-500 transition-colors">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</div>
