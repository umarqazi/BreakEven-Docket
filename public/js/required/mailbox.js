$(document).ready( function() {

    $("#job_templates").ckeditor();

    $("#email-body").ckeditor();

    $('#server_files #fileTreeDemo_2').fileTree({
            root: rootPath,
            script: connector,
            folderEvent: 'dblclick',
            expandSpeed: 750,
            collapseSpeed: 750,
            multiFolder: false
        },
        function(file) {
            $('#server_files').modal('toggle');
            file_name = file.substring(file.lastIndexOf('/')+1);
            $('.file_attachments ul').append('<li><span class="glyphicon glyphicon-file"></span><span>' + file_name + '</span><a class="delete_button" onclick="delete_file(this)"><span class="glyphicon glyphicon-remove-circle"></span></a><input type="hidden" value="'+file+'" name="attachments[]"></li>');
        });


    $('input[name=user_type]').change(function() {
        if (this.value == 'public') {
            $(".email-recepient-main-container #email-recepient-main").hide().removeAttr('name').removeAttr('required');
            $(".email-recepient-main-container .public_user").val('').attr('name','receiver[]').attr('required','true');
            $("#email_recepient_main_chosen").css('display','none');
            $(".email-recepient-main-container .bootstrap-tagsinput").css('display','inline-block');

            $(".email-recepient-cc-container #email-recepient-cc").hide().removeAttr('name').removeAttr('required');
            $(".email-recepient-main-container .public_user_cc").val('').attr('name','cc_recipient[]');
            $(".email-recepient-cc-container").css('display','none');
            $('.email-recepient-main-container.public_cc').css("display" , "block");


            $(".email-recepient-bcc-container #email-recepient-bcc").hide().removeAttr('name').removeAttr('required');
            $(".email-recepient-main-container .public_user_bcc").val('').attr('name','bcc_recipient[]');
            $(".email-recepient-bcc-container").css('display','none');
            $('.email-recepient-main-container.public_bcc').css("display" , "block");

        }else if(this.value == 'users'){
            $(".email-recepient-main-container .bootstrap-tagsinput").css('display','none');
            $(".email-recepient-main-container #email-recepient-main").attr('name','receiver[]').attr('required','true');
            $("#email_recepient_main_chosen").css('display','inline-block');
            $(".email-recepient-main-container .public_user").css('display','none').removeAttr('name').removeAttr('required');
            $(".email-recepient-main-container .email_invalid").css('display','none');
            $("#send-email").removeAttr('disabled');

            $(".email-recepient-bcc-container").show();
            $(".email-recepient-bcc-container #email-recepient-bcc").attr('name','bcc_recipient[]').attr('required','true');
            $(".email-recepient-main-container .public_user_bcc").hide().removeAttr('name').removeAttr('required');
            $('.email-recepient-main-container.public_cc').css("display" , "none");

            $(".email-recepient-cc-container").show();
            $(".email-recepient-cc-container #email-recepient-cc").attr('name','cc_recipient[]').attr('required','true');
            $(".email-recepient-main-container .public_user_bcc").hide().removeAttr('name').removeAttr('required');
            $('.email-recepient-main-container.public_bcc').css("display" , "none");
        }
    });

    $(".mailbox-mobile-menu-control").click(function(){
        $("#mailbox-menu-actual").slideToggle();

        /* Handles Show/Hide Cc/Bcc */
        $("#add-cc").on("click", function(e){
            $(".email-recepient-cc-container").slideToggle(300);
            $(this).fadeToggle(300);
            e.preventDefault();
        });
        $("#remove-cc").on("click", function(e){
            $(".email-recepient-cc-container").slideToggle(300);
            $("#add-cc").fadeToggle(300);
            e.preventDefault();
        });

        $("#add-bcc").on("click", function(e){
            $(".email-recepient-bcc-container").slideToggle(300);
            $(this).fadeToggle(300);
            e.preventDefault();
        });
        $("#remove-bcc").on("click", function(e){
            $(".email-recepient-bcc-container").slideToggle(300);
            $("#add-bcc").fadeToggle(300);
            e.preventDefault();
        });
    });

    var a = 0;
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

function limitwords(){
    var num_words = $("input#email-subject").val().trim().split(/\s+/).length;
    if(num_words > 20){
        $(".error").show();
        $(".error").text("Subject should be less than 20 words").css('color', 'red');
        $("#send-email").attr("disabled", true);
    }else{
        $(".error").hide();
        $('#send-email').removeAttr("disabled");
    }
}

function delete_file(obj){
    $(obj).parent().remove();
}

function validate() {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var email = $(".email-recepient-main-container .public_user").val();
    if(email.length>0){
        result = regex.test(email);
        if(result == true){
            $(".email-recepient-main-container .email_invalid").css('display','none');
            $("#send-email").removeAttr('disabled');
        }else{
            $(".email-recepient-main-container .email_invalid").css('display','inline-block');
            $("#send-email").attr('disabled', true);
        }
    }
}
