<!DOCTYPE html>
<html lang="fr-FR">
<?php include_once("includes/head.inc.php");?>
<?php if(!isset($no_body) || !$no_body) : ?>
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
<?php else : ?>
    <?= $content ?>
<?php endif; ?>

<!-- jQuery -->
<!-- Bootstrap 4 -->
<script src="<?=getenv("PATH_SUBFOLDER")?>admin/resources/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=getenv("PATH_SUBFOLDER")?>admin/resources/js/adminlte.min.js"></script>
<?= (isset($scripts) && !empty($scripts)) ? $scripts : ""; ?>
<?= (isset($toaster) && !empty($toaster)) ? $toaster : ""; ?>
</body>
</html>