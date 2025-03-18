<?php
session_start();
if (!isset($_SESSION['USERID'])) {
	header("location:signin.php");
	exit();
} 
if(isset($_POST['delete']))
{
    include_once('Database/post.php');
    $delete_post= new Post();
    $delete_post->deletePostByID($_POST['pid']);
    header("location:dashboard.php");
}
?>