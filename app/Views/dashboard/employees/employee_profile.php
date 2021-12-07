<?= $this->extend("master")?>
<?= $this->section("content")?>
<div class="row">
    <div class="col-md-12">
        <div class="block-content-outer">
            <div class="block-content-inner">
                <h2><strong>Employee Center</strong></h2>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="block-content-outer basic-info">
            <div class="block-content-inner">
                <div class="form-group">
                    <label for="first_name">Employee's First Name</label>
                    <input type="text" class="form-control" id="first_name" value="<?php echo $record->first_name; ?>" name="first_name" readonly="readonly">
                </div>
                <div class="form-group">
                    <label for="last_name">Employee's Last Name</label>
                    <input type="text" class="form-control" id="last_name" value="<?php echo $record->last_name; ?>" name="last_name" readonly="readonly">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" value="<?php echo $record->email; ?>" name="email" readonly="readonly">
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" class="form-control" id="mobile" value="<?php echo $record->mobile; ?>" name="mobile" readonly="readonly">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" value="<?php echo $record->phone; ?>" name="phone" readonly="readonly">
                </div>

                <div class="form-group">
                    <?php
                    if ($record->hire_date !='0000-00-00'){
                        $hire_date= new DateTime($record->hire_date);
                        $hire_date=date_format($hire_date,"m/d/Y");
                    } else {
                        $hire_date = '';
                    }
                    ?>
                    <label for="hire_date">Hire Date</label>
                    <input type="text" class="form-control" id="hire_date" value="<?php echo $hire_date; ?>" name="hire_date" readonly="readonly">
                </div>
                <div class="form-group">
                    <?php
                    if ($record->release_date != '0000-00-00') {
                        $release_date = new DateTime($record->release_date);
                        $release_date = date_format($release_date, "m/d/Y");
                    } else {
                        $release_date = '';
                    }
                    ?>
                    <label for="release_date">Release Date</label>
                    <input type="text" class="form-control" id="release_date" value="<?php echo  $release_date; ?>" name="release_date" readonly="readonly">
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <input type="text" name="notes" id="notes" class="form-control" value="<?php echo $record->notes; ?>" readonly="readonly">
                </div>

                <div class="form-group">
                    <h3>User's Files</h3>
                    <ul class="user_files">
                        <?php //if(count($files)){?>
                            <?php //foreach($files as $file):?>
                                <li><?php //echo $file['file_name']; ?></li>
                            <?php //endforeach; ?>
                        <?php //} else{ ?>
                            <span>No files found for this user</span>
                        <?php //} ?>
                    </ul>
                </div>
                <div class="form-group">
                    <a href="<?= base_url();?>/employee-edit/<?= $record->user_id ;?>" class="edit_employee_button"><button type="button" class="btn btn-primary">Edit Employee </button></a>
                    <a href="<?= base_url();?>/employee-delete/<?= $record->user_id ;?>" class="edit_employee_button delete_btn"><button type="button" class="btn btn-danger">Delete Employee</button></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="block-content-inner">
            <div class="form-group">
                <label for="employee_address">Address</label>
                <input type="text" class="form-control" id="employee_address" value="<?php echo $record->address; ?>" name="address" readonly="readonly">
            </div>
            <div class="form-group">
                <label for="city">City/Town</label>
                <input type="text" class="form-control" id="city" value="<?php echo $record->city; ?>" name="city" readonly="readonly">
            </div>
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" class="form-control" id="state"  name="state" readonly="readonly" value="<?php echo $record->state; ?>">
            </div>
            <div class="form-group">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" id="zip" value="<?php echo $record->zip; ?>" name="zip" readonly="readonly">
            </div>
            <div class="form-group">
                <label for="employee_type">Job Title</label>
                <select id="job_title" name="job_title" class="form-control" disabled>
                    <option value="super_admin" <?php if ($record->job_title == "super_admin") echo 'selected="selected"'?>>Super Admin</option>
                    <option value="admin" <?php if ($record->job_title == "admin") echo 'selected="selected"'?>>Admin</option>
					<!-- <option value="painter" <?php //if ($record['job_title'] == "painter") //echo 'selected="selected"'?>>Painter</option> -->
                </select>
            </div>

            <div class="form-group">
                <label for="release_date">Hourly Rate</label>
                <input type="text" class="form-control" id="release_date" value="$<?php echo $record->hourly_rate; ?>" name="release_date" readonly="readonly">
            </div>
            <div class="form-group">
                <label for="salary">Salary</label>
                <input type="text" class="form-control" id="salary" value="$<?php echo $record->salary;?>" name="salary" readonly="readonly">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection()?>