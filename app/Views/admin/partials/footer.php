
</div>
</div>



<?php if(logged_in() == true ){?>
    <div class="clearfix"></div>

    <div class="dashboard_footer">
            <ul>
                <li>
                    <a href="<?php echo base_url()?>/privacy-policy">Privacy Policy</a>
                </li>
                <li>
                    <a href="<?php echo base_url()?>/terms-service">Terms of Service</a>
                </li>
                <li>
                    <a href="<?php echo base_url()?>/contact-us">Contact US</a>
                </li>
            </ul>
        <p>Copyright 2017 Good Son Industries, LLC All Rights Reserved.</p>
    </div>
<?php } ?>
<!-- Metis Menu Plugin JavaScript -->
<?= script_tag('vendor/metisMenu/metisMenu.min.js') ?>

<!-- Custom Theme JavaScript -->
<?= script_tag('scripts/sb-admin-2.js') ?>
<?= script_tag('scripts/custom.js') ?>
<?= script_tag('js/required/main.js') ?>
<!-- Modal default-modal-->
<?= script_tag('js/required/jquery-ui-1.11.0.custom/jquery-ui.min.js') ?>
<?= script_tag('js/required/bootstrap/bootstrap.min.js') ?>
<?= script_tag('js/required/jquery.easing.1.3-min.js') ?>
<?= script_tag('js/required/jquery.mCustomScrollbar.min.js') ?>
<?= script_tag('js/required/misc/jquery.mousewheel-3.0.6.min.js') ?>
<?= script_tag('js/required/misc/retina.min.js') ?>
<?= script_tag('js/required/icheck.min.js') ?>
<?= script_tag('js/required/misc/jquery.ui.touch-punch.min.js') ?>  
<?= script_tag('js/required/circloid-functions.js') ?>

<!-- Socket Chat -->
<?php //echo script_tag('ocket.io/socket.io.js') ?>
<?php //echo script_tag('js/required/chat.js') ?>

<!-- Optional JS Files -->

<?= script_tag('js/optional/misc/moment.js') ?>
<?= script_tag('js/optional/misc/moment.min.js') ?>
<?= script_tag('js/optional/fullcalendar/fullcalendar.min.js') ?>
<?= script_tag('js/optional/bootstrap-datetimepicker.min.js') ?>
<?= script_tag('js/select2.min.js') ?>

<!-- add optional JS plugin files here -->

<!-- REQUIRED: User Editable JS Files -->
<?= script_tag('js/script.js') ?>
<?= script_tag('js/optional/bootstrapValidator.min.js') ?>
<?= script_tag('js/optional/toastr.js') ?>
<?= script_tag('js/demo-files/pages-signup.js') ?>
<?= script_tag('js/demo-files/pages-mailbox.js') ?>
<?= script_tag('js/demo-files/pages-calendar.js') ?>
</body>
</html>











