<!--Style-->
<link href="<?=site_url("themes/focus2/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css")?>" rel="stylesheet">
<link href="<?= site_url('assets/vendor/intl-tel-input/build/css/intlTelInput.min.css'); ?>" rel="stylesheet">
<style>
    .input_hidden {
        border: 0;
        clip: rect(0 0 0 0);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width: 1px;
    }
</style>
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
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= $title['page']??'' ?></h4>
                    </div>
                    <div class="card-body">
                        <?= formAlert() ?>
                        <form class="form" action="<?=site_url("profile/store")?>" method="post">
                            <?= csrf_field() ?>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="text-primary"><?=lang("App.profile_msg_desc_1")?></label>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.profile_first_name")?></label>
                                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="<?=lang("App.profile_first_name_ph")?>" value="<?= (isset($obj)) ? $obj['first_name'] : set_value('first_name');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.profile_last_name")?></label>
                                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="<?=lang("App.profile_last_name_ph")?>" value="<?= (isset($obj)) ? $obj['last_name'] : set_value('last_name');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.profile_date_birth")?></label>
                                            <input type="text" class="form-control" placeholder="<?=lang("App.profile_date_birth_ph")?>" id="date_birth" name="date_birth" value="<?= (isset($obj)) ? $obj['date_birth'] : set_value('date_birth');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.profile_email")?></label>
                                            <input type="text" id="email" name="email" class="form-control" placeholder="<?=lang("App.profile_email_ph")?>" value="<?= (isset($obj)) ? $obj['email'] : set_value('email');?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="mobile" class="text-dark"><?=lang("App.profile_mobile")?></label>
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
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="password" class="text-dark"><?=lang("App.profile_password")?></label>
                                            <input type="password" id="password" name="password" class="form-control" placeholder="<?=lang("App.profile_password_ph")?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="confirm_password" class="text-dark"><?=lang("App.profile_confirm_password")?></label>
                                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="<?=lang("App.profile_confirm_password_ph")?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="text-primary"><?=lang("App.profile_msg_desc_2")?></label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.profile_address")?></label>
                                            <input type="text" id="address" name="address" class="form-control" placeholder="<?=lang("App.profile_address_ph")?>" value="<?= (isset($obj)) ? $obj['address'] : set_value('address');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="city" class="text-dark"><?=lang("App.profile_city")?></label>
                                            <input type="text" id="city" name="city" class="form-control" placeholder="<?=lang("App.profile_city_ph")?>" value="<?= (isset($obj)) ? $obj['city'] : set_value('city');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="state" class="text-dark"><?=lang("App.profile_state")?></label>
                                            <input type="text" id="state" name="state" class="form-control" placeholder="<?=lang("App.profile_state_ph")?>" value="<?= (isset($obj)) ? $obj['state'] : set_value('state');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="country" class="text-dark"><?=lang("App.profile_country")?></label>
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
                                            <label for="language" class="text-dark"><?=lang("App.profile_language")?></label>
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
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?=lang("App.profile_subtitle_image")?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 justify-content-center d-flex" >
                                <img src="<?= substr(strtolower($obj['picture']??''), 0, 4) == "http" ? $obj['picture']??'' : site_url($obj['picture']??'')?>" class="btn-circle btn-circle-md">
                            </div>
                            <div class="col-lg-12 text-center mt-3" >
                                <span><b><?= $obj['first_name']??''?></b></span><br>
                                <span><?= $obj['email']??''?></span>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#photoModalCenter"><i class="fas fa-camera"></i> <?=lang("App.profile_change_photo")?></button>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="photoModalCenter">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12 mb-2">
                                                    <h5><?=lang("App.profile_change_image")?></h5>
                                                </div>
                                                <div class="col-lg-3 mt-2">
                                                    <div class="row">
                                                        <div class="col-lg-12 justify-content-center d-flex">
                                                            <form name="form_upload" class="form" action="<?=site_url("profile")?>" enctype="multipart/form-data" method="post">
                                                                <?= csrf_field() ?>
                                                                <input type="file" name="file" id="file" class="input_hidden" onchange="form_upload.submit()" accept="image/*">
                                                                <div class="btn btn-light btn-circle btn-circle-md"><a href="#" class="file-upload"><i class="fas fa-cloud-upload-alt fa-2xl"></i></a></div>
                                                            </form>
                                                        </div>
                                                        <div class="col-lg-12 text-center mt-1" >
                                                            <b><i class="fas fa-upload"></i> <?=strtoupper(lang("App.profile_upload_msg"))?></b>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mt-2">
                                                    <div class="row">
                                                        <div class="col-lg-12 justify-content-center d-flex" >
                                                            <form name="form_not" action="<?=site_url("profile")?>" method="post">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" id="image_not" name="image_not" value="<?=site_url("assets/img/default-user.png")?>">
                                                                <a href="javascript:form_not.submit()"><img src="<?=site_url("assets/img/default-user.png")?>" class="btn-circle btn-circle-md"></a>
                                                            </form>
                                                        </div>
                                                        <div class="col-lg-12 text-center mt-1" >
                                                            <b><i class="fas fa-user-slash"></i> <?=strtoupper(lang("App.profile_no_image_msg"))?></b>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mt-2">
                                                    <div class="row">
                                                        <div class="col-lg-12 justify-content-center d-flex" >
                                                            <form name="form_gravatar" action="<?=site_url("profile")?>" method="post">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" id="image_gravatar" name="image_gravatar" value="https://s.gravatar.com/avatar/<?=MD5($obj['email']??'')?>?s=150">
                                                                <a href="javascript:form_gravatar.submit()"><img src="https://s.gravatar.com/avatar/<?=MD5($obj['email']??'')?>?s=150" class="btn-circle btn-circle-md"></a>
                                                            </form>
                                                        </div>
                                                        <div class="col-lg-12 text-center mt-1" >
                                                            <b><i class="fas fa-user-circle"></i> <?=strtoupper(lang("App.profile_gravatar_msg"))?></b>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php foreach ($oauth??[] as $item) : ?>
                                                    <?php
                                                    $icon = '';
                                                    switch ($item['provider']) {
                                                        case "vkontakte":
                                                            $icon = '<i class="fab fa-vk"></i> ';
                                                            break;
                                                        case "wechat":
                                                            $icon = '<i class="fab fa-weixin"></i> ';
                                                            break;
                                                        default:
                                                            $icon = '<i class="fab fa-'.$item['provider'].'"></i> ';
                                                            break;
                                                    }
                                                    ?>
                                                    <div class="col-lg-3 mt-2">
                                                        <div class="row">
                                                            <div class="col-lg-12 justify-content-center d-flex" >
                                                                <form name="form_<?=$item['provider']??''?>" action="<?=site_url("profile")?>" method="post">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" id="image_<?=$item['provider']??''?>" name="image_<?=$item['provider']??''?>" value="<?=$item['picture']??''?>">
                                                                    <a href="javascript:form_<?=$item['provider']??''?>.submit()"><img src="<?=$item['picture']??''?>" class="btn-circle btn-circle-md"></a>
                                                                </form>
                                                            </div>
                                                            <div class="col-lg-12 text-center mt-1" >
                                                                <b><?=$icon?><?=strtoupper($item['provider']??'')?></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?=lang("App.profile_subtitle_delete")?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 mt-3">
                                <button type="button" class="btn btn-danger btn-block" onclick="delete_user()"><i class="fas fa-times"></i> <?=lang("App.profile_delete_data")?></button>
                                <button type="button" class="btn btn-primary btn-block" onclick="download_data()"><i class="fas fa-download"></i> <?=lang("App.profile_download_data")?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $settings = session()->get('settings'); ?>
        <?php if ($settings['two_factor_auth']) : ?>
            <form name="form_otp" class="form" action="<?=site_url("profile/store")?>" method="post" id="sendFormTFA">
                <?= csrf_field() ?>
                <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mx-0" style="width: 100%;">
                                <div class="col-sm-6 p-md-0">
                                    <h4 class="card-title"><?=lang("App.profile_subtitle_tfa")?></h4>
                                </div>
                                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                                    <div class="custom-control custom-switch ml-2">
                                        <input type="checkbox" id="tfa" name="tfa" class="custom-control-input" onchange="tfaView()" <?=$obj['tfa']??false ?'checked':''?>>
                                        <label for="tfa" class="custom-control-label"><?= lang("App.profile_tfa_msg") ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="otp" style="display: <?=$obj['tfa']??false ?'block':'none'?>">
                                <?php
                                    $tfa = new \App\Libraries\Authenticator();
                                    $name = $obj['first_name']??'';
                                    if($obj['tfa'] && !empty($obj['tfa_secret'])) {
                                        $tfa_secret = $obj['tfa_secret']??'';
                                        $qrcode = $tfa->GetQR("{$settings['title']} ({$name})", $tfa_secret);
                                    } else {
                                        $tfa_secret = $tfa->createSecret();
                                        $qrcode = $tfa->GetQR("{$settings['title']} ({$name})", $tfa_secret);
                                    }
                                ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p><b><?=lang("App.profile_qrcode")?></b></p>
                                        <img src="<?php echo $qrcode; ?>" class="img-responsive">
                                    </div>
                                    <div class="col-lg-6">
                                        <p><b><?=lang("App.profile_backup_code")?></b></p>
                                        <?php
                                        $codes = "";
                                        if(!empty($obj['tfa_code']??'')) {
                                            $codes = explode(',' , $obj['tfa_code']??'');
                                            foreach($codes as $item) {
                                                echo '<span class="badge badge-primary mr-2 mb-1">'.$item.'</span>';
                                            }
                                        }else{
                                            $codes = array();
                                            for($i = 1 ; $i <= 8 ; $i++) {
                                                $code = random_string('numeric', 6);
                                                $codes[] = $code;
                                                echo '<span class="badge badge-primary mr-2 mb-1">'.$code.'</span>';
                                            }
                                        }
                                        ?>
                                        <p class="mt-2"><b><?=lang("App.profile_tfa_secret")?></b><br><b class="text-primary"><?=$tfa_secret?></b></p>
                                        <input type="hidden" id="tfa_secret" name="tfa_secret" value="<?=$tfa_secret?>">
                                        <input type="hidden" id="tfa_code" name="tfa_code" value="<?=implode(',',$codes)?>">
                                        <button type="button" class="btn btn-primary btn-block mt-2" onclick="download('<?=lang("App.profile_qrcode")?>\n<?=implode(",",$codes)?>\n<?=lang("App.profile_tfa_secret")?>\n<?=$tfa_secret?>','backup_codes.txt')"><i class="fas fa-download mr-1"></i> <?=lang("App.profile_tfa_download")?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        <?php endif; ?>
    </div>
</div>
<!-- Required vendors -->
<script src="<?=site_url("themes/focus2/vendor/global/global.min.js")?>">></script>
<script src="<?=site_url("themes/focus2/js/quixnav-init.js")?>">></script>
<script src="<?=site_url("themes/focus2/js/custom.min.js")?>">></script>
<script src="<?=site_url("themes/focus2/vendor/select2/js/select2.full.min.js")?>">></script>
<!-- Alert -->
<script src="<?=site_url("themes/focus2/vendor/sweetalert2/dist/sweetalert2.min.js")?>">></script>
<script src="<?=site_url("themes/focus2/vendor/toastr/js/toastr.min.js")?>">></script>
<!-- Date Range Picker -->
<!-- momment js is must -->
<script src="<?=site_url("themes/focus2/vendor/moment/moment.min.js")?>">></script>
<script src="<?=site_url("themes/focus2/vendor/bootstrap-daterangepicker/daterangepicker.js")?>">></script>
<!-- Material color picker -->
<script src="<?=site_url("themes/focus2/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js")?>">></script>
<script src="<?= site_url('assets/vendor/intl-tel-input/build/js/intlTelInput.min.js'); ?>"></script>
<script src="<?= site_url('assets/vendor/jQuery-Mask-Plugin/dist/jquery.mask.min.js'); ?>"></script>
<!-- Form -->
<script>
    "use strict";
    $(document).ready(function () {
        $('#first_name').focus();
        $("#country").select2();
        $("#language").select2();
        $('#date_birth').bootstrapMaterialDatePicker({
            format: '<?=momentDateJS()?>',
            time: false
        });

        let mobile = document.querySelector("#mobile");
        let iti = window.intlTelInput(mobile, {
            separateDialCode: true,
            placeholderNumberType:"MOBILE",
            utilsScript: "<?= site_url('assets/vendor/intl-tel-input/build/js/utils.js'); ?>"
        });

        mobile.addEventListener('countrychange', function(e) {
            mobile.value = "";

            //Get DDI
            $('#ddi').val("+"+iti.getSelectedCountryData().dialCode);

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

    $('.file-upload').on('click', function(e) {
        e.preventDefault();
        $('#file').trigger('click');
    });

    function download(text, filename){
        let blob = new Blob([text], {type: "text/plain;charset=utf-8"});
        let url = window.URL.createObjectURL(blob);
        let a = document.createElement("a");
        a.href = url;
        a.download = filename;
        a.click();
    }

    function tfaView(){
        document.getElementById("sendFormTFA").submit();
    }

    function delete_user(){
        swal({
            title: "<?=lang("App.user_delete_title")?>",
            text: "<?=lang("App.user_delete_subtitle")?>",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#f34141",
            confirmButtonText: "<?=lang("App.user_delete_btn_ok")?>",
            cancelButtonText: "<?=lang("App.user_delete_btn_cancel")?>",
            closeOnConfirm: !1
        }).then(function(isConfirm) {
            if (isConfirm.value) {
                window.location.href = '<?=site_url("profile/delete")?>';
            }
        })
    }

    function download_data(){
        var a = document.createElement("a");
        var obj = '<?= json_encode($obj) ?>';
        a.href =  'data:text/json;charset=utf-8,'+ obj;
        a.download = "data.json";
        a.click();
    }
</script>
<?= sweetAlert() ?>
