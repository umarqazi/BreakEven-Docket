Dropzone.autoDiscover = false;
$(document).ready(function(){
    //dropzone code for file upload
    var myDropzone = new Dropzone("div#myId", {
        url: fileUploadUrl
    });
    if(formType == 'create'){
        myDropzone.on("success", function(file, r){
            // r is server response
            var full_path = documentRoot + '/uploads/temp/' + file.name;
            $("#files").append("<input type='hidden' value='"+ full_path +"' name='user_file[]'>");
        });
        // end dropzone code
    }
    $('#hire_date').datetimepicker({
        format: 'MM/DD/YYYY'
    });

    $('#release_date').datetimepicker({
        format: 'MM/DD/YYYY'
    });

    /*$('.delete_btn').on('click', function(e) {
        e.preventDefault();
        $('#delete_confirmation').modal('show');
        var href = $(this).attr('href');
        $("#delete_confirmation #btnYes").attr('href',href);
    });
*/
});
$(function () {
	$('.phone_us').mask('000-000-0000');
});
function delete_file_confirmation(file,user){
    event.preventDefault();
    $('#delete_file_confirmation').modal('show');
    $("#delete_file_confirmation #btnYes").attr('onclick','delete_file('+ file + ',' + user +')');
}

function delete_file(file_id,user_id){
    event.preventDefault();
    $.ajax({
        type:"POST",
        url: deleteFileUrl,
        data : {file_id:file_id,user_id:user_id},
        success: function(response){
            $('.files_list_'+parseInt(file_id)).hide(500);
            $('#delete_file_confirmation').modal('hide');
        }
    });
}

function checkemail(){
    $('#msg').empty();
    $('#email_error').empty();
    $('#availability').empty();
    var email = $('#exampleInputEmail1').val();
    if(formType == 'create'){
        var old_email = null;
    }else{
        var old_email = $('input[name="old_email"]').val();
    }
	if(email != ''){
		if (!(validateEmail(email)))
		{
			$('#msg').append('Email Address is Required!');
			e.preventDefault();
		}
	}

    $.ajax({
        url: chechEmailUrl,
        type:"POST",
        data:{email : email, old_email : old_email },
        dataType : 'json',
        success:function(response)
        {
            if (response == false)
            {
                $('#availability').append('<span class="text-danger">Email Already Exists</span>');
                $('.save_employee').prop('disabled', true);
            }
            else
            {
				if(email != ''){
					$('#availability').append('<span class="text-success">Email Available</span>');
					$('.save_employee').prop('disabled', false);
				}
            }

        },
        error:function(response)
        {
            console.log(response);
        }
    })
}

function validateEmail(email)
{
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,3}$/;
    if (filter.test(email))
    {
        return true;
    }
    else
    {
        return false;
    }
}


$("input[name=customer_title]").on('keydown change', function(e){
    var title= $("input[name=customer_title]").val();

    if(parseFloat(title.length) >= '16'   &&  e.keyCode !== 46 && e.keyCode !== 8 ){
        e.preventDefault();
        $("#title, .valid_customer_title").text('The field length should be less then 16!');

    }else if (parseFloat(title.length) < '5'   &&  e.keyCode !== 46 && e.keyCode !== 8 ){

        $("#title, .valid_customer_title").text('The field length should be greater then 5!');

    }else{

        $("#title, .valid_customer_title").text(' ');

    }
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#show_image')
                .attr('src', e.target.result);
                $('.upload_img').show();
        };

        reader.readAsDataURL(input.files[0]);
    }
}