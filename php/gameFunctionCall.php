<?php
    require_once("game/game_action.php");
    $game_action = new game_action();

    if ($_POST && isset($_POST["functionName"])) {
        if (is_array($_POST["functionName"])) {
            $functionName = $_POST["functionName"][0];
        }
        else $functionName = $_POST["functionName"];
    }
    switch ($functionName) {
        case "getUsernames": // $getUsernames returns all usernames in a game
            if (isset($_SESSION["gameID"])) $getUsernames = $game_action->getUsernames($_SESSION["gameID"]);
            $toDump = $getUsernames;
            break;
        case "gameAvailable": // $gameAvailable returns True if another player can join the game
            if (isset($_SESSION["gameID"])) $gameAvailable = $game_action->gameAvailable($_SESSION["gameID"]);
            $toDump = $gameAvailable;
            break;
        case "join_game":
            $join_game = $game_action->join_game($_SESSION["userID"]);
            if ($join_game[1]) {
                // $_SESSION["word"] should be the selected word
                // $onStart should be an array with username as the key and username's points as the value
                $onStart = $game_action->onStart($_SESSION["gameID"]);
                $toDump = array("guess_word", $onStart[0], $onStart[1]);
            } else if ($join_game[0]) {
                // should start countdown of players joining a game
                $toDump = array("loadingPage", $join_game[0], $join_game[1]);
            }
            $toDump = array("loadingPage", $join_game[0], $join_game[1]);
            break;
        case "onStart":
            // $_SESSION["word"] == $onStart[0] should be the selected word
            // $onStart[1] should be an array with username as the key and username's points as the value
            $onStart = $game_action->onStart($_SESSION["gameID"]);
            $toDump = array("guess_word", $onStart[0], $onStart[1]);
            break;
        case "input_definition":
            $input = $_POST["functionName"][1];
            $input_definition = $game_action->input_definition($_SESSION["gameID"], $_SESSION["userID"], $input);
            if ($input_definition == NULL) ; // Have user submit another definition since it's already taken
            if ($input_definition) $onChoices = $game_action->onChoices($_SESSION["gameID"]);
            // $onChoices should be an array of string definitions
            // $_SESSION["idsDefs"] should be an array with elements of the format: [userID, definition]. userID = 0 means the computer
            break;
        case "onChoices":
            $onChoices = $game_action->onChoices($_SESSION["gameID"]);
            // $onChoices should be an array of string definitions
            // $_SESSION["idsDefs"] should be an array with elements of the format: [userID, definition]. userID = 0 means the computer
            break;
        case "select_definition":
            $selectionDef = $_POST["functionName"][1];
            $selectionUser = $_SESSION["usernamesDefs"][$selectionDef];
            $select_definition = $game_action->select_definition($_SESSION["gameID"], $_SESSION["userID"], $selectionUser);
            if ($select_definition)
                $onSummary = $game_action->onSummary($_SESSION["gameID"]);
            break;
        case "onSummary":
            $onSummary = $game_action->onSummary($_SESSION["gameID"]);
            break;
        case "end_game":
            $end_game = $game_action->end_game($_SESSION["gameID"], $_SESSION["userID"]);
            if (!$end_game) {
                // Have Unity call onStart
            } else {
                // Have Unity show end game screen
            }
            break;
    }
    echo var_dump($toDump);
?>
