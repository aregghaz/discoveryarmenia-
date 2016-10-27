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
                        return day + '/' + month + '/' + year;
                    }
                }
            });
        }
    /* calendar -------------------------------- */

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

});