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

    public function setRole($role){
        $this->role = $role ?? 'team_member';
    }
    public function getId() {
        return $this->id;
    }
public function getUserRole($id) {
        $query = "SELECT role FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['role'] ?? null;
    }
    public function getName() {
        return $this->name;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (name, email, password, role) VALUES (:name, :email, :password, :role)";

        $stmt = $this->conn->prepare($query);

        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":role", $this->role);
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

    public function getAllUsers() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUser() {
        $query = "UPDATE " . $this->table_name . " SET name = :name, email = :email, role = :role WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->role = htmlspecialchars(strip_tags($this->role));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteUser() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}


?>