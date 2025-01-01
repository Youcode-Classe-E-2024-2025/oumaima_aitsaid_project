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

 




}