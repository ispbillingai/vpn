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
        <form class="form" action="<?=site_url("settings/template_store")?>" method="post">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mx-0" style="width: 100%;">
                                <div class="col-sm-6 p-md-0">
                                    <h4 class="card-title"><?=lang("App.template_subtitle_email")?></h4>
                                </div>
                                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#tagModalCenter" title="<?=lang("App.template_label_tag")?>">
                                        <i class="fas fa-tags"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="default-tab">
                                <ul class="nav nav-tabs" role="tablist">
                                    <?php $count=1; ?>
                                    <?php foreach ($template??[] as $item) : ?>
                                        <?php if ($item['type']=='email') : ?>
                                            <li class="nav-item">
                                                <a class="nav-link <?=$count==1?'active':''?>" data-toggle="tab" href="#email_<?=$item['id_template']?>"><?=lang("App.".$item['name'])?></a>
                                            </li>
                                            <?php $count++; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="tab-content">
                                    <?php $count=1; ?>
                                    <?php foreach ($template??[] as $item) : ?>
                                        <?php if ($item['type']=='email') : ?>
                                            <div class="tab-pane fade show <?=$count==1?'active':''?>" id="email_<?=$item['id_template']?>" role="tabpanel">
                                                <div class="row mt-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="text-dark"><?=lang("App.template_label_title")?></label>
                                                            <input type="text" id="title_email_<?=$item['id_template']?>" name="title_email_<?=$item['id_template']?>" class="form-control" placeholder="<?=lang("App.template_label_title_ph")?>" value="<?=$item['subject']?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="text-dark"><?=lang("App.template_label_message")?></label>
                                                            <textarea class="form-control" id="body_email_<?=$item['id_template']?>" name="body_email_<?=$item['id_template']?>" rows="3"><?=$item['body']?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $count++; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mx-0" style="width: 100%;">
                                <div class="col-sm-6 p-md-0">
                                    <h4 class="card-title"><?=lang("App.template_subtitle_sms")?></h4>
                                </div>
                                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#tagModalCenter" title="<?=lang("App.template_label_tag")?>">
                                        <i class="fas fa-tags"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="default-tab">
                                <ul class="nav nav-tabs" role="tablist">
                                    <?php $count=1; ?>
                                    <?php foreach ($template??[] as $item) : ?>
                                        <?php if ($item['type']=='sms') : ?>
                                            <li class="nav-item">
                                                <a class="nav-link <?=$count==1?'active':''?>" data-toggle="tab" href="#sms_<?=$item['id_template']?>"><?=lang("App.".$item['name'])?></a>
                                            </li>
                                            <?php $count++; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="tab-content">
                                    <?php $count=1; ?>
                                    <?php foreach ($template??[] as $item) : ?>
                                        <?php if ($item['type']=='sms') : ?>
                                            <div class="tab-pane fade show <?=$count==1?'active':''?>" id="sms_<?=$item['id_template']?>" role="tabpanel">
                                                <div class="row mt-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="text-dark"><?=lang("App.template_label_message")?></label>
                                                            <textarea class="form-control" id="body_sms_<?=$item['id_template']?>" name="body_sms_<?=$item['id_template']?>" rows="3"><?=$item['body']?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $count++; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
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
        </form>
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
        $('#first_name').focus();
        $("#email_gateway").select2();
        $("#email_cert").select2();

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
        <?php foreach ($template??[] as $item) : ?>
            $("#body_<?=$item['type']?>_<?=$item['id_template']?>").summernote(configSummerNote);
        <?php endforeach; ?>
    });
    <?php foreach ($template??[] as $item) : ?>
        $("#body_<?=$item['type']?>_<?=$item['id_template']?>").on("summernote.enter", function(we, e) {
            $(this).summernote("pasteHTML", "<br><br>");
            e.preventDefault();
        });
    <?php endforeach; ?>
    function copy(copyText) {
        navigator.clipboard.writeText(copyText);
        toastr.success('<?= lang("App.template_modal_copy_msg") ?>','<?= lang("App.template_modal_copy") ?>!',{positionClass: 'toast-top-center'})
        $('#tagModalCenter').modal('hide')
    }
</script>
<?= sweetAlert() ?>
<?= toastAlert() ?>
