<?php
session_start();
require_once 'config/Database.php';
require_once 'controllers/Authcontroller.php';
require_once 'models/User.php';
require_once 'models/Project.php';
require_once 'models/Task.php';
require_once 'models/Category.php';
require_once 'models/Tag.php';

$auth = new AuthController();

$action = $_GET['action'] ?? 'login';

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
        $auth->createProject();
        break;
          case 'update_project':
        $auth->updateProject();
        break;
        case 'delete_project':
            $auth->deleteProject();
            break;
            case 'project_details':
                $auth->projectDetails();
                break;
            case 'create_task':
                $auth->createTask();
                break;
            case 'update_task':
                $auth->updateTask();
                break;
            case 'delete_task':
                $auth->deleteTask();
        
        default:
    $auth->login();

        break;
}





?>