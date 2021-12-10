<?= $this->extend("master")?>
<?= $this->section("content")?>
<?php //echo $this->include("partials/top_bar")?>
<div class="row section-main-cats">
    <?php //if(in_array("company_info", $permissions)){?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?php echo base_url();?>/company">
                <div class="box-category hvr-pulse">
                    <div class="shadow">
                        <?= img('images/custom-images/new-icons/company_info.png') ?>
                    </div>
                    <div class="title">Company Info</div>
                </div>
            </a>
        </div>
    <?php //} ?>

    <?php //if(in_array("access_control", $permissions)){?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?php echo base_url();?>employee_center/employee_list">
                <div class="box-category hvr-pulse">
                    <div class="shadow">
                        <?= img('images/custom-images/new-icons/permissions.png') ?>
                    </div>
                    <div class="title">Access Control</div>
                </div>
            </a>
        </div>
    <?php //} ?>
    <?php //if(in_array("invoice_signature", $permissions) || in_array("mail_signature", $permissions) || in_array("estimate_permissions", $permissions) || in_array("all_estimates", $permissions)){ ?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?php echo base_url();?>settings">
                <div class="box-category hvr-pulse">
                    <div class="shadow">
                        <?= img('images/custom-images/new-icons/setting.png') ?>
                    </div>
                    <div class="title">Settings</div>
                </div>
            </a>
        </div>
    <?php //} ?>
    <?php //if($this->session->user_type=="employee" && in_array("activity", $permissions)){?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?php echo base_url();?>/activity">
                <div class="box-category hvr-pulse">
                    <div class="shadow">
                        <?= img('images/custom-images/new-icons/forms_generated.png') ?>
                    </div>
                    <div class="title job_templates_font">Activity</div>
                </div>
            </a>
        </div>
    <?php //}?>
    <?php //if(in_array("all_estimates", $permissions) || in_array("attendance_report", $permissions)){ ?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?php echo base_url();?>reports">
                <div class="box-category hvr-pulse">
                    <div class="shadow">
                        <?= img('images/custom-images/new-icons/reports.png') ?>
                    </div>
                    <div class="title">Reports</div>
                </div>
            </a>
        </div>
    <?php //} ?>
    <?php //if(in_array("attendance", $permissions)){?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?php echo base_url();?>employee_attendance">
                <div class="box-category hvr-pulse">
                    <div class="shadow">
                        <?= img('images/custom-images/new-icons/time_card.png') ?>
                    </div>
                    <div class="title">Attendance</div>
                </div>
            </a>
        </div>
    <?php //} ?>
    <?php //if(in_array("instructions", $permissions)){?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?php echo base_url();?>instructions">
                <div class="box-category hvr-pulse">
                    <div class="shadow">
                        <?= img('images/custom-images/new-icons/instructions.png') ?>
                    </div>
                    <div class="title">Instructions</div>
                </div>
            </a>
        </div>
    <?php //} ?>

    <?php //if(in_array("emp_center", $permissions)){?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?= base_url();?>/employee-center">
                <div class="box-category hvr-pulse">
                    <div class="shadow">
                        <?= img('images/custom-images/new-icons/employee.png') ?>
                    </div>
                    <div class="title">Employees</div>
                </div>
            </a>
        </div>
    <?php //} ?>
</div>
<?= $this->endSection()?>