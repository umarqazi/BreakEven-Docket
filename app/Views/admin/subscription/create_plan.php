<?= $this->extend("admin/admin_master")?>
<?= $this->section("content")?>
<div class="row">
	<div class="col-lg-1">
	</div>
	<div class="col-lg-10" style="background-color: #EBE8E8; border-radius:10px !important; margin-bottom:15px;" >
		<div class="block-content-outer">
			<div class="block-content-inner text-center">
				<h2><strong>Add Subscription</strong></h2>
			</div>
		</div>
		<form id="subscription_form" method="POST" action="<?php echo base_url()?>/admin/save_plan" data-toggle="validator">
			<div class="subscription-form-wrapper">
				<div class="block-content-outer basic-info">
					<div class="block-content-inner">

						<div class="form-group">
							<label for="name">Subscription Name</label>
							<input type="text" class="form-control" id="name" placeholder="Enter Subscription Name"
								   name="name" value="<?php echo set_value('name', isset($subscription['name']) ? $subscription['name'] : '') ; ?>"
								   <?php //echo set_value('company_name', $company['company_name']) ?>
								   
								   >
							<div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
                                <?php echo $validation->getError('name');?>
							</div>
						</div>
							<input type="hidden" name="plan_id" value="<?= !empty($subscription['id']) ? $subscription['id'] : '' ?>"

						<div class="form-group">
							<label for="subscription_description">Subscription Description</label>
							<textarea type="text" class="form-control" id="description" placeholder="Enter Subscription Description" name="description" rows="5" ><?php echo set_value('description', isset($subscription['description']) ? $subscription['description'] : '' ); ?></textarea>
							<div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
								<?php echo $validation->getError('description'); ?>
							</div>
						</div>

						<div class="form-group">
							<label for="subscription_description">Subscription Status</label>
							<select class="status-dropdown" name="status">
								<option value="1" <?php echo isset($subscription['status']) && $subscription['status'] == 1 ? 'selected' : '' ?>>Active</option>
								<option value="0" <?php echo isset($subscription['status']) && $subscription['status'] == 0 ? 'selected' : '' ?>>In Active</option>
							</select>
						</div>

						<div class="form-group">
							<label for="price">Subscription Price</label>
							<input type="text" class="form-control" id="price" placeholder="Enter Subscription Price" name="price" value="<?php echo set_value('price', isset($subscription['price']) ? $subscription['price'] : ''); ?>"
								   >
							<div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
								<?php echo $validation->getError('price'); ?>
							</div>
						</div>

						<div class="form-group">
							<label for="allowed_users">Allowed Users</label>
							<input type="text" class="form-control" id="allowed_users" placeholder="Enter Allowed Users"
								   name="allowed_users" value="<?php echo set_value('allowed_users', isset($subscription['allowed_users']) ? $subscription['allowed_users'] : ''); ?>">
							<div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
								<?php echo $validation->getError('allowed_users'); ?>
							</div>
						</div>

						<div class="form-group">
							<label for="header_color">Set Header Color</label>
							<input type="text" class="form-control colorpicker" id="header_color" placeholder="Enter Header Color" name="header_color" value="<?php echo set_value('header_color', isset($subscription['header_color']) ? $subscription['header_color'] : ''); ?>" required>
							<div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
								<?php echo $validation->getError('header_color'); ?>
							</div>
						</div>

						<div class="form-group">
							<label for="body_color">Set Body Color</label>
							<input type="text" class="form-control colorpicker" id="body_color" placeholder="Enter Body Color" name="body_color" value="<?php echo set_value('body_color', isset($subscription['body_color']) ? $subscription['body_color'] : ''); ?>" required>
							<div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
								<?php echo $validation->getError('body_color'); ?>
							</div>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary save_subscription">Save Subscription</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<?= script_tag('js/required/jquery.minicolors.min.js') ?>
<script>
	var settings = {
		animationSpeed: 50,
		animationEasing: 'swing',
		change: null,
		changeDelay: 0,
		control: 'hue',
		defaultValue: '#000',
		format: 'hex',
		hide: null,
		hideSpeed: 100,
		inline: false,
		keywords: '',
		letterCase: 'uppercase',
		opacity: false,
		position: 'center left',
		show: null,
		showSpeed: 100,
		swatches: []
	};

	$('.colorpicker').minicolors(settings);
	$('.colorpicker').minicolors(settings);
</script>
<?= $this->endSection()?>