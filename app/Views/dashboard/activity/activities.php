
<?= $this->extend("master")?>
<?= $this->section("content")?>
    <style>
    .step_number {
        padding: 9px 12px !important;
        background-color: #D8D5D5;
        color: #293870;
    }
    .bg-date{
        /* border-radius: 25px !important;
        padding: 12px 19px !important;
        background-color: #293870;
        margin-bottom: 5px;
        color: white; */
        border-radius: 25px 25px 0px 0px !important;
        padding: 9px 20px !important;
        background-color: #293870;
        margin-bottom: 5px;
        color: white;
        width: 14%;
        margin-top: 5px;
        margin-bottom: 5px;
        text-align: center;
    }
    
    .box-activity {
        /* border: 1px solid #D8D5D5; */
        border-radius:7px !important;
        background-color:#EEEBEB; 
        padding:8px 5px 5px 5px; 
        margin:4px 1px 0px 1px;
        /* box-shadow: 0 4px 2px -2px gray;  */
    }
    .filter-box{
        border: 1px solid #D8D5D5;
        border-radius: 7px !important;
        background-color: #EEEBEB;
        /* padding: 8px 5px 5px 5px; */
        margin: 4px 1px 0px 1px;
        /* box-shadow: 0 4px 2px -2px grey; */
    }
    .form-control{
        margin-right:8px;
    }
    </style>
    <div class="col-md-12" id="material-section">
        <!-- <h1>Activity Logs</h1> -->
        <h2 class="heading-text" style="margin-top: 5px;">
            Activity Logs
            <button class="btn btn-primary pull-right job_pattern_btn toggle_btn" title="Filter Record" >Filter Records</button>
            <?php if($show_remove_btn == true){ ?>
            <a type="button" class="btn btn-danger pull-right" href="<?= route_to('activity') ?>" style="font-size: 12px; margin-right:4px">Remove Filter</a> 
            <?php } ?>
        </h2>
        <div class="row filter-box" id="filter_div" style="padding:10px " >
            <form action="<?= route_to('activity') ?>" method="post" id="activity_filter_form">
                <div style="display: flex;">
                    <input type="text" id="datetimepicker1" name="date_from" value="<?= isset($filters['date_from']) ? $filters['date_from'] : ''?>" class="form-control" placeholder="Date From">
                    <input type="text" id="datetimepicker2" name="date_to" value="<?= isset($filters['date_to']) ? $filters['date_to'] : ''?>" class="form-control" placeholder="Date To">
                    <select id="employee_id" name="employee_id" class="form-control" >
                        <option disabled="disabled" selected="true" value="">Select Employee</option>
                        <?php foreach($employees as $key => $value):?>
                            <option value="<?= $value['id'];?>" <?= isset($filters['employee_id']) ? (($filters['employee_id'] == $value['id']) ? 'selected' : '' ) : ''?> ><?= $value['user_name'];?></option>
                        <?php endforeach;?>
                    </select>
                    <input type="button" class="btn btn-primary pull-right" id="btn_submit" onclick="validate_filter()" value="Search" style="padding:8px 10px;line-height:normal;">
                </div>
            </form>
        </div>
    </div>
    <div class="clear20"></div>
    <?php $i=1; ?>
    <?php if (!empty($data)) { ?>
        <?php $date = date('Y-m-d', strtotime($data[0]['created_at'])); ?>
        <div class="bg-date" style=""><?= $date ?></div>
        
    <?php foreach($data as $row): ?>
        <?php if ($date == date('Y-m-d', strtotime($row['created_at']))) { ?>
            <?php if($row['type'] == 1) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Loged In at <span style="color: #293870;"><?= date('j M, Y, g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 2) { ?>
                <div class="box-activity">
                <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Loged Out at <span style="color: #293870;"><?= date('j M, Y, g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 3) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Created Employee <a href="#"><?= json_decode($row['description'])->employee_name; ?></a> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 4) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Updated Employee <a href="#"><?= json_decode($row['description'])->employee_name; ?></a> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 5) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Deleted Employee <a href="#"><?= json_decode($row['description'])->employee_name; ?></a> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 6) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Created Docket <span style="color: #293870;"><a href="#"><?= $row['docket_no']; ?></a></span> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 7) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Assigned Docket <span style="color: #293870;"><a href="#"><?= $row['docket_no']; ?></a></span> to <span style="color: #293870;"><a href="#"><?= $row['employee_name']; ?></a></span> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 8) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> Time In on Docket <span style="color: #293870;"><a href="#"><?= $row['docket_no']; ?></a></span> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 9) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> Time Out from Docket <span style="color: #293870;"><a href="#"><?= $row['docket_no']; ?></a></span> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 10) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> Manually Time In on Docket <span style="color: #293870;"><a href="#"><?= $row['docket_no']; ?></a></span> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 11) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> Manually Time Out from Docket <span style="color: #293870;"><a href="#"><?= $row['docket_no']; ?></a></span> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 12) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Changed Permissions of <a href="#"><?= $row['employee_name']; ?></a> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 13) { ?>
                <div class="box-activity">
                <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Checked In Attendance at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 14) { ?>
                <div class="box-activity">
                <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Checked Out Attendance at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 15) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Gone On Break at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 16) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Resume Break at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 17) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Updated Company information at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 18) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Suspended own Company at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 19) { ?>
                <div class="box-activity">
                <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Suspended own Company at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php }if($row['type'] == 21) { ?>
                <div class="box-activity">
                <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Varified their Account at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } if($row['type'] == 22) { ?>
                <div class="box-activity">
                <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Updated their Signature <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php }if($row['type'] == 23) { ?>
                <div class="box-activity">
                <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Updated their Mail Signature <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
            <?php } ?>
        <?php } else {
                $date = date('Y-m-d', strtotime($row['created_at']));
                $i =1; ?>
                <div class="bg-date" style=""><?= $date ?></div>
                <?php if($row['type'] == 1) { ?>
                <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Loged In at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                </div>
                <?php } if($row['type'] == 2) { ?>
                    <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Loged Out at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 3) { ?>
                    <div class="box-activity">
                        <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Created Employee <a href="#"><?= json_decode($row['description'])->employee_name; ?></a> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 4) { ?>
                    <div class="box-activity">
                        <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Updated Employee <a href="#"><?= json_decode($row['description'])->employee_name; ?></a> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 5) { ?>
                    <div class="box-activity">
                        <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Deleted Employee <a href="#"><?= json_decode($row['description'])->employee_name; ?></a> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 6) { ?>
                    <div class="box-activity">
                        <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Created Docket <span style="color: #293870;"><a href="#"><?= $row['docket_no']; ?></a></span> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 7) { ?>
                    <div class="box-activity">
                        <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Assigned Docket <span style="color: #293870;"><a href="#"><?= $row['docket_no']; ?></a></span> to <span style="color: #293870;"><a href="#"><?= $row['employee_name']; ?></a></span> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 8) { ?>
                    <div class="box-activity">
                        <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> Time In on Docket <span style="color: #293870;"><a href="#"><?= $row['docket_no']; ?></a></span> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 9) { ?>
                    <div class="box-activity">
                        <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> Time Out from Docket <span style="color: #293870;"><a href="#"><?= $row['docket_no']; ?></a></span> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 10) { ?>
                    <div class="box-activity">
                        <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> Manually Time In on Docket <span style="color: #293870;"><a href="#"><?= $row['docket_no']; ?></a></span> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 11) { ?>
                    <div class="box-activity">
                        <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> Manually Time Out from Docket <span style="color: #293870;"><a href="#"><?= $row['docket_no']; ?></a></span> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 12) { ?>
                    <div class="box-activity">
                        <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Changed Permissions of <a href="#"><?= $row['employee_name']; ?></a> at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 13) { ?>
                    <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Checked In Attendance at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 14) { ?>
                    <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Checked Out Attendance at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 15) { ?>
                    <div class="box-activity">
                        <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Gone On Break at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 16) { ?>
                    <div class="box-activity">
                        <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Resume Break at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 17) { ?>
                    <div class="box-activity">
                        <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Updated Company information at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 18) { ?>
                    <div class="box-activity">
                        <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Suspended own Company at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 19) { ?>
                    <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Suspended own Company at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php }if($row['type'] == 21) { ?>
                    <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Varified their Account at <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } if($row['type'] == 22) { ?>
                    <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Updated their Signature <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php }if($row['type'] == 23) { ?>
                    <div class="box-activity">
                    <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has Updated their Mail Signature <span style="color: #293870;"><?= date('g:i a', strtotime( $row['created_at'])) ?></span></span>
                    </div>
                <?php } ?>                
            <?php } ?>
    <?php $i++;?>
    <?php endforeach; ?>
    <?php } else { ?>
        <div class="box-activity" style="text-align: center;">
            No Record Found!
        </div>
    <?php }?>
    <div class="clear20"></div>
    <script>
    function validate_filter() {
        if ($('#datetimepicker1').val() == '' && $('#datetimepicker2').val() == null && $('#employee_id').val() == null ) {
            swal({
                title: "Error!",
                text: 'Please Select atleast one value!',
                icon: "error",
            });
        } 
        else {
            $('#activity_filter_form').submit();
        }
    }
    $(document).ready(function(){
        $(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#datetimepicker2').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
        console.log('<?= $show_remove_btn ?>');
        if (!'<?= $show_remove_btn ?>') {
            $("#filter_div").hide();            
        }
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