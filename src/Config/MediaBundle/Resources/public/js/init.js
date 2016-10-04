$(document).ready(function () {

    $('.material-tooltip').remove();
    var debug = $('body').data('debug');
    var prefix;
    if(debug){
        prefix = '/app_dev.php';
    }
    else{
        prefix = '';
    }

    try {
        $('#tabs').tab();
        /* Dropzone Upload */
        // Template for Upload
        var elem = '<div class="table table-striped clear" class="files" id="previews"> ' +
            '<div id="template" class="file-row col-md-4 gallery_section"> ' +
            '<div>' +
            '<span class="preview"><img data-dz-thumbnail /></span> ' +
            '</div>' +
            '<div class="1">' +
            '<p class="name" data-dz-name></p> ' +
            '<strong class="error text-danger" data-dz-errormessage></strong> ' +
            '</div>' +
            '<div>' +
            '<p class="size" data-dz-size></p> ' +
            '<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"> ' +
            '<div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div> ' +
            '</div>' +
            '</div>' +
            '<div style="display: none">' +
            '<button class="btn btn-primary start"> ' +
            '<i class="glyphicon glyphicon-upload"></i> ' +
            '<span>Start</span>' +
            '</button>' +
            '<button data-dz-remove class="btn btn-warning cancel"> ' +
            '<i class="glyphicon glyphicon-ban-circle"></i> ' +
            '<span>Cancel</span>' +
            '</button>' +
            '<button data-dz-remove class="btn btn-danger delete"> ' +
            '<i class="glyphicon glyphicon-trash"></i> ' +
            '<span>Delete</span>' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</div>';

        var uploadInput = '<div class="upload_input btn btn-primary btn-file">Browse ...</div>'
        var block = $('.upload').parent();
        block.append(uploadInput);
        block.append(elem);

        var previewNode = document.querySelector("#template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone(document.body, {
            url: prefix+"/api/upload/media",
            maxFilesize: 2,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: true,
            previewsContainer: '#previews',
            clickable: ".upload_input"
        });

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
        });

        myDropzone.on("totaluploadprogress", function(progress) {
            $("#total-progress .progress-bar").css('width' , progress+'%');
        });
        var arr = [];
        myDropzone.on("success", function(file,response) {
            var id = response.id;

            arr.push(id);
            
            $('#images').attr('value',JSON.stringify(arr));
        });

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            $("#total-progress").css('opacity' , "0");
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
        });

        myDropzone.on("queuecomplete", function(progress) {
            $("#total-progress").css('opacity' , "0");
        });

        $("#actions .start").click(function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
        });
        $("#actions .cancel").click(function() {
            myDropzone.removeAllFiles(true);
        });
        /* Dropzone Upload */


        /* Drag and Drop */
        var panelList = $('#draggablePanelList');
        $('.box_gall .close').click(function(){
            var id = $(this).attr('data-id');
            $(this).parent().parent().append('<input type="hidden" name="remove-'+id+'" value="'+id+'">');
            $(this).parent('div').remove();
        });
        $('.box_gall').each(function (index) {
            var length = $('.box_gall').length;
           $('.number',this).text(index+1);
        });
        var el = document.getElementById('draggablePanelList');
        var sortable = Sortable.create(el,{
            handle: '.panel-heading',
            placeholder: 'placeholder',
            ghostClass: 'ghost',
            onUpdate: function(evt) {
                $('.panel', panelList).each(function(index, elem) {
                    var $listItem = $(elem),
                        newIndex = $listItem.index();
                        console.log(index);
                    var input = $(elem).find('input[type=hidden]');
                    input.attr('value',newIndex+1);
                    $('.number',this).text(index+1)
                });
            }
        });
        /* Drag and Drop */
        
        /* Add Images */
        var arr = [];
        $('#media').click(function(){
            $.ajax({
                type: "post",
                url: prefix + '/api/get/media/0',
                success: function (data) {
                    console.log(data[0]);
                    if ($('#content_list .col-sm-2').length == 0) {
                        for (var index in data[0]) {

                            $('.img .content').append("<div class='col-sm-2'>" +
                                "<div class='add_img' style='background: url("+data[0][index][0]+")" +
                                " no-repeat;background-position: center center;" +
                                "background-size: 100%' data-id="+index+">" +
                                "<div class='file_name'>"+data[0][index][1]+"</div>"+
                                "</div>" +
                                "</div>");
                        }
                        $('.loading').css('display', 'none');
                        var count = data[1];
                        var page = Math.round(count / 16);
                        if ($('#page li').length == 0) {
                            var i = 0;
                            var url = prefix + '/api/get/media/';
                            $('#page').attr('data-page', page);
                            pagination(page, i, url);
                        }
                    }
                    pagerClick();

                    $(".add_img").click(function(){
                        var data = $(this).attr('data-id');
                        var name = 'add_img-'+data;
                        if($(this).hasClass('select_img')){
                            $(this).removeClass('select_img');
                            $('input[name='+name+']').remove();
                            arr.pop(data);
                            $('#all_data').attr('value',JSON.stringify(arr));
                        }
                        else{
                            $(this).addClass('select_img');
                            $('.img .content').append("<input type='hidden' name='"+name+"' value='"+data+"'>");
                            arr.push(data);
                            $('#all_data').attr('value',JSON.stringify(arr));
                        }
                    });
                }
                
            });

        });

        function pagination(page,i,url) {
            i = parseInt(i);
            page = parseInt(page);
            var pageleft = '';
            var pageright = '';

            if(i - 4 > 0)  pageleft = "<li ><a class='pagination_link'  data-href='"+url+(i-5)+"'>"+(i-4)+"</a></li>";
            if(i - 3 > 0)  pageleft += "<li ><a class='pagination_link'  data-href='"+url+(i-4)+"'>"+(i-3)+"</a></li>";
            if(i - 2 > 0)  pageleft += "<li ><a class='pagination_link'  data-href='"+url+(i-3)+"'>"+(i-2)+"</a></li>";
            if(i - 1 > 0)  pageleft += "<li ><a class='pagination_link'  data-href='"+url+(i-2)+"'>"+(i-1)+"</a></li>";
            if(i - 0 > 0)  pageleft += "<li ><a class='pagination_link'  data-href='"+url+(i-1)+"'>"+(i-0)+"</a></li>";


            if(i + 0 < page)  pageright = "<li class='active'><a class='pagination_link'  data-href='"+url+(i+0)+"'>"+(i+1)+"</a></li>";
            if(i + 1 < page)  pageright += "<li ><a class='pagination_link'  data-href='"+url+(i+1)+"'>"+(i+2)+"</a></li>";
            if(i + 2 < page)  pageright += "<li ><a class='pagination_link'  data-href='"+url+(i+2)+"'>"+(i+3)+"</a></li>";
            if(i + 3 < page)  pageright += "<li ><a class='pagination_link'  data-href='"+url+(i+3)+"'>"+(i+4)+"</a></li>";
            if(i + 4 < page)  pageright += "<li ><a class='pagination_link'  data-href='"+url+(i+4)+"'>"+(i+5)+"</a></li>";


            $('#page').children().remove();
            $('#page').append(pageleft+pageright);
            pagerClick();

        }

        function pagerClick() {
            $(".pagination_link").click(function(){
                var url = $(this).attr('data-href');
                $('#page li').removeClass('active');
                $(this).parent().addClass('active');

                $.ajax({
                    type: "post",
                    url: url,
                    success: function(data){
                        var text = url.match(/media\/\d+/i);
                        var i = text[0].match(/\d+/);
                        var uri = prefix + '/api/get/media/';
                        var page = $('#page').attr('data-page');
                        pagination(page,i[0],uri);
                        $('.img .content .col-sm-2').remove();
                        console.log(data[0]);
                        for(var index in data[0]) {

                            $('.img .content').append("<div class='col-sm-2'>" +
                                "<div class='add_img' style='background: url("+data[0][index][0]+")" +
                                " no-repeat;background-position: center center;" +
                                "background-size: 100%' data-id="+index+">" +
                                "<div class='file_name'>"+data[0][index][1]+"</div>"+
                                "</div>" +
                                "</div>");
                            $('.img .content input').each(function(){
                                $('div[data-id='+$(this).attr('value')+']').addClass('select_img');
                            });
                            $('.loading').css('display', 'none');
                        }
                        $(".add_img").click(function(){
                            var data = $(this).attr('data-id');
                            var name = 'add_img-'+data;
                            if($(this).hasClass('select_img')){
                                $(this).removeClass('select_img');
                                $('input[name='+name+']').remove();
                                arr.pop(data);
                                $('#all_data').attr('value',JSON.stringify(arr));
                            }
                            else{
                                $(this).addClass('select_img');
                                $('.img .content').append("<input type='hidden' name='"+name+"' value='"+data+"'>");
                                arr.push(data);
                                $('#all_data').attr('value',JSON.stringify(arr));
                            }
                        });
                    }
                });
            });
        }
        /* Add Images */
        
        
    }
    catch (error){

    }




});