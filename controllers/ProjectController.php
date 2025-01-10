<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
public function exportProjectProgress($projectId) {
    $project = $this->project->getProjectById($projectId);
    $tasks = $this->task->getTasksByProject($projectId);
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Task Title');
    $sheet->setCellValue('B1', 'Status');
    $sheet->setCellValue('C1', 'Priority');
    $sheet->setCellValue('D1', 'Due Date');
    $row = 2;
    foreach ($tasks as $task) {
        $sheet->setCellValue('A' . $row, $task['title']);
        $sheet->setCellValue('B' . $row, $task['status']);
        $sheet->setCellValue('C' . $row, $task['priority']);
        $sheet->setCellValue('D' . $row, $task['fin_date']);
        $row++;
    }
    $writer = new Xlsx($spreadsheet);
    $fileName = 'project_progress_' . $projectId . '.xlsx';
    $writer->save($fileName);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'. $fileName .'"');
    header('Cache-Control: max-age=0');
    readfile($fileName);
    unlink($fileName); 
    exit;
}


public function createProject() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $this->project->name = $_POST['name'] ?? '';
        $this->project->description = $_POST['description'] ?? '';
        $this->project->date_commence = $_POST['date_commence'] ?? '';
        $this->project->date_fin = $_POST['date_fin'] ?? '';
        $this->project->status = $_POST['status'] ?? '';
        $this->project->is_public = isset($_POST['is_public']) ? (int) $_POST['is_public'] : 0;
        $this->project->id_user = $_SESSION['user_id'] ?? null;

        $team_members = $_POST['team_members'] ?? [];

        if ($this->project->createProject()) {
            $project_id = $this->project->getLastInsertId();
            
            // Add team members to the project
            foreach ($team_members as $member_id) {
                $this->project->addProjectMember($project_id, $member_id);
            }

            header("Location: index.php?action=dashboard");
            exit();
        } else {
            $error = "Failed to create project";
            $allUsers = $this->user->getAllUsers();
            include 'views/create_project.php';
        }
    } else {
        $allUsers = $this->user->getAllUsers();
        include 'views/create_project.php';
    }}
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
  
    public function updateTaskStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskId = $_POST['task_id'] ?? null;
            $newStatus = $_POST['new_status'] ?? null;
            if ($taskId && $newStatus) {
                $this->task->updateTaskStatus($taskId, $newStatus);
                echo json_encode(['success' => true]);
                exit;
            }
        }
        echo json_encode(['success' => false]);
        exit;
    }


}