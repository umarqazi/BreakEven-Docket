<!DOCTYPE html>
<style>
    .navbar-header img {
        margin-left: 30px;
        height: 50px !important;
        width: 210px !important;
    }
</style>
<html lang="en" <?php if(!logged_in() == true ){?> class="login_body" <?php } ?>>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Fav and touch icons -->

    <title>BreakEven PRO®</title>


    <!-- Required CSS Files -->

    <!-- Signature CDN Link-->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
	<?= link_tag('css/jquery.signature.css') ?>
	<?= link_tag('css/file_tree/jqueryFileTree.css') ?>
	<?= link_tag('css/datatables/jquery.dataTables.min.css') ?>
	<?= link_tag('css/required/jquery.minicolors.css') ?>
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

</head>

<body <?php if(!logged_in() == true ){?> class="login-bg login_body" <?php } ?>>

<div id="wrapper" class="login_body">

    <?php if(logged_in() == true ){ ?>
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top text-center" role="navigation" style="margin-bottom: 0">


        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= base_url('admin/index')?>">
								<?= img('images/custom-images/logos/BreakEven_DOCKET_horizontal.png') ?></a>
        </div>

        <div class="company_name"><strong><?php echo user()->company_name ?></strong></div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="text-center" href="<?php echo base_url();?>admin/mailbox">
                    <i class="fa fa-envelope fa-fw"></i>
                </a>
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-user fa-fw"></i><?php
                            echo user()->first_name.user()->last_name; ?></a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url();?>login/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>

        <!-- /.navbar-top-links -->

    </nav>

    <div id="page-wrapper" style="margin : 0px ;">

        <div class="clear40"></div>
		<div class="container-fluid">
        <?php } ?>
