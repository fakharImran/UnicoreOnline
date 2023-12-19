<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;


    public $ticket, $user;
    /**
     * Create a new message instance.
     */
    public function __construct(Ticket $ticket ,User $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;

        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket Submission Confirmation - '.$this->ticket->ticket_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // dd($this->user->companyUser->company->company_name);

        return new Content(
            markdown: 'emails.tickets',
            with:[
                'ticket' => $this->ticket,
                'user' => $this->user,
                'ticket_url' => URL::route('tickets.show', $this->ticket)
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
