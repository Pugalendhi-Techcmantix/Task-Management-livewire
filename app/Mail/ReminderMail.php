<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;
    public $userName;
    public $taskDetails;

    /**
     * Create a new message instance.
     */
    public function __construct($userName, array $taskDetails)
    {
        //

        $this->userName = $userName;
        $this->taskDetails = $taskDetails;
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
            subject: 'Task Reminder',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.reminder',
            with: [
                'userName' => $this->userName,
                'taskDetails' => $this->taskDetails,
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
