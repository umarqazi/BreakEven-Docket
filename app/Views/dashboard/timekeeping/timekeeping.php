<?= $this->extend("master")?>
<?= $this->section("content")?>

<style>
    #timekeeping {
        width: 80%;
        margin-left: 10%;
    }
</style>
<div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-10" id="material-section">
        <div class="" id="successMessage">
            <?= view('App\Auth\_message_block') ?>
        </div>
        <h2 class="heading-text">
            <strong>Time Keeping</strong>
            <!-- <button class="btn btn-primary pull-right job_pattern_btn" title="Create a Docket No" onclick="job_pattern()">Create a Docket No</button> -->
        </h2>
        <div class="materials-content">
            <div class="material-items">
                <table class="table table-striped table-hover" id="all_estimates_table">
                    <thead class="dark_blue ">
                    <tr style="color:white !important">
                        <th>Docket No</th>
                        <th>Assigned by</th>
                        <th>Assigned at</th>
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
                                <a href="#"><?php echo !is_null($docket['assigned_at']) ? date('j M, Y, g:i a', strtotime($docket['assigned_at'])) : '' ?></a>
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
			<form id="add_new_area_form" method="post" action="">
				<div class="modal-body clearfix" id="surfaces-methods">
					<div class="col-md-5 col-sm-5 col-xs-5">
						<h4 class="h3_bold">Docket No:
							<input type="text" class="popup_input " name="form_docket_no" id="form_docket_no" disabled >
							<input type="hidden" name="form_docket_id" id="form_docket_id" disabled >
							<input type="hidden" name="timekeeping_id" id="timekeeping_id" disabled >
						</h4>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <div class="clock"></div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="pull-right" style="margin-top: 13px;" >
                            <input type="button" onclick="timeChanges('time_in')" value="Time In" class="btn btn-primary time_in" >
                            <input type="button" onclick="timeChanges('time_out')" value="Time Out" class="btn btn-danger time_out" >
                            <div class="import-drowpdown" data-toggle="modal" data-target="#exampleModal" style="cursor: pointer;">
                                <span class="icon-arrow-down"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:27%">
        <form method="POST" action="<?= route_to('manual_time_in') ?>">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enter Date Time Manually</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class='col-sm-6 col-md-12'>
                                <input type='text' name="date" class="" id='datetimepicker4' placeholder="Enter DateTime"/>
                                <input type="hidden" name="form_docket_id" id="form_docket_id_" >
                                <input type="hidden" name="timekeeping_id" id="timekeeping_id_" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Time Out" class="btn btn-danger time_out pull-right" >
                    <input type="submit" value="Time In" class="btn btn-primary time_in pull-right" >
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= script_tag('js/flipclock/flipclock.js') ?>
<?= script_tag('js/datatables/jquery.dataTables.min.js') ?>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker4').datetimepicker();
    });
</script>
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
    
    
</script>


<?= $this->endSection()?>
