<?php
	session_start();
    //information for your stuff goes here
	$db_hostservername = "localhost";
	$db_username = "id11147920_masonjamesrich";
	$db_password = "utahjazz";
	$db_name = "id11147920_keyboard_game";
    $index = 1;   //used as variable for counter, should reset to one each pull
	$score = $_SESSION['theScore'];
	$username = $_SESSION['currentUsername'];
	
        $connection = mysqli_connect($db_hostservername, $db_username, $db_password, $db_name);
        //new select statement that gets 10 and orders by score
		$sql = "INSERT INTO highscores (user_name, score) VALUES ('" .$username ."', '" .$score ."')";
        $result = mysqli_query($connection, $sql);
        $sql = "SELECT * FROM highscores ORDER BY score DESC LIMIT 10;";
        $result = mysqli_query($connection, $sql);
        if(mysqli_num_rows($result) > 0){
            
            //loop through rows
            while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>'. $index .'</td>';     //display index 1-10
                    echo '<td>'. $row['user_name'] .'</td>'; //display name
                    echo '<td>'. $row['score'] .'</td>';    //display score
                    echo '</tr>';
                    ++$index;                         //incremenet index
            }
        }
?>