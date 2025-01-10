<?php

class Role {
    private $conn;
    private $table_name = "roles";

    public function __construct($db){
        $this->conn = $db;
    }

    public function getAllRoles() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalRoles() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function getAllPermissions() {
        $query = "SELECT * FROM permissions";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createRole($name) {
        $query = "INSERT INTO " . $this->table_name . " (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function assignPermission($roleId, $permissionId) {
        $query = "INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role_id", $roleId);
        $stmt->bindParam(":permission_id", $permissionId);
        return $stmt->execute();
    }
    public function assignPermissions($roleId, $permissionIds) {
        // Supprimer d'abord toutes les permissions existantes pour ce rôle
        $query = "DELETE FROM role_permissions WHERE role_id = :role_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role_id", $roleId);
        $stmt->execute();

        // Ajouter les nouvelles permissions
        $query = "INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)";
        $stmt = $this->conn->prepare($query);

        foreach ($permissionIds as $permissionId) {
            $stmt->bindParam(":role_id", $roleId);
            $stmt->bindParam(":permission_id", $permissionId);
            $stmt->execute();
        }

        return true;
    }

    public function getRolePermissions($roleId) {
        $query = "SELECT p.id, p.name FROM permissions p 
                  JOIN role_permissions rp ON p.id = rp.permission_id 
                  WHERE rp.role_id = :role_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role_id", $roleId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Method to update a role's name
    public function updateRole($roleId, $newName) {
        $query = "UPDATE " . $this->table_name . " SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $newName);
        $stmt->bindParam(":id", $roleId);
        return $stmt->execute();
    }

    // Method to delete a role
    public function deleteRole($roleId) {
        // First, delete any permissions related to the role
        $query = "DELETE FROM role_permissions WHERE role_id = :role_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role_id", $roleId);
        $stmt->execute();

        // Now delete the role itself
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $roleId);
        return $stmt->execute();
    }
}
