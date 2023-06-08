<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSliderController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slider']);
            return $next($request);
        });
    }

    // public function list(Request $request)
    // {
    //     $status = $request->input('status');
    //     $list_action = [
    //         'disable' => 'Vô hiệu hóa',
    //     ];
    //     $url_status = 'active';
    //     if ($status == 'trash') {
    //         $url_status = 'trash';
    //         $list_action = [
    //             'active' => 'Kích hoạt',
    //             'delete' => 'Xóa'
    //         ];
    //         $sliders = Slider::onlyTrashed()->paginate(5);
    //     } else {
    //         $sliders = Slider::where('status', 'public')->paginate(5);
    //     }
    //     $count_users_active = Slider::count();
    //     $count_users_trash = Slider::onlyTrashed()->count();
    //     $count = [$count_users_active,  $count_users_trash];
    //     return view('admin.slider.list', compact('sliders', 'count', 'list_action', 'url_status'));
    // }

    public function list(Request $request)
    {
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        $url_status = 'active';
        $sliders = Slider::where('status', 'public')->paginate(5);
        $count_users_active = Slider::where('status', 'public')->count();
        $count_users_pending = Slider::where('status', 'pending')->count();
        $count_users_trash = Slider::onlyTrashed()->count();
        $count = [$count_users_active, $count_users_pending,  $count_users_trash];
        return view('admin.slider.list', compact('sliders', 'count', 'list_action', 'url_status'));
    }

    public function pending(Request $request)
    {
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        $url_status = 'pending';
        $sliders = Slider::where('status', 'pending')->paginate(5);
        $count_users_active = Slider::where('status', 'public')->count();
        $count_users_pending = Slider::where('status', 'pending')->count();
        $count_users_trash = Slider::onlyTrashed()->count();
        $count = [$count_users_active, $count_users_pending,  $count_users_trash];
        return view('admin.slider.pending', compact('sliders', 'count', 'list_action', 'url_status'));
    }

    public function trash(Request $request)
    {
        $url_status = 'trash';
        $list_action = [
            'active' => 'Kích hoạt',
            'delete' => 'Xóa'
        ];
        $sliders = Slider::onlyTrashed()->paginate(5);
        $count_users_active = Slider::where('status', 'public')->count();
        $count_users_pending = Slider::where('status', 'pending')->count();
        $count_users_trash = Slider::onlyTrashed()->count();
        $count = [$count_users_active, $count_users_pending,  $count_users_trash];
        return view('admin.slider.trash', compact('sliders', 'count', 'list_action', 'url_status'));
    }

    public function add()
    {
        return view('admin.slider.add');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255', 'unique:sliders,name'],
                    'thumbnail' => ['required', 'max:10000'],

                ],
                [
                    'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                    'required' => ':attribute không được để trống',
                    'thumbnail.max' => ':attribute có độ dài tối đa :max kb',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                ],
                [
                    'name' => 'Tên slider',
                    'thumbnail' => 'Hình ảnh slider',
                    'description' => 'Mô tả',
                ]
            );
            $input = $request->all();
            // dd($input);
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $file_name = $file->getClientOriginalName();
                $file->move('public/uploads/slider', $file_name);
                $thumbnail = 'public/uploads/slider/' . $file_name;
                $input['thumbnail'] = $thumbnail;
            }
            // dd($input);
            Slider::create($input);
            return redirect('admin/slider/list')->with('notification', 'Đã thêm slider thành công');
        } else {
            return redirect('admin/slider/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function disable($id)
    {
        $preUrl = url()->previous();
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $slider = Slider::find($id);
            $slider->delete();
            return redirect($preUrl)->with('notification', 'Bạn đã vô hiệu slider thành công');
        } else {
            return redirect($preUrl)->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function delete($id)
    {
        $preUrl = url()->previous();
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            Slider::withTrashed()
                ->where('id', $id)
                ->forceDelete();
            return redirect($preUrl)->with('notification', 'Bạn đã xóa slider thành công');
        } else {
            return redirect($preUrl)->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function action(Request $request)
    {
        $user = Auth::user();
        $preUrl = url()->previous();
        if ($user->role->name == 'admintrator') {
            $action = $request->input('action');
            $list_check = $request->input('list_check');
            if (!empty($list_check)) {
                if ($action == 'disable') {
                    $slider = Slider::whereIn('id', $list_check);
                    $slider->delete();
                    return redirect('admin/slider/list')->with('notification', 'Bạn đã vô hiệu slider thành công');
                }
                if ($action == 'delete') {
                    Slider::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect('admin/slider/list')->with('notification', 'Bạn đã vô hiệu slider thành công');
                }
                if ($action == 'active') {
                    Slider::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    return redirect($preUrl)->with('notification', 'Bạn đã khôi phục slider thành công');
                }
            } else {
                return redirect($preUrl)->with('notification', 'Bạn cần chọn slider để thực hiện thao tác');
            }
        } else {
            return redirect($preUrl)->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function edit($id)
    {
        $slider = Slider::find($id);
        // dd($slider);
        return view('admin.slider.edit', compact('slider'));
    }
    public function update($id, Request $request)
    {
        $preUrl = url()->previous();
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $slider = Slider::find($id);
            $request->validate(
                [
                    'name' => ['string', 'max:255', 'unique:sliders,name,' . $id],
                    'thumbnail' => ['max:10000'],
                ],
                [
                    'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                    'thumbnail.max' => ':attribute có độ dài tối đa :max kb',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                ],
                [
                    'name' => 'Tên slider',
                    'thumbnail' => 'Hình ảnh slider',
                    'description' => 'Mô tả',
                ]
            );
            $request->offsetUnset('_token');
            $input = $request->all();
            // dd($input);
            if ($request->hasFile('thumbnail')) {
                $thumbnail_old = $slider->thumbnail;
                if (file_exists($thumbnail_old)) {
                    unlink($thumbnail_old);
                };
                $file = $request->file('thumbnail');
                $file_name = $file->getClientOriginalName();
                $file->move('public/uploads/slider', $file_name);
                $thumbnail = 'public/uploads/slider/' . $file_name;
                $input['thumbnail'] = $thumbnail;
            }
            // dd($input);
            Slider::where('id', $id)->update($input);
            return redirect('admin/slider/list')->with('notification', 'Đã thêm cập nhật slider thành công');
        } else {
            return redirect('admin/slider/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }
}
