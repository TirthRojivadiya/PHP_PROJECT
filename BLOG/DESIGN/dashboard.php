<?php
session_start();
if (!isset($_SESSION['USERID'])) {
	header("location:signin.php");
	exit();
} else {
	$id = $_SESSION['USERID'];
	$email = $_SESSION['USEREMAIL'];
}

include_once('header_dashboard.php');
include_once('Database/post.php');
$user_post = new Post();
$result = $user_post->viewAllPostUser($id);


?>
<div class="container mt-5 mb-5 justify-content-center" style="min-height: 80vh;">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<?php echo $email; ?>
				</div>
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Title</th>
							<th scope="col">Tag</th>
							<th scope="col">Date</th>
							<th scope="col">View</th>
							<th scope="col">Edit</th>
							<th scope="col">Delete</th>
						</tr>
					</thead>
					<tbody>

						<?php
						$i = 0;

						while ($row = $result->fetch_assoc()) {

						?>
							<tr>
								<td><?php echo ++$i; ?></td>
								<td><?php echo $row['post_title']; ?></td>
								<td><?php echo $row['post_tag']; ?></td>
								<td><?php echo $row['post_date']; ?></td>
								<td>
									<form action="singleviewpost.php" method="post">
										<input type="hidden" name="pid" value="<?php echo $row['post_id']; ?>">
										<button type="submit" name="view" class="btn btn-info">View</button>
									</form>
								</td>



								<td>
									<form action="addpost.php" method="post">
										<input type="hidden" name="pid" value="<?php echo $row['post_id']; ?>">
										<button type="submit" name="edit" class="btn btn-warning">Edit</button>
									</form>
								</td>



								<td>
									<form action="deletepost.php" method="post">
										<input type="hidden" name="pid" value="<?php echo $row['post_id']; ?>">


										<button type="submit" name="delete" class="btn btn-dark">Delete</button>

									</form>

								</td>
							</tr>
						<?php
						}
						?>

					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>
<?php

include_once('footer.php');
?>