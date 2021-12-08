<?= $this->extend("master")?>
<?= $this->section("content")?>
<?php $user_id = user_id();?>
<div class="row section-main-cats">
    <?php if($permissions->hasPermission('Company Info',$user_id)){ ?>
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
    <?php } ?>

    <?php //if($permissions->hasPermission('Access Control',$user_id)){?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?php echo base_url();?>/access-control">
                <div class="box-category hvr-pulse">
                    <div class="shadow">
                        <?= img('images/custom-images/new-icons/permissions.png') ?>
                    </div>
                    <div class="title">Access Control</div>
                </div>
            </a>
        </div>
    <?php //} ?>
    <?php if($permissions->hasPermission('Mail Signature',$user_id) || $permissions->hasPermission('Signature Setup',$user_id)){ ?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?php echo base_url();?>/settings">
                <div class="box-category hvr-pulse">
                    <div class="shadow">
                        <?= img('images/custom-images/new-icons/setting.png') ?>
                    </div>
                    <div class="title">Settings</div>
                </div>
            </a>
        </div>
    <?php } ?>
    <?php if($permissions->hasPermission('Activity',$user_id)){ ?>
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
    <?php }?>
    <?php if($permissions->hasPermission('Reports',$user_id)){ ?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?php echo base_url();?>/reports">
                <div class="box-category hvr-pulse">
                    <div class="shadow">
                        <?= img('images/custom-images/new-icons/reports.png') ?>
                    </div>
                    <div class="title">Reports</div>
                </div>
            </a>
        </div>
    <?php } ?>
    <?php if($permissions->hasPermission('Attendence',$user_id)){ ?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?php echo base_url();?>/employee-attendance">
                <div class="box-category hvr-pulse">
                    <div class="shadow">
                        <?= img('images/custom-images/new-icons/time_card.png') ?>
                    </div>
                    <div class="title">Attendance</div>
                </div>
            </a>
        </div>
    <?php } ?>
    <?php if($permissions->hasPermission('Instructions',$user_id)){ ?>
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
    <?php } ?>

    <?php if($permissions->hasPermission('Employees',$user_id)){?>
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
    <?php } ?>
</div>
<?= $this->endSection()?>