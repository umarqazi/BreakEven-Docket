function get_address(){
    if ($("input[name=same_address]").is(":checked")){
        var customer_id = $('#customer_id').val();
        $.ajax({
            data : {id: customer_id},
            url : getCustomerAddressUrl,
            type : 'post',
            dataType : 'json',
            success : function(data){
                $("input[name=street_address]").attr('value', data.billing_address);
                $("input[name=zip]").attr('value', data.billing_city + ' ' + data.billing_state + ' ' + data.billing_zip);
            }
        })
    }else{
        $("input[name=street_address]").removeAttr('value');
        $("input[name=zip]").removeAttr('value');
    }
}

function show_checkbox(){
    $("input[name=street_address]").attr('value','');
    $("input[name=zip]").attr('value','');
    $('#same_address').prop('checked',false);
    if($("#customer_id").val().length > 0){
        $(".customer_address_checkbox").css('display','inline-block');
    }else{
        $(".customer_address_checkbox").css('display','none');
    }
}

function add_change_order(id) {
    $.ajax({
        data : {id : id},
        url : base_url+'estimating/add_change_order',
        type : 'post',
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                $('.change_order').append(response['html']);
                $('.change_order_dropdown').append('<option value="'+ response['id']+ '">Change Order #'+ response['count'] +'</option>');
                $('.job_exclusions').ckeditor();
            }
            else{
                alert('Change Order Error!');
            }
        }
    });
}

function delete_change_order(id) {

    swal({
        title: "Are you sure?",
        text: "You Want to Delete this Change Order!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then(function(willDelete){
        if (willDelete) {
            $.ajax({
                data: {id:id},
                url: base_url+'estimating/delete_change_order',
                type: 'post',
                success: function (response) {
                    if (response) {
                        $(".change_order_request_"+id).remove();
                    }
                }
            });
        }
    });
}

function show_area_modal(obj) {
    element = $(obj);
    var id_name = element.closest('.change_order_wrapper').attr('id');
    if (id_name){
        var changeID = id_name.split('_');
        $('input[name="change_order_id"]').val(changeID[2]);
    }

    $('#add_new_area').modal('show');
}

function show_miscallneous_modal(obj) {
    element = $(obj);
    var id_name = element.closest('.change_order_wrapper').attr('id');
    if (id_name){
        var changeID = id_name.split('_');
        $('input[name="change_order_id"]').val(changeID[2]);
    }

    $('#add_new_miscallneous').modal('show');
}

function show_subcontractor_modal(obj) {
    element = $(obj);
    var id_name = element.closest('.change_order_wrapper').attr('id');
    if (id_name){
        var changeID = id_name.split('_');
        $('input[name="change_order_id"]').val(changeID[2]);
    }

    $('#add_new_subcontractor').modal('show');
}

function show_time_material_modal(obj) {
    element = $(obj);
    var id_name = element.closest('.change_order_wrapper').attr('id');
    if (id_name){
        var changeID = id_name.split('_');
        $('input[name="change_order_id"]').val(changeID[2]);
    }

    $('#add_new_time_material').modal('show');
}

function view_common_invoices() {

    $.ajax({
        data : {id : estimate_id},
        url : base_url+'estimating/get_invoices',
        type : 'post',
        dataType: 'json',
        success: function (response) {
            if ($.fn.DataTable.isDataTable("#estimate_invoices")) {
                $("#estimate_invoices").DataTable().clear();
                $("#estimate_invoices").DataTable().destroy();
            }

            if (response) {
                $('.invoice-modal-body tbody').html(response['html']);
            }

            $('#estimate_invoices').DataTable({
                "pagingType": "full_numbers",
                "autoWidth": false,
                "searching" : true,
                "sort" : false,
                "bDestroy": true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "language" : {
                    search : '',
                    searchPlaceholder: "Search Files",
                    "zeroRecords": "No File is available",
                    "emptyTable": "No File is available"
                }
            });

            $('table').wrap('<div class="table-responsive" style="clear: both;"></div>');
        }
    });

    $('#estimate_common_invoices_modal').modal('show');
}

function change_order(obj) {
    element = $(obj);
    var value = element.val();

    swal({
        title: "Are you sure?",
        text: "You Want to Generate Change Order!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then(function(willGenerate){
        if (willGenerate) {
            window.location.replace(base_url+'invoices/change_order?est='+estimate_id+'&co='+value);
        }
    });
}

function change_status(obj, id) {
    element = $(obj);
    var value  = $(element).val();
    console.log(id);
    console.log(value);

    $.ajax({
        data : {id: id, value: value},
        url : base_url+'estimating/update_status',
        type : 'post',
        dataType: 'json',
        success: function (response) {
            if (response) {
                swal({
                    title: "Great!",
                    text: 'Estimate Status has been Updated!',
                    icon: "success"
                });
            }
        }
    });
}

function update_exclusion(obj, change_id) {
    element = $(obj);

    var valid = true;
    $( ".error" ).remove();

    var $this = element.parent().siblings('.exclusion_content').find('.job_exclusions');

    if(!$this.val()) {
        element.after("<div class='error'>Required!</div>");
        valid = false;
    }

    if(valid) {
        var body = $this.val();
        $.ajax({
            data : {id: estimate_id, change_id: change_id, body: body},
            url : base_url+'estimating/add_exclusion',
            type : 'post',
            dataType: 'json',
            success: function (response) {
                if (response) {
                    var text = '';

                    if (change_id){
                        text = 'Change Order Clarifications Updated Successfully!';
                    } else {
                        text = 'Scope of Work Clarifitcations Updated Successfully!';
                    }
                    swal({
                        title: "Great!",
                        text: text,
                        icon: "success"
                    });
                }
            }
        });
    }
}

function deleteInvoice(id, obj){
    element = $(obj);
    $.ajax({
        data : {id: id},
        url : base_url+'invoices/delete',
        type : 'post',
        dataType: 'json',
        success: function (response) {
            if (response > 0){
                element.closest('tr').remove();
            }

            var rowCount = $('#estimate_invoices tbody tr').length;

            if (!rowCount){
                var row = '<td valign="top" colspan="5" class="dataTables_empty">No File is available</td>';
                $('#estimate_invoices tbody').append(row);
            }
        }
    });
}

function jobSurveyReminder(){
    var niche = $('.niche_select').val();
    var market = $('.market_select').val();
    if (niche == null || market == null){
        var text = 'You Want to Create An Estimate without ';
        if (niche == null) {
            text += 'Niche Market ';
        }

        if (niche == null && market == null) {
            text += 'and ';
        }

        if (market == null){
            text += 'Market Survey!'
        }

        swal({
            title: "Are you sure?",
            text: text,
            icon: "warning",
            buttons: ['No', 'Yes'],
            dangerMode: true,
        })
            .then(function(willGenerate){
            if (willGenerate) {
                $('#create_estimate_form').submit();
            }
        });
    } else {
        $('#create_estimate_form').submit();
    }
}

//Add Area Productions Validation
$( document ).ready( function(){

    $('.customer_select').select2();
    $('.niche_select').select2();
    $('.market_select').select2();


    $('#add_area_production_button').on('click', function() {
        var valid = true;

        $('#add_area_rows_form .required').each(function() {
            $( ".error" ).remove();
        });

        $('#add_area_rows_form .required').each(function() {
            var $this = $(this);
            if(!$this.val()) {
                if ($this.attr('name') == 'material_coverage[]') {
                    $(this).siblings('.waste').after("<div class='error'>Required!</div>");
                } else{
                    $(this).after("<div class='error'>Required!</div>");
                }
                valid = false;
            } else if ($this.val() == 0 && $this.attr('id') !== 'material_coverage'){
                if ($this.attr('name') == 'material_coverage[]') {
                    $(this).siblings('.waste').after("<div class='error'>Can't be Zero!</div>");
                } else{
                    $(this).after("<div class='error'>Can't be Zero!</div>");
                }
                valid = false;
            }
        });
        $('#add_area_production_button').attr('disabled',true).text('Sending....');
        if(valid) {
            $('#add_area_rows_form').submit();
        }
    });

    // Add New Areas
    $('#add_area_button').on('click', function() {
        var valid = true;

        $('#add_new_area_form .required').each(function() {
            $( ".error" ).remove();
        });

        $('#add_new_area_form .required').each(function() {
            var $this = $(this);
            if(!$this.val()) {
                if ($this.attr('name') == 'material_coverage[]') {
                    $(this).siblings('.waste').after("<div class='error'>Required!</div>");
                } else{
                    $(this).after("<div class='error'>Required!</div>");
                }
                valid = false;
            } else if ($this.val() == 0 && $this.attr('id') !== 'material_coverage'){
                if ($this.attr('name') == 'material_coverage[]') {
                    $(this).siblings('.waste').after("<div class='error'>Can't be Zero!</div>");
                } else{
                    $(this).after("<div class='error'>Can't be Zero!</div>");
                }
                valid = false;
            }
        });


        if(valid) {
            $('#add_area_button').attr('disabled',true).text('Sending....');
            $('#add_new_area_form').submit();
        }
    });

    // Add New Miscellaneous
    $('#add_miscellaneous_button').on('click', function() {
        var valid = true;

        $('#add_new_miscallneous_form .required').each(function() {
            $( ".error" ).remove();
        });

        $('#add_new_miscallneous_form .required').each(function() {
            var $this = $(this);
            if(!$this.val()) {
                $(this).after("<div class='error'>Required!</div>");
                valid = false;
            }
        });

        if(valid) {
            $('#add_miscellaneous_button').attr('disabled',true).text('Sending....');
            $('#add_new_miscallneous_form').submit();
        }
    });

    // Add New Subcontractor
    $('#add_subcontractor_button').on('click', function() {
        var valid = true;


        $('#add_new_subcontractor_form .required').each(function() {
            $( ".error" ).remove();
        });

        $('#add_new_subcontractor_form .required').each(function() {
            var $this = $(this);
            if(!$this.val()) {
                $(this).after("<div class='error'>Required!</div>");
                valid = false;
            }
        });
        if(valid) {
            $('#add_subcontractor_button').attr('disabled',true).text('Sending....');
            $('#add_new_subcontractor_form').submit();
        }
    });

    // Add New Time And Materials
    $('#add_time_material_button').on('click', function() {
        var valid = true;

        $('#add_new_time_form .required').each(function() {
            $( ".error" ).remove();
        });

        $('#add_new_time_form .required').each(function() {
            var $this = $(this);
            if(!$this.val()) {
                $(this).after("<div class='error'>Required!</div>");
                valid = false;
            }
        });
        if(valid) {
            $('#add_time_material_button').attr('disabled',true).text('Sending....');
            $('#add_new_time_form').submit();

        }
    });

    // Create Estimate
    $('#create_estimate_button').on('click', function() {
        var valid = true;

        $('#create_estimate_form .required').each(function() {
            $( ".error" ).remove();
        });

        $('#create_estimate_form .required').each(function() {
            var $this = $(this);
            if(!$this.val()) {
                if ($this.attr('name') == 'customer_id') {
                    $(this).siblings('.select2-container').after("<div class='error'>Required!</div>");
                } else{
                    $(this).after("<div class='error'>Required!</div>");
                }
                valid = false;
            }
        });
        if(valid) {
            $('#create_estimate_button').attr('disabled',true).text('Sending....');
            var niche = $('.niche_select').val();
            var market = $('.market_select').val();
            if (niche == null || market == null){
                var text = 'You Want to Create An Estimate without ';
                if (niche == null) {
                    text += 'Niche Market ';
                }

                if (niche == null && market == null) {
                    text += 'and ';
                }

                if (market == null){
                    text += 'Market Survey!'
                }

                swal({
                    title: "Are you sure?",
                    text: text,
                    icon: "warning",
                    buttons: ['No', 'Yes'],
                    dangerMode: true,
                })
                    .then(function(willGenerate){
                    if (willGenerate) {
                        $('#create_estimate_form').submit();
                    }
                });
            } else {
                $('#create_estimate_form').submit();
            }
        }
    });
});
