<?php
session_start();
require_once 'config/Database.php';
require_once 'controllers/Authcontroller.php';
require_once 'models/User.php';
require_once 'models/Project.php';

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
        default:
    $auth->login();

        break;
}





?>