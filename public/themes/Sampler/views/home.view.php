<?php
use function CMS\Controller\cms_news_list;
use function CMS\Controller\cms_searchbar_news;
?>

<?php $title = "Accueil";
$description = "Coucou"; ?>

<?php ob_start(); ?>
<h1>Accueil</h1>
<?= $news_controller->cms_searchbar_news() ?>
<?php $news = $news_controller->cms_news_list(4);
foreach ($news as $item) :
    $user = $item->user;
    $categories = $item->categories;

    echo "<h3>$item->news_title</h3>";
    echo "<small>(publié le $item->news_created et mis à jour le $item->news_updated, par $user->user_pseudo)</small><br>";
    foreach ($categories as $category) :
        echo "<a href='/categorie/$category->category_slug'>$category->category_name</a>";
    endforeach;
    echo "<p>$item->news_excerpt</p>";
    echo "<a href='/actualite/$item->news_slug'>Lire l'article</a>";
    echo "<hr>";
endforeach;?>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
