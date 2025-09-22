<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject;
    public string $content;
    public string $unsubscribeUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $content)
    {
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     */
    public function build(): NewsletterMail
    {
        return $this->subject($this->subject)
            ->view('emails.newsletter')
            ->with([
                'content' => $this->content,
            ]);
    }
}
