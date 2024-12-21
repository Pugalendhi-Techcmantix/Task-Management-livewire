<?php

namespace App\Livewire\Status;

use App\Models\Status;
use Livewire\Form;


class StatusForm extends Form
{
    public ?Status $status;
    public ?int $status_id = null;
    public  $name = null;


    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:status,name,' . $this->status_id,
        ];
    }

    public function setValue(Status $status)
    {
        $this->status = $status;
        $this->status_id = $status->id;
        $this->fill([
            'name' => $status->name,
        ]);
    }

    public function create()
    {
        Status::create([
            'name' => $this->name,
        ]);
    }
    public function update()
    {
        $this->status->update([
            'name' => $this->name,
        ]);
    }
    public function updating()
    {
        return !empty($this->status);
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
        return view('livewire.status.status-form');
    }
}
