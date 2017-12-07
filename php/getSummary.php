<?php
	if ($_GET && isset($_GET["gameID"])) {
		$gameID = intval($_GET["gameID"]);
		//$db_server = mysqli_connect("localhost", "id3790675_aayushdubey50", "PurdueBalderdash238!", "id3790675_balderdash");
		$db_server = mysqli_connect("localhost", "id3790675_aayush2", "Purdue123!", "id3790675_balderdash2");
		if (!$db_server) {
			echo "Error: Unable to connect to MySQL." . PHP_EOL;
			exit;
		}
	    $query = "SELECT userIDsDef, selectionIDs, currentWordID FROM all_games WHERE gameID=$gameID LIMIT 1;";
	    $result = mysqli_query($db_server, $query);
	    $toPrint = "";
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$allUserIDsDef = explode("|", $row["userIDsDef"]);
			$selectionIDs = explode("|", $row["selectionIDs"]);
			$wordID = $row["currentWordID"];
			$query = "SELECT definition FROM all_words WHERE wordID=$wordID LIMIT 1;";
	    	$result = mysqli_query($db_server, $query);
	    	$row = mysqli_fetch_assoc($result);
			array_push($allUserIDsDef, "0:".$row["definition"]);
			for ($i = 0; $i < count($allUserIDsDef); $i++) {
				$idDef = explode(":", $allUserIDsDef[$i]);
				$userID = $idDef[0];
				if ($userID != 0) {
					$query = "SELECT username FROM users_information WHERE userID=$userID LIMIT 1;";
					$result2 = mysqli_query($db_server, $query);
					$row2 = mysqli_fetch_assoc($result2);
					$username = $row2["username"];
				} else $username = "Computer";
				$toPrint .= $username.": ".$idDef[1]."\nVoters: ";
				$selectionUsers = array();
				for ($j = 0; $j < count($selectionIDs); $j++) {
					$selectionID = explode(":", $selectionIDs[$j]);
					if ($userID == $selectionID[1]) {
						$query = "SELECT username FROM users_information WHERE userID=$selectionID[0] LIMIT 1;";
						$result3 = mysqli_query($db_server, $query);
						$row3 = mysqli_fetch_assoc($result3);
						array_push($selectionUsers, $row3["username"]);
					}
				}
				$toPrint .= implode(",", $selectionUsers)."|";
			}
			if (strlen($toPrint) > 0 && $toPrint[strlen($toPrint) - 1] == "|") $toPrint = substr($toPrint, 0, strlen($toPrint) - 1);
			echo $toPrint;
			/*if ($userIDsDef == "") echo "";
			else echo implode("\n", $toPrint);*/
		} else echo "";
		mysqli_close($db_server);
	}
?>
