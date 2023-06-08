<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'fullname', 'email', 'phone', 'address', 'wards', 'province', 'city', 'note', 'payment_method', 'code', 'card_total', 'product_order', 'status'
    ];
}
