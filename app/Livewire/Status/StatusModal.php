<?php

namespace App\Livewire\Status;

use App\Models\Status;
use LivewireUI\Modal\ModalComponent;

class StatusModal extends ModalComponent
{

    public StatusForm $form;

    public function mount($status_id = null)
    {
        if (!is_null($status_id)) {
            $status = Status::findOrFail($status_id);
            $this->form->setValue($status);
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
        $this->dispatch('refresh-status-table');
        return $this->closeModal();
    }
    public function render()
    {
        return view('livewire.status.status-modal');
    }
}
