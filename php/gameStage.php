<?php
    require_once("game/game_action.php");
    $game_action = new game_action();

    if ($_POST && isset($_POST["gameStage"])) {
        $gameStage = $_POST["gameStage"];
        $toDump = array();
        switch ($gameStage) {
            case "gameStage": // $gameStage returns True if another player can join the game
                $getStageID = $game_action->getStageID($getStageID);
                switch ($getStageID) {
                    case 0:
                        $page = "loadingPage";
                        $getUsernames = $game_action->getUsernames($getStageID);
                        array_push($toDump, $page, $getUsernames);
                        break;
                    case 1:
                        $page = "guessingPage";
                        $getNum = $game_action->getNum($getStageID, "userIDsDef", "|");
                        array_push($toDump, $page, $getNum);
                        break;
                    case 2:
                        $page = "votingPage";
                        $getNum = $game_action->getNum($getStageID, "selectionIDs", "|");
                        array_push($toDump, $page, $getNum);
                        break;
                    case 3:
                        array_push($toDump, "roundPage");
                        break;
                    case 4:
                        array_push($toDump, "endPage");
                        break;
                }
                break;
        }
        print_r($toDump);
    }
?>
