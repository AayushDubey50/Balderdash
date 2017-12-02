<?php
    session_start();
    require_once("../php/User/membership.php");
    $membership = new membership();
    if ($_POST && !empty($_POST["email"]) && !empty($_POST["password"])) {
        $badLogin = $membership->validate_user($_POST["email"], $_POST["password"]);
        if ($badLogin != false) print '<script>location.href = "'.$badLogin.'"</script>';
    } else if ($_POST && !empty($_POST["send"])) {
        $send = explode(", ", $_POST["send"]);
        $badSignup = $membership->create_user($send[0], $send[1], $send[2]);
    }

    // Game is only visible to logged-in users.
    if (!isset($_SESSION["status"]) || $_SESSION["status"] != "authorized") {
        header("location: http://www.purduebalderdash.000webhostapp.com");
    }

    // User already logged in and hits "log out" button, any page has a logout
    // else user is an admin and hits "log out"
    if (isset($_GET["status"]) && $_GET["status"] == "loggedout") {
        $_SESSION["status"] = $_GET["status"];
        $membership->log_out();
    } else if (isset($_GET["adStat"]) && $_GET["adStat"] == "loggedout") {
        $_SESSION["adStat"] = $_GET["adStat"];
        $membership->log_out_admin();
    }

?><!DOCTYPE html>
<!--<script>
    var url = window.location.host;
    if (url[1] != "w") {
        redirectionLocation = "https://purduebalderdash.000webhostapp.com" + window.location.pathname;
        location.href = redirectionLocation;
    }
</script>-->
<html lang="en" id="content">
    <head>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <link rel="stylesheet" href="../font-awesome-4.3.0/css/font-awesome.min.css">
        <script src="../js/correctURL.js"></script>
        <script src="../js/mobile.js"></script>
        <title>Balderdash</title>
        <link rel="stylesheet" type="text/css" href="../css/style3.css">
        <link rel="stylesheet" type="text/css" href="../css/style4.css">
    </head>
    <body>
        <div class="container">
            <nav id="mainNav" class="navbar navbar-default nav see-through" role="navigation">
                <div class="navbar-header">
                    <a href="https://purduebalderdash.000webhostapp.com/"></a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navList" id="datatoggle">
                        <span class="sr-only">TEST navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navList">
                    <ul class="navbar-nav navbar-right" id="navListContain">
                        <li id="../logout"><a href="../?status=loggedout">Log Out</a></li>
                    </ul>
                </div>
            </nav>
            <main class="cd-main-content">
                <div id="main" class="cd-fixed-bg cd-bg-2 row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">
                        <div id="mainText">
                            <p>Join a game!</p>
                        </div>
                        <iframe src="#"></iframe>
                    </div>
                    <div class="col-sm-1"></div>
                </div>
            </main>
        </div>
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                 $(window).scroll(function() {
                    var scroll = $(window).scrollTop();
                    if (scroll >= 1) $(".nav").addClass("dark");
                    else $(".nav").removeClass("dark");
                });
            });
        </script>
    </body>
</html>
