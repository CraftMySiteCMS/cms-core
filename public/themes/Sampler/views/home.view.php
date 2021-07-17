<?php $title = "Accueil";
$description = "page d'accueil du CMS"; ?>

<?php ob_start(); ?>
<h1>Accueil</h1>

<main>

    <p>Héhé, direction l'administration ?</p>

    <a href="./cms-admin/">En vrai faut cliquer ici :)</a>

</main>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>