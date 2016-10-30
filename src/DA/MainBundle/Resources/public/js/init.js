$(document).ready(function () {
    var prefix = $("body").attr('data-prefix');
    var locale = $("body").attr('data-locale');
    /* header -------------------------------- */
        var menuLi = $('.general_menu menu li');
        menuLi.each(function () {
           var img = $('img',this);
           var w = $('img',this).width();
            img.css('margin-left',-w/2);
        });
        menuLi.hover(function () {
           var index = $(this).index();
           var img = $('img',this);
            switch (index){
                case 1:
                    img.addClass('magictime tinLeftIn');
                    break;
                case 5:
                    img.addClass('magictime foolishIn');
                    break;
                default:
                    img.addClass('magictime boingInUp');
                    break;
            }
        },function () {
            var index = $(this).index();
            var img = $('img',this);
            switch (index){
                case 1:
                    img.removeClass('magictime tinLeftIn');
                    break;
                case 5:
                    img.removeClass('magictime foolishIn');
                    break;
                default:
                    img.removeClass('magictime boingInUp');
                    break;
            }
        });

        $('.languages_block ul > li').hover(function () {
           $('.sub_lang').stop().slideDown(400);
        },function () {
            $('.sub_lang').stop().slideUp(400);
        });
        $('.currency_block ul > li').hover(function () {
           $('.sub_currency').stop().slideDown(400);
        },function () {
            $('.sub_currency').stop().slideUp(400);
        });

        $('li.dropdown').hover(function () {
            $('.sub-menu',this).stop().fadeIn(600);
        },function () {
            $('.sub-menu',this).stop().fadeOut(600);
        });
    /* header -------------------------------- */

    /* slider -------------------------------- */
        try{
            $('.home_slider').slick({
                dots: true,
                infinite: true,
                speed: 1500,
                fade: true,
                draggable: false,
                customPaging: function (slider, i) {
                    return '<span class="tab">' + $('.slick-thumbs li:nth-child(' + (i + 1) + ')').html() + '</span>';
                }
            });
            $('.excursion_slider').slick({
                dots: true,
                infinite: false,
                speed: 1200,
                draggable: false,
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: false,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 1
                        }
                    }
                ]
            });
            
            
        }
        catch (err){

        }
    /* slider -------------------------------- */

    /* semantec -------------------------------- */
        
    /* semantec -------------------------------- */

    /* carousel -------------------------------- */
    setSliderWrapper();
    function setSliderWrapper() {
        var count = 0;
        $('.gallery_carousel .slide').each(function(){
            $('.img',this).each(function(){
                count += $(this).outerWidth()+10;
            });

            $(this).css('width',count - 10);
            count = 0;
        });
        /*$('.gallery_tour .slide').css('width',count* 230);*/
        }
        if($('.gallery_carousel').length > 0){
            $('.gallery_carousel').mCustomScrollbar({
                axis:"x",
                theme: 'inset',
                scrollButtons:{enable:true}
            });
        }

    /* carousel -------------------------------- */

    /* calendar -------------------------------- */
        if($('.calendar').length > 0){
            $('.calendar').calendar({
                type: 'date',
                formatter: {
                    date: function (date, settings) {
                        if (!date) return '';
                        var day = date.getDate();
                        var month = date.getMonth() + 1;
                        var year = date.getFullYear();
                        if(day < 10){
                            day = '0'+day;
                        }
                        return month + '/' + day + '/' + year;
                    }
                }
            });
        }

    /* calendar -------------------------------- */

    $('.edit').click(function () {
        var id = $(this).data('id');
        $(this).css('display','none');
        $('.row'+id+' .ok').css('display','inline');
        $('.row'+id+' .basketCalendar > div').addClass('not_readonly');
        $('.row'+id+' .basketCalendar > .not_readonly').calendar({
            type: 'date',
            formatter: {
                date: function (date, settings) {
                    if (!date) return '';
                    var day = date.getDate();
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    if(day < 10){
                        day = '0'+day;
                    }
                    return month + '/' + day + '/' + year;
                }
            }
        });
        $('.row'+id+' input').removeAttr('readonly');

    });
    $('.ok').click(function () {
        var id = $(this).data('id');
        $(this).css('display','none');
        $('.edit').css('display','inline');
        $('.row'+id+'.basketCalendar >div').removeClass('not_readonly');
        $('.row'+id+'.ui.calendar').remove();
        $('.row'+id+'.basketCalendar').click(false);
        $('.row'+id+' input').attr('readonly','readonly');
        $('.row'+id+'.basketCalendar > .not_readonly').calendar({
            type: 'date',
            formatter: {
                date: function (date, settings) {
                    if (!date) return '';
                    var day = date.getDate();
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    return month + '/' + day + '/' + year;
                }
            }
        });
    });
    var total = $('.total').data('p');
    $('.remove').click(function () {
        var id = $(this).data('id');
        var price = $('.row'+id+' .pp').data('p');
        var currency = $('.row'+id+' .pp').data('c');

        $('.total span').text(total - price+currency);
        total = total - price;

        $('.row'+id).remove();

    });
    
    /* scroll -------------------------------- */
        if($('#tour_info').length > 0){
            var top = $('#tour_info').offset().top;
            $(window).scroll(function () {
                var scrollTop = $(this).scrollTop();
                if(scrollTop > top){
                    $('#tour_info').css({
                        position: 'fixed',
                        top: 0,
                        left: 0
                    });
                }
                else{
                    $('#tour_info').css({
                        position: 'relative',
                        top: 0,
                        left: 0
                    });
                }
            });
        }

    /* scroll -------------------------------- */


    /* order -------------------------------- */
        var arr;

        function addToCart(arr) {
            $.ajax({
                url: prefix+'/api/add/basket',
                type: 'post',
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                data: JSON.stringify(arr),
                success: function(msg) {
                    console.log('asdasd');
                    $('.ui.accpetModal')
                        .modal('show')
                    ;
                }

            });
            $.ajax({
                url: prefix+'/api/check/basket',
                type: 'post',
                success: function(c) {
                    $('.order_count').css('display','block');
                    $('.order_count').text(c)
                }

            });
        }
        function timeDifference(laterdate,earlierdate) {
            var difference = laterdate.getTime() - earlierdate.getTime();

            var daysDifference = Math.floor(difference/1000/60/60/24);
            difference -= daysDifference*1000*60*60*24

            var hoursDifference = Math.floor(difference/1000/60/60);
            difference -= hoursDifference*1000*60*60

            var minutesDifference = Math.floor(difference/1000/60);
            difference -= minutesDifference*1000*60

            var secondsDifference = Math.floor(difference/1000);

            return daysDifference;
        }
        $('.add_to_cart').on('click',function () {

            var setFrom = $('#setFrom input').val();
            var setTo =  $('#setTo input').val();

            var t = timeDifference(new Date(setTo),new Date(setFrom));

            var visitors =  $('#visitors input').val();
            var id = $(this).data('id');
            var type = $(this).data('type');
            var price = $(this).data('price');
            var title = $(this).data('name');

            if(type == 'rent_car'){
                var t1 = t+1;
                if(t >= 10 ){
                    price = $('.car'+id+' .day_more').data('price')
                }
                else{
                    price = $('.car'+id+' .day'+t+'_'+t1).data('price');
                }
            }
            console.log(price);
           arr = {  id: id,
                    type: type,
                    setFrom: setFrom,
                    setTo: setTo,
                    visitors: visitors,
                    price: price,
                    title: title,
           };
             addToCart(arr);
        });

    $('.openmodal').click(function () {

        $('.first.modal')
            .modal('show')
        ;
        $('.calendar').calendar({
            type: 'date',
            formatter: {
                date: function (date, settings) {
                    if (!date) return '';
                    var day = date.getDate();
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    if(day < 10){
                        day = '0'+day;
                    }
                    return month + '/' + day + '/' + year;
                }
            }
        });
        var id = $('.addd',this).data('id');
        var type = $('.addd',this).data('type');
        var price = $('.addd',this).data('price');
        var title = $('.addd',this).data('name');

        $('.add_to_cart').attr('data-id',id);
        $('.add_to_cart').attr('data-type',type);
        $('.add_to_cart').attr('data-price',price);
        $('.add_to_cart').attr('data-name',title);

    });
    
    /* order -------------------------------- */
    $('.send_request_block span').click(function () {
        $('.request_form').slideToggle(500);
    });
});