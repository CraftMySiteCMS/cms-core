<!DOCTYPE html>
<?php include_once("../admin/resources/lang/fr.php"); ?>
<html lang="fr-FR">
<head>
    <meta charset="utf-8" />
    <title>CraftMySite | Installation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="robots" content="NOINDEX, NOFOLLOW">
    <meta name="description" content="Installation du CMS">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?=getenv("PATH_SUBFOLDER")?>admin/resources/vendors/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=getenv("PATH_SUBFOLDER")?>admin/resources/css/adminlte.min.css">

    <script src="<?=getenv("PATH_SUBFOLDER")?>admin/resources/vendors/jquery/jquery.min.js"></script>

    <?= (isset($styles) && !empty($styles)) ? $styles : ""; ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include_once("includes/header.inc.php");?>
    <?php include_once("includes/sidebar.inc.php");?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?= $title ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?=getenv("PATH_SUBFOLDER")?>cms-admin">CraftMySite</a></li>
                            <li class="breadcrumb-item active"><?= $title ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <?= $content ?>
    </div>
    <?php include_once("includes/sidebar_cms.inc.php");?>
    <?php include_once("includes/footer.inc.php");?>
</div>

<!-- jQuery -->
<!-- Bootstrap 4 -->
<script src="<?=getenv("PATH_SUBFOLDER")?>admin/resources/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=getenv("PATH_SUBFOLDER")?>admin/resources/js/adminlte.min.js"></script>
<?= (isset($scripts) && !empty($scripts)) ? $scripts : ""; ?>
<?= (isset($toaster) && !empty($toaster)) ? $toaster : ""; ?>
</body>
</html>