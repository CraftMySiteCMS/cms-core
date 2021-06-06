<?php

namespace CMS\Model;

class Database {
    protected function dbConnect() {
        $db = new \PDO("mysql:host=localhost;dbname=cms","root","root");
        $db->exec('SET NAMES utf8mb4');
        return $db;
    }

    static function dbSConnect() {
        $db = new \PDO("mysql:host=localhost;dbname=cms","root","root");
        $db->exec('SET NAMES utf8mb4');
        return $db;
    }
}