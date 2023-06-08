@extends('layouts.admin')
@section('content')
@if(session('notification'))
<div class="alert alert-success">
    {{ session('notification') }}
</div>
@endif
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách đơn hàng</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="text" value="{{ request()->input('keyword')}}" class="form-control form-search" name="keyword" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary" >
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{ url('admin/order/list') }}" class="text-primary">Tất cả<span class="text-muted">({{ $count['active'] }})</span></a>
                <a href="{{ url('admin/order/list/order-complete') }}" class="text-primary">Đã hoàn thành<span class="text-muted">({{ $count['complete'] }})</span></a>
                <a href="{{  url('admin/order/list/order-delivering')  }}" class="text-primary">Đang giao hàng<span class="text-muted">({{ $count['delivering'] }})</span></a>
                <a href="{{  url('admin/order/list/order-processing')  }}" class="text-primary">Đang xử lý<span class="text-muted">({{ $count['processing'] }})</span></a>
                <a href="{{  url('admin/order/list/order-cancel')  }}" class="text-primary">Đã hủy<span class="text-muted">({{ $count['cancel'] }})</span></a>
                <a href="{{  url('admin/order/list/order-trash')  }}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{ $count['trash'] }})</span></a>
            </div>
            <form action="{{ url('admin/order/action') }}" method="POST">
            @csrf
            <input type="hidden" name="url_status" id="" value="{{$url_status}}">
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" id="" name="action">
                    <option value="">Chọn</option>
                    @foreach ($list_action as $k=>$value)
                    <option value="{{ $k }}">{{ $value }}</option>
                    @endforeach
                </select>
                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
            </div>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">
                            <input name="checkall" type="checkbox">
                        </th>
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
                   @if ($orders->count() > 0 )
                    @php
                        $t=0;
                    @endphp
                    @foreach ($orders as $order)
                    @php
                        $t++;
                    @endphp
                    <tr class="">
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{ $order->id }}">
                        </td>
                        <td>{{ $t }}</td>
                        <td>#{{ $order->code }}</td>
                        <td>{{$order->fullname}}</td>
                        <td>{{ number_format($order->card_total,0,',','.') }}đ</td>
                        <td>{{date('d/m/Y - H:i:s', strtotime($order->created_at))  }}</td>
                        <td>
                            @php
                               switch ($order->status){
                                case 'processing':
                               echo '<span class="badge badge-warning">
                                  Đang xử lý
                                </span>';
                                   break;
                                case 'delivering':
                                echo '<span class="badge badge-primary">
                                  Đang giao hàng
                                </span>';
                                    break;
                                case 'complete':
                                echo '<span class="badge badge-success">
                                  Đã hoàn thành
                                </span>';
                                    break;
                                case 'cancel':
                                echo '<span class="badge badge-danger">
                                  Đã hủy
                                </span>';
                                    break;
                                 
                            }
                            @endphp
                        </td>
                        <td>
                            @if ($url_status == "trash")
                            <a href="{{ route('order.delete',$order->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này ra khỏi hệ thống?')"><i class="fa fa-trash"></i></a>
                            @else
                            <a href="{{ route('detail.order',$order->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('order.disable',$order->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc muốn vô hiệu sản phẩm này ra khỏi hệ thống?')"><i class="fa fa-trash"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="bg-white" style="text-align:center">
                            Không tìm thấy kết quả cần tìm
                        </td>
                    </tr>

                @endif
                </tbody>
            </table>
        </form>
        {{ $orders->appends(request()->query())->links()  }}
        </div>
    </div>
</div>
@endsection
