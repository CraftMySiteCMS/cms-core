<?php

namespace CMS\Model;

use PDO;

class Manager {
    protected static $db;

    static function db_connect() : PDO {
        if(Manager::$db instanceof PDO) {
            return Manager::$db;
        } else {
            Manager::$db = new \PDO("mysql:host=".getenv("DB_HOST"),getenv("DB_USERNAME"),getenv("DB_PASSWORD"));
            Manager::$db->query("CREATE DATABASE IF NOT EXISTS ".getenv("DB_NAME").";");
            Manager::$db->query("USE ".getenv("DB_NAME").";");
            return Manager::$db;
        }
    }
}
