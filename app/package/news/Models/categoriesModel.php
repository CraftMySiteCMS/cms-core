<?php

namespace CMS\Model;

use stdClass;

class CategoriesModel extends Database {

    public $category_id;
    public $category_name;
    public $category_slug;
    public $category_description;
    public $category_created;
    public $category_updated;

    public static function checkCategory($var, $is_slug = null) {
        if($is_slug) $var = array("category_slug" => $var);
        else $var = array("category_id" => $var);

        $sql = "SELECT COUNT(category_id) as exist"
            ." FROM cms_categories";
        if($is_slug) $sql .= " WHERE category_slug=:category_slug";
        else $sql .= " WHERE category_id=:category_id";

        $db = Database::dbSConnect();
        $req = $db->prepare($sql);
        $req->execute($var);

        return $req->fetchColumn();
    }

    public function getCategory() {
        $var = array(
            "category_slug" => $this->category_slug
        );

        $sql = "SELECT category_id, category_name, category_slug, category_description, DATE_FORMAT(category_created, '%d/%m/%Y à %H:%i:%s') AS 'category_created', DATE_FORMAT(category_updated, '%d/%m/%Y à %H:%i:%s') AS 'category_updated' FROM cms_categories WHERE category_slug=:category_slug";

        $db = $this->dbConnect();
        $req = $db->prepare($sql);
        $req->execute($var);

        if($req) :
            $result = $req->fetch();
            foreach ($result as $key => $property) :
                if(property_exists(CategoriesModel::class, $key)) :
                    $this->$key = $property;
                endif;
            endforeach;
        endif;
    }
}