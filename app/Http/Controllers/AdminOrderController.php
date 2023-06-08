<?php

namespace App\Http\Controllers;

use App\Order;
use App\Loyal_customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Ramsey\Uuid\v1;

class AdminOrderController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
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
            $keyword = $request->input('keyword');
        }
        $orders = Order::where('fullname', 'LIKE', "%{$keyword}%")->orwhere('code', 'LIKE', "%{$keyword}%")->orderBy('created_at', 'desc')->paginate(5);
        $count_active = Order::count();
        $count_complete = Order::where('status', 'complete')->count();
        $count_delivering = Order::where('status', 'delivering')->count();
        $count_processing = Order::where('status', 'processing')->count();
        $count_cancel = Order::where('status', 'cancel')->count();
        $count_trash = Order::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'complete' => $count_complete,
            'delivering' => $count_delivering,
            'processing' => $count_processing,
            'cancel' => $count_cancel,
            'trash' => $count_trash,
        ];
        return view('admin.order.list', compact('orders', 'list_action', 'url_status', 'count'));
    }

    public function order_complete(Request $request)
    {
        $keyword = "";
        $url_status = 'complete';
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $orders = Order::where('status', 'complete')->where('fullname', 'LIKE', "%{$keyword}%")->where('code', 'LIKE', "%{$keyword}%")->orderBy('created_at', 'desc')->paginate(5);
        $count_active = Order::count();
        $count_complete = Order::where('status', 'complete')->count();
        $count_delivering = Order::where('status', 'delivering')->count();
        $count_processing = Order::where('status', 'processing')->count();
        $count_cancel = Order::where('status', 'cancel')->count();
        $count_trash = Order::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'complete' => $count_complete,
            'delivering' => $count_delivering,
            'processing' => $count_processing,
            'cancel' => $count_cancel,
            'trash' => $count_trash,
        ];
        return view('admin.order.order_complete', compact('orders', 'list_action', 'url_status', 'count'));
    }

    public function order_delivering(Request $request)
    {
        $keyword = "";
        $url_status = 'delivering';
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $orders = Order::where('status', 'delivering')->where('fullname', 'LIKE', "%{$keyword}%")->where('code', 'LIKE', "%{$keyword}%")->orderBy('created_at', 'desc')->paginate(5);
        $count_active = Order::count();
        $count_complete = Order::where('status', 'complete')->count();
        $count_delivering = Order::where('status', 'delivering')->count();
        $count_processing = Order::where('status', 'processing')->count();
        $count_cancel = Order::where('status', 'cancel')->count();
        $count_trash = Order::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'complete' => $count_complete,
            'delivering' => $count_delivering,
            'processing' => $count_processing,
            'cancel' => $count_cancel,
            'trash' => $count_trash,
        ];
        return view('admin.order.order_delivering', compact('orders', 'list_action', 'url_status', 'count'));
    }

    public function order_processing(Request $request)
    {
        $keyword = "";
        $url_status = 'processing';
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $orders = Order::where('status', 'processing')->where('fullname', 'LIKE', "%{$keyword}%")->where('code', 'LIKE', "%{$keyword}%")->orderBy('created_at', 'desc')->paginate(5);
        $count_active = Order::count();
        $count_complete = Order::where('status', 'complete')->count();
        $count_delivering = Order::where('status', 'delivering')->count();
        $count_processing = Order::where('status', 'processing')->count();
        $count_cancel = Order::where('status', 'cancel')->count();
        $count_trash = Order::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'complete' => $count_complete,
            'delivering' => $count_delivering,
            'processing' => $count_processing,
            'cancel' => $count_cancel,
            'trash' => $count_trash,
        ];
        return view('admin.order.order_processing', compact('orders', 'list_action', 'url_status', 'count'));
    }

    public function order_trash(Request $request)
    {
        $keyword = "";
        $url_status = 'trash';
        $list_action = [
            'active' => 'Kích hoạt',
            'delete' => 'Xóa',
        ];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $orders = Order::onlyTrashed()->where('fullname', 'LIKE', "%{$keyword}%")->where('code', 'LIKE', "%{$keyword}%")->paginate(5);
        $count_active = Order::count();
        $count_complete = Order::where('status', 'complete')->count();
        $count_delivering = Order::where('status', 'delivering')->count();
        $count_processing = Order::where('status', 'processing')->count();
        $count_cancel = Order::where('status', 'cancel')->count();
        $count_trash = Order::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'complete' => $count_complete,
            'delivering' => $count_delivering,
            'processing' => $count_processing,
            'cancel' => $count_cancel,
            'trash' => $count_trash,
        ];
        return view('admin.order.order_trash', compact('orders', 'list_action', 'url_status', 'count'));
    }

    public function order_cancel(Request $request)
    {
        $keyword = "";
        $url_status = 'cancel';
        $list_action = [
            'disable' => 'Vô hiệu hóa',
        ];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $orders = Order::where('status', 'cancel')->where('fullname', 'LIKE', "%{$keyword}%")->where('code', 'LIKE', "%{$keyword}%")->orderBy('created_at', 'desc')->paginate(5);
        $count_active = Order::count();
        $count_complete = Order::where('status', 'complete')->count();
        $count_delivering = Order::where('status', 'delivering')->count();
        $count_processing = Order::where('status', 'processing')->count();
        $count_cancel = Order::where('status', 'cancel')->count();
        $count_trash = Order::onlyTrashed()->count();
        $count = [
            'active' => $count_active,
            'complete' => $count_complete,
            'delivering' => $count_delivering,
            'processing' => $count_processing,
            'cancel' => $count_cancel,
            'trash' => $count_trash,
        ];
        return view('admin.order.order_cancel', compact('orders', 'list_action', 'url_status', 'count'));
    }

    public function disable($id)
    {
        $user = Auth::user();
        $preUrl = url()->previous();
        if ($user->role->name == 'admintrator') {
            $product = Order::find($id);
            $product->delete();
            return redirect($preUrl)->with('notification', 'Đơn hàng đã được vô hiệu hóa thành công');
        } else {
            return redirect($preUrl)->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function delete($id)
    {
        $user = Auth::user();
        $preUrl = url()->previous();
        if ($user->role->name == 'admintrator') {
            Order::withTrashed()
                ->where('id', $id)
                ->forceDelete();
            return redirect($preUrl)->with('notification', 'Đơn hàng đã được xóa thành công');
        } else {
            return redirect($preUrl)->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function detail($id)
    {
        $order = Order::find($id);
        return view('admin.order.detail', compact('order'));
    }

    public function order_status(Request $request, $id)
    {
        $fullname = $request->input('fullname');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $wards = $request->input('wards');
        $province = $request->input('province');
        $city = $request->input('city');
        $address = $request->input('address');
        $card_total = $request->input('card_total');
        $create_at = $request->input('create_at');
        $order_status = $request->input('order_status');
        $loyal_customers = Loyal_customer::all();
        $user = Auth::user();
        $preUrl = url()->previous();
        if ($user->role->name == 'admintrator') {
            if ($request->input('select-status')) {
                $status = $request->input('select-status');
                Order::where('id', $id)->update(
                    ['status' => $status]
                );
                if ($status == 'complete' && $order_status != 'complete') {
                    if ($loyal_customers->count() == 0) {
                        dd('a');
                        Loyal_customer::create([
                            'fullname' => $fullname,
                            'phone' => $phone,
                            'email' => $email,
                            'wards' => $wards,
                            'province' => $province,
                            'city' => $city,
                            'card_total' => $card_total,
                            'bought_recently' => $create_at,
                            'number_order' => 1,
                            'address' => $address,
                        ]);
                    } else {
                        $data = Loyal_customer::where([
                            'fullname' => $fullname,
                            'email' => $email,
                            'phone' => $phone
                        ])->first();
                        if (!empty($data)) {
                            $date_customer = date('d/m/Y - H:i:s', strtotime($data->bought_recently));
                            $data_order = date('d/m/Y - H:i:s', strtotime($create_at));
                            // $time_customer = date('H:i:s', strtotime($create_at));
                            // $time_order = date('H:i:s', strtotime($create_at));
                            // dd($data->card_total);
                            if ($date_customer > $data_order) {
                                $data->update([
                                    'bought_recently' => $date_customer,
                                    'number_order' => $data->number_order + 1,
                                    'card_total' => $data->card_total + $card_total,
                                ]);
                            }
                            if ($date_customer < $data_order) {
                                $data->update([
                                    'bought_recently' => $data_order,
                                    'number_order' => $data->number_order + 1,
                                    'card_total' => $data->card_total + $card_total,
                                ]);
                            }
                            if ($date_customer == $data_order) {
                                $data->update([
                                    'number_order' => $data->number_order + 1,
                                    'card_total' => $data->card_total + $card_total,
                                ]);
                            }
                        } else {
                            Loyal_customer::create([
                                'fullname' => $fullname,
                                'phone' => $phone,
                                'email' => $email,
                                'wards' => $wards,
                                'province' => $province,
                                'city' => $city,
                                'card_total' => $card_total,
                                'bought_recently' => $create_at,
                                'number_order' => 1,
                                'address' => $address,
                            ]);
                        }
                    }
                } else {
                    return redirect('admin/order/list')->with('notification', 'Đơn hàng đã được giao thành công');
                }

                if ($status != 'complete' && $order_status == 'complete') {
                    $data = Loyal_customer::where([
                        'fullname' => $fullname,
                        'email' => $email,
                        'phone' => $phone
                    ])->first();
                    if (!empty($data)) {
                        // dd($data->card_total - $card_total);
                        $order = Order::where([
                            'fullname' => $fullname,
                            'email' => $email,
                            'phone' => $phone,
                            'status' => 'complete',
                        ])->orderBy('created_at', 'desc')->first();
                        $data->update([
                            'bought_recently' =>  $order->created_at,
                            'number_order' => $data->number_order - 1,
                            'card_total' => $data->card_total - $card_total,
                        ]);
                    }
                }
            }
            return redirect('admin/order/list')->with('notification', 'Cập nhật tình trạng đơn hàng thành công');
        } else {
            return redirect('admin/order/list')->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
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
                    $Order = Order::whereIn('id', $list_check);
                    $Order->delete();
                    return redirect('admin/order/list')->with('notification', 'Bạn đã vô hiệu đơn hàng thành công');
                }
                if ($action == 'delete') {
                    Order::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect($preUrl)->with('notification', 'Bạn đã vô hiệu đơn hàng thành công');
                }
                if ($action == 'active') {
                    Order::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    return redirect($preUrl)->with('notification', 'Bạn đã khôi phục đơn hàng thành công');
                }
            } else {
                return redirect($preUrl)->with('notification', 'Bạn cần chọn đơn hàng để thực hiện thao tác');
            }
        } else {
            return redirect($preUrl)->with('warning', 'Bạn chưa được cấp quyền để thực hiện hành động này');
        }
    }

    public function loyal_customer()
    {
        $loyal_customers = Loyal_customer::where('number_order', '>=', 2)->get();
        return view('admin.order.loyal_customer', compact('loyal_customers'));
    }
}
