<!--Style-->
<link href="<?=site_url("themes/focus2/vendor/summernote/summernote.css")?>" rel="stylesheet">
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
                        <div class="row mx-0" style="width: 100%;">
                            <div class="col-sm-6 p-md-0">
                                <h4 class="card-title"><?= $title['page']??'' ?></h4>
                            </div>
                            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#tagModalCenter" title="<?=lang("App.template_label_tag")?>">
                                    <i class="fas fa-tags"></i>
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="tagModalCenter">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?=lang("App.template_modal_title")?></h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><?=lang("App.template_modal_subtitle")?></p>
                                                <?php foreach (keywordEmail()??[] as $item) : ?>
                                                    <button type="button" class="btn btn-primary btn-sm mt-1 mr-1" onclick="copy('[<?=$item?>]')">[<?=$item?>]</button>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-dark" data-dismiss="modal"><?=lang("App.template_modal_btn_1")?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?= formAlert() ?>
                        <form class="form" action="<?=site_url("notification/store")?>" method="post">
                            <?= csrf_field() ?>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="email_gateway" class="text-dark"><?=lang("App.notification_field_user")?></label>
                                            <?php $id_select = (isset($obj)) ? $obj['user_recipient'] : set_value('user_recipient');?>
                                            <select name="user_recipient" id="user_recipient" class="form-control">
                                                <option value="" <?= $id_select == "" ? 'selected' : '' ?>><?=lang("App.notification_field_user_all")?></option>
                                                <?php foreach($user??[] as $item): ?>
                                                    <option value="<?=$item['token']?>" <?= $id_select == $item['token'] ? 'selected' : '' ?>><?=$item['first_name']?> - <?=$item['email']?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="title" class="text-dark"><?=lang("App.notification_field_title")?></label>
                                            <input type="text" name="title" id="title" class="form-control" value="<?= (isset($obj)) ? $obj['title'] : set_value('title') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.notification_field_body")?></label>
                                            <textarea class="form-control" id="body" name="body" rows="3"><?= (isset($obj)) ? $obj['body'] : set_value('body') ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="text-primary"><?=lang("App.notification_field_send_msg")?></label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.notification_field_send_email")?></label>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" id="send_email_notification" name="send_email_notification" class="custom-control-input" <?= $obj['send_email_notification']??false ? 'checked' : ''?>>
                                                <label for="send_email_notification" class="custom-control-label"><?=lang("App.notification_field_send_label")?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.notification_field_send_sms")?></label>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" id="send_sms_notification" name="send_sms_notification" class="custom-control-input" <?= $obj['send_sms_notification']??false ? 'checked' : ''?>>
                                                <label for="send_sms_notification" class="custom-control-label"><?=lang("App.notification_field_send_label")?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions mt-2">
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
<!-- Summernote -->
<script src="<?=site_url("themes/focus2/vendor/summernote/summernote.min.js")?>"></script>
<!-- Alert -->
<script src="<?=site_url("themes/focus2/vendor/sweetalert2/dist/sweetalert2.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/toastr/js/toastr.min.js")?>"></script>
<!-- Form -->
<script>
    "use strict";
    $(document).ready(function () {
        $('#title').focus();
        $("#user_recipient").select2();
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
        $("#body").summernote(configSummerNote);
    });
    $("#body").on("summernote.enter", function(we, e) {
        $(this).summernote("pasteHTML", "<br><br>");
        e.preventDefault();
    });
    function copy(copyText) {
        navigator.clipboard.writeText(copyText);
        toastr.success('<?= lang("App.template_modal_copy_msg") ?>','<?= lang("App.template_modal_copy") ?>!',{positionClass: 'toast-top-center'})
        $('#tagModalCenter').modal('hide')
    }
</script>
<?= toastAlert() ?>