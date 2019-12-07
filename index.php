<?php
	session_start();
	
	if (!isset($_SESSION["begun"]))
	{
		unset($_SESSION["validationMessage"]);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!--
Honor Code: I acknowledge that this code represents my own work: 
Initials: MJR    
Date: September 9th, 2019
-->
<meta charset="UTF-8" />
<meta name="author" content="Mason Rich" />
<meta name="description" content="Keyboard Game login page" />
<meta name="keywords" content="login, keyboard, game, username, password" />

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- My style sheet -->
<link href="styles/index.css" rel="stylesheet" type="text/css"/>
    
<title>Login</title> 
</head>      
   <body>
      
	  <div id="myForm">	  
		  <form id="theForm" method="post">
			  <div id="newUserLogin">
				  <div class="container">
					  <label class="loginLabel" for="uname"><b>Username:</b></label>
					  <input class="loginInput" type="text" placeholder="Enter Username" name="uName" required>
				  </div>

				  <div class="container">
					  <label class="loginLabel" for="pword"><b>Password:</b></label>
					  <input class="loginInput" type="text" placeholder="Enter Password" name="pass" required>
					  <button id="submitBtn" class="button">Login</button>	
				      <button id="signUpBtn" class="button">Sign Up</button>						  
				  </div>
				  
			  </div>

		   </form>
		  
	   </div>
	   
	   <?php
				echo $_SESSION["validationMessage"];
	   ?>
			
	  <script>
	
		document.getElementById('submitBtn').addEventListener('click', submit);
		document.getElementById('signUpBtn').addEventListener('click', signUp);
		
		function submit() {
		  document.getElementById('theForm').setAttribute('action', 'login.php');
		}
		
		function signUp() {
		  document.getElementById('theForm').setAttribute('action', 'signup.php');
		}
	  </script>
      
      
      
      
        <script src="js/jquery.slim.min.js"></script>

   </body>

</html>