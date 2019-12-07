<?php


	$db_hostservername = "localhost";
	$db_username = "id11147920_masonjamesrich";
	$db_password = "utahjazz";
	$db_name = "id11147920_keyboard_game";


    $connection = mysqli_connect($db_hostservername, $db_username, $db_password, $db_name);
	
    //if it cannot connect
	if ($connection->connect_error)
	{
		die ("Connection failed: " . $connection->connect_error);
	}

	
	//using RAND() is alternatively slow test with 20 for ease
	$sql = "SELECT word FROM words ORDER BY RAND() LIMIT 4500;";

    

    //insert result
    $result = mysqli_query($connection, $sql); 

    $outp = $result->fetch_all(MYSQLI_ASSOC);
    
    echo json_encode($outp);



	$connection->close();

?> 