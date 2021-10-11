setTimeout(function() {
    $("#successMessage").hide('blind', {}, 500)
}, 5000);

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