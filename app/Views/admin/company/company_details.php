<?= $this->extend("admin/admin_master")?>
<?= $this->section("content")?>
<div class="block-content-outer clearfix">
	<div class="row">
		<div class="col-md-6">
			<div class=" panel-primary">
				<div class="panel-heading company_heading">
					<h3 class="panel-title"><i class="icon icon-info"></i>Company Profile</h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover table-condensed company_info">
							<tbody>
							<tr>
								<td class="other-stats-number">
									<strong>Company Name</strong>
								</td>
								<td class="other-stats-text">
									<?php
										echo $company[0]['company_name'];
									?>
								</td>
							</tr>
							<tr>
								<td class="other-stats-number">
									<strong>Owner</strong>
								</td>
								<td class="other-stats-text">
									<?php
										echo $company[0]['company_owner'];
									?>
								</td>
							</tr>

							<tr>
								<td class="other-stats-number">
									<strong>Address</strong>
								</td>
								<td class="other-stats-text">
									<?php
										echo $company[0]['address'];
									?>
								</td>
							</tr>

							<tr>
								<td class="other-stats-number">
									<strong>Phone</strong>
								</td>
								<td class="other-stats-text">
									<?php
										echo $company[0]['phone'];
									?>
								</td>
							</tr>

							<tr>
								<td class="other-stats-number">
									<strong>Company Email</strong>
								</td>
								<td class="other-stats-text">
									<a href="#" >
										<?php
											echo $company[0]['email'];
										?>
									</a>
								</td>
							</tr>
							<tr>
								<td class="other-stats-number">
									<strong>Admin Email</strong>
								</td>
								<td class="other-stats-text">
									<a href="#" >
										<?php
											echo $company[0]['user_email'];
										?>
									</a>
								</td>
							</tr>
							<tr>
								<td class="other-stats-number">
									<strong>Total Users</strong>
								</td>
								<td class="other-stats-text">
									<?php
										if ($users == 0){
											echo "No User Yet";
										}else{
											echo $users;
										}
									?>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class=" panel-primary">
				<div class="panel-heading company_heading">
					<h3 class="panel-title"><i class="icon icon-credit-card"></i>subscription info</h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover table-condensed company_info">
							<tbody>

							<tr>
								<td class="other-stats-number">
									<strong>Renew Date</strong>
								</td>
								<td class="other-stats-text">

									<?php
										$renew_date= new DateTime($company[0]['renew_date']);
										$subscription_date=new DateTime($company[0]['subscription_start_date']);
										$renew_date=$subscription_date->modify('+1 month');
										$renew_date=date_format($renew_date,"m/d/Y");
										echo  $renew_date;
									?>

								</td>
							</tr>

							<tr>
								<td class="other-stats-number">
									<strong>Subscription Start Date</strong>
								</td>
								<td class="other-stats-text">
									<?php
										$subscription_date=new DateTime($company[0]['subscription_start_date']);
										$subscription_date=date_format($subscription_date,"m/d/Y");
										echo $subscription_date;
									?>

								</td>
							</tr>

							<tr>
								<td class="other-stats-number">
									<strong>Renew Cost</strong>
								</td>
								<td class="other-stats-text">
									<?php
										echo $company[0]['renew_cost'];
									?>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection()?>