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
        $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXEPTION);

    }
catch(PDOExepton $e){
    echo "connectionError :".$e->getMessage();
}

  return $this->conn;
   }






}





?>