<div class="container mt-5">
    <x-mary-card shadow class="shadow-xl p-11">
        <div class="flex items-center justify-between">
            <x-mary-input icon="o-magnifying-glass" placeholder="Search" wire:model.live="search"
                class="w-[450px] focus:outline-none" />
            <x-mary-button label="Add" wire:click="$dispatch('openModal', { component: 'employee.employee-modal' })"
                icon="o-plus" spinner />
        </div>
        <div class="container mt-4">
            <x-mary-table striped :headers="$headers" :rows="$employees" :sort-by="$sortBy" show-empty-text with-pagination
                per-page="perPage" :per-page-values="[2, 3, 5]">
                @foreach ($employees as $employee)
                    @scope('cell_id', $num)
                        <x-mary-badge :value="$num->id" class="badge-info " />
                    @endscope
                    @scope('cell_status', $st)
                        <x-mary-badge :value="$st->statusLabel['status']" :class="$st->status === 1 ? 'bg-green-500 text-white' : 'bg-red-500 text-white'" />
                    @endscope
                    @scope('cell_actions', $employee)
                        <div class="flex gap-3">
                            <x-mary-button
                                wire:click="$dispatch('openModal', { component: 'employee.employee-modal', arguments: { employee_id: '{{ $employee->id }}' }})"
                                class=" btn-circle btn-ghost btn-sm text-primary" icon="o-pencil" spinner />
                            <x-mary-button wire:click="openDeleteModal({{ $employee->id }})=true"
                                class="btn-circle btn-ghost btn-sm text-error" icon="o-trash" spinner />
                        </div>
                    @endscope
                @endforeach
            </x-mary-table>
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
