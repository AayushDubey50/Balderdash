<?php
    require_once("game/game_action.php");
    $game_action = new game_action();

    $functionName = $_POST["functionName"];
    switch ($functionName) {
        case "join_game":
            $join_game = $game_action->join_game($_SESSION["userID"]);
            if ($join_game[1]) {
                // $_SESSION["word"] should be the selected word
                // $onStart should be an array with username as the key and username's points as the value
                $onStart = $game_action->onStart($_SESSION["gameID"]);
            } else if ($join_game[0]) {
                $_SESSION["loadingCountdown"] = time();
            }
            // should start countdown of players joining a game
            // $join_game[2] should be an array of the usernames
            break;
        case "onStart":
            if (isset($_SESSION["loadingCountdown"])) unset($_SESSION["loadingCountdown"]);
            // $_SESSION["word"] should be the selected word
            // $onStart should be an array with username as the key and username's points as the value
            $onStart = $game_action->onStart($_SESSION["gameID"]);
            break;
        case "input_definition":
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
?>
