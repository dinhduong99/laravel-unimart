<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }
    public function show()
    {
        $order_complete = Order::where('status', 'complete')->count();
        $order_processing = Order::where('status', 'processing')->count();
        $order_cancel = Order::where('status', 'cancel')->count();
        $sum_order_complete = Order::where('status', 'complete')->sum('card_total');
        $data = [
            'order_complete' => $order_complete,
            'order_processing' => $order_processing,
            'order_cancel' => $order_cancel,
            'sum_order_complete' => number_format($sum_order_complete, 0, ',', '.')
        ];
        $order_new = Order::where('status', 'processing')->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.dashboard', compact('data', 'order_new'));
    }
}
