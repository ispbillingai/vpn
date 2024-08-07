<div class="authincation h-100">
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-4">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <h4 class="text-center mb-4"><?= lang("App.login_title_otp") ?></h4>
                                <form action="<?=site_url("login/otp")?>" id="sendForm" method="post">
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <label><strong><?= lang("App.login_otp_code") ?></strong></label>
                                        <div><span><?= lang("App.login_otp_span") ?></span></div>
                                        <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                                            <input class="m-2 text-center form-control rounded" type="text" id="pin_1" name="pin_1" maxlength="1" />
                                            <input class="m-2 text-center form-control rounded" type="text" id="pin_2" name="pin_2" maxlength="1" />
                                            <input class="m-2 text-center form-control rounded" type="text" id="pin_3" name="pin_3" maxlength="1" />
                                            <input class="m-2 text-center form-control rounded" type="text" id="pin_4" name="pin_4" maxlength="1" />
                                            <input class="m-2 text-center form-control rounded" type="text" id="pin_5" name="pin_5" maxlength="1" />
                                            <input class="m-2 text-center form-control rounded" type="text" id="pin_6" name="pin_6" maxlength="1" />
                                        </div>
                                    </div>
                                    <div class="text-center mt-1 mb-2">
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
<script src="<?=site_url("themes/focus2/vendor/global/global.min.js")?>"></script>
<script>
    "use strict";
    $(document).ready(function () {
        $('#pin_1').focus();
    });
    document.addEventListener("DOMContentLoaded", function(event) {
        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > *[id]');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('keydown', function(event) {
                    if (event.key === "Backspace") {
                        inputs[i].value = '';
                        if (i !== 0) inputs[i - 1].focus();
                    } else {
                        if (i === inputs.length - 1 && inputs[i].value !== '') {
                            return true;
                        } else if (event.keyCode > 47 && event.keyCode < 58) {
                            inputs[i].value = event.key;
                            if (i !== inputs.length - 1) inputs[i + 1].focus();
                            event.preventDefault();
                        } else if (event.keyCode > 64 && event.keyCode < 91) {
                            inputs[i].value = String.fromCharCode(event.keyCode);
                            if (i !== inputs.length - 1) inputs[i + 1].focus();
                            event.preventDefault();
                        } else if (event.keyCode > 95 && event.keyCode < 106) {
                            inputs[i].value = event.key;
                            if (i !== inputs.length - 1) inputs[i + 1].focus();
                            event.preventDefault();
                        }
                        if(i === 5){
                            load();
                        }
                    }
                });
            }
        }
        OTPInput();
    });
</script>