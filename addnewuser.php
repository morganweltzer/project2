<?php
	$username = $_POST["username"];
	$password = $_POST["password"];
	if(isset($username) and isset($password)){
		echo "Debug> got username=$username;password=$password";
		/*if (checklogin_mysql($_POST["username"],$_POST["password"])) {
			$_SESSION['authenticated'] = TRUE;
			$_SESSION['username'] = $_POST["username"];
			$_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
		}else{
		session_destroy();	
			echo "<script>alert('Invalid username/password');window.location='form.php';</script>";
			die();
		}*/
	}else{
		echo "No username or password";
	}
  	function checklogin_mysql($username, $password){
  		$mysqli = new mysqli('localhost', 'weltzeme', '1234', 'waph');
  		if($mysqli->connect_errno){
  			printf("Database connection failed: %s\n", $mysqli->connect_error);
  			exit();
  		}
	  	$sql = "SELECT * FROM users WHERE username=? AND password = md5(?)";
	  	$sql = $sql . " AND password = md5('" . $password . "')";
	  	// echo "DEBUG>sql=$sql"; return TRUE;
	  	$stmt = $mysqli->prepare($sql);
	  	$stmt->bind_param("ss", $username, $password);
	  	$stmt->execute();
	  	$result=$stmt->get_result();
	  	if($result->num_rows ==1) return TRUE;
	  	return FALSE;
  	}

?>