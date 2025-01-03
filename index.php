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

$auth = new AuthController();
$proj =new ProjectController();
$task =new TaskController();

$action = $_GET['action'] ?? 'public_projects';

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
               
                break; 
                case 'dashboard_user':
                $proj->userDashboard();
               
                break;
        
        default:
    $auth->login();

        break;
}





?>