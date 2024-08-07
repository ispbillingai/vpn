<!--Style-->
<link href="<?=site_url("themes/focus2/vendor/summernote/summernote.css")?>" rel="stylesheet">
<link href="<?=site_url("themes/focus2/vendor/highlightjs/styles/vs2015.css")?>" rel="stylesheet">
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
        <form class="form" id="settingsForm" action="<?=site_url("settings/store")?>" method="post">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="nav flex-column nav-pills">
                                        <a href="#v-pills-all" data-toggle="pill" class="nav-link active show"><i class="fas fa-sitemap"></i> <?=lang("App.settings_label_general")?></a>
                                        <a href="#v-pills-email" data-toggle="pill" class="nav-link"><i class="fas fa-envelope"></i> <?=lang("App.settings_label_email")?></a>
                                        <a href="#v-pills-sms" data-toggle="pill" class="nav-link"><i class="fas fa-sms"></i> <?=lang("App.settings_label_sms")?></a>
                                        <a href="#v-pills-captcha" data-toggle="pill" class="nav-link"><i class="fas fa-robot"></i> <?=lang("App.settings_label_captcha")?></a>
                                        <a href="#v-pills-auth" data-toggle="pill" class="nav-link"><i class="fas fa-user-lock"></i> <?=lang("App.settings_label_auth")?></a>
                                        <a href="#v-pills-storage" data-toggle="pill" class="nav-link"><i class="fas fa-hdd"></i> <?=lang("App.settings_label_storage")?></a>
                                        <a href="#v-pills-backup" data-toggle="pill" class="nav-link"><i class="fas fa-database"></i> <?=lang("App.settings_label_backup")?></a>
                                        <a href="#v-pills-register" data-toggle="pill" class="nav-link"><i class="fas fa-user-plus"></i> <?=lang("App.settings_label_register")?></a>
                                        <a href="#v-pills-notification" data-toggle="pill" class="nav-link"><i class="fas fa-bell"></i> <?=lang("App.settings_label_notification")?></a>
                                        <a href="#v-pills-api" data-toggle="pill" class="nav-link"><i class="fas fa-link"></i> <?=lang("App.settings_label_api")?></a>
                                        <a href="#v-pills-customization" data-toggle="pill" class="nav-link"><i class="fas fa-paint-roller"></i> <?=lang("App.settings_label_customization")?></a>
                                        <a href="#v-pills-logs" data-toggle="pill" class="nav-link"><i class="fas fa-user-clock"></i> <?=lang("App.settings_label_logs")?></a>
                                        <a href="#v-pills-cron" data-toggle="pill" class="nav-link"><i class="fas fa-history"></i> <?=lang("App.settings_label_cron")?></a>
                                    </div>
                                </div>
                                <div class="col-xl-9">
                                    <div class="tab-content">
                                        <div id="v-pills-all" class="tab-pane fade active show">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-xl-12 mb-2">
                                                        <h5><?=lang("App.settings_label_general_title")?></h5>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label class="text-primary"><?=lang("App.settings_label_general_subtitle_1")?></label>
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <div class="form-group">
                                                            <label class="text-dark"><?=lang("App.settings_field_title")?></label>
                                                            <input type="text" id="title" name="title" class="form-control" placeholder=<?=lang("App.settings_field_title_ph")?>" value="<?= (isset($obj)) ? $obj['title'] : set_value('title');?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="text-dark"><?=lang("App.settings_field_frontend")?></label>
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" id="activate_frontend" name="activate_frontend" class="custom-control-input" <?= $obj['activate_frontend']??false ? 'checked' : ''?>>
                                                                <label for="activate_frontend" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="text-dark"><?=lang("App.settings_field_seo_description")?></label>
                                                            <textarea class="form-control" id="seo_description" name="seo_description" rows="3"><?= (isset($obj)) ? $obj['seo_description'] : set_value('seo_description');?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="text-dark"><?=lang("App.settings_field_seo_keywords")?></label>
                                                            <textarea class="form-control" id="seo_keywords" name="seo_keywords" rows="3"><?= (isset($obj)) ? $obj['seo_keywords'] : set_value('seo_keywords');?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label class="text-primary"><?=lang("App.settings_label_general_subtitle_2")?></label>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label for="default_language" class="text-dark"><?=lang("App.settings_field_default_language")?></label>
                                                            <?php $id_select = (isset($obj)) ? $obj['default_language'] : set_value('default_language');?>
                                                            <select name="default_language" id="default_language" class="form-control">
                                                                <option value="en" <?= $id_select == "en" ? 'selected' : '' ?>><?=lang("App.lang_en")?></option>
                                                                <option value="es" <?= $id_select == "es" ? 'selected' : '' ?>><?=lang("App.lang_es")?></option>
                                                                <option value="pt" <?= $id_select == "pt" ? 'selected' : '' ?>><?=lang("App.lang_pt")?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label for="default_role" class="text-dark"><?=lang("App.settings_field_default_role")?></label>
                                                            <?php $id_select = (isset($obj)) ? $obj['default_role'] : set_value('default_role');?>
                                                            <select name="default_role" id="default_role" class="form-control">
                                                                <?php foreach($group??[] as $item): ?>
                                                                    <option value="<?=$item['token']?>" <?= $id_select == $item['token'] ? 'selected' : '' ?>><?=$item['title']?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label for="default_date_format" class="text-dark"><?=lang("App.settings_field_default_date_format")?></label>
                                                            <?php $id_select = (isset($obj)) ? $obj['default_date_format'] : set_value('default_date_format');?>
                                                            <select name="default_date_format" id="default_date_format" class="form-control">
                                                                <option value="Y-m-d" <?= $id_select == "Y-m-d" ? 'selected' : '' ?>>Y-m-d</option>
                                                                <option value="d-m-Y" <?= $id_select == "d-m-Y" ? 'selected' : '' ?>>d-m-Y</option>
                                                                <option value="d/m/Y" <?= $id_select == "d/m/Y" ? 'selected' : '' ?>>d/m/Y</option>
                                                                <option value="m-d-Y" <?= $id_select == "m-d-Y" ? 'selected' : '' ?>>m-d-Y</option>
                                                                <option value="m/d/Y" <?= $id_select == "m/d/Y" ? 'selected' : '' ?>>m/d/Y</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label for="default_hour_format" class="text-dark"><?=lang("App.settings_field_default_hour_format")?></label>
                                                            <?php $id_select = (isset($obj)) ? $obj['default_hour_format'] : set_value('default_hour_format');?>
                                                            <select name="default_hour_format" id="default_hour_format" class="form-control">
                                                                <option value="24" <?= $id_select == "24" ? 'selected' : '' ?>>24h</option>
                                                                <option value="12" <?= $id_select == "12" ? 'selected' : '' ?>>12h</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="default_timezone" class="text-dark"><?=lang("App.settings_field_default_timezone")?></label>
                                                            <?php $id_select = (isset($obj)) ? $obj['default_timezone'] : set_value('default_timezone');?>
                                                            <select name="default_timezone" id="default_timezone" class="form-control">
                                                                <?php foreach($timezone??[] as $item): ?>
                                                                    <option value="<?=$item['timezone']?>" <?= $id_select == $item['timezone'] ? 'selected' : '' ?>><?=$item['description']?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="default_currency" class="text-dark"><?=lang("App.settings_field_default_currency")?></label>
                                                            <?php $id_select = (isset($obj)) ? $obj['default_currency'] : set_value('default_currency');?>
                                                            <select name="default_currency" id="default_currency" class="form-control">
                                                                <?php foreach($currency??[] as $item): ?>
                                                                    <option value="<?=$item['code']?>" <?= $id_select == $item['code'] ? 'selected' : '' ?>><?=$item['code']?> - <?=$item['name']?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="default_currency_separation" class="text-dark"><?=lang("App.settings_field_default_currency_separation")?></label>
                                                            <?php $id_select = (isset($obj)) ? $obj['default_currency_separation'] : set_value('default_currency_separation');?>
                                                            <select name="default_currency_separation" id="default_currency_separation" class="form-control">
                                                                <option value="dot" <?= $id_select == "dot" ? 'selected' : '' ?>><?=lang("App.settings_field_default_currency_separation_dot")?></option>
                                                                <option value="comma" <?= $id_select == "comma" ? 'selected' : '' ?>><?=lang("App.settings_field_default_currency_separation_coma")?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label for="default_currency_position" class="text-dark"><?=lang("App.settings_field_default_currency_position")?></label>
                                                            <?php $id_select = (isset($obj)) ? $obj['default_currency_position'] : set_value('default_currency_position');?>
                                                            <select name="default_currency_position" id="default_currency_position" class="form-control">
                                                                <option value="left" <?= $id_select == "left" ? 'selected' : '' ?>><?=lang("App.settings_field_default_currency_position_left")?></option>
                                                                <option value="right" <?= $id_select == "right" ? 'selected' : '' ?>><?=lang("App.settings_field_default_currency_position_right")?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label for="default_country" class="text-dark"><?=lang("App.settings_field_default_country")?></label>
                                                            <?php $id_select = (isset($obj)) ? $obj['default_country'] : set_value('default_country');?>
                                                            <select name="default_country" id="default_country" class="form-control">
                                                                <?php foreach($countries??[] as $item): ?>
                                                                    <option value="<?=$item['code']?>" <?= $id_select == $item['code'] ? 'selected' : '' ?>><?=$item['name']?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label for="default_theme" class="text-dark"><?=lang("App.settings_field_default_theme")?></label>
                                                            <?php $id_select = (isset($obj)) ? $obj['default_theme'] : set_value('default_theme');?>
                                                            <select name="default_theme" id="default_theme" class="form-control">
                                                                <?php foreach($theme??[] as $item): ?>
                                                                    <?php if ($item['type'] == "backend") : ?>
                                                                        <option value="<?=$item['id_theme']?>" <?= $id_select == $item['id_theme'] ? 'selected' : '' ?>><?=$item['name']?></option>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label for="default_theme_front" class="text-dark"><?=lang("App.settings_field_default_theme_front")?></label>
                                                            <select name="default_theme_front" id="default_theme_front" class="form-control">
                                                                <?php foreach($theme??[] as $item): ?>
                                                                    <?php if ($item['type'] == "frontend") : ?>
                                                                        <option value="<?=$item['id_theme']?>" <?= $id_select == $item['id_theme'] ? 'selected' : '' ?>><?=$item['name']?></option>
                                                                    <?php endif; ?>                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="v-pills-email" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-xl-12 mb-2">
                                                    <h5><?=lang("App.settings_label_email_title")?></h5>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_email_subtitle_1")?></label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="email_gateway" class="text-dark"><?=lang("App.settings_field_email_gateway")?></label>
                                                                    <?php $id_select = (isset($obj)) ? $obj['email_gateway'] : set_value('email_gateway');?>
                                                                    <select name="email_gateway" id="email_gateway" class="form-control">
                                                                        <option value="smtp" <?= $id_select == "smtp" ? 'selected' : '' ?>><?=lang("App.settings_field_email_gateway_smtp")?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_email_smtp")?></label>
                                                                    <input type="text" id="email_smtp" name="email_smtp" class="form-control" placeholder="<?=lang("App.settings_field_email_smtp_ph")?>" value="<?= (isset($obj)) ? $obj['email_smtp'] : set_value('email_smtp');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_email_port")?></label>
                                                                    <input type="number" id="email_port" name="email_port" class="form-control" placeholder="<?=lang("App.settings_field_email_port_ph")?>" value="<?= (isset($obj)) ? $obj['email_port'] : set_value('email_port');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_email_name")?></label>
                                                                    <input type="text" id="email_name" name="email_name" class="form-control" placeholder="<?=lang("App.settings_field_email_name_ph")?>" value="<?= (isset($obj)) ? $obj['email_name'] : set_value('email_name');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_email_address")?></label>
                                                                    <input type="text" id="email_address" name="email_address" class="form-control" placeholder="<?=lang("App.settings_field_email_address_ph")?>" value="<?= (isset($obj)) ? $obj['email_address'] : set_value('email_address');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_email_pass")?></label>
                                                                    <input type="password" id="email_pass" name="email_pass" class="form-control" placeholder="<?=lang("App.settings_field_email_pass_ph")?>" value="<?= (isset($obj)) ? $obj['email_pass'] : set_value('email_pass');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="email_cert" class="text-dark"><?=lang("App.settings_field_email_cert")?></label>
                                                                    <?php $id_select = (isset($obj)) ? $obj['email_cert'] : set_value('email_cert');?>
                                                                    <select name="email_cert" id="email_cert" class="form-control">
                                                                        <option value="none" <?= $id_select == "none" ? 'selected' : '' ?>><?=lang("App.settings_field_email_cert_none")?></option>
                                                                        <option value="ssl" <?= $id_select == "ssl" ? 'selected' : '' ?>><?=lang("App.settings_field_email_cert_ssl")?></option>
                                                                        <option value="tls" <?= $id_select == "tls" ? 'selected' : '' ?>><?=lang("App.settings_field_email_cert_tls")?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_field_test_send")?></label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_email_address")?></label>
                                                                    <div class="input-group">
                                                                        <input type="email" id="send_email_test" name="send_email_test" class="form-control" placeholder="<?=lang("App.settings_field_email_address_ph")?>">
                                                                        <div class="input-group-append">
                                                                            <button type="button" class="btn btn-primary" onclick="send_test()"><?=lang("App.settings_field_test_send_btn")?></button>
                                                                        </div>
                                                                    </div>
                                                                    <p class="text-primary" id="msg_email_test" style="display: none;"><i class="fas fa-spinner fa-pulse"></i> <?= lang("App.login_wait") ?></p>
                                                                </div>
                                                                <label class="text-danger"><?=lang("App.settings_field_send_mail")?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div id="v-pills-sms" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-xl-12 mb-2">
                                                    <h5><?=lang("App.settings_label_sms_title")?></h5>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_sms_subtitle_1")?></label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="sms_gateway" class="text-dark"><?=lang("App.settings_field_sms_gateway")?></label>
                                                                    <?php $id_select = (isset($obj)) ? $obj['sms_gateway'] : set_value('sms_gateway');?>
                                                                    <select name="sms_gateway" id="sms_gateway" class="form-control">
                                                                        <option value="twilio" <?= $id_select == "twilio" ? 'selected' : '' ?>><?=lang("App.settings_field_sms_gateway_twilio")?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-9">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_sms_account_id")?></label>
                                                                    <input type="text" id="sms_account_id" name="sms_account_id" class="form-control" placeholder="<?=lang("App.settings_field_sms_account_id_ph")?>" value="<?= (isset($obj)) ? $obj['sms_account_id'] : set_value('sms_account_id');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_sms_auth_token")?></label>
                                                                    <input type="text" id="sms_auth_token" name="sms_auth_token" class="form-control" placeholder="<?=lang("App.settings_field_sms_auth_token_ph")?>" value="<?= (isset($obj)) ? $obj['sms_auth_token'] : set_value('sms_auth_token');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_sms_info_add")?></label>
                                                                    <input type="text" id="sms_info_add" name="sms_info_add" class="form-control" placeholder="<?=lang("App.settings_field_sms_info_add_ph")?>" value="<?= (isset($obj)) ? $obj['sms_info_add'] : set_value('sms_info_add');?>">
                                                                    <p><?=lang("App.settings_field_sms_obs")?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="v-pills-captcha" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-xl-12 mb-2">
                                                    <h5><?=lang("App.settings_label_captcha_title")?></h5>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_captcha_subtitle_1")?></label>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="sms_gateway" class="text-dark"><?=lang("App.settings_field_captcha_gateway")?></label>
                                                                    <?php $id_select = (isset($obj)) ? $obj['captcha_gateway'] : set_value('captcha_gateway');?>
                                                                    <select name="captcha_gateway" id="captcha_gateway" class="form-control">
                                                                        <option value="recaptcha" <?= $id_select == "recaptcha" ? 'selected' : '' ?>><?=lang("App.settings_field_captcha_gateway_recaptcha")?></option>
                                                                        <option value="hcaptcha" <?= $id_select == "hcaptcha" ? 'selected' : '' ?>><?=lang("App.settings_field_captcha_gateway_hcaptcha")?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_captcha_site_key")?></label>
                                                                    <input type="text" id="captcha_site_key" name="captcha_site_key" class="form-control" placeholder="<?=lang("App.settings_field_captcha_site_key_ph")?>" value="<?= (isset($obj)) ? $obj['captcha_site_key'] : set_value('captcha_site_key');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_captcha_secret_key")?></label>
                                                                    <input type="text" id="captcha_secret_key" name="captcha_secret_key" class="form-control" placeholder="<?=lang("App.settings_field_captcha_secret_key_ph")?>" value="<?= (isset($obj)) ? $obj['captcha_secret_key'] : set_value('captcha_secret_key');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_captcha_subtitle_2")?></label>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_captcha_register")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="captcha_register" name="captcha_register" class="custom-control-input" <?= $obj['captcha_register']??false ? 'checked' : ''?>>
                                                                        <label for="captcha_register" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_captcha_login")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="captcha_login" name="captcha_login" class="custom-control-input" <?= $obj['captcha_login']??false ? 'checked' : ''?>>
                                                                        <label for="captcha_login" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_captcha_recovery")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="captcha_recovery" name="captcha_recovery" class="custom-control-input" <?= $obj['captcha_recovery']??false ? 'checked' : ''?>>
                                                                        <label for="captcha_recovery" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="v-pills-auth" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-xl-12 mb-2">
                                                    <h5><?=lang("App.settings_label_auth_title")?></h5>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_auth_subtitle_1")?></label>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_two_factor_auth")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="two_factor_auth" name="two_factor_auth" class="custom-control-input" <?= $obj['two_factor_auth']??false ? 'checked' : ''?>>
                                                                        <label for="two_factor_auth" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_auth_subtitle_2")?></label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_throttle_auth")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="throttle_auth" name="throttle_auth" class="custom-control-input" <?= $obj['throttle_auth']??false ? 'checked' : ''?>>
                                                                        <label for="throttle_auth" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_throttle_auth_max_attempts")?></label>
                                                                    <input type="number" id="throttle_auth_max_attempts" min="1" name="throttle_auth_max_attempts" class="form-control" placeholder="<?=lang("App.settings_field_throttle_auth_max_attempts_ph")?>" value="<?= (isset($obj)) ? $obj['throttle_auth_max_attempts'] : set_value('throttle_auth_max_attempts');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_throttle_auth_lockour_time")?></label>
                                                                    <div class="input-group">
                                                                        <input type="number" id="throttle_auth_lockour_time" name="throttle_auth_lockour_time" class="form-control" placeholder="<?=lang("App.settings_field_throttle_auth_lockour_time_ph")?>" value="<?= (isset($obj)) ? $obj['throttle_auth_lockour_time'] : set_value('throttle_auth_lockour_time');?>">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><?=lang("App.global_hours")?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="v-pills-storage" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-xl-12 mb-2">
                                                    <h5><?=lang("App.settings_label_storage_title")?></h5>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_storage_subtitle_1")?></label>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="storage_gateway" class="text-dark"><?=lang("App.settings_field_storage_gateway")?></label>
                                                                    <?php $id_select = (isset($obj)) ? $obj['storage_gateway'] : set_value('storage_gateway');?>
                                                                    <select name="storage_gateway" id="storage_gateway" class="form-control">
                                                                        <option value="local" <?= $id_select == "local" ? 'selected' : '' ?>><?=lang("App.settings_field_storage_gateway_local")?></option>
                                                                        <option value="aws" <?= $id_select == "aws" ? 'selected' : '' ?>><?=lang("App.settings_field_storage_gateway_aws")?></option>
                                                                        <option value="minio" <?= $id_select == "minio" ? 'selected' : '' ?>><?=lang("App.settings_field_storage_gateway_minio")?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_storage_subtitle_2")?></label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_aws_key")?></label>
                                                                    <input type="text" id="aws_key" min="1" name="aws_key" class="form-control" placeholder="<?=lang("app.settings_field_aws_key_ph")?>" value="<?= (isset($obj)) ? $obj['aws_key'] : set_value('aws_key');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_aws_secret")?></label>
                                                                    <input type="text" id="aws_secret" min="1" name="aws_secret" class="form-control" placeholder="<?=lang("app.settings_field_aws_secret_ph")?>" value="<?= (isset($obj)) ? $obj['aws_secret'] : set_value('aws_secret');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_aws_region")?></label>
                                                                    <input type="text" id="aws_region" min="1" name="aws_region" class="form-control" placeholder="<?=lang("app.settings_field_aws_region_ph")?>" value="<?= (isset($obj)) ? $obj['aws_region'] : set_value('aws_region');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_aws_bucket")?></label>
                                                                    <input type="text" id="aws_bucket" min="1" name="aws_bucket" class="form-control" placeholder="<?=lang("app.settings_field_aws_bucket_ph")?>" value="<?= (isset($obj)) ? $obj['aws_bucket'] : set_value('aws_bucket');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_aws_endpoint")?></label>
                                                                    <input type="text" id="aws_endpoint" min="1" name="aws_endpoint" class="form-control" placeholder="<?=lang("app.settings_field_aws_endpoint_ph")?>" value="<?= (isset($obj)) ? $obj['aws_endpoint'] : set_value('aws_endpoint');?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="v-pills-backup" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-xl-12 mb-2">
                                                    <h5><?=lang("App.settings_label_backup_title")?></h5>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_backup_subtitle_1")?></label>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="backup_storage" class="text-dark"><?=lang("App.settings_field_backup_storage")?></label>
                                                                    <?php $id_select = (isset($obj)) ? $obj['backup_storage'] : set_value('backup_storage');?>
                                                                    <select name="backup_storage" id="backup_storage" class="form-control">
                                                                        <option value="local" <?= $id_select == "local" ? 'selected' : '' ?>><?=lang("App.settings_field_storage_gateway_local")?></option>
                                                                        <option value="aws" <?= $id_select == "aws" ? 'selected' : '' ?>><?=lang("App.settings_field_storage_gateway_aws")?></option>
                                                                        <option value="minio" <?= $id_select == "minio" ? 'selected' : '' ?>><?=lang("App.settings_field_storage_gateway_minio")?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="backup_table" class="text-dark"><?=lang("App.settings_field_backup_table")?></label>
                                                                    <?php $select = (isset($obj)) ? $obj['backup_table'] : set_value('backup_table');?>
                                                                    <select name="backup_table[]" id="backup_table" multiple="multiple">
                                                                        <?php
                                                                            $select = explode(',',$select);
                                                                            foreach($select??[] as $id_select){
                                                                                if ($id_select == "all"){
                                                                                    $all = 'selected';
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <option value="all" <?=$all??''?>><?=lang("App.settings_field_backup_table_all")?></option>
                                                                        <?php foreach ($tables??[] as $item) : ?>
                                                                            <?php foreach ($select??[] as $id_select) : ?>
                                                                                <?php
                                                                                    if ($id_select == $item){
                                                                                        $selItem = 'selected';
                                                                                    }
                                                                                ?>
                                                                            <?php endforeach; ?>
                                                                            <option value="<?=$item?>" <?=$selItem??''?>><?=lang("App.settings_field_backup_table")?> (<?=$item?>)</option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="backup_time" class="text-dark"><?=lang("App.settings_field_backup_time")?></label>
                                                                    <?php $id_select = (isset($obj)) ? $obj['backup_time'] : set_value('backup_time');?>
                                                                    <select name="backup_time" id="backup_time" class="form-control">
                                                                        <?php for ($i = 0; $i <= 23; $i++) : ?>
                                                                            <option value="<?= $i < 10 ? '0'.$i.':00:00':$i.':00:00' ?>" <?= $id_select == "<?= $i < 10 ? '0'.$i.':00:00':$i.':00:00' ?>" ? 'selected' : '' ?>><?= $i < 10 ? '0'.$i.':00':$i.':00' ?></option>
                                                                            <option value="<?= $i < 10 ? '0'.$i.':30:00':$i.':30:00' ?>" <?= $id_select == "<?= $i < 10 ? '0'.$i.':30:00':$i.':30:00' ?>" ? 'selected' : '' ?>><?= $i < 10 ? '0'.$i.':30':$i.':30' ?></option>
                                                                        <?php endfor; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_backup_email")?></label>
                                                                    <input type="text" id="backup_email" min="1" name="backup_email" class="form-control" placeholder="<?=lang("App.settings_field_backup_email_ph")?>" value="<?= (isset($obj)) ? $obj['backup_email'] : set_value('backup_email');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_backup_notification_email")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="backup_notification_email" name="backup_notification_email" class="custom-control-input" <?= $obj['backup_notification_email']??false ? 'checked' : ''?>>
                                                                        <label for="backup_notification_email" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_backup_automatic")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="backup_automatic" name="backup_automatic" class="custom-control-input" <?= $obj['backup_automatic']??false ? 'checked' : ''?>>
                                                                        <label for="backup_automatic" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 text-right">
                                                                <a href="<?=site_url("integration/create_backup/1")?>" class="btn btn-primary mt-2"><i class="fas fa-download"></i> <?=lang("App.settings_label_backup_btn_1")?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="v-pills-register" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-xl-12 mb-2">
                                                    <h5><?=lang("App.settings_label_register_title")?></h5>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_register_subtitle_1")?></label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_registration")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="registration" name="registration" class="custom-control-input" <?= $obj['registration']??false ? 'checked' : ''?>>
                                                                        <label for="registration" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_remember_me")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="remember_me" name="remember_me" class="custom-control-input" <?= $obj['remember_me']??false ? 'checked' : ''?>>
                                                                        <label for="remember_me" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_forgot_password")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="forgot_password" name="forgot_password" class="custom-control-input" <?= $obj['forgot_password']??false ? 'checked' : ''?>>
                                                                        <label for="forgot_password" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_terms_conditions")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="terms_conditions" name="terms_conditions" class="custom-control-input" <?= $obj['terms_conditions']??false ? 'checked' : ''?>>
                                                                        <label for="terms_conditions" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_email_confirmation")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="email_confirmation" name="email_confirmation" class="custom-control-input" <?= $obj['email_confirmation']??false ? 'checked' : ''?>>
                                                                        <label for="email_confirmation" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_sms_confirmation")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="sms_confirmation" name="sms_confirmation" class="custom-control-input" <?= $obj['sms_confirmation']??false ? 'checked' : ''?>>
                                                                        <label for="sms_confirmation" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_send_welcome_message")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="send_email_welcome" name="send_email_welcome" class="custom-control-input" <?= $obj['send_email_welcome']??false ? 'checked' : ''?>>
                                                                        <label for="send_email_welcome" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_send_welcome_message_sms")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="send_sms_welcome" name="send_sms_welcome" class="custom-control-input" <?= $obj['send_sms_welcome']??false ? 'checked' : ''?>>
                                                                        <label for="send_sms_welcome" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_terms_conditions_text")?></label>
                                                                    <textarea class="form-control" id="terms_conditions_text" name="terms_conditions_text" rows="3"><?= (isset($obj)) ? $obj['terms_conditions_text'] : set_value('terms_conditions_text');?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="v-pills-notification" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-xl-12 mb-2">
                                                    <h5><?=lang("App.settings_label_notification_title")?></h5>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_notification_subtitle_1")?></label>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="send_user_register" class="text-dark"><?=lang("App.settings_field_send_user_register")?></label>
                                                                    <?php $id_select = (isset($obj)) ? $obj['send_user_register'] : set_value('send_user_register');?>
                                                                    <select name="send_user_register" id="send_user_register" class="form-control">
                                                                        <?php foreach($user??[] as $item): ?>
                                                                            <option value="<?=$item['token']?>" <?= $id_select == $item['token'] ? 'selected' : '' ?>><?=$item['first_name']?> - <?=$item['email']?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_send_email_register")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="send_email_register" name="send_email_register" class="custom-control-input" <?= $obj['send_email_register']??false ? 'checked' : ''?>>
                                                                        <label for="send_email_register" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_send_sms_register")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="send_sms_register" name="send_sms_register" class="custom-control-input" <?= $obj['send_sms_register']??false ? 'checked' : ''?>>
                                                                        <label for="send_sms_register" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_send_notification_register")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="send_notification_register" name="send_notification_register" class="custom-control-input" <?= $obj['send_notification_register']??false ? 'checked' : ''?>>
                                                                        <label for="send_notification_register" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_send_pusher_notification_register")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="pusher_enable" name="pusher_enable" class="custom-control-input" <?= $obj['pusher_enable']??false ? 'checked' : ''?>>
                                                                        <label for="pusher_enable" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 mt-2">
                                                                <label class="text-primary"><?=lang("App.settings_label_notification_subtitle_2")?></label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.pusher_appId")?></label>
                                                                    <input type="text" id="pusher_appId" name="pusher_appId" class="form-control" placeholder="Digite o App ID" value="<?= (isset($obj)) ? $obj['pusher_appId'] : set_value('pusher_appId');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.pusher_key")?></label>
                                                                    <input type="text" id="pusher_key" name="pusher_key" class="form-control" placeholder="Digite a Chave Publica" value="<?= (isset($obj)) ? $obj['pusher_key'] : set_value('pusher_key');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.pusher_secret")?></label>
                                                                    <input type="text" id="pusher_secret" name="pusher_secret" class="form-control" placeholder="Digite a Chave Secreta" value="<?= (isset($obj)) ? $obj['pusher_secret'] : set_value('pusher_secret');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.pusher_cluster")?></label>
                                                                    <input type="text" id="pusher_cluster" name="pusher_cluster" class="form-control" placeholder="Digite o Cluster" value="<?= (isset($obj)) ? $obj['pusher_cluster'] : set_value('pusher_cluster');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.pusher_useTLS")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="pusher_useTLS" name="pusher_useTLS" class="custom-control-input" <?= $obj['pusher_useTLS']??false ? 'checked' : ''?>>
                                                                        <label for="pusher_useTLS" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.pusher_scheme")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="pusher_scheme" name="pusher_scheme" class="custom-control-input" <?= $obj['pusher_scheme']??false ? 'checked' : ''?>>
                                                                        <label for="pusher_scheme" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="v-pills-api" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-xl-12 mb-2">
                                                    <h5><?=lang("App.settings_label_api_title")?></h5>
                                                    <input type="hidden" id="group_api" name="group_api" value="<?= (isset($obj)) ? $obj['group_api'] : set_value('group_api');?>">
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_api_subtitle_1")?></label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_enable_api")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="enable_api" name="enable_api" class="custom-control-input" <?= $obj['enable_api']??false ? 'checked' : ''?>>
                                                                        <label for="enable_api" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_block_api")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="block_external_api" name="block_external_api" class="custom-control-input" <?= $obj['block_external_api']??false ? 'checked' : ''?>>
                                                                        <label for="block_external_api" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_ip_api")?></label>
                                                                    <input type="text" id="ip_allowed_api" name="ip_allowed_api" class="form-control" placeholder="<?=lang("App.settings_field_ip_api_ph")?>" value="<?= (isset($obj)) ? $obj['ip_allowed_api'] : set_value('ip_allowed_api');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_jwt_token_lifetime")?></label>
                                                                    <div class="input-group">
                                                                        <input type="number" id="jwt_token_lifetime" min="1" name="jwt_token_lifetime" class="form-control" placeholder="<?=lang("App.settings_field_jwt_token_lifetime_ph")?>" value="<?= (isset($obj)) ? $obj['jwt_token_lifetime'] : set_value('jwt_token_lifetime');?>">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><?=lang("App.global_minutes")?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-9">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_jwt_private_key")?></label>
                                                                    <input type="text" id="jwt_private_key" name="jwt_private_key" class="form-control" placeholder="<?=lang("App.settings_field_jwt_private_key_ph")?>" value="<?= (isset($obj)) ? $obj['jwt_private_key'] : set_value('jwt_private_key');?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="text-primary"><?=lang("App.settings_label_api_subtitle_2")?></label>
                                                            </div>
                                                            <div class="col-lg-6 mb-4">
                                                                <a href="<?=site_url("integration/download_postman")?>" class="btn btn-warning pull-right ml-2"><i class="fas fa-download mr-1"></i> <?=lang("App.settings_label_api_download")?></a>
                                                                <button type="button" data-toggle="modal" data-target="#modalGrid" class="btn btn-primary pull-right" onclick="load_permission_api()"><i class="fas fa-user-lock mr-1"></i> <?=lang("App.settings_label_api_rules")?></button>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <p class="text-dark"><b><i class="fas fa-user-friends"></i> <?=lang("App.settings_label_api_users")?></b></p>
                                                                        <div id="accordion-one" class="accordion-no-gutter accordion-bordered">
                                                                            <div class="accordion__item">
                                                                                <div class="accordion__header collapsed" data-toggle="collapse" data-target="#default_collapseOne">
                                                                                    <span class="accordion__header--text"><span class="badge badge-success"><i class="fas fa-lock"></i> GET</span> <?=getenv('app.baseURL').'/api/user'?></span>
                                                                                    <span class="accordion__header--indicator"></span>
                                                                                </div>
                                                                                <div id="default_collapseOne" class="collapse accordion__body" data-parent="#accordion-one">
                                                                                    <div class="accordion__body--text" id="api_user_all"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="accordion__item">
                                                                                <div class="accordion__header collapsed" data-toggle="collapse" data-target="#default_collapseTwo">
                                                                                    <span class="accordion__header--text"><span class="badge badge-success"><i class="fas fa-lock"></i> GET</span> <?=getenv('app.baseURL').'/api/user/<b>{USER_TOKEN_ID}</b>'?></span>
                                                                                    <span class="accordion__header--indicator"></span>
                                                                                </div>
                                                                                <div id="default_collapseTwo" class="collapse accordion__body" data-parent="#accordion-one">
                                                                                    <div class="accordion__body--text" id="api_user_token"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="accordion__item">
                                                                                <div class="accordion__header collapsed" data-toggle="collapse" data-target="#default_collapseThree">
                                                                                    <span class="accordion__header--text"><span class="badge badge-warning"><i class="fas fa-lock"></i> POST</span> <?=getenv('app.baseURL').'/api/user'?></span>
                                                                                    <span class="accordion__header--indicator"></span>
                                                                                </div>
                                                                                <div id="default_collapseThree" class="collapse accordion__body" data-parent="#accordion-one">
                                                                                    <div class="accordion__body--text" id="api_user_add"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="accordion__item">
                                                                                <div class="accordion__header collapsed" data-toggle="collapse" data-target="#default_collapseFour">
                                                                                    <span class="accordion__header--text"><span class="badge badge-danger"><i class="fas fa-lock"></i> DEL</span> <?=getenv('app.baseURL').'/api/user/<b>{USER_TOKEN_ID}</b>'?></span>
                                                                                    <span class="accordion__header--indicator"></span>
                                                                                </div>
                                                                                <div id="default_collapseFour" class="collapse accordion__body" data-parent="#accordion-one">
                                                                                    <div class="accordion__body--text" id="api_user_delete"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="accordion__item">
                                                                                <div class="accordion__header collapsed" data-toggle="collapse" data-target="#default_collapseFive">
                                                                                    <span class="accordion__header--text"><span class="badge badge-info"><i class="fas fa-lock"></i> PUT</span> <?=getenv('app.baseURL').'/api/user/<b>{USER_TOKEN_ID}</b>'?></span>
                                                                                    <span class="accordion__header--indicator"></span>
                                                                                </div>
                                                                                <div id="default_collapseFive" class="collapse accordion__body" data-parent="#accordion-one">
                                                                                    <div class="accordion__body--text" id="api_user_edit"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p class="text-dark"><b><i class="fas fa-key"></i> <?=lang("App.settings_label_api_auth")?></b></p>
                                                                        <div id="accordion-two" class="accordion-no-gutter accordion-bordered">
                                                                            <div class="accordion__item">
                                                                                <div class="accordion__header collapsed" data-toggle="collapse" data-target="#default_collapseOne_two">
                                                                                    <span class="accordion__header--text"><span class="badge badge-success"><i class="fas fa-lock-open"></i> GET</span> <?=getenv('app.baseURL').'/api/status'?></span>
                                                                                    <span class="accordion__header--indicator"></span>
                                                                                </div>
                                                                                <div id="default_collapseOne_two" class="collapse accordion__body" data-parent="#accordion-two">
                                                                                    <div class="accordion__body--text" id="api_status"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="accordion__item">
                                                                                <div class="accordion__header collapsed" data-toggle="collapse" data-target="#default_collapseTwo_two">
                                                                                    <span class="accordion__header--text"><span class="badge badge-warning"><i class="fas fa-lock-open"></i> POST</span> <?=getenv('app.baseURL').'/api/signin'?></span>
                                                                                    <span class="accordion__header--indicator"></span>
                                                                                </div>
                                                                                <div id="default_collapseTwo_two" class="collapse accordion__body" data-parent="#accordion-two">
                                                                                    <div class="accordion__body--text" id="api_signin"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="modalGrid">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><?=lang("App.settings_label_api_rules")?></h5>
                                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table" id="table-permission" style="display: block; overflow-x: auto; white-space: nowrap;">
                                                                    <thead class="text-primary">
                                                                    <tr>
                                                                        <th>Group Name</th>
                                                                        <th>User (GET)</th>
                                                                        <th>User (POST)</th>
                                                                        <th>User (DEL)</th>
                                                                        <th>USER (PUT)</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php foreach($group??[] as $item): ?>
                                                                    <tr>
                                                                        <td class="badge-secondary"><?=$item['title']?></td>
                                                                        <td>
                                                                            <div class="custom-control custom-switch">
                                                                                <input type="checkbox" id="api_user_get_<?=$item['token']?>" name="api_user_get_<?=$item['token']?>" class="custom-control-input">
                                                                                <label for="api_user_get_<?=$item['token']?>" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="custom-control custom-switch">
                                                                                <input type="checkbox" id="api_user_post_<?=$item['token']?>" name="api_user_post_<?=$item['token']?>" class="custom-control-input">
                                                                                <label for="api_user_post_<?=$item['token']?>" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="custom-control custom-switch">
                                                                                <input type="checkbox" id="api_user_del_<?=$item['token']?>" name="api_user_del_<?=$item['token']?>" class="custom-control-input">
                                                                                <label for="api_user_del_<?=$item['token']?>" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="custom-control custom-switch">
                                                                                <input type="checkbox" id="api_user_put_<?=$item['token']?>" name="api_user_put_<?=$item['token']?>" class="custom-control-input">
                                                                                <label for="api_user_put_<?=$item['token']?>" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times"></i> <?=lang("App.module_permission_cancel")?></button>
                                                                <button type="button" class="btn btn-primary" onclick="save_permission_api()"><i class="fas fa-save"></i> <?=lang("App.module_permission_save")?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="v-pills-customization" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-xl-12 mb-2">
                                                    <h5><?=lang("App.settings_label_customization_title")?></h5>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_customization_subtitle_1")?></label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_enable_module")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="module_enable" name="module_enable" class="custom-control-input" <?= $obj['module_enable']??false ? 'checked' : ''?>>
                                                                        <label for="module_enable" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=''//lang("App.settings_field_enable_layout")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="layout_enable" name="layout_enable" class="custom-control-input" <?=''//$obj['layout_enable']??false ? 'checked' : ''?>>
                                                                        <label for="layout_enable" class="custom-control-label"><?=''//lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="v-pills-logs" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-xl-12 mb-2">
                                                    <h5><?=lang("App.settings_label_logs_title")?></h5>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_logs_subtitle_1")?></label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_remove_log")?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" id="remove_log" name="remove_log" class="custom-control-input" <?= $obj['remove_log']??false ? 'checked' : ''?>>
                                                                        <label for="remove_log" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="text-dark"><?=lang("App.settings_field_remove_log_time")?></label>
                                                                    <div class="input-group">
                                                                        <input type="number" id="remove_log_time" min="1" name="remove_log_time" class="form-control" placeholder="<?=lang("App.settings_field_remove_log_time_ph")?>" value="<?= (isset($obj)) ? $obj['remove_log_time'] : set_value('remove_log_time');?>">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><?=lang("App.global_days")?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="v-pills-cron" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-xl-12 mb-2">
                                                    <h5><?=lang("App.settings_label_cron_title")?></h5>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_cron_subtitle_1")?></label>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <p class="text-dark">
                                                                    <b><?=lang("App.settings_label_cron_timer")?></b>
                                                                    <br><?=lang("App.settings_label_cron_timer_time")?>
                                                                    <br><?=getenv('app.baseURL').'/cron'?>
                                                                </p>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <label class="text-primary"><?=lang("App.settings_label_cron_subtitle_2")?></label>
                                                                <!-- CSRF token -->
                                                                <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                                                <!-- Table -->
                                                                <table id='table-grid' class="table table-striped nowrap" style="width:100%">
                                                                    <thead>
                                                                    <tr>
                                                                        <th><?=lang("App.settings_grid_routine")?></th>
                                                                        <th><?=lang("App.settings_group_grid_error")?></th>
                                                                        <th><?=lang("App.settings_group_grid_created_at")?></th>
                                                                    </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="form-actions">
                                        <a href="<?= site_url($btn_return['route']??'#') ?>" class="<?= $btn_return['class']??''?>">
                                            <i class="<?= $btn_return['icon']??'' ?>"></i> <?= $btn_return['title']??'' ?>
                                        </a>
                                        <button type="submit" class="<?= $btn_submit['class']??''?>">
                                            <i class="<?= $btn_submit['icon']??'' ?>"></i> <?= $btn_submit['title']??'' ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Required vendors -->
<script src="<?=site_url("themes/focus2/vendor/global/global.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/js/quixnav-init.js")?>"></script>
<script src="<?=site_url("themes/focus2/js/custom.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/select2/js/select2.full.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/sweetalert2/dist/sweetalert2.min.js")?>"></script>
<!-- Datatable -->
<script src="<?=site_url("themes/focus2/vendor/datatables/js/jquery.dataTables.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/pickers/daterange/moment.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/datatables/js/dataTables.datetime.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/datatables/js/dataTables.buttons.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/datatables/js/buttons.bootstrap4.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/datatables/js/jszip.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/datatables/js/pdfmake.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/datatables/js/vfs_fonts.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/datatables/js/buttons.html5.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/datatables/js/buttons.print.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/datatables/js/buttons.colVis.min.js")?>"></script>
<!-- Highlightjs -->
<script src="<?=site_url("themes/focus2/vendor/highlightjs/highlight.pack.min.js")?>"></script>
<!-- Summernote -->
<script src="<?=site_url("themes/focus2/vendor/summernote/summernote.min.js")?>"></script>
<!-- Custom -->
<script src="<?=site_url("assets/js/main.js")?>"></script>
<!-- Form -->
<script>
    "use strict";
    $(document).ready(function () {
        $('#first_name').focus();
        $("#email_gateway").select2();
        $("#email_cert").select2();
        $("#sms_gateway").select2();
        $("#captcha_gateway").select2();
        $("#default_language").select2();
        $("#default_role").select2();
        $("#default_date_format").select2();
        $("#default_hour_format").select2();
        $("#default_currency").select2();
        $("#default_currency_position").select2();
        $("#default_currency_separation").select2();
        $("#default_country").select2();
        $("#default_theme").select2();
        $("#default_theme_front").select2();
        $("#default_timezone").select2();
        $("#storage_gateway").select2();
        $("#backup_storage").select2();
        $("#backup_table").select2();
        $("#backup_time").select2();
        $("#send_user_register").select2();

        let configSummerNote = {
            height: 150, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: true, // set focus to editable area after initializing summernote
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['codeview']]
            ]
        }
        $("#terms_conditions_text").summernote(configSummerNote);
        let dataFormat = [
            {
                targets: 2,
                render: $.fn.dataTable.render.moment('YYYY-MM-DD HH:mm:ss','<?=momentDateTimeJS()?>')
            }
        ];
        let order = [[2, "desc"]];
        let translate = '/themes/focus2/vendor/datatables/locales/<?=langJS()?>.json';
        let button = ["<?=lang("App.global_copy")?>","<?=lang("App.global_print")?>","<?=lang("App.global_excel")?>","<?=lang("App.global_pdf")?>"];
        let columns = [{ data: 'routine' },{ data: 'error' },{ data: 'created_at' }];
        loadDataTableAjax('table-grid', '<?=site_url('ajax/getCronHistory')?>', translate, true, true, order, columns,dataFormat, button);
        load_data_api();
    });

    $("#terms_conditions_text").on("summernote.enter", function(we, e) {
        $(this).summernote("pasteHTML", "<br><br>");
        e.preventDefault();
    });

    function save_permission_api(){
        const checkboxes = document.querySelectorAll('input[type="checkbox"][id^="api_"]');
        let obj = {};
        checkboxes.forEach((checkbox) => {
            const chkArray = checkbox.id.split("_");
            if(chkArray.length === 4 && chkArray[3].length === 32 ){
                chkArray.push(checkbox.checked)
            }
            if(obj[chkArray[3]] === undefined){
                obj[chkArray[3]] = [chkArray]
            }else{
                obj[chkArray[3]].push(chkArray);
            }
        });
        $("#group_api").val(JSON.stringify(obj));
        document.getElementById("settingsForm").submit();
    }

    function load_permission_api(){
        const checkboxes = document.querySelectorAll('input[type="checkbox"][id^="api_"]');
        let permission = JSON.parse($("#group_api").val());
        let arrayP = Object.entries(permission);
        arrayP.forEach((group) =>{
            group[1].forEach((item) =>{
                let id = item[0]+'_'+item[1]+'_'+item[2]+'_'+item[3];
                checkboxes.forEach((checkbox) => {
                    if(checkbox.id === id){
                        if(item[4]){
                            checkbox.checked = true;
                        }else{
                            checkbox.checked = false;
                        }
                    }
                });
            });
        });
    }

    function load_data_api(){
        let api_user_all = document.getElementById("api_user_all");
        let api_user_token = document.getElementById("api_user_token");
        let api_user_add = document.getElementById("api_user_add");
        let api_user_delete = document.getElementById("api_user_delete");
        let api_user_edit = document.getElementById("api_user_edit");
        let api_status = document.getElementById("api_status");
        let api_signin = document.getElementById("api_signin");
        api_user_all.innerText = '[\n' +
            '    {\n' +
            '        "token": "fdfa9b8b69e2a71f8a35fdaa226745cf",\n' +
            '        "first_name": "Web",\n' +
            '        "last_name": "Guard",\n' +
            '        "date_birth": null,\n' +
            '        "email": "test@eduardofiorini.com",\n' +
            '        "mobile": "551190000000",\n' +
            '        "picture": "/assets/img/default-user.png",\n' +
            '        "language": "en",\n' +
            '        "address": "",\n' +
            '        "state": "",\n' +
            '        "country": "BR",\n' +
            '        "zip_code": null,\n' +
            '        "status": "1",\n' +
            '        "created_at": "2021-11-12 14:58:46",\n' +
            '        "updated_at": "2021-11-30 16:44:05"\n' +
            '    }\n' +
            ']';
        api_user_token.innerText = '{\n' +
            '        "token": "fdfa9b8b69e2a71f8a35fdaa226745cf",\n' +
            '        "first_name": "Web",\n' +
            '        "last_name": "Guard",\n' +
            '        "date_birth": null,\n' +
            '        "email": "test@eduardofiorini.com",\n' +
            '        "mobile": "551190000000",\n' +
            '        "picture": "/assets/img/default-user.png",\n' +
            '        "language": "en",\n' +
            '        "address": "",\n' +
            '        "state": "",\n' +
            '        "country": "BR",\n' +
            '        "zip_code": null,\n' +
            '        "status": "1",\n' +
            '        "created_at": "2021-11-12 14:58:46",\n' +
            '        "updated_at": "2021-11-30 16:44:05"\n' +
            '    }\n';
        api_user_add.innerText = '{\n' +
            '    "error": false,\n' +
            '    "message": "Added successfully!",\n' +
            '    "data": {\n' +
            '        "token": "0c4e735f95425818d76d89d0837bbe9c",\n' +
            '        "first_name": "Web",\n' +
            '        "last_name": "Guard",\n' +
            '        "date_birth": null,\n' +
            '        "email": "test@eduardofiorini.com",\n' +
            '        "mobile": "",\n' +
            '        "picture": "/assets/img/default-user.png",\n' +
            '        "language": "pt",\n' +
            '        "address": null,\n' +
            '        "state": "",\n' +
            '        "country": "",\n' +
            '        "zip_code": null,\n' +
            '        "status": "1",\n' +
            '        "created_at": "2021-12-10 14:30:35",\n' +
            '        "updated_at": "2021-12-10 14:30:35"\n' +
            '    }\n' +
            '}';
        api_user_delete.innerText = '{\n' +
            '    "error": false,\n' +
            '    "message": "Successfully deleted!"\n' +
            '}';
        api_user_edit.innerText = '{\n' +
            '    "error": false,\n' +
            '    "message": "Successfully Edited!",\n' +
            '    "data": {\n' +
            '        "token": "92f223f92f8d1f95298eba5dd09f53af",\n' +
            '        "first_name": "Eduardo",\n' +
            '        "last_name": "Fiorini",\n' +
            '        "date_birth": "1989-06-19",\n' +
            '        "email": "edupva@gmail.com",\n' +
            '        "mobile": "556696000000",\n' +
            '        "picture": "https://s.gravatar.com/avatar/60bc9eb71c6bc1e82f165ad587bd0947?s=150",\n' +
            '        "language": "pt",\n' +
            '        "address": "",\n' +
            '        "state": "",\n' +
            '        "country": "BR",\n' +
            '        "zip_code": null,\n' +
            '        "status": "1",\n' +
            '        "created_at": "2021-11-07 17:04:49",\n' +
            '        "updated_at": "2021-12-10 14:31:19"\n' +
            '    }\n' +
            '}';
        api_status.innerText = '{\n'+
            '"status": true,\n' +
            '"message": "The system is running!"\n'+
            '}';
        api_signin.innerText = '{\n'+
            '"access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImFkbWluQGFkbWluLmNvbSIsImlhdCI6MTYzOTE1NTgyNiwiZXhwIjoxNjM5MTU2MTI2fQ.-gfpuC2jqWBqCiTUFMECbBR0nUqyfW1n8OyWqqNKqvE"\n'+
            '}';
        hljs.highlightBlock(api_user_all)
        hljs.highlightBlock(api_user_token)
        hljs.highlightBlock(api_user_add)
        hljs.highlightBlock(api_user_delete)
        hljs.highlightBlock(api_user_edit)
        hljs.highlightBlock(api_status)
        hljs.highlightBlock(api_signin)
    }
    function send_test(){
        let email = $("#send_email_test");
        let ajax = new XMLHttpRequest();
        document.getElementById('msg_email_test').style.display = 'block';
        ajax.open("GET", "<?=site_url("integration/send_email_test/")?>"+email.val(), true);
        ajax.send();
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                let data = JSON.parse(this.responseText);
                document.getElementById('msg_email_test').style.display = 'none';
                if(data.return){
                    swal({
                        position: 'center',
                        type: 'success',
                        title: '<?=lang("App.settings_alert_email_test_send")?>',
                        showConfirmButton: false,
                        timer: 2000,
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false
                    });
                }else{
                    swal({
                        position: 'center',
                        type: 'error',
                        title: '<?=lang("App.settings_alert_email_test_error")?>',
                        showConfirmButton: false,
                        timer: 2000,
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false
                    });
                }
                email.val("");
            }
        }
    }
</script>
<?= sweetAlert() ?>
