<?= $this->extend("master") ?>
<?= $this->section("content") ?>


<div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8" id="material-section">
        <h2 class="heading-text">
            <strong>Dockets</strong>
            <button class="btn btn-primary pull-right job_pattern_btn" title="Create a Docket No" onclick="job_pattern()">Create a Docket No</button>
        </h2>
        <div class="" id="successMessage">
            <?= view('App\Auth\_message_block') ?>
        </div>
        <div class="materials-content">
            <div class="material-items">
                <!-- <div class="estimate_head dark_blue">
                    <span class="assembly_type">Get New Estimate</span>
                    <a href="<?php //echo base_url()
                                ?>estimating/create" class="pull-right">
                        <span class="icon-social-addthis" title="Get New Estimate"></span>
                    </a>
                </div> -->
                <table class="table table-striped table-hover" id="all_estimates_table">
                    <thead class="dark_blue ">
                        <tr style="color:white !important">
                            <th>Docket No</th>
                            <th>Added by</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($dockets)) {
                            foreach ($dockets as $docket) : ?>
                                <tr class="item-name">
                                    <td>
                                        <a href="<?php echo base_url() ?>/docket-details/<?php echo $docket['id']; ?>"><?php echo $docket['docket_no']; ?></a>
                                    </td>

                                    <td>
                                        <a class="estimate_field" href="#"><?php echo $docket['user_name']; ?></a>
                                    </td>

                                    <td>
                                        <a class="estimate_field" href="#"><?php echo !is_null($docket['created_at']) ? date('j M, Y, g:i a', strtotime($docket['created_at'])) : '' ?></a>
                                    </td>
                                </tr>
                        <?php endforeach;
                        } ?>
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
                        <div id="error-block" style="color:red">
                            <?php if (session("duplicateDocketNo")) {
                                echo 'Docket No already exists!';
                            } ?>
                        </div>

                        <form id="store_docket_form" method="post" action="<?= route_to('store_docket') ?>">
                            <input type="text" name="docket_no" id="docket_no" class="pattern" value="<?= old('docket_no') ?>" placeholder="Enter Docket No" autofocus required>
                            <div id="_error" style="color: red!important; font-family:'Times New Roman'; font-size: 15px;"></div>
                            <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
                                <?php echo $validation->getError('docket_no'); ?>
                            </div>
                            <span id="availability"></span>
                            <div id="msg" style="color: red"></div>
                            <button type="submit" class="btn btn-info job_btn btn_docket_no">Save Docket No</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (session("duplicateDocketNo") || $validation->getError('docket_no')) {
    $duplicateDocketNo = 1;
} else {
    $duplicateDocketNo = 0;
}
?>
<?= script_tag('js/datatables/jquery.dataTables.min.js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        var duplicateDocketNo = <?php echo $duplicateDocketNo ?>;
        if (duplicateDocketNo === 1) {
            job_pattern();
        }
        $("#docket_no").focus();
        $("#docket_no").blur(function() {
            var name = $('#docket_no').val();
            if (name.length == 0) {
                $('#docket_no').next('div.red').remove();
                $('#docket_no').after('<div style="color:red" class="red">Docket No is Required</div>');
                return false;
            } else {
                $(this).next('div.red').remove();
                return true;
            }
        });
        $('#all_estimates_table').DataTable({
            "pagingType": "full_numbers",
            bAutoWidth: false,
            "autoWidth": false,
            "searching": true,
            "sort": false,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "language": {
                search: '',
                searchPlaceholder: "Search Dockets",
                "zeroRecords": "No Docket No is available",
                "emptyTable": "No Docket No is available"
            }
        });

        /*$('table').wrap('<div class="table-responsive"></div>');*/
        // $('.btn_docket_no').prop('disabled',true);
    });
    function job_pattern() {
        $("#job_pattern").modal('show');
    }
</script>
<?= $this->endSection() ?>