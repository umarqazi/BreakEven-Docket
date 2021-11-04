
<?= $this->extend("master")?>
<?= $this->section("content")?>
<div class="row">
    <div class="col-md-12" id="material-section">
    <?= view('App\Auth\_message_block') ?>
        <h2 class="heading-text">
            <strong>My Dockets</strong>
            <!-- <button class="btn btn-primary pull-right job_pattern_btn" title="Create a Docket No" onclick="job_pattern()">Create a Docket No</button> -->
        </h2>
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
                        <?php if (!empty($logs)) { 
                            $i=1;
                        foreach($logs as $log):?>
                        <tr class="item-name">
                            <td><?= $i ?></td>
                            <td><a href="#"><?= $log['docket_no'];?></a></td>
                            <td><a href="#"><?= $log['assigned_by'];?></a></td>
                            <td><a href="#"><?= $log['worked_by'];?></a></td>
                            <td><a href="#"><?= !is_null($log['time_in']) ? date('d-m-Y H:i:s', strtotime($log['time_in'])) : '' ?></a></td>
                            <td><a href="#"><?= !is_null($log['time_out']) ? date('d-m-Y H:i:s', strtotime($log['time_out'])) : '' ?></a></td>
                            <td><a href="#"><?= !is_null($log['total_time']) ? date('d-m-Y H:i:s', strtotime($log['total_time'])) : '' ?></a></td>
                        </tr>
                    <?php $i++; endforeach;
                    }?>
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

        /*$('table').wrap('<div class="table-responsive"></div>');*/
        // $('.btn_docket_no').prop('disabled',true);
    

    });
</script>
<?= $this->endSection()?>