@extends('layouts.home')
@section('content')
<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="main-content fl-right">
            <div class="section" id="slider-wp">
                <div class="section-detail">
                    @foreach ($sliders as $slider)
                    <div class="item">
                        <img src="{{ url($slider->thumbnail) }}" alt="{{ $slider->name }}">
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="section" id="support-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <div class="thumb">
                                <img src="{{ asset("home/images/icon-1.png") }}">
                            </div>
                            <h3 class="title">Miễn phí vận chuyển</h3>
                            <p class="desc">Tới tận tay khách hàng</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{ asset("home/images/icon-2.png") }}">
                            </div>
                            <h3 class="title">Tư vấn 24/7</h3>
                            <p class="desc">1900.9999</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{ asset("home/images/icon-3.png") }}">
                            </div>
                            <h3 class="title">Tiết kiệm hơn</h3>
                            <p class="desc">Với nhiều ưu đãi cực lớn</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{ asset("home/images/icon-4.png") }}">
                            </div>
                            <h3 class="title">Thanh toán nhanh</h3>
                            <p class="desc">Hỗ trợ nhiều hình thức</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{ asset("home/images/icon-5.png") }}">
                            </div>
                            <h3 class="title">Đặt hàng online</h3>
                            <p class="desc">Thao tác đơn giản</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="section" id="feature-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm nổi bật</h3>
                </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($product_high_views as $product)
                            <form>
                                @csrf
                            <li>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">   
                                <input type="hidden" name="qty" value="1" class="qty_cart_{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}" class="name_cart_{{ $product->id }}">
                                <input type="hidden" name="price" value="{{$product->sale_price == 0 ?$product->price :  $product->sale_price}}" class="price_cart_{{ $product->id }}">
                                <input type="hidden" name="thumbnail" value="{{ $product->thumbnail }}" class="thumbnail_cart_{{ $product->id }}">
                                <input type="hidden" name="slug" value="{{ $product->slug }}" class="slug_cart_{{ $product->id }}"> 
                                <a href="{{ route('detail-product',$product->slug) }}" title="" class="thumb">
                                    <img src="{{ url($product->thumbnail) }}">
                                </a>
                                <a href="{{ route('detail-product',$product->slug) }}" title="" class="product-name">{{ $product->name}}</a>
                                <div class="price">
                                    @if ($product->sale_price > 0)
                                    <span class="new">{{ number_format($product->sale_price,0,',','.') }}đ</span>
                                    <span class="old">{{ number_format($product->price,0,',','.') }}đ</span>
                                    @endif
                                    @if ($product->sale_price == 0)
                                    <span class="new">{{ number_format($product->price,0,',','.') }}đ</span>
                                    @endif
                                </div>
                                <div class="action clearfix">
                                    <button data-id ="{{ $product->id }}" data-url="{{ route('cart.add-ajax') }}" type="button" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</button>
                                    <a href="{{ route('buy-now',$product->slug)  }}" title="" class="buy-now fl-right">Mua ngay</a>
                                </div>
                                @if ($product->percent_price != 0)
                                <div class="sale_off">
                                    <span class="percent_price">-{{ $product->percent_price }}%</span>
                                </div>
                                @endif
                            </li>
                        </form>
                            @endforeach
                        </ul>
                    </div>
            </div>
            <div class="section" id="list-product-wp">
                @foreach ($list_cat as $key => $cat)
                @if ($cat->parent_id==0)
                <div class="section-head">
                    <h3 class="section-title">{{$cat->name }}</h3>
                </div>
                <div class="section-detail">
                    @if ($cat->has_child == 1)
                         <ul class="list-item clearfix">
                        @foreach ($list_cat as $key => $cat_child)
                        @if ($cat_child->parent_id == $cat->id)
                        {{-- <span class="count_{{ $cat_child->name }}"> {{ $cat_child->product->count() }}</span> --}}
                        @foreach ($cat_child->product as $product)
                        <form>
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">   
                            <input type="hidden" name="qty" value="1" class="qty_cart_{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}" class="name_cart_{{ $product->id }}">
                            <input type="hidden" name="price" value="{{$product->sale_price == 0 ?$product->price :  $product->sale_price}}" class="price_cart_{{ $product->id }}">
                            <input type="hidden" name="thumbnail" value="{{ $product->thumbnail }}" class="thumbnail_cart_{{ $product->id }}"> 
                            <input type="hidden" name="slug" value="{{ $product->slug }}" class="slug_cart_{{ $product->id }}"> 
                        @if ($product->status != 'pending')
                        <li>
                            <a href="{{ route('detail-product',$product->slug) }}" title="" class="thumb">
                                <img src=" {{$product->thumbnail}} ">
                            </a>
                            <a href="{{ route('detail-product',$product->slug) }}" title="" class="product-name">{{ $product->name }}</a>
                            <div class="price">
                                @if ($product->sale_price > 0)
                                <span class="new">{{ number_format($product->sale_price,0,',','.') }}đ</span>
                                <span class="old">{{ number_format($product->price,0,',','.') }}đ</span>
                                @endif
                                @if ($product->sale_price == 0)
                                <span class="new">{{ number_format($product->price,0,',','.') }}đ</span>
                                @endif
                            </div>
                            <div class="action clearfix">
                                <button data-id ="{{ $product->id }}" data-url="{{ route('cart.add-ajax') }}" type="button" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</button>
                                <a href="{{ route('buy-now',$product->slug) }}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                            @if ($product->percent_price != 0)
                            <div class="sale_off">
                                <span class="percent_price">-{{ $product->percent_price }}%</span>
                            </div>
                            @endif
                        </li>
                        @endif
                        </form>
                        @endforeach
                        @endif
                        @endforeach
                        {{-- <li>
                            <a href="" title="" class="thumb">
                                <img src="public/home/images/img-pro-17.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop Asus X441NA</a>
                            <div class="price">
                                <span class="new">7.690.000đ</span>
                                <span class="old">8.690.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                            <div class="sale_off">
                                <span class="percent_price">Giảm -10%</span>
                            </div>
                        </li> --}}
                    </ul>
                    @else
                        <p>Hiện tại chưa có sản phẩm nào trong danh mục này</p>
                    @endif
                </div>
                @endif
                @endforeach
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
            @if($product_high_buys ->count() >0)
            <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm bán chạy</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($product_high_buys as $product)
                        <li class="clearfix">
                            <a href="{{ route('detail-product',$product->slug) }}" title="" class="thumb fl-left">
                                <img src="{{ url($product->thumbnail) }}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{ route('detail-product',$product->slug) }}" title="" class="product-name">{{ $product->name }}</a>
                                <div class="price">
                                    <span class="new">{{ number_format($product->sale_price,0,',','.') }}đ</span>
                                    <span class="old">{{ number_format($product->price,0,',','.') }}đ</span>
                                </div>
                                <a href="{{ route('buy-now',$product->slug)  }}" title="" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
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
