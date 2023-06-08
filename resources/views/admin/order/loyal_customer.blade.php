@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if(session('notification'))
        <div class="alert alert-success">
            {{ session('notification') }}
        </div>
        @endif
        @if(session('warning'))
        <div class="alert alert-danger">
            {{ session('warning') }}
        </div>
        @endif
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách khách hàng thân thiết</h5>
        </div>
        <div class="card-body">
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên khách hàng</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Tổng đơn</th>
                            <th scope="col">Mua hàng gần đây</th>
                            <th scope="col">Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t=0;
                        @endphp
                        @if (!empty($loyal_customers))
                            @foreach ($loyal_customers as $customer)
                            @php
                            $t++;
                            @endphp
                            <tr>
                                <td style="font-weight: bold" scope="row">{{ $t }}</td>
                                <td>{{ $customer->fullname }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->address}}, {{ $customer->wards  }}, {{ $customer->province }}, {{ $customer->city}}</td>
                                <td>{{ $customer->number_order }}</td>
                                <td>{{ $customer->bought_recently }}</td>
                                <td>{{ number_format($customer->card_total,0,',','.') }}đ</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="bg-white" style="text-align:center">
                                    Không tìm thấy kết quả cần tìm
                                </td>
                            </tr>
    
                        @endif
    
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection