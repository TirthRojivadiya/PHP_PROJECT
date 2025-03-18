<?php
session_start();
if(isset($_SESSION['USERID']))
{
	header("location:dashboard.php");
	exit();
}
include_once("header.php");
include_once("Database/user.php");
$reg_fullname='';
    $reg_email='';
    $reg_password='';
    $reg_confirmpassword='';
    $error=[];
?>
<?php
if(isset($_POST['submit']))
{
	$reg_fullname=$_POST['regfullname'];
    $reg_email=$_POST['regemail'];
    $reg_password=$_POST['regpassword'];
    $reg_confirmpassword=$_POST['regconfirmpassword'];
   

    $email_pattern="/^[a-zA-Z0-9.%+-_]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $password_pattern="/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@#$%&*?])[a-zA-Z\d@#$%&*?]{8,}$/";
    $fullname_pattern="/^[A-Z][a-z]+\s{1}[A-Z][a-z]+$/";




    if (empty($reg_fullname) && empty($reg_email) && empty($reg_password) && empty($reg_confirmpassword)) {
    	$error['registration_required']="Registration Required";
    }

    if (empty($reg_fullname)) {
    	$error['reg_fullname']="Enter Your Full Name";
    	$error['regname']=$reg_fullname;
    	$error['regemail']=$reg_email;
    	$error['regpass']= $reg_password;
    	$error['regcpass']=$reg_confirmpassword;

    }

     if (empty($reg_email)) {
    	$error['reg_email']="Enter Email";
    	$error['regname']=$reg_fullname;
    	$error['regemail']=$reg_email;
    	$error['regpass']= $reg_password;
    	$error['regcpass']=$reg_confirmpassword;

    }
    if (empty($reg_password)) {
    	$error['reg_password']="Enter Password";
    	$error['regname']=$reg_fullname;
    	$error['regemail']=$reg_email;
    	$error['regpass']= $reg_password;
    	$error['regcpass']=$reg_confirmpassword;

    }

    if (empty($reg_confirmpassword)) {
    	$error['reg_confirmpassword']="Enter Confirm Password";
    	$error['regname']=$reg_fullname;
    	$error['regemail']=$reg_email;
    	$error['regpass']= $reg_password;
    	$error['regcpass']=$reg_confirmpassword;

    }
    if (!empty($reg_fullname) && !preg_match($fullname_pattern,$reg_fullname)) {
    	$error['invalid_reg_fullname']="Invali Full Name";
    	$error['regname']=$reg_fullname;
    	$error['regemail']=$reg_email;
    	$error['regpass']= $reg_password;
    	$error['regcpass']=$reg_confirmpassword;

    }
    if (!empty($reg_email) && !preg_match($email_pattern,$reg_email)) {
    	$error['invalid_reg_email']="Invali Email";
    	$error['regname']=$reg_fullname;
    	$error['regemail']=$reg_email;
    	$error['regpass']= $reg_password;
    	$error['regcpass']=$reg_confirmpassword;

    }
    if (!empty($reg_password) && !preg_match($password_pattern,$reg_password)) {
    	$error['invalid_reg_password']="Invali Password";
    	$error['regname']=$reg_fullname;
    	$error['regemail']=$reg_email;
    	$error['regpass']= $reg_password;
    	$error['regcpass']=$reg_confirmpassword;

    }
    if (!empty($reg_confirmpassword) && !preg_match($password_pattern,$reg_confirmpassword)) {
    	$error['invalid_reg_confirmpassword']="Invali Confirm Password";
    	$error['regname']=$reg_fullname;
    	$error['regemail']=$reg_email;
    	$error['regpass']= $reg_password;
    	$error['regcpass']=$reg_confirmpassword;

    }


if (!empty($error)) {
$querystring=http_build_query($error);
header("location:signup.php?$querystring");
exit();
} else{
	$add_new_user=new User();
	$insertmsg=$add_new_user->insertUser($reg_fullname,$reg_email,$reg_password);

}



}
else{

}





?>
<div class="container d-flex justify-content-center align-item-center mt-5 mb-5" style="min-height: 80vh;">
	<div class="card p-4 shadow-lg" style="width: 400px; border-radius: 10px;" >

		<?php
		if (isset($_GET['registration_required'])) {
			?>

			<div class="alert alert-danger text-center" role="alert">
                  Registration Required!!
            </div>
            <?php
        }
        ?>
        <?php
        if(isset($insertmsg))
        {
        	if($insertmsg==1)
        	{?>
        		<div class="alert alert-success text-center" role="alert">
                  Congratulation!! Your account has been successfully created.
            </div>

        	<?php
			}
        	else
        	{?>
                <div class="alert alert-danger text-center" role="alert">
                  Sorry!! Registration failed Please verify your detail and resubmit 
            </div>
        	<?php
        }

        }
        ?>

		<h3 class="text-center text-primary mb-4">Sign Up</h3>
		<form action="signup.php" method="post" novalidate>
			<div class="mb-3">
				<label for="fullname" class="form-label"> Full Name
				</label>
				<input type="text" name="regfullname" id="fullname" required
				class="form-control" value="<?php echo isset($_GET['regname'])?$_GET['regname']:$reg_fullname?>">
			</div>


			<?php

			if (isset($_GET['reg_fullname'])) {?>
				<div class="mb-3">
				<label class="form-label" style="color: red;"> Enter Your Full Name
				</label>
			</div>
			



				<?php
			}



			?>

			<?php

			if (isset($_GET['invalid_reg_fullname'])) {?>
				<div class="mb-3">
				<label class="form-label" style="color: red;"> Invali Full Name
				</label>
			</div>
			



				<?php
			}



			?>
			<div class="mb-3">
				<label for="email" class="form-label"> Email
				</label>
				<input type="email" name="regemail" id="email" required
				class="form-control" value="<?php echo isset($_GET['regemail'])?$_GET['regemail']:$reg_email?>">
			</div>

			<?php

			if (isset($_GET['reg_email'])) {?>
				<div class="mb-3">
				<label class="form-label" style="color: red;"> Enter Your Email
				</label>
			</div>
			



				<?php
			}



			?>

			<?php

			if (isset($_GET['invalid_reg_email'])) {?>
				<div class="mb-3">
				<label class="form-label" style="color: red;"> Invali Email
				</label>
			</div>
			



				<?php
			}



			?>
			<div class="mb-3">
				<label for="password" class="form-label"> Password
				</label>
				<input type="password" name="regpassword" id="password" required
				class="form-control" value="<?php echo isset($_GET['regpass'])?$_GET['regpass']:$reg_password?>">
			</div>

			<?php

			if (isset($_GET['reg_password'])) {?>
				<div class="mb-3">
				<label class="form-label" style="color: red;"> Enter Your Password
				</label>
			</div>
			



				<?php
			}



			?>

			<?php

			if (isset($_GET['invalid_reg_password'])) {?>
				<div class="mb-3">
				<label class="form-label" style="color: red;"> Invali Password
				</label>
			</div>
			



				<?php
			}



			?>
			<div class="mb-3">
				<label for="confirmpassword" class="form-label"> Confirm Password
				</label>
				<input type="password" name="regconfirmpassword" id="confirmpassword" required
				class="form-control" value="<?php echo isset($_GET['regcpass'])?$_GET['regcpass']:$reg_confirmpassword?>">
			</div>

			<?php

			if (isset($_GET['reg_confirmpassword'])) {?>
				<div class="mb-3">
				<label class="form-label" style="color: red;"> Enter Your Confirm Password
				</label>
			</div>
			



				<?php
			}



			?>

			<?php

			if (isset($_GET['invalid_reg_confirmpassword'])) {?>
				<div class="mb-3">
				<label class="form-label" style="color: red;"> Invali Confirm Password
				</label>
			</div>
			



				<?php
			}



			?>

			<div class="mb-3">
				<button type="submit" name="submit"class="btn btn-primary w-100"> Register</button>
			</div>

			<div class="mb-3 d-flex text-center justify-content-center">
				<p> Already have an account &nbsp;</p>
				<a href="signin.php">Sign In</a>
			</div>
		</form>
	</div>
</div>
<?php

include_once("footer.php");
?>

