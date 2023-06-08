$(document).ready(function () { 
//SEARCH AJAX
$('#head-body #search-wp #s').keyup(function() {
    let _keyword= $(this).val();
    let url= $(this).attr("data-url");
    let url_host=$(this).attr("data-url-host");
    // alert(url_host);
    if (_keyword != '') {   
    $.ajax({
        url: url + "?keyword=" + _keyword,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function(res) {
            // console.table(res);
            var _result ='';
            for (var pro of res) {
                _result += '<div class="product_suggest">';
                _result += '<a href="'+url_host+'/san-pham/'+pro.slug+'">';
                _result += '<div class="item-img">';
                _result += '<img src="'+url_host+'/'+pro.thumbnail+'" alt="">';
                _result += '</div>';
                _result += '<div class="item-infor">';
                _result += '<h3>'+pro.name+'</h3>';
                _result += '<div class="box-price">';
                if(pro.sale_price > 0){
                    _result += '<p class="sale_price">'+pro.sale_price+'đ * </p>';
                    _result += '<p class="price">'+pro.price+'</p>';
                    _result += '<span class="percent_price">-'+pro.percent_price+'%</span>';
                }
                if(pro.sale_price == 0){
                    _result += '<p class="price" style="font-weight:bold;text-decoration:none;">'+pro.price+'đ</p>';
                }
                _result += '</div>';
                _result += '</div>';
                _result += '</a>';
                _result += '</div>';    
    
            }
            $('#head-body #search-wp .search-result').show();
            $('#head-body #search-wp .search-result').html(_result);
        },    
        error: function (jqXHR, textStatus, errorThrown) {},         
    });
    } else {
    $('#head-body #search-wp .search-result').html('');
    $('#head-body #search-wp .search-result').hide();
    } 
    });
//  SLIDER
    var slider = $('#slider-wp .section-detail');
    slider.owlCarousel({
        autoPlay: 4500,
        navigation: false,
        navigationText: false,
        paginationNumbers: false,
        pagination: true,
        items: 1, //10 items above 1000px browser width
        itemsDesktop: [1000, 1], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 1], // betweem 900px and 601px
        itemsTablet: [600, 1], //2 items between 600 and 0
        itemsMobile: true // itemsMobile disabled - inherit from itemsTablet option
    });

//  ZOOM PRODUCT DETAIL
    $("#zoom").elevateZoom({gallery: 'list-thumb', cursor: 'pointer', galleryActiveClass: 'active', imageCrossfade: true, loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'});

//  LIST THUMB
    var list_thumb = $('#list-thumb');
    list_thumb.owlCarousel({
        navigation: true,
        navigationText: false,
        paginationNumbers: false,
        pagination: false,
        stopOnHover: true,
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1000, 4], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 4], // betweem 900px and 601px
        itemsTablet: [768, 4], //2 items between 600 and 0
        itemsMobile: true // itemsMobile disabled - inherit from itemsTablet option
    });

//  FEATURE PRODUCT
    var feature_product = $('#feature-product-wp .list-item');
    feature_product.owlCarousel({
        autoPlay: true,
        navigation: true,
        navigationText: false,
        paginationNumbers: false,
        pagination: false,
        stopOnHover: true,
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1000, 4], //5 items between 1000px and 901px
        itemsDesktopSmall: [800, 3], // betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0
        itemsMobile: [375, 1] // itemsMobile disabled - inherit from itemsTablet option
    });

//  SAME CATEGORY
    var same_category = $('#same-category-wp .list-item');
    same_category.owlCarousel({
        autoPlay: true,
        navigation: true,
        navigationText: false,
        paginationNumbers: false,
        pagination: false,
        stopOnHover: true,
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1000, 4], //5 items between 1000px and 901px
        itemsDesktopSmall: [800, 3], // betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0
        itemsMobile: [375, 1] // itemsMobile disabled - inherit from itemsTablet option
    });

//  SCROLL TOP
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $('#btn-top').stop().fadeIn(150);
        } else {
            $('#btn-top').stop().fadeOut(150);
        }
    });
    $('#btn-top').click(function () {
        $('body,html').stop().animate({scrollTop: 0}, 800);
    });

// CHOOSE NUMBER ORDER
    var value = parseInt($('#num-order').attr('value'));
    $('#plus:not("#plus.plus-cart")').click(function () {
        value++;
        $('#num-order').attr('value', value);
        update_href(value);
    });
    $('#minus:not("#minus.minus-cart")').click(function () {
        if (value > 1) {
            value--;
            $('#num-order').attr('value', value);
        }
        update_href(value);
    });

// CHOOSE NUMBER ORDER CART
    $('.plus-cart').click(function () {
        var value = parseInt($(this).closest('.num-order-cart').find('#num-order').attr('value'));
        value++;
        $(this).closest('.num-order-cart').find('#num-order').attr('value', value).change();
    });
    $('.minus-cart').click(function () {
        let value = parseInt($(this).closest('.num-order-cart').find('#num-order').attr('value'));
        if (value > 1) {
            value--;
            $(this).closest('.num-order-cart').find('#num-order').attr('value', value).change();
        }
    });
//  MAIN MENU
    $('#category-product-wp .list-item > li').find('.sub-menu').after('<i class="fa fa-angle-right arrow" aria-hidden="true"></i>');

//  TAB
    tab();
    //  EVEN MENU RESPON
    // $('html').on('click', function (event) {
    //     var target = $(event.target);
    //     var site = $('#site');

    //     if (target.is('#btn-respon i')) {
    //         if (!site.hasClass('show-respon-menu')) {
    //             site.addClass('show-respon-menu');
    //         } else {
    //             site.removeClass('show-respon-menu');
    //         }
    //     } else {
    //         $('#container').click(function () {
    //             if (site.hasClass('show-respon-menu')) {
    //                 site.removeClass('show-respon-menu');
    //                 return false;
    //             }
    //         });
    //     }
    // });

    $('html').on('click', function (event) {
        var target = $(event.target);
        var site = $('#site');

        if (target.is('#btn-respon i')) {
            if (!site.hasClass('show-respon-menu')) {
                site.addClass('show-respon-menu');
            } else {
                site.removeClass('show-respon-menu');
            }
        } else if(target.is('.mask-content-menu')) {
                if (site.hasClass('show-respon-menu')) {
                    site.removeClass('show-respon-menu');
                    return false;
                }
        }else if(target.is('a.icon-menu i')){
            if (site.hasClass('show-respon-menu')) {
                site.removeClass('show-respon-menu');
                return false;
            }
        }
    });

//  MENU RESPON
    $('#main-menu-respon li .sub-menu').after('<span class="fa fa-angle-right arrow"></span>');
    $('#main-menu-respon li .arrow').click(function () {
        if ($(this).parent('li').hasClass('open')) {
            $(this).parent('li').removeClass('open');
        } else {

//            $('.sub-menu').slideUp();
//            $('#main-menu-respon li').removeClass('open');
            $(this).parent('li').addClass('open');
//            $(this).parent('li').find('.sub-menu').slideDown();
        }
    });


// DELETE PRODUCT CART AJAX
    $("button.del-product").click(function(){
        var _token = $('input[name="_token"]').val();
        var data_url =$(this).attr('data-url');
        var rowid = $(this).attr('data-rowid');
        // alert(data_url);
    let data = {
        rowid:rowid,
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: $(this).attr('data-url'),
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function(data) {
        var str ='<div class="mask-content"></div>';
            str += '<div class="notification">';
            str += '<span><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
            str +='<p>'+data.notification+'</p></div>';
        $("#site").append(str);
        $(".product_"+data.rowid+"").remove();
        setTimeout(function(){
            location.reload();
        }, 800);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        },
    });
        })

// ADD PRODUCT TO CART AJAX
        $('button.add-cart').click(function(){
            var _token = $('input[name="_token"]').val();
            var data_url =$(this).attr('data-url');
            // alert(data_url);
            var id = $(this).attr('data-id');
            var name_product = $('.name_cart_'+id).val();
            var qty_product = $('.qty_cart_'+id).val();
            var price_product = $('.price_cart_'+id).val();
            var thumbnail_product = $('.thumbnail_cart_'+id).val();
            var slug_product = $('.slug_cart_'+id).val();
            var that = $(this);
        let data = {
            id:id,
            name_product: name_product,
            qty_product: qty_product,
            price_product: price_product,
            slug_product:slug_product,
            thumbnail_product:thumbnail_product, 
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            // url: "add-cart-ajax",
            url: data_url,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function(data) {
            var str ='<div class="mask-content"></div>';
            str += '<div class="notification">';
            str += '<span><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
            str +='<p>'+data.notification+'</p></div>';
            $("#site").append(str);
            setTimeout(function(){
                location.reload();
            }, 800);
            // alert(data.notification);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
});
    setInterval(function(){
            $(".mask-content").remove();
            $(".notification").remove();
        }, 20000);

//SELECT CITY-PROVINCE-WARDS
        $('.choose').on('change',(function(){
        var action = $(this).attr('id');
        var matp = $(this).val();
        var result = "";
        var url =$(this).attr('data-url');
        var data = {
            matp: matp,
            action: action 
        };
        if(action == "city"){ 
            result = "province";
        }else{ 
            result = "wards";
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            // dataType: 'json',
            success: function(data) {
                $("#"+result).html(data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    }));  

    $("#customer-info-wp .form-row .form-col input.invalid").on("input", function () {
        $(this).removeClass("invalid");
        $(this).next().css('display', 'none');
    });
    $("#customer-info-wp .form-row .form-col select.invalid").on("change", function () {
        $(this).removeClass("invalid");
        $(this).closest('.form-row').find('.error').css('display', 'none');
    });
    $('#payment-checkout-wp #payment_methods li input[type="radio"]').on("change", function () {
        $(this).closest('ul#payment_methods').find('.error').css('display', 'none');
    });
    $("#order-review-wp input:radio[name=payment-method]").on("change", function () {
        $(this).closest('#payment-checkout-wp').find('.error').css('display', 'none');
    });
  
    // $(".checkout-page .order-review-wp .place-order-wp input[type='submit']").click(function(){
    //     alert("ok");
    // })

    // $(".place-order-wp input[type='submit']").click(function(){
    //     var str ='<div class="mask-content-order"></div>';
    //     str += '<div class="notification-order">';
    //     str += '<span class="spinner"></span>';
    //     str +='<p>Đơn hàng đang được xử lý</p></div>';
    // $("#site").append(str);
    // });

    // setInterval(function(){
    //     $(".mask-content-order").remove();
    //     $(".notification-order").remove();
    // }, 40000);

var $p= $("#post-product-wp .section-desc p").length;
var $h= $("#post-product-wp .section-desc h3").length;
$("#post-product-wp .section-desc h3").slice(0,1).show();
$("#post-product-wp .section-desc p").slice(0,3).show();
$("#seeMore").click(function(e){
  e.preventDefault();
  $("p:hidden").slice(0, $p).fadeIn("slow");
  $("h3:hidden").slice(0,$h).fadeIn("slow");

//   if($("p:hidden,h3:hidden").length == 0){
     $("#seeMore").css('display','none');
    // }
});
});
function tab() {
    var tab_menu = $('#tab-menu li');
    tab_menu.stop().click(function () {
        $('#tab-menu li').removeClass('show');
        $(this).addClass('show');
        var id = $(this).find('a').attr('href');
        $('.tabItem').hide();
        $(id).show();
        return false;
    });
    $('#tab-menu li:first-child').addClass('show');
    $('.tabItem:first-child').show();
}





