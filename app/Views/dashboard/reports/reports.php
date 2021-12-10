<?= $this->extend("master")?>
<?= $this->section("content")?>
<?php //$permissions = $this->load->get_var('permissions');?>
<div class="row section-main-cats">
    <?php //if(in_array("all_estimates", $permissions)){?>              
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?php echo base_url();?>/timekeeping-report">
                <div class="box-category hvr-pulse">
                    <div class="shadow">
                        <?= img('images/custom-images/new-icons/attendance_report.png') ?>
                    </div>
                    <div class="title">All TimeKEEPING Reports</div>
                </div>
            </a>
        </div>
    <?php //} ?>
</div>
<?= $this->endSection()?>
