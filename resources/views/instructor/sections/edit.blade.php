<form wire:submit.prevent="update" class="mb-6">
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
