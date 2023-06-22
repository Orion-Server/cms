<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <div class="flex justify-end gap-2 mt-3">
            <x-filament::button
                icon="{{ $this->getButtonIcon() }}"
                color="{{ $this->getButtonColor() }}"
                type="submit"
            >
                {{ $this->getButtonLabel() }}
            </x-filament::button>
        </div>
    </form>
</x-filament::page>
