<?php

namespace App\Http\Controllers;

use App\City;
use App\Province;
use App\Wards;
use App\Order;
use App\Product;
use App\Cat_product;
use App\Cat_post;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Mail\OrderMail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendOrderMail;
use Illuminate\Support\Facades\Artisan;

class CheckoutController extends Controller
{
    public function index()
    {
        $cat_products = Cat_product::where('status', 'public')->get();
        $cat_posts = Cat_post::where('status', 'public')->get();
        $list_cat = data_tree($cat_products, 0);
        $city = City::orderby('matp', 'ASC')->get();
        $quanhuyen = Province::orderby('matp', 'ASC')->get();
        $wards = Wards::orderby('maqh', 'ASC')->get();
        return view('checkout', compact('city', 'list_cat', 'cat_posts', 'quanhuyen', 'wards'));
    }
    public function  select_address(Request $request)
    {
        $data = $request->all();
        if ($data['action']) {
            $output = '';
            if ($data['action'] == "city") {
                $select_province = Province::where('matp', $data['matp'])->orderby('maqh', 'ASC')->get();
                $output .= "<option value=''>--Chọn quận huyện--</option>";
                foreach ($select_province as $province) {
                    $output .= "<option value={$province->maqh}>{$province->name_quanhuyen}</option>";
                }
            } else {
                $select_wards = Wards::where('maqh', $data['matp'])->orderby('xaid', 'ASC')->get();
                $output .= "<option value=''>--Chọn xã phường--</option>";
                foreach ($select_wards as $wards) {
                    $output .= "<option value={$wards->xaid}>{$wards->name_xaphuong}</option>";
                }
            }
        }
        echo $output;
    }
    public function infor_order()
    {
        $infor = Order::where('code', session('code'))->first();
        $cat_products = Cat_product::where('status', 'public')->get();
        $list_cat = data_tree($cat_products, 0);
        $cat_posts = Cat_post::where('status', 'public')->get();
        if (!empty($infor)) {
            $product_order = json_decode($infor->product_order);
            $order = [
                'fullname' => $infor->fullname,
                'time_order' => date('d/m/Y - H:i:s', strtotime($infor->created_at)),
                'code' => $infor->code,
                'email' => $infor->email,
                'phone' => $infor->phone,
                'address' => $infor->address . ',' .  $infor->wards . ',' .   $infor->province . ',' .  $infor->city,
                'product_order' =>   $product_order,
                'payment_method' =>  $infor->payment_method,
                'card_total' => $infor->card_total,
                'note' => $infor->note
            ];
            Mail::to($order['email'])->queue(new OrderMail($order));
            // Mail::to($order['email'])->send(new OrderMail($order));
        }
        // return view('order_success')->with('infor', $infor);
        return view('order_success', compact('infor', 'list_cat', 'cat_posts'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'fullname' => ['required', 'string', 'max:255', 'min:2'],
                'email' => ['required', 'regex:/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/i'],
                'phone' => ['required', 'numeric', 'min:12'],
                'address' => ['required', 'string', 'max:255'],
                'city' => ['required'],
                'province' => ['required'],
                'wards' => ['required'],
                'payment_method' => ['required', 'in:payment-home'],
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'numeric' => 'Số điện thoại không đúng định dạng',
                'email.regex' => 'Địa chỉ email không đúng định dạng',
                'fullname.min' => 'Họ tên ít nhất 6 ký tự'
            ],
            [
                'fullname' => 'Họ tên',
                'email' => 'Email',
                'phone' => 'Số điện thoại',
                'address' => 'Địa chỉ',
                'city' => 'Thành phố',
                'province' => 'Quận huyện',
                'wards' => 'Phường xã',
                'note' => 'Ghi chú',
                'payment_method' => 'Phương thức thanh toán',
            ]
        );
        $code = rand(100, 1000);
        $infor = $request->all();
        // dd($infor);
        $infor['code'] = $code;
        $product_order = Cart::content();
        $product_id = [];
        foreach ($product_order as $value) {
            $product_id[$value->id] = $value->qty;
        }
        // dd($product_id);
        $card_total = Cart::total();
        $city = City::find((int)$infor['city']);
        $province = Province::find((int)$infor['province']);
        $wards = Wards::find((int)$infor['wards']);
        // dd($city->name_city);
        $infor['city'] = $city->name_city;
        $infor['province'] = $province->name_quanhuyen;
        $infor['wards'] = $wards->name_xaphuong;
        $infor['card_total'] = str_replace('.', '', $card_total);
        $infor['product_order'] = $product_order;
        $infor['status'] = 'processing';
        $order = Order::create($infor);
        Cart::destroy();
        //Thêm số lượng mua vào product được mua
        foreach ($product_id as $key => $value) {
            $product = Product::where('id', $key)->first();
            $product->update(
                [
                    'number_buy' => $product->number_buy + $value
                ]
            );
        };
        return redirect('thong-bao-don-hang.html')->with('code', $order->code);
    }
}
