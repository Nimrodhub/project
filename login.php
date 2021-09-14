
<?php 

require_once "conn.php";



if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==='true'){
	// echo "logged in";
  header("location:index.php");
  exit();
}

$username=$password="";
$username_error=$password_error="";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$input_username=trim($_POST['username']);
	if (empty($input_username)) {
		$username_error="Username is required";
	}else{
		$username=$input_username;
	}
	
	$input_password=trim($_POST['password']);
	if (empty($input_password)) {
		$password_error="Password is required";
	}else{
		$password=$input_password;
	}
	if (empty($username_error) && empty($password_error)) {
		// check account details in the database
		$sql="SELECT id,username,email,password FROM patient WHERE username='$username'";

		$query=mysqli_query($conn,$sql);
		if($query){
			if (mysqli_num_rows($query)==1) {
				$userdetails=mysqli_fetch_assoc($query);
				if (password_verify($password,$userdetails['password'])) {
					$_SESSION['username']=$userdetails['username'];
					$_SESSION['email']=$userdetails['email'];
					$_SESSION['loggedin']=true;
					header("location:index.php");
					exit();
				}else{
					$password_error="Wrong credentials";
				}
			}else{
				$username_error="Username does not exist";
			}
		}else{
			echo "Query failed" . mysqli_error($conn);
		}

	}
}


 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Login</title>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width,initial-scale=1.0">
 	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
 	<link rel="stylesheet" type="text/css" href="css/style.css">
 </head>
 <body>
 <div class="container">
 	<div class="row">
 		<div class="col-md-6 offset-3 ">
 			

 			<form action="login.php" method="post">
 				<h3 class="text-center">Login</h3>
 				<div class="form-group">
 					<label for='username'>UserName: </label>
 					<input type="text" class="form-control" id="username" name="username">
 					<span class="text-danger"><?php echo $username_error; ?></span>
 				</div>
 				 <div class="form-group">
 					<label for='password'>Password: </label>
 					<input type="password" class="form-control" id="myInput" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
					<input type="checkbox" onclick="myFunction()">Show Password

							<script>
							function myFunction() {
							    var x = document.getElementById("myInput");
							    if (x.type === "password") {
							        x.type = "text";
							    } else {
							        x.type = "password";
							    }
							}
							</script>
 					
 					<span class="text-danger"><?php echo $password_error; ?></span>
 				</div>

 				 <div class="form-group">
 					<input type="submit" class="btn btn-primary" value="Login">
 				</div>
 				<a href="register.php" class="text-center">Register as new member</a>
 			</form>

 		</div>
 	</div>
 </div>
 </body>
 </html>