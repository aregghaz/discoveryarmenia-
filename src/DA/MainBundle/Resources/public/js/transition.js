$(document).ready(function () {

    /* accommodation transition */
        $('.accommodation_box a').hover(function () {
           var width = $('.price',this).innerWidth();
            $('.price',this).css({
                marginLeft: - width/2
            });
        },function () {
            $('.price',this).css({
                marginLeft: 0
            });
        });
    /* accommodation transition */

    /* map transition */
        setTimeout(function () {
            $('.map_block').css('opacity',1);
        },1000);
    /* map transition */

});