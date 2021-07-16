<?php


namespace CMS\Model\Shop;


use CMS\Model\Manager;
use PDO;

/**
 * Class: @CategoryModel
 * @package Shop
 * @author BadiiiX | CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class CategoryModel extends Manager
{

    public int $categoryId;
    public string $categoryName;
    public string $categoryDesc;
    public array $categoryItemId;
    public string $categoryPermission;

    private string $categoryTableName = 'cms_shop_categories';
    private string $categoryItemTableName = 'cms_shop_items_categories';


    public function getItems(): array
    {
        $db = self::dbConnect();

        $params = array(
            'category_id' => $this->categoryId
        );
        $items = array();

        $sql = "SELECT * FROM `$this->categoryItemTableName` WHERE shop_category_id = :category_id";
        $req = $db->prepare($sql);
        if ($req->execute($params)) {
            while ($res = $req->fetch()) {
                $items[] = $res['shop_item_id'];
            }
        }
        return $items;
    }

    public function fetch($category_id): bool
    {
        $params = array(
            'category_id' => (string)$category_id
        );

        $sql = "SELECT * FROM `$this->categoryTableName` WHERE shop_category_id=:category_id";

        $db = Manager::dbConnect();
        $req = $db->prepare($sql);
        $res = $req->execute($params);

        if ($res) {
            $result = $req->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                return false;
            }
            foreach ($result as $key => $property) {
                //Remove Shop prefix and camelCase it
                $key = explode('_', $key);
                array_shift($key);
                $firstElement = array_shift($key);
                $key = array_map('ucfirst', $key);
                array_unshift($key, $firstElement);
                $key = implode('', $key);

                if (property_exists(__CLASS__, $key)) {
                    $this->$key = $property ?? '';
                }
            }
        }

        return $res !== false;
    }

    public function fetchAll()
    {
        $db = self::dbConnect();

        $sql = "SELECT * FROM `$this->categoryTableName`";
        $returnArray = [];
        $req = $db->prepare($sql);
        if ($req->execute()) {

            while ($res = $req->fetch()) {

                $category = new self();

                $category->categoryId = (int)$res['shop_category_id'];
                $category->categoryName = $res['shop_category_name'];
                $category->categoryDesc = $res['shop_category_description'] ?? '';
                $category->categoryPermission = $res['shop_category_permission'];

                $returnArray[] = $category;
            }

            return $returnArray;
        }
        return false;
    }

}