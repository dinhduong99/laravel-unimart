<!DOCTYPE html>
<html>
    <head>
        <title>DD STORE</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset("home/css/bootstrap/bootstrap-theme.min.css") }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset("home/css/bootstrap/bootstrap.min.css") }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset("home/reset.css") }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset("home/css/carousel/owl.carousel.css") }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset("home/css/carousel/owl.theme.css") }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset("home/css/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet"/>
        <link href="{{ asset("home/style.css") }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset("home/responsive.css") }}" rel="stylesheet" type="text/css"/>
        <script src="{{ asset("home/js/jquery-2.2.4.min.js") }}" type="text/javascript"></script>
        <script src="{{ asset("home/js/elevatezoom-master/jquery.elevatezoom.js") }}" type="text/javascript"></script>
        <script src="{{ asset("home/js/bootstrap/bootstrap.min.js") }}" type="text/javascript"></script>
        <script src="{{ asset("home/js/carousel/owl.carousel.js") }}" type="text/javascript"></script>
        <script src="{{ asset("home/js/main.js") }}" type="text/javascript"></script>
    </head>
    <body>
    <div id="site">
            <div id="container">
                <div id="header-wp">
                    <div id="head-top" class="clearfix">
                        <div class="wp-inner">
                            <a href="" title="" id="payment-link" class="fl-left">Hình thức thanh toán</a>
                            <div id="main-menu-wp" class="fl-right">
                                <ul id="main-menu" class="clearfix">
                                    <li>
                                        <a href="{{ url("") }}" title="">Trang chủ</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('san-pham') }}" title="">Sản phẩm</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('tin-cong-nghe') }}" title="">Blog</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('gioi-thieu.html') }}" title="">Giới thiệu</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('lien-he.html') }}" title="">Liên hệ</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div  id="head-body" class="clearfix">
                        <div class="wp-inner">
                            {{-- <a href="{{ url("") }}" title="" id="logo" class="fl-left"><img src="{{ asset("home/images/logo.png") }}"/></a>   --}}
                            <a href="{{ url("") }}" title="" id="logo" class="fl-left"><img src="{{ asset('uploads/logo-dd.PNG') }}" alt=""></a>
                            <div id="search-wp" class="fl-left">
                                <form action="{{ route('search') }}" method="POST">
                                    @csrf
                                    <input data-url="{{ url("search-product")}}" data-url-host="{{ url("") }}" type="text" name="keyword" id="s" class="search-ajax" placeholder="Nhập từ khóa tìm kiếm tại đây!" autocomplete="off">
                                    <button type="submit" id="sm-s">Tìm kiếm</button>
                                    <div class="search-result">
                                        {{-- <div class="product_suggest">
                                            <a href="">
                                                <div class="item-img">
                                                    <img src="{{ url("public/uploads/iphone-13-pro-max-xanh-la.jpg") }}" alt="">
                                                </div>
                                                <div class="item-infor">
                                                    <h3>Laptop Dell Gaming G15 5515 R5 5600H</h3>
                                                    <div class="box-price">
                                                        <p class="sale_price">21.591.000đ * </p>
                                                        <p class="price"> 23.990.000đ </p>
                                                        <span class="percen_price">-10%</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div> --}}
                                
                                    </div>
                                </form>
                            </div>
                            <div id="action-wp" class="fl-right">
                                <div id="advisory-wp" class="fl-left">
                                    <span class="title">Tư vấn</span>
                                    <span class="phone">0987.654.321</span>
                                </div>
                                <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                                <a href="{{ url('gio-hang.html') }}" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    @if (Cart::count() > 0)
                                    <span id="num">{{ Cart::count() }}</span>
                                   @endif
                                    @if (Cart::count() == 0)
                                    <span id="num">0</span>
                                    @endif
                                </a>
                                <div id="cart-wp" class="fl-right">
                                    <div id="btn-cart">
                                        <a href="{{ url('gio-hang.html') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                                       @if (Cart::count() > 0)
                                        <span id="num">{{ Cart::count() }}</span>
                                       @endif
                                        @if (Cart::count() == 0)
                                        <span id="num">0</span>
                                        @endif
                                    </div>
                                    <div id="dropdown">
                                        <p class="desc">Có <span>{{ Cart::count() }} sản phẩm</span> trong giỏ hàng</p>
                                        @if (Cart::count() > 0)
                                        @foreach(Cart::content() as $product)
                                        <ul class="list-cart">
                                            <li class="clearfix">
                                                {{-- <a href="{{ route('detail-product',$product->options->slug)  }}" title="" class="thumb fl-left">
                                                    <img src="{{ url($product->options->thumbnail) }}" alt="">
                                                </a> --}}
                                                <a href="" title="" class="thumb fl-left">
                                                    <img src="{{ url($product->options->thumbnail) }}" alt="">
                                                </a>
                                                <div class="info fl-right">
                                                    <a href="" title="" class="product-name">{{ $product->name }}</a>
                                                    <p class="price">{{ number_format($product->price,0,',','.') }}đ</p>
                                                    <p class="qty">Số lượng: <span>{{ $product->qty }}</span></p>
                                                </div>
                                            </li>
                                        </ul>
                                        @endforeach
                                        <div class="total-price clearfix">
                                            <p class="title fl-left">Tổng:</p>
                                            <p class="price fl-right">{{ Cart::total() }}đ</p>
                                        </div>
                                        <div class="action-cart clearfix">
                                            <a href="{{ url('gio-hang.html') }}" title="Giỏ hàng" class="view-cart fl-left">Giỏ hàng</a>
                                            <a href="{{ url('thanh-toan.html') }}" title="Thanh toán" class="checkout fl-right">Thanh toán</a>
                                        </div>
                                        @endif
                                        @if (Cart::count() == 0)
                                            <img src="{{ url('public/uploads/gio-hang.png') }}" alt="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('content')
                <div id="footer-wp">
                    <div id="foot-body">
                        <div class="wp-inner clearfix">
                            <div class="block" id="info-company">
                                <h3 class="title">ISMART</h3>
                                <p class="desc">ISMART luôn cung cấp luôn là sản phẩm chính hãng có thông tin rõ ràng, chính sách ưu đãi cực lớn cho khách hàng có thẻ thành viên.</p>
                                <div id="payment">
                                    {{-- <div class="thumb">
                                        <img src="public/images/img-foot.png" alt="">
                                    </div> --}}
                                </div>
                            </div>
                            <div class="block menu-ft" id="info-shop">
                                <h3 class="title">Thông tin cửa hàng</h3>
                                <ul class="list-item">
                                    <li>
                                        <p>106 - Trần Bình - Cầu Giấy - Hà Nội</p>
                                    </li>
                                    <li>
                                        <p>0987.654.321 - 0989.989.989</p>
                                    </li>
                                    <li>
                                        <p>vshop@gmail.com</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="block menu-ft policy" id="info-shop">
                                <h3 class="title">Chính sách mua hàng</h3>
                                <ul class="list-item">
                                    <li>
                                        <a href="" title="">Quy định - chính sách</a>
                                    </li>
                                    <li>
                                        <a href="" title="">Chính sách bảo hành - đổi trả</a>
                                    </li>
                                    <li>
                                        <a href="" title="">Chính sách hội viện</a>
                                    </li>
                                    <li>
                                        <a href="" title="">Giao hàng - lắp đặt</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="block" id="newfeed">
                                <h3 class="title">Bảng tin</h3>
                                <p class="desc">Đăng ký với chung tôi để nhận được thông tin ưu đãi sớm nhất</p>
                                <div id="form-reg">
                                    <form method="" action="">
                                        <input type="email" name="email" id="email" placeholder="Nhập email tại đây">
                                        <button disabled="disabled" type="submit" id="sm-reg">Đăng ký</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="foot-bot">
                        <div class="wp-inner">
                            <p id="copyright">© Bản quyền thuộc về unitop.vn | Php Master</p>
                        </div>
                    </div>
                </div>
                </div>
                <div id="menu-respon">
                    <nav>
                        <div class="header-menu">
                            <a href="?page=home" title="" class="logo"><img src="{{ asset('uploads/logo-dd.PNG') }}" alt=""></a>
                            <a class="icon-menu" href=""><i class="fas fa-times"></i></a>
                        </div>
                        <div id="menu-respon-wp">
                            <ul class="" id="main-menu-respon">
                                <li>
                                    <a href="?page=home" title>Trang chủ</a>
                                </li>
                                {{-- <li>
                                    <a href="?page=category_product" title>Điện thoại</a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="?page=category_product" title="">Iphone</a>
                                        </li>
                                        <li>
                                            <a href="?page=category_product" title="">Samsung</a>
                                            <ul class="sub-menu">
                                                <li>
                                                    <a href="?page=category_product" title="">Iphone X</a>
                                                </li>
                                                <li>
                                                    <a href="?page=category_product" title="">Iphone 8</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="?page=category_product" title="">Nokia</a>
                                        </li>
                                    </ul>
                                </li> --}}
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
                                <li>
                                    <a href="{{ url('tin-cong-nghe') }}" title="">Blog</a>
                                    <ul class="sub-menu">
                                        @foreach ($cat_posts as $cat)
                                        <li>
                                            <a href="{{ route('post.cat',$cat->slug) }}" title="">{{ $cat->name }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ url('lien-he.html') }}" title>Liên hệ</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
                {{-- <div class="notification">
                    <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                    <p>Đã thêm sản phẩm vào giỏ hàng</p></div> --}}
                <div class="mask-content-menu"></div>
                <div id="btn-top"><img src="{{ url('public/uploads/icon-to-top.png') }}" alt=""/></div>
                <div id="fb-root"></div>
                <script>(function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id))
                            return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));
                </script>
                </body>
                </html>
                


              