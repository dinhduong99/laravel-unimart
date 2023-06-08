<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cat_product;
use App\Cat_post;
use App\Role;
use Illuminate\Support\Facades\Response;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $cat_posts = Cat_post::where('status', 'public')->get();
        $cat_products = Cat_product::where('status', 'public')->get();
        $list_cat = data_tree($cat_products, 0);
        return view('cart', compact('list_cat', 'cat_posts'));
    }

    public function add(Request $request, $slug)
    {

        if ($request->input('num-order')) {
            $product = Product::where('slug', $slug)->first();
            if ($product->percent_price == 0) {
                $price = $product->price;
            } else {
                $price = $product->sale_price;
            }
            Cart::add(
                [
                    'id' => $product->id,
                    'name' => $product->name,
                    'qty' => $request->input('num-order'),
                    'price' => $price,
                    'options' => ['thumbnail' => $product->thumbnail, 'slug' => $product->slug]
                ]
            );
            return redirect('gio-hang.html');
        }
    }

    public function add_ajax(Request $request)
    {
        $id_product = $request->id;
        $name_product = $request->name_product;
        $qty_product = $request->qty_product;
        $price_product =  $request->price_product;
        $thumbnail_product = $request->thumbnail_product;
        $slug_product = $request->slug_product;
        Cart::add(
            [
                'id' =>   $id_product,
                'name' =>  $name_product,
                'qty' => $qty_product,
                'price' => $price_product,
                'options' => ['thumbnail' => $thumbnail_product, 'slug' => $slug_product]
            ]
        );
        return response()->json([
            'notification' => 'Đã thêm sản phẩm vào giỏ hàng',
        ]);
    }

    public function remove_ajax(Request $request)
    {
        $rowid = $request->rowid;
        $url_home = url("");
        Cart::remove($rowid);
        return response()->json([
            'notification' => 'Xóa sản phẩm thành công',
        ]);
    }

    public function delete_all()
    {
        Cart::destroy();
        return redirect('gio-hang.html');
    }

    public function update_ajax(Request $request)
    {
        $data = $request->all();
        $qty = $data['qty'];
        $rowId = $data['rowId'];
        $id = $data['id'];
        Cart::update($rowId, $qty);
        $total = Cart::total();
        $sub_total = Cart::get($rowId)->subtotal();
        $num = Cart::count();
        $res = [
            'id' => $id,
            'qty' => $qty,
            'rowId' => $rowId,
            'total' => $total,
            'sub_total' => $sub_total,
            'num' => $num
        ];
        return response()->json($res);
    }

    public function buy_now($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if ($product->percent_price == 0) {
            $price = $product->price;
        } else {
            $price = $product->sale_price;
        }
        Cart::add(
            [
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $price,
                'options' => ['thumbnail' => $product->thumbnail]
            ]
        );
        return redirect('thanh-toan.html');
    }
}
