<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\Project;


class ProjectPublished extends Mailable
{
    use Queueable, SerializesModels;

    // dichiaro le variabili di istanza per la mail
    public $project;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Project $project)
    {
        // questo mi rende disponibile la variabile in tutta la mail
        $this->project = $project;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Project Published',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $project = $this->project;

        return new Content(
            // bisogna creare mail.published tra le viste delle mail
            view: 'mail.published',
            // with: [
            //     'project' => $project,
            // ],
            with: compact('project'),
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