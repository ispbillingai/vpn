<?php
$settings = session()->get('settings');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="<?= $settings['seo_description']??'' ?>" />
        <meta name="keywords" content="<?= $settings['seo_keywords']??'' ?>" />
        <meta name="author" content="WebGuard" />
        <title><?= $settings['title']??'' ?></title>
        <!-- Favicon-->
        <link rel="icon" type="image/png" sizes="16x16" href="<?=site_url('themes/focus2/images/favicon.png')?>">
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?= site_url('/themes/startbootstrap/css/styles.css');?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?= site_url('assets/vendor/cookieconsent/dist/cookieconsent.css'); ?>" media="print" onload="this.media='all'">
    </head>
    <body class="d-flex flex-column h-100">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <?php include "menu.php" ?>
            
    

