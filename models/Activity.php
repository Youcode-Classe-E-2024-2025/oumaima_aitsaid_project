<?php

class Activity {
    private $conn;
    private $table_name = "activities";
    public $id;
    public $project_id;
    public $user_id;
    public $action;
    public $description;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

   

  
}
