<?php

namespace App\Livewire\Role;

use App\Models\Roles;
use LivewireUI\Modal\ModalComponent;

class RoleModal extends ModalComponent
{

    public RoleForm $form;

    public function mount($role_id = null)
    {
        if (!is_null($role_id)) {
            $role = Roles::findOrFail($role_id);
            $this->form->setValue($role);
        }
    }
    protected function rules()
    {
        return $this->form->rules();
    }

    public function cancel()
    {
        return $this->closeModal();
    }

    public function save()
    {
        // Example save logic (you can modify according to your needs)
        $this->form->save();
        $this->dispatch('refresh-role-table');
        return $this->closeModal();
    }
    public function render()
    {
        return view('livewire.role.role-modal');
    }
}
