<?php

//$db_server = mysqli_connect("localhost", "id3790675_aayushdubey50", "PurdueBalderdash238!", "id3790675_balderdash");
		$db_server = mysqli_connect("localhost", "id3790675_aayush2", "Purdue123!", "id3790675_balderdash2");
if (!$db_server) {
	echo "Error: Unable to connect to MySQL." . PHP_EOL;
	exit;
}
if ($_POST && isset($_POST["functionName"])) {
    if (is_array($_POST["functionName"])) {
        $functionName = implode(",", $_POST["functionName"]);
    }
    else $functionName = $_POST["functionName"];
}
else $functionName = "username";
$query = "SELECT $functionName FROM users_information WHERE userID = 1";
$result = mysqli_query($db_server, $query);
if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
	    if (explode(",", $functionName) > 1) {
	        $functionName = explode(",", $functionName);
	        foreach ($functionName as $id) echo "ID: " .$row[$id];
	    }
		else echo "ID: " .$row[$functionName];
	}
}
mysqli_close($db_server);
?>
