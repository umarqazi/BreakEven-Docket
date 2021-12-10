
<?= $this->extend("admin/admin_master")?>
<?= $this->section("content")?>
<div class="row section-main-cats">
	<div class="col-lg-3 col-md-6 col-sm-12">
		<a href="<?php echo base_url();?>/admin/companies">
			<div class="box-category hvr-pulse">
				<div class="shadow">
                    <?= img('images/custom-images/new-icons/company_info.png') ?>
				</div>
				<div class="title">Companies</div>
			</div>
		</a>
	</div>

	<div class="col-lg-3 col-md-6 col-sm-12">
		<a href="<?php echo base_url();?>/admin/mail-signature">
			<div class="box-category hvr-pulse">
				<div class="shadow">
                    <?= img('images/custom-images/new-icons/email_signature.png') ?>
				</div>
				<div class="title">Mail Signature</div>
			</div>
		</a>
	</div>

	<div class="col-lg-3 col-md-6 col-sm-12">
		<a href="<?php echo base_url();?>/admin/subscription-plans">
			<div class="box-category hvr-pulse">
				<div class="shadow">
                <?= img('images/custom-images/new-icons/all_estimates.png') ?>
				</div>
				<div class="title">Subscription</div>
			</div>
		</a>
	</div>
</div>
<?= $this->endSection()?>