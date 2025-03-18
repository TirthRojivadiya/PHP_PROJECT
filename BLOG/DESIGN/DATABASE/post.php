<?php
include_once("DBConnection.php");

class Post extends DBConnection
{
	public function __construct()
	{

		parent::__construct();
	}
	public function insertPost($title, $description, $image, $tag, $date, $id)
	{
		try {
			$insertquery = "INSERT INTO post VALUES(null,'$title','$description','$image','$tag','$date','$id');";
			if ($this->getConnection()->query($insertquery) == true) {
				return 1;
			} else {
				return 0;
			}
		} catch (Exception $e) {
			return 0;
		}
	}
	public function viewAllPost()
	{
		try {
			$select_query = "SELECT user.user_fullname,post.post_title,post.post_description,post.post_image,post.post_date from post JOIN user ON post.user_id;";
			$result = $this->getConnection()->query($select_query);
			if ($result->num_rows > 0) {
				return $result;
			} else {
				return 0;
			}
		} catch (Exception $e) {
			return 0;
		}
	}
	public function viewAllPostUser($id)
	{
		try {
			$select_query = "SELECT * FROM post where post.user_id='$id';";
			$result = $this->getConnection()->query($select_query);
			if ($result->num_rows > 0) {
				return $result;
			} else {
				return 0;
			}
		} catch (Exception $e) {
			return 0;
		}
	}
	public function viewPostByIDEdit($id)
	{
		try {
			$select_query = "SELECT * FROM post where post.post_id='$id';";
			$result = $this->getConnection()->query($select_query);
			if ($result->num_rows > 0) {
				return $result;
			} else {
				return 0;
			}
		} catch (Exception $e) {
			return 0;
		}
	}
	public function deletePostByID($id)
	{
		try {
			$deletequery = "DELETE FROM post where post.post_id='$id'";
			if ($this->getConnection()->query($deletequery) == true) {
				return 1;
			} else {
				return 0;
			}
		} catch (Exception $e) {
			return 0;
		}
	}
	public function UpdatePostByID($title, $description, $image, $tag, $date, $id,$postid)
	{
		try {
			$updatequery = "UPDATE `post` SET `post_title`='$title',`post_description`='$description',`post_image`='$image',`post_tag`='$tag',`post_date`='$date',`user_id`='$id' WHERE post.post_id='$postid'";
			if ($this->getConnection()->query($updatequery) == true) {
				return 1;
			} else {
				return 0;
			}
		} catch (Exception $e) {
			return 0;
		}
	}
	public function viewPostByID($id)
	{
		try {
			$select_query = "SELECT user.user_fullname,post.post_title,post.post_description,post.post_image,post.post_date from post JOIN user ON post.user_id=user.user_id where post.post_id='$id';";
			$result = $this->getConnection()->query($select_query);
			if ($result->num_rows > 0) {
				return $result;
			} else {
				return 0;
			}
		} catch (Exception $e) {
			return 0;
		}
	}
}
