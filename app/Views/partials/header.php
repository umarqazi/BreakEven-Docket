<body <?php if(!logged_in() == true ){?> class="login-bg login_body" <?php } ?> >
<style>
	.navbar-header img {
		margin-left: 30px;
		height: 50px !important;
		width: 210px !important;
    }
</style>
<div id="wrapper" class="login_body">
	<?php if(logged_in() == true ){ ?>
	<?php $permissions = service('authorization'); $user_id = user_id();?>
	<!-- Navigation -->
	<nav class="navbar navbar-default navbar-static-top text-center" role="navigation" style="margin-bottom: 0">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo base_url()?>home"><?= img('images/custom-images/logos/BreakEven_DOCKET_horizontal.png') ?></a>
		</div>

		<div class="company_name">
			<strong>
				<?php echo user()->first_name .' '.user()->last_name?>
			</strong>
		</div>

		<ul class="nav navbar-top-links navbar-right">
			<li class="dropdown">
				<a class="text-center" href="<?php echo base_url();?>/mailbox">
					<i class="fa fa-envelope fa-fw"></i>
				</a>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-user">
					<li><a href="<?php echo base_url();?>employee_center/profile"><i class="fa fa-user fa-fw"></i><?php
							echo user()->first_name. ' '. user()->last_name; ?></a>
					</li>
					<li class="divider"></li>
					<li><a href="<?= base_url('logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
					</li>
				</ul>
			</li>
		</ul>
		<div id="handle-sidebar-toggle" class=" sidebar<?php empty($_SESSION['sidebar'])  ?  $_SESSION['sidebar']= 0 : false ; if($_SESSION['sidebar'] == 1){ ?> active-sidebar <?php } ?>  " role="navigation">
			<i id="sidebar-arrow" class="fa fa-arrow-left menu-toggle-btn" onclick="sidebar()"></i>
			<div class="sidebar-nav navbar-collapse">
				<ul class="nav" id="side-menu">
					<li>
						<a href="<?php echo base_url();?>/home">
							<?= img('images/custom-images/nav-icon-1.png') ?>
							<div>Dashboard</div>
						</a>
					</li>
					<?php if($permissions->hasPermission('Control Panel',user_id())){?>
						<li>
							<a href="<?php echo base_url();?>task_manager">
								<?= img('images/custom-images/new-icons/task_manager.png') ?>
								<div class="title">Control Panel</div>
							</a>
						</li>
					<?php } ?>

					<?php if($permissions->hasPermission('Cost Setup',user_id())){?>
						<li class="custom_dropdown_parent">
							<a href="<?php echo base_url();?>cost_setup">
								<?= img('images/custom-images/nav-icon-2.png') ?>
								<div>Cost Setup<sup>TM</sup></div>
							</a>
						</li>
					<?php } ?>

					<?php if($permissions->hasPermission('Docket No',user_id())){?>
						<li>
							<a href="<?php echo base_url();?>/docket-no">
								<?= img('images/custom-images/new-icons/estimate.png') ?>
								<div class="title">Add DOCKET no</div>
							</a>
						</li>
					<?php } ?>

					<?php if($permissions->hasPermission('Dockets',user_id())){?>
						<li>
							<a href="<?php echo base_url();?>/dockets">
								<?= img('images/custom-images/new-icons/side-all-estimate.png') ?>
								<div class="title">DOCKET</div>
							</a>
						</li>
					<?php } ?>

					<?php if($permissions->hasPermission('TimeKEPING',user_id())){ ?>
						<li>
							<a href="<?php echo base_url();?>/time-keeping">
								<?= img('images/custom-images/assemblies.png') ?>
								<div>TimeKEPING</div>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</nav>
	<div id="nav-bottom"></div>
	<div id="page-wrapper" <?php if($_SESSION['sidebar']== 1){ ?> class="active-wrapper" <?php } ?>  >

		<div class="inner-page-dashboard">

		<!-- <div class="clear20"></div> -->
		<div class="clear40"></div>
			<?php } ?>

			<script>
				$(document).ready( function (){
					$.ajax({
						url : '<?php echo base_url()?>chat/getUnSeenMessages',
						type : 'get',
						success : function(response){
							if(response != 0) {
								$('.chat-notification-icon').show();
							}
						}
					});
				});

				function sidebar()
				{
					$(this).toggleClass('fa-arrow-left fa-arrow-right');
					$(".sidebar").toggleClass('active-sidebar');
					$("#page-wrapper").toggleClass('active-wrapper');

					var sidebar = $('#page-wrapper').hasClass('active-wrapper') ? 1 : 0;
					$.ajax({
						url : '<?php echo base_url()?>Welcome/sidebarArrow',
						data : {sidebar : sidebar},
						type : 'post',
						success : function(response){
							if(response == 1) {
								$('#sidebar-arrow').addClass('fa-arrow-right');
								$('#page-wrapper').addClass('active-wrapper');
								$("#handle-sidebar-toggle").addClass('active-sidebar');
							}else {
								$('#sidebar-arrow').removeClass('fa-arrow-right');
							}
						}
					});
				}
			</script>
