
$(document).ready(function(){

    /*$('.delete_btn').on('click', function(e) {
        e.preventDefault();
        $('#delete_confirmation').modal('show');
        var href = $(this).attr('href');
        $("#delete_confirmation #btnYes").attr('href',href);
    });*/

    var a = 0;
    //binds to onchange event of your input field
    $('#fileupload').bind('change', function() {
        var ext = $('#fileupload').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
            $('#error1').slideDown("slow");
            $('#error2').slideUp("slow");
            $('#error3').slideUp("slow");
            $("#fileupload").val('');
        }else{
            var picsize = (this.files[0].size);
            if (picsize > 5000000){
                $('#error2').slideDown("slow");
                $('#error1').slideUp("slow");
                $('#error3').slideUp("slow");
                $("#fileupload").val('');
            }else{
                var file = $(this)[0].files[0];
                img = new Image();
                img.src = URL.createObjectURL(file);
                img.onload = function(){
                    if(this.width <= 1024 && this.height <= 768){
                        $('#error1').slideUp("slow");
                        $('#error2').slideUp("slow");
                        $('#error3').slideUp("slow");
                        var reader = new FileReader();
                        reader.onload = function(){
                            var output = document.getElementById('image_preview');
                            output.src = reader.result;
                        };
                        reader.readAsDataURL(file);
                    }else{
                        $('#error1').slideUp("slow");
                        $('#error2').slideUp("slow");
                        $('#error3').slideDown("slow");
                        $("#fileupload").val('');
                    }
                }
            }
        }
    });
});

function edit_material(){
    $("#edit_materials .col-md-8").removeClass('product_details');

    $("#edit_materials select").addClass('form-control-select').removeAttr('disabled').attr('required',true);
    $("#edit_materials input").addClass('form-control-input').removeAttr('readonly').attr('required',true);
    $("#edit_materials #category").addClass('form-control-input').removeAttr('disabled').attr('required',true);
    $("#edit_materials #fileupload").removeAttr('required');
    $(".btn-file").css('display','inline-block').removeAttr('required');
    $(".edit_button").hide();
    $(".update_button").show();
    $(".gallon_sell_rate").hide();
}