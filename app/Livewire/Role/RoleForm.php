<?php

namespace App\Livewire\Role;

use App\Models\Roles;
use Livewire\Form;


class RoleForm extends Form
{
    public ?Roles $role;
    public ?int $role_id = null;
    public  $name = null;


    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $this->role_id,
        ];
    }

    public function setValue(Roles $role)
    {
        $this->role = $role;
        $this->role_id = $role->id;
        $this->fill([
            'name' => $role->name,
        ]);
    }

    public function create()
    {
        Roles::create([
            'name' => $this->name,
        ]);
    }
    public function update()
    {
        $this->role->update([
            'name' => $this->name,
        ]);
    }
    public function updating()
    {
        return !empty($this->role);
    }

    public function save()
    {
        $this->validate();

        if ($this->updating()) {
            $this->update();
        } else {
            $this->create();
        }
    }
    public function render()
    {
        return view('livewire.role.role-form');
    }
}
