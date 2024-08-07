<div class="authincation h-100">
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-4">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <h4 class="text-center mb-4"><?= lang("App.login_title_recovery") ?></h4>
                                <?= formAlert() ?>
                                <form action="<?=site_url("login/recovery_store")?>" id="sendForm" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="token" value="<?=$token??''?>">
                                    <input type="hidden" name="user" value="<?=$user??''?>">
                                    <div class="form-group">
                                        <label><strong><?= lang("App.login_new_password") ?></strong></label>
                                        <div class="input-group">
                                            <input type="password" id="password" name="password" placeholder="<?= lang("App.login_password_ph") ?>" class="form-control">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-dark" id="btn_pass" onclick="pass()"><i class="far fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-primary btn-block" onclick="load()"><?= lang("App.login_btn_recovery") ?></button>
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