<?php
session_start();
require_once 'config/Database.php';
require_once 'controllers/Authcontroller.php';
require_once 'models/User.php';

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
            if (isset($_SESSION['user_id'])) {
                echo "Welcome, " . htmlspecialchars($_SESSION['user_name']) . "!";
                header("Location: index.php?action=login");
            } else {
                
                header("Location: views/dashboard.php");
                exit();
            }
            break;
    default:
    $auth->login();

        break;
}





?>