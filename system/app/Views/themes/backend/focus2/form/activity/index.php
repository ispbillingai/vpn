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
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="d-inline-block">
                            <i class="fab fa-windows text-pink fa-3x"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text text-pink"><?=strtoupper(lang("App.activity_top_windows"))?></div>
                            <div class="stat-digit"><?=$logs['windows']??'0'?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="d-inline-block">
                            <i class="fab fa-apple text-pink fa-3x"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text text-pink"><?=strtoupper(lang("App.activity_top_mac"))?></div>
                            <div class="stat-digit"><?=$logs['mac']??'0'?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="d-inline-block">
                            <i class="fab fa-linux text-pink fa-3x"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text text-pink"><?=strtoupper(lang("App.activity_top_linux"))?></div>
                            <div class="stat-digit"><?=$logs['linux']??'0'?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="d-inline-block">
                            <i class="fab fa-android text-pink fa-3x"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text text-pink"><?=strtoupper(lang("App.activity_top_mobile"))?></div>
                            <div class="stat-digit"><?=($logs['android']??'0') + ($logs['iphone']??'0')?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="d-inline-block">
                            <i class="fab fa-edge text-pink fa-3x"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text text-pink"><?=strtoupper(lang("App.activity_top_edge"))?></div>
                            <div class="stat-digit"><?=($logs['ie']??'0') + ($logs['edge']??'0')?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="d-inline-block">
                            <i class="fab fa-safari text-pink fa-3x"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text text-pink"><?=strtoupper(lang("App.activity_top_safari"))?></div>
                            <div class="stat-digit"><?=$logs['safari']??'0'?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="d-inline-block">
                            <i class="fab fa-firefox-browser text-pink fa-3x"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text text-pink"><?=strtoupper(lang("App.activity_top_firefox"))?></div>
                            <div class="stat-digit"><?=$logs['firefox']??'0'?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="d-inline-block">
                            <i class="fab fa-chrome text-pink fa-3x"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text text-pink"><?=strtoupper(lang("App.activity_top_chrome"))?></div>
                            <div class="stat-digit"><?=$logs['chrome']??'0'?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-sm-6">
                            <h4 class="card-title"><?= $title['page']??'' ?></h4>
                        </div>
                        <?php if (session()->get('dashboard')=='admin') : ?>
                            <div class="col-sm-6 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                                <a href="<?= site_url("activity/all")?>" class="btn btn-lg btn-primary float-md-right">
                                    <i class="fas fa-eye"></i> <?=lang("App.activity_all_btn")?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <!-- CSRF token -->
                        <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <!-- Table -->
                        <div class="table-responsive">
                            <table id='table-grid' class="table table-striped nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th><?=lang("App.activity_grid_user")?></th>
                                    <th><?=lang("App.activity_grid_level")?></th>
                                    <th><?=lang("App.activity_grid_event")?></th>
                                    <th><?=lang("App.activity_grid_ip")?></th>
                                    <th><?=lang("App.activity_grid_os")?></th>
                                    <th><?=lang("App.activity_grid_browser")?></th>
                                    <th><?=lang("App.activity_grid_created")?></th>
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
                    switch (data) {
                        case 'error':
                            return '<span class="badge badge-danger"><?=lang("App.activity_alert_error")?></span>';
                        case 'recovery':
                            return '<span class="badge badge-secondary"><?=lang("App.activity_alert_recovery")?></span>';
                        case 'throttling':
                            return '<span class="badge badge-warning"><?=lang("App.activity_alert_throttling")?></span>';
                        case 'information':
                            return '<span class="badge badge-primary"><?=lang("App.activity_alert_information")?></span>';
                        default:
                            return '<span class="badge badge-primary">'+data+'</span>';
                    }
                }
            },
            {
                targets: 2,
                render: function ( data, type, row ) {
                    switch (data) {
                        case 'login-authenticate':
                            return '<?=lang("App.activity_alert_login_auth")?>';
                        case 'recovery-password':
                            return '<?=lang("App.activity_alert_recovery")?>';
                        default:
                            return data;
                    }
                }
            },
            {
                targets: 6,
                render: $.fn.dataTable.render.moment('YYYY-MM-DD HH:mm:ss','<?=momentDateTimeJS()?>')
            }
        ];
        let order = [[6, "desc"]];
        let translate = '/themes/focus2/vendor/datatables/locales/<?=langJS()?>.json';
        let button = ["<?=lang("App.global_copy")?>","<?=lang("App.global_print")?>","<?=lang("App.global_excel")?>","<?=lang("App.global_pdf")?>"];
        let columns = [{ data: 'name' },{ data: 'level' },{ data: 'event' },{ data: 'ip' },{ data: 'os' },{ data: 'browser' },{ data: 'created_at' }];
        loadDataTableAjax('table-grid', '<?=site_url("ajax/getActivities".$all??"")?>', translate, true, true, order, columns,dataFormat, button);
    });
</script>