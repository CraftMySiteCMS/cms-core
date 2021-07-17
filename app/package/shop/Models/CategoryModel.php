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

    public function create()
    {
        $params = array(
            'category_name' => mb_strimwidth($this->categoryName, 0, 255),
            'category_desc' => $this->categoryDesc,
            'category_permissions' => $this->categoryPermission
        );
        $sql = "INSERT INTO `$this->categoryTableName`(shop_category_name, shop_category_description, shop_category_permission) 
                VALUES (:category_name, :category_desc, :category_permissions)";

        $db = Manager::dbConnect();
        $req = $db->prepare($sql);

        if ($req->execute($params)) {
            $this->categoryId = $db->lastInsertId();
            return $this->categoryId;
        }

        return -1;
    }

    public function addItem($itemId): int
    {
        $params = array(
            'itemId' => (int)$itemId,
            'categoryId' => $this->categoryId
        );
        $sql = "INSERT INTO `$this->categoryItemTableName`(shop_item_id, shop_category_id) VALUES (:itemId, :categoryId)";

        $db = Manager::dbConnect();
        $req = $db->prepare($sql);
        $res = $req->execute($params);

        return ($res) ? $itemId : -1;
    }

    public function deleteItem($itemId): int
    {
        $params = array(
            'itemId' => (int)$itemId,
            'categoryId' => $this->categoryId
        );
        $sql = "DELETE FROM `$this->categoryItemTableName`WHERE shop_category_id=:categoryId AND shop_item_id=:itemId";

        $db = Manager::dbConnect();
        $req = $db->prepare($sql);
        $req->execute($params);
        $req->debugDumpParams();

        return ($req->execute($params)) ? $itemId : -1;
    }

    public function delete(): bool
    {
        $resItem = $this->deleteItems();

        $params = array(
            'categoryId' => $this->categoryId,
        );
        $sql = "DELETE FROM `$this->categoryTableName` WHERE shop_category_id=:categoryId";

        $db = Manager::dbConnect();
        $req = $db->prepare($sql);
        return $req->execute($params) && $resItem;
    }

    public function deleteItems(): bool
    {
        $params = array(
            'categoryId' => $this->categoryId,
        );
        $sql = "DELETE FROM `$this->categoryItemTableName` WHERE shop_category_id=:categoryId";

        $db = Manager::dbConnect();
        $req = $db->prepare($sql);
        return $req->execute($params);
    }

}