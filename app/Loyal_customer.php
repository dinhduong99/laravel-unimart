<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loyal_customer extends Model
{
    protected $fillable = [
        'fullname', 'email', 'phone', 'address', 'wards', 'province', 'city', 'card_total', 'bought_recently', 'number_order'
    ];
}
