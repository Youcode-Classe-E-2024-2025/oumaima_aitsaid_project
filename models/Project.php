<?php

class Project {
    private $conn;
    private $table_name = "projects";

    public $id;
    public $name;
    public $description;
    public $date_commence;
    public $date_fin;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllProjects() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function createProject() {
        $query = "INSERT INTO " . $this->table_name . " (name, description, date_commence, date_fin, status) VALUES (:name, :description, :date_commence, :date_fin, :status)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":date_commence", $this->date_commence);
        $stmt->bindParam(":date_fin", $this->date_fin);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
 




}