<?php

class Task {
    private $conn;
    private $table_name = "tasks";
    public $id;
    public $title;
    public $description;
    public $status;
    public $priority;
    public $fin_date;
    public $category_id;
    public $project_id;
    public $assigned_to;
    public $created_by;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    

   

   

    

    

    

    

    

   

    

    

   

   
}

