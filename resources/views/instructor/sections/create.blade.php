<div x-data="{ open: false }" class="relative py-1 ignore-sort">
    <div @click="open = !open"
        class="group flex justify-center items-center cursor-pointer transition-all h-4">
        <div class="h-[2px] w-full bg-transparent group-hover:bg-indigo-300 absolute transition-colors duration-300"></div>
        <button class="z-10 bg-white border border-indigo-300 text-indigo-500 rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110 shadow-sm">
            <i class="fas fa-plus text-[10px]"></i>
        </button>
    </div>

    <div x-show="open" x-collapse x-cloak @click.away="open = false" class="mt-2 mb-4 bg-indigo-50 p-5 rounded-lg border border-indigo-100">
        <x-input wire:model="name" class="w-full" placeholder="Nombre de la sección..." />
        <div class="flex justify-end mt-3 space-x-3">
            <x-danger-button type="button" @click="open = false">Cancelar</x-danger-button>
            <x-button wire:click="store({{ $position }})" @click="open = false">Agregar</x-button>
        </div>
    </div>
</div>
