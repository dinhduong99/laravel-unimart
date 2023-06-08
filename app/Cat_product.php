<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_product extends Model
{
    protected $fillable = [
        'name', 'slug', 'parent_id', 'status', 'has_child'
    ];
    public function product()
    {
        return $this->hasMany('App\Product', 'product_cat_id', 'id');
    }
}
