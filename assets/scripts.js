$(document).ready( function() {

    if ($("#searchForm") != 'undefined') {
        $("body").find("#reset").on("click",function (e){//@todo
            //e.preventDefault();
            //alert( $( "form[name='searchForm']" ).attr("name"));
            $('#filter_value').value ='';
            //$( "form" ).first().submit();
        });
    }
});