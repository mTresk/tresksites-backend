<x-filament::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="flex mt-6">
            <x-filament::actions :actions="$this->getFormActions()" />
        </div>
    </form>
</x-filament::page>