$("#add-method-form").submit(function(event){
    event.preventDefault();
    var data = {name : $("input[name=add_method_name]").val(), first : $("input[name=add_first]").val(),surface_id : $("input[name=surface_id]").val()};
    $.ajax({
        url : newMethodUrl,
        data : {data : data},
        type : 'post',
        beforeSend:function(){
            // $('#add-method-form').attr('disabled',true).text('Sending....');
        },
        success : function(id){
            $("#"+ data['surface_id']).append('<tr class="div_base_table method_inputs" id="method_id_'+ id +'"><td class="lrge_list"><input type="text" class="large_input" value="'+data['name']+'" name="update_method_name" readonly></td><td></td><td><input type="text" value="'+ parseFloat(data['first']).toFixed(2) +'" class="small_input method_input_values" name="update_first" readonly></td><td class="lrge_list_multiplier"></td><td class="lrge_list_size"></td><td class="lrge_list"><button onclick="edit_method('+id+')" class="edit_method_button_'+id+'"><span class="glyphicon glyphicon-edit surface_edit"></span></button> <button onclick="update_method('+id+')" class="update_method_button" id="update_method_'+id+'"><span class="glyphicon glyphicon-check surface_edit"></span></button><button onclick="delete_method_confirmation('+id+')"><span class="glyphicon glyphicon-remove surface_edit"></span></button></td></tr>');
            $("#add-surface-method").modal('hide');
            $('#add-method-form').trigger('reset');
        }

    });

});

function add_new_surface_method(){
    $(".save_surface").css("display","inline-block");
    $("#new-methods").append("<ul class='method-details'><li class='surface-methods first_cell'><input type='text' name='method_name[]' class='method-input form-control-input' placeholder='Method Name' required></li><li class='surface-methods empty-unit-list'>---</li><li class='surface-methods'><input type='text' name='first_col[]' class='method-input decimalValue form-control-input' onkeyup='restrictInput()' onkeypress='restrictInput()' onblur='restrictInput()' placeholder='Enter Value' required></li><li class='surface-methods empty-unit-list'>---</li><li class='surface-methods empty-unit-list'>---</li></ul>");
}

function add_method(id){
    $("#add-surface-method").modal('show');
    $("input[name=surface_id]").attr("value", id);
}

function edit_surface(id){
    $(".update_surface_name_"+id).removeAttr('readonly').css('color','#000').css('background','#fff');
    $(".multiplier_"+id).removeAttr('readonly').css('color','#000').css('background','#fff');
    $(".size_"+id).removeAttr('readonly').css('color','#000').css('background','#fff');
    $(".unit_"+id).css('display','none');
    $(".update_surface_unit_"+id).css('display','block');
    $(".edit_button_"+id).hide();
    $("#update_button_"+id).css('display','inline-block');

}

function update_surface(id){
    $(".edit_button_"+id).show();
    $("#update_button_"+id).css('display','none');
    $(".update_surface_unit_"+id).css('display','none');
    var name = $(".costom_table_head").find(".update_surface_name_"+id).val();
    var unit = $(".costom_table_head").find(".update_surface_unit_"+id).val();
    var multiplier = $(".costom_table_head").find(".multiplier_"+id).val();
    var size = $(".costom_table_head").find(".size_"+id).val();
    $.ajax({
        data : {id : id, surface_name : name, surface_unit: unit, multiplier: multiplier, size: size},
        url : updateSurfaceUrl,
        type : 'post',
        success : function(){
            $(".update_surface_name_"+id).css('color','#fff').css('background','none').attr('readonly', true).attr('value',name);
            $(".multiplier_"+id).css('color','#fff').css('background','none').attr('readonly', true).attr('value',multiplier);
            $(".size_"+id).css('color','#fff').css('background','none').attr('readonly', true).attr('value',size);
            $(".unit_"+id).css('display','block').attr('readonly', true).attr('value', 'Unit: '+unit);
        }
    });
}

function edit_method(id){
    $("#method_id_"+id + " " +"td input").css('border','solid 1px #333').removeAttr('readonly');
    $(".edit_method_button_"+id).hide();
    $("#update_method_"+id).css('display','inline-block');
}


function update_method(id){
    $(".edit_method_button_"+id).show();
    $("#update_method_"+id).css('display','none');

    var method = {'method_name': $("#method_id_"+id + " " + "input[name=update_method_name]").val(), 'first': $("#method_id_"+id + " " + "input[name=update_first]").val(), 'second': $("#method_id_"+id + " " + "input[name=update_second]").val(), 'third': $("#method_id_"+id + " " + "input[name=update_third]").val()};
    $.ajax({
        data : {method : method, id:id},
        url : updateMethodUrl,
        type : 'post',
        success : function(){
            $("#method_id_"+id + " " +"td input").css('border','none').attr('readonly',true);
        }
    })
}

function delete_method_confirmation(id){
    event.preventDefault();
    /*$('#delete_method_confirmation').modal('show');
    $("#delete_method_confirmation #btnYes").attr('onclick','delete_method('+ id +')');*/

    swal({
        title: "Are you sure?",
        text: "You Want to Delete this Method!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then(function(willDelete){
        if (willDelete) {
            delete_method(id);
        }
    });
}

function delete_method(id){
    event.preventDefault();
    $.ajax({
        data : {id : id},
        url : deleteMethodUrl,
        type : 'post',
        success : function(){
            $('#delete_method_confirmation').modal('hide');
            $("#method_id_"+id).remove();
        }
    })
}

function delete_surface_confirmation(id){
    event.preventDefault();

    swal({
        title: "Are you sure?",
        text: "You Want to Delete this Surface!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then(function(willDelete){
        if (willDelete) {
            delete_surface(id);
        }
    });
}

function delete_surface(id){
    event.preventDefault();
    $.ajax({
        data : {id : id},
        url : deleteSurfaceUrl,
        type : 'post',
        success : function(){
            $('#delete_surface_confirmation').modal('hide');
            $("#dive_surface_"+id).remove();
        }
    });
}

function edit_production_name(id){
    $(".edit_production").css('border','solid 1px #000');
    $("input[name=production_name]").removeAttr('readonly');
    $(".edit_production_button").hide();
    $(".update_production_button").css('display','inline-block');
}

function update_production_name(id){
    $(".edit_production_button").show();
    $(".update_production_button").css('display','none');
    var production_name = $("input[name=production_name]").val();
    $.ajax({
        data : {production_name : production_name, id : id},
        url : updateProductionUrl,
        type : 'post',
        success : function(){
            $("input[name=production_name]").attr('readonly', true);
            $(".edit_production").css('border','none');
        }
    });

}

function delete_production_confirmation(id){
    var url = deleteProductionUrl + id;
    event.preventDefault();

    swal({
        title: "Are you sure?",
        text: "You Want to Delete this Production!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then(function(willDelete){
        if (willDelete) {
            window.location.replace(url);
        }
    });
}

function add_Surface(){
    if($(".new_production_name").val().length === 0){
        $(".production-name-error-msg").css("display","block");
    }else{
        $(".production-name-error-msg").css("display","none");
        var production_name = $(".new_production_name").val();
        $("input[name=new_production]").attr("value",production_name);
        $("#add-surface-modal").modal('show');
    }
}

function add_new_method(){
    $(".save_surface").css("display","inline-block");
    $("#surfaces-methods").append("<ul class='method-details'><li class='surface-methods-item first_cell item-name-input'><input type='text' name='method_name[]' class='method-input form-control-input' placeholder='Method Name' required></li><li class='surface-methods-unit unit-input empty-unit-list'>---</li><li class='surface-methods'><input type='text' name='first_col[]' class='method-input decimalValue form-control-input' onkeyup='restrictInput()' onkeypress='restrictInput()' onblur='restrictInput()' placeholder='Enter 1st Value' required></li><li class='surface-methods empty-unit-list'>---</li><li class='surface-methods empty-unit-list'>---</li></ul>");
}

function restrictInput() {
    $(".decimalValue").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault()
        }
    });
}
