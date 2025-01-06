<?php

namespace App\Livewire\Support;

use App\Models\Support;
use Carbon\Carbon;
use Livewire\Component;

class SupportList extends Component
{
    public $priorityFilter = null;
    public $messages = [];
    public $overAllMsg = 0;
    public $todayMsgCount = 0;
 
    public function mount()
    {
        $this->fetchMessages();
    }

    public function fetchMessages()
    {
        $this->messages = Support::when($this->priorityFilter, function ($query, $priority) {
            $query->where('priority', $priority);
        })->get();

        $this->overAllMsg = Support::count();
        $this->todayMsgCount = Support::whereDate('created_at', Carbon::today())->count();
    }

    public function todayMsg()
    {
        $this->messages = Support::whereDate('created_at', Carbon::today())->get();
    }

    public function filterByPriority($priority)
    {
        $this->priorityFilter = $priority;

        $this->messages = Support::when($priority, function ($query, $priority) {
            $query->where('priority', $priority);
        })->get();
    }

    public function render()
    {
        return view(
            'livewire.support.support-list',
            ['messages' => $this->messages, 'overAllMsg' => $this->overAllMsg, 'todayMsgCount' => $this->todayMsgCount]
        );
    }
}
