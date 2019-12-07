<?php
session_start();

if (isset($_SESSION['currentUsername']))
{
	echo 'Good game, ' .$_SESSION['currentUsername'] .'. Your score was ' .$_GET['score'] .'.';
}
$_SESSION['theScore'] = $_GET['score'];
?>

<!DOCTYPE html> 
<!--this is a php document-->
<html lang="en">
<head>
<!--
Honor Code: I acknowledge that this code represents my own work: 
Initials: *****REPLACE*****    
Date: 
-->
<meta charset="UTF-8" />
<meta name="author" content="Alec Combe" />
<meta name="description" content="Display highscore" />
<meta name="keywords" content="highscore, table, scores" />
    
    <link rel="stylesheet" href="styles/highscores.css">

<title>Highscores</title> 
</head>      
   <body>

          <div class="container">
            <label id="highscores"><p>Highscores</p></label>
            <table name="scores">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Score</th>
                </tr>
            <?php require 'table.php';?>
            
              </table>
          </div>
          
       <!--</form>-->
   </body>

</html>
