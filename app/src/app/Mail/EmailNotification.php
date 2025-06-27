<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct($type, $content)
    {
        //
        $this->type = $type;
        $this->content = $content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {


        $subject = '';
        switch ($this->type) {
            case 'NEW':
                $subject = '[SDTI-Ticket #' . $this->content->ticket->id . '] ' . $this->content->ticket->subject;
                break;

            case 'MESSAGE':
                $subject = '[SDTI-Ticket #' . $this->content->ticket->id . '] RE:' . $this->content->ticket->subject;
                break;

            case 'CHANGE_STATUS':
                $subject = '[SDTI-Ticket #' . $this->content->ticket->id . '] RE:' . $this->content->ticket->subject;
                break;

            default:
                $subject = '[SDTI-ADMIN]';
                break;
        }
        
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $template = '';
        switch ($this->type) {
            case 'NEW':
                $template = 'emails.new';
                break;

            case 'MESSAGE':
                $template = 'emails.message';
                break;

            case 'CHANGE_STATUS':
                $template = 'emails.change_status';
                break;

            default:
                $template = 'emails.admin';
                break;
        }

        return new Content(view: $template,);
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
