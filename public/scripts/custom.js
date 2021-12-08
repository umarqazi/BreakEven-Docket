setTimeout(function() {
    $("#successMessage").hide('blind', {}, 500)
}, 2500);
$(document).ready(function () {
    $('#expiry_date').datetimepicker({
        format: 'MM/DD/YYYY'
    });
    $('#renew_date').datetimepicker({
        format: 'MM/DD/YYYY'
    });
    $('#subscription_date').datetimepicker({
        format: 'MM/DD/YYYY'
    });
});

$( document ).ready( function(){
    $(document).on('click', '.delete_btn', function (e) {

        e.preventDefault();
        var link = $(this).attr('href');

        swal({
            title: "Are you sure?",
            text: "You Want to Delete this!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then(function(willDelete){
            if (willDelete) {
                window.location.replace(link);
            }
        });
    });
});
$(document).on('click', '.disable_btn', function (e) {
    e.preventDefault();
    var link = $(this).attr('href');
    swal({
        title: "Are you sure?",
        text: "You Want to Disable this!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then(function(willDelete){
        if (willDelete) {
            window.location.replace(link);
        }
    });
});