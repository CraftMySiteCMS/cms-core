<h1>Recherche : <?=$keyword?></h1>
<?= cms_searchbar_posts() ?>
<?php foreach ($posts as $item) :
    $user = $item->user;
    $categories = $item->categories;

    echo "<h3>$item->posts_title</h3>";
    echo "<small>(publié le $item->posts_created et mis à jour le $item->posts_updated, par $user->user_pseudo)</small><br>";
    foreach ($categories as $category) :
        echo "<a href='/categorie/$category->category_slug'>$category->category_name</a>";
    endforeach;
    echo "<p>$item->posts_excerpt</p>";
    echo "<a href='/actualite/$item->posts_slug'>Lire l'article</a>";
    echo "<hr>";
endforeach;?>