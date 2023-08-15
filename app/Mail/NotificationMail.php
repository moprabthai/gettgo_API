<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $employee;
    public $requestno;
    public $requeststatus;
    public $comment;
    public function __construct($params)
    {
        $this->employee = $params['assignTo'];
        $this->requestno = $params['requestno'];
        $this->requeststatus = $params['requeststatus'];
        $this->comment=$params['comment'];

    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'แจ้งเตือนจาก Gettgo Overtime System',
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
            view: 'mail.notification',
            with: [
                'employee' => $this->employee,
                'requestno' =>  $this->requestno,
                'requeststatus'=>$this->requeststatus,
                'comment'=>$this->comment
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
