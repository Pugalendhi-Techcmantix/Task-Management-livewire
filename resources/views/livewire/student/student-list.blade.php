<div class="container mt-5 ">
        <x-mary-card shadow class="border border-dashed">


                <div class="d-flex justify-content-between">
                        <x-mary-input icon="o-magnifying-glass" placeholder="Search" wire:model.live="search" style="width: 400px;" />
                        <x-mary-button label="Add" wire:click="addForm" icon="o-plus" spinner />
                </div>
                <div class="container mt-4">
                        @if($students && count($students) > 0)
                        <div class="table-responsive">
                                <table class="table  table-hover">
                                        <thead class="thead-light table-dark">
                                                <tr>
                                                        <th>S.No</th>
                                                        <th>Name</th>
                                                        <th>Roll Number</th>
                                                        <th>Age</th>
                                                        <th>Action</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                                @foreach($students as $student)
                                                <tr>
                                                        <td>{{ $student->id }}</td>
                                                        <td>{{ $student->name }}</td>
                                                        <td>{{ $student->rollno }}</td>
                                                        <td>{{ $student->age }}</td>
                                                        <td>
                                                                <x-mary-button wire:click="editStudent({{ $student->id }})"
                                                                        class="btn-circle btn-ghost btn-sm text-primary"
                                                                        icon="o-pencil"
                                                                        spinner />
                                                                <x-mary-button
                                                                        wire:click="openDeleteModal({{ $student->id }})=true"
                                                                        class="btn-circle btn-ghost btn-sm text-error"
                                                                        icon="o-trash"
                                                                        spinner />

                                                        </td>

                                                </tr>
                                                @endforeach
                                        </tbody>
                                </table>
                        </div>
                        <!-- Pagination -->
                        <div class="mt-4">
                                {{ $students->links() }}
                        </div>

                        @else
                        <p class="text-center mt-4">No data available</p>
                        @endif
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