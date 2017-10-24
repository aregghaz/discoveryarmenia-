$(document).ready(function () {

    $('.before_video').parent().after('<div class="video_content"><div id="y_video"></div></div>');


    $.ajax({
        url: 'http://youtube.com/get_video_info?video_id=lPIAySVvCSs',
        dataType: "json",
        success: function (data) {
            console.log(data);
        }
    });

});