<?php 
class User {
    private $id;
    private $name;
    private $email;
    private $password;
    private $role;
    private $conn;
    private $table_name = "users";

    public function __construct($db){
        $this->conn = $db;
    }

    public function setName($name){
        $this->name = htmlspecialchars(strip_tags($name));
    }

    public function setEmail($email){
        $this->email = htmlspecialchars(strip_tags($email));
    }

    public function setPassword($password){
        $this->password = $password;
    }
    public function getId() {
        return $this->id;
    }
    public function getUserRoles() {
        $query = "SELECT r.id, r.name FROM roles r
                  INNER JOIN user_roles ur ON r.id = ur.role_id
                  WHERE ur.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function hasRole($roleName) {
        $query = "SELECT COUNT(*) FROM roles r
                  INNER JOIN user_roles ur ON r.id = ur.role_id
                  WHERE ur.user_id = :user_id AND r.name = :role_name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->id);
        $stmt->bindParam(":role_name", $roleName);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    public function getName() {
        return $this->name;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (name, email, password) VALUES (:name, :email, :password)";

        $stmt = $this->conn->prepare($query);

        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $hashed_password);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function validate(){
        $errors = [];
        if(empty($this->name)){
            $errors[] = "Username is required";
        }
        if(empty($this->email)){
            $errors[] = "Email is required";
        } elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Invalid email format";
        }
        if(empty($this->password)){
            $errors[] = "Password is required";
        } elseif(strlen($this->password) < 6){
            $errors[] = "Password must be at least 6 characters";
        }
        return $errors;
    }

    public function login ($email, $password){
        $query="SELECT id, name, email, password FROM ". $this->table_name ." WHERE  email = :email";
        $stmt =$this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if($stmt->rowCount() == 1)
        {
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password,$row['password'])){
               $this->id=$row['id'];
               $this->name=$row['name'];
               $this->email=$row['email'];
               return true;

            }
        }
        return false;
    }

    public function getUserById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
//new
public function getAllUsers() {
    $query = "SELECT u.*, GROUP_CONCAT(r.name) as roles, GROUP_CONCAT(r.id) as role_ids 
              FROM " . $this->table_name . " u 
              LEFT JOIN user_roles ur ON u.id = ur.user_id 
              LEFT JOIN roles r ON ur.role_id = r.id 
              GROUP BY u.id";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getTotalUsers() {
    $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}
public function createUser($name, $email, $password) {
    $query = "INSERT INTO " . $this->table_name . " (name, email, password) VALUES (:name, :email, :password)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    if($stmt->execute()) {
        return $this->conn->lastInsertId();
    }
    return false;
}

public function assignRole($userId, $roleId) {
    $query = "INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":role_id", $roleId);
    return $stmt->execute();
}
public function deleteUser($userId) {
    try {
        // Delete related records first
        $query = "DELETE FROM user_roles WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();

        // Now delete the user
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $userId);
        
        if ($stmt->execute()) {
            return true;
        }

    } catch (Exception $e) {
        // Log error or output for debugging
        echo "Error: " . $e->getMessage();
    }

    return false;
}

    public function getAssignedProjects($userId) {
        $query = "SELECT p.* 
                  FROM projects p
                  INNER JOIN project_members pm ON p.id = pm.project_id
                  WHERE pm.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateRole($userId, $roleId) {
        // First, delete the existing roles for the user
        $query = "DELETE FROM user_roles WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
    
        // Now, assign the new role
        $query = "INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":role_id", $roleId);
    
        return $stmt->execute();
    }
    
    
}


?>