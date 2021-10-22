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
	<?php //$permissions = $this->load->get_var('permissions');?>
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
				<?php
				//$company = $this->load->get_var('company');
				//echo $company['company_name'];
				?>
			</strong>
		</div>
		<!-- /.navbar-header -->

		<ul class="nav navbar-top-links navbar-right">
			<li class="dropdown">
				<a class="text-center" href="<?php echo base_url();?>mailbox">
					<i class="fa fa-envelope fa-fw"></i>
				</a>
			</li>
			<!-- /.dropdown -->
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
				<!-- /.dropdown-user -->
			</li>
			<!-- /.dropdown -->
		</ul>
		<!-- /.navbar-top-links -->
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

					<?php // if(in_array("cost_setup", $permissions)){?>
						<li class="custom_dropdown_parent">
							<a href="<?php echo base_url();?>cost_setup">
								<?= img('images/custom-images/nav-icon-2.png') ?>
								<div>Cost Setup<sup>TM</sup></div>
							</a>
						</li>
					<?php //} ?>

					<?php //if(in_array("get_estimate", $permissions)){?>
						<li>
							<a href="<?php echo base_url();?>estimating/create">
								<?= img('images/custom-images/new-icons/estimate.png') ?>
								<div class="title">Estimating</div>
							</a>
						</li>
					<?php //} ?>

					<?php //if(in_array("all_estimates", $permissions)){?>
						<li>
							<a href="<?php echo base_url();?>estimating/estimates">
								<?= img('images/custom-images/new-icons/side-all-estimate.png') ?>
								<div class="title">All Estimates</div>
							</a>
						</li>
					<?php //} ?>

					<?php //if(in_array("assemblies", $permissions)){?>
						<li>
							<a href="<?php echo base_url();?>estimating">
								<?= img('images/custom-images/assemblies.png') ?>
								<div>Assemblies</div>
							</a>
						</li>
					<?php //} ?>

					<?php //if(in_array("task_manager", $permissions)){?>
						<li>
							<a href="<?php echo base_url();?>task_manager">
								<?= img('images/custom-images/new-icons/task_manager.png') ?>
								<div class="title">Task Manager</div>
							</a>
						</li>
					<?php //} ?>

					<?php //if(in_array("chat", $permissions)){?>
						<li>
							<a href="<?php echo base_url();?>chat">
								<?= img('images/custom-images/new-icons/chat.png') ?>
								<span class="chat-notification-icon"></span>
								<div class="title">Chat</div>
							</a>
						</li>
					<?php //} ?>

				</ul>
			</div>
			<!-- /.sidebar-collapse -->
		</div>
		<!-- /.navbar-static-side -->

	</nav>
	<div id="nav-bottom"></div>
	<div id="page-wrapper" <?php if($_SESSION['sidebar']== 1){ ?> class="active-wrapper" <?php } ?>  >

		<div class="inner-page-dashboard">

		<div class="clear20"></div>
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
