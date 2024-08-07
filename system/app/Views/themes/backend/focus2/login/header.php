<?php
$session = session();
$token = $session->get('token')??'';
$tfa = $session->get('tfa')??false;
$settings = $session->get('settings');
if (!empty($token) && $tfa == false) {
    echo "<script>window.location.href = '/'; </script>";
}
?>
<!DOCTYPE html>
<html lang="<?= $settings['default_language']??'en'=='pt' ? 'pt-br' : $settings['default_language']??'en' ?>" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= $settings['title']??'' ?><?= empty($title??'') ? '' : ' - ' . $title?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= site_url('themes/focus2/images/favicon.png'); ?>">
    <link href="<?= site_url('themes/focus2/vendor/toastr/css/toastr.min.css'); ?>" rel="stylesheet">
    <link href="<?= site_url('themes/focus2/css/style.css'); ?>" rel="stylesheet">
    <?php
        if($settings['captcha_gateway'] == 'recaptcha'){
            echo "<script src='https://www.google.com/recaptcha/api.js' async defer></script>";
        }else{
            echo "<script src='https://www.hCaptcha.com/1/api.js' async defer></script>";
        }
    ?>
    <link rel="stylesheet" href="<?= site_url('assets/vendor/cookieconsent/dist/cookieconsent.css'); ?>" media="print" onload="this.media='all'">
</head>
<body class="h-100">