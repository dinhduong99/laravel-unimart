@extends('layouts.home')
@section('content')
<div id="main-content-wp" class="checkout-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?page=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Thanh toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        @if (Cart::content()->count() > 0)
        <form name="form-checkout" action="{{ url("store") }}" method="POST">
            @csrf
        <div class="section" id="customer-info-wp">
            <div class="section-head">
                <h1 class="section-title">Thông tin khách hàng</h1>
            </div>
            <div class="section-detail">
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="fullname">Họ tên</label>
                            <input type="text" name="fullname" id="fullname" class="@error('fullname') invalid @enderror" value="{{ old('fullname') }}">
                            @error('fullname')
                            <div class="error">{{ $message }} !</div>
                            @enderror
                        </div>
                      
                        <div class="form-col fl-right">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="@error('email') invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                            <div class="error">{{ $message }} !</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" name="phone" id="phone" class="@error('phone') invalid @enderror" value="{{ old('phone') }}">
                            @error('phone')
                            <div class="error">{{ $message }} !</div>
                            @enderror
                        </div>
                        <div class="form-col fl-right">
                            <label for="address">Địa chỉ</label>
                            <input type="text" name="address" id="address" class="@error('address') invalid @enderror" value="{{ old('address') }}">
                            @error('address')
                            <div class="error">{{ $message }} !</div>
                            @enderror
                        </div>
                    </div>  
                        <div class="form-row">
                            <div class="form-col">
                                <label for="address">Chọn thành phố</label>
                                <select data-url="{{ url("select-address") }}" name="city" id="city" class="choose city @error('city') invalid @enderror">
                                    @if (old('city'))
                                    <option value="">--Chọn thành phố--</option>
                                    @foreach ($city as $value)
                                    <option value="{{ $value->matp }}" {{old('city') == $value->matp ?"selected":"" }}>{{ $value->name_city }}</option>
                                    @endforeach
                                    @else
                                    <option value="">--Chọn thành phố--</option>
                                    @foreach ($city as $key => $value)
                                    <option value="{{ $value->matp }}">{{ $value->name_city }}</option>
                                    @endforeach
                                    @endif  
                                </select>
                            </div>
                            @error('city')
                            <div class="error">{{ $message }} !</div>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                    <label for="address">Chọn quận huyện</label>
                                    <select data-url="{{ url("select-address") }}" name="province" id="province" class="choose province @error('province') invalid @enderror">
                                        <option value="">--Chọn quận huyện--</option>
                                        @php
                                            $a =[];
                                        @endphp
                                        @if (old('city'))
                                            @foreach ($quanhuyen as $value)
                                                @if ($value->matp == old('city'))
                                              @php
                                                  $a []= $value
                                              @endphp
                                                @endif
                                            @endforeach
                                            @php
                                                sort( $a );
                                            @endphp
                                            @foreach ($a as $key => $value)
                                            <option value="{{ $value->maqh }}" {{old('province') == $value->maqh ?"selected":"" }}>{{ $value->name_quanhuyen }}</option>
                                            @endforeach
                                        @else
                                        <option value="">--Chọn quận huyện--</option>
                                        @endif 
                                    </select> 
                            </div>
                            @error('province')
                            <div class="error">{{ $message }} !</div>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                <label for="address">Chọn xã phường</label>
                                <select data-url="{{ url("select-address") }}" name="wards" id="wards" class="wards @error('wards') invalid @enderror">
                                    <option value="">--Chọn xã phường-</option>
                                    @php
                                    $a =[];
                                    @endphp
                                @if (old('province'))
                                    @foreach ($wards as $value)
                                        @if ($value->maqh == old('province'))
                                      @php
                                          $a []= $value
                                      @endphp
                                        @endif
                                    @endforeach
                                    @php
                                        sort( $a );
                                    @endphp
                                    @foreach ($a as $key => $value)
                                    <option value="{{ $value->xaid }}" {{old('wards') == $value->xaid  ?"selected":"" }}>{{ $value->name_xaphuong }}</option>
                                    @endforeach
                                @else
                                <option value="">--Chọn quận huyện--</option>
                                @endif 
                                </select>
                            </div>
                            @error('wards')
                            <div class="error">{{ $message }} !</div>
                            @enderror
                        </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="notes">Ghi chú</label>
                            <textarea name="note"></textarea>
                        </div>
                    </div>
            </div>
        </div>
        <div class="section" id="order-review-wp">
            <div class="section-head">
                <h1 class="section-title">Thông tin đơn hàng</h1>
            </div>
            <div class="section-detail">
                <table class="shop-table">
                    <thead>
                        <tr>
                            <td style="width:45%">Sản phẩm</td>
                            <td>Số lương</td>
                            <td>Ảnh sản phẩm</td>
                            <td>Tổng</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Cart::content() as $product)
                        <tr class="cart-item">
                            <td class="product-name">{{ $product->name }}</td>
                            <td class="product-quantity">x {{ $product->qty }}</td>
                            <td>
                                <a class="product-thumb" href=""><img src="{{ url($product->options->thumbnail) }}" alt=""></a>
                            </td>
                            <td class="product-total">{{ number_format($product->total,0,',','.') }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="order-total">
                            <td>Tổng đơn hàng:</td>
                            <td></td>
                            <td></td>
                            <td><strong class="total-price">{{ Cart::total() }}đ</strong></td>
                        </tr>
                    </tfoot>
                </table>
                <div id="payment-checkout-wp">
                    <label class="title">Hình thức thanh toán</label>
                    <ul id="payment_methods">
                        <li>
                            <input type="radio" id="payment-home" name="payment_method" value="payment-home">
                            <label for="payment-home">Thanh toán tại nhà</label>
                        </li>
                        @error('payment_method')
                        <div class="error">{{ $message }} !</div>
                        @enderror
                    </ul>
                </div>
                <div class="place-order-wp clearfix">
                    <input type="submit" id="order-now" value="Đặt hàng">
                    {{-- <a href="{{ url("thong-bao-don-hang") }}" id="order-now">Đặt hàng</a> --}}
                </div>
            </div>
        </div>
    </form>
        @else
        <div class="cart-empty">
            <p>Không có sản phẩm nào cần được thanh toán</p>
            <a href="{{ url("") }}">Quay trở lại trang chủ</a>
        </div>
        @endif
    </div>
</div>
@endsection