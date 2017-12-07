<?php
    //session_start();
    require_once("game/game_action.php");
    $game_action = new game_action();

    if ($_POST && isset($_POST["callStage"])) {
        $toDump = "";
        $gameID = intval($_POST["callStage"]);
        //if (!isset($gameID)) $gameID = 1;
        //$gameID = file_get_contents("https://purduebalderdash.000webhostapp.com/php/getSessions.php?keyName=gameID");
        $getStageID = $game_action->getStageID($gameID);
        switch ($getStageID) {
            case 0:
                $getUsernames = $game_action->getUsernames($gameID);
                $startTimer = $game_action->startTimer($gameID);
                $toDump = $startTimer."\n";
                $toDump .= implode("\n", $getUsernames);
                echo $toDump;
                break;
            case 1:
                $toDump = $game_action->getNum($gameID, "userIDsDef", "|");
                echo $toDump;
                break;
            case 2:
                $toDump = $game_action->getNum($gameID, "selectionIDs", "|");
                echo $toDump;
                break;
            case 3:
                //array_push($toDump);
                print_r($toDump);
                break;
            case 4:
                //array_push($toDump);
                print_r($toDump);
                break;
        }
    }
?>
