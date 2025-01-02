<?php

namespace App\Livewire\Role;

use App\Models\Roles;
use App\Models\User;
use Livewire\Component;
use Mary\Traits\Toast;

class RoleList extends Component
{
    use Toast;
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
        $role = Roles::find($this->role_id);

        if (!$role) {
            $this->toast(
                type: 'error',
                title: 'Role!',
                description: 'Role not found.',
                position: 'toast-top toast-end',
                icon: 'o-exclamation-circle',
                css: 'alert-danger',
                timeout: 5000,
                redirectTo: null
            );
            $this->confirmDelete = false;
            return;
        }
        // Check if any users are associated with this role
        $associatedUsers = User::where('role_id', $this->role_id)->exists();
        if ($associatedUsers) {
            $this->toast(
                type: 'error',
                title: 'Role!',
                description: 'This role is associated with users and cannot be deleted.',
                position: 'toast-top toast-end',
                icon: 'o-exclamation-circle',
                css: 'alert-warning',
                timeout: 5000,
                redirectTo: null
            );
            $this->confirmDelete = false;
            return;
        }

        $role->delete();
        $this->toast(
            type: 'success',
            title: 'Deleted!',
            description: 'Role deleted successfully.',
            position: 'toast-top toast-end',
            icon: 'o-check-circle',
            timeout: 5000,
            css: 'alert-success',
            redirectTo: null
        );
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
