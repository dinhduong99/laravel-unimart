<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cat_product;
use App\Product;
use App\Cat_post;
use App\Ads;

class CatProductController extends Controller
{
    public function cat_product(Request $request, $slug)
    {
        // dd($request->all());
        $price_filter = [
            'price_1' => [0, 500000],
            'price_2' => [500000, 10000000],
            'price_3' => [10000000, 5000000],
            'price_4' => [5000000, 10000000],
            'price_5' => [10000000, 100000000],
        ];
        $brand_filter = [
            'brand_1' => [46],
            'brand_2' => [50],
            'brand_3' => [47],
            'brand_4' => [42, 44, 45],
            'brand_5' => [41, 62],
        ];
        $checked = [];
        $cat_product = Cat_product::where('status', 'public')->where('slug', $slug)->first();
        $cat_posts = Cat_post::where('status', 'public')->get();
        $ads = Ads::where('status', 'public')->get();

        if ($cat_product->parent_id == 0 && $cat_product->has_child == 0) {
            // dd('ok');
            if ($request->input('price_filter')) {
                $product =  Product::where('product_cat_id', $cat_product->id)->whereBetween('sale_price',  $price_filter[$request->input("price_filter")])->paginate(10);
                $checked = [
                    'price_filter' => $request->input('price_filter')
                ];
            }

            if ($request->input('brand_filter')) {
                $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$request->input('brand_filter')])->paginate(10);
                $checked = [
                    'brand_filter' => $request->input('brand_filter')
                ];
            }

            if (($request->input('price_filter')) && ($request->input('brand_filter'))) {
                $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$request->input('brand_filter')])->whereBetween('sale_price',  $price_filter[$request->input("price_filter")])->paginate(10);
                $checked = [
                    'price_filter' => $request->input('price_filter'),
                    'brand_filter' => $request->input('brand_filter')
                ];
            }

            if (empty($request->input('price_filter')) && empty($request->input('brand_filter')) && empty($request->input('select'))) {
                $product = Product::where('product_cat_id', $cat_product->id)->paginate(10);
            }

            if ($request->input('select') != "") {
                $price_select = $request->input('price_select');
                $brand_select = $request->input('brand_select');
                if ((isset($price_select)) && (isset($brand_select))) {
                    if ($request->input('select') == 1) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('name', 'ASC')->paginate(10);
                    }
                    if ($request->input('select') == 2) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('name', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 3) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('sale_price', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 4) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('sale_price', 'ASC')->paginate(10);
                    }
                    $checked = [
                        'brand_filter' => $request->input('brand_select'),
                        'price_filter' => $request->input('price_select'),
                        'select' => $request->input('select')
                    ];
                } elseif (isset($price_select)) {
                    $price_select = $request->input('price_select');
                    if ($request->input('select') == 1) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('name', 'ASC')->paginate(10);
                    }
                    if ($request->input('select') == 2) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('name', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 3) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('sale_price', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 4) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('sale_price', 'ASC')->paginate(10);
                    }
                    $checked = [
                        'price_filter' => $request->input('price_select'),
                        'select' => $request->input('select')
                    ];
                } elseif (isset($brand_select)) {
                    $brand_select = $request->input('brand_select');
                    if ($request->input('select') == 1) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->orderBy('name', 'ASC')->paginate(10);
                    }
                    if ($request->input('select') == 2) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->orderBy('name', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 3) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->orderBy('sale_price', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 4) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->orderBy('sale_price', 'ASC')->paginate(10);
                    }
                    $checked = [
                        'brand_filter' => $request->input('brand_select'),
                        'select' => $request->input('select')
                    ];
                } else {
                    if ($request->input('select') == 1) {
                        $product = Product::where('product_cat_id', $cat_product->id)->orderBy('name', 'ASC')->paginate(10);
                    }
                    if ($request->input('select') == 2) {
                        $product = Product::where('product_cat_id', $cat_product->id)->orderBy('name', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 3) {
                        $product = Product::where('product_cat_id', $cat_product->id)->orderBy('sale_price', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 4) {
                        $product = Product::where('product_cat_id', $cat_product->id)->orderBy('sale_price', 'ASC')->paginate(10);
                    }
                    $checked = [
                        'select' => $request->input('select')
                    ];
                }
            }
            $cat_parent = Cat_product::where(['status' => 'public', 'id' => $cat_product->parent_id])->first();
            $count =   $product->count();
            // dd('a');
        }

        if ($cat_product->parent_id == 0 && $cat_product->has_child != 0) {
            // dd('b');
            $cat_product_child = Cat_product::where(['status' => 'public', 'parent_id' => $cat_product->id])->get();
            foreach ($cat_product_child as $cat) {
                $cat_id[] = $cat->id;
            }
            if (($request->input('price_filter')) && ($request->input('brand_filter'))) {
                $product = Product::whereIn('product_cat_id', $cat_id)->whereIn('product_cat_id',  $brand_filter[$request->input('brand_filter')])->whereBetween('sale_price',  $price_filter[$request->input("price_filter")])->paginate(10);
                $checked = [
                    'price_filter' => $request->input('price_filter'),
                    'brand_filter' => $request->input('brand_filter')
                ];
            } elseif ($request->input('price_filter')) {
                $product = Product::whereIn('product_cat_id', $cat_id)->whereBetween('sale_price',  $price_filter[$request->input("price_filter")])->paginate(10);
                $checked = [
                    'price_filter' => $request->input('price_filter')
                ];
            } elseif ($request->input('brand_filter')) {
                $product = Product::whereIn('product_cat_id', $cat_id)->whereIn('product_cat_id',  $brand_filter[$request->input('brand_filter')])->paginate(10);
                $checked = [
                    'brand_filter' => $request->input('brand_filter')
                ];
            }
            // if (empty($request->input('price_filter')) && empty($request->input('brand_filter')) && empty($request->input('select'))) {
            else {
                $product = Product::whereIn('product_cat_id', $cat_id)->paginate(10);
            }

            if ($request->input('select')) {
                $price_select = $request->input('price_select');
                $brand_select = $request->input('brand_select');
                if ((isset($price_select)) && (isset($brand_select))) {
                    // dd('a');
                    if ($request->input('select') == 1) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('name', 'ASC')->paginate(10);
                    }
                    if ($request->input('select') == 2) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('name', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 3) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('sale_price', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 4) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('sale_price', 'ASC')->paginate(10);
                    }
                    $checked = [
                        'price_filter' =>  $price_select,
                        'brand_filter' => $brand_select,
                        'select' => $request->input('select')
                    ];
                } elseif (isset($price_select)) {
                    // dd('b');
                    if ($request->input('select') == 1) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('name', 'ASC')->paginate(10);
                    }
                    if ($request->input('select') == 2) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('name', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 3) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('sale_price', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 4) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('sale_price', 'ASC')->paginate(10);
                    }
                    $checked = [
                        'price_filter' => $price_select,
                        'select' => $request->input('select'),
                    ];
                } elseif (isset($brand_select)) {
                    // dd('c');
                    if ($request->input('select') == 1) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->orderBy('name', 'ASC')->paginate(10);
                    }
                    if ($request->input('select') == 2) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->orderBy('name', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 3) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->orderBy('sale_price', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 4) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->orderBy('sale_price', 'ASC')->paginate(10);
                    }
                    $checked = [
                        'brand_filter' => $brand_select,
                        'select' => $request->input('select'),

                    ];
                    // } elseif (!isset($brand_select) && !isset($price_select)) {
                } else {
                    // dd('d');
                    if ($request->input('select') == 1) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->orderBy('name', 'ASC')->paginate(10);
                    }
                    if ($request->input('select') == 2) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->orderBy('name', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 3) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->orderBy('sale_price', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 4) {
                        $product = Product::whereIn('product_cat_id', $cat_id)->orderBy('sale_price', 'ASC')->paginate(10);
                    }
                    $checked = [
                        'select' => $request->input('select'),

                    ];
                }
            }
            $count =   $product->count();
            $cat_parent = "";
        }

        if ($cat_product->parent_id != 0) {
            // dd('c');
            if ($request->input('price_filter')) {
                $product =  Product::where('product_cat_id', $cat_product->id)->whereBetween('sale_price',  $price_filter[$request->input("price_filter")])->paginate(10);
                $checked = [
                    'price_filter' => $request->input('price_filter')
                ];
            }

            if ($request->input('brand_filter')) {
                $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$request->input('brand_filter')])->paginate(10);
                $checked = [
                    'brand_filter' => $request->input('brand_filter')
                ];
            }

            if (($request->input('price_filter')) && ($request->input('brand_filter'))) {
                $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$request->input('brand_filter')])->whereBetween('sale_price',  $price_filter[$request->input("price_filter")])->paginate(10);
                $checked = [
                    'price_filter' => $request->input('price_filter'),
                    'brand_filter' => $request->input('brand_filter')
                ];
            }

            if (empty($request->input('price_filter')) && empty($request->input('brand_filter')) && empty($request->input('select'))) {
                $product = Product::where('product_cat_id', $cat_product->id)->paginate(10);
            }

            if ($request->input('select') != "") {
                $price_select = $request->input('price_select');
                $brand_select = $request->input('brand_select');
                if ((isset($price_select)) && (isset($brand_select))) {
                    if ($request->input('select') == 1) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('name', 'ASC')->paginate(10);
                    }
                    if ($request->input('select') == 2) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('name', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 3) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('sale_price', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 4) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('sale_price', 'ASC')->paginate(10);
                    }
                    $checked = [
                        'brand_filter' => $request->input('brand_select'),
                        'price_filter' => $request->input('price_select'),
                        'select' => $request->input('select')
                    ];
                } elseif (isset($price_select)) {
                    $price_select = $request->input('price_select');
                    if ($request->input('select') == 1) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('name', 'ASC')->paginate(10);
                    }
                    if ($request->input('select') == 2) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('name', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 3) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('sale_price', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 4) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereBetween('sale_price',  $price_filter[$price_select])->orderBy('sale_price', 'ASC')->paginate(10);
                    }
                    $checked = [
                        'price_filter' => $request->input('price_select'),
                        'select' => $request->input('select')
                    ];
                } elseif (isset($brand_select)) {
                    $brand_select = $request->input('brand_select');
                    if ($request->input('select') == 1) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->orderBy('name', 'ASC')->paginate(10);
                    }
                    if ($request->input('select') == 2) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->orderBy('name', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 3) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->orderBy('sale_price', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 4) {
                        $product = Product::where('product_cat_id', $cat_product->id)->whereIn('product_cat_id',  $brand_filter[$brand_select])->orderBy('sale_price', 'ASC')->paginate(10);
                    }
                    $checked = [
                        'brand_filter' => $request->input('brand_select'),
                        'select' => $request->input('select')
                    ];
                } else {
                    if ($request->input('select') == 1) {
                        $product = Product::where('product_cat_id', $cat_product->id)->orderBy('name', 'ASC')->paginate(10);
                    }
                    if ($request->input('select') == 2) {
                        $product = Product::where('product_cat_id', $cat_product->id)->orderBy('name', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 3) {
                        $product = Product::where('product_cat_id', $cat_product->id)->orderBy('sale_price', 'DESC')->paginate(10);
                    }
                    if ($request->input('select') == 4) {
                        $product = Product::where('product_cat_id', $cat_product->id)->orderBy('sale_price', 'ASC')->paginate(10);
                    }
                    $checked = [
                        'select' => $request->input('select')
                    ];
                }
            }
            $cat_parent = Cat_product::where(['status' => 'public', 'id' => $cat_product->parent_id])->first();
            $count =   $product->count();
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
        if (isset($checked['price_filter'])) {
            $request->session()->put('price_filter', $checked['price_filter']);
        }
        if (isset($checked['brand_filter'])) {
            $request->session()->put('brand_filter', $checked['brand_filter']);
        }
        return view('cat_product', compact('product', 'cat_product', 'list_cat', 'count', 'cat_parent', 'checked', 'cat_posts', 'ads'));
    }
}
