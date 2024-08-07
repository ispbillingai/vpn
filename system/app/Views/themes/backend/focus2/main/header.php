<?php
$token = session()->get('token');
$settings = session()->get('settings');
$picture = session()->get('picture');
$picture = substr(strtolower($picture), 0, 4) == "http" ? $picture : site_url($picture);
$pulse = session()->get('pulse');
$notification = session()->get('notification');
?>
<!DOCTYPE html>
<html lang="<?= $settings['default_language']??'en'=='pt' ? 'pt-br' : $settings['default_language']??'en' ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= lang("App.dashboard_title") ?> - <?= $settings['title']??'' ?></title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?=site_url('themes/focus2/images/favicon.png')?>">
    <link href="<?=site_url('themes/focus2/vendor/owl-carousel/css/owl.carousel.min.css')?>" rel="stylesheet">
    <link href="<?=site_url('themes/focus2/vendor/owl-carousel/css/owl.theme.default.min.css')?>" rel="stylesheet">
    <link href="<?=site_url('themes/focus2/vendor/jqvmap/css/jqvmap.min.css')?>" rel="stylesheet">
    <link href="<?=site_url('themes/focus2/vendor/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">
    <link href="<?=site_url('themes/focus2/vendor/select2/css/select2.min.css')?>" rel="stylesheet">
    <link href="<?=site_url('themes/focus2/vendor/sweetalert2/dist/sweetalert2.min.css')?>" rel="stylesheet">
    <link href="<?=site_url('themes/focus2/vendor/lou-multi-select/css/multi-select.css')?>" rel="stylesheet">
    <link href="<?=site_url('themes/focus2/vendor/nestable2/css/jquery.nestable.min.css')?>" rel="stylesheet">
    <link href="<?=site_url('themes/focus2/vendor/toastr/css/toastr.min.css')?>" rel="stylesheet">
    <link href="<?=site_url('themes/focus2/css/theme.css')?>" rel="stylesheet">
    <link href="<?=site_url('themes/focus2/css/style.css')?>" rel="stylesheet">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        localStorage.setItem("direction", "<?= lang("App.direction")?>")
        let pusher = new Pusher('<?= $settings['pusher_key']??'' ?>', {
            cluster: '<?= $settings['pusher_cluster']??'' ?>'
        });
        let channel = pusher.subscribe('<?= $token?>');
        channel.bind('notification-web', function(data) {
            let title = data.title;
            let message = data.message;
            let token = data.token;
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "300000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "onclick": function() {
                    window.location.href = '/my/notification_view/'+token;
                }
            }
            $("#bell-icon").html('<i class="fas fa-bell"></i><div class="pulse-css text-danger"></div>');
            toastr.success(message, title);
        });
    </script>
</head>
<body>
<!--PreLoader-->
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
<!--Main Wrapper-->
<div id="main-wrapper">
    <!--Nav Header-->
    <div class="nav-header">
        <a href="<?=site_url('dashboard')?>" class="brand-logo">
            <img class="logo-abbr" src="<?=site_url('themes/focus2/images/logo.png')?>" alt="">
            <img class="logo-compact" src="<?=site_url('themes/focus2/images/logo-text.png')?>" alt="">
            <img class="brand-title" src="<?=site_url('themes/focus2/images/logo-text.png')?>" alt="">
        </a>
        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>
    <!--Header-->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left"></div>
                    <ul class="navbar-nav header-right">
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                <i class="fas fa-globe-americas"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?= site_url('lang/en'); ?>" class="dropdown-item">
                                    <img src="<?=site_url('assets/flags/united-states.png')?>">
                                    <span class="ml-2"><?= lang("App.lang_en") ?></span>
                                </a>
                                <a href="<?= site_url('lang/es'); ?>" class="dropdown-item">
                                    <img src="<?=site_url('assets/flags/spain.png')?>">
                                    <span class="ml-2"><?= lang("App.lang_es") ?></span>
                                </a>
                                <a href="<?= site_url('lang/pt'); ?>" class="dropdown-item">
                                    <img src="<?=site_url('assets/flags/brazil.png')?>">
                                    <span class="ml-2"><?= lang("App.lang_pt") ?></span>
                                </a>
                                <a href="<?= site_url('lang/ar'); ?>" class="dropdown-item">
                                    <img src="<?=site_url('assets/flags/saudi-arabia.png')?>">
                                    <span class="ml-2"><?= lang("App.lang_ar") ?></span>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                <div id="bell-icon">
                                    <i class="fas fa-bell"></i>
                                    <?php if ($pulse > 0) : ?>
                                        <div class="pulse-css text-danger"></div>
                                    <?php endif; ?>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="list-unstyled">
                                    <?php foreach ($notification??[] as $item) : ?>
                                        <a href="<?=site_url('my/notification_view/'.$item['token'])?>">
                                            <li class="media dropdown-item">
                                                <?php if ($item['is_read']) : ?>
                                                    <span class="success"><i class="far fa-envelope-open"></i> </span>
                                                <?php else : ?>
                                                    <span class="primary"><i class="far fa-envelope"></i> </span>
                                                <?php endif; ?>
                                                <div class="media-body">
                                                    <p><?=$item['title']?></p>
                                                </div>
                                                <span class="notify-time timeAgo"><?=$item['created_at']?></span>
                                            </li>
                                        </a>
                                    <?php endforeach; ?>
                                </ul>
                                <a class="all-notification" href="<?=site_url('my/notification')?>"><?= lang("App.notification_bell_btn") ?> <i class="ti-arrow-right"></i></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown header-profile">
                            <label for="theme" class="theme">  
                                <span class="theme__toggle-wrap">  
                                    <input id="theme" class="theme__toggle" type="checkbox" role="switch" name="theme" value="dark">  
                                    <span class="theme__fill"></span>  
                                    <span class="theme__icon">  
                                            <span class="theme__icon-part"></span>  
                                            <span class="theme__icon-part"></span>  
                                            <span class="theme__icon-part"></span>  
                                            <span class="theme__icon-part"></span>  
                                            <span class="theme__icon-part"></span>  
                                            <span class="theme__icon-part"></span>  
                                            <span class="theme__icon-part"></span>  
                                            <span class="theme__icon-part"></span>  
                                            <span class="theme__icon-part"></span>  
                                    </span>  
                                </span>  
                            </label>  
                        </li>
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <img src="<?= $picture??''?>" class="btn-circle btn-circle-sm" style="width: 50px ; height: 50px;">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?= site_url('profile'); ?>" class="dropdown-item">
                                    <i class="fas fa-user"></i>
                                    <span class="ml-2"><?= lang("App.menu_profile") ?></span>
                                </a>
                                <a href="<?= site_url('activity'); ?>" class="dropdown-item">
                                    <i class="fas fa-list"></i>
                                    <span class="ml-2"><?= lang("App.menu_activity") ?></span>
                                </a>
                                <a href="<?= site_url('login/logout'); ?>" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span class="ml-2"><?= lang("App.menu_logout") ?></span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <?php include "menu.php" ?>

