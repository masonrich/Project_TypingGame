<?php
	session_start();
	
	//Username and Password from user
	$userName = $_POST['uName'];
	$password = $_POST['pass'];
	
	$_SESSION["validationMessage"] = "";
	$_SESSION["begun"] = "true";
	
	//Don't run if a blank username or password were submitted.
	if (!empty($userName) && !empty($password))
	{
		//DB connection vars. 
		//TODO:Change these to match your DB.
		$db_hostservername = "localhost";
		$db_username = "id11147920_masonjamesrich";
		$db_password = "utahjazz";
		$db_name = "id11147920_keyboard_game";
		
		$connection = new mysqli($db_hostservername, $db_username, $db_password, $db_name);
		
		if ($connection->connect_error)
		{
			die ("Connection failed: " . $connection->connect_error);
		}
		
		//TODO: Change query to match your DB.
		$sql = "SELECT user_name FROM users WHERE user_name = ('$userName')";	
		//Run query
		$result = mysqli_query($connection, $sql);
		
		//Save query result as a var
		while($temp = $result->fetch_assoc())
		{
			  $finalResult = $temp["user_name"];
		}	

		if (!isset($finalResult))
		{
			$finalResult = "";
		}
				
		//Make sure username doesn't already exist in the database
		if ($finalResult == $userName)
		{
			//TODO: Change this URL to your url
			header ('Location: https://typegamertype.000webhostapp.com/index.php');
			$_SESSION["validationMessage"] = "That username is already taken. Try something different.";
		}
		else
		{
			//Available chars for salt
			$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*)(';
			
			//Randomly mixes string of available chars for salt
			$mixedChars = str_shuffle($permitted_chars);
			
			//Trims random mixture of possible salt and trims it to 12 chars
			$salt = substr($mixedChars, 0, 12);
								
			//Append user's password with salt
			$saltedPassword = $password;
			$saltedPassword .= $salt;
			
			//Hash the salted user's password
			$hashedString = hash("sha256", $saltedPassword);
			
			//TODO: Change these two queries to match your DB.
			$importQuery =	"INSERT INTO users (user_name, salt, hash) VALUES ('$userName', '$salt', '$hashedString')";
			$fetchQuery = "SELECT * from users WHERE user_name = ('$userName')";
			//Run queries
			$runImportQuery = mysqli_query($connection, $importQuery);
			$runFetchQuery = mysqli_query($connection, $fetchQuery);
			
			//Verify that import worked
			while($tempTwo = $runFetchQuery->fetch_assoc())
			{
			  $importSuccess = $tempTwo["user_name"];
			}			
			
			//If the user's hashed password equals the hash found in the DB, they're logged in successfully
			if ($importSuccess == $userName)
			{
				//TODO: Change this URL to your url
				header ('Location: https://typegamertype.000webhostapp.com/game.html');
				unset($_SESSION["validationMessage"]);
				unset($_SESSION["begun"]);
				$_SESSION["currentUsername"] = $userName;
			}
			else
			{
				//TODO: Change this URL to your url
				header ('Location: https://typegamertype.000webhostapp.com/index.php');
				$_SESSION["validationMessage"] = "An error occurred when trying to create user.";
			}
		}
	}
	else
	{
		//TODO: Change this URL to your url
		header ('Location: https://typegamertype.000webhostapp.com/index.php');
		$_SESSION["validationMessage"] = "Be sure to fill out both the username and password fields.";
	}
	
	die();
?>



	
	



	
	