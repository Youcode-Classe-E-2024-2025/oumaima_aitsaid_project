<?php

class Project {
    //attributs
    private $conn;
    private $table_name = "projects";
    public $id;
    public $name;
    public $description;
    public $date_commence;
    public $date_fin;
    public $status;
    public $is_public;
    public $id_user;
    //constructeurs
    public function __construct($db) {
        $this->conn = $db;
    }
//get All Project
    public function getAllProjects() {
        $query = "SELECT * FROM " . $this->table_name;                                              
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
//Create Project
    public function createProject() {
        $query = "INSERT INTO " . $this->table_name . " 
        (name, description, date_commence, date_fin, status, is_public, id_user) 
        VALUES 
        (:name, :description, :date_commence, :date_fin, :status, :is_public, :id_user)";
    $stmt = $this->conn->prepare($query);

     $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->date_commence = htmlspecialchars(strip_tags($this->date_commence));
        $this->date_fin = htmlspecialchars(strip_tags($this->date_fin));
        $this->status = $this->validateStatus($this->status);
        $this->is_public = (int) $this->is_public;
        $this->id_user= $this->id_user;
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":date_commence", $this->date_commence);
        $stmt->bindParam(":date_fin", $this->date_fin);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":is_public", $this->is_public, PDO::PARAM_INT);
                $stmt->bindParam(":id_user", $this->id_user);

    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    //update Project
    public function updateProject() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name, description = :description, date_commence = :date_commence, 
                      date_fin = :date_fin, status = :status, is_public = :is_public 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->date_commence = htmlspecialchars(strip_tags($this->date_commence));
        $this->date_fin = htmlspecialchars(strip_tags($this->date_fin));
        $this->status = $this->validateStatus($this->status);
        $this->is_public = $this->is_public ? 1 : 0;

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":date_commence", $this->date_commence);
        $stmt->bindParam(":date_fin", $this->date_fin);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":is_public", $this->is_public);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //delete Project 
    public function deleteProject() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //public Project
    public function readPublic() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE is_public = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //project Id
    
    public function getProjectById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }



//last Id Project
    public function getLastInsertId() {
        return $this->conn->lastInsertId();
    }
    
    public function addProjectMember($project_id, $user_id, $role = 'member') {
        $query = "INSERT INTO project_members (project_id, user_id, role) VALUES (:project_id, :user_id, :role)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":project_id", $project_id);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":role", $role);
        return $stmt->execute();
    }
 


//valideStatus

        private function validateStatus($status) {
         $validStatuses = ['not_started', 'in_progress', 'completed'];
            if (in_array($status, $validStatuses)) {
             return $status;
         }
         return 'false';}
    
      
      
        
    //get Project User
        public function getUserProjects($user_id) {
            $query = "SELECT p.* FROM " . $this->table_name . " p
                      JOIN project_members pm ON p.id = pm.project_id
                      WHERE pm.user_id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $user_id);
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return false;
        }
       
    
    }