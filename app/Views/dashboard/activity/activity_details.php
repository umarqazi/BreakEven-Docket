
<?= $this->extend("master")?>
<?= $this->section("content")?>
<div class="row">
    <div class="col-md-12" id="material-section">
        <div class="" id="successMessage">
            <?= view('App\Auth\_message_block') ?>
        </div>
        <h2 class="heading-text">
            <strong>All Activity on dockets</strong>
            <button class="btn btn-primary pull-right job_pattern_btn toggle_btn" title="Filter Record" >Filter Records</button>
        </h2>
        <div class="row" style="border: 1px solid #D8D5D5;border-radius:7px !important;background-color:#EEEBEB; padding:8px 5px 5px 5px; margin:4px 1px 0px 1px;box-shadow: 0 4px 2px -2px gray; " id="filter_div">
            <div class="col-md-3">
                <label style="padding: 6px 0px 0px 0px;"><strong>Filter Records</strong></label>
            </div>
            <div class="col-md-3">
                <select id="employee_id" name="employee_id" class="form-control  required" required="true">
                    <option disabled="disabled" selected="true" value="">Select Employee</option>
                    <option disabled="disabled" selected="true" value="">Choose Employee</option>
                    <option disabled="disabled" selected="true" value="">Choose Employee</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="employee_id" name="employee_id" class="form-control  required" required="true">
                    <option disabled="disabled" selected="true" value="">Select Docket No</option>
                    <option disabled="disabled" selected="true" value="">Choose Employee</option>
                    <option disabled="disabled" selected="true" value="">Choose Employee</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-success float-right">Search</button>
            </div>
        </div>
        <div class="materials-content">
            <div class="material-items">
                <table class="table table-striped table-hover" id="all_logs_table">
                    <thead class="dark_blue ">
                    <tr style="color:white !important">
                        <th>#</th>
                        <th>Docket No</th>
                        <th>Assigned by</th>
                        <th>Worked By</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Working Time</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (!empty($logs)) {
                        $i=1;
                        foreach($logs as $log):
                        ?>
                        <tr class="item-name">
                            <td><?= $i ?></td>
                            <td><a href="#"><?= $log['docket_no'];?></a></td>
                            <td><a href="#"><?= $log['assigned_by'];?></a></td>
                            <td><a href="#"><?= $log['worked_by'];?></a></td>
                            <td><a href="#"><?= !empty($log['time_in']) ?       date('j M, Y, g:i a', strtotime($log['time_in']))   : '' ?></a></td>
                            <td><a href="#"><?= !empty($log['time_out']) ?      date('j M, Y, g:i a', strtotime($log['time_out']))  : '<span class="text-danger">Still Woking</span>' ?></a></td>
                            <td><a href="#"><?= !empty($log['total_time']) ?    date('H:i:s', strtotime($log['total_time']))        : '<span class="text-danger">Still Woking</span>' ?></a></td>
                        </tr>
                        <?php 
                        $i++; 
                        endforeach;
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<?= script_tag('js/datatables/jquery.dataTables.min.js') ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#all_logs_table').DataTable({
            "pagingType": "full_numbers",
            bAutoWidth: false,
            "autoWidth": false,
            "searching" : true,
            "sort" : false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language" : {
                search : '',
                searchPlaceholder: "Search Activity",
                "zeroRecords": "No Record Found",
                "emptyTable": "No Record Found"
            }
        });
        $("#filter_div").hide(  );
        $(".toggle_btn").click(function(){ 
            if ($("#filter_div").is(":visible")) {
                $("#filter_div").hide(500);
            } else {
                $("#filter_div").show(500);
            }
        });
    });
</script>
<?= $this->endSection()?>
