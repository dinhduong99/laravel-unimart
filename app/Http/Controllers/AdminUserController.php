<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;

class AdminUserController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $status = $request->input('status');
            $list_action = [
                'disable' => 'Vô hiệu hóa',
            ];
            $url_status = 'active';
            if ($status == 'trash') {
                $url_status = 'trash';
                $list_action = [
                    'active' => 'Kích hoạt',
                    'delete' => 'Xóa'
                ];
                $keyword = "";
                if ($request->input('keyword')) {
                    $keyword = $request->input('keyword');
                }
                $users = User::onlyTrashed()->where('name', 'LIKE', "%{$keyword}%")->paginate(5);
            } else {
                $keyword = "";
                if ($request->input('keyword')) {
                    $keyword = $request->input('keyword');
                }
                $users = User::where('name', 'LIKE', "%{$keyword}%")->paginate(5);
            }
            $count_users_active = User::count();
            $count_users_trash = User::onlyTrashed()->count();
            $count = [$count_users_active,  $count_users_trash];
            return view('admin.user.list', compact('users', 'count', 'list_action', 'url_status'));
        } else {
            return redirect('dashboard')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function add()
    {
        $roles = Role::all();
        return view('admin.user.add', compact('roles'));
    }

    public function store(Request $request)
    {
        $roles = Role::all();
        $role_id = [];
        foreach ($roles as $role) {
            $role_id[] = $role->id;
        }
        $role_id = implode(",", $role_id);
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'password_confirmation' => ['required', 'string', 'min:8'],
                'role_id' => ['required', "in:$role_id"]
            ],
            [
                'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'confirmed' => 'Xác nhận mật khẩu không thành công',
                'in' => 'Phân quyền cho thành viên',
            ],
            [
                'name' => 'Họ và tên',
                'email' => 'Địa chỉ email',
                'password' => 'Mật khẩu',
                'password_confirmation' => 'Xác nhận mật khẩu',
                'role_id' => 'Phân quyền'

            ]
        );
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $request->input('role_id'),
        ]);
        return redirect('admin/user/list')->with('notification', 'Đã thêm thành viên thành công');
    }

    public function disable($id)
    {
        if (Auth::id() != $id) {
            $user = User::find($id);
            $user->delete();
            return redirect('admin/user/list')->with('notification', 'Bạn đã vô hiệu tài khoản của thành viên thành công');
        } else {
            return redirect('admin/user/list')->with('notification', 'Bạn không thể tự vô hiệu mình ra khỏi hệ thống');
        }
    }
    public function delete($id)
    {
        User::withTrashed()
            ->where('id', $id)
            ->forceDelete();
        return redirect('admin/user/list')->with('notification', 'Bạn đã xóa thành viên ra khỏi hệ thống thành công');
    }
    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        $action = $request->input('action');
        // dd($action);
        // return $list_check;
        if ($list_check) {
            foreach ($list_check as $k => $id) {
                if (Auth::id() == $id) {
                    unset($list_check[$k]);
                }
            }
            if (!empty($list_check)) {
                $action = $request->input('action');
                $url_status = $request->input('url_status');
                // return $url_status;
                if ($action == "") {
                    if ($url_status == "trash") {
                        return redirect('admin/user/list?status=trash')->with('notification', 'Bạn đã cần chọn thao tác để thực hiện');
                    }
                    if ($url_status == "active") {
                        return redirect('admin/user/list')->with('notification', 'Bạn đã cần chọn thao tác để thực hiện');
                    }
                }
                if ($action == 'active') {
                    User::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    return redirect('admin/user/list')->with('notification', 'Bạn đã khôi phục thành viên thành công');
                }
                if ($action == 'disable') {
                    User::destroy($list_check);
                    return redirect('admin/user/list')->with('notification', 'Bạn đã vô hiệu hóa tài khoản thành viên thành công');
                }
                if ($action == 'delete') {
                    User::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect('admin/user/list')->with('notification', 'Bạn đã xóa thành viên ra khỏi hệ thống thành công');
                }
            }
            return redirect('admin/user/list')->with('notification', 'Bạn không thể thao tác trên chính tài khoản của bạn');
        } else {
            return redirect('admin/user/list')->with('notification', 'Bạn cần chọn thành viên để thực hiện thao tác');
        }
    }
    public function edit($id)
    {
        $roles = Role::all();
        $user = User::find($id);
        return view('admin.user.edit', compact('roles', 'user'));
    }
    public function update(Request $request, $id)
    {
        // $roles = Role::all();
        // $role_id = [];
        // foreach ($roles as $role) {
        //     $role_id[] = $role->id;
        // }
        // $role_id = implode(",", $role_id);
        // $request->validate(
        //     [
        //         'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $id],
        //         'password' => ['string', 'min:8', 'confirmed'],
        //         'password_confirmation' => ['string', 'min:8'],
        //         'role_id' => ['required', "in:$role_id"]
        //     ],
        //     [
        //         'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
        //         'required' => ':attribute không được để trống',
        //         'min' => ':attribute có độ dài ít nhất :min ký tự',
        //         'max' => ':attribute có độ dài tối đa :max ký tự',
        //         'confirmed' => 'Xác nhận mật khẩu không thành công',
        //         'in' => 'Phân quyền cho thành viên',
        //     ],
        //     [
        //         'name' => 'Họ và tên',
        //         'password' => 'Mật khẩu',
        //         'password_confirmation' => 'Xác nhận mật khẩu',
        //         'role_id' => 'Phân quyền'
        //     ]
        // );
        // User::where('id', $id)->update([
        //     'name' => $request->input('name'),
        //     'password' => Hash::make($request->input('password')),
        //     'role_id' => $request->input('role_id'),
        // ]);
        // return redirect('admin/user/list')->with('notification', 'Đã thêm cập nhật thành công');
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $roles = Role::all();
            $role_id = [];
            foreach ($roles as $role) {
                $role_id[] = $role->id;
            }
            $role_id = implode(",", $role_id);
            // if ($request->input('name')) {

            // }

            if ($request->input('password')) {
                $request->validate(
                    [
                        'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $id],
                        'password' => ['string', 'min:8', 'confirmed'],
                        'password_confirmation' => ['string', 'min:8'],
                        'role_id' => ['required', "in:$role_id"]
                    ],
                    [
                        'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                        'required' => ':attribute không được để trống',
                        'min' => ':attribute có độ dài ít nhất :min ký tự',
                        'max' => ':attribute có độ dài tối đa :max ký tự',
                        'confirmed' => 'Xác nhận mật khẩu không thành công',
                        'in' => 'Phân quyền cho thành viên',
                    ],
                    [
                        'name' => 'Họ và tên',
                        'password' => 'Mật khẩu',
                        'password_confirmation' => 'Xác nhận mật khẩu',
                        'role_id' => 'Phân quyền'
                    ]
                );
                User::where('id', $id)->update([
                    'name' => $request->input('name'),
                    'password' => Hash::make($request->input('password')),
                    'role_id' => $request->input('role_id'),
                ]);
                return redirect('admin/user/list')->with('notification', 'Đã thêm cập nhật thành công');
            } else {
                $request->validate(
                    [
                        'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $id],
                        'role_id' => ['required', "in:$role_id"]
                    ],
                    [
                        'unique' => ':attribute đã tồn tại trong hệ thống, vui lòng chọn :attribute mới',
                        'required' => ':attribute không được để trống',
                        'min' => ':attribute có độ dài ít nhất :min ký tự',
                        'max' => ':attribute có độ dài tối đa :max ký tự',
                        'in' => 'Phân quyền cho thành viên',
                    ],
                    [
                        'name' => 'Họ và tên',
                        'role_id' => 'Phân quyền'
                    ]
                );
                User::where('id', $id)->update([
                    'name' => $request->input('name'),
                    'role_id' => $request->input('role_id'),
                ]);
                return redirect('admin/user/list')->with('notification', 'Đã thêm cập nhật thành công');
            }
        } else {
            return redirect('/dashboard')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }
}
