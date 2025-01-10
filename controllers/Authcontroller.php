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
        
        $errors = $this->user->validate();
        if(empty($errors)){
          
                header("Location: index.php?action=login&register=1");
                exit();
            } else {
                $errors[] = "Problem creating user";
            }
        }
        include 'views/register.php';
    
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
      $roles = $this->user->getUserRoles();
      $_SESSION['user_roles'] = array_column($roles, 'name');
      if (in_array('Admin', $_SESSION['user_roles'])) {
        header("Location: index.php?action=dashboard");
    } elseif (in_array('project_manager', $_SESSION['user_roles'])) {
        header("Location: index.php?action=Admin_dashboard");
    } else {
        header("Location: index.php?action=user_dashboard");
    }    exit();
    


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

    public function personalDashboard($userId) {
        $tasks = $this->task->getTasksByUser($userId);

        // Calculer les statistiques
        $totalTasks = count($tasks);
        $completedTasks = count(array_filter($tasks, function($task) {
            return $task['status'] === 'completed';
        }));
        $inProgressTasks = count(array_filter($tasks, function($task) {
            return $task['status'] === 'inProgress';
        }));
        $todoTasks = count(array_filter($tasks, function($task) {
            return $task['status'] === 'toDo';
        }));

        // Charger la vue
        include 'views/personalDashboard.php';
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

   
// AuthController.php
public function userDashboard() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?action=login");
        exit();
    }

    $userId = $_SESSION['user_id'];
    $userName = $_SESSION['user_name'];

    // Fetch assigned projects for the user
    $assignedProjects = $this->user->getAssignedProjects($userId);
    $tasks = [];
    $project = null;

    // Handling task status updates
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task_id']) && isset($_POST['new_status'])) {
        $taskId = $_POST['task_id'];
        $newStatus = $_POST['new_status'];

        // Update task status in the database
        $this->task->updateTaskStatus($taskId, $newStatus);
    }

    // If a project ID is passed, show tasks for that specific project
    if (isset($_GET['project_id'])) {
        $projectId = $_GET['project_id'];
        $project = $this->project->getProjectById($projectId);

        // Fetch tasks related to that project and user
        $tasks = $this->task->getTasksByProjectAndUser($projectId, $userId);
    }

    // Include the dashboard view
    include 'views/user_dashboard.php';
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



}


?>