<?php

class Tag {
    private $conn;
    private $table_name = "tags";

    public $id;
    public $name;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createTag() {
        $query = "INSERT INTO " . $this->table_name . " (name) VALUES (:name)";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));

        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function getAllTags() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    

    

    
}

