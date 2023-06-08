<?php

namespace App\Http\Controllers;

use App\Ads;
use App\Cat_product;
use App\Product;
use App\Slider;
use App\Cat_post;
use App\Page;
use App\Post;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $avg_view_products = Product::where('status', '!=', 'pending')->avg('view');
        $avg_buy_products = Product::where('status', '!=', 'pending')->avg('number_buy');
        $product_high_views = Product::where([['status', '!=', 'pending'], ['view', '>=', $avg_view_products]])->get();
        $product_high_buys = Product::where([['status', '!=', 'pending'], ['number_buy', '>=', $avg_buy_products]])->get();
        // dd($product_high_buys);
        $sliders = Slider::all();
        $cat_posts = Cat_post::where('status', 'public')->get();
        // function cat($data, $parent_id = 0, $level = 0)
        // {
        //     $result = [];
        //     foreach ($data as $item) {
        //         if ($item['parent_id'] == $parent_id) {
        //             $item['level'] = $level;
        //             $result[] = $item;
        //             unset($data[$item['id']]);
        //             $child = cat($data, $item['id'], $level + 1);
        //             $result = array_merge($result, $child);
        //         }
        //     }
        //     return $result;
        // }
        // $list_cat = cat($cat_products, 0);
        $cat_products = Cat_product::where('status', 'public')->get();
        $list_cat = data_tree($cat_products, 0);
        $ads = Ads::where('status', 'public')->get();
        return view('home', compact('list_cat', 'cat_products', 'sliders', 'product_high_views', 'product_high_buys', 'cat_posts', 'ads'));
    }

    public function product_all()
    {
        $avg_buy_products = Product::where('status', '!=', 'pending')->avg('number_buy');
        $product_high_buys = Product::where([['status', '!=', 'pending'], ['number_buy', '>=', $avg_buy_products]])->get();
        $cat_products = Cat_product::where('status', 'public')->get();
        $cat_posts = Cat_post::where('status', 'public')->get();
        // function cat_product_all($data, $parent_id = 0, $level = 0)
        // {
        //     $result = [];
        //     foreach ($data as $item) {
        //         if ($item['parent_id'] == $parent_id) {
        //             $item['level'] = $level;
        //             $result[] = $item;
        //             unset($data[$item['id']]);
        //             $child = cat_product_all($data, $item['id'], $level + 1);
        //             $result = array_merge($result, $child);
        //         }
        //     }
        //     return $result;
        // }
        $list_cat = data_tree($cat_products, 0);
        $ads = Ads::where('status', 'public')->get();
        return view('product_all', compact('list_cat', 'cat_products', 'product_high_buys', 'cat_posts', 'ads'));
    }

    public function intro()
    {
        $intro = Page::where('slug', 'gioi-thieu')->first();
        $cat_posts = Cat_post::where('status', 'public')->get();
        $avg_buy_products = Product::where('status', '!=', 'pending')->avg('number_buy');
        $product_high_buys = Product::where([['status', '!=', 'pending'], ['number_buy', '>=', $avg_buy_products]])->get();
        $avg_buy_posts = Post::where('status', '!=', 'pending')->avg('view');
        // dd($avg_buy_posts);
        $post_high_view = Post::where([['status', '!=', 'pending'], ['view', '>=', $avg_buy_products]])->paginate(5);
        $cat_products = Cat_product::where('status', 'public')->get();
        $list_cat = data_tree($cat_products, 0);
        // dd($post_high_view);
        $ads = Ads::where('status', 'public')->get();
        return view('intro', compact('intro', 'cat_posts', 'product_high_buys', 'post_high_view', 'list_cat', 'ads'));
    }
}
