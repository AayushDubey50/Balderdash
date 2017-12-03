<?php
    require_once("game/game_action.php");
    $game_action = new game_action();

    $functionName = $_POST["functionName"];
    switch ($functionName) {
        case "join_game":
            $join_game = $game_action->join_game($_SESSION["userID"]);
            if ($join_game[1]) {
                // $_SESSION["word"] should be the selected word
                // $onStart should be an array with elements of the format: [username, points]
                $onStart = $game_action->onStart($_SESSION["gameID"]);
            } else if ($join_game[0]) ; // should start countdown of players joining a game
            // $join_game[2] should be an array of the usernames
            break;
        case "onStart":
            // $_SESSION["word"] should be the selected word
            // $onStart should be an array with elements of the format: [username, points]
            $onStart = $game_action->onStart($_SESSION["gameID"]);
            break;
        case "inputDefinitions":
            $inputDefinitions = $game_action->inputDefinitions($_SESSION["gameID"], $_SESSION["userID"], $_POST["input"]);
            if ($inputDefinitions) $wordsAndDefin = $game_action->wordsAndDefin($_SESSION["gameID"]);
            // 
            break;
        case "wordsAndDefin":
            $wordsAndDefin = $game_action->wordsAndDefin($_SESSION["gameID"]);
            break;
        case "select_definition":
            $select_definition = $game_action->select_definition($_SESSION["gameID"], $_SESSION["userID"], $_POST["selectionID"]);
            if ($select_definition) $round_summary = $game_action->round_summary($_SESSION["gameID"]);
            break;
        case "round_summary":
            $round_summary = $game_action->round_summary($_SESSION["gameID"]);
            break;
    }
?>
