<?php

	if ($_GET && isset($_GET["userID"])) {
		$userID = $_GET["userID"];
		//$db_server = mysqli_connect("localhost", "id3790675_aayushdubey50", "PurdueBalderdash238!", "id3790675_balderdash");
		$db_server = mysqli_connect("localhost", "id3790675_aayush2", "Purdue123!", "id3790675_balderdash2");
		if (!$db_server) {
			echo "Error: Unable to connect to MySQL." . PHP_EOL;
			exit;
		}
	    $query = "SELECT gameID, allUserIDs FROM all_games WHERE stageID=0;";// WHERE gameID=(SELECT MIN(gameID) FROM all_games WHERE stageID=0 AND allUserIDs='$userID' AND userPoints='0') LIMIT 1;";
	    $toPrint = "-1";
		$result = mysqli_query($db_server, $query);
		if(mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$allUserIDs = explode(",", $row["allUserIDs"]);
				foreach ($allUserIDs as $uid) {
					if ($userID == $uid) {
						$toPrint = $row["gameID"];
						break 2;
					}
				}
			}
			//$row = mysqli_fetch_assoc($result);
		}
		echo $toPrint;
		mysqli_close($db_server);
	}

?>
