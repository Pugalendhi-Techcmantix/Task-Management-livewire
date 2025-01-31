<?php

namespace App\Console\Commands;

use App\Mail\ReminderMailDaily;
use App\Models\Tasks;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';
    protected $description = 'Send reminder emails to users';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    // public function handle()
    // {
    //     $users = User::where('email', true)->get(); // Example condition

    //     foreach ($users as $user) {
    //         Mail::raw("Hello {$user->name}, this is your reminder!", function ($message) use ($user) {
    //             $message->to($user->email)->subject('Reminder Notification');
    //         });
    //     }

    //     $this->info('Reminder emails sent successfully.');
    // }


    public function handle()
    {
        // Fetch tasks due today
        $tasks = Tasks::whereDate('due_date', Carbon::today())->with('employee')->get();

        foreach ($tasks as $task) {
            if ($task->employee && $task->employee->email) {  // Corrected to use `employee`
                // Send email
                Mail::to($task->employee->email)->send(new ReminderMailDaily($task->employee->name, $task));

                $this->info("Reminder email sent to: {$task->employee->email}");
            }
        }

        $this->info('Reminder emails process completed.');
    }
}
