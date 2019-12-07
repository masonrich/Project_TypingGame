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
		//TODO: Change these to match your DB.
		$db_hostservername = "localhost";
		$db_username = "id11147920_masonjamesrich";
		$db_password = "utahjazz";
		$db_name = "id11147920_keyboard_game";
		
		$connection = new mysqli($db_hostservername, $db_username, $db_password, $db_name);
		
		if ($connection->connect_error)
		{
			die ("Connection failed: " . $connection->connect_error);
		}
		
		//TODO: Change this query to match your DB.
		$sql = "SELECT user_name FROM users WHERE user_name = ('$userName')";	
		//Run query
		$result = mysqli_query($connection, $sql);
		
		//Save query result as a var
		while($temp = $result->fetch_assoc())
		{
			  $finalResult = $temp["user_name"];
		}		
		
		//Make sure username was indeed found in the database
		if ($finalResult != $userName)
		{
			//TODO: change this URL to your url
			header ('Location: https://typegamertype.000webhostapp.com/index.php');
			$_SESSION["validationMessage"] = "<p>Username wasn't found in the database.</p><br>";
		}
		else
		{
			//TODO: Change these two queries to match your DB.
			$fetchedSaltQuery =	"SELECT salt from users WHERE user_name = ('$userName')";
			$fetchedHashQuery = "SELECT hash from users WHERE user_name = ('$userName')";
			//Run queries
			$saltResult = mysqli_query($connection, $fetchedSaltQuery);
			$hashResult = mysqli_query($connection, $fetchedHashQuery);
			
			//Save query result as a var for salt
			while($tempTwo = $saltResult->fetch_assoc())
			{
			  $fetchedSalt = $tempTwo["salt"];
			}
			
			//Save query result as a var for hash
			while($tempThree = $hashResult->fetch_assoc())
			{
			  $fetchedHash = $tempThree["hash"];
			}
			
			//Append user's password with salt from DB
			$saltedPassword = $password;
			$saltedPassword .= $fetchedSalt;
			
			//Hash the salted user's password
			$hashedString = hash("sha256", $saltedPassword);
			
			//If the user's hashed password equals the hash found in the DB, they're logged in successfully
			if ($hashedString == $fetchedHash)
			{
				//TODO: change this URL to your url
				header ('Location: https://typegamertype.000webhostapp.com/game.html');
				unset($_SESSION["validationMessage"]);
				unset($_SESSION["begun"]);
				$_SESSION["currentUsername"] = $userName;
			}
			else
			{
				//TODO: change this URL to your url
				header ('Location: https://typegamertype.000webhostapp.com/index.php');
				$_SESSION["validationMessage"] = "Password did not match. Sorry, try again.";
			}
		}
	}
	else
	{
		header ('Location: https://typegamertype.000webhostapp.com/index.php');
		$_SESSION['validationMessage'] = "Be sure to fill out both the username and password fields.";
	}
	
	die();
?>



	
	