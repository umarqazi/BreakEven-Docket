<?= $this->extend("master")?>
<?= $this->section("content")?>
<div class="row">
    <div class=" col-md-12">
        <div class="" id="successMessage">
            <?= view('App\Auth\_message_block') ?>
        </div>
    </div>
</div>

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
                                    <?php echo $company['company_name']; ?>
                                </td>
                            </tr>

                            <tr>

                                <td class="other-stats-number">
                                    <strong>Owner</strong>
                                </td>
                                <td class="other-stats-text">
                                    <?php echo $company['company_owner']; ?>
                                </td>
                            </tr>

                            <tr>

                                <td class="other-stats-number">
                                    <strong>Phone</strong>
                                </td>
                                <td class="other-stats-text">
                                    <?php echo $company['phone']; ?>
                                </td>
                            </tr>
                            <tr>

                                <td class="other-stats-number">
                                    <strong>Company Email</strong>
                                </td>
                                <td class="other-stats-text">
                                    <a href="#" >
                                        <?php echo $company['email']; ?>
                                    </a>
                                </td>
                            </tr>

                            <tr>

                                <td class="other-stats-number">
                                    <strong>Address</strong>
                                </td>
                                <td class="other-stats-text">
                                    <?php echo $company['address'] ?>
                                </td>
                            </tr>

                            <tr>

                                <td class="other-stats-number">
                                    <strong>City</strong>
                                </td>
                                <td class="other-stats-text">
                                    <?php echo $company['city'] ?>
                                </td>
                            </tr>

                            <tr>

                                <td class="other-stats-number">
                                    <strong>State</strong>
                                </td>
                                <td class="other-stats-text">
                                    <?php echo $company['state'] ?>
                                </td>
                            </tr>

                            <tr>

                                <td class="other-stats-number">
                                    <strong>Zip</strong>
                                </td>
                                <td class="other-stats-text">
                                    <?php echo $company['zip'] ?>
                                </td>
                            </tr>

                            <tr>

                                <td class="other-stats-number">
                                    <strong>Total Users</strong>
                                </td>
                                <td class="other-stats-text">
                                    <?php
										if ($users == 0){
											echo "No User";
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
                                    $renew_date= new DateTime($company['renew_date']);
                                    $subscription_date=new DateTime($company['subscription_start_date']);
                                    $renew_date=$subscription_date->modify('+1 month');
                                    $renew_date=date_format($renew_date,"m/d/Y");
                                    // echo  $renew_date;
                                    echo !is_null($renew_date) ? date('j M, Y.', strtotime($renew_date)) : '';
                                    ?>
                                </td>
                            </tr>

                            <tr>

                                <td class="other-stats-number">
                                    <strong>Subscription Start Date</strong>
                                </td>
                                <td class="other-stats-text">
                                    <?php
                                    // $subscription_date=new DateTime($company['subscription_start_date']);
                                    // $subscription_date=date_format($subscription_date,"m/d/Y");
                                    // echo $subscription_date; 
                                    echo !is_null($company['subscription_start_date']) ? date('j M, Y.', strtotime($company['subscription_start_date'])) : '';
                                    ?>
                                </td>
                            </tr>

                            <tr>

                                <td class="other-stats-number">
                                    <strong>Renew Cost</strong>
                                </td>
                                <td class="other-stats-text">
                                    <?php echo $company['renew_cost']; ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group company-logo">
                        <div class="upload_img">
                            <div class="image_holder">
                                <div class="img_inner">
                                    <?php if (!empty($company['company_logo'])){?>
                                             <img src="<?php echo base_url()?>/uploads/company_images/<?= $company['company_logo'] ?>">
                                    <?php }else{ ?>
                                        <p style="text-align: center">Logo Here</p>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12">

        </div>


        <div class="col-md-12 edit_profile_btn">
            <a href="<?php echo base_url();?>/company-edit" class="edit_employee_button">
                <button type="button" class="btn btn-primary">
                    EDIT PROFILE
                    <span class="glyphicon glyphicon glyphicon-edit"></span>
                </button>
			</a>

			<!--	Suspend Button		-->
			<a href="<?php echo base_url();?>/suspend-company" class="edit_employee_button disable_btn">
				<button type="button" class="btn btn-danger">
					Suspend Company
				</button>
			</a>
        </div>

    </div>
</div>
<?= $this->endSection()?>