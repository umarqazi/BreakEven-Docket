$(function () {
    $('#datetimepicker4').datetimepicker();
});
$(document).ready(function(){
    $('#all_estimates_table').DataTable({
        "pagingType": "full_numbers",
        bAutoWidth: false,
        "autoWidth": false,
        "searching" : true,
        "sort" : false,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "language" : {
            search : '',
            searchPlaceholder: "Search Dockets",
            "zeroRecords": "No Record Found!",
            "emptyTable": "No Record Found!"
        }
    });
});
function openTimekeepingModal(docket_id){
    $('.time_in').hide();
    $('.time_out').hide();
    $.ajax({
        url: base_url+'/get_docket_details',
        type:"POST",
        data:{ docket_id : docket_id },
        dataType : 'json',
        success:function(response)
        {
            if (response == false)
            {
                //errorrr
            }
            else
            {
                $('#timekeeping_id').val('');
                $('#timekeeping_id_').val('');
                $('#form_docket_no').val('');
                $('#form_docket_id').val('');
                $('#form_docket_id_').val('');
                if(typeof(response.checkTimeInOrOut[0]) != "undefined" && response.checkTimeInOrOut[0] !== null) {
                    if (response.checkTimeInOrOut[0].time_in == '') {
                        $('.time_in').show();
                    } else if(response.checkTimeInOrOut[0].time_out == '') {
                        $('#timekeeping_id').val(response.checkTimeInOrOut[0].id);
                        $('#timekeeping_id_').val(response.checkTimeInOrOut[0].id);
                        $('.time_out').show();
                    } else {
                        $('.time_in').show();
                    }
                } else {
                    $('.time_in').show();
                }

                //aassigning values here to the form
                $('#form_docket_no').val(response.dockets.docket_no);
                $('#form_docket_id').val(response.dockets.id);
                $('#form_docket_id_').val(response.dockets.id);
                $('#time_table').find('tbody').remove();
                $('.clock').empty();
                html = '';
                html += '<tbody>';
                if (response.timekeeping != false) {
                    $(response.timekeeping).each(function(index, value) {
                    var showTimeOut = '';
                    if(value.total_time != "") {
                        showTimeOut = value.total_time
                    } else {
                        showTimeOut = '';
                        var date1 = new Date(value.time_in);
                        var date2 = new Date();
                        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                        var diffSeconds = Math.ceil(timeDiff / 1000);
                        console.log(diffSeconds);
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
                    html += '<tr>';
                    html += '<td>'+value.time_in+'</td>';
                    html += '<td>'+value.time_out+'</td>';
                    html += '<td>'+showTimeOut+'</td>';
                    html += '</tr>';
                })
                html += '</tbody>';
                $('#time_table').prepend(html);
                } else {
                    $('#time_table').append('<tbody><tr><td colspan="3"><center>No data Found!</center></td></tr></tbody>');
                }
            }
        },
        error:function(response)
        {
            console.log(response);
        }
    })
    $("#timekeeping").modal('show');

}
function timeChanges(time){
    var docket_id = $('#form_docket_id').val();
    var time_in;
    var time_out;
    var msg;
    var timekeeping_id;
    if (time == 'time_in') {
        time_in = true;
        time_out = false;
        msg = 'Time In';
        timekeeping_id = null;       
    } else {
        time_out = true;
        time_in = false;
        msg = 'Time Out';   
        timekeeping_id = $('#timekeeping_id').val();  
    }
    $.ajax({
        url: base_url+'/time_in',
        type:"POST",
        data:{ docket_id : docket_id ,time_in:time_in,time_out:time_out,timekeeping_id:timekeeping_id},
        dataType : 'json',
        success:function(response)
        {
            if (response == false)
            {
                //error
            }
            else
            {
                $("#timekeeping").modal('hide');
                swal({
                    title: "Great!",
                    text: msg+' Successfully!',
                    icon: "success"
                });
            }

        },
        error:function(response)
        {
            console.log('errror');
        }
    })
}

