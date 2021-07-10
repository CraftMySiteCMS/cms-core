<?php
namespace CMS\Model\pages;

use CMS\Model\Manager;
use CMS\Model\users\usersModel;
use PDO;

class pagesModel extends Manager {
    public $page_id;
    public $user_id;
    public $user;
    public $page_title;
    public $page_slug;
    public $page_content;
    public $page_created;
    public $page_updated;
    public $page_state;
    public $page_content_translated;

    public static function exist($var, $is_slug = null) {
        if($is_slug) $var = array("page_slug" => $var);
        else $var = array("page_id" => $var);

        $sql = "SELECT COUNT(page_id) as exist"
            ." FROM cms_pages";
        if($is_slug) $sql .= " WHERE page_slug=:page_slug";
        else $sql .= " WHERE page_id=:page_id";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($var);

        return $req->fetchColumn();
    }

    public function create() {
        $var = array(
            "page_slug" => $this->page_slug,
            "user_id" => $this->user_id,
            "page_title" => mb_strimwidth($this->page_title ,0,255),
            "page_content" => $this->page_content,
            "page_state" => $this->page_state
        );
        $sql = "INSERT INTO cms_pages(page_slug, user_id, page_title, page_content, page_state) VALUES (:page_slug, :user_id, :page_title, :page_content, :page_state)";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);

        if($req->execute($var)){
            $this->page_id = $db->lastInsertId();
            return $this->page_id;
        } else {
            return -1;
        }
    }

    public function fetch($is_slug = null) {
        if($is_slug) $var = array("page_slug" => $this->page_slug);
        else $var = array("page_id" => $this->page_id);

        $sql = "SELECT page_id, page_title, page_slug, user_id, page_content, DATE_FORMAT(page_created, '%d/%m/%Y à %H:%i:%s') AS 'page_created', DATE_FORMAT(page_updated, '%d/%m/%Y à %H:%i:%s') AS 'page_updated'"
            ." FROM cms_pages"
            ." WHERE page_state = 1";
        if($is_slug) $sql .= " AND page_slug=:page_slug";
        else $sql .= " AND page_id=:page_id";

        $db =  Manager::db_connect();
        $req = $db->prepare($sql);

        if($req->execute($var)) :
            $result = $req->fetch(PDO::FETCH_ASSOC);
            foreach ($result as $key => $property) :
                if(property_exists(pagesModel::class, $key)) :
                    $this->$key = $property;
                endif;
            endforeach;

            $this->TranslatePage();

            $user = new usersModel();
            $user->fetch($result['user_id']);
            $this->user = $user;
        endif;
    }
    public static function fetchAll(): array {
        $return = [];

        $sql = "SELECT page_id, page_title, page_slug, user_id, page_content, page_state, DATE_FORMAT(page_created, '%d/%m/%Y à %H:%i:%s') AS 'page_created', DATE_FORMAT(page_updated, '%d/%m/%Y à %H:%i:%s') AS 'page_updated'"
            ." FROM cms_pages ";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);

        if($req->execute()) :
            while($result = $req->fetch()) :
                $pages = new pagesModel();
                $pages->page_id = $result['page_id'];
                $pages->page_slug = $result['page_slug'];
                $pages->page_title = $result['page_title'];
                $pages->page_content = $result['page_content'];
                $pages->page_created = $result['page_created'];
                $pages->page_updated = $result['page_updated'];

                $pages->TranslatePage();

                $user = new usersModel();
                $user->fetch($result['user_id']);
                $pages->user = $user;

                array_push($return,$pages);

            endwhile;
        endif;

        return $return;
    }
    public function update() {
        $var = array(
            "page_id" => $this->page_id,
            "page_slug" => $this->page_slug,
            "page_title" =>  mb_strimwidth($this->page_title ,0,255),
            "page_content" =>  $this->page_content
        );

        $sql = "UPDATE cms_pages SET "
            ."page_slug"."=:page_slug,"
            ."page_title"."=:page_title,"
            ."page_content"."=:page_content"
            ." WHERE "."page_id"."=:page_id";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($var);

        $this->update_edit_time();
    }
    public function changeState() {
        $var = array(
            "page_id" => $this->page_id,
            "page_state" => $this->page_state,
        );

        $sql = "UPDATE cms_pages SET "
            ."page_state"."=:page_state"
            ." WHERE "."page_id"."=:page_id";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($var);

        $this->update_edit_time();
    }
    public function delete() {
        $var = array(
            "page_id" => $this->page_id,
        );
        $sql = "DELETE"
            ." FROM cms_pages"
            ." WHERE page_id=:page_id";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($var);
    }
    public function update_edit_time() {
        $var = array(
            "page_id" => $this->page_id,
        );

        $sql = "UPDATE cms_pages SET "
            ."page_updated"."=CURRENT_TIMESTAMP"
            ." WHERE "."page_id"."=:page_id";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($var);
    }

    public function TranslatePage() {
        $content = json_decode($this->page_content);
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
                    $convertedHtml .= "<img class='img-fluid' src='$src' title='$caption' alt='$caption' /><br /><em>$caption</em>";
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

        $this->page_content_translated = $convertedHtml;
    }
}
