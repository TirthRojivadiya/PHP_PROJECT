<?php
include_once("DBConnection.php");

class User extends DBConnection
{
	public function __construct()
	{

		parent::__construct();
	}
	public function insertUser($fullname,$email,$password)
	{
		try{
			$insert_query="INSERT INTO user VALUES(null,'$fullname','$email','$password');";
		if($this->getConnection()->query($insert_query)==true)
		{
			return 1;
		}

		}catch(Exception $e)
		{
            return 0;
		}



	}
	public function loginUser($email,$password)
	{
			$id=0;
			$selectquery="SELECT user.user_id FROM `user` Where user.user_email='$email' and user.user_password='$password';";
			$result=$this->getConnection()->query($selectquery);
			if($result->num_rows>0)
			{
				while ($row=$result->fetch_assoc()) {
					$id=$row['user_id'];
				}
				return $id;
			}
			else{
				return 0;
			}

		



	}
}

?>
