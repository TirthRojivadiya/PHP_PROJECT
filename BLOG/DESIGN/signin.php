<?php
session_start();
if(isset($_SESSION['USERID']))
{
	header("location:dashboard.php");
	exit();
}
include_once("header.php");
include_once("Database/user.php");
$username='';
$userpassword='';
$error=[];
?>
<?php
if(isset($_POST['submit']))
{
$username=$_POST['uemail'];
$userpassword=$_POST['upassword'];


$email_pattern="/^[a-zA-Z0-9.%+-_]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
$password_pattern="/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@#$%&*?])[a-zA-Z\d@#$%&*?]{8,}$/";



if (empty($username)&& empty($userpassword)) {
	$error['login_required']="Login Required";
}
if (empty($username) && !empty($userpassword)) {
	$error['empty_username']="Enter Your Username";
	$error['username']=$username;
	$error['password']=$userpassword;
}
 if (!empty($username) && empty($userpassword)) {
	$error['empty_userpassword']="Enter Your Password";
	$error['username']=$username;
	$error['password']=$userpassword;
}
if (!empty($username) && !preg_match($email_pattern, $username)) {
	$error['invalid_email_format']="Invalid Email Format";
	$error['username']=$username;
	$error['password']=$userpassword;
}
if (!empty($userpassword) && !preg_match($password_pattern, $userpassword)) {
	$error['invalid_password_format']="Invalid Password Format";
	$error['username']=$username;
	$error['password']=$userpassword;
}


if (!empty($error)) {
$querystring=http_build_query($error);
header("location:signin.php?$querystring");
exit();
}
else{
	$login_user = new User();
	$loginmsg=$login_user->loginUser($username,$userpassword);

}



}
else{

}

?>
<div class="container d-flex justify-content-center align-item-center mt-5 mb-5" style="min-height: 80vh;">
	<div class="card p-4 shadow-lg" style="width: 400px; border-radius: 10px;" >
		<?php
		if (isset($_GET['login_required'])) {
			?>

			<div class="alert alert-danger text-center" role="alert">
                Login Required!!
            </div>
            <?php
        }
        ?>
        <?php
        if (isset($loginmsg)) {
        	if ($loginmsg==0) {
				?>
        		<div class="alert alert-danger text-center" role="alert">
              Sorry!! User does not exits try again later
            </div>
        		
        	<?php
			}
        	else{
        		$_SESSION['USERID']=$loginmsg;
				$_SESSION['USEREMAIL']=$username;
        		header("location:dashboard.php");
        		exit();

        	}
        }


        ?>


            
	




		
		<h3 class="text-center text-primary mb-4">Sign In</h3>
		<form action="signin.php" method="post" novalidate>
			<div class="mb-3">
				<label for="email" class="form-label"> Email
				</label>
				<input type="email" name="uemail" id="email" required
				class="form-control" value="<?php echo isset($_GET['username'])? $_GET['username']:$username;?>">
			</div>
			<?php

			if (isset($_GET['empty_username'])) {?>
				<div class="mb-3">
				<label class="form-label" style="color: red"> Enter Your Email
				</label>
			</div>
			



				<?php
			}



			?>

			<?php

			if (isset($_GET['invalid_email_format'])) {?>
				<div class="mb-3">
				<label class="form-label" style="color: red"> Invalid Email Format
				</label>
			</div>
			



				<?php
			}



			?>
			<div class="mb-3">
				<label for="password" class="form-label"> Password
				</label>
				<input type="password" name="upassword" id="password" required
				class="form-control" value="<?php echo isset($_GET['password'])? $_GET['password']:$userpassword;?>">
			</div>

			<?php

			if (isset($_GET['empty_userpassword'])) {
				?>
				<div class="mb-3">
				<label class="form-label" style="color: red"> Enter Your Password
				</label>
			</div>
			



				<?php
			}



			?>

			<?php

			if (isset($_GET['invalid_password_format'])) {?>
				<div class="mb-3">
				<label class="form-label" style="color: red"> Invalid Password Format
				</label>
			</div>
			



				<?php
			}



			?>
			<div class="mb-3">
				<label for="remember" class="form-check-label"> Remember Me
				</label>
				<input type="checkbox" name="uremember" id="remember" 
				class="form-check-input">
			</div>

			<div class="mb-3">
				<button type="submit" name="submit" class="btn btn-primary w-100"> Login</button>
			</div>

			<div class="mb-3 text-center">
				<a href="">Forgot Password</a>
			</div>
		</form>
	</div>
</div>
<?php

include_once("footer.php");

?>

