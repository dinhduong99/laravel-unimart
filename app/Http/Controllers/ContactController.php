<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cat_product;
use App\Cat_post;
use App\Contact;
use PhpParser\Node\Stmt\Catch_;

class ContactController extends Controller
{
    public function index()
    {
        $cat_products = Cat_product::where('status', 'public')->get();
        $cat_posts = Cat_post::where('status', 'public')->get();
        $list_cat = data_tree($cat_products, 0);
        return view('contact', compact('list_cat', 'cat_posts'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'fullname' => ['required', 'string', 'max:255', 'min:6'],
                'email' => ['required', 'regex:/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/i'],
                'phone' => ['required', 'numeric', 'min:12'],
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
                'note' => 'Ghi chú',
            ]
        );
        $infor = $request->all();
        $infor['status'] = 'pending';
        Contact::create($infor);
        return redirect('thong-bao-lien-he.html');
    }
    public function contact_success()
    {
        $cat_products = Cat_product::where('status', 'public')->get();
        $list_cat = data_tree($cat_products, 0);
        $cat_posts = Cat_post::where('status', 'public')->get();
        return view('contact_success', compact('list_cat', 'cat_posts'));
    }
}
