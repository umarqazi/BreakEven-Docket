
<?= $this->extend("master")?>
<?= $this->section("content")?>
<style>
    .filter-box {
        border: 1px solid #D8D5D5;
        border-radius:7px !important;
        background-color:#EEEBEB; 
        padding:8px 5px 5px 5px; 
        margin:4px 1px 0px 1px;
        box-shadow: 0 4px 2px -2px gray; 
    }
    .form-control{
        margin-right:8px;
    }
</style>
<div class="row cost_step_row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <ul id="right-tabs-alt-1" class="nav nav-tabs tabs-right tabs-alt-1 highlight-color-blue">
            <li id = "list-step1" class="active">
                <a href="#step1" data-toggle="tab" aria-expanded="false"><p class="step_number">1</p><p class="title_text" style="text-align: center;">Partially worked Dockets</p></a>
            </li>
            <li id = "list-step2" class="">
                <a href="#step2" data-toggle="tab" aria-expanded="true"><p class="step_number">2</p><p class="title_text" style="text-align: center;">Total Working on Docket</p></a>
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="" id="successMessage">
        <?= view('App\Auth\_message_block') ?>
    </div>
    <div class="tab-content instructions_content">
        <div id="step1" class="tab-pane active">
            <div class="col-md-12" id="material-section">
                <h2 class="heading-text" style="margin-top: 5px;">
                    <strong>All Workings on dockets</strong>
                    <button class="btn btn-primary pull-right job_pattern_btn toggle_btn" title="Filter Record" >Filter Records</button>
                    <?php if($show_remove_btn == true){ ?>
                    <a type="button" class="btn btn-danger pull-right" href="<?= route_to('timekeeping-report') ?>" style="font-size: 12px; margin-right:4px">Remove Filter</a> 
                    <?php } ?>
                </h2>
                <div class="row filter-box" id="filter_div" >
                    <form action="<?= route_to('timekeeping-report') ?>" method="post" id="activity_filter_form">
                        <div style="display: flex;">
                            <input type="text" id="datetimepicker1" name="time_in" value="<?= isset($filters['time_in']) ? $filters['time_in'] : ''?>" class="form-control" placeholder="Time In">
                            <input type="text" id="datetimepicker2" name="time_out"value="<?= isset($filters['time_out']) ? $filters['time_out'] : ''?>" class="form-control" placeholder="Time Out">
                            <select id="employee_id" name="employee_id" class="form-control" >
                                <option disabled="disabled" selected="true" value="">Select Employee</option>
                                <?php foreach($employees as $key => $value):?>
                                    <option value="<?= $value['id'];?>" <?= isset($filters['employee_id']) ? (($filters['employee_id'] == $value['id']) ? 'selected' : '' ) : ''?>><?= $value['user_name'];?></option>
                                <?php endforeach;?>
                            </select>
                            <select id="docket_id" name="docket_id" class="form-control" >
                                <option disabled="disabled" selected="true" value="">Select Docket No:</option>
                                <?php foreach($dockets as $key => $value):?>
                                    <option value="<?= $value['id'];?>" <?= isset($filters['docket_id']) ? (($filters['docket_id'] == $value['id']) ? 'selected' : '' ) : ''?> ><?= $value['docket_no'];?></option>
                                <?php endforeach;?>
                            </select>
                            <input type="button" class="btn btn-primary pull-right" id="btn_submit" onclick="validate_filter()" value="Search" style="padding:8px 10px;line-height:normal;">
                        </div>
                    </form>
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
        <div id="step2" class="tab-pane">
            <div class="col-md-12" id="material-section">
                <h2 class="">
                    <b>Total Working Time by an Employee on a Docket</b>
                </h2>
                <div class="materials-content">
                    <div class="material-items">
                        <table class="table table-striped table-hover" id="all_dockets_time_sum_table">
                            <thead class="dark_blue ">
                            <tr style="color:white !important">
                                <th>#</th>
                                <th>Docket No</th>
                                <th>Worked By</th>
                                <th>Total Working Time</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if (!empty($sumOfWorkingTimeByDockets)) {
                                    $i=1;
                                    foreach($sumOfWorkingTimeByDockets as $data):
                                    ?>
                                    <tr class="item-name">
                                        <td><?= $i ?></td>
                                        <td><a href="#"><?= $data['docket_no'];?></a></td>
                                        <td><a href="#"><?= $data['worked_by'];?></a></td>
                                        <td><a href="#"><?= !empty($data['total_time']) ?    date('H:i:s', strtotime($data['total_time'])) : '<span class="text-danger">Still Woking</span>' ?></a></td>
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
    </div>
</div>
<script>
    let show_remove_btn = '<?= $show_remove_btn ?>';
</script>
<?= script_tag('js/datatables/jquery.dataTables.min.js') ?>
<?= script_tag('js/dashboard/docket_activity.js') ?>
<?= $this->endSection()?>
