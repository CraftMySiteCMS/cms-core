<?php

namespace CMS\Model;

use PDO;
use stdClass;

class NewsModel extends Database {

    public $news_id;
    public $news_slug;
    public $user_id;
    public $news_title;
    public $news_content;
    public $news_image;
    public $news_created;
    public $news_updated;
    public $news_state;

    public $news_excerpt;
    public $categories = array();
    public $user = array();

    public static function checkNews($var, $is_slug = null) {
        if($is_slug) $var = array("news_slug" => $var);
        else $var = array("news_id" => $var);

        $sql = "SELECT COUNT(news_id) as exist"
            ." FROM cms_news";
        if($is_slug) $sql .= " WHERE news_slug=:news_slug";
        else $sql .= " WHERE news_id=:news_id";

        $db = Database::dbSConnect();
        $req = $db->prepare($sql);
        $req->execute($var);

        return $req->fetchColumn();
    }

    public function getNews($is_slug = null) {
        if($is_slug) $var = array("news_slug" => $this->news_slug);
        else $var = array("news_id" => $this->news_id);

        $sql = "SELECT news_id, news_slug, user_id, news_title, news_content, DATE_FORMAT(news_created, '%d/%m/%Y à %H:%i:%s') AS 'news_created', DATE_FORMAT(news_updated, '%d/%m/%Y à %H:%i:%s') AS 'news_updated'"
            ." FROM cms_news"
            ." WHERE news_state = 1";
        if($is_slug) $sql .= " AND news_slug=:news_slug";
        else $sql .= " AND news_id=:news_id";

        $db = $this->dbConnect();
        $req = $db->prepare($sql);
        $req->execute($var);

        if($req) :
            $result = $req->fetch(PDO::FETCH_ASSOC);
            foreach ($result as $key => $property) :
                if(property_exists(NewsModel::class, $key)) :
                    $this->$key = $property;
                endif;
            endforeach;
            $user = new UserModel();
            $user->getUser($result['user_id']);
            $this->user = $user;
            $this->getCategories();
            $this->TranslateNews();
        endif;
    }

    public static function getAllNews($limit = null, $offset = null, $category = null): array {
        $return = [];

        $sql = "SELECT news_id, news_slug, user_id, news_title, news_content, DATE_FORMAT(news_created, '%d/%m/%Y à %H:%i:%s') AS 'news_created', DATE_FORMAT(news_updated, '%d/%m/%Y à %H:%i:%s') AS 'news_updated'"
            ." FROM cms_news "
            ." WHERE news_state = 1"
            ." ORDER BY news_id DESC";
        if($limit != null && $offset != null) $sql .= " LIMIT $offset, $limit";
        elseif($limit != null && $offset == null) $sql .= " LIMIT $limit";

        $db = Database::dbSConnect();
        $req = $db->prepare($sql);
        $req->execute();

        if($req) :
            while($result = $req->fetch()) :
                $news = new NewsModel();
                $news->news_id = $result['news_id'];
                $news->news_slug = $result['news_slug'];
                $news->news_title = $result['news_title'];
                $news->news_content = $result['news_content'];
                $news->news_created = $result['news_created'];
                $news->news_updated = $result['news_updated'];

                $news->ExcerptNews();
                $news->TranslateNews();

                $user = new UserModel();
                $user->getUser($result['user_id']);
                $news->user = $user;

                $news->getCategories();



                $is_in_category = false;
                foreach ($news->categories as $category_infos) {
                    if($category == $category_infos->category_id) {
                        $is_in_category = true;
                    }
                }
                if($category != null && $is_in_category || $category == null) {
                    array_push($return,$news);
                }

            endwhile;
        endif;

        return $return;
    }
    public function getCategories() {
        $this->categories = [];
        $var = array(
            "news_id" => $this->news_id
        );

        $sql = "SELECT cms_categories_news.category_id, cms_categories.category_name, cms_categories.category_slug"
            ." FROM cms_categories_news"
            ." INNER JOIN cms_categories"
            ." ON cms_categories.category_id = cms_categories_news.category_id"
            ." WHERE cms_categories_news.news_id=:news_id";

        $db = $this->dbConnect();
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

    public static function searchNews($search_keyword): array {
        $return = [];
        $var = array(
            "keyword" => "%$search_keyword%"
        );

        $sql = "SELECT news_id, news_slug, user_id, news_title, news_content, DATE_FORMAT(news_created, '%d/%m/%Y à %H:%i:%s') AS 'news_created', DATE_FORMAT(news_updated, '%d/%m/%Y à %H:%i:%s') AS 'news_updated'"
            ." FROM cms_news "
            ." WHERE news_title LIKE :keyword OR news_content LIKE :keyword"
            ." AND news_state = 1"
            ." ORDER BY news_id DESC";

        $db = Database::dbSConnect();
        $req = $db->prepare($sql);
        $req->execute($var);

        if($req) :
            while($result = $req->fetch()) :
                $news = new NewsModel();
                $news->news_id = $result['news_id'];
                $news->news_slug = $result['news_slug'];
                $news->news_title = $result['news_title'];
                $news->news_content = $result['news_content'];
                $news->news_created = $result['news_created'];
                $news->news_updated = $result['news_updated'];
                $news->ExcerptNews();

                $user = new UserModel();
                $user->getUser($result['user_id']);
                $news->user = $user;

                $news->getCategories();

                array_push($return,$news);
            endwhile;
        endif;

        return $return;
    }

    public function createNews() {
        $infos = array(
            "news_slug" => $this->news_slug,
            "user_id" => $this->user_id,
            "news_title" => $this->news_title,
            "news_content" => $this->news_content,
            "news_state" => 1
        );
        $sql = "INSERT INTO cms_news(news_slug, user_id, news_title, news_content, news_state) VALUES (:news_slug, :user_id, :news_title, :news_content, :news_state)";

        $db = $this->dbConnect();
        $req = $db->prepare($sql);
        $status = $req->execute($infos);

        if($status){
            $this->news_id = $db->lastInsertId();
            return $this->news_id;
        } else {
            return -1;
        }
    }

    public function ExcerptNews() {
        $content = json_decode($this->news_content);
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

        $this->news_excerpt = "<p>$convertedHtml</p>";
    }

    public function TranslateNews() {
        $content = json_decode($this->news_content);
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

        $this->news_content = $convertedHtml;
    }
}


// Toutes les news d'un article
//SELECT * FROM "cms_categories_news" INNER JOIN cms_categories ON cms_categories_news.category_id = cms_categories.category_id WHERE cms_categories_news.news_id = 1


//SELECT cms_news.news_id, news_slug, user_id, news_title, news_content, DATE_FORMAT(news_created, '%d/%m/%Y à %H:%i:%s') AS 'news_created', DATE_FORMAT(news_updated, '%d/%m/%Y à %H:%i:%s') AS 'news_updated', GROUP_CONCAT(cms_categories.category_name,"|",cms_categories.category_slug SEPARATOR '&&' ) AS categories FROM "cms_news"
//INNER JOIN cms_categories_news ON cms_categories_news.news_id = cms_news.news_id
//INNER JOIN cms_categories ON cms_categories_news.category_id = cms_categories.category_id
//GROUP BY news_id