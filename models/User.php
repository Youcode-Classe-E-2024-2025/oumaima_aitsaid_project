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

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (name, email, password, role) VALUES (:name, :email, :password, :role)";

        $stmt = $this->conn->prepare($query);

        // Hash the password
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind the parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":role", $this->role);

        // Execute the query
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    
}
?>