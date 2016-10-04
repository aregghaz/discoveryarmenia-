$(document).ready(function () {
    $('.tokenfield').tokenfield({
    });


    $('select.adminSelect').change(function(el){
        var elt = $(this);
        var text = elt[0].options[elt[0].options.selectedIndex].text;
        
    });
});