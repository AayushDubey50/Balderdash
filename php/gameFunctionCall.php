<?php
    require_once("game/game_action.php");
    $game_action = new game_action();

    if ($_POST && isset($_POST["functionName"])) {
        if (is_array($_POST["functionName"])) $functionName = $_POST["functionName"][0];
        else $functionName = $_POST["functionName"];
        $toDump = "";
        switch ($functionName) {
            case "join_game": // user presses "Join Game" button
                $join_game = $game_action->join_game($_SESSION["userID"]);
                if ($join_game[1]) $toDump = $game_action->onStart($_SESSION["gameID"]);
                else $toDump = $join_game[0];
                break;
            case "onStart":
                // $_SESSION["word"] == $onStart[0] should be the selected word
                // $onStart[1] should be an array with username as the key and username's points as the value
                $toDump = $game_action->onStart($_SESSION["gameID"]);
                break;
            case "input_definition": // user submits a definition
                $input = $_POST["functionName"][1];
                $input_definition = $game_action->input_definition($_SESSION["gameID"], $_SESSION["userID"], $input);
                if ($input_definition == NULL) $toDump = "Another user has submitted the same definition.";
                else if ($input_definition) $toDump = $game_action->onChoices($_SESSION["gameID"]);
                else $toDump = "Your definition has been submitted.";
                break;
            case "onChoices":
                $toDump = $game_action->onChoices($_SESSION["gameID"]); // $onChoices should be an array of string definitions
                // $_SESSION["idDefs"] gets set to be an array with elements of the format: ["definition" => userID]. userID = 0 means the Computer
                break;
            case "select_definition": // user votes a user's definition
                $selectionDef = $_POST["functionName"][1];
                $selectionID = $_SESSION["idDefs"][$selectionDef];
                $select_definition = $game_action->select_definition($_SESSION["gameID"], $_SESSION["userID"], $selectionID);
                if ($select_definition) $toDump = $game_action->onSummary($_SESSION["gameID"]);
                else $toDump = "Your vote has been submitted.";
                break;
            case "onSummary":
                $toDump = $game_action->onSummary($_SESSION["gameID"]);
                break;
            case "reset_round":
                $game_action->reset_round($_SESSION["gameID"], $_SESSION["userID"]);
                break;
            case "onEnd":
                $onEnd = $game_action->onEnd($_SESSION["gameID"]);
                break;
        }
        if (is_array($toDump)) print_r($toDump);
        else echo $toDump;
    }
?>
