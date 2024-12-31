<?php

class AuthController{
private $db;
private $user;

public function __construct(){
    $database =new Database();
    $this->db =$database->getconnection();
    $this->user=new User($this->db);
}



}


?>