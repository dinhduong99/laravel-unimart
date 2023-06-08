@extends('layouts.home')
@section('content')
<div id="main-content-wp" class="clearfix detail-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ url("") }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{ route("cat-product",$cat_parent->slug) }}" title="">{{ $cat_parent->name }}</a>
                    </li>
                    <li>
                        <a href="{{ route("cat-product",$product->cat->slug) }}" title="">{{ $product->cat->name }}</a>
                    </li>
                    <li>
                        <a href="{{ url()->current() }}" title="">{{ $product->name }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-product-wp">
                <div class="section-detail clearfix">
                    <div class="thumb-wp fl-left">
                        @php
                            $image_list = json_decode($product->image_list);
                            // $image_list[] = $product->thumbnail;
                        //   print_r($image_list);
                        @endphp
                        <a href="" title="" id="main-thumb">
                            <img style="width:350px;height:350px; object-fit: contain;" id="zoom" src="{{ url($product->thumbnail) }}" data-zoom-image="{{ url($product->thumbnail) }}"/>
                        </a>
                        <div id="list-thumb">
                            <a href="" data-image="{{ url($product->thumbnail) }}" data-zoom-image="{{ url($product->thumbnail) }}">
                                <img  id="zoom" src="{{ url($product->thumbnail) }}" />
                            </a>
                            @foreach ($image_list as  $image)
                            <a href="" data-image="{{ url( $image) }}" data-zoom-image="{{ url( $image) }}">
                                <img  id="zoom" src="{{ url( $image) }}" />
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="thumb-respon-wp fl-left">
                        <img src="{{ url($product->thumbnail) }}" alt="">
                    </div>
                    <div class="info fl-right">
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <div class="detail">
                           {!! $product->detail !!}
                            {{-- <p>Bộ vi xử lý :Intel Core i505200U 2.2 GHz (3MB L3)</p>
                            <p>Cache upto 2.7 GHz</p>
                            <p>Bộ nhớ RAM :4 GB (DDR3 Bus 1600 MHz)</p>
                            <p>Đồ họa :Intel HD Graphics</p>
                            <p>Ổ đĩa cứng :500 GB (HDD)</p> --}}
                        </div>
                        <div class="num-product">
                            <span class="title">Sản phẩm: </span>
                            <span class="status">
                                @php
                                switch ($product->status){
                                 case 'out of stock':
                                   echo 'Hết hàng';
                                   break;
                                 case 'stocking':
                                  echo 'Còn hàng';
                                  break;
                             }
                             @endphp
                            </span>
                        </div>
                       
                        <div class="box-price">
                            @if ($product->sale_price > 0)
                                <p class="sale_price">{{ number_format($product->sale_price,0,',','.') }}đ *</p>
                                <p class="price">{{ number_format($product->price,0,',','.') }}đ</p>
                                <span class="percent_price">-{{ $product->percent_price}}%</span>
                            @endif
                             @if ($product->sale_price == 0)
                             <p class="sale_price">{{ number_format($product->price,0,',','.') }}đ</p>
                            @endif
                       
                        </div>
                        <form action="{{ route('cart.add',$product->slug) }}" method="POST">
                            @csrf
                            <div id="num-order-wp">
                                <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                <input type="text" name="num-order" value="1" id="num-order">
                                <a title="" id="plus"><i class="fa fa-plus"></i></a>
                            </div>
                            <button type="submit" title="Thêm giỏ hàng" class="add-cart">Thêm giỏ hàng</button>
                        </form>
                    </div>
            
                </div>
            </div>
            <div class="section" id="post-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Mô tả sản phẩm</h3>
                </div>
                <div class="section-desc">
                    {!! $product->description !!}
                    <span id="seeMore">Xem thêm</span>
                </div>
            </div>
            <div class="section" id="same-category-wp">
                <div class="section-head">
                    <h3 class="section-title">Cùng chuyên mục</h3>
                </div>
                <div class="section-detail">
                 
                        @if ($product_same->count() > 0)
                        <ul class="list-item">
                        @foreach ($product_same as $product)
                        <form>
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">   
                            <input type="hidden" name="qty" value="1" class="qty_cart_{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}" class="name_cart_{{ $product->id }}">
                            <input type="hidden" name="price" value="{{$product->sale_price == 0 ?$product->price :  $product->sale_price}}" class="price_cart_{{ $product->id }}">
                            <input type="hidden" name="thumbnail" value="{{ $product->thumbnail }}" class="thumbnail_cart_{{ $product->id }}"> 
                            <input type="hidden" name="slug" value="{{ $product->slug }}" class="slug_cart_{{ $product->id }}"> 
                        <li>
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
                                <a href="{{ route('buy-now',$product->slug) }}" title="" class="buy-now fl-right">Mua ngay</a>
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
                        @else
                           Hiện tại chưa có sản phẩm nào cùng chuyên mục
                        @endif
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