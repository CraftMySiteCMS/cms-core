<?php $news = cms_news();
$user = $news->user;
$categories = $news->categories;

echo "<h1>$news->news_title</h1>";
echo "<small>(publié le $news->news_created et mis à jour le $news->news_updated, par $user->user_pseudo)</small><br>";
foreach ($categories as $category) :
    echo "<a href='/categorie/$category->category_slug'>$category->category_name</a>";
endforeach;
echo "<div>$news->news_content</div>";