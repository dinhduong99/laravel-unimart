<?php

namespace App\Http\Controllers;

use App\Cat_post;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPostController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);
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
        $posts = Post::where('name', 'LIKE', "%{$keyword}%")->paginate(5);
        $count_all = Post::count();
        $count_active = Post::where('status', 'public')->count();
        $count_pending = Post::where('status', 'pending')->count();
        $count_trash = Post::onlyTrashed()->count();
        $count = [
            'all' => $count_all,
            'active' => $count_active,
            'pending' => $count_pending,
            'trash' => $count_trash,
        ];
        return view('admin.post.list', compact('posts', 'count', 'list_action', 'url_status'));
    }

    public function approved(Request $request)
    {
        $keyword = "";
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        $url_status = 'active';
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $posts = Post::where('status', 'public')->where('name', 'LIKE', "%{$keyword}%")->paginate(5);
        $count_all = Post::count();
        $count_active = Post::where('status', 'public')->count();
        $count_pending = Post::where('status', 'pending')->count();
        $count_trash = Post::onlyTrashed()->count();
        $count = [
            'all' => $count_all,
            'active' => $count_active,
            'pending' => $count_pending,
            'trash' => $count_trash,
        ];
        return view('admin.post.approved', compact('posts', 'count', 'list_action', 'url_status'));
    }

    public function  trash(Request $request)
    {
        $keyword = "";
        $list_action = [
            'active' => 'Kích hoạt',
            'delete' => 'Xóa',
        ];
        $url_status = 'trash';
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $posts = Post::onlyTrashed()->where('name', 'LIKE', "%{$keyword}%")->paginate(5);
        $count_all = Post::count();
        $count_active = Post::where('status', 'public')->count();
        $count_pending = Post::where('status', 'pending')->count();
        $count_trash = Post::onlyTrashed()->count();
        $count = [
            'all' => $count_all,
            'active' => $count_active,
            'pending' => $count_pending,
            'trash' => $count_trash,
        ];
        return view('admin.post.trash', compact('posts', 'count', 'list_action', 'url_status'));
    }

    public function pending(Request $request)
    {
        $keyword = "";
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        $url_status = 'pending';
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $posts = Post::where('status', 'pending')->where('name', 'LIKE', "%{$keyword}%")->paginate(5);
        $count_all = Post::count();
        $count_active = Post::where('status', 'public')->count();
        $count_pending = Post::where('status', 'pending')->count();
        $count_trash = Post::onlyTrashed()->count();
        $count = [
            'all' => $count_all,
            'active' => $count_active,
            'pending' => $count_pending,
            'trash' => $count_trash,
        ];
        return view('admin.post.pending', compact('posts', 'count', 'list_action', 'url_status'));
    }

    public function edit($id)
    {
        $list_cat = Cat_post::where('status', 'public')->get();
        $post = Post::find($id);
        return view('admin.post.edit', compact('list_cat', 'post'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $Post = Post::find($id);
            $cat_posts = Cat_post::where('status', 'public')->get();
            foreach ($cat_posts as $value) {
                $cats[] = $value->id;
            }
            $cats = implode(",", $cats);
            $preUrl = url()->previous();
            $request->validate(
                [
                    'name' => 'required|string|max:255|unique:posts,name,' . $id,
                    'slug' => 'required|string|max:255|unique:posts,slug,' . $id,
                    'post_cat_id' => ['required', "in:$cats"],
                    'thumbnail' => ['max:10000'],
                    'description' => ['required', 'string',],
                ],
                [
                    'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                    'required' => ':attribute không được để trống',
                    'thumbnail.max' => ':attribute có độ dài tối đa :max kb',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                    'in' => 'Vui lòng chọn :attribute'
                ],
                [
                    'name' => 'Tên tiêu đề bài viết',
                    'slug' => 'Đường dẫn',
                    'post_cat_id' => 'Danh mục bài viết',
                    'thumbnail' => 'Hình ảnh bài viết',
                    'description' => 'Mô tả bài viết',
                ]
            );
            // dd($request->all());
            $request->offsetUnset('_token');
            $request->offsetUnset('btn-update');
            $input = $request->all();

            if ($request->hasFile('thumbnail')) {
                $thumbnail_old = $Post->thumbnail;
                if (file_exists($thumbnail_old)) {
                    unlink($thumbnail_old);
                };
                $file = $request->file('thumbnail');
                $file_name = $file->getClientOriginalName();
                $file->move('public/uploads', $file_name);
                $thumbnail = 'public/uploads/' . $file_name;
                $input['thumbnail'] = $thumbnail;
            }
            Post::where('id', $id)->update($input);
            return redirect('admin/post/list')->with('notification', 'Đã cập nhật bài viết thành công');
        } else {
            return redirect("admin/post/list")->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }


    public function disable($id)
    {
        $preUrl = url()->previous();
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $post = Post::find($id);
            $post->delete();
            return redirect($preUrl)->with('notification', 'Bài viết đã được vô hiệu hóa thành công');
        } else {
            return redirect($preUrl)->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function delete($id)
    {
        $preUrl = url()->previous();
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            Post::withTrashed()
                ->where('id', $id)
                ->forceDelete();
            return redirect($preUrl)->with('notification', 'Bài viết đã được xóa thành công');
        } else {
            return redirect($preUrl)->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function add()
    {
        $list_cat = Cat_post::where('status', 'public')->get();
        return view('admin.post.add', compact('list_cat'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $cat_posts = Cat_post::where('status', 'public')->get();
            foreach ($cat_posts as $value) {
                $cats[] = $value->id;
            }
            $cats = implode(",", $cats);
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255', 'unique:posts'],
                    'slug' => ['required', 'string', 'max:255', 'unique:posts'],
                    'post_cat_id' => ['required', "in:$cats"],
                    'thumbnail' => ['required', 'max:10000'],
                    'description' => ['required', 'string',],
                ],
                [
                    'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                    'required' => ':attribute không được để trống',
                    'thumbnail.max' => ':attribute có độ dài tối đa :max kb',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                    'in' => 'Vui lòng chọn :attribute'
                ],
                [
                    'name' => 'Tên tiêu đề bài viết',
                    'slug' => 'Đường dẫn',
                    'post_cat_id' => 'Danh mục bài viết',
                    'thumbnail' => 'Hình ảnh bài viết',
                    'description' => 'Mô tả bài viết',
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
            Post::create($input);
            // print_r($input);
            // dd($input);
            return redirect('admin/post/list')->with('notification', 'Đã thêm bài viết thành công');
        } else {
            return redirect('admin/post/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }


    public function action(Request $request)
    {
        $user = Auth::user();
        $preUrl = url()->previous();
        if ($user->role->name == 'admintrator') {
            $list_check = $request->input('list_check');
            // dd($list_check);
            $action = $request->input('action');

            // dd($action);
            if ($list_check) {
                $action = $request->input('action');
                if ($action == "") {
                    return redirect($preUrl)->with('notification', 'Bạn đã cần chọn thao tác để thực hiện');
                }
                if ($action == "disable") {
                    Post::destroy($list_check);
                    return redirect($preUrl)->with('notification', 'Bạn đã vô hiệu hóa bài viết thành công');
                }
                if ($action == "active") {
                    Post::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    return redirect($preUrl)->with('notification', 'Bạn đã kích hoạt bài viết thành công');
                }
                if ($action == "delete") {
                    Post::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect($preUrl)->with('notification', 'Bạn đã xóa bài viết thành công');
                }
            } else {
                return redirect($preUrl)->with('notification', 'Bạn cần chọn bài viết để thực hiện thao tác');
            }
        } else {
            return redirect($preUrl)->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }
    //Danh mục Posts
    public function cat()
    {
        $list_cat = Cat_post::where('status', 'public')->get();
        return view('admin.post.cat', compact('list_cat'));
    }

    public function cat_add(Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255', 'unique:cat_posts'],
                    'slug' => ['required', 'string', 'max:255', 'unique:cat_posts'],
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
            Cat_post::create([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'status' => $request->input('status'),
                'parent_id' => 0,
                'has_child' => 0,
            ]);
            return redirect('admin/post/cat/list')->with('notification', 'Đã thêm danh mục cha thành công');
        } else {
            return redirect('admin/post/cat/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }
}
