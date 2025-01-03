

<?php

class ProjectController{
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
public function createProject() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $this->project->name = $_POST['name'] ?? '';
        $this->project->description = $_POST['description'] ?? '';
        $this->project->date_commence = $_POST['date_commence'] ?? '';
        $this->project->date_fin = $_POST['date_fin'] ?? '';
        $this->project->status = $_POST['status'] ?? '';
        $this->project->is_public = isset($_POST['is_public']) ? 1 : 0;
        $this->project->id_user = $_SESSION['user_id'] ?? null;

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
}
 public function updateProject() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->project->id = $_POST['id'] ?? '';
            $this->project->name = $_POST['name'] ?? '';
            $this->project->description = $_POST['description'] ?? '';
            $this->project->date_commence = $_POST['date_commence'] ?? '';
            $this->project->date_fin = $_POST['date_fin'] ?? '';
            $this->project->status = $_POST['status'] ?? '';
            $this->project->is_public = isset($_POST['is_public']) ? 1 : 0;

            if ($this->project->updateProject()) {
                header("Location: index.php?action=dashboard&id=" . $this->project->id);
                exit();
            } else {
                $error = "Failed to update project";
                $project = $this->project->getProjectById($this->project->id);
                include 'views/update_project.php';
            }
        } else {
            $project_id = $_GET['id'] ?? '';
            $project = $this->project->getProjectById($project_id);
            if ($project) {
                include 'views/update_project.php';
            } else {
                header("Location: index.php?action=dashboard");
                exit();
            }
        }
    }

    public function deleteProject() {
        $project_id = $_GET['id'] ?? '';
        $this->project->id = $project_id;
        if ($this->project->deleteProject()) {
            header("Location: index.php?action=dashboard");
            exit();
        } else {
            $error = "Failed to delete project";
            header("Location: index.php?action=dashboard&error=" . urlencode($error));
            exit();
        }
    }
    public function projectDetails() {
        $project_id = $_GET['id'] ?? '';
        $project = $this->project->getProjectById($project_id);
        if ($project) {
            $tasks = $this->task->getTasksByProject($project_id);
            include 'views/project_details.php';
        } else {
            header("Location: index.php?action=dashboard");
            exit();
        }
    }
    public function viewPublicProjects() {
        $projects = $this->project->readPublic();
        
       
        
        include 'views/public_projects.php';
    }


    public function userDashboard() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
        $user_id = $_SESSION['user_id'];
        $user_projects = $this->project->getUserProjects($user_id);
        include 'views/user_dashboard.php';
    }


}