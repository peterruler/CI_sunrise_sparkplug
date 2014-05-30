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
function reorderList(link, order_by) {
    var sortByID = document.getElementsByName('sort_by');
    sortByID.value = order_by;

    var dirID = document.getElementsByName('direction')
    var dirValue = dirID.value;
    if(dirValue == 'ASC') {
        dirID.value = "DESC";
    } else{
        dirID.value = "ASC";
    }
    document.listForm.submit();
}