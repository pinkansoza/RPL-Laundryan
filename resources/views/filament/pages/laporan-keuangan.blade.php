<x-filament-panels::page>
    {{-- Tambahkan baris ini agar form filternya muncul di paling atas --}}
    <form wire:submit.prevent="submitFiltersForm">
        {{ $this->filtersForm }}
    </form>

</x-filament-panels::page>