<!--Style-->
<link rel="stylesheet" href="<?= site_url("themes/focus2/vendor/chartist/css/chartist.min.css") ?>">
<style>
    .ct-series-a .ct-bar, .ct-series-a .ct-line, .ct-series-a .ct-point, .ct-series-a,.bg-char-lead{
        stroke: #6b51df;
    }
    .ct-series-b .ct-bar, .ct-series-b .ct-line, .ct-series-b .ct-point, .ct-series-b,.bg-char-conversion{
        stroke: limegreen;
    }
    .ct-series-c .ct-bar, .ct-series-c .ct-line, .ct-series-c .ct-point, .ct-series-c,.bg-char-disengaged{
        stroke: #ff004d;
    }
    .ct-pie-chart .ct-label {
        fill: rgb(255 255 255);
        color: rgb(255 255 255);
        font-size: .70rem;
        line-height: 1;
    }
    .ct-icon {
        height: 23px;
        width: 23px;
        margin-right: 5px;
        float: left;
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
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="d-inline-block">
                            <i class="fas fa-users text-pink fa-3x"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text text-pink"><?=strtoupper(lang("App.dashboard_user_total"))?></div>
                            <div class="stat-digit"><?=$total_user??'0'?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="d-inline-block">
                            <i class="fas fa-user-friends text-pink fa-3x"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text text-pink"><?=strtoupper(lang("App.dashboard_user_new"))?></div>
                            <div class="stat-digit"><?=$total_new??'0'?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="d-inline-block">
                            <i class="fas fa-user-check text-pink fa-3x"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text text-pink"><?=strtoupper(lang("App.dashboard_user_enabled"))?></div>
                            <div class="stat-digit"><?=$total_enabled??'0'?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="d-inline-block">
                            <i class="fas fa-user-times text-pink fa-3x"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text text-pink"><?=strtoupper(lang("App.dashboard_user_disabled"))?></div>
                            <div class="stat-digit"><?=$total_disabled??'0'?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?=lang("App.dashboard_chart_history")?></h4>
                        <span><i class="fas fa-square" style="color: #6b51df"></i> <?=lang("App.dashboard_user_total")?> <i class="fas fa-square" style="color: limegreen"></i> <?=lang("App.dashboard_user_enabled")?> <i class="fas fa-square" style="color: #ff004d"></i> <?=lang("App.dashboard_user_disabled")?></span>
                    </div>
                    <div class="card-body">
                        <div class="ct-bar-chart mt-5"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?=lang("App.dashboard_grid_user")?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table" id="table-grid" >
                                <tbody>
                                <?php foreach ($data_user??[] as $item) : ?>
                                    <tr>
                                        <td style="height: 56px; text-align: center;">
                                            <img src="<?= $item['picture']??''?>" class="btn-circle btn-circle-sm">
                                        </td>
                                        <td>
                                            <b><?= $item['first_name']??''?> <?= $item['last_name']??''?></b><br>
                                            <?= $item['email']??''?><br>
                                            <span class="timeAgo"><?= $item['created_at']??'' ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?=lang("App.dashboard_grid_access")?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-height: 370px; overflow-y: auto;">
                            <table class="table" id="table-grid">
                                <thead class="text-primary">
                                <tr>
                                    <th><?=lang("App.dashboard_user")?></th>
                                    <th><?=lang("App.dashboard_email")?></th>
                                    <th><?=lang("App.dashboard_created_at")?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($data_activity??[] as $item) : ?>
                                    <?php $data = json_decode($item['detail'],true); ?>
                                    <tr>
                                        <td><?= $item['first_name']??''?></td>
                                        <td><?= $item['email']??''?></td>
                                        <td><span class="timeAgo"><?= $item['created_at']??'' ?></span>  </td>
                                    </tr>
                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?=lang("App.dashboard_chart_auth")?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12" id="ct-icon-chart"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12"><div class="ct-pie-chart"></div></div>
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
<!-- Form -->
<script src="<?=site_url("themes/focus2/vendor/chartist/js/chartist.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/moment/moment.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/pg-calendar/js/pignose.calendar.min.js")?>"></script>
<script src="<?=site_url("themes/focus2/vendor/sweetalert2/dist/sweetalert2.min.js")?>"></script>
<script>
    "use strict";
    $(document).ready(function () {
        let dataPie = <?= $data_char_pie??'{}' ?>;
        let labels = dataPie['labels'];
        let icons = document.getElementById("ct-icon-chart").innerHTML;
        for (let i = 0; i < labels.length; i++) {
            switch (labels[i].toLowerCase()) {
                case 'vkontakte':
                    icons += '<p class="btn-vk btn-circle ct-icon"><i class="fab fa-vk mt-1 ml-1"></i></p>';
                    break;
                case 'wechat':
                    icons += '<p class="btn-wechat btn-circle ct-icon"><i class="fab fa-weixin mt-1 ml-1"></i></p>';
                    break;
                case 'google':
                    icons += '<p class="btn-'+labels[i].toLowerCase()+'-plus btn-circle ct-icon"><i class="fab fa-'+labels[i].toLowerCase()+' mt-1 ml-1"></i></p>';
                    break;
                default:
                    icons += '<p class="btn-'+labels[i].toLowerCase()+' btn-circle ct-icon"><i class="fab fa-'+labels[i].toLowerCase()+' mt-1 ml-1"></i></p>';
            }
        }
        document.getElementById("ct-icon-chart").innerHTML = icons;
        let optionsPie = {
            labelInterpolationFnc: function(value) {
                return value[0]+value[1]+value[2]
            }
        };
        let responsiveOptionsPie = [
            ['screen and (min-width: 640px)', {
                chartPadding: 30,
                labelOffset: 100,
                labelDirection: 'explode',
                labelInterpolationFnc: function(value) {
                    return value;
                }
            }],
            ['screen and (min-width: 1024px)', {
                labelOffset: 0,
                chartPadding: 10
            }]
        ];
        new Chartist.Pie('.ct-pie-chart', dataPie, optionsPie, responsiveOptionsPie);
        let dataBar = <?= $data_char_bar??'{}' ?>;
        let optionsBar = {
            seriesBarDistance: 10
        };
        let responsiveOptionsBar = [
            ['screen and (max-width: 640px)', {
                seriesBarDistance: 5,
                axisX: {
                    labelInterpolationFnc: function(value) {
                        return value[0];
                    }
                }
            }]
        ];
        new Chartist.Bar('.ct-bar-chart', dataBar, optionsBar, responsiveOptionsBar);
    });
</script>
<?= sweetAlert() ?>