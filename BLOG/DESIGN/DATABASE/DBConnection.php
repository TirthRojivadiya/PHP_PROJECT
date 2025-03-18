<?php

class DBConnection
{
	private $host="localhost";
	private $username="root";
	private $password="";
	private $dbname="blog_information";
	private $conn;

	public function __construct()
	{
		$this->connect();
	}

	private function connect()
	{
		$this->conn = new mysqli($this->host,$this->username,$this->password,$this->dbname);
		if ($this->conn->connect_error) {
			die("Failed Connection:".$this->conn->connect_error);

		}
	}

	public function getConnection(){
	
		return $this->conn;


	}

	public function closeConnection(){
		return $this->conn->close();
		
	}
}
$db = new DBConnection();
$db->getConnection();
$db->closeConnection();


?>
