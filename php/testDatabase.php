<?php

$db_server = mysqli_connect("localhost", "id3790675_aayushdubey50", "PurdueBalderdash238!", "id3790675_balderdash");
if (!$db_server) {
	echo "Error: Unable to connect to MySQL." . PHP_EOL;
	exit;
}
$functionName = $_POST["functionName"];
$query = "SELECT $functionName FROM users_information WHERE userID = 1";
$result = mysqli_query($db_server, $query);
if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		echo "ID: " .$row['username'];
	}
}
mysqli_close($db_server);
?>