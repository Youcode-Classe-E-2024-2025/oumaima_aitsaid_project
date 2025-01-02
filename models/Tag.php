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

    public function getTagById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function updateTag() {
        $query = "UPDATE " . $this->table_name . " SET name = :name WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteTag() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

