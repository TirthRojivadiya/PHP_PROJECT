<?php
session_start();
if(!isset($_SESSION['USERID']))
{
	include_once("header.php");

}
else
{
	include_once("header_dashboard.php");
}
include_once("Database/post.php");
$post=new Post();
$results=$post->viewAllPost();

?>

<div class="container" style="min-height:80vh;">
	<div class="row">
		<div class="col-md-12">
			<?php

			while ($row=$results->fetch_assoc()) { 
			
			



			?>
			<div class="card shadow-lg m-4">
				<div class="media d-flex">
  <div>
  	<img class="mr-3 m-3" src="<?php echo $row['post_image'];?>" width="300px" height="300px" alt="Generic placeholder image">
  	<h6 class="text-center">Author: <?php echo $row['user_fullname'];?></h6>
  	<h6 class="text-center">Date: <?php echo $row['post_date'];?></h6>
  </div>
  <div class="media-body p-4" style="text-align: justify;">
    <h5 class="mt-0"><?php echo $row['post_title'];?></h5>
    <?php echo  $row['post_description'];?>

  </div>
</div>
			</div>

			<?php


}
			?>
		</div>

	</div>
<?php

include_once("footer.php");

?>