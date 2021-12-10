<?= $this->extend("master")?>
<?= $this->section("content")?>


<div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-10" id="material-section">
        <h2 class="heading-text">
            <strong>Assign Dockets</strong>
        </h2>
        <?= view('App\Auth\_message_block') ?>
        <div class="materials-content">
            <div class="material-items">
                <!-- <div class="estimate_head dark_blue">
                    <span class="assembly_type">Get New Estimate</span>
                    <a href="<?php //echo base_url()?>estimating/create" class="pull-right">
                        <span class="icon-social-addthis" title="Get New Estimate"></span>
                    </a>
                </div> -->
                <table class="table table-striped table-hover" id="all_estimates_table">
                    <thead class="dark_blue ">
                    <tr style="color:white !important">
                        <th>Docket No</th>
                        <th>Added by</th>
                        <th>Date</th>
                        <th>View Assigned to</th>
                        <th>Assign</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($dockets)){
                    foreach($dockets as $docket):?>
                        <tr class="item-name">
                            <td>
                                <a href="#"><?php echo $docket['docket_no'];?></a>
                            </td>

                            <td>
                                <a class="estimate_field" href="#"><?php echo $docket['user_name'];?></a>
                            </td>

                            <td>
                                <a class="estimate_field" href="#"><?php echo !empty($docket['created_at']) ? date('j M, Y, g:i a', strtotime($docket['created_at'])) : '' ?></a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs" onclick="view_docket_modal(<?= $docket['id'];?>)">View</button>
                            </td>
                            <td>
                                <a href="<?php echo base_url();?>/docket-details/<?php echo $docket['id'];?>"><button type="button" class="btn btn-warning btn-xs">Assign</button></a>
                            </td>
                        </tr>
                    <?php endforeach;
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="col-md-2">
    </div>
</div>
<div class="modal fade full-modal" id="view_docket_modal" tabindex="-1" role="dialog" aria-labelledby="full-modal-label"
	 aria-hidden="true">
	<div class="modal-dialog" style="width: 75%;">
		<div class="modal-content" data-border-top="multi">
			<form id="add_new_area_form" method="post" action="">
				<div class="modal-body clearfix" id="surfaces-methods">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h2>Assignees</h2>
                        <div class="materials-content">
                            <div class="material-items">
                                <table class="table table-striped table-hover" id="dockt_assignees_table">
                                    <thead class="dark_blue ">
                                    <tr style="color:white !important">
                                        <th>#</th>
                                        <th>Docket No</th>
                                        <th>Assigned to</th>
                                        <th>Assigned By</th>
                                        <th>Assigned At</th>
                                    </tr>
                                    </thead>
                                    <tbody>                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
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
                "zeroRecords": "No docket is available",
                "emptyTable": "No docket is available"
            }
        });
    });
    function view_docket_modal(docket_id){
        $.ajax({
            url: base_url+'/get-docket-assignee',
            type:"POST",
            data:{ docket_id : docket_id },
            dataType : 'json',
            success:function(response)
            {
                $('#dockt_assignees_table').find('tbody').remove();
                if (response == false)
                {
                    $('#dockt_assignees_table').append('<tbody><tr><td colspan="5"><center>No data Found!</center></td></tr></tbody>');
                }
                else
                {
                    html = '';
                    html += '<tbody>';
                    $(response).each(function(index, value) {
                        html += '<tr>';
                        html += '<td>'+(index+1)+'</td>';
                        html += '<td>'+value.docket_no+'</td>';
                        html += '<td>'+value.employee_name+'</td>';
                        html += '<td>'+value.assigned_by+'</td>';
                        html += '<td>'+value.assigned_at+'</td>';
                        html += '</tr>';
                    })
                    html += '</tbody>';
                    $('#dockt_assignees_table').prepend(html);
                }

            },
            error:function(response)
            {
                console.log(response);
            }
        })
        $("#view_docket_modal").modal('show');
    }
</script>


<?= $this->endSection()?>
