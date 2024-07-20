<?php
	$username = $_POST["username"];
	$password = $_POST["password"];
	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$email = $_POST["email"];
	$phone = $_POST["phone"];
	if(isset($username) and isset ($password) and isset($firstname) and isset($lastname) and isset($email) and isset($phone)){
		//echo "Debug> got username=$username;password=$password";
		if (addnewuser($username, $password, $firstname, $lastname, $email, $phone)) {
			echo "Registration Sucessful";
		}else{
			echo "Registration failed";

		}
	}else{
		echo "No username or password set";
	}

  	function addnewuser($username, $password, $firstname, $lastname, $email, $phone) {
  		$mysqli = new mysqli('localhost', 'weltzeme', '1234', 'waph');
  		if($mysqli->connect_errno){
  			printf("Database connection failed: %s\n", $mysqli->connect_error);
  			return FALSE;
  		}
	  	$prepared_sql = "INSERT INTO users (username, password, firstname, lastname, email, phone) VALUES (?, md5(?), ?, ?, ?, ?)";
	  	$stmt = $mysqli->prepare($prepared_sql);
	  	$stmt->bind_param("ss", $username, $password, $firstname, $lastname, $email, $phone);
	  	if($stmt->execute()) return TRUE;
	  	return FALSE;
  	}
?>