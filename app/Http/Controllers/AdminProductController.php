<?php

namespace App\Http\Controllers;

use App\Cat_product;
use App\Color;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $keyword = "";
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        $url_status = 'active';
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $products  = Product::where('name', 'LIKE', "%{$keyword}%")->paginate(5);
        $count_active = Product::count();
        $count_out_of_stock = Product::where('status', 'out of stock')->count();
        $count_stocking = Product::where('status', 'stocking')->count();
        $count_pending = Product::where('status', 'pending')->count();
        $count_trash = Product::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'out-of-stock' => $count_out_of_stock,
            'stocking' => $count_stocking,
            'pending' => $count_pending,
            'trash' => $count_trash,
        ];
        return view('admin.product.list', compact('products', 'count', 'list_action', 'url_status'));
    }

    public function product_stocking(Request $request)
    {
        $keyword = "";
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        $url_status = 'stocking';
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $products = Product::where('status', 'stocking')->where('name', 'LIKE', "%{$keyword}%")->paginate(5);
        $count_active = Product::count();
        $count_out_of_stock = Product::where('status', 'out of stock')->count();
        $count_stocking = Product::where('status', 'stocking')->count();
        $count_pending = Product::where('status', 'pending')->count();
        $count_trash = Product::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'out-of-stock' => $count_out_of_stock,
            'stocking' => $count_stocking,
            'pending' => $count_pending,
            'trash' => $count_trash,
        ];
        return view('admin.product.stocking', compact('products', 'count', 'list_action', 'url_status'));
    }

    public function product_out_of_stock(Request $request)
    {
        $keyword = "";
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        $url_status = 'out_of_stock';
        $products = Product::where('status', 'out of stock')->where('name', 'LIKE', "%{$keyword}%")->paginate(5);
        $count_active = Product::count();
        $count_out_of_stock = Product::where('status', 'out of stock')->count();
        $count_stocking = Product::where('status', 'stocking')->count();
        $count_pending = Product::where('status', 'pending')->count();
        $count_trash = Product::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'out-of-stock' => $count_out_of_stock,
            'stocking' => $count_stocking,
            'pending' => $count_pending,
            'trash' => $count_trash,
        ];
        return view('admin.product.stocking', compact('products', 'count', 'list_action', 'url_status'));
    }

    public function product_pending(Request $request)
    {
        $keyword = "";
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        $url_status = 'pending';
        $products = Product::where('status', 'pending')->where('name', 'LIKE', "%{$keyword}%")->paginate(5);
        $count_active = Product::count();
        $count_out_of_stock = Product::where('status', 'out of stock')->count();
        $count_stocking = Product::where('status', 'stocking')->count();
        $count_pending = Product::where('status', 'pending')->count();
        $count_trash = Product::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'out-of-stock' => $count_out_of_stock,
            'stocking' => $count_stocking,
            'pending' => $count_pending,
            'trash' => $count_trash,
        ];
        return view('admin.product.pending', compact('products', 'count', 'list_action', 'url_status'));
    }

    public function product_trash(Request $request)
    {
        $keyword = "";
        $url_status = 'trash';
        $list_action = [
            'active' => 'Kích hoạt',
            'delete' => 'Xóa',
        ];
        $products = Product::onlyTrashed()->paginate(5);
        $count_active = Product::count();
        $count_out_of_stock = Product::where('status', 'out of stock')->where('name', 'LIKE', "%{$keyword}%")->count();
        $count_stocking = Product::where('status', 'stocking')->count();
        $count_pending = Product::where('status', 'pending')->count();
        $count_trash = Product::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'out-of-stock' => $count_out_of_stock,
            'stocking' => $count_stocking,
            'pending' => $count_pending,
            'trash' => $count_trash,
        ];
        return view('admin.product.trash', compact('products', 'count', 'list_action', 'url_status'));
    }

    public function add()
    {
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
        // return $list_cat;
        $colors = Color::where('id', '>', 1)->get();
        $colors_img = Color::all();
        // dd($colors_img);
        return view('admin.product.add', compact('colors', 'list_cat', 'colors_img'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $cat_products = Cat_product::where('parent_id', '!=', 0)->get();
            foreach ($cat_products as $value) {
                $cats[] = $value->id;
            }
            $cats = implode(",", $cats);
            // return $cats;
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255', 'unique:products'],
                    'color_id' => ['required'],
                    'slug' => ['required', 'string', 'max:255', 'unique:products'],
                    'price' => ['required', 'string', 'max:255'],
                    'sale_price' => ['required', 'string', 'max:255'],
                    'percent_price' => ['required', 'string', 'max:255'],
                    'product_cat_id' => ['required', "in:$cats"],
                    'thumbnail' => ['required', 'max:10000'],
                    'image_list' => ['required'],
                    'image_list.*' => ['max:10000'],
                    'detail' => ['required', 'string',],
                    'description' => ['required', 'string',],
                ],
                [
                    'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                    'required' => ':attribute không được để trống',
                    'thumbnail.max' => ':attribute có độ dài tối đa :max kb',
                    'image_list.max' => ':attribute có độ dài tối đa :max kb',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                    'in' => 'Vui lòng chọn :attribute'
                ],
                [
                    'name' => 'Tên màu',
                    'color_id' => 'Màu sắc sản phẩm',
                    'slug' => 'Đường dẫn',
                    'price' => 'Giá sản phẩm',
                    'sale_price' => 'Phần trăm khuyến mãi',
                    'percent_price' => 'Giá khuyến mãi',
                    'product_cat_id' => 'Danh mục sản phẩm',
                    'thumbnail' => 'Hình ảnh sản phẩm',
                    'image_list' => 'Hình ảnh chi tiết sản phẩm',
                    'detail' => 'Chi tiết sản phẩm',
                    'description' => 'Mô tả sản phẩm',
                ]
            );
            $input = $request->all();
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $file_name = $file->getClientOriginalName();
                $file->move('public/uploads', $file_name);
                $thumbnail = 'public/uploads/' . $file_name;
                $input['thumbnail'] = $thumbnail;
            }
            if ($request->hasFile('image_list')) {
                $files = $request->file('image_list');
                // $color_img = $request->file('color_image');
                foreach ($files as $file) {
                    $file_name = $file->getClientOriginalName();
                    $file->move('public/uploads', $file_name);
                    $thumbnail = 'public/uploads/' . $file_name;
                    $image_list[] = $thumbnail;
                }
                $input['image_list'] =  json_encode($image_list);
            }
            $input['color_image'] = json_encode($request->input('color_image'));
            $input['color_id'] = json_encode($request->input('color_id'));
            Product::create($input);
            // print_r($input);
            // dd($input);
            return redirect('admin/product/list')->with('notification', 'Đã thêm sản phẩm thành công');
        } else {
            return redirect('admin/product/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function edit($id)
    {
        $colors = Color::where('id', '>', 1)->get();
        $colors_img = Color::all();
        $product = Product::find($id);
        $cat_products = Cat_product::where('status', 'public')->get();
        function cat_edit($data, $parent_id = 0, $level = 0)
        {
            $result = [];
            foreach ($data as $item) {
                if ($item['parent_id'] == $parent_id) {
                    $item['level'] = $level;
                    $result[] = $item;
                    unset($data[$item['id']]);
                    $child = cat_edit($data, $item['id'], $level + 1);
                    $result = array_merge($result, $child);
                }
            }
            return $result;
        }
        $list_cat = cat_edit($cat_products, 0);
        return view('admin.product.edit', compact('product', 'colors', 'list_cat', 'colors_img'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $product = Product::find($id);
            // dd($product);
            $cat_products = Cat_product::where('parent_id', '!=', 0)->get();
            foreach ($cat_products as $value) {
                $cats[] = $value->id;
            }
            $cats = implode(",", $cats);
            // return $cats;
            $request->validate(
                [
                    'name' => 'required|string|max:255|unique:products,name,' . $id,
                    'color_id' => ['required'],
                    'slug' => 'required|string|max:255|unique:products,slug,' . $id,
                    'price' => ['required', 'string', 'max:255'],
                    'sale_price' => ['required', 'string', 'max:255'],
                    'percent_price' => ['required', 'string', 'max:255'],
                    'product_cat_id' => ['required', "in:$cats"],
                    'thumbnail' => ['max:10000'],
                    'image_list.*' => ['max:10000'],
                    'detail' => ['required', 'string',],
                    'description' => ['required', 'string',],
                ],
                [
                    'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                    'required' => ':attribute không được để trống',
                    'thumbnail.max' => ':attribute có độ dài tối đa :max kb',
                    'image_list.max' => ':attribute có độ dài tối đa :max kb',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                    'in' => 'Vui lòng chọn :attribute'
                ],
                [
                    'name' => 'Tên màu',
                    'color_id' => 'Màu sắc sản phẩm',
                    'slug' => 'Đường dẫn',
                    'price' => 'Giá sản phẩm',
                    'sale_price' => 'Phần trăm khuyến mãi',
                    'percent_price' => 'Giá khuyến mãi',
                    'product_cat_id' => 'Danh mục sản phẩm',
                    'thumbnail' => 'Hình ảnh sản phẩm',
                    'image_list' => 'Hình ảnh chi tiết sản phẩm',
                    'detail' => 'Chi tiết sản phẩm',
                    'description' => 'Mô tả sản phẩm',
                ]
            );
            $request->offsetUnset('_token');
            $request->offsetUnset('btn-update');
            $input = $request->all();

            if ($request->hasFile('thumbnail')) {
                $thumbnail_old = $product->thumbnail;
                if (file_exists($thumbnail_old)) {
                    unlink($thumbnail_old);
                };
                $file = $request->file('thumbnail');
                $file_name = $file->getClientOriginalName();
                $file->move('public/uploads', $file_name);
                $thumbnail = 'public/uploads/' . $file_name;
                $input['thumbnail'] = $thumbnail;
            }
            if ($request->hasFile('image_list')) {
                $image_list_delete = [];
                $image_list_now = $request->input('key');
                $image_list_old = json_decode($product->image_list);
                // dd($image_list_now);
                if (!empty($image_list_now)) {
                    foreach ($image_list_old as $key => $value) {
                        if (in_array($value, $image_list_now)) {
                            $image_list[] = $value;
                        } else {
                            $image_list_delete[] = $value;
                        }
                    };

                    if (!empty($image_list_delete)) {
                        foreach ($image_list_delete as $image) {
                            if (file_exists($image)) {
                                unlink($image);
                            };
                        };
                    }
                } else {
                    foreach ($image_list_old as $image) {
                        if (file_exists($image)) {
                            unlink($image);
                        };
                    };
                }

                $files = $request->file('image_list');
                foreach ($files as $file) {
                    $file_name = $file->getClientOriginalName();
                    $file->move('public/uploads', $file_name);
                    $thumbnail = 'public/uploads/' . $file_name;
                    $image_list[] = $thumbnail;
                }
                $input['image_list'] =  json_encode($image_list);
                $input['color_image'] = json_encode($request->input('color_image'));
            } else {
                $image_list_now = $request->input('key');
                $image_list = $image_list_now;
                $input['image_list'] =  json_encode($image_list);
                $input['color_image'] = json_encode($request->input('color_image'));
            }
            // dd($input);
            unset($input['key']);
            // dd($input);
            Product::where('id', $id)->update($input);
            return redirect('admin/product/list')->with('notification', 'Đã cập nhật sản phẩm thành công');
        } else {
            return redirect('admin/product/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function disable($id)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $product = Product::find($id);
            $product->delete();
            return redirect('admin/product/list')->with('notification', 'Sản phẩm đã được vô hiệu hóa thành công');
        } else {
            return redirect('admin/product/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }
    public function delete($id)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            Product::withTrashed()
                ->where('id', $id)
                ->forceDelete();
            return redirect('admin/product/list')->with('notification', 'Sản phẩm đã được xóa thành công');
        } else {
            return redirect('admin/product/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function action(Request $request)
    {
        $user = Auth::user();
        $list_check = $request->input('list_check');
        $action = $request->input('action');
        $preUrl = url()->previous();
        // dd($action);
        if ($user->role->name == 'admintrator') {
            if ($list_check) {
                $action = $request->input('action');
                if ($action == "") {
                    return redirect($preUrl)->with('notification', 'Bạn đã cần chọn thao tác để thực hiện');
                }
                if ($action == "disable") {
                    Product::destroy($list_check);
                    return redirect($preUrl)->with('notification', 'Bạn đã vô hiệu hóa sản phẩm thành công');
                }
                if ($action == "active") {
                    Product::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    return redirect($preUrl)->with('notification', 'Bạn đã kích hoạt sản phẩm thành công');
                }
                if ($action == "delete") {
                    Product::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect($preUrl)->with('notification', 'Bạn đã xóa sản phẩm thành công');
                }
            } else {
                return redirect($preUrl)->with('notification', 'Bạn cần chọn sản phẩm để thực hiện thao tác');
            }
        } else {
            return redirect($preUrl)->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function slug(Request $request)
    {
        $str = $request->str;
        $slug = Str::slug($str, '-');
        return response()->json([
            'slug' => $slug,
        ]);
    }
    //Màu sắc sản phẩm  - Color
    public function color()
    {
        $colors = Color::where('id', '>', 1)->get();
        return view('admin.product.color', compact('colors'));
    }

    public function color_add(Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255', 'unique:colors'],
                    'color_code' => ['required', 'string', 'max:255', 'unique:colors'],
                ],
                [
                    'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                    'required' => ':attribute không được để trống',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                ],
                [
                    'name' => 'Tên màu',
                    'color_code' => 'Mã màu',
                ]
            );
            Color::create([
                'name' => $request->input('name'),
                'color_code' => $request->input('color_code'),
            ]);
            return redirect('admin/product/color')->with('notification', 'Đã thêm màu sắc thành công');
        } else {
            return redirect('admin/product/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function color_delete($id)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            Color::where('id', $id)->delete();
            return redirect('admin/product/color')->with('notification', 'Đã xóa màu sắc thành công');
        } else {
            return redirect('admin/product/color')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    //Danh mục cha - Cat_parrent
    public function cat_parent_list()
    {
        $cat_products = Cat_product::where(['parent_id' => 0, 'status' => 'public'])->get();
        return view('admin.product.cat_parent', compact('cat_products'));
    }

    public function cat_parent_add(Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255', 'unique:cat_products'],
                    'slug' => ['required', 'string', 'max:255', 'unique:cat_products'],
                ],
                [
                    'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                    'required' => ':attribute không được để trống',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                ],
                [
                    'name' => 'Tên danh mục',
                    'slug' => 'Đường dẫn',
                ]
            );
            Cat_product::create([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'status' => $request->input('status'),
                'parent_id' => 0,
                'has_child' => 0,
            ]);
            return redirect('admin/product/cat_parent/list')->with('notification', 'Đã thêm danh mục cha thành công');
        } else {
            return redirect('admin/product/cat_parent/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function cat_parent_delete($id)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $cat_child = Cat_product::where('parent_id', $id)->get();
            $cat_parent = Cat_product::find($id);
            if ($cat_parent->has_child == 0) {
                $cat_parent->delete();
                return redirect('admin/product/cat_parent/list')->with('notification', 'Đã xóa danh mục cha thành công');
            } else {
                $cat_parent->delete();
                foreach ($cat_child as $cat) {
                    $cat->update([
                        'status' => 'pending'
                    ]);
                }
                return redirect('admin/product/cat_parent/list')->with('notification', 'Đã xóa danh mục cha thành công, các danh mục con sẽ được chuyển vào các danh mục chưa duyệt');
            }
        } else {
            return redirect('admin/product/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }
    // Danh mục - Cat
    public function cat()
    {
        $cat_products = Cat_product::where('status', 'public')->get();
        function data_tree($data, $parent_id = 0, $level = 0)
        {
            $result = [];
            foreach ($data as $item) {
                if ($item['parent_id'] == $parent_id) {
                    $item['level'] = $level;
                    $result[] = $item;
                    $child = data_tree($data, $item['id'], $level + 1);
                    $result = array_merge($result, $child);
                }
            }
            return $result;
        }
        $list_cat = data_tree($cat_products);
        // return $list_cat;
        $cat_parent = Cat_product::where('parent_id', 0)->get();
        return view('admin.product.cat', compact('cat_parent', 'list_cat'));
    }

    public function cat_add(Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $cat_parent = Cat_product::where('parent_id', 0)->get();
            foreach ($cat_parent as $value) {
                $cat[] = $value->id;
            }
            $cat = implode(",", $cat);
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255', 'unique:cat_products'],
                    'slug' => ['required', 'string', 'max:255', 'unique:cat_products'],
                    'parent_id' => ['required', "in:$cat"],
                ],
                [
                    'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                    'required' => ':attribute không được để trống',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                    'in' => 'Vui lòng chọn :attribute'
                ],
                [
                    'name' => 'Tên danh mục',
                    'slug' => 'Đường dẫn',
                    'parent_id' => 'Danh mục cha'
                ]
            );
            Cat_product::create([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'status' => $request->input('status'),
                'parent_id' => $request->input('parent_id'),
                'has_child' => 0,
            ]);
            Cat_product::where('id', $request->input('parent_id'))->update([
                'has_child' => 1
            ]);
            if ($request->input('status') == 'public') {
                return redirect('admin/product/cat/list')->with('notification', 'Đã thêm danh mục thành công');
            } else {
                return redirect('admin/product/cat/list')->with('notification', 'Đã thêm danh mục thành công, danh mục được chuyển vào danh mục chưa duyệt');
            }
        } else {
            return redirect('admin/product/cat/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function delete_cat($id)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $product_cat = Cat_product::where(['parent_id' => $id, 'status' => 'public'])->get();
            // return $product_cat;
            if ($product_cat->count() > 0) {
                $cat_id = [];
                foreach ($product_cat as $cat) {
                    $cat_id[] = $cat->id;
                }
                Cat_product::where('id', $id)->delete();
                Cat_product::whereIn('id', $cat_id)->update([
                    'status' => 'pending'
                ]);
                return redirect('admin/product/cat/list')->with('notification', 'Đã xóa danh mục thành công');
            } else {
                $cat = Cat_product::find($id);
                $cat->delete();
                $product_cat = Cat_product::where(['parent_id' =>  $cat->parent_id, 'status' => 'public'])->get();
                if ($product_cat->count() == 0) {
                    Cat_product::where('id', $cat->parent_id)->update([
                        'has_child' => 0
                    ]);
                }
                return redirect('admin/product/cat/list')->with('notification', 'Đã xóa danh mục thành công');
            }
        } else {
            return redirect('admin/product/cat/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
        // if ($product_cat->count() == 0) {
        //     $cat_id = [];
        //     foreach ($product_cat as $cat) {
        //         $cat_id[] = $cat->id;
        //     }
        //     Cat_product::where('id', $id)->delete();
        //     Cat_product::whereIn('id', $cat_id)->update([
        //         'status' => 'pending'
        //     ]);
        // }
    }

    //Cat_pending
    public function cat_pending()
    {
        $cat_pending = Cat_product::where('status', 'pending')->get();
        return view('admin.product.cat_pending', compact('cat_pending'));
    }

    public function cat_pending_delete($id)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            Cat_product::where('id', $id)->delete();
            return redirect('admin/product/cat_pending/list')->with('notification', 'Đã xóa danh mục thành công');
        } else {
            return redirect('admin/product/cat_pending/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }
    public function cat_pending_edit($id)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $cat_parent = Cat_product::where(['parent_id' => 0, 'status' => 'public'])->get();
            $cat_edit = Cat_product::find($id);
            return view('admin.product.cat_pending_edit', compact('cat_parent', 'cat_edit'));
        } else {
            return redirect('admin/product/cat_pending/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function cat_pending_update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $cat_parent = Cat_product::where('parent_id', 0)->get();
            $cat_edit =  Cat_product::find($id);
            foreach ($cat_parent as $value) {
                $cat[] = $value->id;
            }
            $cat = implode(",", $cat);
            if ($cat_edit->parent_id != 0) {
                $request->validate(
                    [
                        'parent_id' => ['required', "in:$cat"],
                    ],
                    [
                        'required' => ':attribute không được để trống',
                        'in' => 'Vui lòng chọn :attribute'
                    ],
                    [
                        'parent_id' => 'Danh mục cha'
                    ]
                );
                Cat_product::where('id', $id)->update([
                    'status' => $request->input('status'),
                    'parent_id' => $request->input('parent_id'),
                    'has_child' => 0,
                ]);
                Cat_product::where('id', $request->input('parent_id'))->update([
                    'has_child' => 1
                ]);
            }

            if ($cat_edit->parent == 0) {
                Cat_product::where('id', $id)->update([
                    'status' => $request->input('status'),
                ]);
            }

            if ($request->input('status') == 'public') {
                return redirect('admin/product/cat/list')->with('notification', 'Đã thêm danh mục thành công');
            } else {
                return redirect('admin/product/cat_pending/list')->with('notification', 'Đã thêm danh mục thành công');
            }
        } else {
            return redirect('admin/product/cat_pending/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }
}
