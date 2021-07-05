<?php

namespace CMS\Model\posts;

use CMS\Model\Manager;
use CMS\Model\users\usersModel;
use PDO;
use stdClass;

class postsModel extends Manager {

    public $posts_id;
    public $posts_slug;
    public $user_id;
    public $posts_title;
    public $posts_content;
    public $posts_image;
    public $posts_created;
    public $posts_updated;
    public $posts_state;

    public $posts_excerpt;
    public $categories = array();
    public $user = array();

    public static function checkPosts($var, $is_slug = null) {
        if($is_slug) $var = array("posts_slug" => $var);
        else $var = array("posts_id" => $var);

        $sql = "SELECT COUNT(posts_id) as exist"
            ." FROM cms_posts_list";
        if($is_slug) $sql .= " WHERE posts_slug=:posts_slug";
        else $sql .= " WHERE posts_id=:posts_id";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($var);

        return $req->fetchColumn();
    }

    public function getPosts($is_slug = null) {
        if($is_slug) $var = array("posts_slug" => $this->posts_slug);
        else $var = array("posts_id" => $this->posts_id);

        $sql = "SELECT posts_id, posts_slug, user_id, posts_title, posts_content, DATE_FORMAT(posts_created, '%d/%m/%Y à %H:%i:%s') AS 'posts_created', DATE_FORMAT(posts_updated, '%d/%m/%Y à %H:%i:%s') AS 'posts_updated'"
            ." FROM cms_posts_list"
            ." WHERE posts_state = 1";
        if($is_slug) $sql .= " AND posts_slug=:posts_slug";
        else $sql .= " AND posts_id=:posts_id";

        $db = $this->db_connect();
        $req = $db->prepare($sql);
        $req->execute($var);

        if($req) :
            $result = $req->fetch(PDO::FETCH_ASSOC);
            foreach ($result as $key => $property) :
                if(property_exists(postsModel::class, $key)) :
                    $this->$key = $property;
                endif;
            endforeach;
            $user = new usersModel();
            $user->fetch($result['user_id']);
            $this->user = $user;
            $this->getCategories();
            $this->TranslatePosts();
        endif;
    }

    public static function getAllPosts($limit = null, $offset = null, $category = null): array {
        $return = [];

        $sql = "SELECT posts_id, posts_slug, user_id, posts_title, posts_content, DATE_FORMAT(posts_created, '%d/%m/%Y à %H:%i:%s') AS 'posts_created', DATE_FORMAT(posts_updated, '%d/%m/%Y à %H:%i:%s') AS 'posts_updated'"
            ." FROM cms_posts_list "
            ." WHERE posts_state = 1"
            ." ORDER BY posts_id DESC";
        if($limit != null && $offset != null) $sql .= " LIMIT $offset, $limit";
        elseif($limit != null && $offset == null) $sql .= " LIMIT $limit";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute();

        if($req) :
            while($result = $req->fetch()) :
                $posts = new postsModel();
                $posts->posts_id = $result['posts_id'];
                $posts->posts_slug = $result['posts_slug'];
                $posts->posts_title = $result['posts_title'];
                $posts->posts_content = $result['posts_content'];
                $posts->posts_created = $result['posts_created'];
                $posts->posts_updated = $result['posts_updated'];

                if(!empty($posts->posts_content)) {
                    $posts->ExcerptPosts();
                    $posts->TranslatePosts();
                }

                $user = new usersModel();
                $user->fetch($result['user_id']);
                $posts->user = $user;

                $posts->getCategories();



                $is_in_category = false;
                foreach ($posts->categories as $category_infos) {
                    if($category == $category_infos->category_id) {
                        $is_in_category = true;
                    }
                }
                if($category != null && $is_in_category || $category == null) {
                    array_push($return,$posts);
                }

            endwhile;
        endif;

        return $return;
    }
    public function getCategories() {
        $this->categories = [];
        $var = array(
            "posts_id" => $this->posts_id
        );

        $sql = "SELECT cms_posts_categories_posts.category_id, cms_posts_categories.category_name, cms_posts_categories.category_slug"
            ." FROM cms_posts_categories_posts"
            ." INNER JOIN cms_posts_categories"
            ." ON cms_posts_categories.category_id = cms_posts_categories_posts.category_id"
            ." WHERE cms_posts_categories_posts.posts_id=:posts_id";

        $db = $this->db_connect();
        $req = $db->prepare($sql);
        $req->execute($var);

        if($req) :
            while($result = $req->fetch()) :
                $category = new stdClass();
                $category->category_id = $result["category_id"];
                $category->category_name = $result["category_name"];
                $category->category_slug = $result["category_slug"];
                array_push($this->categories, $category);
            endwhile;
        endif;
    }

    public static function searchPosts($search_keyword): array {
        $return = [];
        $var = array(
            "keyword" => "%$search_keyword%"
        );

        $sql = "SELECT posts_id, posts_slug, user_id, posts_title, posts_content, DATE_FORMAT(posts_created, '%d/%m/%Y à %H:%i:%s') AS 'posts_created', DATE_FORMAT(posts_updated, '%d/%m/%Y à %H:%i:%s') AS 'posts_updated'"
            ." FROM cms_posts_list "
            ." WHERE posts_title LIKE :keyword OR posts_content LIKE :keyword"
            ." AND posts_state = 1"
            ." ORDER BY posts_id DESC";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($var);

        if($req) :
            while($result = $req->fetch()) :
                $posts = new postsModel();
                $posts->posts_id = $result['posts_id'];
                $posts->posts_slug = $result['posts_slug'];
                $posts->posts_title = $result['posts_title'];
                $posts->posts_content = $result['posts_content'];
                $posts->posts_created = $result['posts_created'];
                $posts->posts_updated = $result['posts_updated'];
                $posts->ExcerptPosts();

                $user = new usersModel();
                $user->fetch($result['user_id']);
                $posts->user = $user;

                $posts->getCategories();

                array_push($return,$posts);
            endwhile;
        endif;

        return $return;
    }

    public function createPosts() {
        $infos = array(
            "posts_slug" => $this->posts_slug,
            "user_id" => $this->user_id,
            "posts_title" => $this->posts_title,
            "posts_content" => $this->posts_content,
            "posts_state" => 1
        );
        $sql = "INSERT INTO cms_posts_list(posts_slug, user_id, posts_title, posts_content, posts_state) VALUES (:posts_slug, :user_id, :posts_title, :posts_content, :posts_state)";

        $db = $this->db_connect();
        $req = $db->prepare($sql);
        $status = $req->execute($infos);

        if($status){
            $this->posts_id = $db->lastInsertId();
            return $this->posts_id;
        } else {
            return -1;
        }
    }

    public function ExcerptPosts() {
        $content = json_decode($this->posts_content);
        $blocks = $content->blocks;
        $convertedHtml = "";
        foreach ($blocks as $block) :
            switch ($block->type) :
                case "header":
                    $text = $block->data->text;
                    $convertedHtml .= $text.". ";
                    break;
                case "paragraph":
                    $text = $block->data->text;
                    $convertedHtml .= "$text";
                    break;
            endswitch;
        endforeach;

        if(strlen($convertedHtml) >= 183) $convertedHtml = substr($convertedHtml, 0, 180)."...";

        $this->posts_excerpt = "<p>$convertedHtml</p>";
    }

    public function TranslatePosts() {
        $content = json_decode($this->posts_content);
        $blocks = $content->blocks;
        $convertedHtml = "";
        foreach ($blocks as $block) :
            switch ($block->type) :
                case "header":
                    $level = $block->data->level;
                    $text = $block->data->text;
                    $convertedHtml .= "<h$level>$text</h$level>";
                    break;
                case "embded":
                    $convertedHtml .= "<div><iframe width='560' height='315' src='$block->data->embed' allow='autoplay; encrypted-media' allowfullscreen></iframe></div>";
                    break;
                case "paragraph":
                    $text = $block->data->text;
                    $convertedHtml .= "<p>$text</p>";
                    break;
                case "delimiter":
                    $convertedHtml .= "<hr />";
                    break;
                case "image":
                    $src = $block->data->url;
                    $caption = $block->data->caption;
                    $convertedHtml .= "<img class='img-fluid' src='$src' title='$caption' /><br /><em>$caption</em>";
                    break;
                case "list":
                    if($block->data->style == "unordered") $convertedHtml .= "<ul>";
                    else $convertedHtml .= "<ol>";
                    foreach($block->data->items as $item) :
                        $convertedHtml .= "<li>$item</li>";
                    endforeach;
                    if($block->data->style == "unordered") $convertedHtml .= "</ul>";
                    else $convertedHtml .= "</ol>";
                    break;
                case "quote":
                    $text = $block->data->text;
                    $caption = $block->data->caption;
                    $convertedHtml .= "<figure>";
                    $convertedHtml .= "<blockquote><p>$text</p></blockquote>";
                    $convertedHtml .= "<figcaption>$caption</figcaption>";
                    $convertedHtml .= "</figure>";
                    break;
                case "code":
                    $convertedHtml .= "<pre><code>";
                    $convertedHtml .= $block->data->code;
                    $convertedHtml .= "</pre></code>";
                    break;
                case "warning":
                    $title = $block->data->title;
                    $message = $block->data->message;
                    $convertedHtml .= "<div class='warning'>";
                    $convertedHtml .= "<div class='warning-title'><p>$title</p></div>";
                    $convertedHtml .= "<div class='warning-content'>$message</div>";
                    $convertedHtml .= "</div>";
                    break;
                case "linkTool":
                    $link = $block->data->link;
                    //$text = $block->data->meta;
                    $convertedHtml .= "<a href='$link'>$link</a>";
                    break;
                case "table":
                    $convertedHtml .= "<table><tbody>";
                    foreach($block->data->content as $tr) :
                        $convertedHtml .= "<tr>";
                        foreach ($tr as $td) :
                            $convertedHtml .= "<td>$td</td>";
                        endforeach;
                        $convertedHtml .= "</tr>";

                    endforeach;
                    $convertedHtml .= "</table></tbody>";
                    break;
            endswitch;
        endforeach;

        $this->posts_content = $convertedHtml;
    }
}


// Je sais plus pourquoi j'ai mis ça là mais je le garde au cas où
//SELECT * FROM "cms_posts_categories_posts" INNER JOIN cms_posts_categories ON cms_posts_categories_posts.category_id = cms_posts_categories.category_id WHERE cms_posts_categories_posts.posts_id = 1


//SELECT cms_posts_list.posts_id, posts_slug, user_id, posts_title, posts_content, DATE_FORMAT(posts_created, '%d/%m/%Y à %H:%i:%s') AS 'posts_created', DATE_FORMAT(posts_updated, '%d/%m/%Y à %H:%i:%s') AS 'posts_updated', GROUP_CONCAT(cms_posts_categories.category_name,"|",cms_posts_categories.category_slug SEPARATOR '&&' ) AS categories FROM "cms_posts_list"
//INNER JOIN cms_posts_categories_posts ON cms_posts_categories_posts.posts_id = cms_posts_list.posts_id
//INNER JOIN cms_posts_categories ON cms_posts_categories_posts.category_id = cms_posts_categories.category_id
//GROUP BY posts_id