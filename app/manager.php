<?php
namespace CMS\Model;

use PDO;

/**
 * Class: @manager
 * @package Core
 * @author CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class manager {
    protected static $db;

    public static function dbConnect() : PDO {
        if(self::$db instanceof PDO) {
            return self::$db;
        }

        self::$db = new \PDO("mysql:host=".getenv("DB_HOST"),getenv("DB_USERNAME"),getenv("DB_PASSWORD"), array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        self::$db->exec("CREATE DATABASE IF NOT EXISTS ".getenv("DB_NAME").";");
        self::$db->exec("USE ".getenv("DB_NAME").";");
        return self::$db;
    }
}