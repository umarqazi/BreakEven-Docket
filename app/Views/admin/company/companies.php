<?= $this->extend("admin/admin_master")?>
<?= $this->section("content")?>
<div class="row">
	<div class="col-lg-12">
		<div class="company-index-page">
			<div style="text-align: center">
				<h1>
					<b>COMPANIES</b>
				</h1>
			</div>
            <div class="" id="successMessage">
                <?= view('App\Auth\_message_block') ?>
            </div>
			<div class="block-content-outer">
				<div class="block-content-inner">
					<div class="admin-company-table">
						<table id="datatable-1" class="table table-striped table-hover">
							<thead>
							<tr>
								<th>Company Name</th>
								<th>Owner Name</th>
								<th>Company Email</th>
								<th>Admin Email</th>
								<th>Mobile</th>
								<th>Fax</th>
								<th>Address</th>
								<th>View Full Record</th>
								<th>Enable/Disable</th>
							</tr>
							</thead>
							<tbody>
							<?php 
							if(!empty($companies)){
							foreach ($companies as $row):?>
								<tr>
									<td><?php echo $row['company_name']; ?></td>
									<td><?php echo $row['company_owner']?></td>
									<td><?php echo $row['email']; ?></td>
									<td><?php echo $row['user_email']; ?></td>
									<td><?php echo $row['phone']; ?></td>
									<td><?php echo $row['fax']?></td>
									<td><?php echo $row['address']; ?></td>
									<td>
										<a href="<?php echo base_url();?>/admin/company-details/<?php echo $row['id'];?>"><button
												type="button" class="btn btn-info btn-xs">View Full Record</button></a>
									</td>
									<td>
										<?php if ($row['is_enabled'] == 0){ ?>
											<a href="<?php echo base_url();?>/admin/enable_company/<?php echo $row['id']?>"><button
													type="button" class="btn btn-success btn-xs">Enable</button></a>
										<?php }else{?>
										<a href="<?php echo base_url();?>/admin/disable_company/<?php echo $row['id']?>" class="disable_btn"><button
												type="button" class="btn btn-danger btn-xs">Disable</button></a>
									</td>
									<?php
									}
									?>
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
</div>
<?= script_tag('js/datatables/jquery.dataTables.min.js') ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#datatable-1').DataTable({
			"pagingType": "full_numbers",
			"searching" : true,
			"sort" : false,
			"language" : {search : '', searchPlaceholder: "Search Company"}
		});
		//scroll for table
		$('table').wrap('<div class="table-responsive"></div>');
	});
</script>

<script type='text/javascript'>
	$('.enableOnInput').prop('disabled', true); //TO DISABLED
	$('.enableOnInput').prop('disabled', false); //TO ENABLE
</script>

<script>
	$(document).on('click', '.disable_btn', function (e) {

		e.preventDefault();
		var link = $(this).attr('href');

		swal({
			title: "Are you sure?",
			text: "You Want to Disable this!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
			.then(function(willDelete){
				if (willDelete) {
					window.location.replace(link);
				}
			});
	});
</script>
<?= $this->endSection()?>