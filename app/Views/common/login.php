<?= $this->extend("master")?>
<?= $this->section("content")?>
<div class="page-wrapper login_page">
    <div class="page-container">
        <div class="container text-center">
            <div class="form-wrapper">
                <div class="text-center login-logo">
                    <img src="<?php echo base_url()?>application/assets/images/custom-images/logos/signup-logo.png">
                </div>


                <form role="form" action="<?php echo base_url();?>login/validate" method="post" class="login_form form-horizontal" id="login_form">
                    <div class="form-group">
                        <label>USER NAME</label>
                        <input class="form-control login_email" placeholder="Email" type="email" name="email" required="required">
                    </div>
                    <div class="form-group">
                        <label>PASSWORD</label>
                        <input type="password" class="form-control login_password" placeholder="Password"
                               name="password" required="required">
                    </div>

                    <div class="">
                        <a href="login/forget_email" class="">Forgot Password?</a>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-default" type="submit">Sign In</button>
                    </div>
                </form>

                <div class="text-center links">
                    <a href="<?php echo base_url()?>company/register">Register Your Company</a>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        $("#successMessage").hide('blind', {}, 500)
    }, 5000);
</script>
<?= $this->endSection()?>