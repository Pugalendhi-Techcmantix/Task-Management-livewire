<?php

namespace App\Livewire\Status;

use App\Models\Status;
use Livewire\Component;

class StatusList extends Component
{

    public $search = '', $name, $status_id, $confirmDelete = false;
    public int $perPage = 5; // Number of items per page
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];
    protected $listeners = ['refresh-status-table' => '$refresh'];


    public function openDeleteModal($status_id)
    {
        $this->confirmDelete = true;    // Trigger modal visibility
        $this->status_id = $status_id; // Assign the employee ID to delete
    }

    public function destroy()
    {
        Status::findOrfail($this->status_id)->delete();
        $this->confirmDelete = false;
        $this->dispatch('refresh-status-table');
    }

    public function render()
    {
        $headers = [
            ['key' => 'id', 'label' => 'S.No', 'sortable' => true,],
            ['key' => 'name', 'label' => 'Name', 'sortable' => true],
            ['key' => 'created_at', 'label' => 'Created At', 'sortable' => true],
            ['key' => 'updated_at', 'label' => 'Updated At', 'sortable' => true],
            ['key' => 'actions', 'label' => 'Action', 'sortable' => false],
        ];
        // Fetch students with sorting
        $statuslist = Status::query()
            ->orderBy(...array_values($this->sortBy))
            ->get(); // Fetch data as a collection
        return view(
            'livewire.status.status-list',
            [
                'headers' => $headers,
                'statuslist' => $statuslist,
            ]
        );
    }
}
