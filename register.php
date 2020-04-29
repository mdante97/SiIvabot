<?php
include("inc/db.php");
?>
<head>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
</head>
<center>
<form action="" method="post" style="border:1px solid #ccc">
  <title>Register</title>
  <div class="box">
    <h1>New User?</h1>
    <p>Create an account by filling the form below.</p>
    <hr>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <div class="clearfix">
      <button name='submit' type="submit" class="signupbtn">Sign Up</button>
    </div>
  </div>
</form>
</center>
<?php

if(isset($_POST['submit'])){
	$email = $_POST['email'];
	$stmt = $mysqli->prepare("SELECT * from users WHERE email = ?");
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$stmt->store_result();
	if($stmt->num_rows > 0)
		$message = "User with this email already exists!";
	else{
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$stmt = $mysqli->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
		$stmt->bind_param("ss", $email, $password);
		if($stmt->execute())
			$message = "Registration Sucessful!";
		else
			$message = $stmt->error;
	}
	echo "<script>alert('$message');window.location.replace('/login.php');</script>";
}




?>
