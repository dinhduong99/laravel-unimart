<?php

namespace App\Http\Controllers;

use App\Cat_product;
use App\Product;
use App\Cat_post;
use App\Ads;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $product = Product::where('name', 'like', '%' . $keyword . '%')->get();
        $cat_products = Cat_product::where('status', 'public')->get();
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
        // dd($result);
        $list_cat = data_tree($cat_products, 0);
        $ads = Ads::where('status', 'public')->get();
        return view('search', compact('list_cat', 'product', 'cat_posts', 'ads'));
    }
    public function ajax_search(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $keyword = $data['keyword'];
            $res = Product::where('name', 'LIKE', '%' .  $keyword  . '%')->get();
            return response()->json($res);
        }
    }
    public function product_filter(Request $request)
    {
        return "a";
    }
}
