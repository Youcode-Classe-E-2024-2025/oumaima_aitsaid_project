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

    public function getTaskById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function updateTask() {
        $query = "UPDATE " . $this->table_name . " 
                  SET title = :title, description = :description, status = :status, 
                      priority = :priority, fin_date = :fin_date, category_id = :category_id, 
                      assigned_to = :assigned_to 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = $this->validateStatus($this->status);
        $this->priority = $this->validatePriority($this->priority);
        $this->fin_date = htmlspecialchars(strip_tags($this->fin_date));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->assigned_to = htmlspecialchars(strip_tags($this->assigned_to));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":priority", $this->priority);
        $stmt->bindParam(":fin_date", $this->fin_date);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":assigned_to", $this->assigned_to);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteTask() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getTasksByProject($project_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE project_id = :project_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":project_id", $project_id);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function getTasksByUser($user_id) {
        $query = "SELECT t.* FROM " . $this->table_name . " t
                  JOIN assign_task at ON t.id = at.task_id
                  WHERE at.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function assignTask($task_id, $user_id) {
        $query = "INSERT INTO assign_task (task_id, user_id) VALUES (:task_id, :user_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":task_id", $task_id);
        $stmt->bindParam(":user_id", $user_id);
        
        return $stmt->execute();
    }

    public function unassignTask($task_id, $user_id) {
        $query = "DELETE FROM assign_task WHERE task_id = :task_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":task_id", $task_id);
        $stmt->bindParam(":user_id", $user_id);
        
        return $stmt->execute();
    }

    public function addTag($task_id, $tag_id) {
        $query = "INSERT INTO task_tags (task_id, tag_id) VALUES (:task_id, :tag_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":task_id", $task_id);
        $stmt->bindParam(":tag_id", $tag_id);
        
        return $stmt->execute();
    }

    public function removeTag($task_id, $tag_id) {
        $query = "DELETE FROM task_tags WHERE task_id = :task_id AND tag_id = :tag_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":task_id", $task_id);
        $stmt->bindParam(":tag_id", $tag_id);
        
        return $stmt->execute();
    }

    public function getTaskTags($task_id) {
        $query = "SELECT t.* FROM tags t
                  JOIN task_tags tt ON t.id = tt.tag_id
                  WHERE tt.task_id = :task_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":task_id", $task_id);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
}

