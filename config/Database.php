<?php
class Database{
   private $host="localhost";
   private $db_name="gestionnaire_de_projets";
   private $username="root";
   private $password="";
   private $conn;
   public function getconnection(){
    $this->conn=null;
    try{
        $this->conn =
        new PDO(
            "mysql:host=".$this->host.";dbname=".$this->db_name,$this->username,$this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    }
catch(PDOExcepton $exception){
    echo "connectionError :".$exception->getMessage();
}

  return $this->conn;
   }






}





?>