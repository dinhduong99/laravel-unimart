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
                    
                    @if ($cat_product->parent_id == 0)
                        <li>
                            <a href="{{ route("cat-product",$cat_product->slug) }}" title="">{{ $cat_product->name }}</a>
                        </li>
                    @endif
                        @if ($cat_product->parent_id != 0)
                        <li>
                            <a href="{{ route("cat-product",$cat_parent->slug) }}" title="">{{ $cat_parent->name }}</a>
                        </li>
                        <li>
                            <a href="{{ route("cat-product",$cat_product->slug) }}" title="">{{ $cat_product->name }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title fl-left">{{ $cat_product->name }}</h3>
                    <div class="filter-wp fl-right">
                        @if ($cat_product->parent_id == 0)
                        <p style="font-weight:700;font-size:16px" class="desc">{{ $count}} {{ $cat_product->name }}</p>
                        @endif
                        @if ($cat_product->parent_id != 0)
                        <p style="font-weight:700;font-size:16px" class="desc">{{ $count}} {{ $cat_parent->name }} {{ $cat_product->name }}</p>
                        @endif
                        <div class="form-filter">
                            <form method="GET" action="">
                                @if ($checked)
                                    @if(isset($checked['price_filter']))
                                        <input type="hidden" value="{{ $checked['price_filter'] }}" name="price_select">
                                    @endif
                                    @if(isset($checked['brand_filter']))
                                        <input type="hidden" value="{{ $checked['brand_filter'] }}" name="brand_select">
                                @endif
                                @endif
                                <select name="select">
                                    <option  value="0">Sắp xếp</option>
                                    <option {{ in_array(1 ,$checked)?"selected":"" }} value="1">Từ A-Z</option>
                                    <option {{ in_array(2 ,$checked)?"selected":"" }} value="2">Từ Z-A</option>
                                    <option {{ in_array(3 ,$checked)?"selected":"" }} value="3">Giá cao xuống thấp</option>
                                    <option {{ in_array(4 ,$checked)?"selected":"" }} value="4">Giá thấp lên cao</option>
                                </select>
                                <button name="btn-sort">Lọc</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        @if ($count >0)
                        @foreach ($product as $item)
                        <form action="">
                            @csrf
                            <li>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">   
                                <input type="hidden" name="qty" value="1" class="qty_cart_{{ $item->id }}">
                                <input type="hidden" name="name" value="{{ $item->name }}" class="name_cart_{{ $item->id }}">
                                <input type="hidden" name="price" value="{{$item->sale_price == 0 ?$item->price :  $item->sale_price}}" class="price_cart_{{ $item->id }}">
                                <input type="hidden" name="thumbnail" value="{{ $item->thumbnail }}" class="thumbnail_cart_{{ $item->id }}"> 
                                <input type="hidden" name="slug" value="{{ $item->slug }}" class="slug_cart_{{ $item->id }}"> 
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
                                    <button data-id ="{{ $item->id }}" data-url="{{ route('cart.add-ajax') }}" type="button" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</button>
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
                        @else
                            <p>Không có sản phẩm nào trong danh mục này.</p>
                        @endif
                        
                    </ul>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail">
                    {{$product->links()}}
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
                    <form method="GET">
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Giá</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="radio" id="price_1" {{ in_array("price_1" ,$checked)?"checked":"" }} name="price_filter" value="price_1" ></td>
                                    <td><label for="price_1">Dưới 500.000đ</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" id="price_2" {{ in_array("price_2" ,$checked)?"checked":"" }} name="price_filter" value="price_2"></td>
                                    <td><label for="price_2">500.000đ - 1.000.000đ</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" id="price_3" {{ in_array("price_3" ,$checked)?"checked":"" }} name="price_filter" value="price_3"></td>
                                    <td><label for="price_3">1.000.000đ - 5.000.000đ</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" id="price_4" {{ in_array("price_4" ,$checked)?"checked":"" }} name="price_filter" value="price_4"></td>
                                    <td><label for="price_4">5.000.000đ - 10.000.000đ</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" id="price_5" {{ in_array("price_5" ,$checked)?"checked":"" }} name="price_filter" value="price_5"></td>
                                    <td><label for="price_5">Trên 10.000.000đ</label></td>
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
                                    <td><input type="radio" id="brand_1" {{ in_array("brand_1" ,$checked)?"checked":"" }} name="brand_filter" value="brand_1"></td>
                                    <td><label for="brand_1">Acer</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" id="brand_2" {{ in_array("brand_2" ,$checked)?"checked":"" }} name="brand_filter" value="brand_2"></td>
                                    <td><label for="brand_2">Oppo</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" id="brand_3" {{ in_array("brand_3" ,$checked)?"checked":"" }} name="brand_filter" value="brand_3"></td>
                                    <td><label for="brand_3">Dell</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" id="brand_4" {{ in_array("brand_4" ,$checked)?"checked":"" }} name="brand_filter" value="brand_4"></td>
                                    <td><label for="brand_4">Apple</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" id="brand_5" {{ in_array("brand_5" ,$checked)?"checked":"" }} name="brand_filter" value="brand_5"></td>
                                    <td><label for="brand_5">Samsung</label></td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn-filter">Lọc ngay</button>
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
