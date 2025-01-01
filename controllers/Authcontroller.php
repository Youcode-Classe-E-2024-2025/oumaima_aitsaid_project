<?php

class AuthController{
private $db;
private $user;
private $project;

public function __construct(){
    $database =new Database();
    $this->db =$database->getconnection();
    $this->user=new User($this->db);
    $this->project=new Project($this->db);
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

if(empty($email) || empty($password)){
$error ="remplire les champs svp";
include 'views/login.php';
return;
}

if($this->user->login($email, $password)){
      $_SESSION['user_id'] = $this->user->getId();
      $_SESSION['user_name'] = $this->user->getName();
      header("Location: index.php?action=dashboard");
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

public function dashboard() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?action=login");
        exit();
    }
    $userName = $_SESSION['user_name'];
    $projects = $this->project->getAllProjects();
    include 'views/dashboard.php';
}

public function createProject() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $this->project->name = $_POST['name'] ?? '';
        $this->project->description = $_POST['description'] ?? '';
        $this->project->date_commence = $_POST['date_commence'] ?? '';
        $this->project->date_fin = $_POST['date_fin'] ?? '';
        $this->project->status = $_POST['status'] ?? '';

        if ($this->project->createProject()) {
            header("Location: index.php?action=dashboard");
            exit();
        } else {
            $error = "Failed to create project";
            include 'views/create_project.php';
        }
    } else {
        include 'views/create_project.php';
    }
}}


?>