<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendOrderMail;


class OrderMailController extends Controller
{
    public function sendmail()
    {
        // $infor = Order::where('code', session('code'))->first();
        // // dd($infor);
        // $product_order = json_decode($infor->product_order);
        // $order = [
        //     'fullname' => $infor->fullname,
        //     'time_order' => date('d/m/Y - H:i:s', strtotime($infor->created_at)),
        //     'code' => $infor->code,
        //     'email' => $infor->email,
        //     'phone' => $infor->phone,
        //     'address' => $infor->address . ',' .  $infor->wards . ',' .   $infor->province . ',' .  $infor->city,
        //     'product_order' =>   $product_order,
        //     'payment_method' =>  $infor->payment_method,
        //     'card_total' => $infor->card_total,
        //     'note' => $infor->note
        // ];
        // // dd($order);
        // Mail::to('ndinhduong99@gmail.com')->queue(new OrderMail());
        // $emailJob = new SendOrderMail();
        // dispatch($emailJob);
        // echo "thành công";
    }
}
