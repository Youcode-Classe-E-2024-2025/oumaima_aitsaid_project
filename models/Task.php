<?php

class Task {
    private $conn;
    private $table_name = "tasks";

    public $id;
    public $title;
    public $description;
    public $status;
    public $priority;
    public $fin_date;
    public $category_id;
    public $project_id;
    public $assigned_to;
    public $created_by;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createTask() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (title, description, status, priority, fin_date, category_id, project_id, assigned_to, created_by) 
                  VALUES 
                  (:title, :description, :status, :priority, :fin_date, :category_id, :project_id, :assigned_to, :created_by)";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = $this->validateStatus($this->status);
        $this->priority = $this->validatePriority($this->priority);
        $this->fin_date = htmlspecialchars(strip_tags($this->fin_date));
        $this->category_id = $this->category_id;
        $this->project_id = $this->project_id;
        $this->assigned_to = $this->assigned_to;
        $this->created_by = htmlspecialchars(strip_tags($this->created_by));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":priority", $this->priority);
        if (empty($this->fin_date)) {
            $stmt->bindValue(":fin_date", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(":fin_date", $this->fin_date);
        }
            $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":project_id", $this->project_id);
        $stmt->bindParam(":assigned_to", $this->assigned_to);
        $stmt->bindParam(":created_by", $this->created_by);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    private function validateStatus($status) {
        $validStatuses = ['toDo', 'inProgress', 'completed'];
        return in_array($status, $validStatuses) ? $status : 'toDo';
    }

    private function validatePriority($priority) {
        $validPriorities = ['low', 'medium', 'high'];
        return in_array($priority, $validPriorities) ? $priority : 'medium';
    }
    

    

    

    

    

    

   

    

    

   

   
}

