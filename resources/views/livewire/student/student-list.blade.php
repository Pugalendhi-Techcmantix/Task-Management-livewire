<div class="container mt-5">
        <x-mary-card shadow class="shadow-xl p-11">

                <div class="flex items-center justify-between">
                        <x-mary-input icon="o-magnifying-glass" placeholder="Search" wire:model.live="search"
                                class="w-96 focus:outline-none" />
                        <x-mary-button label="Add" wire:click="addForm" icon="o-plus" spinner />
                </div>
                <div class="container mt-4">
                        <x-mary-table striped :headers="$headers" :rows="$students" :sort-by="$sortBy"
                                with-pagination
                                per-page="perPage"
                                :per-page-values="[2,3,5]">

                                @if($students->count() > 0)
                                @foreach($students as $student)
                                @scope('cell_id',$num)
                                <x-mary-badge :value="$num->id" class="badge-info " />
                                @endscope
                                @scope('cell_actions', $student)
                                <div class="flex gap-3">
                                        <x-mary-button wire:click="editStudent({{ $student->id }})"
                                                class="btn-circle btn-ghost btn-sm text-primary"
                                                icon="o-pencil"
                                                spinner />
                                        <x-mary-button
                                                wire:click="openDeleteModal({{ $student->id }})=true"
                                                class="btn-circle btn-ghost btn-sm text-error"
                                                icon="o-trash"
                                                spinner />
                                </div>
                                @endscope
                                @endforeach
                                @else
                                <tr>
                                        <td colspan="{{ count($headers) }}" class="text-center py-4">No data available</td>
                                </tr>
                                @endif
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