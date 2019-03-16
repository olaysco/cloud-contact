<?php

class Database{
	private $host = 'localhost';
	private $db_name = 'cloudcontact';
	private $user = 'root';
	private $password = '';
	public $conn;

	public function getConnection(){
		$this->conn = null;

		try{
			$this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name,$this->user,$this->password);
		}catch(PDOException $exception){
			echo "Connection error: ".$exception->getMessage();
		}
		return $this->conn;
	} 

	
}
?>