$(document).ready(function () {

    var editor = $('.text_editor');

    if(editor.length > 0){
        textEditor();
    }
    $('.mapSearch').focus(function() {
        $(this).keypress(function(event){
            if (event.keyCode == 13)
            {
                event.preventDefault();
            }
        });
    });
    function textEditor() {
        $('.text_editor').summernote({
            height: 150,
            callbacks: {
                onPaste: function(e) {
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                    e.preventDefault();
                    document.execCommand('insertText', false, bufferText);
                }
            },
            codemirror: { // codemirror options
                theme: 'superhero'
            },
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ]

        });
        $('.note-recent-color').css('background', 'transparent');
    }

});