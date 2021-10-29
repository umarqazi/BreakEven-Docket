<?= $this->extend("master")?>
<?= $this->section("content")?>


<div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-10" id="material-section">
        <h2 class="heading-text">
            <strong>My Dockets</strong>
            <button class="btn btn-primary pull-right job_pattern_btn" title="Create a Docket No" onclick="job_pattern()">Create a Docket No</button>
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
                                <a href="<?php //echo base_url()?>estimating/estimate_page/<?php //echo $estimate['id'];?>"><?php echo $docket['docket_no'];?></a>
                            </td>

                            <td>
                                <a class="estimate_field" href="<?php //echo base_url()?>estimating/estimate_page/<?php //echo $estimate['id'];?>"><?php echo $docket['assigned_by'];?></a>
                            </td>

                            <td>
                                <a class="estimate_field" href="#"><?php echo !is_null($docket['assigned_at']) ? date('d-m-Y H:i:s', strtotime($docket['assigned_at'])) : '' ?></a>
                            </td>
                            <td>
                                <a href="#"><button type="button" class="btn btn-warning btn-xs" onclick="openTimekeepingModal(<?= $docket['docket_id'];?>)">Assign</button></a>
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


<div id="job_pattern" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div id="modalBody" class="modal-body">
                <div class="row job_no_container">
                    <div class="jop_wrapper">

                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                        <div class="heading">Create Docket No</div>
                        <div id="error-block"></div>
                        <form id="store_docket_form" method="post" action="<?= route_to('store_docket') ?>">
                            <input type="text" name="docket_no" id="docket_no" class="pattern" value="<?= old('docket_no') ?>" placeholder="Enter Docket No" >
                            <div id="_error" style="color: red!important; font-family:'Times New Roman'; font-size: 15px;"></div>
                            <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
                                <?php echo $validation->getError('docket_no'); ?>
                            </div>
                            <span id="availability"></span><div id="msg" style="color: red"></div>
                            <button type="button" onclick="checkDocektNo()" class="btn btn-info job_btn btn_docket_no" >Save Docket No</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade full-modal" id="timekeeping" tabindex="-1" role="dialog" aria-labelledby="full-modal-label"
	 aria-hidden="true">
	<div class="modal-dialog" data->
		<div class="modal-content" data-border-top="multi">
			<form id="add_new_area_form" method="post" action="<?php echo base_url() ?>estimating/add_estimate_area">
				<div class="modal-body clearfix" id="surfaces-methods">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h3 class="h3_bold">Docket No:
							<input type="text" placeholder="" class="popup_input "
								   name="docket_no" id="form_docket_no" disabled >
						</h3>
						<div class="table-responsive area_details">
                            Hamzah Mahmood
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="add-button pull-left"><span class="icon-social-addthis" title="Add New Method"></span></button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="add_area_button">Add Area</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

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
    function checkDocektNo(){
        $('#msg').empty();
        $('#_error').empty();
        $('#availability').empty();
        var docket_no = $('#docket_no').val();
        if(docket_no == ''){
            $('#msg').append('Docket No is Required!');
            e.preventDefault();
        }
        var checkDocketNourl = '<?php echo base_url();?>/get_docket_no';

        $.ajax({
            url: checkDocketNourl,
            type:"POST",
            data:{ docket_no : docket_no },
            dataType : 'json',
            success:function(response)
            {
                if (response == false)
                {
                    $('#availability').append('<span class="text-danger">Docket No Already Exists</span>');
                }
                else
                {
                    if(docket_no != ''){
                        $('#store_docket_form').submit();
                    } else {
                        $('#availability').append('<span class="text-danger">Docket No Already Exists</span>');
                    }
                }

            },
            error:function(response)
            {
                console.log(response);
            }
        })
    }
    function openTimekeepingModal(docket_id){

        $.ajax({
            url: base_url+'/get_docket_details_for_timekeeping',
            type:"POST",
            data:{ docket_id : docket_id },
            dataType : 'json',
            success:function(response)
            {
                if (response == false)
                {
                    $('#availability').append('<span class="text-danger">Docket No Already Exists</span>');
                }
                else
                {
                    //aassigning values here to the form
                    console.log(response.docket_no);
                    $('#form_docket_no').val(response.docket_no);
                }

            },
            error:function(response)
            {
                console.log(response);
            }
        })
        $("#timekeeping").modal('show');

    }
</script>


<?= $this->endSection()?>
