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