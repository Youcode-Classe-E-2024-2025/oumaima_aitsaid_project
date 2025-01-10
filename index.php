<?php
session_start();
require_once 'config/Database.php';
require_once 'controllers/AdminController.php';
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
$Admin =new AdminController();

$action = $_GET['action'] ?? 'public_projects';
try{
switch($action){
    case 'users':
        // Fetch all users and their roles
        $Admin->users();
       
        break;
    case 'register':
        $auth->register();
        break;

    case 'login':
        $auth->login();
        break;
    
        case 'dashboard':
           
            $auth->dashboard();
            break; 
             case 'Admin_dashboard':
           
            $Admin->dashboard();
            break; 
            case 'user_dashboard':
           
            $auth->userDashboard();
            break;
            case 'personal_dashboard'  :
                $auth->personalDashboard($_GET['user_id']);
            break;
            case 'export_project_progress':
                if (isset($_GET['project_id'])) {
                    $proj->exportProjectProgress($_GET['project_id']);
                } else {
                    throw new Exception("Project ID is required for exporting project progress.");
                }
                break;
            case 'create_user':
                $Admin->users();
                break;
                case 'createUser':
                $Admin->users();
                $Admin->createUser();
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
                case 'createRole':
                    $Admin->roles();
                    $Admin->createRole();
                    break;
                case 'roles':
                    $Admin->roles();
                    break;
                    case 'updateRole':
                        $Admin->roles();
                        $Admin->updateRole();
                        break;                   
                         case 'deleteUser':
                            $Admin->users();
                        $Admin->deleteUser();
                        break;
                    case 'deleteRole':
                        $Admin->deleteRole();
                        break;
                    case 'permissions':
                        $Admin->permissions() ;
                        break;
                    case 'createPermission':
                        $Admin->createPermission() ;
                        break;
                    case 'updatePermission':
                        $Admin->updatePermission() ;
                        break;
                    case 'deletePermission':
                        $Admin->deletePermission() ;
                        break;
                        
                        
                        case 'update_task_status':
        
            $task->updateTaskStatus() ;
        break;
        case 'view_timeline':
            $task->viewTimeline();
            break;
            case 'updateUserRole':
              $Admin->updateUserRole();
                break;
                case 'assignPermissions':
              $Admin->assignPermissions();
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