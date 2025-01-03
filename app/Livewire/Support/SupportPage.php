<?php

namespace App\Livewire\Support;

use App\Models\Support;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class SupportPage extends Component
{
    use Toast;
    public $subject, $message, $category, $priority;

    public $priorityOptions = [
        [
            'id' => 1,
            'name' => 'Low',
        ],
        [
            'id' => 2,
            'name' => 'Medium',
        ],
        [
            'id' => 3,
            'name' => 'High',
        ],
    ];
    public $categoryOptions = [
        [
            'id' => 1,
            'name' => 'Bug',
        ],
        [
            'id' => 2,
            'name' => 'Feature Request',
        ],
        [
            'id' => 3,
            'name' => 'General Query',
        ],
    ];
    public function rules()
    {
        return [
            'subject' => 'required|string|max:255',
            'category' => 'required',
            'message' => 'required',
            'priority' => 'required',
        ];
    }
    public function save()
    {
        $this->validate();
        $user_id = Auth::user()->id;
        Support::create([
            'user_id' => $user_id,
            'subject' => $this->subject,
            'category' => $this->category,
            'message' => $this->message,
            'priority' => $this->priority,
        ]);
        $this->toast(
            type: 'success',
            title: 'Sent!',
            description: "Your query has been sended!",
            position: 'toast-top toast-end',
            icon: 'o-check-circle',
            css: 'alert-info',
            redirectTo: null
        );
        // Clear form fields
        $this->reset(['subject', 'category', 'message', 'priority']);
    }



    public function render()
    {
        return view('livewire.support.support-page');
    }
}
