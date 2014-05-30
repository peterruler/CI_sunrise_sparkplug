var myList = {};
myList.reorderList = function(filter_by) {
    console.log('reorder');
    var sortByID = document.getElementsByName('filter_by');
    sortByID.value = filter_by;

    var dirID = document.getElementsByName('direction')
    var dirValue = dirID.value;
    if(dirValue == 'ASC') {
        dirID.value = "DESC";
    } else{
        dirID.value = "ASC";
    }
    console.log( $('#listForm').attr('name'));
    $("#listForm").submit();
}
$(document).ready( function() {
    if ($("#searchForm") != 'undefined') {
        $("body").find("#reset").on("click",function (e){//@todo
            //e.preventDefault();
            //alert( $( "form[name='searchForm']" ).attr("name"));
            $('#filter_value').value ='';
            //$( "form" ).first().submit();
        });
    }
$('.order_list').each( function(index,elem) {
    $(this).on('click', function(evt) {
        console.log('clicked');
        evt.preventDefault();
        var name = $(this).attr('name');
        myList.reorderList(name);
    });
    });
});
