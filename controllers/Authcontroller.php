<?php

class AuthController{
private $db;
private $user;
private $project;
private $task;
private $category;
private $tag;

public function __construct(){
    $database =new Database();
    $this->db =$database->getconnection();
    $this->user=new User($this->db);
    $this->project=new Project($this->db);
    $this->task = new Task($this->db);
    $this->category = new Category($this->db);
    $this->tag = new Tag($this->db);
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
      $role = $this->user->getUserRole($_SESSION['user_id']);
      $_SESSION['user_role'] = $role;
      switch ($role) {
        case 'admin':
            header("Location: index.php?action=dashboard");
            break;
        case 'team_member':
            header("Location: index.php?action=user_dashboard");
            break;
        case 'project_manager':
            header("Location: index.php?action=manager_dashboard");
            break;
        default:
            header("Location: index.php?action=login");
            break;
    }
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

   
   

    public function createCategory() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->category->name = $_POST['name'] ?? '';
            $this->category->description = $_POST['description'] ?? '';

            if ($this->category->createCategory()) {
                header("Location: index.php?action=manage_categories");
                exit();
            } else {
                echo "Failed to create category";
                include '/create_category.php';
            }
        } else {
            include 'views/create_category.php';
            echo "Failed to create category";
        }
    }

    public function manageCategories() {
        $categories = $this->category->getAllCategories();
        include 'views/manage_categories.php';
    }

    public function createTag() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->tag->name = $_POST['name'] ?? '';

            if ($this->tag->createTag()) {
                header("Location: index.php?action=manage_tags");
                exit();
            } else {
                $error = "Failed to create tag";
                include 'views/create_tag.php';
            }
        } else {
            include 'views/create_tag.php';
        }
    }

    public function manageTags() {
        $tags = $this->tag->getAllTags();
        include 'views/manage_tags.php';
    }


    public function userDashboard() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
        $user_id = $_SESSION['user_id'];
        $user_projects = $this->project->getUserProjects($user_id);
        $user_tasks = $this->task->getTasksByUser($user_id);
        include 'views/user_dashboard.php';
    }

}


?>