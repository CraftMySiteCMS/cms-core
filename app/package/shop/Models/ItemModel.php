<?php


namespace CMS\Model\Shop;

use CMS\Model\Manager;
use PDO;

/**
 * Class: @ItemModel
 * @package Shop
 * @author BadiiiX | CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class ItemModel extends Manager
{
    public int $itemId;
    public string $itemName;
    public float $itemPrice;
    public int $itemStock;
    public array $itemCategoriesId;
    public string $itemDescription;
    public string $itemThumbnail;
    public int $itemUserLimit;
    public bool $itemState;

    private string $itemTableName = 'cms_shop_items';
    private string $itemCategoryTableName = 'cms_shop_items_categories';


    public function getCategories(): array
    {
        $db = self::dbConnect();

        $params = array(
            'item_id' => $this->itemId
        );
        $categories = array();

        $sql = "SELECT * FROM `$this->itemCategoryTableName` WHERE shop_item_id = :item_id";
        $req = $db->prepare($sql);
        if ($req->execute($params)) {
            while ($res = $req->fetch()) {
                $categories[] = $res['shop_category_id'];
            }
        }
        return $categories;
    }

    public function create($category_id): bool
    {
        return $this->createItem() !== -1 && $this->addCategories($category_id);
    }

    public function createItem(): int
    {
        $params = array(
            'item_name' => mb_strimwidth($this->itemName, 0, 255),
            'item_price' => $this->itemPrice,
            'item_stock' => $this->itemStock,
            'item_description' => $this->itemDescription,
            'item_thumbnail' => $this->itemThumbnail,
            'item_userlimit' => $this->itemUserLimit,
            'item_state' => $this->itemState
        );
        $sql = "INSERT INTO `$this->itemTableName`(shop_item_name, shop_item_price, shop_item_stock, shop_item_description, shop_item_thumbnail, shop_item_userlimit, shop_item_state) 
                VALUES (:item_name, :item_price, :item_stock, :item_description, :item_thumbnail, :item_userlimit, :item_state)";

        $db = Manager::dbConnect();
        $req = $db->prepare($sql);

        if ($req->execute($params)) {
            $this->itemId = $db->lastInsertId();
            return $this->itemId;
        }

        return -1;
    }

    public function delete(): bool
    {
        $resCategory = $this->deleteCategories();

        $params = array(
            'item_id' => $this->itemId,
        );
        $sql = "DELETE FROM `$this->itemTableName` WHERE shop_item_id=:item_id";

        $db = Manager::dbConnect();
        $req = $db->prepare($sql);
        return $req->execute($params) && $resCategory;
    }

    public function deleteCategories(): bool
    {
        $params = array(
            'item_id' => $this->itemId,
        );
        $sql = "DELETE FROM `$this->itemCategoryTableName` WHERE shop_item_id=:item_id";

        $db = Manager::dbConnect();
        $req = $db->prepare($sql);
        return $req->execute($params);
    }


    public function addCategory($categoryId): int
    {
        $params = array(
            'category_id' => (int)$categoryId,
            'item_id' => $this->itemId
        );
        $sql = "INSERT INTO `$this->itemCategoryTableName`(shop_item_id, shop_category_id) VALUES (:item_id, :category_id)";

        $db = Manager::dbConnect();
        $req = $db->prepare($sql);

        return ($req->execute($params)) ? $categoryId : -1;
    }


    public function addCategories(array $categoryId): bool
    {
        $returnValue = -1;

        foreach ($categoryId as $category) {
            $returnValue = ($this->addCategory($category) !== -1) ? $returnValue : -1;
        }
        return $returnValue;
    }

    public function fetch($item_id): bool
    {
        $params = array(
            'item_id' => (int)$item_id
        );

        $sql = "SELECT * FROM `$this->itemTableName` WHERE shop_item_id=:item_id";

        $db = Manager::dbConnect();
        $req = $db->prepare($sql);
        $res = $req->execute($params);

        if ($res) {
            $result = $req->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                return false;
            }
            foreach ($result as $key => $property) {
                //Remove Shop prefix and camel case it
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

        $sql = "SELECT * FROM `$this->itemTableName`";
        $returnArray = [];
        $req = $db->prepare($sql);
        if ($req->execute()) {

            while ($res = $req->fetch()) {

                $item = new self();

                $item->itemId = (int)$res['shop_item_id'];
                $item->itemName = $res['shop_item_name'];
                $item->itemPrice = (float)$res['shop_item_price'];
                $item->itemStock = (int)$res['shop_item_stock'];
                $item->itemDescription = $res['shop_item_description'];
                $item->itemThumbnail = $res['shop_item_thumbnail'] ?? '';
                $item->itemUserLimit = (int)$res['shop_item_userLimit'];
                $item->itemState = (bool)$res['shop_item_state'];

                $returnArray[] = $item;
            }

            return $returnArray;
        }
        return false;
    }

}