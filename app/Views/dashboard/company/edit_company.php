
<?= $this->extend("master")?>
<?= $this->section("content")?>

<div class="row">
        <div class="" id="successMessage">
            <?= view('App\Auth\_message_block') ?>
        </div>

    <div class="row">
        <form action="<?= base_url();?>/update-company" method="post" id="company_information" enctype="multipart/form-data">
            <div class="block-content-outer basic-info col-md-6">
                <div class="block-content-inner">
                    <h2><strong>Company Information</strong></h2>
                </div>
                <div class="form-group">
                    <label for="first_name">Company Name</label>
                    <input type="hidden" name="company_id" value="<?= $company['id'] ?>" >
                    <input type="text" class="form-control" name="company_name"
                           value="<?php echo set_value('company_name', $company['company_name']) ?>" >
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 14px;">
						<?php echo $validation->getError('company_name');?>
                        <?php //echo form_error('company_name'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name">Owner</label>
                    <input type="text" class="form-control"  name="owner_name"
                           value="<?php echo set_value('company_owner', $company['company_owner']) ?>" >
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 14px;">
						<?php echo $validation->getError('company_owner'); ?>
                        <?php //echo form_error('company_owner'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control phone_us" id="phone" name="phone"
                           value="<?php echo set_value('phone', $company['phone']) ?>">
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 14px;">
						<?php echo $validation->getError('phone'); ?>
                        <?php //echo form_error('phone'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Company Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email"
                           value="<?php echo set_value('email', $company['email']) ?>">
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 14px;">
						<?php echo $validation->getError('email'); ?>
                        <?php //echo form_error('email'); ?>
                    </div>
                </div>

               <div class="form-group">
                    <label for="exampleInputEmail1">Address</label>
                    <input type="text" class="form-control" name="address"
                           value="<?php echo set_value('address', $company['address']) ?>">
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 14px;">
						<?php echo $validation->getError('address'); ?>
                        <?php //echo form_error('address'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">City</label>
                    <input type="text" class="form-control" name="city"
                           value="<?php echo set_value('city', $company['city']) ?>">
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 14px;">
						<?php echo $validation->getError('city'); ?>
                        <?php //echo form_error('city'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">State</label>
                    <input type="text" class="form-control" name="state"
                           value="<?php echo set_value('state', $company['state']) ?>">
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 14px;">
						<?php echo $validation->getError('state'); ?>
                        <?php //echo form_error('state'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Zip</label>
                    <input type="text" class="form-control numericValue" name="zip"
                           value="<?php echo set_value('zip', $company['zip']) ?>">
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 14px;">
						<?php echo $validation->getError('zip'); ?>
                        <?php //echo form_error('zip'); ?>
                    </div>
                </div>
			</div>

            <div class="block-content-outer basic-info col-md-6">
                <div class="block-content-inner">
                    <h2><strong>Subscription Information</strong></h2>
                </div>
                <div class="form-group">
                    <?php $renew_date=new DateTime($company['renew_date']);
                    $subscription_date= new DateTime($company['subscription_start_date']);
                    $renew_date=$subscription_date->modify('+1 month');
                    $renew_date=date_format($renew_date,"m/d/Y");
//                    print_r($renew_date); die;
                    ?>
                    <label for="job_title">Renew Date</label>
                    <div id="renew_date">
                        <input type="text" class="form-control" value="<?php echo $renew_date?>" name="renew_date" readonly />
<!--                        <span class="input-group-addon">-->
<!--                        <span class="glyphicon glyphicon-calendar"></span>-->
                    </span>
                    </div>
					<div style="color: red!important; font-family:'Times New Roman'; font-size: 14px;">
						<?php echo $validation->getError('renew_date'); ?>
						<?php //echo form_error('renew_date'); ?>
					</div>
                </div>
                <div class="form-group">
                    <?php
                    $subscription_date= new DateTime($company['subscription_start_date']);
                    $subscription_date=date_format($subscription_date,"m/d/Y");
                    ?>
                    <label for="job_title">Subscription Start Date</label>

                    <div id="subscription_date">
                        <input type="text" class="form-control" value="<?php echo $subscription_date; ?>" name="start_date" readonly />
<!--                        <span class="input-group-addon">-->
<!--                        <span class="glyphicon glyphicon-calendar"></span>-->
                    </span>
                    </div>
					<div style="color: red!important; font-family:'Times New Roman'; font-size: 14px;">
						<?php echo $validation->getError('start_date'); ?>
						<?php //echo form_error('start_date'); ?>
					</div>
                </div>
                <div class="form-group">
                    <label for="">Renew Cost</label>
                    <select name="renew_cost" class="form-control">
                        <option>Select Monthly Subscription</option>
                        <?php

                        // foreach($subscriptions as $data)
                        // {
                        //     $selected = $company['subscription_plan_id'] == $data['id'] ? 'selected' : '';
                        //     echo '<option '.$selected.' value="'.$data['id'].'">'.$data['name'].' ($'.$data['price'].')</option>';
                        // }
                        ?>
                    </select>
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 14px;">
                        <?php echo $validation->getError('renew_cost'); ?>
                        <?php //echo form_error('renew_cost'); ?>
                    </div>
                </div>

                <div class="form-group ">
                    <label for="">Upload Logo</label>
                    <input type="file" class="form-control" name="userfile"">

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <a href="#" class="edit_employee_button"><button type="submit" class="btn btn-primary">Update Company Info</button></a>
                </div>
            </div>
        </form>
    </div>
	<?= script_tag('js/dropzone.js') ?>
	<?= script_tag('js/required/jquery.mask.min.js') ?>
	<?= script_tag('js/required/users.js') ?>


	<script type="text/javascript">
        $(document).ready(function () {
            $('#expiry_date').datetimepicker({
                format: 'MM/DD/YYYY'
            });
        });

        $(document).ready(function () {
            $('#renew_date').datetimepicker({
                format: 'MM/DD/YYYY'
            });
        });

        $(document).ready(function () {
            $('#subscription_date').datetimepicker({
                format: 'MM/DD/YYYY'
            });
        });
    </script>

<?= $this->endSection()?>
