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
        <form class="form" action="<?=site_url("settings/oauth_store")?>" method="post">
            <?= csrf_field() ?>
            <div class="row">
                <?php foreach ($oauth??[] as $item) : ?>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><i class="<?=$item['icon_class']?>"></i> <?=$item['btn_text']?></h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="text-dark"><?=$item['provider']=='twitter'?lang("App.oauth_label_key"):lang("App.oauth_label_id")?></label>
                                            <input type="text" id="<?=$item['provider']?>_key_<?=$item['id_oauth']?>" name="<?=$item['provider']?>_key_<?=$item['id_oauth']?>" class="form-control" placeholder="<?=$item['provider']=='twitter'?lang("App.oauth_label_key_ph"):lang("App.oauth_label_id_ph")?>" value="<?=$item['key']?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.oauth_label_secret")?></label>
                                            <input type="text" id="<?=$item['provider']?>_secret_<?=$item['id_oauth']?>" name="<?=$item['provider']?>_secret_<?=$item['id_oauth']?>" class="form-control" placeholder="<?=lang("App.oauth_label_secret_ph")?>" value="<?=$item['secret']?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.oauth_label_view")?></label>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" id="<?=$item['provider']?>_show_<?=$item['id_oauth']?>" name="<?=$item['provider']?>_show_<?=$item['id_oauth']?>" class="custom-control-input">
                                                <label for="<?=$item['provider']?>_show_<?=$item['id_oauth']?>" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.oauth_label_active")?></label>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" id="<?=$item['provider']?>_status_<?=$item['id_oauth']?>" name="<?=$item['provider']?>_status_<?=$item['id_oauth']?>" class="custom-control-input">
                                                <label for="<?=$item['provider']?>_status_<?=$item['id_oauth']?>" class="custom-control-label"><?=lang("App.global_activate")?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="text-dark"><?=lang("App.oauth_label_url_return")?></label>
                                            <h6><?= getenv('app.baseURL') . '/oauth/' . $item['provider']?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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
        </form>
    </div>
</div>
<!-- Required vendors -->
<script src="<?=site_url("themes/focus2/vendor/global/global.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/js/quixnav-init.js")?>"></script>
<script src="<?=site_url("themes/focus2/js/custom.min.js")?>"></script>
<!-- Alert -->
<script src="<?=site_url("themes/focus2/vendor/sweetalert2/dist/sweetalert2.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/toastr/js/toastr.min.js")?>"></script>
<!-- Form -->
<script>
    "use strict";
    $(document).ready(function () {
        LoadChecked();
    });
    function LoadChecked() {
        let obj = JSON.parse('<?= (isset($oauth)) ? json_encode($oauth) : '{}' ?>');
        $.each(obj, function (key, item) {
            if(item.show_text === "1"){
                document.getElementById(item.provider+"_show_"+item.id_oauth).checked = true;
            }
            if(item.status === "1"){
                document.getElementById(item.provider+"_status_"+item.id_oauth).checked = true;
            }
        });
    }
</script>
<?= sweetAlert() ?>
