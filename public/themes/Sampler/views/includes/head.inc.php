<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <?php session_start(); ?>

    <?= $core_controller->cms_head($title, $description); ?>

    <!-- Theme style -->
    <link rel="stylesheet" type="text/css" href="<?=getenv("PATH_SUBFOLDER")?>public/themes/Sampler/assets/css/main.css">
</head>
<body>