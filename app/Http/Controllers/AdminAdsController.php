<?php

namespace App\Http\Controllers;

use App\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAdsController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'ads']);
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        $url_status = 'active';
        $adss = Ads::where('status', 'public')->paginate(5);
        $count_adss_active = Ads::where('status', 'public')->count();
        $count_adss_pending = Ads::where('status', 'pending')->count();
        $count_adss_trash = Ads::onlyTrashed()->count();
        $count = [$count_adss_active,  $count_adss_pending,  $count_adss_trash];
        return view('admin.ads.list', compact('adss', 'count', 'list_action', 'url_status'));
    }

    public function ads_pending(Request $request)
    {
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        $url_status = 'pending';
        $adss = Ads::where('status', 'pending')->paginate(5);
        $count_adss_active = Ads::where('status', 'public')->count();
        $count_adss_pending = Ads::where('status', 'pending')->count();
        $count_adss_trash = Ads::onlyTrashed()->count();
        $count = [$count_adss_active,  $count_adss_pending,  $count_adss_trash];

        return view('admin.ads.pending', compact('adss', 'count', 'list_action', 'url_status'));
    }

    public function ads_trash(Request $request)
    {
        $url_status = 'trash';
        $list_action = [
            'active' => 'Kích hoạt',
            'delete' => 'Xóa'
        ];
        $adss = Ads::onlyTrashed()->paginate(5);
        $count_adss_active = Ads::where('status', 'public')->count();
        $count_adss_pending = Ads::where('status', 'pending')->count();
        $count_adss_trash = Ads::onlyTrashed()->count();
        $count = [$count_adss_active,  $count_adss_pending,  $count_adss_trash];
        return view('admin.ads.list', compact('adss', 'count', 'list_action', 'url_status'));
    }

    public function add(Request $request)
    {
        return view('admin.ads.add');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $preUrl = url()->previous();
        if ($user->role->name == 'admintrator') {
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255', 'unique:ads,name'],
                    'thumbnail' => ['required', 'max:10000'],
                ],
                [
                    'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                    'required' => ':attribute không được để trống',
                    'thumbnail.max' => ':attribute có độ dài tối đa :max kb',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                ],
                [
                    'name' => 'Tên ads',
                    'thumbnail' => 'Hình ảnh ads',
                    'description' => 'Mô tả',
                ]
            );
            $input = $request->all();
            // dd($input);
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $file_name = $file->getClientOriginalName();
                $file->move('public/uploads/ads', $file_name);
                $thumbnail = 'public/uploads/ads/' . $file_name;
                $input['thumbnail'] = $thumbnail;
            }
            // dd($input);
            Ads::create($input);
            return redirect('admin/ads/list')->with('notification', 'Đã thêm ads thành công');
        } else {
            return redirect($preUrl)->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function disable($id)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $ads = Ads::find($id);
            $ads->delete();
            return redirect('admin/ads/list')->with('notification', 'Bạn đã vô hiệu ads thành công');
        } else {
            return redirect('admin/ads/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function delete($id)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            Ads::withTrashed()
                ->where('id', $id)
                ->forceDelete();
            return redirect('admin/ads/list')->with('notification', 'Bạn đã xóa ads thành công');
        } else {
            return redirect('admin/ads/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function action(Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $action = $request->input('action');
            $list_check = $request->input('list_check');
            $preUrl = url()->previous();
            if (!empty($list_check)) {
                if ($action == "") {
                    return redirect($preUrl)->with('notification', 'Bạn đã cần chọn thao tác để thực hiện');
                }
                if ($action == 'disable') {
                    $slider = Ads::whereIn('id', $list_check);
                    $slider->delete();
                    return redirect($preUrl)->with('notification', 'Bạn đã vô hiệu ads thành công');
                }
                if ($action == 'delete') {
                    Ads::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect($preUrl)->with('notification', 'Bạn đã vô hiệu ads thành công');
                }
                if ($action == 'active') {
                    Ads::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    return redirect($preUrl)->with('notification', 'Bạn đã khôi phục ads thành công');
                }
            } else {
                return redirect($preUrl)->with('notification', 'Bạn cần chọn ads để thực hiện thao tác');
            }
        } else {
            return redirect('admin/ads/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function edit($id)
    {
        $ads = Ads::find($id);
        // dd($slider);
        return view('admin.ads.edit', compact('ads'));
    }
    public function update($id, Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $slider = Ads::find($id);
            $request->validate(
                [
                    'name' => ['string', 'max:255', 'unique:ads,name,' . $id],
                    'thumbnail' => ['max:10000'],
                ],
                [
                    'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                    'required' => ':attribute không được để trống',
                    'thumbnail.max' => ':attribute có độ dài tối đa :max kb',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                ],
                [
                    'name' => 'Tên ads',
                    'thumbnail' => 'Hình ảnh ads',
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
                $file->move('public/uploads/ads', $file_name);
                $thumbnail = 'public/uploads/ads/' . $file_name;
                $input['thumbnail'] = $thumbnail;
            }
            // dd($input);
            Ads::where('id', $id)->update($input);
            return redirect('admin/ads/list')->with('notification', 'Đã thêm cập nhật ads thành công');
        } else {
            return redirect('admin/ads/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }
}
