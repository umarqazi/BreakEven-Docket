<?= $this->extend("admin/admin_master")?>
<?= $this->section("content")?>
<style>
	.btn{
		min-width: 65px !important;
	}
</style>
<div class="row">
	<div class="col-lg-1">
	</div>
	<div class="col-lg-10">
		<div class="block">
			<div class="block-heading add_employee">
				<div class="main-text h2">
					SUBSCRIPTIONS
				</div>
				<div class="add_button_employee pull-right">
					<a href="<?php echo base_url();?>/admin/create-plans" class="add_employee_button">
						<button type="button" class="btn btn-primary">
							Add A Subscription
						</button>
					</a>
				</div>
			</div>
		</div>
		<div class="" id="successMessage">
			<?= view('App\Auth\_message_block') ?>
		</div>

		<div class="block-content-outer">
			<div class="block-content-inner">
				<div class="table-responsive">
					<table id="datatable-1" class="table table-striped table-hover">
						<thead>
						<tr>
							<th>Name</th>
							<th>Price</th>
							<th>Allowed Users</th>
							<th>Header</th>
							<th>Body</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
						<?php
                        if(!empty($subscriptions)){
                        foreach ($subscriptions as $row):?>
							<tr>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['price']; ?></td>
								<td><?php echo $row['allowed_users'] ? $row['allowed_users']: 'Unlimited'?> Users</td>
								<td><?php echo $row['header_color']?></td>
								<td><?php echo $row['body_color']?></td>
								<td>
									<a href="<?php echo base_url();?>/admin/subscription-edit/<?php echo $row['id'];?>"><button class="btn btn-primary">Edit</button></a>
									<a href="<?php echo base_url();?>/admin/subscription-delete/<?php echo $row['id'];?>" class="delete_btn"><button class="btn btn-danger">Delete</button></a>
								</td>
							</tr>
						<?php 
                        endforeach; 
                        } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</div>



<?= script_tag('js/datatables/jquery.dataTables.min.js') ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#datatable-1').DataTable({
			"pagingType": "full_numbers",
			"searching" : true,
			"sort" : false,
			"language" : {search : '', searchPlaceholder: "Search"}
		});
	});


	var subscription_added = '<?php //echo $this->session->flashdata('SubscriptionAdded'); ?>';
	var subscription_edited = '<?php //echo $this->session->flashdata('SubscriptionUpdated'); ?>';
	var subscription_deleted = '<?php //echo $this->session->flashdata('SubscriptionDeleted'); ?>';
	var subscription_failed = '<?php //echo $this->session->flashdata('SubscriptionFailed'); ?>';
	var msg = '';
	if (subscription_added){
		msg = subscription_added;
	} else if (subscription_edited){
		msg = subscription_edited;
	} else {
		msg = subscription_deleted;
	}

	if (msg) {
		swal({
			title: "Great!",
			text: msg,
			icon: "success",
			timer: 2000
		});
	} else if (subscription_failed) {
		swal({
			title: "Error!",
			text: subscription_failed,
			icon: "error",
		});
	}
</script>
<?= $this->endSection()?>