<?php

require_once __DIR__ . '/../Core/Dbh.php';

class Category extends Dbh {
    private $category_id;
    private $name;

    public function __construct($name = null) {
        $this->name = $name;
    }

    public function insertCategory() {
        $query = "INSERT INTO Category (name) VALUES (:name)";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->execute();
        $stmt = null;
        return parent::connect()->lastInsertId();
    }

    public function getAllCategories() {
        $query = "SELECT * FROM Category";
        $stmt = parent::connect()->prepare($query);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $categories;
    }
}