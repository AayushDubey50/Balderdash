<?php
    /**
     * Game Action
     * 
     * @author     Aayush Dubey <dubeya@purdue.edu>
     */
    class game_action {
        /**
         * Run a SQL query command
         *
         * @param string $query  SQL request made to the database
         * @param boolean $select  if the $query request is a SELECT request
         * @param string $toGet  key name for multiple mysqli_fetch_assoc calls, else False
         * @return array  key=>value array for any SELECT request
         */
        private function run_query($query, $select, $toGet) {
            $db_server = mysqli_connect("localhost", "id3790675_aayushdubey50", "PurdueBalderdash238!", "id3790675_balderdash");
            if (!$db_server) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
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
        /**
         * Get all usernames in a given game
         *
         * @param int $gameID  id of the game
         * @return array of all usernames
         */
        function getUsernames($gameID) {
            $query = "SELECT allUserIDs FROM all_games WHERE gameID=$gameID;";
            $row = $this->run_query($query, True, False);
            $userIDs = explode(",", $row["allUserIDs"]);
            $usernames = array();
            foreach ($userIDs as $userID) {
                $query = "SELECT username FROM users_information WHERE userID=$userID;";
                $row = $this->run_query($query, True, False);
                array_push($usernames, $row["username"]);
            }
            return $usernames;
        }
        /**
         * asdf
         *
         * @param int $gameID  id of the game
         * @return array of all usernames
         */
        function getUserIDsDef($gameID) {
            $query = "SELECT userIDsDef FROM all_games WHERE gameID=$gameID;";
            $row = $this->run_query($query, True, False);
            $allIDsDef = explode("|", $row["userIDsDef"]);
            $idDefs = array();
            for ($i = 0; $i < count($allIDsDef); $i++) {
                $idDef = explode(":", $allIDsDef[$i]);
                $idDefs[$idDef[1]] = $idDef[0];
            }
            $idDefs[$_SESSION["definition"]] = "Computer";
            return $idDefs;
        }
        /**
         * Check to see if the given game is available for more players to join
         *
         * @param int $gameID  id of the game
         * @return boolean
         */
        function getStageID($gameID) {
            $query = "SELECT stageID FROM all_games WHERE gameID=$gameID;";
            $row = $this->run_query($query, True, False);
            return $row["stageID"];
        }
        /**
         * Check to see if the given game is available for more players to join
         *
         * @param int $gameID  id of the game
         * @return boolean
         */
        function getNum($gameID, $columnName, $delimiter) {
            $query = "SELECT $columnName FROM all_games WHERE gameID=$gameID;";
            $row = $this->run_query($query, True, False);
            return count(explode($delimiter, $row[$columnName]));
        }
        /**
         * Check to see if the given game is available for more players to join
         *
         * @param int $gameID  id of the game
         * @param int $stageID  id of which page to load
         * @return boolean
         */
        private function setStageID($gameID, $stageID) {
            $query = "UPDATE all_games SET stageID=$stageID WHERE gameID=$gameID;";
            $this->run_query($query, False, False);
        }
        /**
         * Check to see if the given game is available for more players to join
         *
         * @param int $gameID  id of the game
         * @param int $stageID  id of which page to load
         * @return boolean
         */
        function startTimer($gameID) {
            $query = "SELECT * FROM all_games WHERE gameID=$gameID;";
            $row = $this->run_query($query, True, False);
            if (count(explode(",", $row["allUserIDs"])) >= 3) return "True";
            else return "False";
        }
        /**
         * Start a new Balderdash game by inserting a new row into the all_games table
         *
         * @param int $userID  id of the user who is part of the game
         */
        private function start_game($userID) {
            $query = "SELECT wordID FROM all_words;";
            $row = $this->run_query($query, True, "wordID");
            $wordIDsLeft = implode(",", $row);
            $allUserIDs = strval($userID);
            $query = "INSERT INTO all_games (stageID, wordIDsLeft, currentWordID, allUserIDs, userPoints) VALUES (0, '$wordIDsLeft', 0, '$allUserIDs', '0');";
            $this->run_query($query, False, False);
            $query = "SELECT gameID FROM all_games WHERE gameID=(SELECT MIN(gameID) FROM all_games WHERE stageID=0 AND allUserIDs='$allUserIDs' AND userPoints='0') LIMIT 1;";
            $row = $this->run_query($query, True, False);
            return $row["gameID"];
        }
        /**
         * Join a new Balderdash game if one is available by joining an existing game or creating a new game
         *
         * @param int $userID  id of the user who pressed the "Join Game" button
         * @return array(boolean, boolean)
         */
        function join_game($userID) {
            //$startCountdown = False; // Don't start countdown
            $moveToOnstart = False; // Don't move on to onStart()
            $gameID = -1;

            // First available game
            $query = "SELECT * FROM all_games WHERE gameID=(SELECT MIN(gameID) FROM all_games WHERE stageID=0);";
            $row = $this->run_query($query, True, False);

            if ($row == NULL || !$row || !isset($row["gameID"])) $gameID = $this->start_game($userID);
            else {
                // Add another userID of $userID
                $userIDs = explode(",", $row["allUserIDs"]);
                array_push($userIDs, $userID);
                $allUserIDs = implode(",", $userIDs);

                // Add another userPoints of 0
                $points = explode(",", $row["userPoints"]);
                array_push($points, 0);
                $userPoints = implode(",", $points);

                $gameID = $row["gameID"];
                $query = "UPDATE all_games SET allUserIDs='$allUserIDs', userPoints='$userPoints' WHERE gameID=$gameID;";
                $this->run_query($query, False, False);
                if (count($userIDs) == 5) $moveToOnstart = True;
                //else if (count($userIDs) == 3) $startCountdown = True;
            }
            return $gameID;
            //return array($startCountdown, $moveToOnstart);
        }
        /**
         * Start a new round in the game
         *
         * @param int $gameID  id of the game to start
         * @return array with username as the key and user's points as the value
         */
        function onStart($gameID) {
            $this->setStageID($gameID, 1);
            $query = "SELECT * FROM all_games WHERE gameID=$gameID;";
            $row = $this->run_query($query, True, False);

            $allWordIDsLeft = explode(",", $row["wordIDsLeft"]);
            $allUserPoints = explode(",", $row["userPoints"]);

            $currentWordID = array_rand($allWordIDsLeft); // Choose random wordID, which will be currentWordID
            if (($key = array_search($currentWordID, $allWordIDsLeft)) !== false) unset($allWordIDsLeft[$key]);
            $wordIDsLeft = implode(",", $allWordIDsLeft); // Remove $currentWordID from $allWordIDsLeft

            $query = "UPDATE all_games SET wordIDsLeft='$wordIDsLeft', currentWordID=$currentWordID WHERE gameID=$gameID;";
            $this->run_query($query, False, False);

            $userIDs = explode(",", $row["allUserIDs"]);
            $usernameAndPoints = array();
            $i = 0;
            foreach ($userIDs as $userID) {
                $query = "SELECT username FROM users_information WHERE userID=$userID;";
                $row = $this->run_query($query, True, False);
                $userPoint = $allUserPoints[$i++];
                $namePoint = $row["username"].": ".$userPoint." pts";
                array_push($usernameAndPoints, $namePoint);
                //$usernameAndPoints[$row["username"]] = $userPoint; // ["AayushDubey50" => 4, "Avi" => 2, ... ]
            }
            $query = "SELECT * FROM all_words WHERE wordID=$currentWordID;";
            $row = $this->run_query($query, True, False);
            $_SESSION["wordID"] = $row["wordID"];
            $_SESSION["word"] = $row["word"];
            $_SESSION["definition"] = $row["definition"];
            return ($row["word"]."\n".implode("\n", $usernameAndPoints));
        }
        /**
         * Input a user's definition of the word
         *
         * @param int $gameID  id of the game
         * @param int $userID  id of the user who inputs their definition
         * @param string $input  definition that the user submits
         * @return boolean  if True then move on to wordsAndDefin()
         */
        function input_definition($gameID, $userID, $input) {
            $input = str_replace(array(":", "|"), "", $input);
            $input = ucfirst($input);
            if ($input == $_SESSION["definition"]) return NULL; // User wrote Computer's definition
            else {
                $query = "SELECT * FROM all_games WHERE gameID=$gameID;";
                $row = $this->run_query($query, True, False);
                $numUsers = count(explode(",", $row["allUserIDs"]));
                if ($row["userIDsDef"] == "") $userIDsDef = $userID.":".$input;
                else {
                    $allIDsDef = explode("|", $row["userIDsDef"]);
                    $changeDefinition = False;
                    for ($i = 0; $i < count($allIDsDef); $i++) {
                        $idDef = explode(":", $allIDsDef[$i]);
                        if ($userID == $idDef[0]) {
                            $allIDsDef[$i] = $userID.":".$input;
                            $changeDefinition = True;
                            break;
                        } else if ($input == $idDef[1]) return NULL; // Another user wrote that exact definition
                    }
                    if (!$changeDefinition) $userIDsDef = $row["userIDsDef"]."|".$userID.":".$input;
                    else $userIDsDef = implode("|", $allIDsDef);
                }
                $query = "UPDATE all_games SET userIDsDef='$userIDsDef' WHERE gameID=$gameID;";
                $this->run_query($query, False, False);
                if (count(explode("|", $userIDsDef)) == $numUsers) return True;
                return False;
            }
        }
        /**
         * View all definitions in round, including Computer's
         *
         * @param int $gameID  id of the game
         * @return array of string definitions
         */
        function onChoices($gameID) {
            $this->setStageID($gameID, 2);
            $query = "SELECT * FROM all_games WHERE gameID=$gameID;";
            $row = $this->run_query($query, True, False);
            $allIDsDef = explode("|", $row["userIDsDef"]);
            $idDefs = array();
            $allDefinitions = array();
            for ($i = 0; $i < count($allIDsDef); $i++) {
                $idDef = explode(":", $allIDsDef[$i]);
                array_push($allDefinitions, $idDef[1]);
                $idDefs[$idDef[1]] = $idDef[0];
            }
            array_push($allDefinitions, $_SESSION["definition"]);
            $idDefs[$_SESSION["definition"]] = "Computer";
            //$_SESSION["idDefs"] = $idDefs;
            shuffle($allDefinitions);
            return $allDefinitions;
        }
        /**
         * Take in a user's selection of a definition
         *
         * @param int $gameID  id of the game
         * @param int $userID  id of the user who selects a definition
         * @param int $selectionID  userID of whose definition was inputted
         * @return boolean
         */
        function select_definition($gameID, $userID, $selectionID) {
            $query = "SELECT * FROM all_games WHERE gameID=$gameID;";
            $row = $this->run_query($query, True, False);
            $allIDsDef = explode("|", $row["userIDsDef"]);
            $userIDs = explode(",", $row["allUserIDs"]);
            if ($row["selectionIDs"] == "") $selectionIDs = $userID.":".$selectionID;
            else {
                $allSelectionIDs = explode("|", $row["selectionIDs"]);
                $changeSelection = False;
                for ($i = 0; $i < count($allSelectionIDs); $i++) {
                    $userSelectionID = explode(":", $allSelectionIDs[$i]);
                    if ($userID == $userSelectionID[0]) {
                        $allSelectionIDs[$i] = $userID.":".$selectionID;
                        $changeSelection = True;
                        break;
                    }
                }
                if (!$changeSelection) $selectionIDs = $row["selectionIDs"]."|".$userID.":".$selectionID;
                else $selectionIDs = implode("|", $allSelectionIDs);
            }
            $numUsers = count($userIDs);
            $allUserPoints = explode(",", $row["userPoints"]);
            //$numSelects = $row["numSelects"];
            if (isset($_SESSION["oldSelectionID"])) {
                for ($i = 0; $i < count($userIDs); $i++) {
                    // if Computer, else if your own, else if another's
                    if ($_SESSION["oldSelectionID"] == 0 && $userID == $userIDs[$i]) {
                        $allUserPoints[$i]--;
                        //$numSelects--;
                        break;
                    } else if ($_SESSION["oldSelectionID"] == $userID && $userID == $userIDs[$i]) {
                        $allUserPoints[$i]++;
                        //$numSelects--;
                        break;
                    } else if ($_SESSION["oldSelectionID"] == $userIDs[$i]) {
                        $allUserPoints[$i]--;
                        //$numSelects--;
                        break;
                    }
                }
            }
            for ($i = 0; $i < count($userIDs); $i++) {
                // if Computer, else if your own, else if another's
                if ($selectionID == 0 && $userID == $userIDs[$i]) {
                    $allUserPoints[$i]++;
                    //$numSelects++;
                    break;
                } else if ($selectionID == $userID && $userID == $userIDs[$i]) {
                    $allUserPoints[$i]--;
                    //$numSelects++;
                    break;
                } else if ($selectionID == $userIDs[$i]) {
                    $allUserPoints[$i]++;
                    //$numSelects++;
                    break;
                }
            }
            $userPoints = implode(",", $allUserPoints);
            $query = "UPDATE all_games SET userPoints='$userPoints', selectionIDs='$selectionIDs' WHERE gameID=$gameID;";
            $this->run_query($query, False, False);
            $_SESSION["oldSelectionID"] = $selectionID;
            if (count(explode("|", $selectionIDs)) == $numUsers) return True;
            return False;
        }
        /**
         * Give full round summary of who guessed what and the number of points each user has.
         *
         * @param int $gameID  id of the game
         * @return array of key username to value of array(user's definition, user's points, and their voted username)
         */
        function onSummary($gameID) {
            $this->setStageID($gameID, 3);
            if (isset($_SESSION["oldSelectionID"])) unset($_SESSION["oldSelectionID"]);
            $query = "SELECT * FROM all_games WHERE gameID=$gameID;";
            $row = $this->run_query($query, True, False);
            $allUserPoints = explode(",", $row["userPoints"]);
            $allIDsDef = explode("|", $row["userIDsDef"]);
            $allSelectionIDs = explode("|", $row["selectionIDs"]);
            $roundInfo = array();
            for ($i = 0; $i < count(explode(",", $row["allUserIDs"])); $i++) {
                $idDef = explode(":", $allIDsDef[$i]);
                $userID = $idDef[0];
                $definition = $idDef[1];
                for ($j = 0; $j < count($allSelectionIDs); $j++) {
                    $allSelectionID = explode(":", $allSelectionIDs[$j]);
                    if ($userID == $allSelectionID[0]) {
                        $selectionID = $allSelectionID[1];
                        for ($k = 0; $k < count($allIDsDef); $k++) {
                            $idDef = explode(":", $allIDsDef[$k]);
                            if ($selectionID == $idDef[0]) {
                                $selectionDefinition = $idDef[1];
                                $query = "SELECT username FROM users_information WHERE userID=$userID;";
                                $row = $this->run_query($query, True, False);
                                $roundInfo[$row["username"]] = array($definition, $allUserPoints[$i], $selectionDefinition);
                                break;
                            }
                        }
                        break;
                    }
                }
            }
            for ($i = 0; $i < count($roundInfo) - 1; $i++) {
                for ($j = 0; $j < count($roundInfo) - $i - 1; $j++) {
                    if ($roundInfo[$j + 1][1] > $roundInfo[$j][1]) {
                        $temp = $roundInfo[$j + 1];
                        $roundInfo[$j + 1] = $roundInfo[$j][1];
                        $roundInfo[$j][1] = $temp;
                    }
                }
            }
            return $roundInfo;
        }
        /**
         * End the game if necessary, else start a new round.
         *
         * @param int $gameID  id of the game to end
         */
        function reset_round($gameID) {
            $query = "UPDATE all_games SET currentWordID=0, selectionIDs='', userIDsDef='' WHERE gameID=$gameID;";
            $this->run_query($query, False, False);
        }
        /**
         * End the game
         *
         * @param int $gameID  id of the game to end
         * @return boolean
         */
        function onEnd($gameID, $userID) {
            $this->setStageID($gameID, 4);
            $query = "SELECT * FROM all_games WHERE gameID=$gameID;";
            $row = $this->run_query($query, True, False);
            $userIDs = explode(",", $row["allUserIDs"]);
            $allUserPoints = explode(",", $row["userPoints"]);
            $i = 0;
            for (; $i < count($userIDs); $i++) if ($userID == $userIDs[$i]) break;
            $point = $allUserPoints[$i];
            rsort($allUserPoints);
            for ($i = 0; $i < count($allUserPoints); $i++) if ($point == $allUserPoints[$i]) break;
            return array($i, $point);
        }
    }
?>
