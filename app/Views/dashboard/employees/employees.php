<?= $this->extend("master")?>
<?= $this->section("content")?>
<div class="row">
    <div class="col-md-12">
        <div class="block overhead_visible">
            <div class="block-heading add_employee">
            <?= view('App\Auth\_message_block') ?>
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
                                <a href="<?php echo base_url()?>employee_center/employee_upload_csv" title="Import Employees">
                                    <span class="glyphicon glyphicon-import"></span>Import Employees
                                </a>
                            </li>
							<?php //}?>
                            <li>
                                <a href="<?php echo base_url()?>employee_center/export_employees" title="Export Employees">
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
<style>
    table {
    display: block;
    overflow-y: scroll;
    }
</style>
<div class="block-content-outer">
    <div class="block-content-inner" id="employee_center_table">
        <div class="employees_table">
            <table id="datatable-1" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Hire Date</th>
                    <th>Hourly Rate</th>
                    <th>View Full Record</th>
                    <th>Edit Record</th>
                    <th>Delete Record</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($employees)){ foreach ($employees as $row):
                    //if(user_id() == $row['id']){?>
                        <?php //if ($row['hire_date']) {?>
                            <?php //$date = new DateTime($row['hire_date']); $date = $date->format('m/d/Y')?>
                        <?php //} else {$date = '';}?>
                        <tr>
                            <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo !empty($row['hire_date']) ? date('j M, Y', strtotime($row['hire_date'])) : ''; ?></td>
                            <td><?php echo $row['hourly_rate']; ?></td>
                            <td>
                                <a href="<?php echo base_url();?>/employee-show/<?php echo $row['id'];
                                ?>"><button type="button" class="btn btn-info btn-xs">View</button></a>
                            </td>
                            <td>
                                <a href="<?php echo base_url();?>/employee-edit/<?php echo $row['id'];
                                ?>"><button type="button" class="btn btn-warning btn-xs">Edit</button></a>
                            </td>
                            <td>
                                <a href="<?php echo base_url() .'/employee-delete/'. $row['id'];
                                ?>" class="delete_btn"><button type="button" class="btn btn-danger
                                            btn-xs">Delete</button></a>
                            </td>
                        </tr>
                    <?php //} 
                    endforeach; }?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="<?php echo base_url()?>application/assets/js/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){
        $('#datatable-1').DataTable({
            "pagingType": "full_numbers",
            bAutoWidth: false,
            "autoWidth": false,
            "searching" : true,
            "sort" : false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language" : {
                search : '',
                searchPlaceholder: "Search Employees",
                "zeroRecords": "No Employee Found!",
                "emptyTable": "No Employee Found!"
            }
        });

        $('table').wrap('<div class="table-responsive"></div>');

        if (msg) {
            swal({
                title: "Great!",
                text: msg,
                icon: "success",
                timer: 2000
            });
        }

        if (employee_limit) {
            swal({
                title: "Error!",
                text: employee_limit,
                icon: "error",
            });
        }

    });
</script>
<?= $this->endSection()?>