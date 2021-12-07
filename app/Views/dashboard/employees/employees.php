<?= $this->extend("master")?>
<?= $this->section("content")?>
<div class="row">
    <div class="col-md-12">
        <div class="block overhead_visible">
            <div class="block-heading add_employee">
                <div class="" id="successMessage">
                    <?= view('App\Auth\_message_block') ?>
                </div>
                <div class="main-text h2">
                    Employee Center
                </div>
                <div class="add_button_employee pull-right">
                    <?php //if (empty($subscription['allowed_users']) || count($records) < $subscription['allowed_users']) {?>
                        <a href="<?php echo base_url();?>/Add-Employee" class="add_employee_button">
                            <button type="button" class="btn btn-primary blue">
                                Add An Employee
                            </button>
                        </a>
                    <?php //}?>
                    <div class="import-drowpdown">
                        <span class="icon-arrow-down"></span>
                        <ul>
							<?php //if (empty($subscription['allowed_users']) || count($records) < $subscription['allowed_users']) {?>
                            <li>
                                <a href="<?php echo base_url()?>/employee_upload_csv" title="Import Employees">
                                    <span class="glyphicon glyphicon-import"></span>Import Employees
                                </a>
                            </li>
							<?php //}?>
                            <li>
                                <a href="<?php echo base_url()?>/export_employees" title="Export Employees">
                                    <span class="glyphicon glyphicon-export"></span>Export Employees
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="block-content-outer">
    <div class="block-content-inner" id="employee_center_table">
        <div class="employees_table">
            <table id="employee_table" class="table table-striped table-hover" style="width: 100%;">
                <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Hire Date</th>
                    <th>Hourly Rate</th>
                    <th><center>Actions</center></th>
                </tr>
                </thead>
                <tbody>
                    <?php if(!empty($employees)){ foreach ($employees as $row): ?>
                        <tr>
                            <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo !empty($row['hire_date']) ? date('j M, Y', strtotime($row['hire_date'])) : ''; ?></td>
                            <td><?php echo $row['hourly_rate']; ?></td>
                            <td>
                                <a class="text-secondry mr-4" href="<?php echo base_url();?>/employee-show/<?php echo $row['id'];
                                ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                            
                                <a class="text-primary mr-4" href="<?php echo base_url();?>/employee-edit/<?php echo $row['id'];
                                ?>"><span class="glyphicon glyphicon-edit"></span></a>
                            
                                <a class="text-danger delete_btn" href="<?php echo base_url() .'/employee-delete/'. $row['id'];
                                ?>" class="delete_btn"><span class="glyphicon glyphicon-trash"></span></a>
                            </td>
                        </tr>
                    <?php endforeach; }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= script_tag('js/datatables/jquery.dataTables.min.js') ?>
<?= script_tag('js/dashboard/employee.js') ?>
<?= $this->endSection()?>