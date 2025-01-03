<?php

namespace App\Livewire\Support;

use App\Models\Support;
use Carbon\Carbon;
use Livewire\Component;

class SupportList extends Component
{
    public $priorityFilter = null;

    public function filterByPriority($priority)
    {
        $this->priorityFilter = $priority;
    }
    public function render()
    {

        // // Fetch all support messages
        // $messages = Support::all();

        $messages = Support::when($this->priorityFilter, function ($query, $priority) {
            $query->where('priority', $priority);
        })->get();

        $overAllMsg = Support::count();
        $todayMsg = Support::whereDate('created_at', Carbon::today())->count();


        return view(
            'livewire.support.support-list',
            ['messages' => $messages, 'overAllMsg' => $overAllMsg, 'todayMsg' => $todayMsg]
        );
    }
}
