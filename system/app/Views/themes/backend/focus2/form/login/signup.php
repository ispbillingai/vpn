<link href="<?= site_url('assets/vendor/intl-tel-input/build/css/intlTelInput.min.css'); ?>" rel="stylesheet">
<div class="authincation h-100">
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-4">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <h4 class="text-center mb-4"><?= lang("App.login_title_signup") ?></h4>
                                <?= formAlert() ?>
                                <form action="<?=site_url("login/store")?>" id="sendForm" method="post">
                                    <?= csrf_field() ?>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label><strong><?= lang("App.login_first_name") ?></strong></label>
                                                <input type="text" name="first_name" id="first_name" placeholder="<?= lang("App.login_first_name_ph") ?>" class="form-control" value="<?= set_value('first_name') ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label><strong><?= lang("App.login_last_name") ?></strong></label>
                                                <input type="text" name="last_name" id="last_name" placeholder="<?= lang("App.login_last_name_ph") ?>" class="form-control" value="<?= set_value('last_name') ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label><strong><?= lang("App.login_email") ?></strong></label>
                                                <input type="email" name="email" id="email" placeholder="<?= lang("App.login_email_ph") ?>" class="form-control" value="<?= set_value('email') ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label><strong><?= lang("App.login_mobile") ?></strong></label>
                                                <div class="input-group">
                                                    <input type="tel" name="mobile" id="mobile" class="form-control" value="<?= set_value('mobile') ?>">
                                                    <input type="hidden" name="city" id="city" value="<?= set_value('city') ?>">
                                                    <input type="hidden" name="state" id="state" value="<?= set_value('state') ?>">
                                                    <input type="hidden" name="country" id="country" value="<?= set_value('country') ?>">
                                                    <input type="hidden" name="ddi" id="ddi" value="<?= set_value('ddi') ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label><strong><?= lang("App.login_password") ?></strong></label>
                                                <div class="input-group">
                                                    <input type="password" id="password" name="password" placeholder="<?= lang("App.login_password_ph") ?>" class="form-control" value="<?= set_value('password') ?>">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-dark" id="btn_pass" onclick="pass()"><i class="far fa-eye"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($settings['terms_conditions']??false): ?>
                                        <div class="col-lg-12 d-flex justify-content-between">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch ml-2">
                                                    <input type="checkbox" id="accept" name="accept" class="custom-control-input" <?= set_value('accept')=='on'?'checked':''?>>
                                                    <label for="accept" class="custom-control-label"><?= lang("App.login_accept_terms") ?></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <a href="javascript:void(0)" data-toggle="modal" data-target=".terms-conditions-modal-lg"><?= lang("App.login_read_terms") ?></a>
                                            </div>
                                            <div class="modal fade terms-conditions-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?= lang("App.login_terms_use") ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body"><?= html_entity_decode($settings['terms_conditions_text']??'');?></div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal"><?= lang("App.login_closed") ?></button>
                                                            <button type="button" class="btn btn-primary" onclick="accepted()"><?= lang("App.login_accept") ?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($settings['captcha_register']??false): ?>
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
                                        <button type="button" class="btn btn-primary btn-block" onclick="validate()"><?= lang("App.login_register") ?></button>
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
<script src="<?= site_url('assets/vendor/jQuery/jquery-3.6.1.min.js'); ?>"></script>
<script src="<?= site_url('assets/vendor/intl-tel-input/build/js/intlTelInput.min.js'); ?>"></script>
<script src="<?= site_url('assets/vendor/jQuery-Mask-Plugin/dist/jquery.mask.min.js'); ?>"></script>
<script>
    "use strict";
    $(document).ready(function($) {
        let mobile = document.querySelector("#mobile");
        let iti = window.intlTelInput(mobile, {
            initialCountry: "auto",
            separateDialCode: true,
            placeholderNumberType:"MOBILE",
            geoIpLookup: function(callback) {
                fetch('https://ipapi.co/json/')
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        let countryCode = (data && data.country) ? data.country : "us";
                        $('#city').val((data && data.city) ? data.city : "");
                        $('#state').val((data && data.region) ? data.region : "");
                        $('#ddi').val((data && data.country_calling_code) ? data.country_calling_code : "");
                        $('#country').val((data && data.country) ? data.country : "");
                        callback(countryCode);
                    });
            },
            utilsScript: "<?= site_url('assets/vendor/intl-tel-input/build/js/utils.js'); ?>"
        });

        mobile.addEventListener('countrychange', function(e) {
            mobile.value = "";

            //Get DDI and Country
            $('#ddi').val("+"+iti.getSelectedCountryData().dialCode);
            $('#country').val(iti.getSelectedCountryData().iso2);

            //Set Mask
            let activePlaceholder = mobile.placeholder;
            let newMask = activePlaceholder.replace(/[1-9]/g, "0");
            $('#mobile').mask(newMask);
        });

        mobile.addEventListener('open:countrydropdown', function(e) {
            $('#mobile').unmask();
        });

        mobile.addEventListener('close:countrydropdown', function(e) {
            //Set Mask
            let activePlaceholder = mobile.placeholder;
            let newMask = activePlaceholder.replace(/[1-9]/g, "0");
            $('#mobile').mask(newMask);
        });
    });

    function validate(){
        if(<?= $settings['terms_conditions']??0 ?> === 1){
            if(document.getElementById('accept').checked === true){
               load();
            }else{
                toastr.error('<?= lang("App.login_alert_terms") ?>','<?= lang("App.login_alert") ?>!',{positionClass: 'toast-top-center'})
            }
        }else{
            load();
        }
    }
</script>
