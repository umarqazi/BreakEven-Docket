<?php helper('html'); helper('auth');?>
<?= $this->extend("master")?>
<?= $this->section("content")?>
<div class="page-wrapper">
    <div class="page-container">
        <div class="container text-center">

            <div class="form-wrapper">
                <div class="text-center login-logo">
                    <?= img('images/custom-images/logos/signup-logo.png') ?>
                </div>
					<?= view('App\Auth\_message_block') ?>
                    <form action="<?= route_to('login') ?>" method="post">
                    <input type="hidden" name="is_admin" value="1" >
						<?= csrf_field() ?>
						<?php if ($config->validFields === ['email']): ?>
						<div class="form-group">
							<label for="login"><?=lang('Auth.email')?></label>
							<input type="email" class="form-control <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>"
								   name="login" placeholder="<?=lang('Auth.email')?>" required="required">
							<div class="invalid-feedback">
								<?= session('errors.login') ?>
							</div>
						</div>
						<?php else: ?>
						<div class="form-group">
							<label>USER NAME</label>
							<input type="text" class="form-control login_email <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="Email" required="required">
							<div class="invalid-feedback">
								<?= session('errors.login') ?>
							</div>
						</div>
						<?php endif; ?>
						<div class="form-group">
							<label>PASSWORD</label>
							<input type="password" name="password" class="form-control login_password <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="Password" required="required">
							<div class="invalid-feedback">
								<?= session('errors.password') ?>
							</div>
						</div>
						<?php if ($config->allowRemembering): ?>
						<div class="form-check">
							<label class="form-check-label">
								<input type="checkbox" name="remember" class="form-check-input" <?php if(old('remember')) : ?> checked <?php endif ?>>
								<?=lang('Auth.rememberMe')?>
							</label>
						</div>
						<?php endif; ?>
						<!-- <br> -->
						<div class="text-center">
							<button class="btn btn-default" type="submit">Sign In</button>
						</div>
					</form>
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
