<?php

if ($_GET && isset($_GET["username"])) {
	$username = $_GET["username"];
	//$db_server = mysqli_connect("localhost", "id3790675_aayushdubey50", "PurdueBalderdash238!", "id3790675_balderdash");
	$db_server = mysqli_connect("localhost", "id3790675_aayush2", "Purdue123!", "id3790675_balderdash2");
	if (!$db_server) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		exit;
	}
    $query = "SELECT userID FROM users_information WHERE username='$username' LIMIT 1;";
	$result = mysqli_query($db_server, $query);
	if(mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		mysqli_close($db_server);
		echo $row["userID"];
	} else echo "-1";
}
?>
