<?php
	if ($_GET && isset($_GET["gameID"])) {
		$gameID = intval($_GET["gameID"]);
		//$db_server = mysqli_connect("localhost", "id3790675_aayushdubey50", "PurdueBalderdash238!", "id3790675_balderdash");
		$db_server = mysqli_connect("localhost", "id3790675_aayush2", "Purdue123!", "id3790675_balderdash2");
		if (!$db_server) {
			echo "Error: Unable to connect to MySQL." . PHP_EOL;
			exit;
		}
	    $query = "SELECT allUserIDs, allUserPoints FROM all_games WHERE gameID=$gameID LIMIT 1;";
	    $result = mysqli_query($db_server, $query);
	    $toPrint = "";
		//if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$allUserIDs = explode(",", $row["allUserIDs"]);
			$userPoints = explode(",", $row["allUserPoints"]);
			$i = 0;
			$toPush = array();
			foreach ($allUserIDs as $userID) {
				$query = "SELECT username FROM users_information WHERE userID=$userID LIMIT 1;";
				$result2 = mysqli_query($db_server, $query);
				$row2 = mysqli_fetch_assoc($result2);
				array_push($toPush, $row2["username"].": ".$userPoints[$i++]);
			}
			$toPrint = implode("\n", $toPush);
			echo $toPrint;
			/*if ($userIDsDef == "") echo "";
			else echo implode("\n", $toPrint);*/
		//} else echo "";
		mysqli_close($db_server);
	}
?>
