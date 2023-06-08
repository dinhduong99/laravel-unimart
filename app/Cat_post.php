<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_post extends Model
{
    protected $fillable = [
        'name', 'slug', 'status',
    ];
    public function product()
    {
        return $this->hasMany('App\Post', 'post_cat_id', 'id');
    }
}
