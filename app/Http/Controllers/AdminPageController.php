<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'page']);
            return $next($request);
        });
    }
    public function add()
    {
        return view('admin.page.add');
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $preUrl = url()->previous();
        if ($user->role->name == 'admintrator') {
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255', 'unique:pages,name'],
                    'slug' => ['required', 'string', 'max:255', 'unique:pages'],
                    'description' => ['required', 'string'],
                ],
                [
                    'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                    'required' => ':attribute không được để trống',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                ],
                [
                    'name' => 'Tiêu đề trang',
                    'slug' => 'Đường dẫn',
                    'description' => 'Nội dung',
                ]
            );
            $input = $request->all();
            Page::create($input);
            return redirect('admin/page/list')->with('notification', 'Đã thêm page thành công');
        } else {
            return redirect($preUrl)->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function list()
    {
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        $url_status = 'active';
        $pages = Page::where('status', 'public')->paginate(5);
        $count_page_active = Page::where('status', 'public')->count();
        $count_page_pending = Page::where('status', 'pending')->count();
        $count_page_trash = Page::onlyTrashed()->count();
        $count = [$count_page_active,  $count_page_pending,  $count_page_trash];
        return view('admin.page.list', compact('pages', 'count', 'list_action', 'url_status'));
    }

    public function pending()
    {
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        $url_status = 'pending';
        $pages = Page::where('status', 'pending')->paginate(5);
        $count_page_active = Page::where('status', 'public')->count();
        $count_page_pending = Page::where('status', 'pending')->count();
        $count_page_trash = Page::onlyTrashed()->count();
        $count = [$count_page_active,  $count_page_pending,  $count_page_trash];
        return view('admin.page.list', compact('pages', 'count', 'list_action', 'url_status'));
    }

    public function trash()
    {
        $url_status = 'trash';
        $list_action = [
            'active' => 'Kích hoạt',
            'delete' => 'Xóa'
        ];
        $pages = Page::onlyTrashed()->paginate(5);
        $count_page_active = Page::where('status', 'public')->count();
        $count_page_pending = Page::where('status', 'pending')->count();
        $count_page_trash = Page::onlyTrashed()->count();
        $count = [$count_page_active,  $count_page_pending,  $count_page_trash];
        return view('admin.page.list', compact('pages', 'count', 'list_action', 'url_status'));
    }


    public function disable($id)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $page = Page::find($id);
            $page->delete();
            return redirect('admin/page/list')->with('notification', 'Bạn đã vô hiệu page thành công');
        } else {
            return redirect('admin/page/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function delete($id)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            Page::withTrashed()
                ->where('id', $id)
                ->forceDelete();
            return redirect('admin/page/list')->with('notification', 'Bạn đã xóa page thành công');
        } else {
            return redirect('admin/page/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
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
                    $page = Page::whereIn('id', $list_check);
                    $page->delete();
                    return redirect($preUrl)->with('notification', 'Bạn đã vô hiệu page thành công');
                }
                if ($action == 'delete') {
                    Page::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect($preUrl)->with('notification', 'Bạn đã vô hiệu page thành công');
                }
                if ($action == 'active') {
                    Page::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    return redirect($preUrl)->with('notification', 'Bạn đã khôi phục page thành công');
                }
            } else {
                return redirect($preUrl)->with('notification', 'Bạn cần chọn page để thực hiện thao tác');
            }
        } else {
            return redirect('admin/page/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function edit($id)
    {
        $page = Page::find($id);
        return view('admin.page.edit', compact('page'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255', 'unique:pages,name,' . $id],
                    'slug' => ['required', 'string', 'max:255', 'unique:pages,slug' . $id],
                    'description' => ['required', 'string']
                ],
                [
                    'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                    'required' => ':attribute không được để trống',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                ],
                [
                    'name' => 'Tiêu đề trang',
                    'slug' => 'Đường dẫn',
                    'description' => 'Nội dung',
                ]
            );
            $request->offsetUnset('_token');
            $input = $request->all();
            Page::where('id', $id)->update($input);
            return redirect('admin/page/list')->with('notification', 'Đã thêm cập nhật ads thành công');
        } else {
            return redirect('admin/page/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
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
}
