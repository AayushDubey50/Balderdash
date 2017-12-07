<?php
    require_once("game/game_action.php");
    $game_action = new game_action();

    if ($_POST && isset($_POST["functionName"]) && is_array($_POST["functionName"])) {
        $functionName = $_POST["functionName"][0];
        $userID = intval($_POST["functionName"][1]);
        if (count($_POST["functionName"]) >= 3) $gameID = $_POST["functionName"][2];
        $toDump = "";
        switch ($functionName) {
            case "join_game": // user presses "Join Game" button
                $toDump = $game_action->join_game($userID);
                //if ($join_game[0]) $toDump = $game_action->onStart($gameID);
                //else $toDump = strval($join_game[0]);
                break;
            case "onStart":
                // $toDump should begin with the selected word then a newline, afterwards a string of "Username: # pts" separated by new lines.
                $toDump = $game_action->onStart($gameID);
                mail("aayush.dubey50@gmail.com", "onStart", $toDump);
                break;
            case "input_definition": // user submits a definition
                $input = $_POST["functionName"][3];
                $input_definition = $game_action->input_definition($gameID, $userID, $input);
                if ($input_definition == NULL) $toDump = "False, Another user has submitted the same definition.";
                else if ($input_definition) $toDump = "True";//$toDump = $game_action->onChoices($gameID);
                else $toDump = "False, Your definition has been submitted.";
                break;
            case "onChoices":
                $toDump = $game_action->onChoices($gameID); // $toDump should be an array of string definitions
                // $_SESSION["idDefs"] gets set to be an array with elements of the format: ["definition" => userID]. userID = 0 means the Computer
                break;
            case "select_definition": // user votes a user's definition
                //$selectionID = $_SESSION["idDefs"][$_POST["functionName"][3]];
                $selectionID = $game_action->getUserIDsDef($gameID);
                $select_definition = $game_action->select_definition($gameID, $userID, $selectionID);
                if ($select_definition) $toDump = "True";//$toDump = $game_action->onSummary($gameID);
                else $toDump = "Your vote has been submitted.";
                break;
            case "onSummary":
                $toDump = $game_action->onSummary($gameID);
                break;
            case "reset_round":
                $game_action->reset_round($gameID);
                break;
            case "onEnd":
                $toDump = $game_action->onEnd($gameID, $userID);
                break;
        }
        echo $toDump;
    }
?>
