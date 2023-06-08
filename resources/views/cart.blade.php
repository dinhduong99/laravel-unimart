@extends('layouts.home')
@section('content')
<div id="main-content-wp" class="cart-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ url('') }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        @if (Cart::count() > 0)
        <div class="section" id="info-cart-wp">
            <div class="section-detail table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <td>STT</td>
                            <td>Ảnh sản phẩm</td>
                            <td>Tên sản phẩm</td>
                            <td>Giá sản phẩm</td>
                            <td>Số lượng</td>
                            <td>Thành tiền</td>
                            <td>Tác vụ</td>
                        </tr>
                    </thead>
                    @php
                        $t=0;
                    @endphp
                    <tbody>
                    @foreach (Cart::content() as $product)
                    @php
                    $t++;
                    @endphp
                    <form>
                        @csrf
                        <tr class="product_{{  $product->rowId }}">
                            <td class="stt">{{ $t }}</td>
                            <td>
                                <a href="" title="" class="thumb">
                                    <img src="{{ url($product->options->thumbnail) }}" alt="">
                                </a>
                            </td>
                            <td>
                                <a href="" title="" class="name-product">{{ $product->name }}</a>
                            </td>
                            <td class="price">{{ number_format($product->price,0,',','.') }}đ</td>
                            <td>
                                <div style="justify-content: center" class="d-flex num-order-cart" id="num-order-wp">
                                    <a title="" class="minus-cart" id="minus"><i class="fa fa-minus"></i></a>
                                        <input data-rowid ="{{ $product->rowId }}" data-id="{{ $product->id }}" data-url="{{ route('cart.update-ajax') }}" type="text" name="num-order[{{ $product->rowId }}]" value="{{ $product->qty }}" class="num-order-cart" id="num-order">
                                     <a title="" class="plus-cart" id="plus"><i class="fa fa-plus"></i></a>
                                </div>
                            </td>
                            <td class="sub-total-{{ $product->id}}">{{ number_format($product->total,0,',','.') }}đ</td>
                            <td>
                                <button data-rowid ="{{ $product->rowId }}" data-id ="{{ $product->id }}" data-url="{{ route('cart.remove-ajax') }}"  type="button" title="Xóa" class="del-product"><i class="fa fa-trash-o"></i> Xóa</button>
                            </td>
                        </tr>
                    </form>
                    </tbody>
                    @endforeach
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <p id="total-price" class="fl-right">Tổng giá: <span>{{ Cart::total() }}đ</span></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <div class="fl-right">
                                        <a href="{{ url("thanh-toan.html") }}" title="" id="checkout-cart">Thanh toán</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div> 

        <div class="section" id="info-cart-respon-wp">
            @foreach (Cart::content() as $product)
            <div class="section-detail">
                <div class="product_{{  $product->rowId }} detail">
                    <a href="" title="" class="thumb">
                        <img src="{{ url($product->options->thumbnail) }}" alt="">
                    </a>
                    <div class="infor-product">
                        <a href="" title="" class="name-product">{{ $product->name }}</a>
                        <span class="price">{{ number_format($product->price,0,',','.') }}đ</span>
                        <div class="d-flex num-order-cart" id="num-order-wp">
                            <a title="" class="minus-cart" id="minus"><i class="fa fa-minus"></i></a>
                                <input data-rowid ="{{ $product->rowId }}" data-id="{{ $product->id }}" data-url="{{ route('cart.update-ajax') }}" type="text" name="num-order[{{ $product->rowId }}]" value="{{ $product->qty }}" class="num-order-cart" id="num-order">
                             <a title="" class="plus-cart" id="plus"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="right-product">
                        <div class="sub-total">
                            <span style="display:inline-block" class="into-money">Thành tiền:</span>
                            <span style="display:inline-block" class="sub-total-{{ $product->id}}">{{ number_format($product->total,0,',','.') }}đ</span>
                        </div>
                        <button data-rowid ="{{ $product->rowId }}" data-id ="{{ $product->id }}" data-url="{{ route('cart.remove-ajax') }}"  type="button" title="Xóa" class="del-product"><i class="fa fa-trash-o"></i> Xóa</button>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="check-out">
                <div class="clearfix">
                    <p id="total-price" class="fl-right">Tổng giá: <span>{{ Cart::total() }}đ</span></p>
                </div>
                <div class="fl-right">
                    <a href="{{ url("thanh-toan.html") }}" title="" id="checkout-cart">Thanh toán</a>
                </div>
            </div>
        </div>
         <div class="section" id="action-cart-wp">
            <div class="section-detail">
                <p class="title">Click vào <span>“Cập nhật giỏ hàng”</span> để cập nhật số lượng. Nhập vào số lượng <span>0</span> để xóa sản phẩm khỏi giỏ hàng. Nhấn vào thanh toán để hoàn tất mua hàng.</p>
                <div style="display: flex">
                    <a href="{{ url("") }}" title="" id="buy-more">Mua tiếp</a><br/>
                    <a href="{{ url("delete-all") }}" title="" id="delete-cart">Xóa giỏ hàng</a>
                </div>
            </div>
        </div>
        @else
            <div class="cart-empty">
                <p>Không có sản phẩm nào trong giỏ hàng</p>
                <a href="{{ url("") }}">Quay trở lại trang chủ</a>
            </div>
        @endif
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {   
    $("#num-order.num-order-cart").change(function(){
    let qty = $(this).val();
    let rowId = $(this).attr('data-rowid');
    let id= $(this).attr('data-id');
    let url=$(this).attr('data-url');
    let _token = $('input[name="_token"]').val();
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });  
    $.ajax({
            url: url,
            method: 'POST',
            data:{qty: qty, rowId: rowId, id: id, _token:_token },
            dataType: 'json', 
            success: function(data) {
            $('.sub-total-'+data.id+'').text(data.sub_total + "đ");
            $('#total-price span').text(data.total + "đ");
            $('#cart-wp #num, #cart-respon-wp #num').text(data.num);
            $('#cart-wp #dropdown .list-cart .info .qty').text("Số lượng: " + data.qty);
            $('#cart-wp #dropdown .total-price p.price').text(data.total + "đ");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });     
    });
});
</script>
@endsection

