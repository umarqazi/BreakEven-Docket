$(document).ready(function(){
    var new_sum = 0;
    calculateOriginalSum();
    new_sum = calculateNewSum();
    calculate_billable_sum(new_sum);
    calculate_due(this, event);
    total_balance_finish();
    $('#save_invoice').prop('disabled', true);
    $(".job_exclusions").ckeditor();
});
var global_check_box_count = 0;
function total_balance_finish() {
    var billable_sum = 0;
    $.each($("input[name='billable_item']:checked"), function(){
        billable_sum += parseFloat($(this).parent().siblings('.overall_total').text());
    });
    var credit = $('.amount_credit').val();
    var received = $('.amount_received').val();
    received = received.replace(',','');
    received = received.replace(',','');
    credit = credit.replace(',','');
    var amount_due = Number(billable_sum) - (Number(credit) + Number(received));
    $('.total_balance_finish').val(amount_due.toFixed(2));

}





/*Enable Recieved Amount Field on Focus*/
$('.project_completed').focus(function () {
    $('.received_amount').prop('disabled', false);
});

$('.project_completed').keyup(function (event) {
    var value = $(this).val();
    if(value > 100){
        $(this).val(value.substr(0, value.length - 1));
    }
    calculate_due(this, event);
});

$('.received_amount').on('keyup keydown',function (event) {
    calculate_due(this, event);
});
$('.payment_received, .enter_credit').on('click', function (){
    var checked_invoices = $('.invoice_nos:checkbox:checked');
    var new_invoice = $('.append_first').length;
    var invoice_btn = $('.append_first .invoice_no_button:checkbox:checked');
    if (checked_invoices.length > 1 || (checked_invoices.length > 0 && new_invoice > 0 && invoice_btn.is(':checked') == true)) {
        // $('.payment_received').prop('disabled', true);
        $('.is_split_invoice').val(1);
        $('#empty_message').modal('show');
        $('.invoice_summary_table').hide();
        $('#append_data').html('');
        jQuery.each(checked_invoices, function(index, item) {
            var balance_due = parseFloat($('#'+item.value+' .balance_due').val().replace(/,/g, ''));
            var invoice_total = parseFloat($('#'+item.value+' .total_inovices_amount').val().replace(/,/g, ''));
            var ledger_payment_received = parseFloat($('#'+item.value+' .ledger_payment_received').val().replace(/,/g, ''));
            var common_invoice_id = $('#'+item.value+' .common_invoice_id').val();
            var ledger_credit = parseFloat($('#'+item.value+' .ledger_credit').val().replace(/,/g, ''));
            var remaining_balance = invoice_total-ledger_payment_received-ledger_credit;
            var html;
            html += '<tr id="'+item.value+'" class="tr_invoice">';
            html += '<td><input type="text" name="common_invoice_no_split[]" class="form-control common_invoice_no_split" value="'+item.value+'" readonly ><input type="hidden" name="common_invoice_id_split[]" class="form-control common_invoice_id_split" value="'+common_invoice_id+'" readonly ></td>';
            html += '<td><input type="text" name="total_inovices_amount_split[]" class="form-control total_inovices_amount_split" value="'+invoice_total+'" readonly ></td>';
            html += '<td><input type="text" name="ledger_payment_received_split[]" class="form-control ledger_payment_received_split" value="'+ledger_payment_received+'" readonly ></td>';
            html += '<td><input type="text" name="ledger_credit[]" class="form-control ledger_credit" value="'+ledger_credit+'" readonly ></td>';
            html += '<td><input type="text" name="balance_due_split[]" class="form-control balance_due_split" value="'+remaining_balance.toFixed(2)+'" readonly></td>';
            html += '<td class="amount_td"><input type="text" name="payment_received_split[]" class="form-control calCulate_amount payment_received_split" value="0.00"  ><span class="amount_error_'+item.value+' text-danger"></span></td>';
            html += '<td><input type="text" name="credit_split[]" class="form-control calCulate_amount credit_split" value="0.00"></td>';
            html += '</tr>';
            
            $('#append_data').append(html);
        });
        if ($('.append_first').length != 0) {
            
            
            if (invoice_btn.is(':checked') == true) {
                var new_invoice_no = $('.append_first .invoice_no_button').val();
                $('#invoice_summary_append').html('');
                $('.invoice_summary_table').show();
                var original_sum = $('#original_sum').text();
                var new_sum = $('#new_sum').text();
                var project_completed = $('.project_completed').val();
                var amount_received = $('.amount_received').val();
                var amount_credit = $('.amount_credit').val();
                var current_inv_total = $('.current_inv_total').val();
                var received_amount = $('.received_amount').val();
                var total_balance_finish = $('.total_balance_finish').val();
                var balance_to_finish_amount = $('.balance_to_finish_amount').val();
                var html2;
                html2 += '<tr class="tr_split">';
                // html2 += '<td><input type="text" class="form-control original_sum_split" id="original_sum_split" value="'+original_sum+'" readonly></td>';
                // html2 += '<td><input type="text" class="form-control total_inovices_amount" value="'+new_sum+'" id="new_sum_split" readonly ></td>';
                html2 += '<td><input type="text" class="form-control total_inovices_amount" value="'+new_invoice_no+'" id="new_sum_split" readonly ></td>';
                html2 += '<td><input type="text" name="balance_due" class="form-control balance_due" value="'+current_inv_total+'" readonly></td>';
                // html2 += '<td><input type="text" name="project_completed" class="form-control project_completed_split" value="'+project_completed+'" readonly></td>';
                html2 += '<td><input type="text" name="balance_due" class="form-control balance_due" value="" readonly></td>';
                html2 += '<td><input type="text" name="balance_due" class="form-control balance_due" value="" readonly></td>';
                
                // html2 += '<td><input type="text" name="balance_due" class="form-control balance_due" value="'+received_amount+'" readonly></td>';
                html2 += '<td ><input type="text" name="balance_due" class="form-control total_balance_finish_split" value="'+total_balance_finish+'" readonly></td>';
                // html2 += '<td><input type="text" name="balance_due" class="form-control balance_due" value="'+balance_to_finish_amount+'" readonly></td>';
                html2 += '<td class="amount_td"><input type="text" class="form-control inv_payment_received_split payment_class_split" value="0.00" name="payment_received"><span class="amount_error_ text-danger"></span></td>';
                html2 += '<td><input type="text" class="form-control inv_enter_credit_split payment_class_split" value="0.00" ></td>';
                $('#invoice_summary_append').append(html2);
            }
        }
    } else {
        $('.is_split_invoice').val(0);
        $('.payment_received').prop('disabled', false);
    }
})

$(document).on('keydown keyup', '.calCulate_amount', function(e){
    
    var row = $(this).closest('.tr_invoice');
    var payment = row.find('.payment_received_split').val();
    var credit = row.find('.credit_split').val();
    var balance_due_split = row.find('.balance_due_split').val();
    var common_invoice_no_split = row.find('.common_invoice_no_split').val();
    if ((parseFloat(payment)+parseFloat(credit)) > balance_due_split) {
            row.find('.amount_error_'+common_invoice_no_split).text('amount should not greater than' + balance_due_split);
            $('.save_invoice').prop('disabled',true);
        }else{
            $('.amount_error_'+common_invoice_no_split).text('');
            $('.save_invoice').prop('disabled',false);
        }
});
$(document).on('keydown keyup', '.payment_class_split', function(e){
    
    var total_balance_finish = parseFloat($('.total_balance_finish').val()).toFixed(2);
    var row = $(this).closest('.tr_split');
    var inv_enter_credit_split = row.find('.inv_enter_credit_split').val();
    var inv_payment_received_split = row.find('.inv_payment_received_split').val();
    if ((parseFloat(inv_enter_credit_split)+parseFloat(inv_payment_received_split)) > total_balance_finish) {
            row.find('.amount_error_').text('amount should not greater than' + total_balance_finish);
            $('.save_invoice').prop('disabled',true);
        }else{
            $('.amount_error_').text('');
            $('.save_invoice').prop('disabled',false);
        }
});
$('.payment_received').on('keydown keyup', function(e){
    var current_inv_total = localStorage.getItem('total') ? localStorage.getItem('total') : localStorage.getItem('amount');
    var payment_received  = parseFloat($('.payment_received').val()).toFixed(2);
    var credit = parseFloat($('.enter_credit').val()).toFixed(2);
    var total_rec = parseFloat($('.total_balance_finish').val()).toFixed(2);
    var totlal_val = parseFloat(payment_received)+parseFloat(credit);
    if(isNaN(totlal_val)){
        totlal_val = 0;
    }
    
	let get_checkbox_invoice_no = 0;

	if ($('.invoice_no_button').is(':checked')){
		get_checkbox_invoice_no = $('.invoice_no_button:checked').val();
	}
    if($('#'+get_checkbox_invoice_no).length != 0) {
        //payment for old invoice
        var total_inovices_amount = parseFloat($('#'+get_checkbox_invoice_no+' .total_inovices_amount').val().replace(/,/g, ''));
        var ledger_payment_received = parseFloat($('#'+get_checkbox_invoice_no+' .ledger_payment_received').val().replace(/,/g, ''));
        var ledger_credit = parseFloat($('#'+get_checkbox_invoice_no+' .ledger_credit').val().replace(/,/g, ''));
        var receiveable_amount_for_old_inv = total_inovices_amount - ledger_payment_received - ledger_credit;
        var input_payment_total = parseFloat($(this).val()) + Number(credit);
        if (input_payment_total > receiveable_amount_for_old_inv
            && e.keyCode !== 46 // keycode for delete
            && e.keyCode !== 8 // keycode for backspace
        ) {
            $('.credit_received_parent .error').text('amount should not greater than' + receiveable_amount_for_old_inv);
            // e.preventDefault();
            // $(this).val(receiveable_amount_for_old_inv);
            $('#save_invoice').prop('disabled',true);
        }else{
            $('.credit_received_parent .error').text('');
            $('.credit_received_parent .amount_error').html('');
            $('#save_invoice').prop('disabled',false);
        }
    } else {
        //payment for new invoice
        if( totlal_val > total_rec){
            console.log('check is ture');
            $('.credit_received_parent .error').text('');
            $('#amount_error').html('Amount should not greater than '+total_rec);
            $('#save_invoice').prop('disabled',true);
            // return;
        } else {
            $('.credit_received_parent .error').text('');
            $('#amount_error').html('');
            $('#save_invoice').prop('disabled', false);
        }
    }
	

});

//credit amount
$('.enter_credit').on('keydown keyup', function(e){
    // var current_inv_total = $('#current_inv_total').val();
    var current_inv_total = localStorage.getItem('total') ? localStorage.getItem('total') : localStorage.getItem('amount');
    var payment_received  = parseFloat($('.payment_received').val()).toFixed(2);
    if(isNaN(payment_received)){
        payment_received = 0;
    }
    var crdit = parseFloat($('.enter_credit').val()).toFixed(2);
    var total_rec = parseFloat($('.total_balance_finish').val()).toFixed(2);
    var totlal_val = parseFloat(payment_received)+parseFloat(crdit);
    

	let get_checkbox_invoice_no = 0;

	if ($('.invoice_no_button').is(':checked')){
		get_checkbox_invoice_no = $('.invoice_no_button:checked').val();
	}
    if($('#'+get_checkbox_invoice_no).length != 0) {
        var total_credit_amount = parseFloat($('#'+get_checkbox_invoice_no+' .balance_due').val().replace(/,/g, ''));

        var total_inovices_amount = parseFloat($('#'+get_checkbox_invoice_no+' .total_inovices_amount').val().replace(/,/g, ''));
        var ledger_payment_received = parseFloat($('#'+get_checkbox_invoice_no+' .ledger_payment_received').val().replace(/,/g, ''));
        var ledger_credit = parseFloat($('#'+get_checkbox_invoice_no+' .ledger_credit').val().replace(/,/g, ''));
        var receiveable_amount_for_old_inv = total_inovices_amount - ledger_payment_received - ledger_credit;
        var input_payment_total = parseFloat($(this).val()) + Number(payment_received);
        console.log(payment_received);
        if (input_payment_total > receiveable_amount_for_old_inv
            && e.keyCode !== 46 // keycode for delete
            && e.keyCode !== 8 // keycode for backspace
        ) {
            $('.credit_received_parent .error').text('amount should not greater ' + receiveable_amount_for_old_inv);
            $('#save_invoice').prop('disabled',true);
        }else{
            $('.credit_received_parent .error').text('');
            $('.payment_received_parent .error').text('');
            $('#save_invoice').prop('disabled',false);
        }
    } else {
        //payment for new invoice
        if( totlal_val > total_rec){
            $('.amount_error').html('Amount should not greater than '+total_rec);
            $('#save_invoice').prop('disabled',true);
            // return;
        } else {
            $('.amount_error').html('');
            $('.payment_received_parent .error').text('');
            $('#save_invoice').prop('disabled',false);
        }
    }

});
$('.payment_received_split').on('keydown keyup', function(e){
    // console.log($('.invoice_nos').length());
    // var check = $('.invoice_nos').find('input[type="checkbox"]').prop('checked').length;
    // var check = $("input:checked").length;
    
    // var current_inv_total = $('#current_inv_total').val();
    var current_inv_total = localStorage.getItem('total') ? localStorage.getItem('total') : localStorage.getItem('amount');
    var payment_received  = parseFloat($('.payment_received_split').val()).toFixed(2);
    var crdit = parseFloat($('.enter_credit_split').val()).toFixed(2);
    var total_rec = parseFloat($('.total_balance_finish_split').val()).toFixed(2);
    var totlal_val = parseFloat(payment_received)+parseFloat(crdit);
    if( totlal_val > total_rec){
        $('#amount_error_split').html('Amount should not greater than '+total_rec);
        $('.save_invoice').prop('disabled',true);
        // return;
    } else {
        $('#amount_error_split').html('');
        $('.save_invoice').prop('disabled', false);
    }
	// let get_checkbox_invoice_no = 0;

	// if ($('.invoice_no_button').is(':checked')){
	// 	get_checkbox_invoice_no = $('.invoice_no_button:checked').val();
	// }
    // if($('#'+get_checkbox_invoice_no).length != 0) {
    //     var total_inovices_amount = parseFloat($('#'+get_checkbox_invoice_no+' .balance_due').val().replace(/,/g, ''));
    //     if ($(this).val() > total_inovices_amount
    //         && e.keyCode !== 46 // keycode for delete
    //         && e.keyCode !== 8 // keycode for backspace
    //     ) {
    //         $('.payment_received_parent .error').text('amount should not greater ' + total_inovices_amount);
    //         e.preventDefault();
    //         $(this).val(total_inovices_amount);
    //     }else{
    //         $('.payment_received_parent .error').text('');
    //     }
    // }
	

});

$(".payment_received").keyup(function(){
	var val = $(this).val().replace(/\,/g,'');
	$(this).val( val );
});


$(".enter_credit").keyup(function(){
	var val = $(this).val().replace(/\,/g,'');
	$(this).val( val );
});

$('.credit').on('keyup keydown', function (event) {
    calculate_due(this, event);
});

$('.save_invoice').click(function (event) {
	$(this).prop("disabled", true);
    save_common_invoice();
});

function calculateOriginalSum() {
    var sum = 0;
    $.each($("input[name='billable_item']:checked"), function(){
        global_check_box_count = global_check_box_count+1;
    });
    // iterate through each td based on class and add the values
    $(".total_col").each(function() {

        var value = $(this).text();
        var removed_field = $(this).next().find('input[type="checkbox"]').prop('checked');

        // add only if the value is number
        if(!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);

            $('#original_sum').html(sum.toFixed(2));
        }
    });
}



function calculateNewSum() {
    var sum = 0;

    // iterate through each td based on class and add the values
    $(".overall_total").each(function() {

        var value = $(this).text();
        // var removed_field = $(this).next().find('input[type="checkbox"]').prop('checked');
        var check_box_cancel = $(this).next().next().find('input[type="checkbox"]').prop('checked');
        if(check_box_cancel == false){
            var value = $(this).text();
            if(!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
                $('#new_sum').html(sum.toFixed(2));
            }
        }

        // add only if the value is number
        // if(!isNaN(value) && value.length != 0) {
        //     sum += parseFloat(value);

        //     $('#new_sum').html(sum.toFixed(2));
        // }
    });

    return sum;
}
// function calculateNewSum() {
//     var sum = 0;

//     // iterate through each td based on class and add the values
//     $(".overall_total").each(function() {
//         var check_box_cancel = $(this).next().next().find('input[type="checkbox"]').prop('checked');
        
//         // add only if the value is number
//         if(check_box_cancel == false){
//             var value = $(this).text();
//             if(!isNaN(value) && value.length != 0) {
//                 sum += parseFloat(value);
//                 $('#new_sum').html(sum.toFixed(2));
//             }
//         }
//     });

//     return sum;
// }

function calculate_due(obj, e) {
    element = $(obj);

    var original_sum = 0;
    var new_sum = 0;
    var completed = 0;
    // var credit = 0;
    var amount_due = 0;
    var received_amount = 0;
    var balance_to_finish = 10;
	var total_amount_due = 0;

    original_sum    =  $('#original_sum').text();
    new_sum         =  $('#new_sum').text();
    completed       =  $('.project_completed').val()/100;
    credit          =  0;
    received_amount =  $('.received_amount').val();

    total_amount_due = (new_sum*completed).toFixed(2);
    const amount_fix_due = total_amount_due;

    if(parseFloat(received_amount) > parseFloat(amount_fix_due) && e && e.keyCode !== 46
        && e.keyCode !== 8){
        e.preventDefault();
        // $('#received .error').text('amount should not greater '+amount_fix_due);
        $('#save_invoice').prop('disabled', true);
        $('.total_due_amount').val('0.00');
        $('.credit').prop('disabled', true);

    } else if(parseFloat(total_amount_due) < (parseFloat(credit) + parseFloat(received_amount)) && e && e.keyCode !== 46
        && e.keyCode !== 8){
        e.preventDefault();
        $('#credit .error').text('sum of recevied and credit should not greater '+amount_fix_due);
        $('#save_invoice').prop('disabled', true);
    }else{

        amount_due = (new_sum*completed) - received_amount;
        // balance_to_finish = new_sum - amount_due - received_amount; //old method
        balance_to_finish = new_sum-received_amount; //new method
        if(parseFloat(received_amount) >= parseFloat(amount_fix_due) && e && e.keyCode !== 46
            && e.keyCode !== 8){
            e.preventDefault();
            $('.total_due_amount').val('0.00');

        }else {
            $('.total_due_amount').val(amount_due.toFixed(2));
       }
        $('.balance_to_finish_amount').val(balance_to_finish.toFixed(2));
        $('#received .error').text(' ');
        // $('#credit .error').text(' ');
        // $('#save_invoice').prop('disabled', false);
        // $('.credit').prop('disabled', false);
        $('.received_amount').prop('disabled', false);
    }
    if(parseFloat(total_amount_due) < (parseFloat(credit)) && e && e.keyCode !== 46
        && e.keyCode !== 8){
        e.preventDefault();
        $('.total_due_amount').val('0.00');
        $('.balance_to_finish_amount').val(balance_to_finish.toFixed(2));
        // $('#credit .error').text('amount should not greater '+amount_fix_due);
        $('#save_invoice').prop('disabled', true);
        // $('.credit').prop('disabled', false);
        $('.received_amount').prop('disabled', false);
    }
}

function save_common_invoice() {
    var today = new Date();
	let get_checkbox_invoice_no = 0;
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date+' '+time;
	if ($('.invoice_no_button').is(':checked')){
		get_checkbox_invoice_no = $('.invoice_no_button:checked').val();
	}


    // for balance due
	var payment_received  = parseFloat($('.payment_received').val()).toFixed(2);
    //credit value
	var credit_total_amount = parseFloat($('.enter_credit').val()).toFixed(2);
	var received_amount = localStorage.getItem('total') ? localStorage.getItem('total') : localStorage.getItem('amount');
	var total_due_ledger = parseFloat($('.total_due').val()).toFixed(2);
	var balance_due = received_amount - payment_received;
	balance_due = parseFloat(balance_due).toFixed(2);
	$('.balance_due').val(balance_due);
	 //get invoice number from localstorage
	 var get_invoice_no = localStorage.getItem('invoice_no');
     
	if (get_invoice_no == null){
		var total_inovices_amount = $('#'+get_checkbox_invoice_no+' .total_inovices_amount').val();
		var ledger_payment_received = $('#'+get_checkbox_invoice_no+' .ledger_payment_received').val();
		var total_ledger_payment_received = parseFloat(payment_received) + parseFloat(ledger_payment_received.replace(/,/g, ''));
        var ledger_credit = $('#'+get_checkbox_invoice_no+' .ledger_credit').val();
        var credit_total_amount = Number(credit_total_amount) + Number(ledger_credit);
		var balance_due = total_inovices_amount.replace(/,/g, '') - total_ledger_payment_received - credit_total_amount ;
		payment_received = total_ledger_payment_received;
		received_amount = total_inovices_amount;
	}
   
	//balancs finish amount
	var balance_to_finish_amount = $('.balance_to_finish_amount').val();
	var estimate_id = $('.estimate_id').val();
	//get data form local storage
    var record;
    var split_record;
    var is_split_invoice = $('.is_split_invoice').val();
    var invoice_btn = $('.append_first .invoice_no_button:checkbox:checked');
    if (is_split_invoice == 1) { //if it is a split invoice
        var payment_received_split  = parseFloat($('.inv_payment_received_split').val()).toFixed(2);
        var credit_total_amount = parseFloat($('.inv_enter_credit_split').val()).toFixed(2);
        var invoice_no = $('.append_first .invoice_no_button').val();
        record = {
            estimate_id:        estimate_id,
            original_sum:       $('#original_sum').text(),
            new_sum:            $('#new_sum').text(),
            project_completed:  $('.project_completed').val(),
            credit:             credit_total_amount,
            amount_received:    received_amount,
            payment_received:   payment_received_split,
            payment_date:       dateTime,
            balance_due:   		balance_due,
            total_due:          received_amount,
            balance_to_finish:  balance_to_finish_amount,
            exclusions:         $('.job_exclusions').val(),
            // past_due_amount:    $('.past_due_input').val(),
            created_at:         dateTime,
            areas_productions:  JSON.parse(localStorage.getItem('areas_productions')),
            miscellaneous:      JSON.parse(localStorage.getItem('miscellaneous')),
            subcontractors:     JSON.parse(localStorage.getItem('subcontractors')),
            time_materials:     JSON.parse(localStorage.getItem('time_materials')),
            time_materials_cancel:     JSON.parse(localStorage.getItem('time_materials_cancel')),
            subcontractors_cancel:     JSON.parse(localStorage.getItem('subcontractors_cancel')),
            areas_productions_cancel:  JSON.parse(localStorage.getItem('areas_productions_cancel')),
            miscellaneous_cancel:      JSON.parse(localStorage.getItem('miscellaneous_cancel')),
            // invoice_no:			localStorage.getItem('invoice_no')
            invoice_no:			    get_checkbox_invoice_no,
            receiveable_amount:	    $('.total_balance_finish').val(),
            
        };
        // var ss = $('input:text.common_invoice_no_split').serialize();
        var common_invoice_no_split = $('input[name="common_invoice_no_split[]"]').map(function(){ 
            return this.value; 
        }).get();
        var total_inovices_amount_split = $('input[name="total_inovices_amount_split[]"]').map(function(){ 
            return this.value; 
        }).get();
        var ledger_payment_received_split = $('input[name="ledger_payment_received_split[]"]').map(function(){ 
            return this.value; 
        }).get();
        var balance_due_split = $('input[name="balance_due_split[]"]').map(function(){ 
            return this.value; 
        }).get();
        var payment_received_split = $('input[name="payment_received_split[]"]').map(function(){ 
            return this.value; 
        }).get();
        var credit_split = $('input[name="credit_split[]"]').map(function(){ 
            return this.value; 
        }).get();
        var ledger_credit = $('input[name="ledger_credit[]"]').map(function(){ 
            return this.value; 
        }).get();
        var common_invoice_id_split = $('input[name="common_invoice_id_split[]"]').map(function(){ 
            return this.value; 
        }).get();
        split_record = {
            invoice_nos:        common_invoice_no_split,
            total_amount:       total_inovices_amount_split,
            received_payment:   ledger_payment_received_split,
            balance_due:        balance_due_split,
            new_payment:        payment_received_split,
            new_credit:         credit_split,
            old_credit:         ledger_credit,
            balance_to_finish:  balance_to_finish_amount,
            receiveable_amount: $('.total_balance_finish').val(),
            created_at:         dateTime,
            project_completed:  $('.project_completed').val(),
            common_invoice_id_split:  common_invoice_id_split,
            payment_date:       dateTime,
        }
        if ($('.append_first').length == 0 || invoice_btn.is(':checked') == false) {
            record = null;
        }
    } else {
        record =  {
            estimate_id:        estimate_id,
            original_sum:       $('#original_sum').text(),
            new_sum:            $('#new_sum').text(),
            project_completed:  $('.project_completed').val(),
            credit:             credit_total_amount,
            amount_received:    received_amount,
            payment_received:   payment_received,
            payment_date:       dateTime,
            balance_due:   		balance_due,
            total_due:          received_amount,
            balance_to_finish:  balance_to_finish_amount,
            exclusions:         $('.job_exclusions').val(),
            // past_due_amount:    $('.past_due_input').val(),
            created_at:         dateTime,
            areas_productions:  JSON.parse(localStorage.getItem('areas_productions')),
            miscellaneous:      JSON.parse(localStorage.getItem('miscellaneous')),
            subcontractors:     JSON.parse(localStorage.getItem('subcontractors')),
            time_materials:     JSON.parse(localStorage.getItem('time_materials')),
            time_materials_cancel:     JSON.parse(localStorage.getItem('time_materials_cancel')),
            subcontractors_cancel:     JSON.parse(localStorage.getItem('subcontractors_cancel')),
            areas_productions_cancel:  JSON.parse(localStorage.getItem('areas_productions_cancel')),
            miscellaneous_cancel:      JSON.parse(localStorage.getItem('miscellaneous_cancel')),
            // invoice_no:			localStorage.getItem('invoice_no')
            invoice_no:			    get_checkbox_invoice_no,
            receiveable_amount:	    $('.total_balance_finish').val()
        };
        split_record = null;
    }
	var localStorage_invoice_no = localStorage.getItem('invoice_no');
    $.ajax({
		async: true,
        url : base_url+'/estimating/store_common_invoice',
        data : {record : record, invoice_no: localStorage_invoice_no, estimate_id: estimate_id,split_record:split_record},
        type : 'POST',
        dataType : 'json',
		success: function(response){
            if(response['status_without_record']){
                window.location.replace(base_url+'estimating/common_estimate_page/'+estimate_id);
            }else if (response['status']){
                $('#preview_button').attr('common-id' , response['id']);
				window.location.replace(base_url+'invoices/common_invoice/?common='+response['id']+'&est='+estimate_id);
            } else {
                alert('Invoice Failed To Save!');
            }
        }
    });
}


/*Call this Function on Checkbox check*/
/*Subtract row Value from New Sum on Checked*/
function update_field_cancel_item(obj,id,table){
    var date    =  new Date();
    var element = $(obj);
    date = date.toLocaleDateString("en-US");
    element.next('.cancel_date').text(date);
    var billableItem = new Array();
    var item_id = element.closest('tr').attr('id');
    

    if (!element.prop('checked') == true) {
        var cancel_date = element.closest('.tr').find('.cancel_date');
        // var status_date = element.closest('.tr').find('.status_date');
        var remove_item = element.closest('.tr').find('.remove_item');
        // status_date.html('');
        $(remove_item).prop("checked", false);
        $(remove_item).attr("disabled", false);
        cancel_date.html('');
    	billableItem = localStorage.getItem(table) ? JSON.parse(localStorage.getItem(table)) : [];
		var index = billableItem.indexOf(item_id);
		var spliced_array = billableItem.splice(index, 1);
    	/* Remove value in Local Storage */
		localStorage.setItem(table, JSON.stringify(billableItem));
		status = 0;
        date = '';

		fetch_invoice_no(obj,is_cancel=true);
        change_cancel_item_status(item_id,table,status,date);
        // update_status(id, table, status, new_sum, date);

        var item_val = element.closest('.tr').find('.item_val');
        var new_sum = parseFloat($('#new_sum').text());
        var balance_to_finish_amount = parseFloat($('.balance_to_finish_amount').val());
        var new_sum_after_cancel_item = new_sum+parseFloat(item_val.text());
        var new_balance_to_finish_after_calcel_item = balance_to_finish_amount + parseFloat(item_val.text());
        calculate_billable_sum(new_sum_after_cancel_item);
        $('#new_sum').text(new_sum_after_cancel_item.toFixed(2));
        $('.balance_to_finish_amount').val(new_balance_to_finish_after_calcel_item.toFixed(2));

        // var original_sum = parseFloat($('#original_sum').text());
        // var original_sum_after_cancel_item = original_sum+parseFloat(item_val.text());
        // $('#original_sum').text(original_sum_after_cancel_item.toFixed(2));

    } else {
		billableItem = localStorage.getItem(table) ? JSON.parse(localStorage.getItem(table)) : [];
		billableItem.push(item_id);
		localStorage.setItem(table, JSON.stringify(billableItem));
		fetch_invoice_no(obj,is_cancel=true);
        
        // var status_date = element.closest('.tr').find('.status_date');
        var remove_item = element.closest('.tr').find('.remove_item');
        // status_date.html('');
        // $(remove_item).prop("checked", false);
        $(remove_item).attr("disabled", true);

        var cancel_date = element.closest('.tr').find('.cancel_date');
        var status = 1;
        change_cancel_item_status(item_id,table,status,cancel_date);

        var item_val = element.closest('.tr').find('.item_val');
        var new_sum = parseFloat($('#new_sum').text());
        var balance_to_finish_amount = parseFloat($('.balance_to_finish_amount').val());
        
        var new_sum_after_cancel_item = new_sum-parseFloat(item_val.text());
        var new_balance_to_finish_after_calcel_item = balance_to_finish_amount -item_val.text();
        calculate_billable_sum(new_sum_after_cancel_item);
        $('#new_sum').text(new_sum_after_cancel_item.toFixed(2));
        $('.balance_to_finish_amount').val(new_balance_to_finish_after_calcel_item.toFixed(2));
        var original_sum = parseFloat($('#original_sum').text());
        // var original_sum_after_cancel_item = original_sum-parseFloat(item_val.text());
        // $('#original_sum').text(original_sum_after_cancel_item.toFixed(2));
        // // update_status(id, table, status, new_sum, date);
    }
}
function update_field_status(obj, id, table) {
	var billableItem = new Array();
	var element = $(obj);
    var status  = 1;
    var date    =  new Date();
    date = date.toLocaleDateString("en-US");

	let last_amount = null;
	var value = parseFloat(element.closest('td').siblings('.overall_total').text());

	

	var item_id = element.closest('tr').attr('id');
	var new_sum = parseFloat($('#new_sum').text());

    if (!element.prop('checked') == true) {

        if(localStorage.getItem('amount')) {
            last_amount = localStorage.getItem('amount');
            localStorage.setItem('total', parseFloat(localStorage.getItem('total') ? localStorage.getItem('total') : localStorage.getItem('amount')) - parseFloat(value));
        }
        localStorage.setItem('amount', JSON.stringify(value));
        var cancel_item = element.closest('.tr').find('.cancel_item');
        $(cancel_item).attr("disabled", false);
    	billableItem = localStorage.getItem(table) ? JSON.parse(localStorage.getItem(table)) : [];
		var index = billableItem.indexOf(item_id);

		// billableItem.filter(item => item !== item_id.toString());
		var spliced_array = billableItem.splice(index, 1);
    	/* Remove value in Local Storage */
		localStorage.setItem(table, JSON.stringify(billableItem));
		status = 0;
        date = '';


		fetch_invoice_no(obj,is_cancel=false);
        var item_val = element.closest('.tr').find('.item_val');
        var new_sum = parseFloat($('#new_sum').text());
        var balance_to_finish_amount = parseFloat($('.balance_to_finish_amount').val());
        var new_sum_after_cancel_item = new_sum+parseFloat(item_val.text());
        var new_balance_to_finish_after_calcel_item = balance_to_finish_amount + parseFloat(item_val.text());

        calculate_billable_sum(parseFloat(new_sum));
        // $('#new_sum').text(new_sum_after_cancel_item.toFixed(2));
        $('.balance_to_finish_amount').val(new_balance_to_finish_after_calcel_item.toFixed(2));
        // update_status(id, table, status, new_sum, date);

        var item_vals = element.closest('.tr').find('.item_val');
        var current_total = $('.current_inv_total').val();
        var ct;
        if(current_total){
            ct = parseFloat(current_total)-parseFloat(item_vals.text())
        } else {
            ct = 0;
        }
        $('.current_inv_total').val(ct.toFixed(2));
        total_balance_finish();

    } else {
        if(localStorage.getItem('amount')) {
            last_amount = localStorage.getItem('amount');
            localStorage.setItem('total', parseFloat(localStorage.getItem('total') ? localStorage.getItem('total') : localStorage.getItem('amount')) + parseFloat(value));
        }
        localStorage.setItem('amount', JSON.stringify(value));
        billableItem = localStorage.getItem(table) ? JSON.parse(localStorage.getItem(table)) : [];
		billableItem.push(item_id);
		/* Push new Value */
		localStorage.setItem(table, JSON.stringify(billableItem));
		fetch_invoice_no(obj,is_cancel=false);
        
        var cancel_item = element.closest('.tr').find('.cancel_item');
        var item_vals = element.closest('.tr').find('.item_val');
        var current_total = $('.current_inv_total').val();
        var ct;
        if(current_total){
            ct = parseFloat(current_total)+parseFloat(item_vals.text())
        } else {
            ct = item_vals.text();
        }
        $('.current_inv_total').val(ct.toFixed(2));
        total_balance_finish();

        if(cancel_item.is(':checked')){
            var cancel_date = element.closest('.tr').find('.cancel_date');
            cancel_date.html('');
            $(cancel_item).prop("checked", false);
            $(cancel_item).attr("disabled", true);
            var status = 0;
            var date_ = '';
            change_cancel_item_status(item_id,table,status,date_);

            
            //here new_sum, balance to finish and billable_sum will be updated
            var item_val = element.closest('.tr').find('.item_val');
            var new_sum = parseFloat($('#new_sum').text());
            var balance_to_finish_amount = parseFloat($('.balance_to_finish_amount').val());
            var new_sum_after_cancel_item = new_sum+parseFloat(item_val.text());
            var new_balance_to_finish_after_calcel_item = balance_to_finish_amount+parseFloat(item_val.text());
            calculate_billable_sum(parseFloat(new_sum_after_cancel_item));
            $('#new_sum').text(new_sum_after_cancel_item.toFixed(2));
            // $('.balance_to_finish_amount').val(new_balance_to_finish_after_calcel_item.toFixed(2));
           


            
        }else{
            $(cancel_item).prop("checked", false);
            $(cancel_item).attr("disabled", true);
            var item_val = element.closest('.tr').find('.item_val');
            var new_sum = parseFloat($('#new_sum').text());
            var balance_to_finish_amount = parseFloat($('.balance_to_finish_amount').val());
            
            var new_sum_after_cancel_item = new_sum-parseFloat(item_val.text());
            var new_balance_to_finish_after_calcel_item = balance_to_finish_amount -item_val.text();
            calculate_billable_sum(parseFloat(new_sum));
            
            // $('#new_sum').text(new_sum_after_cancel_item.toFixed(2));
            $('.balance_to_finish_amount').val(new_balance_to_finish_after_calcel_item.toFixed(2));
        }
    }
    element.next('.status_date').text(date);
}

function fetch_invoice_no(elem,is_cancel) {
	var estimate_id = $('.estimate_id').val();

		$.ajax({
			type : "post",
			data : {estimate_id : estimate_id},
			url : base_url+"estimating/get_invoice_info",
			dataType : "json",
			success : function(response){
                if(!is_cancel==true) {
                    if ($(elem).is(':checked')){
                        $(elem).parent().siblings('td.invoice_no').children('span').text(response);
                    }else{
                        $(elem).parent().siblings('td.invoice_no').children('span').empty();
                    }
                }
				//	append tr
				var markup = "<tr class='append_first'>" +
					"<td class='invoice_no'><label><input type='checkbox' style='float:left; margin-top:2px; margin-left:5px;'  class='invoice_no_button' name='invoice_no' value='"+response+"'><span></span></label></td>" +
					"<td><label><input type='checkbox' name='past_due' id='past_due' style='float:left' ><span style='float:left; margin-top:2px; margin-left:5px;'>Past due</span></label></td>" +
					"</tr>";

				if (localStorage.getItem('invoice_no') == null){
					$(".past_due_table tbody").append(markup);
				}
				/* Set Value  */
				localStorage.setItem('invoice_no', response);

				$('.past_due_table .invoice_no span').text(response);
				$('.remove_tr').remove();
				// fieldEnableEventListener();
				$('.invoice_no_button').on('click', function () {
					$('.payment_received, .enter_credit').removeAttr("disabled");
					$('#save_invoice').prop('disabled', false);
				});
                var all_checked_billabe_item = 0;
                $.each($("input[name='billable_item']:checked"), function(){
                    all_checked_billabe_item = all_checked_billabe_item+1;
                });
                if (global_check_box_count == all_checked_billabe_item || all_checked_billabe_item < global_check_box_count) {
                    if($('.append_first').length > 0) {
                        $('.append_first').hide();
                    }
                } else {
                    if($('.append_first').length > 0) {
                        $('.append_first').show();
                    }
                }
			},
			error: function() {
				alert('There is some error performing the Task');
			}
		});
}

//remove attributes from enter payment and credit input field
// function fieldEnableEventListener(){
	$('.invoice_no_button').on('click', function () {
		$('.payment_received, .enter_credit').removeAttr("disabled");
		$('#save_invoice').prop('disabled', false);
	});
// }

// $('.payment_received').on('keydown keyup', function(e){
// 	$('#save_invoice').prop('disabled', false);
// });

function update_status(id, table, status, new_sum, date) {

    $.ajax({
        url : base_url+'/estimating/update_invoice_field_status',
        data : {id: id, table: table, status: status, date: date},
        type : 'POST',
        dataType : 'json',
        success: function(response){
            if (response){
                $('#new_sum').text(new_sum.toFixed(2));
            }
        }
    });
}

function change_cancel_item_status(id,table,status,date) {
    var cancel_date;
    if(date != ''){
        cancel_date = date.html();
    } else {
        cancel_date = '';
    }
    $.ajax({
        url : base_url+'/estimating/update_cancel_item_status',
        data : {id: id, table: table, status: status, date: cancel_date},
        type : 'POST',
        dataType : 'json',
        success: function(response){
            if (response){
                // $('#new_sum').text(new_sum.toFixed(2));
            }
        }
    });
}

function calculate_billable_sum(new_sum) {
    var billable_sum = 0;
    var percent_completed = 0;

    $.each($("input[name='billable_item']:checked"), function(){
        billable_sum += parseFloat($(this).parent().siblings('.overall_total').text());
    });

    percent_completed = (billable_sum / new_sum) * 100;
    $('.project_completed').val(percent_completed.toFixed(2));
    $('.received_amount').val(billable_sum.toFixed(2));
    calculate_due(this, event);
}

function update_past_due(event) {
    var assignPastDue;
    var  past_due=$('input[name ="pastdue"]').val();
    if(past_due === '0'){
        assignPastDue = 1;
    }else{
        assignPastDue = 0;
    }
    $('input[name ="past_due"]').val(assignPastDue);
    $('input[name ="paid_amount"]').val('0');

    var invoice_id  = $('input[name ="existing_invoice_id"]').val();
    var common_id   = $('input[name ="common_id"]').val();
    var past_due    = assignPastDue;
    var paid_amount = '0';

    $.ajax({
        url : base_url+'/estimating/update_common_invoice',
        data : {invoice_id: invoice_id, common_id: common_id, past_due: past_due, paid_amount: paid_amount},
        type : 'POST',
        dataType : 'json',
        success: function(response){
            if (response){
                window.location.reload(true);
            }
        }
    });
}

function update_paid(event) {
    var assignPastDue;
    var  past_due=$('input[name ="paid_amount"]').val();
    if(past_due === '0'){
        assignPastDue = 1;
    }else{
        assignPastDue = 0;
    }
    $('input[name ="paid_amount"]').val(assignPastDue);
    $('input[name ="past_due"]').val('0');

    var invoice_id  = $('input[name ="existing_invoice_id"]').val();
    var common_id   = $('input[name ="common_id"]').val();
    var past_due    = '0';
    var paid_amount = assignPastDue;
    $.ajax({
        url : base_url+'/estimating/update_common_invoice',
        data : {invoice_id: invoice_id, common_id: common_id, past_due: past_due, paid_amount: paid_amount},
        type : 'POST',
        dataType : 'json',
        success: function(response){
            if (response){
                window.location.reload(true);
            }
        }
    });
}

window.onload = function()
{
	window.localStorage.clear();
}
