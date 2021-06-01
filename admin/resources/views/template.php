<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="<?= $description ?>">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?=WEBSITE_ADMIN_URL?>resources/vendors/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=WEBSITE_ADMIN_URL?>resources/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <?php include_once("includes/header.inc.php");?>
    <?php include_once("includes/sidebar.inc.php");?>

    <?= $content ?>

    <?php include_once("includes/sidebar_cms.inc.php");?>
    <?php include_once("includes/footer.inc.php");?>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?=WEBSITE_ADMIN_URL?>resources/vendors/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=WEBSITE_ADMIN_URL?>resources/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=WEBSITE_ADMIN_URL?>resources/js/adminlte.min.js"></script>
</body>
</html>