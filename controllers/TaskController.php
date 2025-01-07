<?php

require_once __DIR__ . '/../vendor/autoload.php';

class TaskController{
private $db;
private $user;
private $project;
private $task;
private $category;
private $tag;
private $parsedown;

public function __construct(){
    $database =new Database();
    $this->db =$database->getconnection();
    $this->user=new User($this->db);
    $this->project=new Project($this->db);
    $this->task = new Task($this->db);
    $this->category = new Category($this->db);
    $this->tag = new Tag($this->db);
    $this->parsedown = new \Parsedown();
} 
 
 
     public function createTask() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->task->title = $_POST['title'] ?? '';
            $this->task->description = $_POST['description'] ?? '';
            $this->task->description_html = $this->parsedown->text($this->task->description);
            $this->task->status = $_POST['status'] ?? 'toDo';
            $this->task->priority = $_POST['priority'] ?? 'medium';
            $this->task->fin_date = $_POST['fin_date'] ? $_POST['fin_date'] : null;
            $this->task->category_id = $_POST['category_id'] ?? null;
            $this->task->project_id = $_POST['project_id'] ?? '';
            $this->task->assigned_to = $_POST['assigned_to'] ?? null;
            $this->task->created_by = $_SESSION['user_id'] ?? null;

            $task_id = $this->task->createTask();
            if ($task_id) {
                if (isset($_POST['tags']) && is_array($_POST['tags'])) {
                    foreach ($_POST['tags'] as $tag_id) {
                        $this->task->addTag($task_id, $tag_id);
                    }
                }
                header("Location: index.php?action=project_details&id=" . $this->task->project_id);
                exit();
            } else {
                $error = "Failed to create task";
                $project = $this->project->getProjectById($this->task->project_id);
                $categories = $this->category->getAllCategories();
                $tags = $this->tag->getAllTags();
                $users= $this->user->getAllUsers();
                
                include 'views/create_task.php';
            }
        } else {
            $project_id = $_GET['project_id'] ?? '';
            $project = $this->project->getProjectById($project_id);
            $categories = $this->category->getAllCategories();
            $users= $this->user->getAllUsers();
            $tags = $this->tag->getAllTags();
            if ($project) {
                include 'views/create_task.php';
            } else {
                header("Location: index.php?action=dashboard");
                exit();
            }
        }
    }

    public function updateTask() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->task->id = $_POST['id'] ?? '';
                        $this->task->title = $_POST['title'] ?? '';
            $this->task->description = $_POST['description'] ?? '';
             $description_html = $this->parsedown->text($this->task->description);
            $this->task->status = $_POST['status'] ?? '';
            $this->task->priority = $_POST['priority'] ?? '';
            $this->task->fin_date = $_POST['fin_date'] ?? '';
            $this->task->category_id = $_POST['category_id'] ?? null;
            $this->task->assigned_to = $_POST['assigned_to'] ?? null;
                if ($this->task->updateTask()) {
                $current_tags = $this->task->getTaskTags($this->task->id);
                $new_tags = $_POST['tags'] ?? [];
                                foreach ($current_tags as $tag) {
                    if (!in_array($tag['id'], $new_tags)) {
                        $this->task->removeTag($this->task->id, $tag['id']);
                    }
                }               
                foreach ($new_tags as $new_tag_id) {
                    if (!in_array($new_tag_id, array_column($current_tags, 'id'))) {
                        $this->task->addTag($this->task->id, $new_tag_id);
                    }
                }
                
                header("Location: index.php?action=project_details&id=" . $_POST['project_id']);
                exit();
            } else {
                $error = "Failed to update task";
                $task = $this->task->getTaskById($this->task->id);
                $project = $this->project->getProjectById($task['project_id']);
                $categories = $this->category->getAllCategories();
                include 'views/update_task.php';
            }
        } else {
            $task_id = $_GET['id'] ?? '';
            if ($task_id) {
                $task = $this->task->getTaskById($task_id);
                if ($task) {
                    $project = $this->project->getProjectById($task['project_id']);
                    $categories = $this->category->getAllCategories();
                    include 'views/update_task.php';
                } else {
                    header("Location: index.php?action=dashboard");
                    exit();
                }
            } else {
                header("Location: index.php?action=dashboard");
                exit();
            }
        }
    }
    
    public function updateTaskStatus() {
        session_start(); 
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'], $_POST['new_status'], $_POST['project_id'])) {
            $taskId = $_POST['task_id'];
            $newStatus = $_POST['new_status'];
            $projectId = $_POST['project_id']; 
            $stmt = $this->db->prepare("UPDATE tasks SET status = ? WHERE id = ?");
            $success = $stmt->execute([$newStatus, $taskId]);

            if ($success) {
                header("Location: index.php?action=user_dashboard&project_id=" . $projectId);
                exit();
            } else {
                echo "Failed to update task status.";
            }
        } else {
            echo "Invalid request. Missing task_id, new_status, or project_id.";
        }
        exit();
    }
    
    

    public function deleteTask() {
        $task_id = $_GET['id'] ?? '';
        $this->task->id = $task_id;
        $task = $this->task->getTaskById($task_id);
        if ($this->task->deleteTask()) {
            header("Location: index.php?action=project_details&id=" . $task['project_id']);
            exit();
        } else {
            $error = "Failed to delete task";
            header("Location: index.php?action=project_details&id=" . $task['project_id'] . "&error=" . urlencode($error));
            exit();
        

}}
}