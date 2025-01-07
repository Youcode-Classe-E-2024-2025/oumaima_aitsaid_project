<?php

class Activity {
    private $conn;
    private $table_name = "activities";
    public $id;
    public $project_id;
    public $user_id;
    public $action;
    public $description;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function logActivity() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (project_id, user_id, action, description) 
                  VALUES 
                  (:project_id, :user_id, :action, :description)";

        $stmt = $this->conn->prepare($query);

        $this->project_id = htmlspecialchars(strip_tags($this->project_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->action = htmlspecialchars(strip_tags($this->action));
        $this->description = htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(":project_id", $this->project_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":action", $this->action);
        $stmt->bindParam(":description", $this->description);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

  
}
