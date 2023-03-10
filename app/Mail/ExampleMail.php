<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExampleMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    # está esperando um objeto da model User. Os dados de $user poderão ser acessados na view 'example'. 
    public function __construct(private User $user)
    {
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        $email = "wendersongds@gmail.com";

        return new Envelope(
            from: new Address($email, 'wenderson'),
            subject: 'email de exemplo',
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
            view: 'emails.users.example',
            with: [
                'user' => $this->user,
                'imageExample' => storage_path('app/image-test.png')
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
        return [
            Attachment::fromPath(storage_path('app/certificado.pdf'))
                ->as('certificado-wenderson.pdf')
                ->withMime('application/pdf')
        ];
    }
}
