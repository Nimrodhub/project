<?php 
require_once"conn.php";

$username=$email=$password=$confirm_password="";
$username_error=$email_error=$password_error=$confirm_password_error="";

if ($_SERVER['REQUEST_METHOD']=='POST') {
	$input_username=trim($_POST['username']);
	if (empty($input_username)) {
		$username_error="Username is required";
	}else{
		$sql="SELECT * FROM patient WHERE username='$input_username'";
		$exQuery=mysqli_query($conn,$sql);

		if ($exQuery) {
			if (mysqli_num_rows($exQuery)>0) {
				$username_error="Username already exists";
			}else{
				$username=$input_username;
			}
		}else{
			echo "query failed";

		}

	}
     $input_email=trim($_POST['email']);
if (empty($input_email)) {
	$email_error="email is required";
}else{
	$email=$input_email;
}

$input_password=trim($_POST['password']);
if (empty($input_password)) {
	$password_error="password is required";
}else{
	$password=$input_password;
}

$input_confirm_password=trim($_POST['confirm_password']);
if (empty($input_confirm_password)) {
	$confirm_password_error="confirm password is required";
}else{
	$confirm_password=$input_confirm_password;
	if (empty($password_error) && $password !=$confirm_password) {
		$confirm_password_error="Password do not match";
	}
	

}
if (empty($username_error) && empty($email_error) && empty($password_error) && empty($confirm_password_error)) {
	$hashed_password=password_hash($password, PASSWORD_DEFAULT);
	$sql="INSERT INTO patient(username,email,password) VALUES('$username','$email','$hashed_password')";
	if (mysqli_query($conn,$sql)) {
		header("location:login.php");
		exit();
	}else{
		echo "Error creating account";
	}
}else{
	echo "Field errors";
}

}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
	<div class="container">
	<div class="col-md-6 offset-3">
		<h3 class="text-center">Online Lab Services Reporting System</h3>
<form action="" method="post">
	<h3 class="text-center">Register</h3>
  <div class="form-group">
    <label for="name">name</label>
    <input type="text" class="form-control" id="username" name="username">
    <span class="text-danger"><?php echo $username_error; ?></span>
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
     <span class="text-danger"><?php echo $email_error; ?></span>
  </div>
  <div class="form-group ">
    
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
    <span class="text-danger"><?php echo $password_error; ?></span>
  </div>
  <div class="form-group ">
    
    <label for="confirm_password">Confirm_password</label>
    <input type="password" class="form-control" id="confirm_password" placeholder="Re-enter password"name="confirm_password">
      <span class="text-danger"><?php echo $confirm_password_error; ?></span>

  </div>
  <button type="submit" class="btn btn-primary">Register</button>
  <div>
  <a href="login.php"> Already have an account</a>
</div>
</form>

</div>
</div>
</body>
</html>