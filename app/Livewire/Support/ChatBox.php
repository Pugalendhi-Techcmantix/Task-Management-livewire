<?php

namespace App\Livewire\Support;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatBox extends Component
{
    public $messages;
    public $newMessage;
    public $users;
    public function sendMessage()
    {
        // Trim message to remove extra spaces
        $trimmedMessage = trim($this->newMessage);

        // Check if the message is empty
        if (empty($trimmedMessage)) {
            // Show a toast or alert using Livewire's emit
            session()->flash('error', 'Message cannot be empty');
            return;
        }

        // Save the message to the database
        Chat::create([
            'user_id' => Auth::id(),
            'message' => $trimmedMessage,
        ]);

        $this->newMessage = ''; // Reset input after sending
    }


    public function mount()
    {
        $this->chatget();  // Fetch initial messages when component mounts.
        $this->users();
    }

    public function users()
    {
        $this->users = User::get();
        return $this->users;
    }

    public function chatget()
    {
        // Fetch messages in ascending order (oldest first)
        $this->messages = Chat::orderBy('created_at', 'asc')->get();
    }


    public function render()
    {
        // $this->messages = Chat::latest()->get();
        return view('livewire.support.chat-box');
    }
}
