<?php

namespace App\Livewire\Task;

use LivewireUI\Modal\ModalComponent;

class TaskModal extends ModalComponent
{

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }
    public function render()
    {
        return view('livewire.task.task-modal');
    }
}
