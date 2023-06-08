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
                        <a href="" title="">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        <form name="form-checkout" action="{{ url('lien-he/store') }}" method="POST">
            @csrf
            <div class="section" id="contact-info-wp">
                <div class="section-head">
                    <h1 class="section-title">Liên hệ trực tuyến</h1>
                </div>
                <div class="section-detail">
                    <div class="form-row">
                        <div class="form-col">
                            <label for="fullname">Họ tên</label>
                            <input type="text" name="fullname" id="fullname" class="@error('fullname') invalid @enderror" value="{{ old('fullname') }}">
                            @error('fullname')
                            <div class="error">{{ $message }} !</div>
                            @enderror
                        </div>
                    </div>
                        <div class="form-row">
                            <div class="form-col">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="@error('email') invalid @enderror" value="{{ old('email') }}">
                                @error('email')
                                <div class="error">{{ $message }} !</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" name="phone" id="phone" class="@error('phone') invalid @enderror" value="{{ old('phone') }}">
                                @error('phone')
                                <div class="error">{{ $message }} !</div>
                                @enderror
                            </div>
                        </div>  
                        <div class="form-row">
                            <div class="form-col">
                                <label for="notes">Ghi chú</label>
                                <textarea name="note"></textarea>
                            </div>
                        </div>
                </div>
                <div class="place-contact-wp">
                    <input type="submit" id="send-now" value="Gửi tin">
                </div>
            </div>
    </form>
    <div class="section" id="map-wp">
        <div class="section-head">
            <h1 class="section-title">Thông tin liên hệ</h1>
        </div>
        <div class="section-detail">
            <p>Tư vấn, Cskh: 0784490686</p>
            <p>Số điện thoại liên hệ : 0961627729</p>
            <p>Email liên hệ: ndinhduong99@gmail.com</p>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d501725.3382147796!2d106.41502403989591!3d10.755341096674579!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529292e8d3dd1%3A0xf15f5aad773c112b!2zSOG7kyBDaMOtIE1pbmgsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1672058949888!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    </div>
</div>
@endsection