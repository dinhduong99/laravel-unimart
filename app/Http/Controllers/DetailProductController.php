<?php

namespace App\Http\Controllers;

use App\Cat_product;
use Illuminate\Http\Request;
use App\Product;
use App\Cat_post;
use App\Ads;

class DetailProductController extends Controller
{
    public function index($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $product_same = Product::where([['id', '!=', $product->id], ['product_cat_id', $product->cat->id]])->get();
        // dd($product->cat->parent_id);
        $cat_parent = Cat_product::where([['status', 'public'], ['id', $product->cat->parent_id]])->first();
        // dd($cat_parent);
        if ($product->view == null) {
            $product->update([
                'view' => 1
            ]);
        } else {
            $view = $product->view + 1;
            $product->update([
                'view' =>  $view
            ]);
        }
        $cat_products = Cat_product::where('status', 'public')->get();
        function cat($data, $parent_id = 0, $level = 0)
        {
            $result = [];
            foreach ($data as $item) {
                if ($item['parent_id'] == $parent_id) {
                    $item['level'] = $level;
                    $result[] = $item;
                    unset($data[$item['id']]);
                    $child = cat($data, $item['id'], $level + 1);
                    $result = array_merge($result, $child);
                }
            }
            return $result;
        }
        $list_cat = cat($cat_products, 0);
        $cat_posts = Cat_post::where('status', 'public')->get();
        $ads = Ads::where('status', 'public')->get();
        return view('detail_product', compact('product', 'product_same', 'cat_parent', 'list_cat', 'cat_posts', 'ads'));
    }
}
