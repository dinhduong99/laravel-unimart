$(document).ready(function() {
    $('.nav-link.active .sub-menu').slideDown();
    // $("p").slideUp();

    $('#sidebar-menu .arrow').click(function() {
        $(this).parents('li').children('.sub-menu').slideToggle();
        $(this).toggleClass('fa-angle-right fa-angle-down');
    });

    $("input[name='checkall']").click(function() {
        var checked = $(this).is(':checked');
        $('.table-checkall tbody tr td input:checkbox').prop('checked', checked);
    });

    setTimeout(function(){
        $(".alert.alert-success").hide("2000")
    }, 2500);
    
    setTimeout(function(){
        $(".alert.alert-danger").hide("2000")     
    }, 2500);
 
    $('input#name').keyup(function(){
            let str = $(this).val();
            let data_url= $(this).attr('data-url')
            let token = $("#token").val();
            let data = {
                str: str,
                token: token,
                data_url: data_url
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: data_url,
                method: 'POST',
                data: data,
                dataType: 'json',
                success: function(data) {
                    $('input#slug').val(data.slug);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                },
            });
    })

    $('input#price').keyup(function(){
        var price = $(this).val();
        var percent_price = $('input#percent_price').val();
        if(percent_price > 0){
            percent_price = $('input#percent_price').val();
            var sale_price = price -(price * percent_price / 100);
        }else{
            percent_price = 0;
            var sale_price = 0;
        }
       $('input#percent_price').val(percent_price);
       $('input#sale_price').val(sale_price);
    });
    $('input#percent_price').keyup(function(){
        var percent_price = $(this).val();
        var price = $('input#price').val();
        if(price > 0){
            price = $('input#price').val();
            var sale_price = price -(price * percent_price / 100);
        }else{
            price = 0;
            var sale_price = 0;
        }
       $('input#sale_price').val(sale_price);
    });
});
