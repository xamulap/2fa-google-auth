<?php
define("_EXEC",1);
session_start();

include("./includes/functions.php");
$config = parse_ini_file("/etc/2fa.conf");

$conn = new mysqli($config['mysql_host'],$config['mysql_user'],$config['mysql_pass'],$config['mysql_db']);

?><!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>2FA</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
<!--
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
-->
    <style>
	html { 
	}
	.form-signin .form-floating:focus-within {
	  z-index: 2;
	}
	#floatingInput {
	  margin-bottom: -1px;
	  border-bottom-right-radius: 0;
	  border-bottom-left-radius: 0;
	}

	.form-signin input[type="password"] {
	  margin-bottom: 10px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}
	
    </style>
  </head>
<?php

if(!$_SESSION['admin']) { 
	$username=$_REQUEST['username'];	
	$password=$_REQUEST['password'];
	
	if($username && $password) { 

		$sql="select * from admin where username=?";
		$prep = $conn->prepare($sql);
		$prep->bind_param("s",$username);
		$prep->execute();
		$check = $prep->get_result();
		$check_r = $check->fetch_assoc();
		$password_hash = $check_r['password'];

		if(password_verify($password,$password_hash)) {
			$_SESSION['admin']=true;
		}


	}
}


if(!$_SESSION['admin']) { 


	
?>

    <body class="text-center">
	<main class="form-signin"  style="width: 100%; max-width: 330px;padding-top:100px; margin: auto;">
	  <form action="" method="POST">
	    <h1 class="h3 mb-3 fw-normal">2FA OTP</h1>

	    <div class="form-floating">
	      <input type="text" class="form-control" id="floatingInput" name="username" placeholder="Username" >
	      <label for="floatingInput">Username</label>
	    </div>
	    <div class="form-floating">
	      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
	      <label for="floatingPassword">Password</label>
	    </div>

	    <input type="submit" class="w-100 btn btn-lg btn-primary" >
	  </form>
	</main>
    </div>
<?php
} else { 

	include('./includes/body.php');
}
?>
</html>



