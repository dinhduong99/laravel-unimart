<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Page extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'name', 'description', 'status', 'slug'
    ];
}
