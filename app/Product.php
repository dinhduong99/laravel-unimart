<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'name', 'slug', 'thumbnail', 'product_cat_id', 'price', 'percent_price', 'sale_price',    'detail', 'description', 'status', 'image_list',  'color_image', 'color_id', 'view', 'number_buy'
    ];
    public function cat()
    {
        return $this->belongsTo('App\Cat_product', 'product_cat_id', 'id');
    }
    public function scopeSearch($query)
    {
        if (request('keyword')) {
            $keyword = request('keyword');
            $query = $query->where('name', 'like', '%' . $keyword . '%');
        }
        return $query;
    }
}
