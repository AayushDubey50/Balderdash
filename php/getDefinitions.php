<?php

	if ($_GET && isset($_GET["gameID"])) {
		$gameID = intval($_GET["gameID"]);
		//$db_server = mysqli_connect("localhost", "id3790675_aayushdubey50", "PurdueBalderdash238!", "id3790675_balderdash");
		$db_server = mysqli_connect("localhost", "id3790675_aayush2", "Purdue123!", "id3790675_balderdash2");
		if (!$db_server) {
			echo "Error: Unable to connect to MySQL." . PHP_EOL;
			exit;
		}
	    $query = "SELECT userIDsDef, currentWordID FROM all_games WHERE gameID=$gameID LIMIT 1;";
	    $toPrint = array();
		$result = mysqli_query($db_server, $query);
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$userIDsDef = $row["userIDsDef"];
			$wordID = $row["currentWordID"];
			$all = explode("|", $userIDsDef);
			for ($i = 0; $i < count($all); $i++) {
				$idDef = explode(":", $all[$i]);
				array_push($toPrint, $idDef[1]);
			}
			$query = "SELECT definition FROM all_words WHERE wordID=$wordID;";
			$result = mysqli_query($db_server, $query);
			$row = mysqli_fetch_assoc($result);
			array_push($toPrint, $row["definition"]);
			shuffle($toPrint);
			if ($userIDsDef == "") echo "";
			else echo implode("\n", $toPrint);
		} else echo "";
		mysqli_close($db_server);
	}

?>
