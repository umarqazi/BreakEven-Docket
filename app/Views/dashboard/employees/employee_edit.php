<?= $this->extend("master")?>
<?= $this->section("content")?>
<?php $validation = \Config\Services::validation(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="block-content-outer">
            <div class="block-content-inner">
                <h2><strong>Employee Center</strong></h2>
            </div>
        </div>
    </div>
</div>

<form id="employee_form" method="post" action="<?= route_to('store_employee') ?>" enctype="multipart/form-data" data-toggle="validator">
    <div class="row">
        <div class="block-content-outer basic-info col-md-6">
            <div class="block-content-inner">
                <div class="form-group">
                    <label for="first_name">Employee's First Name</label>
                    <input type="hidden" name="user_id" value="<?php echo set_value('user_id', $record->user_id) ?>" >
                    <input type="hidden" class="form-control" name="user_type" value="employee">
                    <input type="hidden" class="form-control" name="employee_id" value="<?php echo set_value('user_id', $record->employee_id) ?>">
                    <input type="text" class="form-control" id="first_name" value="<?php echo set_value('first_name', $record->first_name) ?>" name="first_name" >
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('first_name'); ?>
                        <?php echo $validation->getError('first_name'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="last_name">Employee's Last Name</label>
                    <input type="text" class="form-control" id="last_name"
                           value="<?php echo set_value('last_name', $record->last_name) ?>"
                           name="last_name" >
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('last_name'); ?>
                        <?php echo $validation->getError('last_name'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1"
                           name="email"
                           value="<?php echo set_value('email', $record->email) ?>"
                           onblur="checkemail()">
                    <input type="hidden" value="<?php echo $record->email; ?>" name="old_email" >
                    <span id="availability"></span><div id="msg" style="color: red"></div>
                    <div id="email_error" style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('email'); ?>
                        <?php echo $validation->getError('email'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" class="form-control phone_us" id="mobile"  name="mobile"
                           value="<?php echo set_value('mobile', $record->mobile) ?>"  placeholder="011-111-1111">
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('mobile'); ?>
                        <?php echo $validation->getError('mobile'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control phone_us" id="phone" name="phone"
                           value="<?php echo set_value('phone', $record->phone) ?>" placeholder="011-111-1111">
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('phone'); ?>
                        <?php echo $validation->getError('phone'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php
                    if ($record->hire_date !='0000-00-00'){
                        $hire_date = new DateTime($record->hire_date);
                        $hire_date = date_format($hire_date,"m/d/Y");
                    } else{
                        $hire_date = '';
                    }
                    ?>
                    <label for="hire_date">Hire Date</label>
                    <div class='input-group' id="hire_date">
                        <input type='text' class="form-control hire_date" name="hire_date"
                               value="<?php echo set_value('hire_date', $hire_date) ?>"/>


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
                    <?php
                    if ($record->release_date!='0000-00-00') {
                        $release_date = new DateTime($record->release_date);
                        $release_date = date_format($release_date, "m/d/Y");
                    } else{
                        $release_date = '';
                    }
                    ?>
                    <label for="release_date">Release Date</label>
                    <div class='input-group ' id="release_date">
                        <input type='text' class="form-control release_date" name="release_date"
                               value="<?php echo set_value('release_date', $release_date) ?>"/>

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
                    <input type="text" name="notes" id="notes" class="form-control" value="<?php echo $record->notes; ?>">
                </div>

                <?php
                if (user()->job_title  == "super_admin"){?>

                <div class="form-group">
                    <label for="is_enabled">Enable/Disable</label>
                    <select id="is_enabled" name="is_enabled" class="form-control" >
                        <option value="1" <?php if ($record->is_enabled == "1")
                            echo 'selected="selected"'?>>Enable</option>
                        <option value="0" <?php if ($record->is_enabled == "0")
                            echo 'selected="selected"'?>>Disable</option>
                    </select>
					<div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('is_enabled'); ?>
                        <?php echo $validation->getError('is_enabled'); ?>
					</div>
                </div>
                <?php }?>

                <?php //if(count($files)){?>
                    <div class="form-group">
                        <h3>User's Files</h3>
                        <ul class="user_files">
                            <?php //foreach($files as $file):?>
                                <li class="files_list_<?php //echo $file['id'];?>"><?php //echo $file['file_name'];?>
                                    <a class="<?php //echo $file['user_id'];?>" onclick="delete_file_confirmation(<?php //echo $file['id'];?>,<?php //echo $file['user_id'];?>)"><span class="glyphicon glyphicon-remove-circle"></span></a>
                                </li>
                            <?php //endforeach; ?>

                        </ul>
                    </div>
                <?php //} ?>

                <div class="form-group">
                    <a><button type="submit" class="btn btn-primary save_employee">Update Employee</button></a>
                    <a href="<?php echo base_url();?>employee_center/delete/<?php echo $record->user_id;?>" class="edit_employee_button delete_btn"><button type="button" class="btn btn-danger">Delete Employee</button></a>
                </div>
            </div>
        </div>

        <div class="block-content-outer basic-info col-md-6">
            <div class="block-content-inner">
                <div class="form-group">
                    <label for="employee_address">Address</label>
                    <input type="text" class="form-control" id="employee_address"  name="address"
                           value="<?php echo set_value('address', $record->address) ?>">
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('address'); ?>
                        <?php echo $validation->getError('address'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="city">City/Town</label>
                    <input type="text" class="form-control" id="city" name="city"
                           value="<?php echo set_value('city', $record->city) ?>">
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('city'); ?>
                        <?php echo $validation->getError('city'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" class="form-control" id="state" placeholder="Enter State" name="state"
                           value="<?php echo set_value('state', $record->state) ?>">
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('state'); ?>
                        <?php echo $validation->getError('state'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="zip">Zip</label>
                    <input type="text" class="form-control numericValue" id="zip" name="zip"
                           value="<?php echo set_value('zip', $record->zip) ?>">
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('zip'); ?>
                        <?php echo $validation->getError('zip'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="release_date">Hourly Rate</label>
                    <input type="text" class="form-control decimalValue" id="hourly_rate" name="hourly_rate"
                           value="<?php echo set_value('hourly_rate', $record->hourly_rate) ?>">
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('hourly_rate'); ?>
                        <?php echo $validation->getError('hourly_rate'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="salary">Salary</label>
                    <input type="text" class="form-control decimalValue" id="salary" name="salary"
                           value="<?php echo set_value('salary', $record->salary) ?>">
                    <div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('salary'); ?>
                        <?php echo $validation->getError('salary'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="employee_type">Job Title</label>
                    <select id="job_title" name="job_title" class="form-control" >
                        <option value="super_admin" <?php if ($record->job_title == "super_admin") echo 'selected="selected"'?>>Super Admin</option>
                        <option value="admin" <?php if ($record->job_title == "admin") echo 'selected="selected"'?>>Admin</option>
						<!-- <option value="painter" <?php if ($record->job_title == "painter") echo 'selected="selected"'?>>Painter</option> -->
                    </select>
					<div style="color: red!important; font-family:'Times New Roman'; font-size: 15px;">
						<?php //echo $this->session->flashdata('job_title'); ?>
						<?php echo $validation->getError('job_title'); ?>
					</div>
                </div>

				<h3 class="employee_access_control">"To update Employee Access visit Access Control"</h3>

                <div id="myId" class="fallback dropzone"></div>

                <div class="form-group">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $record->user_id?>">
                </div>
            </div>
        </div>
    </div>
</form>

<div id="delete_confirmation" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 class="modal-title"><strong id="modalTitle">Delete</strong></h4>
            </div>
            <div id="modalBody" class="modal-body">
                <p>You are about to delete this <strong>Employee</strong>. Do you want to proceed?</p>
            </div>
            <div class="modal-footer">
                <a href="#" id="btnYes" class="btn danger">Yes</a>
                <a href="#" data-dismiss="modal" aria-hidden="true" class="btn secondary">No</a>
            </div>
        </div>
    </div>
</div>

<div id="delete_file_confirmation" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 class="modal-title"><strong id="modalTitle">Delete</strong></h4>
            </div>
            <div id="modalBody" class="modal-body">
                <p>You are about to delete this <strong>File</strong>. Do you want to proceed?</p>
            </div>
            <div class="modal-footer">
                <a href="#" id="btnYes" class="btn danger">Yes</a>
                <a href="#" data-dismiss="modal" aria-hidden="true" class="btn secondary">No</a>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>application/assets/js/dropzone.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/required/jquery.mask.min.js"></script>
<script src="<?php echo base_url();?>application/assets/js/required/users.js"></script>
<script>
    var fileUploadUrl = '<?php echo base_url()?>file_storage/file_upload/?id=<?php echo $record->user_id ?>';
    var formType = 'edit';
    var documentRoot = '<?php echo $_SERVER['DOCUMENT_ROOT']?>';
    var chechEmailUrl = '<?php echo base_url();?>employee_center/get_email';
    var deleteFileUrl = '<?php echo base_url();?>employee_center/delete_file';
</script>
<?= $this->endSection()?>