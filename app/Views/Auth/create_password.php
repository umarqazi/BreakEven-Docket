<?= $this->extend("master")?>
<?= $this->section("content")?>
<?php if ($user == false) { ?>
    <div id="employee-activation">
        <form id="msform" method="POST" action="<?php echo base_url()?>employee_center/set_password">
            <!-- fieldsets -->
            <fieldset id="set-password">
                <h2 class="fs-title">Wrong Information<b></b></h2>
            </fieldset>
        </form>
    </div>
<?php } else { ?>
    <div id="employee-activation">
        <form id="msform" method="POST" action="<?php echo base_url()?>/set_password">
            <!-- fieldsets -->
            <fieldset id="set-password">
                <div class="" id="successMessage">
                    <?= view('App\Auth\_message_block') ?>
                </div>
                <h2 class="fs-title">Hello <b><?php echo $user['first_name'].' '.$user['last_name']
                        ?></b></h2>
                <h3 class="fs-subtitle">Thankyou for activating your Account<br>Please Set your account password below</h3>
                <input type="password" class="input-value password" name="password"
                    placeholder="Password" required>
                    <p>
                        <?php echo $validation->getError('password'); ?>
                    </p>
                <input type="password" class="input-value confirm_password" onkeyup="empty_password()"
                    name="confirm_password" placeholder="Confirm Password" required  >
                    <p>
                        <?php echo $validation->getError('confirm_password'); ?>
                    </p>
                <div class="password-mismatch"></div>
                <input type="hidden" name="user_id" value="<?php echo $user['id']?>">
                <input type="button" class="btn btn-info submit_button" value="Set Password" onclick="match_password()">
            </fieldset>
    </form>
    </div>
    <script>
        $(document).ready(function () {
            $('.submit_button').prop('disabled', true);
        });

        //confirm password
        function match_password(){
            if($('.password').val() === $('.confirm_password').val()){
                $('.password-mismatch').text('');
                $('.submit_button').prop('disabled', false);
                $('#msform').submit();
            }else{
                $('.password-mismatch').text('Password And Confirm Password Does Not Match');
                $('.submit_button').prop('disabled', true);
            }
        }

        function empty_password() {
            if ($('.confirm_password').val() != ''){
                $('.password-mismatch').text('');
                $('.submit_button').prop('disabled', false);
            } else {
                $('.password-mismatch').text('Please fill out password field');
            }
        }
    </script>
<?php } ?>

<?= $this->endSection()?>