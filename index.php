<?php
session_start();
require_once 'config/Database.php';
require_once 'controllers/Authcontroller.php';
require_once 'controllers/Projectcontroller.php';
require_once 'controllers/Taskcontroller.php';
require_once 'models/User.php';
require_once 'models/Project.php';
require_once 'models/Task.php';
require_once 'models/Category.php';
require_once 'models/Tag.php';
require_once 'models/Activity.php';

$auth = new AuthController();
$proj =new ProjectController();
$task =new TaskController();

$action = $_GET['action'] ?? 'public_projects';
try{
switch($action){

    case 'register':
        $auth->register();
        break;

    case 'login':
        $auth->login();
        break;
    
        case 'dashboard':
           
            $auth->dashboard();
            break; 
            case 'user_dashboard':
           
            $auth->userDashboard();
            break;
        case 'logout':
            session_destroy();
            header("Location:index.php?action=login");
            exit();
            break;
            case 'create_project':
               
        $proj->createProject();
        break;
          case 'update_project':
        $proj->updateProject();
        break;
        case 'delete_project':
            $proj->deleteProject();
            break;
            case 'project_details':
                $proj->projectDetails();
                break;
            case 'create_task':
                $task->createTask();
                break;
            case 'update_task':
                $task->updateTask();
                break;
            case 'delete_task':
                $task->deleteTask();
         case 'public_projects':
                $proj->viewPublicProjects();
               
                break; case 'public_projects':
                $proj->viewPublicProjects();
               
                break;
        case 'update_task_status':
        
            $task->updateTaskStatus() ;
        break;
        case 'view_timeline':
            $task->viewTimeline();
            break;

        default:
        throw new Exception("Page non trouvée");
        
        
}
} catch (Exception $e) {
error_log($e->getMessage());
header("HTTP/1.0 404 Not Found");
include 'views/404.php';
exit();
}






?>