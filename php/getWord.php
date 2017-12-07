<?php

	if ($_GET && isset($_GET["gameID"])) {
		$gameID = $_GET["gameID"];
		//$db_server = mysqli_connect("localhost", "id3790675_aayushdubey50", "PurdueBalderdash238!", "id3790675_balderdash");
		$db_server = mysqli_connect("localhost", "id3790675_aayush2", "Purdue123!", "id3790675_balderdash2");
		if (!$db_server) {
			echo "Error: Unable to connect to MySQL." . PHP_EOL;
			exit;
		}
	    $query = "SELECT currentWordID FROM all_games WHERE gameID=$gameID LIMIT 1;";
	    $toPrint = "";
		$result = mysqli_query($db_server, $query);
		if(mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$wordID = $row["currentWordID"];
			$query = "SELECT word FROM all_words WHERE wordID=$wordID LIMIT 1;";
			$result = mysqli_query($db_server, $query);
			$row = mysqli_fetch_assoc($result);
			echo $row["word"];
		}
		echo $toPrint;
		mysqli_close($db_server);
	}

?>
