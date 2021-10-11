$(document).ready(function () {
    if(setup === '1' ){
        $("input.editable").removeAttr("readonly");
        $("input").addClass('form-control-input');
        $('.creat-cost-setup').removeClass('form-control-input');
    }

    /* Set Employee Mix Data in Cost Setup Fields in Bottom Table */
    var avg_mix_rate = $('.employees_mix_table #employee_avg_mix_rate').text().replace(/[,$]/g, '');
    var annual_hours = $('.employees_mix_table #annual_hours').text().replace(/[,$]/g, '');
    var total_labor = $('.employees_mix_table #total_labor').text().replace(/[,$]/g, '');


    $('.cost-setup-labor-overhead .employees_mix_rate .labor_rate_per_hour').val('$'+avg_mix_rate);
    $('.cost-setup-labor-overhead .employees_annual_hours .operations_overhead').val(annual_hours.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    $('.cost-setup-labor-overhead .total_labor_revenue .management_overhead').val('$'+total_labor.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));

    /* Set Non Productive Overhead Data in Cost Setup Fields in Bottom Table */
    var non_pro_annual_salary = parseInt($('.non_pro_employees_table #total_annual_salary').text().replace(/[,$]/g, ''));
    var non_pro_total_hours = parseInt($('.non_pro_employees_table #total_hours').text().replace(/[,$]/g, ''));
    var total_burden_fringe = parseFloat($('.cost-setup-management-overhead .total_burden strong').text().replace(/[,$%]/g, ''), 10).toFixed(2);
    var non_pro_mix_rate = parseFloat(non_pro_annual_salary / non_pro_total_hours).toFixed(2);
    var non_pro_per_hour_cost = parseFloat(non_pro_mix_rate, 10) + parseFloat((non_pro_mix_rate * total_burden_fringe) / 100, 10);
    var total_burden = parseFloat($('.total_fringe_benefits strong').text());

    var total_non_productive_revenue = non_pro_annual_salary + ((non_pro_annual_salary * total_burden_fringe) / 100);

    var total_non_productive_overhead = ((total_non_productive_revenue / parseFloat(total_labor.replace(/[,$]/g,'')).toFixed(2)) * 100).toFixed(2);

    (non_pro_mix_rate > 0) ? $('.management-overhead-body .non_productive_mix_rate .mgmt_avg_mgmt_labor_rate_per_hour').val('$'+non_pro_mix_rate.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"))
:  $('.management-overhead-body .non_productive_mix_rate .mgmt_avg_mgmt_labor_rate_per_hour').val('$0.00');

    (total_non_productive_revenue > 0) ?   $('.management-overhead-body .total_non_productive_revenue').text('$'+total_non_productive_revenue.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")) :   $('.management-overhead-body .total_non_productive_revenue').text('');
    (total_non_productive_overhead > 0) ?   $('.management-overhead-body .non_productive_overhead').text(total_non_productive_overhead+'%') :   $('.management-overhead-body .non_productive_overhead').text('0.00%');
    (total_non_productive_revenue > 0) ?      $('.management-overhead-body .total_non_productive_revenue').text('$'+total_non_productive_revenue.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")) : $('.management-overhead-body .total_non_productive_revenue').text('$0.00');


    (non_pro_per_hour_cost > 0) ? $('.management-overhead-body .mgmt_cost_of_mgmt_labor_with_burden_fringe').val('$'+non_pro_per_hour_cost.toFixed(2))
:     $('.management-overhead-body .mgmt_cost_of_mgmt_labor_with_burden_fringe').val('$0.00');

    /* Set Operating Overheads Data in Cost Setup Fields */
    var total_operating_expense = parseFloat($('#total_operating_expense').text().replace(/[,$]/g, '')).toFixed(2);
    var total_operating_overhead = ((total_operating_expense / total_labor.replace(/[,$]/g,'')) * 100);
    (total_operating_overhead > 0) ? $('.operating_overhead_table #total_operation_overhead').val(total_operating_overhead.toFixed(2)+'%') : $('.operating_overhead_table #total_operation_overhead').val('0.00%');


    /* Set Overhead Totals Data in Cost Setup */
    $('.overhead_totals .mix_rate').val('$'+avg_mix_rate.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    show_overhead_totals();

});

function calculate_cost_setup() {

    /* Set Employee Mix Data in Cost Setup Fields in Bottom Table */
    var avg_mix_rate = $('.employees_mix_table #employee_avg_mix_rate').text().replace(/[,$]/g, '');
    var annual_hours = $('.employees_mix_table #annual_hours').text().replace(/[,$]/g, '');
    var total_labor = $('.employees_mix_table #total_labor').text().replace(/[,$]/g, '');

    $('.cost-setup-labor-overhead .employees_mix_rate .labor_rate_per_hour').val('$'+avg_mix_rate);
    $('.cost-setup-labor-overhead .employees_annual_hours .operations_overhead').val(annual_hours.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    $('.cost-setup-labor-overhead .total_labor_revenue .management_overhead').val('$'+total_labor.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));

    /* Set Non Productive Overhead Data in Cost Setup Fields in Bottom Table */
    var non_pro_annual_salary = parseInt($('.non_pro_employees_table #total_annual_salary').text().replace(/[,$]/g, ''));
    var non_pro_total_hours = parseInt($('.non_pro_employees_table #total_hours').text().replace(/[,$]/g, ''));
    var total_burden_fringe = parseFloat($('.cost-setup-management-overhead .total_burden strong').text().replace(/[,$%]/g, ''), 10).toFixed(2);

    var non_pro_mix_rate = parseFloat(non_pro_annual_salary / non_pro_total_hours).toFixed(2);
    var non_pro_per_hour_cost = parseFloat(non_pro_mix_rate, 10) + parseFloat((non_pro_mix_rate * total_burden_fringe) / 100, 10);

    var total_burden = parseFloat($('.total_fringe_benefits strong').text());

    var total_non_productive_revenue = non_pro_annual_salary + ((non_pro_annual_salary * total_burden_fringe) / 100);

    var total_non_productive_overhead = ((total_non_productive_revenue / parseFloat(total_labor.replace(/[,$]/g,'')).toFixed(2)) * 100).toFixed(2);

    (non_pro_mix_rate > 0) ? $('.management-overhead-body .non_productive_mix_rate .mgmt_avg_mgmt_labor_rate_per_hour').val('$'+non_pro_mix_rate.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"))
        :  $('.management-overhead-body .non_productive_mix_rate .mgmt_avg_mgmt_labor_rate_per_hour').val('$0.00');

    (total_non_productive_revenue > 0) ?   $('.management-overhead-body .total_non_productive_revenue').text('$'+total_non_productive_revenue.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")) :   $('.management-overhead-body .total_non_productive_revenue').text('');
    (total_non_productive_overhead > 0) ?   $('.management-overhead-body .non_productive_overhead').text(total_non_productive_overhead+'%') :   $('.management-overhead-body .non_productive_overhead').text('0.00%');
    $('.management-overhead-body .total_non_productive_revenue').text('$'+total_non_productive_revenue.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));

    (non_pro_per_hour_cost > 0) ? $('.management-overhead-body .mgmt_cost_of_mgmt_labor_with_burden_fringe').val('$'+non_pro_per_hour_cost.toFixed(2))
        :     $('.management-overhead-body .mgmt_cost_of_mgmt_labor_with_burden_fringe').val('$0.00');

    /* Set Operating Overheads Data in Cost Setup Fields */
    var total_operating_expense = parseFloat($('#total_operating_expense').text().replace(/[,$]/g, '')).toFixed(2);
    var total_operating_overhead = ((total_operating_expense / total_labor.replace(/[,$]/g,'')) * 100);
    (total_operating_overhead > 0) ? $('.operating_overhead_table #total_operation_overhead').val(total_operating_overhead.toFixed(2)+'%') : $('.operating_overhead_table #total_operation_overhead').val('0.00%');


    /* Set Overhead Totals Data in Cost Setup */
    $('.overhead_totals .mix_rate').val('$'+avg_mix_rate.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    show_overhead_totals();
}
function edit_labor_overhead(){
    $(".button-inner-step1").hide();
    $(".button-outer-step1").append('<div class="button-inner cost-setup-update"><button type="submit" class="btn btn-primary btn-xs update-form-button overhead-update">Update</button></div>');
    $(".button-outer-step1").append('<div class="button-inner cost-setup-next"><button type="button" onclick="change_class_step1()" class="btn btn-warning btn-xs update-button">Next</button></div>');
    $("#labor-overhead input.editable").removeAttr("readonly");
    $("#labor-overhead input").addClass('form-control-input');
}

function change_class_step1(){
    $("#step1").removeClass('active');
    $("#step2").addClass('active');
    $("#list-step1").removeClass('active');
    $("#list-step2").addClass('active');
}

function edit_management_overhead(){
    $(".button-inner-step2").hide();
    $(".button-outer-step2").append('<div class="button-inner cost-setup-update"><button type="submit" class="btn btn-primary btn-xs update-form-button overhead-update">Update</button></div>');
    $(".button-outer-step2").append('<div class="button-inner cost-setup-next"><button type="button" onclick="change_class_step2()" class="btn btn-warning btn-xs update-button">Next</button></div>');

    $("#management-overhead input.editable").removeAttr("readonly");
    $("#management-overhead input").addClass('form-control-input');
}

function change_class_step2(){
    $("#step2").removeClass('active');
    $("#step3").addClass('active');
    $("#list-step2").removeClass('active');
    $("#list-step3").addClass('active');
}

function change_class_step3(){
    $("#step3").removeClass('active');
    $("#step4").addClass('active');
    $("#list-step3").removeClass('active');
    $("#list-step4").addClass('active');
}

function edit_overhead(){
    $(".button-inner-step3").hide();
    $(".button-outer-step3").append('<div class="button-inner"><button type="submit" class="btn btn-primary btn-xs update-form-button overhead-update">Update</button></div>');
    $("#overhead input.editable.decimalValue").removeAttr("readonly");
    $("#overhead input.editable").addClass('form-control-input');
}



$(function () {

    var hash = $(location).attr('hash');


    if (hash.length > 0) {

        $('a[href="' + hash + '"]').closest('ul').find('li.active').removeClass('active');
        $('a[href="' + hash + '"]').closest('li').addClass('active');

        $(hash).addClass('active').siblings().removeClass('active');

    }
})

function create_next_button(){
    $("#step1").removeClass('active');
    $("#step2").addClass('active');
    $("#list-step1").removeClass('active');
    $("#list-step2").addClass('active');
}


/*========================= EMPLOYEES MIX ===========================*/

function show_employee_modal() {
    $('#add_employee_mix_form .modal-title').text('Add Employee');
    $('#add_employee_mix_form .add_employee_mix').text('Add Employee');

    $(".employee_select").attr('disabled', false);
    $('#add_employee_mix_form').find("input[type=text], select").val('');
// Remove if mix_id already exists.
    $('#mix_id').remove();
    $.ajax({
        url : base_url+'cost_setup/get_employee_mix',
        type : 'get',
        success: function (response) {
            /* Edit Employee Mix Record */
            $('.employee_select').html(response);
        }
    });

    $("#add_employee_mix_modal").modal('show');
}

$(document).on('click', '.add_employee_mix' ,function(event) {
    window.onbeforeunload = null;
    event.preventDefault();
    event.stopImmediatePropagation();
    var valid = true;

    $('#add_employee_mix_form .required').each(function() {
        $( ".error" ).remove();
    });

    $('#add_employee_mix_form .required').each(function() {
        if($(this).val() < 1) {
            $(this).after("<div class='error'>Required!</div>");
            valid = false;
        }
    });

    if(valid) {
        var user_id = $('.employee_select').val();
        var raw_wage = $('.raw_wages').val();
        var annual_hours = $('.annual_hours').val();

        var ot_hours = $('.ot_hours').val();
        var double_pay = $('.double_pay').val();
        var employee_mix_id = 0;
        if ($('#mix_id').val()){
            employee_mix_id = $('#mix_id').val();
        }

        $.ajax({
            data : {id: user_id, wages: raw_wage, hours: annual_hours, mix_id: employee_mix_id, ot_hours: ot_hours, double_pay: double_pay},
            url : base_url+'cost_setup/add_employee_mix',
            type : 'post',
            dataType: 'json',
            beforeSend:function(){
                $('.add_employee_mix').attr('disabled',true).text('Sending....');
            },
            success: function (response) {


                $('#add_employee_mix_form')[0].reset();
                $('.add_employee_mix').attr('disabled',false);
                $('#add_employee_mix_form .required').each(function() {
                    $( ".error" ).remove();
                });
                /* Edit Employee Mix Record */
                if (employee_mix_id){
                    $('#row'+employee_mix_id).find('.employee_name strong').text(response['employee'].first_name + ' ' + response['employee'].last_name);
                    $('#row'+employee_mix_id).find('.employee_raw_wages strong').text('$'+ (parseFloat(response['employee'].raw_wages).toFixed(2)).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                    $('#row'+employee_mix_id).find('.employee_annual_hours strong').text((parseFloat(response['employee'].annual_hours).toFixed(2)).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                    $('#row'+employee_mix_id).find('.employee_ot_hours strong').text((parseFloat(response['employee'].ot_hours).toFixed(2)).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                    $('#row'+employee_mix_id).find('.employee_double_pay strong').text((parseFloat(response['employee'].double_pay).toFixed(2)).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                    $('#row'+employee_mix_id).find('.employee_average_pay_rate strong').text('$'+ (parseFloat(response['employee'].average_pay_rate).toFixed(2)).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                } else {
                    /* Add New Employee Mix Record */
                    if ($('.no_employees').length) {
                        $(".employees_mix_table .no_employees").remove();
                    }
                    $(".employees_mix_table table tbody").append('<tr id="row'+response['mix_id']+'"><td class="col-md-3 employee_name"><strong>' + response['employee'].first_name + ' ' + response['employee'].last_name + '</strong></td><td class="col-md-3 employee_raw_wages"><strong>$' + parseFloat(response['employee'].raw_wages).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</strong></td><td class="col-md-3 employee_annual_hours"><strong>' + parseFloat(response['employee'].annual_hours).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</strong></td><td class="col-md-3 employee_ot_hours"><strong>' + parseFloat(response['employee'].ot_hours).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</strong></td><td class="col-md-3 employee_double_pay"><strong>' + parseFloat(response['employee'].double_pay).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</strong></td><td class="col-md-3 employee_average_pay_rate"><strong>$' + parseFloat(response['employee'].average_pay_rate).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</strong></td><td class="employee_mix_actions"><a class="btn btn-primary edit_employee_mix" id="' + response['mix_id'] + '"><span class="glyphicon glyphicon-edit"></span></a> <a class="btn btn-danger delete_employee_mix" id="' + response['mix_id'] + '"><span class="glyphicon glyphicon-trash"></span></a></td></tr>');
                }
                calculate_summary();
                $("#add_employee_mix_modal").modal('hide');
                calculate_cost_setup();
            }
        });
    }
});

$(document).on('click', '.edit_employee_mix', function() {
    var id = $(this).attr('id');

    // Remove if mix_id already exists.
    $('#mix_id').remove();

    $('<input>').attr({type: 'hidden', id: 'mix_id', name: 'id', value: id}).appendTo('#add_employee_mix_form');
    $('#add_employee_mix_form .modal-title').text('Edit Employee');
    $('#add_employee_mix_form .add_employee_mix').text('Update Employee');

    $.ajax({
        data : {id: id},
        url : base_url+'cost_setup/edit_employee_mix',
        type : 'post',
        dataType: 'json',
        success: function (response) {
            $('#add_employee_mix_form')[0].reset();

            $(".employee_select").attr('disabled', 'disabled');
            $(".employee_select").empty();
            $(".employee_select").append('<option value="">Select an Employee</option>');
            for (var i=0;i<response['employees'].length;i++ ){
                $(".employee_select").append('<option value="' + response['employees'][i].user_id+ '">'+response['employees'][i].first_name +' '+ response['employees'][i].last_name +'</option>');
            }
            $("select option[value='"+ response['record'].user_id+"']").attr("selected","selected");
            $('.raw_wages').val(response['record'].raw_wages);
            $('.annual_hours').val(response['record'].annual_hours);
            $('.ot_hours').val(response['record'].ot_hours);
            $('.double_pay').val(response['record'].double_pay);
            $('.average_pay_rate').val(response['record'].average_pay_rate);
            $("#add_employee_mix_modal").modal('show');
            calculate_cost_setup();
        }
    });
});

$(document).on('click', '.delete_employee_mix', function() {
    var id = $(this).attr('id');
    var employee_raw_wages = parseFloat($(this).closest('.employee_raw_wages').text().replace(/[,$]/g, ''));
    var employee_annual_hours = parseFloat($(this).closest('.employee_annual_hours').text());
    swal({
        title: "Are you sure?",
        text: "You Want to Delete this!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then(function(willDelete){
        if (willDelete) {
            $.ajax({
                data : {id: id},
                url : base_url+'cost_setup/delete_employee_mix',
                type : 'post',
                dataType: 'json',
                success: function (response) {
                    // $("tr#row" + id).hide();
                    $('.employee_mix_rate #row'+id).remove();
                    calculate_summary();
                    if (!$('.employees_mix_table table tbody tr').length){
                        $(".employees_mix_table table tbody").append('<tr class="no_employees"><td colspan="4">No Employees Exists</td></tr>');
                    }
                    calculate_cost_setup();

                }
            });
        }
    });
});

function calculate_summary() {
    var mix_rate = 0, total_mix_rate = 0, avg_mix_rate = 0, avg_pay_rate = 0;
    var annual_hours = 0, total_annual_hours = 0;
    var total_labor_revenue = 0;
    var count = $('.employees_mix_table table tbody tr').length;
    $('.employees_mix_table table tbody tr').each(function() {
        mix_rate = parseFloat($(this).find('td.employee_average_pay_rate strong').text().replace(/[,$]/g,''));
        avg_pay_rate = parseFloat($(this).find('td.employee_average_pay_rate strong').text().replace(/[,$]/g,''));
        total_mix_rate += mix_rate;
        annual_hours = parseFloat($(this).find('td.employee_annual_hours strong').text().replace(/[,$]/g,'')) + parseFloat($(this).find('td.employee_ot_hours strong').text().replace(/[,$]/g,'')) + parseFloat($(this).find('td.employee_double_pay strong').text().replace(/[,$]/g,''));
        total_annual_hours += annual_hours;
        total_labor_revenue += (avg_pay_rate * annual_hours);
    });

    if (count){
        avg_mix_rate = (total_mix_rate / count);
    }

    total_labor_revenue = (parseFloat(avg_mix_rate).toFixed(2) * total_annual_hours);
    $('.employees_mix_table table tfoot #employee_avg_mix_rate').text('$'+avg_mix_rate.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    $('.cost-setup-labor-overhead .employees_mix_rate .labor_rate_per_hour').val('$'+avg_mix_rate.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    $('.employees_mix_table table tfoot #annual_hours').text(total_annual_hours.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    $('.cost-setup-labor-overhead .employees_annual_hours .operations_overhead').val(total_annual_hours.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    $('.employees_mix_table table tfoot #total_labor').text('$'+total_labor_revenue.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    $('.cost-setup-labor-overhead .total_labor_revenue .management_overhead').val('$'+total_labor_revenue.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));

    /* Overhead Totals section */
    $('.overhead_totals .mix_rate').val('$'+avg_mix_rate.toFixed(2));

    show_overhead_totals();
}

/*========================= NON PRODUCTIVE EMPLOYEES ===========================*/

function show_non_productive_employee_modal() {
    $('#non_productive_employees_form .modal-title').text('Add Employee');
    $('#non_productive_employees_form .add_non_productive_employee').text('Add Employee');
    $(".non_productive_employee_select").attr('disabled', false);
    $('#non_productive_employees_form').find("input[type=text], select").val('');
// Remove if mix_id already exists.
    $('#non_productive_id').remove();
    $.ajax({
        url : base_url+'cost_setup/get_non_productive_employee',
        type : 'get',
        success: function (response) {
            /* Edit Employee non productive Record */
            $('.non_productive_employee_select').html(response);
        }
    });
    $("#non_productive_employees_modal").modal('show');
}

$(document).on('click', '.add_non_productive_employee' ,function() {
    var valid = true;
    window.onbeforeunload = null;
    event.preventDefault();
    event.stopImmediatePropagation();

    $('#non_productive_employees_form .required').each(function() {
        $( ".error" ).remove();
    });

    $('#non_productive_employees_form .required').each(function() {
        if($(this).val() < 1) {
            $(this).after("<div class='error'>Required!</div>");
            valid = false;
        }
    });

    if(valid) {
        var user_id = $('.non_productive_employee_select').val();
        var annual_salary = $('.annual_salary').val();
        var total_hours = $('.total_hours').val();
        var employee_id = 0;
        if ($('#non_productive_id').val()){
            employee_id = $('#non_productive_id').val();
        }

        $.ajax({
            data : {user_id: user_id, salary: annual_salary, hours: total_hours, id: employee_id},
            url : base_url+'cost_setup/add_non_productive_employees',
            type : 'post',
            dataType: 'json',
            beforeSend:function(){
                $('.add_non_productive_employee').attr('disabled',true).text('Sending....');
            },
            success: function (response) {
                $('#non_productive_employees_form .required').each(function() {
                    $( ".error" ).remove();
                });
                $('#non_productive_employees_form')[0].reset();
                $('.add_non_productive_employee').attr('disabled',false);

                /* Edit Employee non productive Record */
                if (employee_id){
                    $('.non-productive-employee-body #row'+employee_id).find('.employee_name strong').text(response['employee'].name);
                    $('.non-productive-employee-body #row'+employee_id).find('.employee_annual_salary strong').text('$'+response['employee'].annual_salary.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                    $('.non-productive-employee-body #row'+employee_id).find('.employee_total_hours strong').text(response['employee'].total_hours.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                } else {
                    /* Add New Employee non productive Mix Record */
                    if ($('.no_employees').length) {
                        $(".non_pro_employees_table .no_employees").remove();
                    }
                    $(".non_pro_employees_table table tbody").append('<tr id="row'+response['employee'].id+'"><td class="col-md-3 employee_name"><strong>' +   response['employee'].name   +'</strong></td><td class="col-md-3 employee_annual_salary"><strong> $' + parseFloat( response['employee'].annual_salary).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</strong></td><td class="col-md-3 employee_total_hours"><strong>' + parseFloat( response['employee'].total_hours ).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</strong></td><td><a class="btn btn-primary edit_non_pro_employee" id="' + response['employee'].id + '"><span class="glyphicon glyphicon-edit"></span></a> <a class="btn btn-danger delete_non_pro_employee" id="' + response['employee'].id + '"><span class="glyphicon glyphicon-trash"></span></a></td></tr>');
                }

                calculate_non_prod_summary();
                $("#non_productive_employees_modal").modal('hide');
            }
        });
    }
});

$(document).on('click', '.edit_non_pro_employee', function() {
    var id = $(this).attr('id');

    // Remove if mix_id already exists.
    $('#non_productive_id').remove();

    $('<input>').attr({type: 'hidden', id: 'non_productive_id', name: 'non_productive_id', value: id}).appendTo('#non_productive_employees_form');
    $('#non_productive_employees_form .modal-title').text('Edit Employee');
    $('#non_productive_employees_form .add_non_productive_employee').text('Update Employee');

    $.ajax({
        data : {id: id},
        url : base_url+'cost_setup/edit_non_productive_employees',
        type : 'post',
        dataType: 'json',
        success: function (response) {
            $('#non_productive_employees_form')[0].reset();
            $(".non_productive_employee_select").attr('disabled', 'disabled');
            $(".non_productive_employee_select").empty();
            $(".non_productive_employee_select").append('<option value="">Select an Employee</option>');
            for (var i=0;i<response['employees'].length;i++ ){
                $(".non_productive_employee_select").append('<option value="' + response['employees'][i].user_id+ '">'+response['employees'][i].first_name +' '+ response['employees'][i].last_name +'</option>');
            }
            $("select option[value='"+ response['record'].user_id+"']").attr("selected","selected");
            $('.non_productive_employee_name').val(response['record'].name);
            $('.annual_salary').val(response['record'].annual_salary);
            $('.total_hours').val(response['record'].total_hours);
            $("#non_productive_employees_modal").modal('show');
        }
    });
});

$(document).on('click', '.delete_non_pro_employee', function() {
    var id = $(this).attr('id');

    swal({
        title: "Are you sure?",
        text: "You Want to Delete this Method!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then(function(willDelete){
        if (willDelete) {
            $.ajax({
                data : {id: id},
                url : base_url+'cost_setup/delete_non_productive_employees',
                type : 'post',
                dataType: 'json',
                success: function (response) {
                    $('.non_pro_employees_table #row'+id).remove();
                    calculate_non_prod_summary();
                    if (!$('.non_pro_employees_table table tbody tr').length){
                        $(".non_pro_employees_table table tbody").append('<tr class="no_employees"><td colspan="4">No Employees Exists</td></tr>');
                    }
                }
            });
        }
    });
});

function calculate_non_prod_summary() {
    var total_annual_salary = 0;
    var total_hours_sum = 0 , non_productive_mix_rate = 0, non_pro_per_hour_cost =0;
    $('.non_pro_employees_table table tbody tr').each(function() {
        total_annual_salary += parseFloat($(this).find('td.employee_annual_salary strong').text().replace(/[,$]/g,''));
        total_hours_sum += parseFloat($(this).find('td.employee_total_hours strong').text().replace(/[,$]/g,''));
    });

    var total_burden_fringe = parseFloat($('.cost-setup-management-overhead .total_burden strong').text().replace(/[,$%]/g, ''), 10).toFixed(2);

    /* Calculate Non Production Mix Rate */
    non_productive_mix_rate = (total_annual_salary / total_hours_sum).toFixed(2);

    /* Calculate Non Productive actual cost per hour*/
    non_pro_per_hour_cost = parseFloat(non_productive_mix_rate, 10) + parseFloat((non_productive_mix_rate * total_burden_fringe) / 100, 10);

    var total_burden = parseFloat($('.total_fringe_benefits strong').text());
    var total_labor_revenue = $('.cost-setup-labor-overhead .total_labor_revenue .management_overhead').val();
    var total_non_productive_revenue = total_annual_salary + ((total_annual_salary * total_burden_fringe) / 100);
    var total_non_productive_overhead = ((total_non_productive_revenue / parseFloat(total_labor_revenue.replace(/[,$]/g,'')).toFixed(2)) * 100).toFixed(2);

    $('.non_pro_employees_table table tfoot #total_annual_salary').text('$'+total_annual_salary.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    $('.non_pro_employees_table table tfoot #total_annual_salary').val('$'+total_annual_salary.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    $('.non_pro_employees_table table tfoot #total_hours').text(total_hours_sum.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    $('.management-overhead-body .non_productive_mix_rate .mgmt_avg_mgmt_labor_rate_per_hour').val('$'+non_productive_mix_rate.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    $('.management-overhead-body .mgmt_cost_of_mgmt_labor_with_burden_fringe').val('$'+non_pro_per_hour_cost.toFixed(2));
    $('.management-overhead-body .total_non_productive_revenue').text('$'+total_non_productive_revenue.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    $('.management-overhead-body .non_productive_overhead').text(total_non_productive_overhead+'%');

    /* Set Overhead Totals */
    $('.overhead_totals .non_productive_overhead').val(total_non_productive_overhead+'%');

    show_overhead_totals();
}


/*========================== OPERATING OVERHEADS ===============================*/

function show_operating_overhead_modal() {
    $('#operating_overhead_form .modal-title').text('Add Overhead');
    $('#operating_overhead_form .add_operating_overhead').text('Add Overhead');

    $('#operating_overhead_form').find("input[type=text]").val("");
    $("#operating_overhead_modal").modal('show');
}

$(document).on('click', '.add_operating_overhead' ,function() {
    var valid = true;
    window.onbeforeunload = null;
    event.preventDefault();
    event.stopImmediatePropagation();
    $('#operating_overhead_form .required').each(function() {
        $( ".error" ).remove();
    });

    $('#operating_overhead_form .required').each(function() {
        if($(this).val() < 1) {
            $(this).after("<div class='error'>Required!</div>");
            valid = false;
        }
    });

    if(valid) {
        var overhead_name = $('.operating_overhead_name').val();
        var overhead_amount = $('.operating_overhead_amount').val();
        var overhead_id = 0;
        if ($('#overhead_id').val()){
            overhead_id = $('#overhead_id').val();
        }

        $.ajax({
            data : {name: overhead_name, amount: overhead_amount, id: overhead_id},
            url : base_url+'cost_setup/add_operating_overhead',
            type : 'post',
            dataType: 'json',
            beforeSend:function(){
                $('.add_operating_overhead').attr('disabled',true).text('Sending....');
            },
            success: function (response) {
                $('#operating_overhead_form')[0].reset();
                $('.add_operating_overhead').attr('disabled',false);
                $('#operating_overhead_form .required').each(function() {
                    $( ".error" ).remove();
                });
                /* Edit Operating Overhead Record */
                if (overhead_id){
                    $('.operating_overhead_body #row'+overhead_id).find('.overhead strong').text(overhead_name);
                    $('.operating_overhead_body #row'+overhead_id).find('.overhead_amount strong').text(overhead_amount);
                } else {
                    /* Add New Operating Overhead Record */
                    if ($('.no_employees').length) {
                        $(".operating_overhead_table .no_employees").remove();
                    }
                    $(".operating_overhead_table table tbody").append('<tr id="row'+response+'"><td class="col-md-3 overhead_name"><strong>' + overhead_name +'</strong></td><td class="col-md-3 overhead_amount"><strong> $' + parseFloat(overhead_amount).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</strong></td><td><a class="btn btn-primary edit_operating_overhead" id="' + response + '"><span class="glyphicon glyphicon-edit"></span></a> <a class="btn btn-danger delete_operating_overhead" id="' + response + '"><span class="glyphicon glyphicon-trash"></span></a></td></tr>');
                }

                calculate_operating_overhead_summary();
                $("#operating_overhead_modal").modal('hide');
            }
        });
    }
});

$(document).on('click', '.edit_operating_overhead', function() {
    var id = $(this).attr('id');

    // Remove if mix_id already exists.
    $('#overhead_id').remove();

    $('<input>').attr({type: 'hidden', id: 'overhead_id', name: 'overhead_id', value: id}).appendTo('#operating_overhead_form');
    $('#operating_overhead_form .modal-title').text('Edit Overhead');
    $('#operating_overhead_form .add_operating_overhead').text('Update Overhead');

    $.ajax({
        data : {id: id},
        url : base_url+'cost_setup/edit_operating_overhead',
        type : 'post',
        dataType: 'json',
        success: function (response) {
            $('#operating_overhead_form')[0].reset();
            $('.operating_overhead_name').val(response['overhead'].name);
            $('.operating_overhead_amount').val(response['overhead'].amount);
            $("#operating_overhead_modal").modal('show');
        }
    });
});

$(document).on('click', '.delete_operating_overhead', function() {
    var id = $(this).attr('id');

    swal({
        title: "Are you sure?",
        text: "You Want to Delete this!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then(function(willDelete){
        if (willDelete) {
            $.ajax({
                data : {id: id},
                url : base_url+'cost_setup/delete_operating_overhead',
                type : 'post',
                dataType: 'json',
                success: function (response) {
                    $('.operating_overhead_table #row'+id).remove();
                    calculate_operating_overhead_summary();
                    if (!$('.operating_overhead_table table tbody tr').length){
                        $(".operating_overhead_table table tbody").append('<tr class="no_employees"><td colspan="3">No Operating Overhead Exists</td></tr>');
                    }
                }
            });
        }
    });
});

function calculate_operating_overhead_summary() {
    var total_operating_overhead = 0 , total_labor_overhead = 0 , total_operations_overhead = 0;
    $('.operating_overhead_table table tbody tr').each(function() {
        total_operating_overhead += parseFloat($(this).find('td.overhead_amount strong').text().replace(/[,$]/g,''));
    });

    total_labor_overhead = parseFloat($('.employees_mix_table #total_labor').text().replace(/[,$]/g,''));
    total_operations_overhead = ((total_operating_overhead / total_labor_overhead) * 100).toFixed(2);
    $('.operating_overhead_table #total_operating_expense').text('$'+total_operating_overhead.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    $('.operating_overhead_table #total_operation_overhead').val(total_operations_overhead+'%');
    show_overhead_totals();
}


/*=========================== OVERHEADS TOTALS SECTION ================================*/
function show_overhead_totals() {

    var labor_mix_rate = parseFloat($('.mix_rate').val().replace(/[,$%]/g, '')).toFixed(2);
    var profit_markup  = parseFloat($('.profit_mark_up').val().replace(/[,$%]/g, '')).toFixed(2);
    var labor_and_fringe_burden = parseFloat($('.labor_and_fringe_burden span').text().replace(/[,$%]/g, '')).toFixed(2);
    var total_non_productive_overhead = $('.management-overhead-body .non_productive_overhead').text().replace(/[,$%]/g, '');
    var total_operations_overhead = $('.operating_overhead_table #total_operation_overhead').val().replace(/[,$%]/g, '');
    var total_overheads = parseFloat(labor_and_fringe_burden) + parseFloat(total_operations_overhead) + parseFloat(total_non_productive_overhead);
    var breakeven_rate = parseFloat(labor_mix_rate) + ((labor_mix_rate * total_overheads) / 100);
    var hourly_selling_rate = parseFloat(breakeven_rate) + ((breakeven_rate * profit_markup) / 100);
    var net_profit_margin = (((hourly_selling_rate - breakeven_rate) / hourly_selling_rate) * 100);

    /* Set Overhead Totals */
    $('.labor-mix-rate span').text('$'+labor_mix_rate);

    $('.overhead_totals .operations_overhead').val(total_operations_overhead+'%');
    $('.overhead_totals .non_productive_overhead').val(total_non_productive_overhead+'%');
    $('.overhead_totals .overhead_total').val(total_overheads.toFixed(2)+'%');
    $('.breakeven-rate span').text('$'+breakeven_rate.toFixed(2));
    $('.hourly-selling-rate span').text('$'+hourly_selling_rate.toFixed(2));
    $('.net-profit-margin span').text(net_profit_margin.toFixed(2)+'%');

	//   Sum of Total Labor Burden
	$(document).on("change", ".total-labor-burden-values", function() {
		var sum = 0;
		$(".total-labor-burden-values").each(function () {
			sum += +$(this).val().replace('%', '');
		});
		$(".total-labor-burden-values-total").text(sum);
	});

	//    Sum of Total Labor Burden and Fringe
	$(document).on("change", ".total-labor-burden-fringe-values", function() {
		var sum = 0;
		$(".total-labor-burden-fringe-values").each(function () {
			sum += +$(this).val().replace('%', '');
		});
		$(".total-labor-burden-fringe-values-total").text(sum);
	});

}


