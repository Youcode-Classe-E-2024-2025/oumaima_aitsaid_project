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

    

    
}
?>