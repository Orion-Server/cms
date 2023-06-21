<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <div class="flex justify-end gap-2 mt-3">
            <x-filament::button color="warning">Search</x-filament::button>
            <x-filament::button type="submit">Create</x-filament::button>
        </div>
    </form>
</x-filament::page>
