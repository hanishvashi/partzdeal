<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerOrderEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $order_data;
    public $gs;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_data,$gs,$subject)
    {
        $this->order_data = $order_data;
        $this->gs = $gs;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');

        $from_name = $this->gs->from_name;
        $from_email = 'sales@partzdeal.com';
        $subject = "Funda of Web IT: You have a new query";
        $order = $this->order_data;
        $gs = $this->gs;
        return $this->from($from_email, $from_name)
            ->view('emails.customerorder',compact('order','gs'))
            ->subject($this->subject)
        ;
    }
}