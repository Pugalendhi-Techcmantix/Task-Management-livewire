<div class="container mt-5">
    <x-mary-card shadow class="shadow-xl p-11">
        <div class="flex items-center justify-between">
            <x-mary-input icon="o-magnifying-glass" placeholder="Search" wire:model.live="search"
                class="w-[450px] focus:outline-none" />
            <x-mary-button label="Add" wire:click="$dispatch('openModal', { component: 'task.task-modal' })"
                icon="o-plus" spinner />
        </div>
        <div class="container mt-4">
            
        </div>
    </x-mary-card>


    <x-mary-modal wire:model="confirmDelete" title="Are you sure?">
        <div>Click 'Confirm' to permanently delete.</div>
        <x-slot:actions>
            <x-mary-button label="{{ __('Cancel') }}" wire:click="confirmDelete = false" spinner />
            <x-mary-button label="{{ __('Confirm') }}" wire:click="destroy" class="btn-primary" spinner />
        </x-slot>
    </x-mary-modal>
</div>
