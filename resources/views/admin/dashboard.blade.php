@extends('layouts.admin')
@section('content')
@if(session('warning'))
<div class="alert alert-danger">
    {{ session('warning') }}
</div>
@endif
<div class="container-fluid py-5">
    <div class="row">
        <div class="col">
            <div class="card text-white bg-primary mb-3 card-statistics" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $data['order_complete'] }}</h5>
                    <p class="card-text">Đơn hàng giao dịch thành công</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-danger mb-3 card-statistics" style="max-width: 18rem;">
                <div class="card-header">ĐANG XỬ LÝ</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $data['order_processing'] }}</h5>
                    <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white bg-success mb-3 card-statistics" style="max-width: 18rem;">
                <div class="card-header">DOANH SỐ</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $data['sum_order_complete'] }}đ</h5>
                    <p class="card-text">Doanh số hệ thống</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-dark mb-3 card-statistics" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG HỦY</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $data['order_cancel'] }}</h5>
                    <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end analytic  -->
    <div class="card">
        <div class="card-header font-weight-bold">
            ĐƠN HÀNG MỚI
        </div>
        <form action="" method="POST">
            @csrf
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mã ĐH</th>
                        <th scope="col">Họ Tên</th>
                        <th scope="col">Tổng đơn hàng</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($order_new->count() > 0 )
                    @php
                        $t=0;
                    @endphp
                    @foreach ($order_new as $order)
                    @php
                        $t++;
                    @endphp
                    <tr class="">
                        <td>{{ $t }}</td>
                        <td>#{{ $order->code }}</td>
                        <td>{{$order->fullname}}</td>
                        <td>{{ number_format($order->card_total,0,',','.') }}đ</td>
                        <td>{{date('d/m/Y - H:i:s', strtotime($order->created_at))  }}</td>
                        <td>
                            @php
                               switch ($order->status){
                                case 'processing':
                               echo '<span class="badge badge-danger">
                                  Đang xử lý
                                </span>';
                                   break;
                                case 'delivering':
                                echo '<span class="badge badge-warning">
                                  Đang giao hàng
                                </span>';
                                    break;
                                case 'complete':
                                echo '<span class="badge badge-primary">
                                  Đã hoàn thành
                                </span>';
                                    break;
                                case 'cancel':
                                echo '<span class="badge badge-dark">
                                  Đã hủy
                                </span>';
                                    break;
                                 
                            }
                            @endphp
                        </td>
                        <td>
                            <a href="{{ route('detail.order',$order->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('order.disable',$order->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc muốn vô hiệu sản phẩm này ra khỏi hệ thống?')"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="bg-white" style="text-align:center">
                          Hiện tại chưa có đơn hàng mới nào
                        </td>
                    </tr>

                @endif
                </tbody>
            </table>
        </form>
        {{$order_new->links() }}
        </div>
    </div>

</div>
@endsection