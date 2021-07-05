<?php $title = "Accueil";
$description = "Coucou"; ?>

<?php ob_start(); ?>

COUCOU

<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ .'/../template.php'); ?>

