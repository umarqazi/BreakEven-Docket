//jQuery time
$(document).ready(function(){
    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches

    $('.subscription_plan').change(function(){
        var value = $('.subscription_plan').val();

        $.ajax({
            url: base_url+"company/get_subscription",
            type: "POST",
            data: {id : value},
            dataType : 'json',
            success:function(response)
            {
                $('#subscription_name').text(response.name);
                $('#plan_name').text(response.name);
                $('#subscription_price').text(response.price);
                $('#plan_price').text(response.price);
            }
        });

    });

    $('#company-info .next').click(function(){
        var element = $(this);
        var error;
        $("#company-info .input-value").each(function(){
            if($(this).val() == null || $(this).val().length < 1){
                if($('#company-info div#error-msg:has(span)').length < 1){
                    $('#company-info #error-msg').append('<span class="text-danger">Please fill in all' +
                        ' fields</span>');
                }
                error = true;
                return false;
            }else{
                error = false;
            }
        });
        if(error){
            event.preventDefault();
            return;
        }else{
            $('#company-info #error-msg span').remove();
            next(element);
        }
    });

$('#employee-info .next').click(function(){
    var element = $(this);
    var error;
    $("#employee-info .input-value").each(function(){
        if($(this).val().length < 1){
            if($('#employee-info div#error-msg:has(span)').length < 1){
                $('#employee-info #error-msg').append('<span class="text-danger">Please fill in all' +
                    ' fields</span>');
            }
            error = true;
            return false;
        }
    });
    if(error){
        event.preventDefault();
        return;
    }else{
        $('#employee-info #error-msg span').remove();
        next(element);
    }

});

function next(element) {
    if (animating) return false;
    animating = true;

    current_fs = element.parent();
    next_fs = element.parent().next();

    //activate next step on progressbar using the index of next_fs
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    //show the next fieldset
    next_fs.show();
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function (now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale current_fs down to 80%
            scale = 1 - (1 - now) * 0.2;
            //2. bring next_fs from the right(50%)
            left = (now * 50) + "%";
            //3. increase opacity of next_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({
                'transform': 'scale(' + scale + ')',
                'position': 'absolute'
            });
            next_fs.css({'left': left, 'opacity': opacity});
        },
        duration: 800,
        complete: function () {
            current_fs.hide();
            animating = false;
        },
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });
}

$(".previous").click(function(){
    if(animating) return false;
    animating = true;

    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    //de-activate current step on progressbar
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

    //show the previous fieldset
    previous_fs.show();
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale previous_fs from 80% to 100%
            scale = 0.8 + (1 - now) * 0.2;
            //2. take current_fs to the right(50%) - from 0%
            left = ((1-now) * 50)+"%";
            //3. increase opacity of previous_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({'left': left});
            previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
        },
        duration: 800,
        complete: function(){
            current_fs.hide();
            animating = false;
        },
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });
});

$(".submit").click(function(){
    return false;
});

});

function match_password(){
    if($('#employee-info .confirm_password').val() !=''){
        if($('#employee-info .password').val() === $('#employee-info .confirm_password').val()){
            $('#employee-info .password-mismatch').text('');
            $('#employee-info .next').prop('disabled', false);
        }else{
            $('#employee-info .password-mismatch').text('Password And Confirm Password Does Not Match');
            $('#employee-info .next').prop('disabled', true);
        }
    }else{
        $('#employee-info .password-mismatch').text('Please fill out confirm password');
    }
}

function checkemail(type){
    if(type === 'company'){
        var availabilityDiv = '#company-info #availability';
        var button = '#company-info .next';
        var invalidDiv = '#company-info #msg';
        var errorDiv = '#company-info #email_error';
        var email = $('#company-info .company_email').val();
        var table = 'companies';
        $(invalidDiv).empty();
        $(errorDiv).empty();
        $(availabilityDiv).empty();
    }else{
        var availabilityDiv = '#employee-info #availability';
        var button = '#employee-info .next';
        var invalidDiv = '#employee-info #msg';
        var errorDiv = '#employee-info #email_error';
        var email = $('#employee-info .employee_email').val();
        var table = 'users';
        $(invalidDiv).empty();
        $(errorDiv).empty();
        $(availabilityDiv).empty();
    }

    if(email.length > 0){
        if (!(validateEmail(email)))
        {
            $(invalidDiv).text('Invalid Email');
            $(button).attr('disabled', true);
            $(availabilityDiv + ' span').remove();
            return false;
        }else{
            $(button).removeAttr('disabled', false);
        }

        $.ajax({
            url: base_url+"company/get_email",
            type: "POST",
            data: {email : email, table : table },
            dataType : 'json',
            success:function(response)
            {
                if (response > 0)
                {
                    $(availabilityDiv).append('<span class="text-danger pull-left">Email Already Exist</span>');
                    $(button).prop('disabled', true);
                }
                else
                {
                    $(availabilityDiv).append('<span class="text-success pull-left">Email Available</span>');
                    $(button).prop('disabled', false);
                }
            }
        });
    }
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
