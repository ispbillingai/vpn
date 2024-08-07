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
                        <div class="col-sm-12">
                            <h4 class="card-title"><?= $title['page']??'' ?></h4>
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
                                    <th><?=lang("App.notification_grid_sender")?></th>
                                    <th><?=lang("App.notification_grid_recipient")?></th>
                                    <th><?=lang("App.notification_grid_title")?></th>
                                    <th><?=lang("App.notification_grid_created_my")?></th>
                                    <th><?=lang("App.notification_grid_view_my")?></th>
                                    <th><?=lang("App.user_grid_options")?></th>
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
<script src="<?=site_url('themes/focus2/vendor/timeago/jquery.timeago.js'); ?>"></script>
<script src="<?=site_url('themes/focus2/vendor/timeago/locales/jquery.timeago.'.langJS().'.js'); ?>"></script>
<script>
    "use strict";
    $(document).ready(function () {
        let dataFormat = [
            {
                targets: 3,
                render: $.fn.dataTable.render.moment('YYYY-MM-DD HH:mm:ss','<?=momentDateTimeJS()?>')
            },
            {
                targets: 4,
                render: function ( data, type, row ) {
                    switch (data) {
                        case '1':
                            return '<span class="badge badge-success"><?=lang("App.notification_grid_yes")?></span>';
                        default:
                            return '<span class="badge badge-dark"><?=lang("App.notification_grid_no")?></span>';
                    }
                }
            },
        ];
        let order = [[3, "desc"]];
        let translate = '/themes/focus2/vendor/datatables/locales/<?=langJS()?>.json';
        let button = ["<?=lang("App.global_copy")?>","<?=lang("App.global_print")?>","<?=lang("App.global_excel")?>","<?=lang("App.global_pdf")?>"];
        let columns = [{ data: 'sender' },{ data: 'recipient' },{ data: 'title' },{ data: 'created_at' },{ data: 'is_read' },{ data: 'options' }];
        loadDataTableAjax('table-grid', '<?=site_url('ajax/getMyNotification')?>', translate, true, true, order, columns,dataFormat, button);
    });
</script>
<?= sweetAlert() ?>
