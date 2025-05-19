<div wire:loading.class="opacity-50">
    {{ $this->table }}

    {{-- Custom loading indicator visible when table actions are loading --}}
    <div wire:loading wire:loading.class="flex" wire:target="tableFilters,gotoPage,previousPage,nextPage,sortTable">
        <x-filament::loading-indicator class="h-5 w-5" />
        Loading table data...
    </div>
</div>