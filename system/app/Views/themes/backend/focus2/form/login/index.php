<div class="authincation h-100">
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-4">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <a href="<?= site_url('login'); ?>"  class="justify-content-center mb-4"></a>
                                <h4 class="text-center mb-2">
                                    <img id="logo" alt=""><br>
                                </h4>
                                <h4 class="text-center mb-4">
                                    <?= lang("App.login_title") ?>
                                </h4>
                                <div class="row mb-4">
                                    <div class="col-xl-12 text-center">
                                        <?php foreach($oauth??[] as $item): ?>
                                            <a href="<?= site_url('oauth/'.$item['provider']); ?>" class="btn <?=$item['btn_class'] ?> mt-1 mr-1"><i class="<?=$item['icon_class']?> <?=$item['show_text']?'mr-2':'fa-2x' ?> "></i><?=$item['show_text']?$item['btn_text']:'' ?></a>
                                        <?php endforeach; ?>
                                    </div><i class="fa-2x"></i>
                                </div>
                                <form action="<?= site_url('login/authenticate'); ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <label><strong><?= lang("App.login_email") ?></strong></label>
                                        <input type="email" id="email" name="email" placeholder="<?= lang("App.login_email_ph") ?>" class="form-control" value="">
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?= lang("App.login_password") ?></strong></label>
                                        <div class="input-group">
                                            <input type="password" id="password" name="password" placeholder="<?= lang("App.login_password_ph") ?>" class="form-control" value="">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-dark" id="btn_pass" onclick="pass()"><i class="far fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                                <?php if($settings['remember_me']??false): ?>
                                                    <div class="custom-control custom-switch ml-2">
                                                        <input type="checkbox" id="remember" name="remember" class="custom-control-input">
                                                        <label for="remember" class="custom-control-label"><?= lang("App.login_remember_me") ?></label>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group">
                                                <?php if($settings['forgot_password']??false): ?>
                                                    <a href="<?= site_url('login/forgot_password'); ?>"><?= lang("App.login_forgot_password") ?></a>
                                                <?php endif; ?>
                                            </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-access btn-primary btn-block"><?= lang("App.login_access") ?></button>
                                    </div>
                                    <?php if($settings['captcha_login']??false): ?>
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if($settings['registration']??false): ?>
                    <h6 class="text-center mt-4 text-dark"><?= lang("App.login_signup_desc") ?> <a href="<?= site_url('login/signup'); ?>" class="text-primary"><?= lang("App.login_signup") ?></a></h6>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    "use strict";
    let theme = localStorage.getItem("theme");
    if(theme === "dark"){
        document.getElementById("logo").src="<?= site_url('themes/focus2/images/logo-full-dark.png'); ?>";
    }else{
        document.getElementById("logo").src="<?= site_url('themes/focus2/images/logo-full.png'); ?>";
    }
</script>

