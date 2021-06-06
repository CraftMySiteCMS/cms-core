<?php $posts = cms_posts_list();
$user = $posts->user;
$categories = $posts->categories;

echo "<h1>$posts->posts_title</h1>";
echo "<small>(publié le $posts->posts_created et mis à jour le $posts->posts_updated, par $user->user_pseudo)</small><br>";
foreach ($categories as $category) :
    echo "<a href='/categorie/$category->category_slug'>$category->category_name</a>";
endforeach;
echo "<div>$posts->posts_content</div>";