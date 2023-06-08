<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Order;

class OrderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    // }
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mails.order')
            ->from('ndinhduong1999@gmail.com', 'DD STORE')
            ->subject("Thông báo xác nhận đơn hàng #{$this->order['code']}")
            ->with($this->order);
    }
}
