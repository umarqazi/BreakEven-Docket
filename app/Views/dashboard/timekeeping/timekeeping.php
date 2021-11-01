<?= $this->extend("master")?>
<?= $this->section("content")?>

<style>
    #timekeeping {
        width: 70%;
        margin-left: 15%;
    }
</style>
<div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-10" id="material-section">
        <h2 class="heading-text">
            <strong>My Dockets</strong>
            <!-- <button class="btn btn-primary pull-right job_pattern_btn" title="Create a Docket No" onclick="job_pattern()">Create a Docket No</button> -->
        </h2>
        <?= view('App\Auth\_message_block') ?>
        <div class="materials-content">
            <div class="material-items">
                <table class="table table-striped table-hover" id="all_estimates_table">
                    <thead class="dark_blue ">
                    <tr style="color:white !important">
                        <th>Docket No</th>
                        <th>Assigned by</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($dockets)) { 
                        foreach($dockets as $docket):?>
                        <tr class="item-name">
                            <td>
                                <a href="#"><?php echo $docket['docket_no'];?></a>
                            </td>

                            <td>
                                <a href="#"><?php echo $docket['assigned_by'];?></a>
                            </td>

                            <td>
                                <a href="#"><?php echo !is_null($docket['assigned_at']) ? date('d-m-Y H:i:s', strtotime($docket['assigned_at'])) : '' ?></a>
                            </td>
                            <td>
                                <a href="#"><button type="button" class="btn btn-warning btn-xs" onclick="openTimekeepingModal(<?= $docket['docket_id'];?>)">Details</button></a>
                            </td>
                        </tr>
                    <?php endforeach;
                    }?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="col-md-2">
    </div>
</div>
<div class="modal fade full-modal" id="timekeeping" tabindex="-1" role="dialog" aria-labelledby="full-modal-label"
	 aria-hidden="true">
	<div class="modal-dialog" data->
		<div class="modal-content" data-border-top="multi">
			<form id="add_new_area_form" method="post" action="<?php echo base_url() ?>estimating/add_estimate_area">
				<div class="modal-body clearfix" id="surfaces-methods">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<h3 class="h3_bold">Docket No:
							<input type="text" class="popup_input " name="form_docket_no" id="form_docket_no" disabled >
							<input type="hidden" name="form_docket_id" id="form_docket_id" disabled >
							<input type="hidden" name="timekeeping_id" id="timekeeping_id" disabled >
						</h3>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <!-- <div class="clock" style="margin:2em;"></div> -->
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="pull-right">
                            
                            <input type="button" onclick="timeChanges('time_in')" value="Time In" class="btn btn-primary time_in" >
                            <input type="button" onclick="timeChanges('time_out')" value="Time Out" class="btn btn-danger time_out" >
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table id="time_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Time IN</th>
                                    <th>Time Out</th>
                                    <th>Total Time</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
				</div>

				<div class="modal-footer">
                <!-- <span class="icon-social-addthis" title="Add New Method"></span> -->
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<?= script_tag('js/flipclock/flipclock.js') ?>
<?= script_tag('js/datatables/jquery.dataTables.min.js') ?>
<script type="text/javascript">
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
                "zeroRecords": "No Docket is available",
                "emptyTable": "No Docket is available"
            }
        });

        /*$('table').wrap('<div class="table-responsive"></div>');*/
        // $('.btn_docket_no').prop('disabled',true);
    

    });
    function openTimekeepingModal(docket_id){
        $('.time_in').hide();
        $('.time_out').hide();
        $.ajax({
            url: base_url+'/get_docket_details_for_timekeeping',
            type:"POST",
            data:{ docket_id : docket_id },
            dataType : 'json',
            success:function(response)
            {
                if (response == false)
                {
                    $('#availability').append('<span class="text-danger">No Docket found</span>');
                }
                else
                {
                    $('#timekeeping_id').val('');
                    $('#form_docket_no').val('');
                    $('#form_docket_id').val('');
                    if(typeof(response.checkTimeInOrOut[0]) != "undefined" && response.checkTimeInOrOut[0] !== null) {
                        if (response.checkTimeInOrOut[0].time_in == '') {
                            // we have to show time in btn only because user is time outed from privious work
                            $('.time_in').show();

                        } else if(response.checkTimeInOrOut[0].time_out == '') {
                            $('#timekeeping_id').val(response.checkTimeInOrOut[0].id);
                            // we have to 
                            $('.time_out').show();
                            //show clock here
                        } else {
                            $('.time_in').show();
                        }
                    } else {
                        $('.time_in').show();
                    }

                    //aassigning values here to the form
                    $('#form_docket_no').val(response.dockets.docket_no);
                    $('#form_docket_id').val(response.dockets.id);
                    $('#time_table').find('tbody').remove();
                    html = '';
                    console.log(response.timekeeping);
                    if (response.timekeeping != false) {
                        $(response.timekeeping).each(function(index, value) {
                        // var diff = ( new Date("1970-1-1 " + end_time) - new Date("1970-1-1 " + start_time) ) / 1000 / 60 / 60;
                        var showTimeOut;
                        if(value.total_time != "") {
                            showTimeOut = value.total_time
                        } else {
                            // console.log(value.time_in);
                            // new FlipClock($('.clock'), value.time_in, { });
                            showTimeOut = '';
                            
                        }
                        html += '<tbody><tr>';
                        html += '<td>'+value.time_in+'</td>';
                        html += '<td>'+value.time_out+'</td>';
                        html += '<td>'+showTimeOut+'</td>';
                        html += '</tbody></tr>';
                    })
                    $('#time_table').append(html);
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
    function hhhh(d)
    {
        var dateParts = new Date((Number(d.split("-")[0])), (Number(d.split("-")[1]) - 1), (Number(d.split("-")[2])));
        var dateis = dateParts.getTime();

        var timeEnd = $("#endtime").val();
        var time1 = ((Number(timeEnd.split(':')[0]) * 60 + Number(timeEnd.split(':')[1]) * 60) * 60) * 1000;

        var timeStart = $("#starttime").val();
        var time2 = ((Number(timeStart.split(':')[0]) * 60 + Number(timeStart.split(':')[1]) * 60) * 60) * 1000;

        var dateTimeEnd = dateis + time1;
        var dateTimeStart = dateis + time2;
    }
    
    
</script>


<?= $this->endSection()?>
