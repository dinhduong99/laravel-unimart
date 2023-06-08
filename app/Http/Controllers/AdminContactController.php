<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminContactController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'contact']);
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $keyword = "";
        $url_status = 'active';
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        if ($request->input('keyword')) {
            $request = $request->input('keyword');
        }
        $contacts = Contact::where('fullname', 'LIKE', "%{$keyword}%")->paginate(5);
        $count_active =  Contact::count();
        $count_pending = Contact::where('status', 'pending')->count();
        $count_approved = Contact::where('status', 'approved')->count();
        $count_trash = Contact::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'pending' => $count_pending,
            'approved' => $count_approved,
            'trash' => $count_trash,
        ];
        return view('admin.contact.list', compact('contacts', 'url_status', 'list_action', 'count'));
    }

    public function contact_pending(Request $request)
    {
        $keyword = "";
        $url_status = 'pending';
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        if ($request->input('keyword')) {
            $request = $request->input('keyword');
        }
        $contacts = Contact::where('status', 'pending')->where('fullname', 'LIKE', "%{$keyword}%")->paginate(5);
        $count_active =  Contact::count();
        $count_pending = Contact::where('status', 'pending')->count();
        $count_approved = Contact::where('status', 'approved')->count();
        $count_trash = Contact::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'pending' => $count_pending,
            'approved' => $count_approved,
            'trash' => $count_trash,
        ];
        return view('admin.contact.pending', compact('contacts', 'url_status', 'list_action', 'count'));
    }

    public function contact_approved(Request $request)
    {
        $keyword = "";
        $url_status = 'approved';
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        if ($request->input('keyword')) {
            $request = $request->input('keyword');
        }
        $contacts = Contact::where('status', 'approved')->where('fullname', 'LIKE', "%{$keyword}%")->paginate(5);
        $count_active =  Contact::count();
        $count_pending = Contact::where('status', 'pending')->count();
        $count_approved = Contact::where('status', 'approved')->count();
        $count_trash = Contact::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'pending' => $count_pending,
            'approved' => $count_approved,
            'trash' => $count_trash,
        ];
        return view('admin.contact.approved', compact('contacts', 'url_status', 'list_action', 'count'));
    }

    public function contact_trash(Request $request)
    {
        $keyword = "";
        $url_status = 'trash';
        $list_action = [
            'active' => 'Kích hoạt',
            'delete' => 'Xóa',
        ];
        if ($request->input('keyword')) {
            $request = $request->input('keyword');
        }
        $contacts = Contact::onlyTrashed()->where('fullname', 'LIKE', "%{$keyword}%")->paginate(5);
        $count_active =  Contact::count();
        $count_pending = Contact::where('status', 'pending')->count();
        $count_approved = Contact::where('status', 'approved')->count();
        $count_trash = Contact::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'pending' => $count_pending,
            'approved' => $count_approved,
            'trash' => $count_trash,
        ];
        return view('admin.contact.trash', compact('contacts', 'url_status', 'list_action', 'count'));
    }

    public function edit(Request $request, $id)
    {
        $contact = Contact::find($id);
        return view('admin.contact.edit', compact('contact'));
    }

    public function update_status(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $contact = Contact::find($id);
            if ($request->input('select-status')) {
                $status = $request->input('select-status');
                $contact->update([
                    'status' =>  $status
                ]);
            }
            return redirect('admin/contact/list')->with('notification', 'Cập nhật tình trạng liên hệ thành công');
        } else {
            return redirect('admin/contactlist')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function disable($id)
    {
        $user = Auth::user();
        $preUrl = url()->previous();
        if ($user->role->name == 'admintrator') {
            $contact = Contact::find($id);
            $contact->delete();
            return redirect($preUrl)->with('notification', 'Liên hệ đã được vô hiệu hóa thành công');
        } else {
            return redirect($preUrl)->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function delete($id)
    {
        $user = Auth::user();
        $preUrl = url()->previous();
        if ($user->role->name == 'admintrator') {
            Contact::withTrashed()
                ->where('id', $id)
                ->forceDelete();
            return redirect($preUrl)->with('notification', 'Liên hệ đã được xóa thành công');
        } else {
            return redirect($preUrl)->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function action(Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'admintrator') {
            $action = $request->input('action');
            $list_check = $request->input('list_check');
            if (!empty($list_check)) {
                if ($action == 'disable') {
                    $Order = Contact::whereIn('id', $list_check);
                    $Order->delete();
                    return redirect('admin/contact/list')->with('notification', 'Bạn đã vô hiệu liên hệ thành công');
                }
                if ($action == 'delete') {
                    Contact::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect('admin/contact/list')->with('notification', 'Bạn đã vô hiệu liên hệ thành công');
                }
                if ($action == 'active') {
                    Contact::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    return redirect('admin/contact/list')->with('notification', 'Bạn đã khôi phục liên hệ thành công');
                }
            } else {
                return redirect('admin/contact/list')->with('notification', 'Bạn cần chọn liên hệ để thực hiện thao tác');
            }
        } else {
            return redirect('admin/contact/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }
}
