<!--Style-->
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
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <div class="row mx-0" style="width: 100%;">
                            <div class="col-sm-6 p-md-0">
                                <h4 class="card-title"><?=lang("App.module_subtitle_install")?></h4>
                            </div>
                            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <div class="row">
                                    <div class="col-lg-12 justify-content-center d-flex">
                                        <form name="form_upload" class="form" action="<?=site_url("settings/module")?>" enctype="multipart/form-data" method="post">
                                            <?= csrf_field() ?>
                                            <input type="file" name="file" id="file" class="input_hidden" onchange="form_upload.submit()" accept="application/zip">
                                            <div class="btn btn-light btn-circle btn-circle-md"><a href="#" class="file-upload"><i class="fas fa-cloud-upload-alt fa-2xl"></i></a></div>
                                        </form>
                                    </div>
                                    <div class="col-lg-12 text-center mt-1" >
                                        <b><i class="fas fa-upload"></i> <?=strtoupper(lang("App.module_upload_msg"))?></b>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <div class="row mx-0" style="width: 100%;">
                            <div class="col-sm-6 p-md-0">
                                <h4 class="card-title"><?=lang("App.module_subtitle_grid")?></h4>
                            </div>
                            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-height: 370px; overflow-y: auto;">
                            <table class="table" id="table-grid">
                                <thead class="text-primary">
                                <tr>
                                    <th><?=lang("App.module_name")?></th>
                                    <th><?=lang("App.module_version")?></th>
                                    <th><?=lang("App.module_dir")?></th>
                                    <th><?=lang("App.module_create_date")?></th>
                                    <th><?=lang("App.module_update_date")?></th>
                                    <th><?=lang("App.module_status")?></th>
                                    <th><?=lang("App.group_grid_options")?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $mods = file_get_contents(APPPATH . "Modules/Modules.json");
                                $mods = @json_decode($mods);
                                ?>
                                <?php if ($mods && is_array($mods) && count($mods)) : ?>
                                    <?php foreach ($mods as $item) : ?>
                                        <tr>
                                            <td><?= $item->name??''?></td>
                                            <td><?= $item->version??''?></td>
                                            <td><?= $item->directory??''?></td>
                                            <td><span class="timeAgo"><?= $item->created_at??'' ?></span></td>
                                            <td><span class="timeAgo"><?= $item->updated_at??'' ?></span></td>
                                            <td><?= $item->status??'' == 1 ? '<span class="badge badge-success">'.lang("App.global_active").'</span>' : '<span class="badge badge-dark">'.lang("App.global_inactive").'</span>' ?></td>
                                            <td>
                                                <div class="btn-group mr-1 mb-1" xmlns="http://www.w3.org/1999/html">
                                                    <button type="button" class="btn btn-primary btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <?=lang("App.group_grid_options")?>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <button type="button" class="dropdown-item" title="<?=lang("App.module_alert_status")?>" onclick="update('<?= $item->directory??''?>','update')"><?= $item->status??'' == 1 ? '<i class="fas fa-toggle-off"></i> '.lang("App.global_inactive") : '<i class="fas fa-toggle-on"></i> '.lang("App.global_active") ?></button>
                                                        <button type="button" class="dropdown-item" title="<?=lang("App.module_alert_permission")?>" data-toggle="modal" data-target="#modalGrid" onclick="addons_attributed('<?= $item->directory??''?>');"><i class="fas fa-user-lock"></i> <?=lang("App.module_permission")?></button>
                                                        <button type="button" class="dropdown-item" title="<?=lang("App.module_alert_delete")?>" onclick="uninstall('<?= $item->directory??''?>','uninstall')"><i class="fa fa-trash"></i> <?=lang("App.module_uninstall")?></button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-actions mt-2">
                            <a href="<?= site_url($btn_return['route']??'#') ?>" class="<?= $btn_return['class']??''?>">
                                <i class="<?= $btn_return['icon']??'' ?>"></i> <?= $btn_return['title']??'' ?>
                            </a>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalGrid">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?=lang("App.module_permission_model")?></h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body row">
                                    <div class="col-sm-12 justify-content-sm-center mt-2 mt-sm-0 d-flex">
                                        <select id='callbacks' multiple='multiple' class="form-control">
                                            <?php foreach ($groups??[] as $item) : ?>
                                                <option value="<?= $item['token']?>"><?= $item['title']?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times"></i> <?=lang("App.module_permission_cancel")?></button>
                                    <button type="button" class="btn btn-primary" onclick="save_attributed();"><i class="fas fa-save"></i> <?=lang("App.module_permission_save")?></button>
                                </div>
                            </div>
                        </div>
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
<script src="<?=site_url("themes/focus2/vendor/lou-multi-select/js/jquery.multi-select.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/quicksearch/jquery.quicksearch.js")?>"></script>
<!-- Form -->
<script>
    "use strict";
    let idSelect = 0;
    $(document).ready(function () {
        $('#callbacks').multiSelect({
            selectableHeader: "<div style='text-align: center; font-weight: bold;'><?=lang("App.module_permission_available")?></div><input type='text' class='search-input form-control mt-1 mb-1' autocomplete='off' placeholder='<?=lang("App.module_permission_search")?>'>",
            selectionHeader: "<div style='text-align: center; font-weight: bold;'><?=lang("App.module_permission_assigned")?></div><input type='text' class='search-input form-control mt-1 mb-1' autocomplete='off' placeholder='<?=lang("App.module_permission_search")?>'>",
            afterInit: function(ms){
                var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function(e){
                        if (e.which === 40){
                            that.$selectableUl.focus();
                            return false;
                        }
                    });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function(e){
                        if (e.which == 40){
                            that.$selectionUl.focus();
                            return false;
                        }
                    });
            },
            afterSelect: function (values) {
                //alert("Select value: " + values);
                this.qs1.cache();
                this.qs2.cache();
            },
            afterDeselect: function (values) {
                //alert("Deselect value: " + values);
                this.qs1.cache();
                this.qs2.cache();
            }
        });

        $('.file-upload').on('click', function(e) {
            e.preventDefault();
            $('#file').trigger('click');
        });
    });

    function addon_alert(type,title,msg){
        let config = {
            positionClass: 'toast-top-center',
            timeOut: 5e3,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            preventDuplicates: !0,
            onclick: null,
            showDuration: '300',
            hideDuration: '1000',
            extendedTimeOut: '1000',
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
            tapToDismiss: !1
        };

        if(type === 'success')
            toastr.success(msg,title,config);

        if(type === 'error')
            toastr.error(msg,title,config);
    }

    function addons_attributed(id){
        idSelect = btoa(id);
        let getJSON = function(url, callback) {
            let xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.responseType = 'json';
            xhr.onload = function() {
                let status = xhr.status;
                if (status === 200) {
                    callback(null, xhr.response);
                } else {
                    callback(status, xhr.response);
                }
            };
            xhr.send();
        };
        getJSON('/settings/module_permission/'+idSelect,
            function(err, data) {
                if (err !== null) {
                    console.log('ERROR: ' + err);
                } else {
                    let multiS = $('#callbacks');
                    let group = []
                    multiS.multiSelect('deselect_all');
                    data.forEach(function(item){
                        group = group.concat([item]);
                    });
                    multiS.multiSelect('select', group);
                }
            });
    }

    function save_attributed(){
        let obj = {};
        obj.id = atob(idSelect);
        obj.select = $('#callbacks').val();
        let param = btoa(JSON.stringify(obj));

        let getJSON = function(url, callback) {
            let xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.responseType = 'json';
            xhr.onload = function() {
                let status = xhr.status;
                if (status === 200) {
                    callback(null, xhr.response);
                } else {
                    callback(status, xhr.response);
                }
            };
            xhr.send();
        };
        getJSON('/settings/module_permission/save/'+param,
            function(err, data) {
                $('#modalGrid').modal('toggle');
                if (err !== null) {
                    addon_alert('error','<?=lang("App.module_attributed_title_error")?>','<?=lang("App.module_attributed_error")?>')
                } else {
                    addon_alert('success','<?=lang("App.module_attributed_title_success")?>','<?=lang("App.module_attributed_success")?>')
                }
            });
    }

    function update(id,func){
        window.location.href = '<?=site_url("settings/module/")?>'+btoa(id)+"/"+func;
    }

    function uninstall(id,func){
        swal({
            title: "<?=lang("App.module_uninstall_title")?>",
            text: "<?=lang("App.module_uninstall_subtitle")?>",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#f34141",
            confirmButtonText: "<?=lang("App.module_uninstall_btn_ok")?>",
            cancelButtonText: "<?=lang("App.module_uninstall_btn_cancel")?>",
            closeOnConfirm: !1
        }).then(function(isConfirm) {
            if (isConfirm.value) {
                window.location.href = '<?=site_url("settings/module/")?>'+btoa(id)+"/"+func;
            }
        })
    }
</script>
<?= sweetAlert() ?>
<?= toastAlert() ?>
