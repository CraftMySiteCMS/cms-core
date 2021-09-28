<?php $title = "Accueil";
$description = "page d'accueil du CMS"; ?>

<?php ob_start(); ?>

<h1>Accueil</h1>

<main>
    <a href="./cms-admin/">Accès rapide à l'administration</a>
</main>

<?php $content = ob_get_clean(); ?>