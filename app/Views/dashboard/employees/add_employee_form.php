<?= $this->extend("master")?>
<?= $this->section("content")?>
<?php if(isset($errors)){
    echo '<p class="alert alert-danger"><strong> There are some errors in the input fields </strong></p>';
}?>
<div class="row">
    <div class="col-md-12">
        <div class="block-content-outer">
            <div class="block-content-inner users_btn">
                <h2><strong>Employee</strong></h2>
				<a class="btn btn-primary blue" href="<?php echo base_url();?>/employee-center">Back to employees</a>
            </div>
        </div>
    </div>
</div>

<form id="employee_form" method="POST" action="<?= route_to('store_employee') ?>" enctype="multipart/form-data" data-toggle="validator">
    <div class="row">
        <div class="block-content-outer basic-info col-md-6">
            <div class="block-content-inner">

                <div class="form-group">
                    <label for="first_name">Employee's First Name</label>
                    <input type="text" class="form-control" id="first_name" placeholder="Enter First Name"
                           name="first_name" value="<?= old('first_name') ?>" />
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('first_name'); ?>
                        <?php echo $validation->getError('first_name'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="last_name">Employee's Last Name</label>
                    <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name"
                           name="last_name" value="<?= old('last_name') ?>" />
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('last_name'); ?>
                        <?php echo $validation->getError('last_name'); ?>
                    </div>
                </div>

                <div class="form-group employee_email">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email"
                           name="email" onblur="checkemail();" value="<?= old('email') ?>" />
                    <div id="email_error" style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('email'); ?>
                        <?php echo $validation->getError('email'); ?>
                    </div>
                    <span id="availability"></span><div id="msg" style="color: red"></div>

                </div>

                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" class="form-control phone_us" id="mobile" placeholder="Mobile" name="mobile"
                    value="<?= old('mobile') ?>" />
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('mobile'); ?>
                        <?php echo $validation->getError('mobile'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control phone_us" id="phone" placeholder="Phone" name="phone"
                    value="<?= old('phone') ?>" />
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('phone'); ?>
                        <?php echo $validation->getError('phone'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="hire_date">Hire Date</label>
                    <div class="input-group" id="hire_date">
                        <input type='text' class="form-control hire_date" placeholder="Select Hire Date"
                               name="hire_date" value="<?= old('hire_date') ?>" />
                            <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>

                    </div>
					<div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('hire_date'); ?>
						<?php echo $validation->getError('hire_date'); ?>
					</div>
                </div>

                <div class="form-group">
                    <label for="release_date">Release Date</label>
                    <div class="input-group" id="release_date">
                        <input type="text" class="form-control release_date" placeholder="Select Release Date"
                               name="release_date" value="<?= old('release_date') ?>" />
                        <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
					</div>
					<div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('release_date'); ?>
						<?php echo $validation->getError('release_date'); ?>
					</div>
                    <div class="error"></div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" form="employee_form" placeholder="Enter Employee's Notes..." ><?= old('notes') ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary save_employee">Save Employee</button>
                </div>
            </div>
        </div>

        <div class="block-content-outer basic-info col-md-6">
            <div class="block-content-inner">

                <div class="form-group">
                    <label for="employee_address">Address</label>
                    <input type="text" class="form-control" id="employee_address" placeholder="Enter Address"
                           name="address" value="<?= old('address') ?>" />
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('address'); ?>
                        <?php echo $validation->getError('address'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="city">City/Town</label>
                    <input type="text" class="form-control" id="city" placeholder="Enter Employee's City" name="city"
                    value="<?= old('city') ?>" />
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('city'); ?>
                        <?php echo $validation->getError('city'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" class="form-control" id="state" placeholder="Enter State" name="state"
                    value="<?= old('state') ?>" />
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('state'); ?>
                        <?php echo $validation->getError('state'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="zip">Zip</label>
                    <input type="text" class="form-control numericValue" id="zip" placeholder="Enter Zip Code" name="zip"
                    value="<?= old('zip') ?>" />
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('zip'); ?>
                        <?php echo $validation->getError('zip'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="hourly_rate">Hourly Rate</label>
                    <input type="text" class="form-control decimalValue" placeholder="Enter Hourly Rate" name="hourly_rate"
                    value="<?= old('hourly_rate') ?>" />
					<div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('hourly_rate'); ?>
						<?php echo $validation->getError('hourly_rate'); ?>
					</div>
				</div>

                <div class="form-group">
                    <label for="salary">Salary</label>
                    <input type="text" class="form-control decimalValue" id="salary" placeholder="Enter Employee's Salary"
                           name="salary" value="<?= old('salary') ?>" />
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('salary'); ?>
                        <?php echo $validation->getError('salary'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="job_title">Job Title</label>
                    <select id="job_title" name="job_title" class="form-control"
                    value="<?= old('job_title') ?>" >
                        <option value="super_admin" <?php if (!empty( old('job_title')) &&  old('job_title') == 'super_admin'){ echo 'selected';} ?>>Super Admin</option>
                        <option value="admin" <?php if (!empty( old('job_title')) &&  old('job_title') == 'admin'){ echo 'selected';} ?>>Admin</option>
						<!-- <option value="painter" <?php if (!empty( old('job_title')) &&  old('job_title') == 'painter'){ echo 'selected';} ?>>Painter</option> -->
                    </select>
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('job_title'); ?>
                        <?php echo $validation->getError('job_title'); ?>
                    </div>
                </div>

				<h3 class="employee_access_control">"To update Employee Access visit Access Control"</h3>

                <div id="files" class="files"></div>


                <div id="myId" class="fallback dropzone"></div>

                <div class="form-group">
                    <input type="hidden" class="form-control" name="user_type" value="employee">
                    <input type="hidden" class="form-control" name="create_employee" value="1">
                </div>

            </div>
        </div>
    </div>
</form>
<?= script_tag('js/dropzone.js') ?>
<?= script_tag('js/required/jquery.mask.min.js') ?>
<?= script_tag('js/required/users.js') ?>
<script>
    var fileUploadUrl = '<?php echo base_url()?>file_storage/file_upload/?id=0';
    var formType = 'create';
    var documentRoot = '<?php echo $_SERVER['DOCUMENT_ROOT']?>';
    var chechEmailUrl = '<?php echo base_url();?>/get_email';
</script>
<?= $this->endSection()?>