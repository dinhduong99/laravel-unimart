@extends('layouts.home')
@section('content')
<div id="main-content-wp" class="clearfix blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ url('') }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{ url('tin-cong-nghe') }}" title="">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">Blog</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @if ($posts->count()>0)
                            @foreach ($posts as $post)
                            <li class="clearfix">
                                <a href="{{ route('post.detail',$post->slug) }}" title="" class="thumb fl-left">
                                    <img src="{{ url($post->thumbnail) }}" alt="">
                                </a>
                                <div class="info fl-right">
                                    <a href="{{ route('post.detail',$post->slug) }}" title="" class="title">{{ $post->name }}</a>
                                    <div style="display: flex;justify-content:space-between;padding-top:4%">
                                        <span class="create-date">{{date('d/m/Y', strtotime($post->created_at)) }}</span>
                                      <a href="{{ route('post.cat',$post->cat->slug) }}"><span class="create-cat">{{$post->cat->name }}</span></a>  
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="section" id="paging-wp">
                {{$posts->links() }}
            </div>
        </div>
        <div class="sidebar fl-left">
            <div class="section" id="category-post-wp">
                <div class="section-head">
                    <h3 class="section-title">Danh mục bài viết</h3>
                </div>
                <div class="secion-detail">
                    <ul class="list-item">
                        @foreach ($cat_posts as $cat)
                        <li>
                            <a href="{{ route('post.cat',$cat->slug) }}" title="">{{ $cat->name }}</a>
                        </li>
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