<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $eventname;
    public $teamname;

      /**
     * Create a new message instance.
     *
     * @param array $data The data array containing name and eventname
     * @return void
     */
    public function __construct($data)
    {
        $this->name = $data['name'] ?? '';
        $this->teamname = $data['teamname'] ?? '';
        $this->eventname = $data['eventname'] ?? '';
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Event Confirmation',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.grp',
            with: [
                'name' => $this->name,
                'teamname'=>$this->teamname,
                'eventname' => $this->eventname,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
