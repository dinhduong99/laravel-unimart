@extends('layouts.home')
@section('content')
<div id="main-content-wp" class="order-success-page">
    <div id="wrapper" class="wp-inner clearfix">
        @if (session('code'))
        <div class="section" id="notification-wp">
            <div class="section-head">
                <h3 class="section-title">Đơn Hàng Đã Được Đặt Thành Công</h3>
            </div>
            <div class="section-detail">
                <p>Chân thành cảm ơn quý khách đã mua sắm tại <span style="font-weight:bold">DD STORE</span>.</p>
                <p>Chúng tôi hy vọng quý khách hài lòng với trải nghiệm mua sắm và các sản phẩm đã chọn.</p>
                <P>Bộ phận nhân viên chăm sóc khách hàng <span style="font-weight:bold">DD STORE</span> sẽ liên hệ với quý khách sớm nhất để xác nhận lại thông tin đơn hàng lại một lần nữa.</P>
            </div>
        </div>
        <div class="section" id="order-infor-wp">
            <div class="section-head">
                <p class="section-title">Thông tin đơn hàng của quý khách</p>
            </div>
            @php
                $product_order= json_decode($infor->product_order);
            @endphp
            <div class="section-detail">
                <table class="customer-infor-table">
                    <tbody>
                        <tr>
                            <td >Mã Đơn Hàng</td>
                            <td style="font-weight:bold"> #{{ $infor->code }}</td>
                        </tr>
                        <tr>
                            <td>Thời gian đặt hàng:</td>
                            <td>{{date('d/m/Y - H:i:s', strtotime($infor->created_at))  }}</td>
                        </tr>
                        <tr>
                            <td>Tên Khách hàng:</td>
                            <td>{{ $infor->fullname}}</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>{{ $infor->email }}</td>
                        </tr>
                        <tr>
                            <td>Số điện thoại:</td>
                            <td>{{ $infor->phone }}</td>
                        </tr>
                        <tr>
                            <td>Địa chỉ</td>
                            <td>{{ $infor->address }}, {{ $infor->city }}, {{  $infor->province}}, {{ $infor->wards }}</td>
                        </tr>
                        <tr>
                            <td>Ghi chú:</td>
                            <td>{{ $infor->note }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="section" id="product-infor-wp">
            <div class="section-head">
                <p class="section-title">Chi tiết đơn hàng của quý khách</p>
            </div>
            <div class="section-detail">
                <table class="product-infor-table">
                    <thead>
                        <tr>
                            <td style="width:45%">Sản phẩm</td>
                            <td>Số lượng</td>
                            <td>Ảnh sản phẩm</td>
                            <td>Tổng</td>
                        </tr>
                    </thead>
                   
                    <tbody>
                        @foreach ($product_order as $product)
                        <tr class="cart-item">
                            <td class="product-name">{{ $product->name }}</td>
                            <td class="product-quantity">x {{ $product->qty }}</td>
                            <td>
                                <a class="product-thumb" href=""><img src="{{ url($product->options->thumbnail) }}" alt=""></a>
                            </td>
                            <td class="product-total">{{ number_format($product->subtotal,0,',','.') }}đ</td>
                        </tr>
                        @endforeach
                </tbody>
                    <tfoot>
                        <tr class="order-total">
                            <td>Tổng đơn hàng:</td>
                            <td></td>
                            <td></td>
                            <td><strong class="total-price">{{ number_format($infor->card_total,0,',','.') }}đ</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @else
        <div class="cart-empty">
            <a href="{{ url("") }}">Quay trở lại trang chủ</a>
        </div>
        @endif
    </div>
</div>
@endsection