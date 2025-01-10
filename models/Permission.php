<?php

class Permission {
    private $conn;
    private $table_name = "permissions";

    public function __construct($db){
        $this->conn = $db;
    }

    public function getAllPermissions() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalPermissions() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function createPermission($name) {
        $query = "INSERT INTO " . $this->table_name . " (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function updatePermission($permissionId, $newName) {
        $query = "UPDATE " . $this->table_name . " SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $newName);
        $stmt->bindParam(":id", $permissionId);
        return $stmt->execute();
    }

    public function deletePermission($permissionId) {
        // First, delete any role associations
        $query = "DELETE FROM role_permissions WHERE permission_id = :permission_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":permission_id", $permissionId);
        $stmt->execute();

        // Now delete the permission itself
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $permissionId);
        return $stmt->execute();
    }
}