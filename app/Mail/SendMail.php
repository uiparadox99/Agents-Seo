<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       $address = 'noreply@agents.com.pk';
       $subject = 'Confirm you account';
       $name = 'Agents PK';

       return $this->view('emails.register-email-template')
       ->from($address, $name)
       ->replyTo($address, $name)
       ->subject($subject)
       ->with([
        'name' => $this->data['name'],
        'email' => $this->data['email'],
        'token' => $this->data['token'],
      ]);
   }
}
