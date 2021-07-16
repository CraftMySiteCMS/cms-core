<?php


namespace CMS\Model\Shop;


use CMS\Model\Manager;

/**
 * Class: @ShopModel
 * @package Shop
 * @author BadiiiX | CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class ShopModel extends Manager
{

    public static function missedTables(): array
    {

        $tableList = ['cms_shop_items', 'cms_shop_categories', 'cms_shop_commands', 'cms_shop_opinions', 'cms_shop_commands_items', 'cms_shop_items_categories'];
        $db = Manager::dbConnect();
        $missedValues = [];
        foreach ($tableList as $table) {
            if (!$db->prepare("DESCRIBE `$table`")->execute()) {
                $missedValues[] = $table;
            }
        }

        return $missedValues;
    }
}