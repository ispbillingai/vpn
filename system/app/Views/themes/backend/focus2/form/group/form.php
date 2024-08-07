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
                        <form class="form" action="<?= site_url("group/store")?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_group" value="<?= (isset($obj)) ? $obj['id_group'] : set_value('id_group') ?>">
                            <input type="hidden" name="token" value="<?= (isset($obj)) ? $obj['token'] : set_value('token') ?>">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="title" class="text-dark"><?=lang("App.group_field_title")?></label>
                                            <input type="text" name="title" id="title" class="form-control" value="<?= (isset($obj)) ? $obj['title'] : set_value('title') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dashboard" class="text-dark"><?=lang("App.group_field_dashboard")?></label>
                                            <?php $id_select = (isset($obj)) ? $obj['dashboard'] : set_value('dashboard');?>
                                            <select name="dashboard" id="dashboard" class="form-control">
                                                <option value="user" <?= $id_select == "user" ? 'selected' : '' ?>><?=lang("App.group_label_user")?></option>
                                                <option value="admin" <?= $id_select == "admin" ? 'selected' : '' ?>><?=lang("App.group_label_admin")?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 right">
                                        <div class="form-group">
                                            <button type="button" name="select_all" id="select_all" class="btn btn-primary round"><i class="la la-toggle-on"></i> <?=lang("App.group_btn_select")?></button>
                                            <button type="button" name="remove_all" id="remove_all" class="btn btn-primary round ml-1"><i class="la la-toggle-off"></i> <?=lang("App.group_btn_remove")?></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php foreach(getAllClass() as $item): ?>
                                        <div class="col-md-3 col-lg-2 mt-3">
                                            <h4 class="danger"><?=getDictionary($item['name'])?></h4>
                                            <?php foreach($item['methods'] as $subitem): ?>
                                                <?php if(!getIgnoreMethod($subitem)): ?>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" id="<?=$item['name'].'_'.$subitem?>" name="<?=$item['name'].'_'.$subitem?>" class="custom-control-input">
                                                        <label for="<?=$item['name'].'_'.$subitem?>" class="custom-control-label"><?=getDictionary($subitem)?></label>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="form-actions mt-4">
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
<!-- Form -->
<script>
    "use strict";
    $(document).ready(function () {
        $('#title').focus();
        $("#dashboard").select2();
        LoadRules();
    });
    function LoadRules() {
        let obj = JSON.parse('<?= (isset($obj)) ? str_replace('&quot;','"',$obj['rules']) : '{}' ?>');
        $.each(obj, function (key, item) {
            $.each(item, function (sub_key, sub_item) {
                try {
                    document.getElementById(key+"_"+sub_item).checked = true;
                }catch (e) {
                }
            });
        });
    }
    $('#select_all').on('click', function () {
        $(':checkbox').each(function() {
            this.checked = true;
        });
    });
    $('#remove_all').on('click', function () {
        $(':checkbox').each(function() {
            this.checked = false;
        });
    });
</script>
