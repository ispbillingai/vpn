<!--Style-->
<link href="<?=site_url("themes/focus2/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css")?>" rel="stylesheet">
<link href="<?= site_url('assets/vendor/intl-tel-input/build/css/intlTelInput.min.css'); ?>" rel="stylesheet">
<!--Content Body-->
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4><i class="<?= $title['icon']??'' ?>"></i> <?= $title['module']??'' ?></h4>
                    <span class="ml-1"><?= $title['page']??'' ?></span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <?php foreach ($breadcrumb??[] as $item) : ?>
                        <?php if (!$item['active']) : ?>
                            <li class="breadcrumb-item"><a href="<?= site_url($item['route']) ?>"><?= $item['title'] ?></a></li>
                        <?php else : ?>
                            <li class="breadcrumb-item active"><?= $item['title'] ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= $title['page']??'' ?></h4>
                    </div>
                    <div class="card-body">
                        <?= formAlert() ?>
                        <form class="form" action="<?=site_url("user/store")?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_user" value="<?= (isset($obj)) ? $obj['id_user'] : set_value('id_user') ?>">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="text-primary"><?=lang("App.user_msg_desc_1")?></label>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.user_field_first_name")?></label>
                                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="<?=lang("App.user_field_first_name_ph")?>" value="<?= (isset($obj)) ? $obj['first_name'] : set_value('first_name');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.user_field_last_name")?></label>
                                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="<?=lang("App.user_field_last_name_ph")?>" value="<?= (isset($obj)) ? $obj['last_name'] : set_value('last_name');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.user_field_email")?></label>
                                            <input type="text" id="email" name="email" class="form-control" placeholder="<?=lang("App.user_field_email_ph")?>" value="<?= (isset($obj)) ? $obj['email'] : set_value('email');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.user_field_date_birth")?></label>
                                            <input type="text" class="form-control" placeholder="<?=lang("App.user_field_date_birth_ph")?>" id="date_birth" name="date_birth" value="<?= (isset($obj)) ? $obj['date_birth'] : set_value('date_birth');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="mobile" class="text-dark"><?=lang("App.user_field_cell")?></label>
                                            <input type="tel" id="mobile" name="mobile" class="form-control" value="<?= (isset($obj)) ? $obj['mobile'] : set_value('mobile');?>">
                                            <?php
                                            $ddi = "";
                                            $number = (isset($obj)) ? $obj['mobile'] : "";
                                            if(!empty($number)){
                                                $split = explode(' ',$number);
                                                if(count($split) > 0){
                                                    $ddi = $split[0];
                                                }
                                            }
                                            ?>
                                            <input type="hidden" name="ddi" id="ddi" value="<?= !empty($ddi) ? $ddi : set_value('ddi');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="password" class="text-dark"><?=lang("App.user_field_password")?></label>
                                            <input type="password" id="password" name="password" class="form-control" placeholder="<?=lang("App.user_field_password_ph")?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="confirm_password" class="text-dark"><?=lang("App.user_field_password_confirm")?></label>
                                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="<?=lang("App.user_field_password_confirm_ph")?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="id_group" class="text-dark"><?=lang("App.user_field_group")?></label>
                                            <?php $id_select = (isset($obj)) ? $obj['group']??[] : set_value('group');?>
                                            <select name="group" id="group" class="form-control">
                                                <?php foreach ($group??[] as $item) : ?>
                                                    <option value="<?=$item['token']??''?>" <?= $id_select == $item['token'] ? 'selected' : '' ?>><?=$item['title']??''?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="email_confirmed" class="text-dark"><?=lang("App.user_field_email_confirmed")?></label>
                                            <?php $id_select = (isset($obj)) ? $obj['email_confirmed']??[] : set_value('email_confirmed');?>
                                            <select name="email_confirmed" id="email_confirmed" class="form-control">
                                                <option value="0" <?= $id_select == "0" ? 'selected' : '' ?>><?=lang("App.user_alert_not_confirmed")?></option>
                                                <option value="1" <?= $id_select == "1" ? 'selected' : '' ?>><?=lang("App.user_alert_confirmed")?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="sms_confirmed" class="text-dark"><?=lang("App.user_field_sms_confirmed")?></label>
                                            <?php $id_select = (isset($obj)) ? $obj['sms_confirmed']??[] : set_value('sms_confirmed');?>
                                            <select name="sms_confirmed" id="sms_confirmed" class="form-control">
                                                <option value="0" <?= $id_select == "0" ? 'selected' : '' ?>><?=lang("App.user_alert_not_confirmed")?></option>
                                                <option value="1" <?= $id_select == "1" ? 'selected' : '' ?>><?=lang("App.user_alert_confirmed")?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="status" class="text-dark"><?=lang("App.user_field_status")?></label>
                                            <?php $id_select = (isset($obj)) ? $obj['status']??[] : set_value('status');?>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" <?= $id_select == "1" ? 'selected' : '' ?>><?=lang("App.global_active")?></option>
                                                <option value="0" <?= $id_select == "0" ? 'selected' : '' ?>><?=lang("App.global_inactive")?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="text-primary"><?=lang("App.user_msg_desc_2")?></label>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.user_field_address")?></label>
                                            <input type="text" id="address" name="address" class="form-control" placeholder="<?=lang("App.user_field_address_ph")?>" value="<?= (isset($obj)) ? $obj['address'] : set_value('address');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="city" class="text-dark"><?=lang("App.user_field_city")?></label>
                                            <input type="text" id="city" name="city" class="form-control" placeholder="<?=lang("App.user_field_city_ph")?>" value="<?= (isset($obj)) ? $obj['city'] : set_value('city');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="state" class="text-dark"><?=lang("App.user_field_state")?></label>
                                            <input type="text" id="state" name="state" class="form-control" placeholder="<?=lang("App.user_field_state_ph")?>" value="<?= (isset($obj)) ? $obj['state'] : set_value('state');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="country" class="text-dark"><?=lang("App.user_field_country")?></label>
                                            <?php $id_select = (isset($obj)) ? $obj['country']??[] : set_value('country');?>
                                            <select name="country" id="country" class="form-control">
                                                <option value=""><?=lang("App.global_select")?></option>
                                                <?php foreach ($country??[] as $item) : ?>
                                                    <option value="<?=$item['code']??''?>" <?= $id_select == $item['code'] ? 'selected' : '' ?>><?=$item['name']??''?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="language" class="text-dark"><?=lang("App.user_field_language")?></label>
                                            <?php $id_select = (isset($obj)) ? $obj['language']??[] : set_value('language');?>
                                            <select name="language" id="language" class="form-control">
                                                <option value=""><?=lang("App.global_select")?></option>
                                                <option value="en" <?= $id_select == "en" ? 'selected' : '' ?>><?=lang("App.lang_en")?></option>
                                                <option value="es" <?= $id_select == "es" ? 'selected' : '' ?>><?=lang("App.lang_es")?></option>
                                                <option value="pt" <?= $id_select == "pt" ? 'selected' : '' ?>><?=lang("App.lang_pt")?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions">
                                <a href="<?= site_url($btn_return['route']??'#') ?>" class="<?= $btn_return['class']??''?>">
                                    <i class="<?= $btn_return['icon']??'' ?>"></i> <?= $btn_return['title']??'' ?>
                                </a>
                                <button type="submit" class="<?= $btn_submit['class']??''?>">
                                    <i class="<?= $btn_submit['icon']??'' ?>"></i> <?= $btn_submit['title']??'' ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Required vendors -->
<script src="<?=site_url("themes/focus2/vendor/global/global.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/js/quixnav-init.js")?>"></script>
<script src="<?=site_url("themes/focus2/js/custom.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/select2/js/select2.full.min.js")?>"></script>
<!-- Date Range Picker -->
<!-- momment js is must -->
<script src="<?=site_url("themes/focus2/vendor/moment/moment.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/bootstrap-daterangepicker/daterangepicker.js")?>"></script>
<!-- Material color picker -->
<script src="<?=site_url("themes/focus2/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js")?>"></script>
<script src="<?= site_url('assets/vendor/intl-tel-input/build/js/intlTelInput.min.js'); ?>"></script>
<script src="<?= site_url('assets/vendor/jQuery-Mask-Plugin/dist/jquery.mask.min.js'); ?>"></script>
<!-- Form -->
<script>
    "use strict";
    $(document).ready(function () {
        $('#first_name').focus();
        $("#group").select2();
        $("#status").select2();
        $("#country").select2();
        $("#language").select2();
        $("#email_confirmed").select2();
        $("#sms_confirmed").select2();
        $('#date_birth').bootstrapMaterialDatePicker({
            format: '<?=momentDateJS()?>',
            time: false
        });

        let mobile = document.querySelector("#mobile");
        let country = $('#country');
        let language = $('#language');
        let ddi = $('#ddi');
        let iti = window.intlTelInput(mobile, {
            separateDialCode: true,
            placeholderNumberType:"MOBILE",
            utilsScript: "<?= site_url('assets/vendor/intl-tel-input/build/js/utils.js'); ?>"
        });

        mobile.addEventListener('countrychange', function(e) {
            mobile.value = "";

            //Get DDI
            ddi.val("+"+iti.getSelectedCountryData().dialCode);

            //Set Country
            let iso = iti.getSelectedCountryData().iso2.toUpperCase()
            country.val(iso);
            country.select2().trigger('change');

            //Set Language
            switch (iso) {
                case 'PT':
                case 'BR':
                case 'AO':
                case 'GQ':
                case 'GW':
                case 'MZ':
                case 'CV':
                case 'ST':
                case 'TL':
                    language.val("pt");
                    break;
                case 'ES':
                case 'AR':
                case 'BO':
                case 'CL':
                case 'CO':
                case 'EC':
                case 'FK':
                case 'GF':
                case 'GY':
                case 'PY':
                case 'PE':
                case 'SR':
                case 'UY':
                case 'VE':
                case 'MX':
                    language.val("es");
                    break;
                default:
                    language.val("en");
            }
            language.select2().trigger('change');

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
</script>
