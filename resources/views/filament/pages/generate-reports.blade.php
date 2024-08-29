<x-filament::page>
    <form wire:submit.prevent="generateReport">
        {{ $this->form }}

        <div class="mt-4">
            <x-filament::button type="submit">
                Generar Informe
            </x-filament::button>
        </div>
    </form>
</x-filament::page>
