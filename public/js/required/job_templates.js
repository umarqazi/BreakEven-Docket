$(document).ready(function(){

    $("#terms_conditions").ckeditor();

    if (invoice_type == 'commercial' || invoice_type == 'quote'){
        $(".change_order_field").hide();
    }
    if(estimate > 0){
        $(".select_customer_dropdown").attr("disabled","disabled");
        $('#estimate_id').val(estimate);
        $.ajax({
            type : 'post',
            data : {id:estimate},
            url : base_url+'invoices/get_est_basic_info',
            dataType : 'json',
            success : function(est){
                var customer = est.customer;
                var estimate_details = est.estimate;
                $("input[name=job_address]").attr("value", estimate_details.street_address).attr("readonly","readonly");
                $("input[name=job_city]").attr("value", estimate_details.zip).attr("readonly","readonly");
                $("input[name=job_name]").attr("value", estimate_details.job_name).attr("readonly","readonly");
                $("input[name=job_no]").attr("value", estimate_details.job_no).attr("readonly","readonly");
                $("input[name=contractor]").attr("value",customer.first_name+' '+ customer.last_name).attr("readonly","readonly");
                $("input[name=con_address]").attr("value",estimate_details.street_address).attr("readonly","readonly");
                $("input[name=con_city]").attr("value",estimate_details.zip).attr("readonly","readonly");
                $("input[name=con_phone]").attr("value",customer.phone).attr("readonly","readonly");
                $("input[name=con_email]").attr("value",customer.email).attr("readonly","readonly");
                $("input[name=con_display_name]").attr("value",customer.display_name).attr("readonly","readonly");
                $(".select_customer_dropdown").val(customer.id).attr("selected","selected");
                $(".invoice_estiamtes_row").append('<input type="hidden" name="customer" value="'+ customer.id+'">');
                if(invoice_type == "change_order"){
                    $(".existing_change_orders").empty();
                }
                $.ajax({
                    type : 'post',
                    data : {estimate : estimate},
                    url : base_url+'invoices/get_estimate',
                    dataType : 'json',
                    success : function(response){
                        var change_order            = {'tables' : '', 'grand_total': 0};
                        var common_invoice_summary  = {'tables' : '', 'grand_total': 0};
                        var areas                   = {'tables' : '', 'grand_total': 0};
                        var miscellaneous           = {'tables' : '', 'grand_total': 0};
                        var subcontractors          = {'tables' : '', 'grand_total': 0};
                        var time_materials          = {'tables' : '', 'grand_total': 0};
                        var final_table_data        = '';

						areas               = get_area_details(response.areas, null, 'estimate', invoice_type);
						miscellaneous       = get_miscellaneous_details(response.miscellaneous, null, 'estimate', invoice_type);
						subcontractors      = get_subcontractor_details(response.subcontractors, null, 'estimate', invoice_type);
						time_materials      = get_time_materials_details(response.time, null, 'estimate', invoice_type);

                        if (invoice_type == "common invoice")
                        {
                            common_invoice_summary      = get_common_invoice_summary(common_invoice_id , estimate);
                        }
                        if (response.changeorder.length && (invoice_type == "change_order" || invoice_type == "common invoice")){
                            if (changeOrderId != 0){
                                var change_order_array = [];
                                change_order_array.push(changeOrderId);
                                change_order = get_change_orders(response , change_order_array);
                            } else {
                                change_order = get_change_orders(response);
                            }
                        } else{
                            change_order['grand_total'] = 0;
                            change_order['tables'] = '';
                        }

                        if(invoice_type == "change_order") {
                            final_table_data = change_order['tables'];
                        } else {
                            final_table_data = areas['tables'] + miscellaneous['tables'] + subcontractors['tables'] + time_materials['tables'] + change_order['tables'] + common_invoice_summary['tables'];
                        }
                        var grand_total_all = 0;
                        var grand_scope_total = 0;
                        var grand_change_order_total = 0;

                        if (invoice_type == "common invoice")
                        {
                            grand_total_all = parseFloat(common_invoice_summary['balance_due']);
                        } else {
                            grand_scope_total = parseFloat(areas['grand_total']) + parseFloat(miscellaneous['grand_total']) + parseFloat(subcontractors['grand_total']) + parseFloat(time_materials['grand_total']);

                            // To sum up All the Change Orders Prior to this Change Order
                            // Including estimate Total + Sum of All Prior Change Orders.

                            if (invoice_type == 'change_order') {
                                var total = 0;
                                $.ajax({
                                    type : 'post',
                                    data : {estimate : estimate, change_order: changeOrderId},
                                    url : base_url+'invoices/get_change_order_invoices',
                                    dataType : 'json',
                                    async: false,
                                    success : function(response){

                                        var status = 0;
                                        var change_order_no = 0;

                                        for ($i=0; $i<response.length; $i++){

                                            if (response[$i].change_order_no >9){
                                                change_order_no = response[$i].change_order_no;
                                            } else {
                                                change_order_no = '0'+response[$i].change_order_no;
                                            }
                                            total += parseFloat(response[$i].co_no_amount);
                                            status = check_status(response[$i].estimate_id ,response[$i].change_order_no);
                                            if(status == 1 ) {
                                                // total += parseFloat(response[$i].co_no_amount);
                                                $('#change_order_trail_id').append('<strong>Change Order '+ change_order_no +' Sum <span> </span></strong><input type="text" class="no-border" value="$'+ parseFloat(response[$i].co_no_amount).toFixed(2) + '" readonly> '+
                                                    '<div style="display: inline-block;padding-left: 30px ;"> <span style="display: none"><input name='+$i+' type="radio" checked onchange = "change_order_status_loop('+response[$i].estimate_id +','+response[$i].change_order_no +', this )"  value="1"> Accepted</span>' +
                                                    '<input type="radio" style="margin-left: 30px;" name='+$i+' onchange = "change_order_status_loop('+response[$i].estimate_id +','+response[$i].change_order_no +', this )" value="0"> Declined</div> <br>') ;
                                            }

                                            else {
                                                $('#change_order_trail_id').append('<strong>Change Order '+ change_order_no +' Sum <span></span></strong><input type="text" class="no-border" value="$'+ parseFloat(response[$i].co_no_amount).toFixed(2) + '" readonly> '+
                                                    '<div style="display: inline-block;padding-left: 30px ;"> <span style="display: none"><input name='+$i+' type="radio" onchange = "change_order_status_loop('+response[$i].estimate_id +','+response[$i].change_order_no +', this )"  value="1"> Accepted</span>' +
                                                    '<input type="radio" style="margin-left: 30px;" name='+$i+' checked onchange = "change_order_status_loop('+response[$i].estimate_id +','+response[$i].change_order_no +', this )" value="0"> Declined</div> <br>') ;
                                            }



                                        }

                                        var current_change_order_no = 0;
                                        if((response.length + 1) > 9) {
                                            current_change_order_no = (response.length + 1) ;
                                        }
                                        else {
                                            current_change_order_no = '0'+ (response.length + 1);
                                        }
                                        status = current_change_order_status(changeOrderId) ;
                                        grand_change_order_total = parseFloat(change_order['grand_total']);
                                        if (status == 1) {
                                            //  grand_change_order_total = parseFloat(change_order['grand_total']);
                                            $('#current_change_order_id').append('<strong class="co_no" >Change Order '+ current_change_order_no +' Sum <span class="co_number" ></span></strong><input type="text" class="no-border" name="co_no_amount"  value="$' + grand_change_order_total.toFixed(2) + '"readonly > ' +
                                                '<div style="display: inline-block;padding-left: 30px ;"> <span style="display: none"><input name="Co_status"type="radio" checked onchange = "change_order_status(changeOrderId, this)"  value="1"> Accepted</span>' +
                                                '<input type="radio" style="margin-left: 30px;" name="Co_status" onchange = "change_order_status(changeOrderId, this)" value="0"> Declined</div>');
                                        }

                                        else {
                                            $('#current_change_order_id').append('<strong class="co_no" >Change Order ' +  current_change_order_no +' Sum <span class="co_number" ></span></strong><input type="text" class="no-border" name="co_no_amount"  value="$' + parseFloat(change_order['grand_total'].toFixed(2)) + '"readonly > ' +
                                                '<div style="display: inline-block;padding-left: 30px ;"> <span style="display: none"><input name="Co_status"type="radio" checked  onchange = "change_order_status(changeOrderId, this)"  value="1"> Accepted</span>' +
                                                '<input type="radio" style="margin-left: 30px;" name="Co_status" onchange = "change_order_status(changeOrderId, this)" value="0"> Declined</div>');


                                        }

                                    }
                                });


                            }

                            grand_scope_total = parseFloat(grand_scope_total);
                            grand_total_all = grand_scope_total + grand_change_order_total;


                        }

                        grand_total_all = grand_total_all.toFixed(2);
                        grand_scope_total = grand_scope_total.toFixed(2);
                        grand_change_order_total = grand_change_order_total.toFixed(2);
                        //separation of int part
                        var grand_intpart = Math.floor(grand_total_all);
                        var grand_change_order_intpart = Math.floor(grand_change_order_total);

                        //separation of decimal part
                        var decimal = (grand_total_all % 1).toFixed(2);
                        var change_order_decimal = (grand_change_order_total % 1).toFixed(2);

                        //to remove point
                        var decimal_value = decimal + '';
                        var change_order_decimal_value = change_order_decimal + '';
                        var dec = parseInt(decimal_value.replace('.', ''));
                        if (dec<10){
                            dec = '0'+dec;
                        }
                        var dec_fraction = dec+'/100';
                        //int value to words
                        var str = toWords(grand_intpart);
                        str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                            return letter.toUpperCase();
                        });
                        grand_intpart = grand_intpart.toLocaleString("en");
                        grand_change_order_intpart = grand_change_order_intpart.toLocaleString("en");
                        grand_intpart = grand_intpart + '.' + decimal_value.split('.')[1];
                        grand_change_order_intpart = grand_change_order_intpart + '.' + change_order_decimal_value.split('.')[1];

                        $('input[name="change_order"]').attr('value', changeOrderId);

                        if(invoice_type == "commercial"){
                            $("input[name=numeric_money]").attr('value', grand_intpart);
                            $("input[name=written_money]").attr('value', str);
                            $("input[name=decimal_value]").attr('value', dec_fraction);
                        }
                        else if(invoice_type=="quote"){
                            $("input[name=numeric_money]").attr('value',grand_total_all);
                        }

                        if (invoice_type == 'common invoice'){
                            var grand_total_html = '<p><span><b>Please Pay : </b></span><span> $'+ grand_intpart +'</span></p>';
                        } else if (invoice_type == 'change_order' || invoice_type == 'work_order'){
                            var grand_total_html = '';
                        } else {
                            var grand_total_html = '<p><span><b>Grand Total : </b></span><span> $'+ grand_intpart +'</span></p>';
                        }
                        var final_html = final_table_data + grand_total_html;

                        $("#job_templates").ckeditor();
                        CKEDITOR.instances.job_templates.setData(final_html, function()
                        {
                            this.checkDirty();
                        });

                        if(invoice_type == "change_order"){
                            var display = parseFloat(grand_total_all) + total ;

                            $('input[name="prior_total"]').attr('value', '$'+grand_scope_total);
                            $('input[name="total_due"]').attr('value', '$'+parseFloat(display).toFixed(2));

                            // Call to get Change Order Number from DB and fill invoice.
                            if (changeOrderId != 0) {
                                $.ajax({
                                    url: base_url + 'invoices/get_change_order_info',
                                    type: 'post',
                                    dataType: 'json',
                                    data: {id: changeOrderId},
                                    async: false,
                                    success: function (response) {
                                        if (response['change_order'] >9){
                                            $('input[name="change_order_no"]').attr('value', response['change_order']);
                                        } else{
                                            var value = '0' + response['change_order'];
                                            $('input[name="change_order_no"]').attr('value', value);
                                        }
                                    }
                                });
                            }

                            // Call to get Customer and Job Info from DB and Fill invoice.
                            $.ajax({
                                type : "post",
                                data : { customer_id : est.customer_id },
                                dataType : "json",
                                url  : base_url+"invoices/fetch_customer_jobs",
                                success : function(jobs){
                                    $('.parent_job').removeAttr('disabled');
                                    $('.parent_job').children('option:not(:first)').remove();
                                    if(jobs != null){
                                        for ( i=0; i<jobs.length; i++){
                                            $(".parent_job").append("<option value='" + jobs[i].job_no + "'>" + jobs[i].job_no + "</option>");
                                        }
                                    }
                                }
                            });
                        }

                        /*Enable the Generate PDF Button unless data has been fully Loaded*/
                        if (grand_intpart != '0.00' && invoice_type == 'commercial') {
                            $('#generate_pdf').prop('disabled', false);
                            $('#send_mail_button').show();
                        } else if (grand_change_order_intpart != '0.00' && invoice_type == 'change_order') {
                            $('#generate_pdf').prop('disabled', false);
                            $('#send_mail_button').show();
                        } else if (invoice_type == 'common invoice') {
                            $('#generate_pdf').prop('disabled', false);
                            $('#send_mail_button').show();
                        } else if (invoice_type == 'work_order') {
                            $('#generate_pdf').prop('disabled', false);
                            $('#send_mail_button').show();
                        } else {
                            $('#generate_pdf').prop('disabled', false);
                            $('#send_mail_button').show();
                        }
                    }
                });
            }
        });
    }
});

function change_order_status($id, obj){
    var status = $(obj).val();

    $.ajax({
        type : "post",
        data : {change_order :$id , sta : status },
        url : base_url+"invoices/update_change_order_status",
        dataType : "json",
        async: false,
        success : function(response){

        }
    });

}
function change_order_status_loop($est_id,Co_no ,obj){
    var status = $(obj).val();

    $.ajax({
        type : "post",
        data : {estimate_id: $est_id , change_order_no :Co_no , sta : status },
        url : base_url+"invoices/update_change_order_status_loop",
        dataType : "json",
        async: false,
        success : function(response){

        }
    });

}

function check_status(estimate_id,change_order_no){
    var result = 0 ;
    $.ajax({
        type : "post",
        data : {est_id :estimate_id , Co_No : change_order_no },
        url : base_url+"invoices/check_change_order_status",
        dataType : "json",
        async: false,
        success : function(response){
            result =  response  ;
        }
    });
    return result ;
}

function current_change_order_status(Id){
    var result = 0 ;
    $.ajax({
        type : "post",
        data : {Co_id :Id },
        url : base_url+"invoices/check_current_change_order_status",
        dataType : "json",
        async: false,
        success : function(response){
            result =  response  ;
        }
    });
    return result ;
}

/*
$('#generate_pdf').click(function () {
    $('#method_type').val('generate_pdf');
	var formData = new FormData($('#create_invoice_form')[0]);
	$.ajax({
		url:base_url+'invoices/create',
		type:'post',
		data:formData,
		cache: false,
		contentType: false,
		processData: false,
		success: function(e){
			console.log(formData);
		}
	});
    // $('#create_invoice_form').submit();
	// var estimate_id = $('#estimate_id').val();
	// window.location.replace(base_url+'estimating/estimate_page/'+estimate_id);
});
*/


function update_terms(){
    var terms = $('#terms_conditions').val();

    $.ajax({
        type : "post",
        data : {terms :terms, type: 'ajax'},
        url : base_url+"invoices/update_terms",
        dataType : "json",
        async: false,
        success : function(response){

            if (response) {
                swal({
                    title: "Great!",
                    text: 'Terms and Conditions have been Updated!',
                    icon: "success"
                });
            }
        }
    });
}

$('#send_mail_button').click(function () {
    $('#method_type').val('generate_mail');
    $('#create_invoice_form').submit();
});

var timer ;

function getabbr($id){

    clearTimeout(timer);
    timer = setTimeout(function () {
        var abbr = $(".commercial_note_abbr").val();

        $.ajax({
            type : "post",
            data : {company_id :$id , abbreviation : abbr },
            url : base_url+"invoices/update_company_abbreviation",
            dataType : "json",
            async: false,
            success : function(response){
                $(".commercial_abbr").val(abbr);
            }
        });
    }, 1000);

}

function getClient($id){

    clearTimeout(timer);
    timer = setTimeout(function () {
        var client= $(".commercial_note_client").val();

        $.ajax({
            type : "post",
            data : {company_id :$id , Cl : client },
            url : base_url+"invoices/update_company_client",
            dataType : "json",
            async: false,
            success : function(response){

            }
        });

    }, 1000);
}

function get_customer_estimates(){
    $(".estimate_dropdown").removeAttr("disabled");
    $(".areas_dropdown").attr("disabled","true").trigger("chosen:updated");
    $(".miscellaneous_dropdown").attr("disabled","true").trigger("chosen:updated");
    $(".subcontractors_dropdown").attr("disabled","true").trigger("chosen:updated");
    $(".time_materials_dropdown").attr("disabled","true").trigger("chosen:updated");
    $(".parent_job").removeAttr("disabled");
    var customer_id = $(".select_customer_dropdown").val();
    $.ajax({
        type : "post",
        data : {customer : customer_id, invoice_type : invoice_type},
        url : base_url+"invoices/fetch_customer_estimates",
        dataType : "json",
        success : function(response){
            var estimates = response.estimates;
            var jobs = response.jobs;

            $('.estimate_dropdown').children('option:not(:first)').remove();
            if(estimates!=null){
                for ( i=0; i<estimates.length; i++){
                    $(".estimate_dropdown").append("<option value='" + estimates[i].id + "'>" + estimates[i].job_name + "</option>");
                }
            }
            $("input[name=contractor]").attr("value", estimates[0]['first_name']+" "+ estimates[0]['last_name']);
            $("input[name=con_address]").attr("value", estimates[0]['address']);
            $("input[name=con_city]").attr("value", estimates[0]['city']+ ' ' + estimates[0]['state'] + ' ' + estimates[0]['zip']);
            $("input[name=con_phone]").attr("value", estimates[0]['phone']);
            $("input[name=con_email]").attr("value", estimates[0]['email']);

            /*if(invoice_type == "change_order"){
                $('.parent_job').children('option:not(:first)').remove();
                if(jobs != null){
                    for ( i=0; i<jobs.length; i++){
                        $(".parent_job").append("<option value='" + jobs[i].job_no + "'>" + jobs[i].job_no + "</option>");
                    }
                }
            }*/
        }
    });
}

function get_prior_total(){
    var job_no = $(".parent_job").val();
    $.ajax({
        type     : "post",
        data     : {job_no : job_no},
        url      : base_url+"invoices/get_job_total",
        dataType : "json",
        success  : function(response){
            $('input[name="prior_total"]').attr('value', response);
            var co_amount = $('input[name="co_no_amount"]').val();
            if(co_amount){
                var total_sum  = parseFloat(co_amount) + parseFloat(response);
                $('input[name="total_due"]').attr('value',total_sum.toFixed(2));
            }
        }

    })
}

function add_more(){
    $(".notes-list").append("<li><input type='text' name='commercial_lists[]' class='no-border proposal_lists'><a onclick='add_proposal_list(this)'><span class='glyphicon glyphicon-ok-sign' style='padding-right: 5px'></span></a><a class='edit_commercial_proposal' style='display: none;' onclick='edit_commercial_proposal(this)' data-id=''><span class='glyphicon glyphicon-pencil' style='padding-right: 5px'></span></a><a class='remove_commercial_proposal' onclick='remove(this)'><span class='glyphicon glyphicon-remove-circle'></span></a></li>");
    event.preventDefault();
}

function remove(element){
	let id = $(element).attr('data-id');

	if (id) {
		$.ajax({
			data: {id: id},
			type: 'post',
			url: base_url + 'invoices/delete_proposal_list',
			dataType: 'json',
			success: function (response) {
				element.closest("li").remove();
				if (!$('.notes-list li').length) {
					add_more();
				}
			}
		});
	}
}

function add_proposal_list(element){
	let proposal = $(element).parent("li").find('.proposal_lists').val();

	if (proposal) {
		$.ajax({
			data: {description: proposal, estimate: estimate},
			type: 'post',
			url: base_url + 'invoices/add_proposal_list',
			dataType: 'json',
			success: function (response) {
				if (response) {
					$(element).hide();
					$(element).parent("li").find('.edit_commercial_proposal').attr( 'data-id', response );
					$(element).parent("li").find('.remove_commercial_proposal').attr( 'data-id', response );
					$(element).parent("li").find('.edit_commercial_proposal').show();
				}
			}
		});
	}
}

function edit_commercial_proposal(element){
	let proposal = $(element).parent("li").find('.proposal_lists').val();
	let id = $(element).attr('data-id');

	if (proposal) {
		$.ajax({
			data: {id: id, description: proposal},
			type: 'post',
			url: base_url + 'invoices/edit_proposal_list',
			dataType: 'json',
			success: function (response) {

			}
		});
	}
}

function getvalue(){
    var change_order_no = $('#change_order_no').val();
    $(".co_number").text(change_order_no);

}

function get_options(){
    estimate_id = $(".estimate_dropdown").val();
    $('#estimate_id').val(estimate_id);
    $(".areas_dropdown option").remove();
    $(".miscellaneous_dropdown option").remove();
    $(".subcontractors_dropdown option").remove();
    $(".time_materials_dropdown option").remove();
    $(".change_order_dropdown option").remove();
    $(".scope_button button").removeAttr('disabled');
    $("#job_templates").ckeditor();
    CKEDITOR.instances.job_templates.setData('');
    $.ajax({
        data: {id: estimate_id},
        type: 'post',
        url: base_url + 'invoices/get_est_basic_info',
        dataType: 'json',
        success: function (est) {
            if (invoice_type != 'change_order') {
                var estimate = est.estimate;
                $('#exclusion_heading').html('<p><strong>Scope of Work Clarifications</strong></p>');
                $('#exclusion_text').html(estimate['exclusions']);
            }
            $.ajax({
                data : {estimate_id : estimate_id},
                type : 'post',
                url : base_url+'invoices/get_estimate_areas',
                dataType : 'json',
                success : function(areas){
                    $(".areas_dropdown").removeAttr("disabled").trigger("chosen:updated");
                    for (i = 0; i < areas.length; i++) {
                        $(".areas_dropdown").append("<option value='"+ areas[i].id +"'> " + areas[i].name + "</option>").trigger("chosen:updated");
                    }
                    $.ajax({
                        data : {estimate_id : estimate_id},
                        type : 'post',
                        url : base_url+'invoices/get_estimate_miscellaneous',
                        dataType : 'json',
                        success : function(miscellaneous){
                            $(".miscellaneous_dropdown").removeAttr("disabled").trigger("chosen:updated");
                            for (i = 0; i < miscellaneous.length; i++) {
                                $(".miscellaneous_dropdown").append("<option value='"+ miscellaneous[i].id +"'>" + miscellaneous[i].description + "</option>").trigger("chosen:updated");
                            }
                            $.ajax({
                                data : {estimate_id : estimate_id},
                                type : 'post',
                                url : base_url+'invoices/get_estimate_subcontractors',
                                dataType : 'json',
                                success : function(subcontractors){
                                    $(".subcontractors_dropdown").removeAttr("disabled").trigger("chosen:updated");
                                    for (i = 0; i < subcontractors.length; i++) {
                                        $(".subcontractors_dropdown").append("<option value='"+ subcontractors[i].id +"'> " + subcontractors[i].name + "</option>").trigger("chosen:updated");
                                    }
                                    $.ajax({
                                        data : {estimate_id : estimate_id},
                                        type : 'post',
                                        url : base_url+'invoices/get_estimate_time_materials',
                                        dataType : 'json',
                                        success : function(time_materials){
                                            $(".time_materials_dropdown").removeAttr("disabled").trigger("chosen:updated");
                                            for (i = 0; i < time_materials.length; i++) {
                                                $(".time_materials_dropdown").append("<option value='"+ time_materials[i].id +"'> " + time_materials[i].time_item + "</option>").trigger("chosen:updated");
                                            }
                                            $.ajax({
                                                data : {estimate_id : estimate_id},
                                                type : 'post',
                                                url : base_url+'invoices/get_estimate_change_orders',
                                                dataType : 'json',
                                                success : function(changeorders){
                                                    $(".change_order_dropdown").removeAttr("disabled").trigger("chosen:updated");
                                                    for (i = 0; i < changeorders.length; i++) {
                                                        var j = i+1;
                                                        $(".change_order_dropdown").append("<option value='"+ changeorders[i].id +"'> " + 'Change Order #' + changeorders[i].change_order + "</option>").trigger("chosen:updated");
                                                    }
                                                    $.ajax({
                                                        data : {estimate_id : estimate_id},
                                                        type : 'post',
                                                        url : base_url+'invoices/get_estimate_info',
                                                        dataType : 'json',
                                                        success : function(response){
                                                            $("input[name=job_address]").attr("value", response.street_address);
                                                            $("input[name=job_city]").attr("value", response.zip);
                                                            $("input[name=job_name]").attr("value", response.job_name);
                                                            $("input[name=job_no]").attr("value", response.job_no);
                                                            $("input[name=contractor]").attr("value",response.first_name+' '+response.last_name);
                                                            $("input[name=con_address]").attr("value",response.address);
                                                            $("input[name=con_city]").attr("value",response.city + ' ' + response.state + ' ' + response.zip);
                                                            $("input[name=con_phone]").attr("value",response.phone);
                                                            $("input[name=con_email]").attr("value",response.email);
                                                            $(".select_customer_dropdown").val(response.customer_id).attr("selected","selected");
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        }

                    });
                }
            });
        }
    });
}

function get_scope_detials(){
    var areas               = get_area_details([],null, 'scope', invoice_type);
    var miscellaneous       = get_miscellaneous_details([], null, 'scope', invoice_type);
    var subcontractors      = get_subcontractor_details([], null, 'scope', invoice_type);
    var time_materials      = get_time_materials_details([], null, 'scope', invoice_type);

    var estimate_id         = $(".estimate_dropdown").val();
    var change_orders       = $(".change_order_dropdown").val();
    var change_order = {'tables' : '', 'grand_total': 0};

    if (change_orders.length && invoice_type == "work_order") {
        $.ajax({
            type: 'post',
            data: {estimate: estimate_id},
            url: base_url + 'invoices/get_estimate',
            dataType: 'json',
            async : false,
            success: function (response) {
                change_order = get_change_orders(response, change_orders);
            }
        });
    }else {
        change_order['grand_total'] = 0;
        change_order['tables'] = '';
    }

    var final_table_data = areas['tables'] + miscellaneous['tables'] + subcontractors['tables'] + time_materials['tables'] + change_order['tables'];

    var grand_total_all = 0;
    var grand_scope_total = 0;
    var grand_change_order_total = 0;

    grand_scope_total = parseFloat(areas['grand_total']) + parseFloat(miscellaneous['grand_total']) + parseFloat(subcontractors['grand_total']) + parseFloat(time_materials['grand_total']);
    grand_change_order_total = parseFloat(change_order['grand_total']);
    grand_total_all = grand_scope_total + grand_change_order_total;

    grand_total_all = grand_total_all.toFixed(2);

    if(invoice_type == "change_order"){
        $('input[name="prior_total"]').attr('value', grand_scope_total);
        $('input[name="co_no_amount"]').attr('value', grand_change_order_total);
        $('input[name="total_due"]').attr('value', grand_total_all);

        /*var prior_total = $('input[name="prior_total"]').val();
        if(prior_total != ''){
            var total_due = parseFloat(prior_total) + parseFloat(grand_total_all);
            $('input[name="total_due"]').attr('value', total_due.toFixed(2));
        }*/
    }
    //separation of int part
    var grand_intpart = Math.floor(grand_total_all);
    //separation of decimal part
    var decimal = (grand_total_all - Math.floor(grand_total_all)).toFixed(2);
    var decimal_value = decimal + '';
    var dec = parseInt(decimal_value.replace('.', ''));
    if (dec<10){
        dec = '0'+dec;
    }
    var dec_fraction = dec+'/100';
    var str = toWords(grand_intpart);
    str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });
    grand_intpart = parseInt(grand_intpart)+ parseFloat(decimal);
    grand_intpart = grand_intpart.toLocaleString("en");

    $('input[name="change_order"]').attr('value', changeOrderId);

    if(invoice_type == "commercial"){
        $("input[name=numeric_money]").attr('value', grand_intpart);
        $("input[name=written_money]").attr('value', str);
        $("input[name=decimal_value]").attr('value', dec_fraction);
    }else if(invoice_type == "quote"){
        $("input[name=numeric_money]").attr('value', grand_intpart);
    }
    var grand_total_html = '<p><span><b>Grand Total : </b></span><span>'+ grand_intpart +'</span></p>';
    var final_html = final_table_data + grand_total_html;
    $("#job_templates").ckeditor();
    CKEDITOR.instances.job_templates.setData(final_html);

    /*Enable the Generate PDF Button unless data has been fully Loaded*/
    if (grand_intpart !=0) {
        $('#generate_pdf').prop('disabled', false);
        $('#send_mail_button').show();
    }
}

function get_change_order_scope_detials(){
    var areas                   = {'tables' : '', 'grand_total': 0};
    var miscellaneous           = {'tables' : '', 'grand_total': 0};
    var subcontractors          = {'tables' : '', 'grand_total': 0};
    var time_materials          = {'tables' : '', 'grand_total': 0};

    var estimate_id         = $(".estimate_dropdown").val();
    var change_orders       = $(".change_order_dropdown").val();
    var change = [];
    var change_order = [];

    change.push(change_orders);

    $.ajax({
        type : 'post',
        data : {estimate : estimate_id},
        url : base_url+'invoices/get_estimate',
        dataType : 'json',
        async: false,
        success : function(response){
            areas               = get_area_details(response.areas, null, 'estimate', invoice_type);
            miscellaneous       = get_miscellaneous_details(response.miscellaneous, null, 'estimate', invoice_type);
            subcontractors      = get_subcontractor_details(response.subcontractors, null, 'estimate', invoice_type);
            time_materials      = get_time_materials_details(response.time, null, 'estimate', invoice_type);
        }
    });

    if (change_orders) {
        $.ajax({
            type: 'post',
            data: {estimate: estimate_id},
            url: base_url + 'invoices/get_estimate',
            dataType: 'json',
            async : false,
            success: function (response) {
                change_order = get_change_orders(response, change);
            }
        });
    }else {
        change_order['grand_total'] = 0;
        change_order['tables'] = '';
    }

    var final_table_data = change_order['tables'];

    var grand_total_all = 0;
    var grand_scope_total = 0;
    var grand_change_order_total = 0;

    grand_scope_total = parseFloat(areas['grand_total']) + parseFloat(miscellaneous['grand_total']) + parseFloat(subcontractors['grand_total']) + parseFloat(time_materials['grand_total']);


    // To sum up All the Change Orders Prior to this Change Order
    // Including estimate Total + Sum of All Prior Change Orders.

    var total = 0;
    if (change_orders != null) {
        $.ajax({
            type: 'post',
            data: {estimate: estimate_id, change_order: change_orders},
            url: base_url + 'invoices/get_change_order_invoices',
            dataType: 'json',
            async: false,
            success: function (response) {
                for ($i = 0; $i < response.length; $i++) {
                    total += parseFloat(response[$i].co_no_amount);
                }
            }
        });
    }

    grand_scope_total += total;

    grand_change_order_total = parseFloat(change_order['grand_total']);
    grand_total_all = grand_scope_total + grand_change_order_total;

    grand_total_all = grand_total_all.toFixed(2);


    if(invoice_type == "change_order" && change_orders != null){
        $('input[name="prior_total"]').attr('value', grand_scope_total);
        $('input[name="co_no_amount"]').attr('value', grand_change_order_total.toFixed(2));
        $('input[name="total_due"]').attr('value', grand_total_all);

        $.ajax({
            url : base_url+'invoices/get_change_order_info',
            type : 'post',
            dataType : 'json',
            data : {id : change_orders},
            async : false,
            success : function(response){
                if (response['change_order'] >9){
                    $('input[name="change_order_no"]').attr('value', response['change_order']);
                } else{
                    var value = '0' + response['change_order'];
                    $('input[name="change_order_no"]').attr('value', value);
                }

                if (response['exclusions']){
                    $('#exclusion_heading').html('<p><strong>Change Order Clarifications</strong></p>');
                    $('#exclusion_text').html(response['exclusions']);
                }
            }
        });
    }
    //separation of int part
    var grand_intpart = Math.floor(grand_change_order_total);
    //separation of decimal part
    var decimal = (grand_change_order_total - Math.floor(grand_change_order_total)).toFixed(2);
    var decimal_value = decimal + '';
    var dec = parseInt(decimal_value.replace('.', ''));
    if (dec<10){
        dec = '0'+dec;
    }
    var dec_fraction = dec+'/100';
    var str = toWords(grand_intpart);
    str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });
    grand_intpart = parseInt(grand_intpart)+ parseFloat(decimal);
    grand_intpart = grand_intpart.toLocaleString("en");

    $('input[name="change_order"]').attr('value', change_orders);

    if(invoice_type == "commercial"){
        $("input[name=numeric_money]").attr('value', grand_intpart);
        $("input[name=written_money]").attr('value', str);
        $("input[name=decimal_value]").attr('value', dec_fraction);
    }else if(invoice_type == "quote"){
        $("input[name=numeric_money]").attr('value', grand_intpart);
    }
    var grand_total_html = '<p><span><b>Grand Total : </b></span><span>'+ grand_intpart +'</span></p>';
    var final_html = final_table_data + grand_total_html;
    $("#job_templates").ckeditor();
    CKEDITOR.instances.job_templates.setData(final_html);

    /*Enable the Generate PDF Button unless data has been fully Loaded*/
    if (grand_change_order_total != '0.00') {
        $('#generate_pdf').prop('disabled', false);
        $('#send_mail_button').show();
    }
}

function get_time_materials_details(time, cid, type, invoice){
    var time_materials_final_data = '';
    var invoiceNo = null;
    var cid = cid || null;
    $.ajax({
        url : base_url+'invoices/fetch_estimate_permissions',
        dataType : 'json',
        data: {type: invoice},
        async : false,
        success : function(permission){
            var permissions = JSON.parse(permission.time_material);
            var time_materials = [];
            if (type == 'scope') {
                time_materials = $(".time_materials_dropdown").val();
            }
            var timeColumns = ['name','item','total_hours','labor_cost','material_cost','sales_tax','profit_mark','sell_price','total_sell_price'];
            var timeDbColumns = ['name','time_item','time_total_hours','time_total_labor_cost','time_material_cost','time_sales_tax','material_profit_mark_up','material_sell_price','total_sell_price'];
            var commonInvoiceColumns = ['item', 'total_hours', 'total_sell_price'];

            if(time_materials.length==0){
                time_materials = time;
            }

			/* check on invoice number if it has value or not */
			invoiceNo = invoice_no != null ? invoice_no : null;

            if(time_materials != undefined && time_materials.length != 0){
                $.ajax({
                    url : base_url+'invoices/time_materials_detials',
                    type : 'post',
                    dataType : 'json',
                    data : {ids : time_materials , changeId : cid, invoice: invoice, invoice_no: invoiceNo},
                    async : false,
                    success : function(response){
                        if (response.length) {
                            var table_head = '<div style="font-size:16px;font-weight:bold;text-align:center;margin-top: 10px;background-color:#293870;line-height: 40px !important;color:#fff;">Time & Materials</div>';
                            table_head += '<table  align="center" width="100%" style="padding: 5px;text-align:center;font-size:12px; border-color: white; box-shadow: none;"><thead style="background:#f3f3f3;"><tr><th style="background-color:#f3f3f3; font-weight:bold; border-color: #000;">NO#</th>';

                            for (i =0;i<timeColumns.length;i++) {
                                if (invoice_type == 'common invoice'){
                                    if($.inArray(timeColumns[i],commonInvoiceColumns) !== -1){
                                        var name = timeColumns[i].replace(/_/g, " ");
                                        name = name.charAt(0).toUpperCase() + name.substr(1);
                                        table_head += '<th style="background-color:#f3f3f3;font-weight:bold; border-color: #000;">'+ name +'</th>';
                                    }
                                }
                                else {
                                    if($.inArray(timeColumns[i], permissions) !== -1){
                                        if (timeColumns[i] == 'sell_price'){
                                            table_head += '<th style="background-color:#f3f3f3; font-weight:bold; border-color: #000; line-height: 40px;">Material Price</th>';
                                        } else {
                                            var name = timeColumns[i].replace(/_/g, " ");
                                            name = name.charAt(0).toUpperCase() + name.substr(1);
                                            table_head += '<th style="background-color:#f3f3f3;font-weight:bold; border-color: #000;">' + name + '</th>';
                                        }
                                    }
                                }
                            }

                            table_head += '</tr></thead><tbody>';
                            var time_total = 0;
                            for(j=0; j<response.length; j++){
                                k = j+1;
                                table_head += '<tr><td style="border-color: #000;">'+ k + '</td>';

                                for (timeRow =0;timeRow<timeDbColumns.length;timeRow++) {
                                    if (invoice_type == 'common invoice'){
                                        if($.inArray(timeColumns[timeRow], commonInvoiceColumns) !== -1){
                                            var dbName = timeDbColumns[timeRow];
                                            table_head += '<td style="border-color: #000;">'+ response[j][dbName] + '</td>';
                                        }
                                    }
                                    else{
                                        if($.inArray(timeColumns[timeRow], permissions) !== -1){
                                            var dbName = timeDbColumns[timeRow];
                                            table_head += '<td style="border-color: #000;">'+ response[j][dbName] + '</td>';
                                        }
                                    }
                                }

                                table_head += '</tr>';
                                time_total = parseFloat(response[j].total_sell_price) + parseFloat(time_total);
                            }

                            table_head += '</tbody></table><br>';
                            time_total = time_total.toFixed(2);
                            time_materials_final_data = {tables : table_head, grand_total : time_total};
                        }
                        else {
                            time_materials_final_data = {tables : '', grand_total : 0};
                        }
                    }
                })
            }else{
                time_materials_final_data = {tables : '', grand_total : 0};
            }
        }
    });
    return time_materials_final_data;
}

function get_subcontractor_details(sub, cid, type, invoice){
    var subcontractor_final_data= '';
    var invoiceNo = null;
    var cid = cid || null;
    $.ajax({
        url : base_url+'invoices/fetch_estimate_permissions',
        dataType : 'json',
        data: {type: invoice},
        async : false,
        success : function(permission){
            var permissions = JSON.parse(permission.subcontractor);
            var subcontractor = [];
            if (type == 'scope') {
                subcontractor = $(".subcontractors_dropdown").val();
            }
            if(subcontractor.length==0){
                subcontractor = sub;
            }

			/* check on invoice number if it has value or not */
			invoiceNo = invoice_no != null ? invoice_no : null;

            if(subcontractor != undefined && subcontractor.length != 0){
                $.ajax({
                    url : base_url+'invoices/subcontractor_detials',
                    type : 'post',
                    dataType : 'json',
                    data : {ids : subcontractor, changeId : cid, invoice: invoice, invoice_no: invoiceNo},
                    async : false,
                    success : function(response){
                        if (response.length) {
                            var table_head = '<div style="font-size:16px;font-weight:bold;text-align:center;margin-top: 10px;background-color:#293870;line-height: 40px !important;color:#fff;">Subcontractors</div>';
                            var subColumns = ['contract_name','subcontractor_name','subcontractor_item','total_cost','profit_mark_up','total_sell_price'];
                            var subDbColumns = ['subcontract_name','name','item','subcontractor_cost','subcontractor_profit_mark_up','total_sell_price'];
                            var commonInvoiceColumns = ['subcontractor_name','subcontractor_item','total_sell_price'];

                            table_head += '<table  align="center" width="100%" style="padding: 5px;text-align:center;font-size:12px; border-color: white; box-shadow: none;"><thead><tr><th style="background-color:#f3f3f3; font-weight:bold;border-color: #000;">NO#</th>';

                            for (i =0;i<subColumns.length;i++) {
                                if (invoice_type == 'common invoice'){
                                    if ($.inArray(subColumns[i], commonInvoiceColumns) !== -1){
                                        var name = subColumns[i].replace(/_/g, " ");
                                        name = name.charAt(0).toUpperCase() + name.substr(1);
                                        table_head += '<th style="background-color:#f3f3f3; font-weight:bold; border-color: #000;">'+ name +'</th>';
                                    }
                                }
                                else{
                                    if($.inArray(subColumns[i], permissions) !== -1){
                                        var name = subColumns[i].replace(/_/g, " ");
                                        name = name.charAt(0).toUpperCase() + name.substr(1);
                                        table_head += '<th style="background-color:#f3f3f3; font-weight:bold; border-color: #000;">'+ name +'</th>';
                                    }
                                }
                            }

                            table_head += '</tr></thead><tbody>';
                            var subcontractor_total = 0;
                            for(j=0; j<response.length; j++){
                                k = j+1;
                                table_head += '<tr><td style="border-color: #000;">'+ k +'</td>';

                                for (i =0;i<subDbColumns.length;i++) {
                                    if (invoice_type == 'common invoice'){
                                        if ($.inArray(subColumns[i], commonInvoiceColumns) !== -1){
                                            var name = subDbColumns[i];
                                            table_head += '<td style="border-color: #000;">'+ response[j][name] + '</td>';
                                        }
                                    }
                                    else{
                                        if($.inArray(subColumns[i], permissions) !== -1){
                                            var name = subDbColumns[i];
                                            table_head += '<td style="border-color: #000;">'+ response[j][name] + '</td>';
                                        }
                                    }
                                }

                                table_head += '</tr>';
                                subcontractor_total = parseFloat(response[j].total_sell_price) + parseFloat(subcontractor_total);
                            }
                            table_head += '</tbody></table><br>';
                            subcontractor_total = subcontractor_total.toFixed(2);
                            subcontractor_final_data = {tables : table_head, grand_total : subcontractor_total};
                        }
                        else {
                            subcontractor_final_data = {tables : '', grand_total : 0};
                        }
                    }
                })
            }else{
                subcontractor_final_data = {tables : '', grand_total : 0};
            }
        }
    });
    return subcontractor_final_data;
}

function get_miscellaneous_details(misc, cid, type, invoice){
    var miscellaneous_final_data = '';
    var invoiceNo = null;
    var cid = cid || null;
    $.ajax({
        url : base_url+'invoices/fetch_estimate_permissions',
        dataType : 'json',
        data: {type: invoice},
        async : false,
        success : function(permission){
            var permissions = JSON.parse(permission.miscellaneous);
            var miscellaneous = [];
            if (type == 'scope') {
                miscellaneous = $(".miscellaneous_dropdown").val();
            }
            if(miscellaneous.length==0){
                miscellaneous = misc;
            }

			/* check on invoice number if it has value or not */
			invoiceNo = invoice_no != null ? invoice_no : null;

            if(miscellaneous != undefined && miscellaneous.length != 0){
                $.ajax({
                    url : base_url+'invoices/miscellaneous_detials',
                    type : 'post',
                    dataType : 'json',
                    async : false,
                    data : {ids : miscellaneous, changeId : cid, invoice: invoice ,invoice_no: invoiceNo},
                    success : function(response){
                        if (response.length) {
                            var table_head = '<div style="font-size:16px;font-weight:bold;text-align:center;margin-top: 10px;background-color:#293870;line-height: 40px !important;color:#fff;">Miscellaneous</div>';
                            table_head += '<table  align="center" width="100%" style="padding: 5px;text-align:center;font-size:12px; border-color: white; box-shadow: none;"><thead><tr><th style="background-color:#f3f3f3; border-color: #000; font-weight:bold;">NO#</th>';

                            var miscColumns = ['name','description','sales_tax','total_cost','profit_mark_up','total_selling_price'];
                            var miscDbColumns = ['name','description','sales_tax','total_cost','profit_mark_up','total_sell_price'];
                            var commonInvoiceColumns = ['description','total_selling_price'];

                            for (i =0;i<miscColumns.length;i++) {
                                if (invoice_type == 'common invoice'){
                                    if ($.inArray(miscColumns[i], commonInvoiceColumns) !== -1){
                                        var name = miscColumns[i].replace(/_/g, " ");
                                        name = name.charAt(0).toUpperCase() + name.substr(1);
                                        table_head += '<th style="background-color:#f3f3f3; font-weight:bold; border-color: #000;" >'+name+'</th>';
                                    }
                                }
                                else{
                                    if($.inArray(miscColumns[i], permissions) !== -1){
                                        var name = miscColumns[i].replace(/_/g, " ");
                                        name = name.charAt(0).toUpperCase() + name.substr(1);
                                        table_head += '<th style="background-color:#f3f3f3; font-weight:bold; border-color: #000;">'+ name +'</th>';
                                    }
                                }
                            }

                            table_head += '</tr></thead><tbody>';
                            var miscellaneous_total = 0;
                            for(j=0; j<response.length; j++){
                                k = j+1;

                                table_head += '<tr><td style="border-color: #000;;">'+ k +'</td>';
                                for(x = 0; x<miscDbColumns.length; x++) {

                                    if (invoice_type == 'common invoice'){
                                        if ($.inArray(miscColumns[x], commonInvoiceColumns) !== -1) {
                                            var colValue = miscDbColumns[x];
                                            table_head += '<td style="border-color: #000;">' + response[j][colValue] + '</td>';
                                        }
                                    }
                                    else {
                                        if ($.inArray(miscColumns[x], permissions) !== -1) {
                                            var colValue = miscDbColumns[x];
                                            table_head += '<td style="border-color: #000;">' + response[j][colValue] + '</td>';
                                        }                                    }
                                }

                                table_head += '</tr>';
                                miscellaneous_total = parseFloat(response[j].total_sell_price) + parseFloat(miscellaneous_total);
                            }

                            table_head += '</tbody></table><br>';
                            miscellaneous_total = miscellaneous_total.toFixed(2);
                            miscellaneous_final_data = {tables : table_head, grand_total : miscellaneous_total};
                        }
                        else {
                            miscellaneous_final_data = {tables : '', grand_total : 0};
                        }
                    }
                })
            }else{
                miscellaneous_final_data = {tables : '', grand_total : 0};
            }
        }
    });
    return miscellaneous_final_data;
}

function get_area_details(area_ids, cid, type, invoice){
    var cid = cid || null;
    var invoiceNo = null;
    var areas_final_data = '';
    $.ajax({
        url : base_url+'invoices/fetch_estimate_permissions',
        data: {type: invoice},
        dataType : 'json',
        async : false,
        success : function(permission){
            var permissions = JSON.parse(permission.area);
            var areas = [];
            if (type == 'scope') {
                areas = $(".areas_dropdown").val();
            }
            if(areas.length==0){
                areas = area_ids;
            }

			/* check on invoice number if it has value or not */
			invoiceNo = invoice_no != null ? invoice_no : null;

            if( areas != undefined && areas.length != 0 ){
                $.ajax({
                    url : base_url+'invoices/area_details',
                    type : 'post',
                    dataType : 'json',
                    data : {ids : areas, cid : cid, invoice: invoice, invoice_no: invoiceNo},
                    async : false,
                    success : function(response){
                        if (response.length) {
                            var tables = '';
                            var area_total = 0;
                            var columnNames = ['production', 'surface','method','application','method_speed','material','coverage','quantity','mark_up','hours','cost','sell_rate','total'];
                            var headers     = ['Item', 'Description','Method','Apply/Install','Production','Material','Material Metric/Coverage','Quantity','Mark Up','Hours','Cost','Unit Rate','Total'];
                            var dbColumnNames = ['production_name', 'surface_name', 'method_name', 'application','coverage','product_name','material_coverage','quantity','mark_up','hours','unit_cost','unit_sell_rate','total'];
                            var commonInvoiceDbColumns = ['item','description','total'];
                            var commonInvoiceColumns = ['production_name','surface_name','total'];
                            for(i = 0; i<response.length; i++){
                                var table_head = '<div style="font-size:16px;font-weight:bold;text-align:center;margin-top: 10px; background-color:#293870;line-height: 40px !important;color:#fff;">'+ response[i][0].name +'</div><table  class="table_specific" align="center" width="100%" style="padding: 5px;text-align:center;font-size:12px; border-color: white; box-shadow: none;"><thead><tr>';
                                if (invoice_type == 'common invoice') {
                                    for (j = 0; j < commonInvoiceDbColumns.length; j++) {
                                        var name = commonInvoiceDbColumns[j].replace(/_/g, " ");
                                        name = name.charAt(0).toUpperCase() + name.substr(1);
                                        table_head += '<th style="background-color:#f3f3f3; font-weight:bold; border-color: #000;" >' + name + '</th>';
                                    }
                                }
                                else {
                                    for (j = 0; j<columnNames.length; j++) {
                                        if ($.inArray(columnNames[j], permissions) !== -1) {
                                            table_head += '<th style="background-color:#f3f3f3; font-weight:bold; border-color: #000;" >' + headers[j] + '</th>';
                                        }
                                    }
                                }

                                table_head += '</tr></thead><tbody>';
                                var area_detail = response[i];
                                var this_area_total = 0;
                                for(j=0; j<area_detail.length; j++){
                                    table_head += '<tr>';
                                    if (invoice_type == 'common invoice'){
                                        for(x = 0; x<commonInvoiceColumns.length; x++) {
                                            var colValue = commonInvoiceColumns[x];
                                            if (columnNames[x] == 'quantity' && area_detail[j]['unit']) {
                                                table_head += '<td style="border-color: #000;">' + area_detail[j][colValue] + ' ' + area_detail[j]['unit'] + '</td>';
                                            } else {
                                                table_head += '<td style="border-color: #000;">' + area_detail[j][colValue] + '</td>';
                                            }
                                        }
                                    }
                                    else {
                                        for(x = 0; x<dbColumnNames.length; x++) {
                                            if ($.inArray(columnNames[x], permissions) !== -1) {
                                                var colValue = dbColumnNames[x];
                                                if (columnNames[x] == 'quantity' && area_detail[j]['unit']) {
                                                    table_head += '<td style="border-color: #000;">' + area_detail[j][colValue] + ' ' + area_detail[j]['unit'] + '</td>';
                                                } else {
                                                    table_head += '<td style="border-color: #000;">' + area_detail[j][colValue] + '</td>';
                                                }
                                            }
                                        }
                                    }
                                    table_head += '</tr>';
                                    area_total = parseFloat(area_detail[j].total) + parseFloat(area_total);
                                    this_area_total = parseFloat(area_detail[j].total) + parseFloat(this_area_total);
                                }

                                table_head += '<tr>';

                                if (invoice_type !== 'common invoice'){
                                    for (j = 0; j<columnNames.length; j++) {
                                        if($.inArray(columnNames[j], permissions) !== -1){
                                            if (columnNames[j] == 'total') {
                                                table_head += '<td style="border-color: #000;">' + 'Area Total: ' +this_area_total.toFixed(2) + '</td>';
                                            }
                                            else{
                                                table_head += '<td></td>';
                                            }
                                        }
                                    }
                                }

                                table_head += '</tr>' ;
                                table_head += '</tbody></table><br>';
                                tables += table_head;
                            }
                            area_total = area_total.toFixed(2);
                            areas_final_data = {tables : tables, grand_total : area_total};
                        }
                        else {
                            areas_final_data = {tables : '', grand_total : 0};
                        }
                    }
                })
            }else{
                areas_final_data = {tables : '', grand_total : 0};
            }
        }
    });
    return areas_final_data;
}

function get_change_orders(response, changeOrders) {
    var change = changeOrders || [];

    /*If Admin wants to generate invoice by Estimate ID*/
    var change_orders   = response.changeorder;
    var change_order_no = response.changeorderno;

    /*If there is value selected in Change Order Dropdown*/
    if (change.length){
        change_orders = change;
    }

    var change_order_data = '';
    var change_order_table_data = '';
    var change_order_total = 0.00;
    var invoiceNo = null;

    if(change_orders.length) {
        for (change_id = 0; change_id < change_orders.length; change_id++) {
            j = change_id + 1;
            var change_heading = '';

            if (changeOrderId ==0 && invoice_type != 'change_order'){
                change_heading = '<div style="font-size:18px;font-weight:bold;text-align:center;margin-top: 10px;margin:15px 0;">Change Order #' + change_order_no[change_id] + '</div>';
            }
			var change_order_areas = get_area_details(response.areas, change_orders[change_id], 'change_order', invoice_type);
			var change_order_miscellaneous = get_miscellaneous_details(response.miscellaneous, change_orders[change_id], 'change_order', invoice_type);
			var change_order_subcontractors = get_subcontractor_details(response.subcontractors, change_orders[change_id], 'change_order', invoice_type);
			var change_order_time = get_time_materials_details(response.time, change_orders[change_id], 'change_order', invoice_type);

            if (change_order_areas['tables'] != '' || change_order_miscellaneous['tables'] != '' || change_order_subcontractors['tables'] != '' || change_order_time['tables'] != ''){
				change_order_table_data += change_heading;
			}

			change_order_table_data += change_order_areas['tables'] + change_order_miscellaneous['tables'] + change_order_subcontractors['tables'] + change_order_time['tables'];
			change_order_total += parseFloat(change_order_areas['grand_total']) + parseFloat(change_order_miscellaneous['grand_total']) + parseFloat(change_order_subcontractors['grand_total']) + parseFloat(change_order_time['grand_total']);
        }

        change_order_data = {tables : change_order_table_data, grand_total : change_order_total};
    } else{
        change_order_data = {tables : '', grand_total : 0};
    }
    return change_order_data;
}

function get_common_invoice_summary(id, estimate) {
    var common_invoice_final_data = '';
	var invoiceNo = null;

	/* check on invoice number if it has value or not */
	invoiceNo = invoice_no != null ? invoice_no : null;

    $.ajax({
        url : base_url+'invoices/common_invoice_summary',
        type : 'post',
        dataType : 'json',
        data : {id: id, estimate: estimate , invoice_no: invoiceNo},
        async : false,
        success : function(response){
			if (response) {
				var table = '';
                var columnNames = ['Original Sum', 'New Sum to Date','% Completed','Credit','Payment Received' ,'Balance Due', 'Balance to Finish'];
                var dbColumnNames = ['original_sum', 'new_sum','project_completed','credit', 'payment_received' , 'balance_due' , 'balance_to_finish'];

                var table_head = '<div class="space30"></div>';

                table_head += '<div style="border:1px solid #000000; font-size:16px;font-weight:bold;text-align:center;margin-top: 10px;background-color:#293870;line-height: 40px !important;color:#fff;">Invoice Summary</div><table nobr="true" class="table_specific" align="center" width="100%" style="padding: 10px;text-align:center;font-size:12px; border-color: white; box-shadow: none;"><thead><tr>';
                for (j = 0; j<columnNames.length; j++) {
                    table_head += '<th style="background-color:#f3f3f3; font-weight:bold; border-color: #000;" >'+columnNames[j]+'</th>';
                }

                table_head += '</tr></thead><tbody><tr>';
                //var area_detail = response[i];
                //var this_area_total = 0;

                // table_head += '<tr>';
                for(x = 0; x<dbColumnNames.length; x++) {
                    var colValue = dbColumnNames[x];
                    if (colValue != 'project_completed'){
                        table_head += '<td style="border-color: #000;">' + parseFloat(response[colValue]).toFixed(2); + '</td>';
                    } else {
                        table_head += '<td style="border-color: #000;">' + parseFloat(response[colValue]).toFixed(2); + ' %' + '</td>';
                    }
                }
                table_head += '</tr></tbody></table>';
                table += table_head;

                //area_total = area_total.toFixed(2);
                common_invoice_final_data = {tables : table, grand_total : response['total_due'], balance_due: response['balance_due']};
			}
            else {
                common_invoice_final_data = {tables : '', grand_total : 0};
            }
        }
    });
    return common_invoice_final_data;
}

// Convert numbers to words
// copyright 25th July 2006, by Stephen Chapman http://javascript.about.com
// permission to use this Javascript on your web page is granted
// provided that all of the code (including this copyright notice) is
// used exactly as shown (you can change the numbering system if you wish)

// American Numbering System
var th = ['','thousand','million', 'billion','trillion'];
// uncomment this line for English Number System
// var th = ['','thousand','million', 'milliard','billion'];

var dg = ['zero','one','two','three','four', 'five','six','seven','eight','nine']; var tn = ['ten','eleven','twelve','thirteen', 'fourteen','fifteen','sixteen', 'seventeen','eighteen','nineteen']; var tw = ['twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety']; function toWords(s){s = s.toString(); s = s.replace(/[\, ]/g,''); if (s != parseFloat(s)) return 'not a number'; var x = s.indexOf('.'); if (x == -1) x = s.length; if (x > 15) return 'too big'; var n = s.split(''); var str = ''; var sk = 0; for (var i=0; i < x; i++) {if ((x-i)%3==2) {if (n[i] == '1') {str += tn[Number(n[i+1])] + ' '; i++; sk=1;} else if (n[i]!=0) {str += tw[n[i]-2] + ' ';sk=1;}} else if (n[i]!=0) {str += dg[n[i]] +' '; if ((x-i)%3==0) str += 'hundred ';sk=1;} if ((x-i)%3==1) {if (sk) str += th[(x-i-1)/3] + ' ';sk=0;}} if (x != s.length) {var y = s.length; str += 'point '; for (var i=x+1; i<y; i++) str += dg[n[i]] +' ';} return str.replace(/\s+/g,' ');}


$(window).on("load", function() {
	setInterval(function(){

		//  apply css only on Firefox
		var isFirefox = window.firefox;

		//  apply css only on chrome
		var isChromium = window.chrome;
		if(isChromium){
			$(".cke_wysiwyg_frame").contents().find("th").css({"border-style": "solid", "border-color": "#000"});
			$(".cke_wysiwyg_frame").contents().find("th:first-child").css({"border-left": "1px solid #000"});
			$(".cke_wysiwyg_frame").contents().find("td").css({"border-style": "solid", "border-color": "#000"});
			$(".cke_wysiwyg_frame").contents().find("td:first-child").css({"border-left": "1px solid #000"});
			$(".cke_wysiwyg_frame").contents().find("td:last-child").css({"border-left": "1px solid #000"});

			// remove borders from empty rows
			$(".cke_wysiwyg_frame").contents().find("td").each(function() {
				var $this = $(this);
				if($this.html().replace(/\s|<br>/g, '').length == 0)
					$this.css({"border": "0", "border-color": "transparent", "border-style": "none"});
			});
		}

		if(navigator.userAgent.indexOf("Firefox") > -1){
			$(".cke_wysiwyg_frame").contents().find("th").css({"border-left-color": "#000", "border-left-style": "solid"});
			$(".cke_wysiwyg_frame").contents().find("td").css({"border-left-color": "#000", "border-left-style": "solid"});

			// remove borders from empty rows
			$(".cke_wysiwyg_frame").contents().find("td").each(function() {
				var $this = $(this);
				if($this.html().replace(/\s|<br>/g, '').length == 0)
					$this.css({"border": "0", "border-color": "transparent", "border-style": "none"});
			});
		}

		if(navigator.userAgent.indexOf('Safari'))
		{
			$(".cke_wysiwyg_frame").contents().find("th").css({"border-left-color": "#000", "border-left-style": "solid"});
			$(".cke_wysiwyg_frame").contents().find("td").css({"border-left-color": "#000", "border-left-style": "solid"});

			// remove borders from empty rows
			$(".cke_wysiwyg_frame").contents().find("td").each(function() {
				var $this = $(this);
				if($this.html().replace(/\s|<br>/g, '').length == 0)
					$this.css({"border": "0", "border-color": "transparent", "border-style": "none"});
			});
		}

		// remove empty paragrapgh tags
		$(".cke_wysiwyg_frame").contents().find("p").each(function() {
			var $this = $(this);
			if($this.html().replace(/\s|&nbsp:/g, '').length == 0)
				$this.remove();
				$this.css({"margin": "0"});
		});

	}, 500);
});
