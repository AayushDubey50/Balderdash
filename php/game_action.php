<?php
    class game_action {
        private function run_query($query, $select, $toGet) {
            $db_server = mysqli_connect("localhost", "id3790675_aayushdubey50", "PurdueBalderdash238!", "id3790675_balderdash");
            if (!$db_server) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
            //mysql_select_db("id3790675_balderdash", $db_server);
            $result = mysqli_query($db_server, $query);
            if (!$result) {
                $row = NULL;
            } else if ($select) {
                if (!$toGet) $row = mysqli_fetch_assoc($result);
                else {
                    $row = array();
                    while ($row2 = mysqli_fetch_assoc($result)) array_push($row, $row2[$toGet]);
                }
            }
            mysqli_close($db_server);
            if ($select) return $row;
        }
        function start_game($userID) {
            $query = "SELECT wordId FROM all_words;";
            $row = $this->run_query($query, True, "wordId");
            $wordIDsLeft = implode(",", $row);
            $query = "INSERT INTO all_games (isAvailable, wordIDsLeft, currentWordID, allUserIDs, userIDsDef, userPoints) VALUES (1, '$wordIDsLeft', '', '$userID', '', '0');";
            $this->run_query($query, False, False);
            $query = "SELECT * FROM all_games WHERE gameID=(SELECT MIN(gameID) FROM all_games WHERE isAvailable=1 AND allUserIDs=$userID AND userPoints='0')";
            $row = $this->run_query($query, True, False);
            $_SESSION["gameID"] = $row["gameID"];
        }
        function join_game($userID) {
            $query = "SELECT * FROM all_games WHERE gameID=(SELECT MIN(gameID) FROM all_games WHERE isAvailable=1)";
            $row = $this->run_query($query, True, False);
            if ($row == NULL || !$row || !isset($row["gameID"])) $this->start_game($userID);
            else {
                $_SESSION["gameID"] = $row["gameID"];
                $userIDs = explode(",", $row["allUserIDs"]);
                array_push($userIDs, $userID);
                $allUserIDs = implode(",", $userIDs);

                $points = explode(",", $row["userPoints"]);
                array_push($points, 0);
                $userPoints = implode(",", $points);

                $gameID = $row["gameID"];
                if (count($userIDs) >= 10) {
                    $query = "UPDATE all_games SET allUserIDs='$allUserIDs', userPoints='$userPoints', isAvailable=0 WHERE gameID=$gameID;";
                    $this->run_query($query, False, False);
                    $this->onStart($gameID);
                } else if (count($userIDs) >= 3) {
                    $query = "UPDATE all_games SET allUserIDs='$allUserIDs', userPoints='$userPoints' WHERE gameID=$gameID;";
                    $this->run_query($query, False, False);
                    if (!isset($_SESSION["gameCountdown"])) $_SESSION["gameCountdown"] = time();
                }
            }
        }
        function onStart($gameID) {
            $query = "SELECT * FROM all_games WHERE gameID=$gameID;";
            $row = $this->run_query($query, True, False);
            $allWordIDsLeft = explode(",", $row["wordIDsLeft"]);
            $userIDs = explode(",", $row["allUserIDs"]);
            $allUserPoints = explode(",", $row["userPoints"]);
            $currentWordID = array_rand($allWordIDsLeft);

            $allWordIDsLeft = array_diff($allWordIDsLeft, $currentWordID);
            $wordIDsLeft = implode(",", $allWordIDsLeft);

            $query = "UPDATE all_games SET wordIDsLeft=$wordIDsLeft, currentWordID=$currentWordID WHERE gameID=$gameID;";
            $this->run_query($query, False, False);

            $toReturn = array();
            $i = 0;
            foreach ($userIDs as $userID) {
                $userPoint = $allUserPoints[$i++];
                $query = "SELECT username FROM user_information WHERE userID=$userID;";
                $row = $this->run_query($query, True, False);
                array_push($toReturn, array($row["username"], $userPoint));
            }
            if (!isset($_SESSION["definitionCountdown"])) $_SESSION["definitionCountdown"] = time();
            $query = "SELECT * FROM all_words WHERE wordID=$currentWordID;";
            $row = $this->run_query($query, True, False);
            $_SESSION["wordID"] = $row["wordID"];
            $_SESSION["word"] = $row["word"];
            $_SESSION["definition"] = $row["definition"];
            return $toReturn;
        }
        function inputDefinitions($gameID, $userID, $input) {
            $query = "SELECT * FROM all_games WHERE gameID=$gameID;";
            $row = $this->run_query($query, True, False);
            $numUsers = count(explode(",", $row["allUserIDs"]));
            if ($row["userIDsDef"] == "") $userIDsDef = $userID.":".$input;
            else {
                $allIDsDef = explode(";", $row["userIDsDef"]);
                $flag = True;
                for ($i = 0; $i < count($allIDsDef); $i++) {
                    $idDef = explode(":", $allIDsDef[$i]);
                    if ($userID == $idDef[0]) {
                        $allIDsDef[$i] = $userID.":".$input;
                        $flag = False;
                        break;
                    }
                }
                if ($flag) $userIDsDef = $row["userIDsDef"].";".$userID.":".$input;
                else $userIDsDef = implode(";", $allIDsDef);
            }
            $query = "UPDATE all_games SET userIDsDef=$userIDsDef WHERE gameID=$gameID;";
            $this->run_query($query, False, False);
            if (count(explode(";", $userIDsDef)) == $numUsers) {
                $this->wordsAndDefin($gameID);
            }
        }
        function wordsAndDefin($gameID) {
            $query = "SELECT * FROM all_games WHERE gameID=$gameID;";
            $row = $this->run_query($query, True, False);
            $allIDsDef = explode(";", $row["userIDsDef"]);
            $toReturn = array();
            for ($i = 0; $i < count($allIDsDef); $i++) array_push($toReturn, explode(":", $allIDsDef[$i]));
            array_push($toReturn, array(0, $_SESSION["definition"]));
            shuffle($toReturn);
            return $toReturn;
        }
    }
?>
