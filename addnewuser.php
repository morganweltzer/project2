<?php
	$username = $_POST["username"];
	$password = $_POST["password"];
	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$email = $_POST["email"];
	$phone = $_POST["phone"];
	if(isset($username) and isset ($password)){
		//echo "Debug> got username=$username;password=$password";
		if (addnewuser($username,$password)) {
			echo "Registration Sucessful";
		}else{
			echo "Registration failed";

		}
	}else{
		echo "No username or password set";
	}

  	function addnewuser($username, $password) {
  		$mysqli = new mysqli('localhost', 'weltzeme', '1234', 'waph');
  		if($mysqli->connect_errno){
  			printf("Database connection failed: %s\n", $mysqli->connect_error);
  			return FALSE;
  		}
	  	$prepared_sql = "INSERT INTO users (username,password) VALUES (?,md5(?))";
	  	$stmt = $mysqli->prepare($prepared_sql);
	  	$stmt->bind_param("ss", $username,$password);
	  	if($stmt->execute()) return TRUE;
	  	return FALSE;
  	}
?>