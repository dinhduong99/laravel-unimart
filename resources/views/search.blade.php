@extends('layouts.home')
@section('content')
<div id="main-content-wp" class="clearfix category-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ url("") }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{ url("") }}" title="">Tìm kiếm</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title fl-left">Tìm thấy {{ $product->count() }} kết quả: '{{ request()->input('keyword')}}'</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        @foreach ($product as $item)
                        <form action="">
                            @csrf
                            <li>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">   
                                <input type="hidden" name="qty" value="1" class="qty_cart_{{ $item->id }}">
                                <input type="hidden" name="name" value="{{ $item->name }}" class="name_cart_{{ $item->id }}">
                                <input type="hidden" name="price" value="{{$item->sale_price == 0 ?$item->price :  $item->sale_price}}" class="price_cart_{{ $item->id }}">
                                <input type="hidden" name="thumbnail" value="{{ $item->thumbnail }}" class="thumbnail_cart_{{ $item->id }}"> 
                                <a href="{{ route('detail-product',$item->slug) }}" title="" class="thumb">
                                    <img src="{{ url($item->thumbnail) }}">
                                </a>
                                <a href="{{ route('detail-product',$item->slug) }}" title="" class="product-name">{{ $item->name }}</a>
                                <div class="price">
                                    @if ($item->sale_price > 0)
                                    <span class="new">{{ number_format($item->sale_price,0,',','.') }}đ</span>
                                    <span class="old">{{ number_format($item->price,0,',','.') }}đ</span>
                                    @endif
                                    @if ($item->sale_price == 0)
                                    <span class="new">{{ number_format($item->price,0,',','.') }}đ</span>
                                    @endif
                                </div>
                                <div class="action clearfix">
                                    <button data-id ="{{ $item->id }}" data_url="{{ route('cart.add-ajax') }}" type="button" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</button>
                                    <a href="{{ route('buy-now',$item->slug) }}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                </div>
                                @if ($item->percent_price != 0)
                                <div class="sale_off">
                                    <span class="percent_price">-{{ $item->percent_price }}%</span>
                                </div>
                                @endif
                            </li>
                        </form>
                        
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">1</a>
                        </li>
                        <li>
                            <a href="" title="">2</a>
                        </li>
                        <li>
                            <a href="" title="">3</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            <div class="section" id="category-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Danh mục sản phẩm</h3>
                </div>
                <div class="secion-detail">
                    <ul class="list-item">
                        @foreach ($list_cat as $key => $cat)
                        @if ($cat->parent_id==0)
                        <li>
                            <a href="{{route('cat-product', $cat->slug)}}" title="">{{ $cat->name }}</a>
                            @if ($cat->has_child == 1)
                            <ul class="sub-menu">
                                @foreach ($list_cat as $key => $cat_sub )
                                @if ($cat_sub->parent_id == $cat->id)
                                <li>
                                    <a href="{{route('cat-product',$cat_sub->slug)}}" title="">{{ $cat_sub->name }}</a>
                                </li>
                                @endif
                            @endforeach
                            </ul>
                            @endif
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="filter-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Bộ lọc</h3>
                </div>
                <div class="section-detail">
                    <form method="POST" action="">
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Giá</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="radio" name="r-price"></td>
                                    <td>Dưới 500.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price"></td>
                                    <td>500.000đ - 1.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price"></td>
                                    <td>1.000.000đ - 5.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price"></td>
                                    <td>5.000.000đ - 10.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price"></td>
                                    <td>Trên 10.000.000đ</td>
                                </tr>
                            </tbody>
                        </table>
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Hãng</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="radio" name="r-brand"></td>
                                    <td>Acer</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand"></td>
                                    <td>Apple</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand"></td>
                                    <td>Hp</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand"></td>
                                    <td>Lenovo</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand"></td>
                                    <td>Samsung</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand"></td>
                                    <td>Toshiba</td>
                                </tr>
                            </tbody>
                        </table>
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Loại</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="radio" name="r-price"></td>
                                    <td>Điện thoại</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price"></td>
                                    <td>Laptop</td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class="section" id="banner-wp">
                @foreach ($ads as $value)
                <div style="margin-bottom:25px" class="section-detail">
                    <a href="" title="" class="thumb">
                        <img src="{{ url($value->thumbnail) }}" alt="">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection