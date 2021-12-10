<?= $this->extend("master")?>
<?= $this->section("content")?>
<div class="col-md-12" >
    <div class="" id="successMessage">
        <?= view('App\Auth\_message_block') ?>
    </div>
</div>
<div class="col-md-1">
</div>
<div class="col-md-10">
    <h2 class="heading-text">
        <a class="btn btn-primary pull-right" href="<?= route_to('add-permissions') ?>" style="font-size: 12px; margin:0px 4px 4px 0px" >Add Permissions</a>
    </h2>

    <table class="table table-bordered" id="permissions_table">
        <thead class="dark_blue ">
            <tr style="color:white !important">
                <th>Employee Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php if(!empty($employees)){ ?>
        <?php foreach ($employees as $employee):?>
        <tbody>
            <tr>
                <td class="col-sm-4"><?php echo $employee['first_name'].' '.$employee['last_name']; ?></td>
                <td class="col-sm-8">
                    <button class="btn btn-success" data-toggle="modal" data-target="#full-modal" onclick="get_employee_permissions(<?php echo $employee['user_id']?>);">
                        View Permissions
                    </button>
                </td>
            </tr>
        </tbody>
        <?php endforeach;?>
        <?php }?>
    </table>
</div>
<div class="modal fade full-modal" id="full-modal" tabindex="-1" role="dialog" aria-labelledby="full-modal-label" aria-hidden="true">
	<form role="form" id="checkbox-form" method="post" action="<?= route_to('assign_permissions'); ?>">
		<input type="hidden" name="user_id" value="" id="user_id">
		<div class="modal-dialog">
			<div class="modal-content" data-border-top="multi">
				<div class="modal-body">
                    <?php //dd($authorize->hasPermission(2,5)); ?>
					<ul class="access_control_checkboxes permission_listing">
                        
					</ul>
                </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save Changes</button>
				</div>
			</div>
		</div>
	</form>
</div>
<?= script_tag('js/datatables/jquery.dataTables.min.js') ?>
<?= script_tag('js/dashboard/access_control.js') ?>
<?= $this->endSection()?>