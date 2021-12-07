$('.generate_report').click(function () {
    var from = $('input[name = "start_date"]').val();
    var to = $('input[name = "end_date"]').val();
    var valid = true;

    $('.sales_report_buttons .required').each(function() {
        $( ".error" ).remove();
    });

    $('.sales_report_buttons .required').each(function() {

        if($(this).val().length < 1) {
            $(this).parent().after("<div class='error'>Required!</div>");
            valid = false;
        }
    });

    var d1 = moment(from);
    var d2 = moment(to);

    if (d2 < d1) {
        valid = false;
        $('.sales_report_table_wrapper').html('');
        $('.validation_msg').html("<div class='error'>To must be Greater than From!</div>")
    }

    if(valid) {
        $.ajax({
            url: base_url + 'employee_attendance/generate_user_report',
            type: 'post',
            dataType: 'json',
            data: {from: from, to: to},
            success: function (response) {
                if (response['html']) {
                    $('.user_attendance_report_table_wrapper').html('');
                    $('.user_attendance_report_table_wrapper').html(response['html']);
                } else {
                    $('.user_attendance_report_table_wrapper').html('');
                    $('.user_attendance_report_table_wrapper').html('<div class="empty_sales_report">Sorry, This Employee has no records for this interval.</div>');
                }
                $(".generate_pdf").removeAttr('disabled');
            }
        });
    }
});



    if(check_in_time != ''){
        var date1 = new Date(check_in_time);
        var date2 = new Date();
        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        var diffSeconds = Math.ceil(timeDiff / 1000);
    }
    
    $(document).ready(function() {
        if(check_in_time != ''){
            var clock = $('.clock').FlipClock({
                clockFace:'DailyCounter',
                autoStart:false,
                callbacks: {
                    stop:function() {
                        $('.message').html('The clock has stopped!')
                    }
                }
            });
            clock.setTime(diffSeconds);
            clock.start();
        }

        /*Initialize Datepicker*/
        $('#datetimepicker_from').datetimepicker({
            format: 'MM/DD/YYYY'
        });
        $('#datetimepicker_to').datetimepicker({
            format: 'MM/DD/YYYY'
        });

        /*Add Labels into Date Field*/
        $('#datetimepicker_from input').attr('placeholder', "From");
        $('#datetimepicker_to input').attr('placeholder', "To");
    });

    function checkin(){
        $.ajax({
            url: base_url+"/checkin",
            success: function(){
                location.reload();
            }
        });
    }

    function checkout(id){
        $.ajax({
            type: 'POST',
            data: {
                id:id
            },
            url:base_url+"/checkout",
            success: function(){
                location.reload();
            }
        });
    }

    function breaks(id){
        $.ajax({
            type: 'POST',
            data: {
                id:id
            },
            url: base_url+"/break",
            success: function(){
                location.reload();
            }
        });
    }

    function resume(id){
        $.ajax({
            type: 'POST',
            data: {
                id:id
            },
            url: base_url+"/resume",
            success: function(){
                location.reload();
            }
        });
    }