$(document).ready(function () {

	/* Initialize Datepicker */
	$('#datetimepicker_from').datetimepicker({
		format: 'MM/DD/YYYY'
	});

	$('#datetimepicker_to').datetimepicker({
		format: 'MM/DD/YYYY'
	});

	/* Add Labels into Date Field */
	$('#datetimepicker_from input').attr('placeholder', "From");
	$('#datetimepicker_to input').attr('placeholder', "To");
});

$('.generate_report').click(function () {

	var from = $('input[name = "date_from"]').val();
	var to = $('input[name = "date_to"]').val();
	var valid = true;

	$('.sales_report_buttons .required').each(function () {
		$(".error").remove();
	});

	$('.sales_report_buttons .required').each(function () {

		if ($(this).val().length < 1) {
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

	if (valid) {

		$.ajax({
			url: base_url + 'estimating/generate_sales_report',
			type: 'post',
			dataType: 'json',
			data: {from: from, to: to},
			success: function (response) {
				console.log(response);

				if (response['html']) {
					$('.sales_report_table_wrapper').html('');
					$('.sales_report_table_wrapper').html(response['html']);
				} else {
					$('.sales_report_footer_summary').html('');
					$('.sales_report_table_wrapper').html('<div class="empty_sales_report">No Report Exists for this Interval.</div>');
				}

				if (response['company_totals'] && response['html']) {
					var footer_html = '';
					footer_html += '<div class="footer_cash_sales"><span class="title">Cash Sales</span><span class="footer_amount"> $' + response['company_totals']['received'].toLocaleString("en") + '</span></div>';
					footer_html += '<div class="footer_accural_sales"><span class="title">Accural Sales</span><span class="footer_amount"> $' + response['company_totals']['jobs_invoiced'].toLocaleString("en") + '</span></div>';
					$('.sales_report_footer_summary').html(footer_html);
				}

				$(".generate_pdf").removeAttr('disabled');
			}
		});
	}
});

$('#generate_sales_report_pdf').click(function () {
	if (!$('#generate_sales_report_pdf').is('[disabled=disabled]')) {
		$('#create_sales_report').submit();
	}
});
