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
                                <a class="estimate_field" href="#"><?php echo !empty($docket['created_at']) ? date('M j, Y, g:i a', strtotime($docket['created_at'])) : '' ?></a>
                            </td>
                            <td>
                                <a href="<?php echo base_url();?>/employee-show/<?php echo $docket['id'];?>"><button type="button" class="btn btn-info btn-xs">View</button></a>
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
                            <input type="text" name="docket_no" id="docket_no" class="pattern add_job_no" value="<?= old('docket_no') ?>" placeholder="Enter Docket No" >
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
    function job_pattern(){
        $("#job_pattern").modal('show');
    }
</script>


<?= $this->endSection()?>
