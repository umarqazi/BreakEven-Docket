<?= $this->extend("master")?>
<?= $this->section("content")?>


<div class="row">

    <div class="col-md-12 " id="material-section">
        <!-- <h2 class="heading-text">
            <strong>Docket Detail</strong>
        </h2> -->
    </div>
</div>
<div class="row">

    <div class="col-md-1" id="material-section">
    </div>
    <div class="col-md-10" id="material-section">
        <div class="block overhead_visible">
            <div class="block-heading add_employee">
            <?= view('App\Auth\_message_block') ?>
                <div class="main-text h2">
                    Docket Assigned to
                </div>
                <div class="add_button_employee pull-right">
                    <?php //if (empty($subscription['allowed_users']) || count($records) < $subscription['allowed_users']) {?>
                        <button class="btn btn-primary pull-right job_pattern_btn" title="Create a Docket No" onclick="job_pattern()">Assign <?= !empty($dockets) ? '( '.$dockets[0]['docket_no'].')' : '' ?></button>
                    <?php //}?>
                </div>
            </div>
        </div>
        <div class="materials-content">
            <div class="material-items">
                <table class="table table-striped table-hover" id="all_assigned_users_table">
                    <thead class="dark_blue ">
                    <tr style="color:white !important">
                        <th>Docket No</th>
                        <th>Assigned to</th>
                        <th>Assigned By</th>
                        <th>Assigned At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($assignedEmployees)) { ?>
                    <?php foreach($assignedEmployees as $value):?>
                        <tr class="item-name">
                            <td>
                                <a ><?php echo $value['docket_no'];?></a>
                            </td>

                            <td>
                                <a ><?php echo $value['employee_name'];?></a>
                            </td>

                            <td>
                                <a ><?php echo $value['assigned_by'];?></a>
                            </td>

                            <td>
                                <a ><?php echo !is_null($value['assigned_at']) ? date('j M, Y, g:i a', strtotime($value['assigned_at'])) : '' ?></a>
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
</div>
<div class="row">
</div>


<div id="job_pattern" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="modalBody" class="modal-body">
                <div class="row job_no_container">
                    <div class="jop_wrapper">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                        <div class="heading">Assign Docket to Employee</div>
                        <div id="error-block"></div>
                        <form id="store_assign_form" method="post" action="<?= route_to('assign_docket') ?>">
                            <label for="input-demo-v"><strong>Select Employee</strong></label>
                            <input type="text" name="docket_no" id="docket_no" class="pattern add_job_no" value="<?= !empty($dockets) ? $dockets[0]['docket_no'] : '' ?>" readonly >
                            <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
                                <?php echo $validation->getError('docket_id'); ?>
                            </div>
                            <input type="hidden" name="docket_id" value="<?= $dockets[0]['id'] ?>" >
                            
                            <?php if(!empty($employees)) { ?>
                            <div class="form-group">
                                <label for="input-demo-v">Select Employee</label>
                                <select id="employee_id" name="employee_id" class="form-control  required" required="true">
                                    <option disabled="disabled" selected="true" value="">Choose Employee</option>
                                    <?php foreach($employees as $key => $value):?>
                                        <option value="<?= $value['id'];?>" <?= in_array($value['id'], $alreadyAssignedEmployees) ? ' disabled="disabled" ' : ''?> >
                                        <?= $value['user_name'];?>
                                        <?= in_array($value['id'], $alreadyAssignedEmployees) ? ' (Already Assigned)' : ''?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
                                <?php echo $validation->getError('employee_id'); ?>
                            </div>
                            <?php } ?>

                            
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
<?= script_tag('js/datatables/jquery.dataTables.min.js') ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#all_assigned_users_table').DataTable({
            "pagingType": "full_numbers",
            bAutoWidth: false,
            "autoWidth": false,
            "searching" : true,
            "sort" : false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language" : {
                search : '',
                searchPlaceholder: "Search Dockets",
                "zeroRecords": "No Record Found",
                "emptyTable": "No Record Found"
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
        var employee_id = $('#employee_id').val();
        if(docket_no == ''){
            $('#msg').append('Docket No is Required!');
            e.preventDefault();
        } else if (employee_id == null) {
            $('#msg').append('Select Employee First!');
            e.preventDefault();
        } else {
            $('#store_assign_form').submit();
        }
        
        return;
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
                        $('#store_assign_form').submit();
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
    function job_pattern(){
        $("#job_pattern").modal('show');
    }
</script>


<?= $this->endSection()?>
