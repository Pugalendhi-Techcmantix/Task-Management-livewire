<?php

namespace App\Mail;

use App\Models\Tasks;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderMailDaily extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $task;

    public function __construct($userName, Tasks $task)
    {
        $this->userName = $userName;
        $this->task = $task;
    }


    // public function build()
    // {
    //     return $this->subject('Task Reminder')
    //                 ->view('mail.reminder')
    //                 ->with(['messageContent' => $this->messageContent]);
    // }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Task Reminder: ' . $this->task->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.auto-reminder',
            with: [
                'userName' => $this->userName,
                'task' => $this->task
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
