<h1><?= cms_category_name(); ?></h1>
<p><?= cms_category_description(); ?></p>
<?php $news = cms_news_list(null, null, cms_category_id());
foreach ($news as $item) :
    $user = $item->user;
    $categories = $item->categories;

    echo "<h2>$item->news_title</h2>";
    echo "<small>(publié le $item->news_created et mis à jour le $item->news_updated, par $user->user_pseudo)</small><br>";
    foreach ($categories as $category) :
        echo "<a href='/categorie/$category->category_slug'>$category->category_name</a>";
    endforeach;
    echo "<p>$item->news_excerpt</p>";
    echo "<a href='/actualite/$item->news_slug'>Lire l'article</a>";
    echo "<hr>";
endforeach;?>