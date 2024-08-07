<div class="authincation h-100">
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-4">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <h4 class="text-center mb-4"><?= lang("App.login_title_forgot_password") ?></h4>
                                <?= formAlert() ?>
                                <form action="<?=site_url("integration/reset_password")?>" id="sendForm" method="post">
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <label><strong><?= lang("App.login_email") ?></strong></label>
                                        <input type="email" name="email" id="email" placeholder="<?= lang("App.login_email_ph") ?>" class="form-control" value="">
                                    </div>
                                    <?php if($settings['captcha_recovery']??false): ?>
                                        <?php if($settings['captcha_gateway'] == 'recaptcha'): ?>
                                            <div class="text-center mt-2">
                                                <div class="g-recaptcha" style="display: inline-block" data-sitekey="<?=$settings['captcha_site_key']??''?>"></div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($settings['captcha_gateway'] == 'hcaptcha'): ?>
                                            <div class="text-center mt-2">
                                                <div class="h-captcha" style="display: inline-block" data-sitekey="<?=$settings['captcha_site_key']??''?>"></div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-primary btn-block" onclick="load()"><?= lang("App.login_request") ?></button>
                                    </div>
                                    <div class="text-center mt-1">
                                        <button type="button" class="btn btn-dark btn-block" onclick="window.location.href = '<?=site_url("login")?>';"><?= lang("App.login_come_back") ?></button>
                                    </div>
                                    <p class="text-primary" id="msg" style="display: none;"><i class="fas fa-spinner fa-pulse"></i> <?= lang("App.login_wait") ?></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>