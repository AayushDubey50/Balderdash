<?php
    require_once("game/game_action.php");
    $game_action = new game_action();

    $functionName = $_POST["functionName"];
    switch ($functionName) {
        case "join_game":
            $join_game = $game_action->join_game($_SESSION["userID"]);
            if ($join_game) $onStart = $game_action->onStart($_SESSION["gameID"]);
            break;
        case "onStart":
            $onStart = $game_action->onStart($_SESSION["gameID"]);
            break;
        case "inputDefinitions":
            $inputDefinitions = $game_action->inputDefinitions($_SESSION["gameID"], $_SESSION["userID"], $input);
            if ($inputDefinitions) $wordsAndDefin = $game_action->wordsAndDefin($_SESSION["gameID"]);
            break;
        case "wordsAndDefin":
            $wordsAndDefin = $game_action->wordsAndDefin($_SESSION["gameID"]);
            break;
        case "select_definition":
            $select_definition = $game_action->select_definition($_SESSION["gameID"], $_SESSION["userID"], $selectionID);
            if ($select_definition) $round_summary = $game_action->round_summary($_SESSION["gameID"]);
            break;
    }
?>
