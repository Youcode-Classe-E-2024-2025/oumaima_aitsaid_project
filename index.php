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
            $auth->dashboard();
            break;
      
        default:
    $auth->login();

        break;
}





?>