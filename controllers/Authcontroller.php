<?php

class AuthController{
private $db;
private $user;

public function __construct(){
    $database =new Database();
    $this->db =$database->getconnection();
    $this->user=new User($this->db);
}

public function register(){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $this->user->setName($_POST['username'] ?? '');
        $this->user->setEmail($_POST['email'] ?? '');
        $this->user->setPassword($_POST['password'] ?? '');
        $this->user->setRole('team_member');
        
        $errors = $this->user->validate();
        if(empty($errors)){
            if($this->user->create()){
                header("Location: index.php?action=login&register=1");
                exit();
            } else {
                $errors[] = "Problem creating user";
            }
        }
        include 'views/register.php';
    } else {
        include 'views/register.php';
    }
}

public function login(){
if($_SERVER["REQUEST_METHOD"] == "POST"){

$email=$_POST['email'] ?? '';
$password =$_POST['password'] ?? '';

if(empty($email) || empty($password))
$error ="remplire les champs svp";

include 'views/login.php';
return;


$stmt =$this->db->prepare("SELECT * FROM users WHERE email= :email");
$stmt ->bindParam(':email',$email);
$stmt->execute();
$user=$stmt->fetch(PDO::FETCH_ASSOC);

if($user && password_verify($password,$user['password'])){
      $_SESSION['user_id'] =$user['id'];
      $_SESSION['user_name'] =$user['name'];
      header("location:index.php?action:dashboard");
      exit();


}
else{
    $error ="Invalid email or password";
    include 'views/login.php';
}

}
else {
    include 'views/login.php';
}


}

}


?>