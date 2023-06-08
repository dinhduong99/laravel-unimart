<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'name', 'slug', 'thumbnail', 'post_cat_id', 'description', 'status', 'view'
    ];
    public function cat()
    {
        return $this->belongsTo('App\Cat_post', 'post_cat_id', 'id');
    }
}
