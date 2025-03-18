<?php
session_start();
if(!isset($_SESSION['USERID']))
{
header("location:signin.php");

}
else
{
	include_once("header_dashboard.php");
	if (isset($_POST['view'])) {
include_once("Database/post.php");
$id=$_POST['pid'];
$view_post= new Post();
$result=$view_post->viewPostByID($id);

	}
}

?>

<div class="container" style="min-height:80vh;">
	<div class="row">
		<div class="col-md-12">
			<?php while ($row=$result->fetch_assoc()) {

			?>
			<div class="card shadow-lg m-5">
				<div class="media d-flex m-3">
  <div>
  	<img class="mr-3 m-3" src="<?php echo $row['post_image']; ?>" width="500px" height="500px" alt="Generic placeholder image">
  	<h6 class="text-center">Author: <?php echo $row['user_fullname']; ?></h6>
  	<h6 class="text-center">Date: <?php echo $row['post_date']; ?></h6>
  </div>
  <div class="media-body p-3" style="text-align: justify;">
    <h4 class="mt-0 mt-3 mb-3"><?php echo $row['post_title']; ?></h4>
    
       <?php
       echo $row['post_description'];
     }
       ?>
  </div>
</div>
			</div>

		</div>

		<div class="row mb-3 justify-content-center">
			<a href="dashboard.php" class="btn btn-primary text-center fw-bold" style="width:400px; height: 50px;"> << Back </a>
			
		</div>
	</div>
<?php

include_once("footer.php");

?>