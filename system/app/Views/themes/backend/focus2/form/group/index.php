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
                    <div class="card-header row">
                        <div class="col-sm-6">
                            <h4 class="card-title"><?= $title['page']??'' ?></h4>
                        </div>
                        <div class="col-sm-6 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                            <a href="<?= site_url($btn_add['route']??'#')?>" class="<?= $btn_add['class']??''?>">
                                <i class="<?= $btn_add['icon']??'' ?>"></i> <?= $btn_add['title']??'' ?>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- CSRF token -->
                        <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <!-- Table -->
                        <div class="table-responsive">
                            <table id='table-grid' class="table table-striped nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th><?=lang("App.group_grid_title")?></th>
                                    <th><?=lang("App.group_grid_dashboard")?></th>
                                    <th><?=lang("App.group_grid_created")?></th>
                                    <th><?=lang("App.group_grid_updated")?></th>
                                    <th><?=lang("App.group_grid_options")?></th>
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
<!-- Required vendors -->
<script src="<?=site_url("themes/focus2/vendor/global/global.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/js/quixnav-init.js")?>"></script>
<script src="<?=site_url("themes/focus2/js/custom.min.js")?>"></script>
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
<!-- Alert -->
<script src="<?=site_url("themes/focus2/vendor/sweetalert2/dist/sweetalert2.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/toastr/js/toastr.min.js")?>"></script>
<!-- Custom -->
<script src="<?=site_url("assets/js/main.js")?>"></script>
<script>
    "use strict";
    $(document).ready(function () {
        let dataFormat = [
            {
                targets: 1,
                render: function ( data, type, row ) {
                    if(data.toLowerCase() === 'admin'){
                        return '<span class="badge badge-warning">'+data.toUpperCase()+'</span>';
                    }else if(data.toLowerCase() === 'user'){
                        return '<span class="badge badge-secondary">'+data.toUpperCase()+'</span>';
                    }else{
                        return '<span class="badge badge-dark">'+data.toUpperCase()+'</span>';
                    }
                }
            },
            {
                targets: 2,
                render: $.fn.dataTable.render.moment('YYYY-MM-DD HH:mm:ss','<?=momentDateTimeJS()?>')
            },
            {
                targets: 3,
                render: $.fn.dataTable.render.moment('YYYY-MM-DD HH:mm:ss','<?=momentDateTimeJS()?>')
            }
        ];
        let order = [[0, "asc"]];
        let translate = '/themes/focus2/vendor/datatables/locales/<?=langJS()?>.json';
        let button = ["<?=lang("App.global_copy")?>","<?=lang("App.global_print")?>","<?=lang("App.global_excel")?>","<?=lang("App.global_pdf")?>"];
        let columns = [{ data: 'title' },{ data: 'dashboard' },{ data: 'created_at' },{ data: 'updated_at' },{ data: 'options' }];
        loadDataTableAjax('table-grid', '<?=site_url('ajax/getGroups')?>', translate, true, true, order, columns,dataFormat, button);
    });

    function delete_group(id){
        swal({
            title: "<?=lang("App.group_delete_title")?>",
            text: "<?=lang("App.group_delete_subtitle")?>",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#f34141",
            confirmButtonText: "<?=lang("App.group_delete_btn_ok")?>",
            cancelButtonText: "<?=lang("App.group_delete_btn_cancel")?>",
            closeOnConfirm: !1
        }).then(function(isConfirm) {
            if (isConfirm.value) {
                window.location.href = '<?=site_url("group/delete/")?>'+id;
            }
        })
    }
</script>
<?= sweetAlert() ?>
