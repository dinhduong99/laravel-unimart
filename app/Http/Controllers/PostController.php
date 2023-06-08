<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cat_post;
use App\Post;
use App\Product;
use App\Cat_product;
use App\Ads;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'public')->paginate(5);
        $cat_posts = Cat_post::where('status', 'public')->get();
        $avg_buy_products = Product::where('status', '!=', 'pending')->avg('number_buy');
        $product_high_buys = Product::where([['status', '!=', 'pending'], ['number_buy', '>=', $avg_buy_products]])->paginate(5);
        $cat_products = Cat_product::where('status', 'public')->get();
        $list_cat = data_tree($cat_products, 0);
        // $avg_buy_Posts = Post::where('status', '!=', 'pending')->avg('number_buy');
        // $Post_high_buys = Post::where([['status', '!=', 'pending'], ['number_buy', '>=', $avg_buy_Posts]])->get();

        // $list_cat = cat_Post_all($cat_Posts, 0);
        $ads = Ads::where('status', 'public')->get();
        return view('post', compact('posts', 'cat_posts', 'product_high_buys', 'list_cat', 'ads'));
    }
    public function detail($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $view = $post->view + 1;
        $post->update([
            'view' =>  $view
        ]);
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
        return view('detail_post', compact('post', 'cat_posts', 'product_high_buys', 'post_high_view', 'list_cat', 'ads'));
    }
    public function cat_post($slug)
    {
        // dd($slug);
        $cat_posts = Cat_post::where('status', 'public')->get();
        $avg_buy_products = Product::where('status', '!=', 'pending')->avg('number_buy');
        $product_high_buys = Product::where([['status', '!=', 'pending'], ['number_buy', '>=', $avg_buy_products]])->paginate(5);
        $cat_post = Cat_post::where('slug', $slug)->first();
        $cat_products = Cat_product::where('status', 'public')->get();
        $list_cat = data_tree($cat_products, 0);
        $posts = Post::where(['status' => 'public', 'post_cat_id' => $cat_post->id])->paginate(5);
        $ads = Ads::where('status', 'public')->get();
        return view('cat_post', compact('cat_posts', 'product_high_buys', 'posts', 'cat_post', 'list_cat', 'ads'));
    }
}
