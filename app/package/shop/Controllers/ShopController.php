<?php

namespace CMS\Controller\Shop;

use CMS\Controller\CoreController;
use CMS\Controller\users\usersController;
use CMS\Model\Shop\CategoryModel;
use CMS\Model\Shop\ItemModel;
use CMS\Model\Shop\ShopModel;
use JsonException;

/**
 * Class: @ShopController
 * @package Shop
 * @author BadiiiX | CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class ShopController extends CoreController
{

    public string $packageName = 'shop';
    public shopModel $shopModel;
    public ItemModel $itemModel;
    public categoryModel $categoryModel;

    public array $itemsList;

    public array $categoriesList;

    public function __construct($theme_path = null)
    {
        parent::__construct($theme_path);
        $this->shopModel = new shopModel();
        $this->itemModel = new ItemModel();
        $this->categoryModel = new categoryModel();

        $this->itemsList = $this->itemModel->fetchAll();
        $this->categoriesList = $this->categoryModel->fetchAll();

    }

    /**
     * Routes Functions
     */


    public function show(): void
    {
        usersController::isAdminLogged();


        $themePath = CoreController::$themePath;

        echo 'Bienvenue sur la boutique plus vide que mon esprit !';

        require("$themePath/views/shop/show.view.php");
    }

    public function listItemsAdmin(): void
    {
        usersController::isAdminLogged();
        $itemList = $this->itemsList;

        require('app/package/shop/views/list.items.admin.view.php');
    }

    public function listCategoriesAdmin(): void
    {
        usersController::isAdminLogged();

        $categoriesList = $this->categoriesList;
        $itemList = $this->itemsList;

        require('app/package/shop/views/list.categories.admin.view.php');
    }

    public function addItemAdmin(): void
    {
        usersController::isAdminLogged();

        $categoriesList = $this->categoriesList;
        require('app/package/shop/views/add.items.admin.view.php');
    }

    public function addItemPostAdmin(): void
    {
        usersController::isAdminLogged();

        $addedItem = new ItemModel();
        $addedItem->itemName = $_POST['item_name'];
        $addedItem->itemDescription = 'NOT IMPLEMENTED';
        $addedItem->itemThumbnail = 'NOT IMPLEMENTED';
        $addedItem->itemPrice = (float)$_POST['item_price'];
        $addedItem->itemUserLimit = (int)$_POST['item_userLimit'];
        $addedItem->itemStock = (int)$_POST['item_stock'];
        $addedItem->itemState = 1;

        echo $addedItem->create($_POST['item_categories']);
    }

    public function deleteItemPostAdmin(): void
    {
        usersController::isAdminLogged();

        $itemId = (int)$_POST['item_id'];
        $removedItem = new ItemModel();

        $removedItem->fetch($itemId);
        echo $removedItem->delete();
    }

    /**
     * @throws JsonException
     */
    public function homeAdmin(): void
    {
        usersController::isAdminLogged();

        $initErrors = $this->initErrors();

        require('app/package/shop/views/home.admin.view.php');
    }


    /**
     * Utils Functions
     * @throws JsonException
     */

    public function initErrors(): array
    {
        $returnArray = [];

        if (!$this->cmsPackageAvailableTheme($this->packageName)) {
            $returnArray['theme_error'] = SHOP_ERROR_INCOMPATIBLE_THEME;
        }

        $missedTables = shopModel::missedTables();
        if (count($missedTables) > 0) {

            $arrayToHtml = '<ul>';
            foreach ($missedTables as $table) {
                $arrayToHtml .= " <li><b>$table</b></li>  ";
            }
            $arrayToHtml .= ' </ul>';
            $returnArray['missing_tables'] = SHOP_ERROR_MISSING_TABLE . $arrayToHtml;
        }

        return $returnArray;
    }
}