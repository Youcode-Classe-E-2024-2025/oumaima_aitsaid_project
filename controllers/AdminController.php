<?php
class AdminController {
    private $db;
    private $user;
  
    
   

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
       
    }

    public function dashboard() {
        
        include 'views/dashboard.php';
    }
}
?>