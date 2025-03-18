<?php


session_start();
if (!isset($_SESSION['USERID'])) {
	header("location:signin.php");
	exit();
}
include_once("header_dashboard.php");
include_once("Database/post.php");
if (isset($_POST['edit'])) {
	$pid = $_POST['pid'];
	$view_post_edit = new Post();
	$result = $view_post_edit->viewPostByIDEdit($pid);
	while ($row = $result->fetch_assoc()) {
		$edit_id = $row['post_id'];
		$edit_title = $row['post_title'];
		$edit_description = $row['post_description'];
		$edit_image = $row['post_image'];
		$edit_tag = $row['post_tag'];
		$edit_user_id = $row['user_id'];
	}
}

?>

<?php
if (isset($_POST['submit'])) {
	$status = 0;
	$post_title = $_POST['addpost_title'];
	$post_description = $_POST['addpost_description'];
	$post_image = $_FILES['addpost_image'];
	$post_tag = $_POST['addpost_tag'];


	$post_image_name = $_FILES['addpost_image']['name'];

	if (isset($_POST['image']) && empty($post_image_name)) {
		$post_image_name = $_POST['image'];
		$status = 1;
		$targetFile = $_post_image_name;
		
	}
	$post_image_tempname = $_FILES['addpost_image']['tmp_name'];
	$post_image_size = $_FILES['addpost_image']['size'];
	$post_image_type = $_FILES['addpost_image']['type'];

	$error = [];


	if (empty($post_title) && empty($post_description) && empty($post_image_name)) {
		$error['addpost_required'] = "Add Title, Description And Upload Any Image To Create A Post";
	}
	if (empty($post_title)) {
		$error['title_required'] = "Title Required";
	}
	if (empty($post_description)) {
		$error['description_required'] = "Description Required";
	}
	if (empty($post_image_name)) {
		$error['image_required'] = "Image Required";
	}

	if ($status == 0 && !empty($post_image_name)) {

		$image_type_array = array("image/jpg", "image/jpeg", "image/png", "image/gif");
		if (in_array($post_image_type, $image_type_array)) {
			if ($post_image_size <= 50000 && $post_image_size >= 20000) {
				if (empty($error)) {
					$targetDir = "POST_IMAGES/";
					$targetFile = $targetDir . basename($post_image_name);
					if (move_uploaded_file($post_image_tempname, $targetFile)) {
						// succesfully;
					} else {
						$error['image_upload'] = "Image not Uploaded successfully";
					}
				} else {
					$error['image_upload'] = "Image not Uploaded successfully";
				}
			} else {
				$error['image_size'] = "Uploaded image should contain the following size: less than 50kb and more than 20kb";
			}
		} else {
			$error['image_format'] = "Uploaded an image not containing following format(jpeg,jpg,png,gif)";
		}
	}
	if (!empty($error)) {
		$querystring = http_build_query($error);
		header("location:addpost.php?$querystring");
		exit();
	} else {
		if (isset($_POST['id']) && $_POST['id'] != '') {
			$edit_old_post = new Post();
			$post_id = $_POST['id'];
			$post_date = date("Y-m-d");
			$id = $_SESSION['USERID'];
			$editpostmsg = $edit_old_post->UpdatePostByID($post_title, $post_description, $post_date, $post_tag, $targetFile, $id, $post_id);
		} else {
			$add_new_post = new Post();
			$post_date = date("Y-m-d");
			$id = $_SESSION['USERID'];
			$addpostmsg = $add_new_post->insertPost($post_title, $post_description,$targetFile,$post_tag,$post_date,$id);
		}
	}
} else {
}





?>
<div class="container m-5" style="min-height: 80vh;">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<form action="addpost.php" method="POST" enctype="multipart/form-data" novalidate>
				<div class="card">
					<div class="card-header">
						<?php
						if (isset($_POST['edit'])) {
						?>
							<input type="hidden" name="id" value="<?php echo $edit_id ?>">
							<input type="hidden" name="id" value="<?php echo $edit_image ?>">
						<?php
						}


						?>

						<?php
						if (isset($_GET['addpost_required'])) {
						?>

							<div class="alert alert-danger text-center" role="alert">
								Add Title, Description And Upload Any Image To Create A Post!!
							</div>
						<?php
						}
						?>
						<?php
						if (isset($addpostmsg)) {
							if ($addpostmsg == 1) { ?>
								<div class="alert alert-success text-center" role="alert">
									Bravo!! Your Post has been successfully Added
								</div>

							<?php
							} else { ?>
								<div class="alert alert-danger text-center" role="alert">
									Sorry!! can not add new post please verify your content and resubmit
								</div>
						<?php
							}
						}
						?>
						<?php
						if (isset($editpostmsg)) {
							if ($editpostmsg == 1) { ?>
								<div class="alert alert-success text-center" role="alert">
									 Your Post has been successfully Updated
								</div>

							<?php
							} else { ?>
								<div class="alert alert-danger text-center" role="alert">
									Sorry!! can not update old post please verify your content and resubmit
								</div>
						<?php
							}
						}
						?>
						<?php
						if (isset($_POST['edit'])) {
							echo "Updated Post";
						} else {
							echo "Add Post";
						}

						?>

					</div>
					<div class="card-body">

						<div class="mb-3">
							<label for="title" class="form-label"> Title
							</label>
							<input type="text" name="addpost_title" id="title" required
								class="form-control" value="<?php if (isset($_POST['edit'])) {
																echo $edit_title;
															} ?>">
						</div>
						<?php

						if (isset($_GET['title_required'])) { ?>
							<div class="mb-3">
								<label class="form-label" style="color: red;"> Title Required
								</label>
							</div>




						<?php
						}



						?>
						<div class="mb-3">
							<label for="description" class="form-label"> Describtion
							</label>
							<textarea rows="6" name="addpost_description" id="editor"
								class="form-control"><?php if (isset($_POST['edit'])) {
															echo htmlspecialchars_decode($edit_description);
														} ?></textarea>
						</div>

						<?php

						if (isset($_GET['description_required'])) { ?>
							<div class="mb-3">
								<label class="form-label" style="color: red;"> Description Required
								</label>
							</div>




						<?php
						}



						?>
						<?php if (isset($_POST['edit'])) {
							echo "<img src='" . $edit_image . "'height=100px width=100px>";
						}

						?>
						<div class="mb-3">
							<label for="image" class="form-label"> Upload Image
							</label>
							<input type="file" name="addpost_image" id="image"
								class="form-control">
						</div>

						<?php

						if (isset($_GET['image_required'])) { ?>
							<div class="mb-3">
								<label class="form-label" style="color: red;"> Image Required
								</label>
							</div>




						<?php
						}



						?>


						<?php

						if (isset($_GET['image_format'])) { ?>
							<div class="mb-3">
								<label class="form-label" style="color: red;"> Uploaded an image not containing following format(jpeg,jpg,png,gif)
								</label>
							</div>




						<?php
						}



						?>
						<?php
						if (isset($_GET['image_size'])) { ?>
							<div class="mb-3">
								<label class="form-label" style="color: red;"> Uploaded image should contain the following size: less than 50kb and more than 20kb
								</label>
							</div>




						<?php
						}



						?>
						<?php
						if (isset($_GET['image_upload'])) { ?>
							<div class="mb-3">
								<label class="form-label" style="color: red;"> Image not Uploaded successfully
								</label>
							</div>




						<?php
						}



						?>
						<div class="mb-3">

							<label for="image" class="form-label">Choose Tag
							</label>
							<select name="addpost_tag" class="form-select">
								<option value="Knowledge" <?php echo (isset($_POST['edit']) && $edit_tag == 'Knowledge') ? 'selected' : ''; ?>>Knowledge</option>
								<option value="Science And Technology" <?php echo (isset($_POST['edit']) && $edit_tag == 'Science And Technology') ? 'selected' : ''; ?>>Science And Technology</option>
								<option value="Travel" <?php echo (isset($_POST['edit']) && $edit_tag == 'Travel') ? 'selected' : ''; ?>>Travel</option>
								<option value="Food" <?php echo (isset($_POST['edit']) && $edit_tag == 'Food') ? 'selected' : ''; ?>>Food</option>
								<option value="Movies" <?php echo (isset($_POST['edit']) && $edit_tag == 'Movies') ? 'selected' : ''; ?>>Movies</option>
								<option value="Music" <?php echo (isset($_POST['edit']) && $edit_tag == 'Music') ? 'selected' : ''; ?>>Music</option>
							</select>
						</div>
						<div class="mb-3 d-flex justify-content-between">
							<div>
								<input type="submit" name="submit" value="<?php if (isset($_POST['edit'])) {
																				echo "Update Post";
																			} else {
																				echo "Add Post";
																			}
																			?>" class="btn btn-danger">
								<input type="reset" name="reset" class="btn btn-secondary">

							</div>
							<div>
								<a href="" class="btn btn-primary"> &nbsp; &nbsp;<< Back &nbsp; &nbsp;</a>
							</div>

						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	ClassicEditor
		.create(document.querySelector('#editor'))
		.catch(error => {
			console.error(error);
		});
</script>


<?php

include_once("footer.php")

?>