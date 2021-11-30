<?= $this->extend("master")?>
<?= $this->section("content")?>
<div class="row section-main-cats">
    <div class="col-md-12">

        <?php if($permissions->hasPermission(4,user_id())){ ?>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <a href="<?php echo base_url();?>/signature">
                    <div class="box-category hvr-pulse">
                        <div class="shadow">
								<?= img('images/custom-images/new-icons/invoice_signature.png') ?>
                        </div>
                        <div class="title">Signature Setup</div>
                    </div>
                </a>
            </div>
        <?php } ?>

        <?php if($permissions->hasPermission(5,user_id())){ ?>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <a href="<?php echo base_url();?>/mail-signature">
                    <div class="box-category hvr-pulse">
                        <div class="shadow">
								<?= img('images/custom-images/new-icons/email_signature.png') ?>
                        </div>
                        <div class="title">Mail Signature</div>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>
</div>
<?= $this->endSection()?>
