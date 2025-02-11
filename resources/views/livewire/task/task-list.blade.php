<div class="container ">
    <x-mary-card shadow class="shadow-xl p-11" title="Assign Task">
        <x-slot:menu>
            <x-mary-dropdown>
                <x-mary-menu-item title="Add" icon="o-plus"
                    wire:click="$dispatch('openModal', { component: 'task.task-modal' })" spinner />
                <x-mary-menu-item title="Import" icon="o-arrow-small-up" wire:click="importOpen" spinner />
                <x-mary-menu-item title="Download" icon="o-arrow-down-tray" wire:click="export" spinner />
                <x-mary-menu-item title="Delete All" icon="o-trash" wire:click="deleteAllMessages" spinner />
            </x-mary-dropdown>

        </x-slot:menu>

        <x-mary-input icon="o-magnifying-glass" placeholder="Search" wire:model.live="search"
            class="focus:outline-none" />

        <div class="mt-4">
            <x-mary-table striped :headers="$headers" :rows="$tasks" :sort-by="$sortBy" show-empty-text with-pagination
                per-page="perPage" :per-page-values="[2, 5, 10]">
                @foreach ($tasks as $task)
                    @scope('cell_id', $num)
                        <x-mary-badge :value="$num->id" class="badge-info " />
                    @endscope
                    @scope('cell_status', $st)
                        <x-mary-badge :value="$st->statusLabel['status']" :class="match ($st->status) {
                            1 => 'bg-yellow-500 ',
                            2 => 'bg-blue-500 text-white',
                            3 => 'bg-red-500 text-white',
                            4 => 'bg-green-500 text-white',
                            default => 'bg-gray-500 text-white',
                        }" />
                    @endscope
                    @scope('cell_actions', $task)
                        <div class="flex gap-3">
                            <x-mary-button
                                wire:click="$dispatch('openModal', { component: 'task.task-modal', arguments: { task_id: '{{ $task->id }}' }})"
                                class=" btn-circle btn-ghost btn-sm text-primary" icon="o-pencil" spinner />
                            <x-mary-button wire:click="openDeleteModal({{ $task->id }})=true"
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

    <x-mary-modal wire:model="confirmOpen" title="Upload Your File?">
        <x-mary-file wire:model="file" label="Upload the Task Excel File:" hint="Only xlsx, xls, csv"
            accept=".xlsx, .xls, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, text/csv" />
        @if (!empty($importErrors))
            <div class="max-h-60 overflow-auto"> <!-- Adjusted max height and scroll behavior -->
                @foreach ($importErrors as $error)
                    <x-mary-alert class="alert-warning mb-2" title="Validation Error"
                        description="{{ html_entity_decode($error) }}" />
                @endforeach
            </div>
        @endif
        <x-slot:actions>
            <x-mary-button label="Cancel" wire:click="confirmOpen = false" />
            <x-mary-button label="Upload" wire:click="import" class="btn-primary" spinner />
        </x-slot>
    </x-mary-modal>
</div>
