<?php

namespace App\Livewire\Role;

use App\Models\Roles;
use Livewire\Component;

class RoleList extends Component
{

    public $search = '', $name, $role_id, $confirmDelete = false;
    public int $perPage = 5; // Number of items per page
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];
    protected $listeners = ['refresh-role-table' => '$refresh'];


    public function openDeleteModal($role_id)
    {
        $this->confirmDelete = true;    // Trigger modal visibility
        $this->role_id = $role_id; // Assign the employee ID to delete
    }

    public function destroy()
    {
        Roles::findOrfail($this->role_id)->delete();
        $this->confirmDelete = false;
        $this->dispatch('refresh-role-table');
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
        $rolelist = Roles::query()
            ->where('id', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->orderBy(...array_values($this->sortBy))
            ->get(); // Fetch data as a collection
        return view(
            'livewire.role.role-list',
            [
                'headers' => $headers,
                'rolelist' => $rolelist,
            ]
        );
    }
}
