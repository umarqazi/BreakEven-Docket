<!DOCTYPE html>
<?php helper('html'); helper('auth');?>
<html lang="en" <?php if(!logged_in() == true){?> class="login_body" <?php   } ?> >
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Cache-control" content="no-cache">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="-1"/>
	<!-- Fav and touch icons -->

	<title>BreakEven PRO®</title>


	<!-- Required CSS Files -->

	<!-- Signature CDN Link-->
	<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
	<?= link_tag('css/jquery.signature.css') ?>
	<?= link_tag('css/file_tree/jqueryFileTree.css') ?>
	<?= link_tag('css/datatables/jquery.dataTables.min.css') ?>
	<?= link_tag('css/required/bootstrap/bootstrap.min.css') ?>
	<?= link_tag('js/required/jquery-ui-1.11.0.custom/jquery-ui.min.css') ?>
	<?= link_tag('css/optional/fullcalendar/fullcalendar.min.css') ?>
	<?= link_tag('css/optional/timeline/component.css') ?>
	<?= link_tag('css/demo-files/pages-timeline.css') ?>
	<?= link_tag('css/demo-files/pages-mailbox.css') ?>
	<?= link_tag('css/fancybox/jquery.fancybox.min.css') ?>
	<?= link_tag('css/file-upload/jquery.fileupload.css') ?>
	<?= link_tag('css/dropzone.min.css') ?>
	<?= link_tag('css/flipclock/flipclock.css') ?>
	<?= link_tag('css/required/icheck/all.css') ?>
	<!-- More Required CSS Files -->
	<?= link_tag('css/styles-core.css') ?>
	<?= link_tag('css/styles-core-responsive.css') ?>
	<?= link_tag('css/chat.css') ?>
	<?= link_tag('css/font-awesome.min.css') ?>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<?= link_tag('js/required/misc/ie10-viewport-bug-workaround.js') ?>
	<!--JavaScript Files -->
	<?= script_tag('js/required/jquery-3.2.1.min.js') ?>
	<?= link_tag('vendor/metisMenu/metisMenu.min.css') ?>
	<?= link_tag('dist/css/sb-admin-2.css') ?>
	<?= link_tag('vendor/font-awesome/css/font-awesome.min.css') ?>

	<?= link_tag('styles/responsive.css') ?>
	<?= link_tag('fonts/metrize-icons/styles-metrize-icons.css') ?>

	<?= link_tag('js/docsupport/prism.css') ?>
	<?= link_tag('css/chosen.css') ?>
	<?= link_tag('css/custom.css') ?>

	<?= link_tag('css/required/mCustomScrollbar/jquery.mCustomScrollbar.min.css') ?>


	<!-- Optional CSS Files -->
	<?= link_tag('css/fullcalendar/fullcalendar.css') ?>
	<?= link_tag('css/optional/fullcalendar/circloid-fullcalendar.css') ?>
	<?= link_tag('css/fullcalendar/fullcalendar.print.css') ?>
	<?= link_tag('css/optional/bootstrap-datetimepicker.min.css') ?>
	<?= link_tag('css/optional/bootstrap-tagsinput.min.css') ?>
	<?= link_tag('css/optional/toastr.css') ?>
	<?= link_tag('css/select2.min.css') ?>

	<!-- Sweet Alert Notifications-->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script>

		$( document ).ready(function() {

			$(".sidebar-nav").addClass('menu_hide');
			$(".navbar-toggle").click(function(){
				$(".sidebar-nav").removeClass('menu_hide');
			});

		});
	</script>
	<style>
		.sidebar, #page-wrapper{
			transition: all ease-in-out 0.4s;
			-ms-transition: all ease-in-out 0.4s ;
			-webkit-transition: all ease-in-out 0.4s;
			-moz-transition: all ease-in-out 0.4s;
			-o-transition: all ease-in-out 0.4s;
		}
		#page-wrapper {
			height: 100%;
			min-height: 100vh;
			background-color: #f3f3f3;
		}
		.inner-page-dashboard{
			/*overflow: hidden;*/
			padding: 0px 15px;
		}
		@media (min-width: 768px) {

			/*.login_body{
				overflow: hidden;
			}*/
			.inner-page-dashboard{
				padding: 0px 40px;
			}
			#page-wrapper {
				position: relative;
				margin: 0 0;
				padding:0 0;
				border-left: 1px solid #e7e7e7;
				width: calc(100% - 250px);
				float:right;
			}
			#page-wrapper.active-wrapper{
				margin-left: 0px;
				width: calc(100%);
			}
			i#sidebar-arrow {
				top: 0px;
			}
			.sidebar {
				z-index: 1;
				position: absolute;
				width: 250px;
				top: 59px;
				left:0px;
				/*background: #293870;*/
				height: 100vh;
			}
			.sidebar.active-sidebar {
				left: -250px;
			}
			.navbar-top-links .dropdown-messages,
			.navbar-top-links .dropdown-tasks,
			.navbar-top-links .dropdown-alerts {
				margin-left: auto;
			}
		}
	</style>

</head>