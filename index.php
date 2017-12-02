<?php
    session_start();
    require_once("php/User/membership.php");
    $membership = new membership();

    // User tries logging into their account
    // else if the user wants to sign up for an account
    if ($_POST && !empty($_POST["user"]) && !empty($_POST["password"])) {
        $badLogin = $membership->validate_user($_POST["user"], $_POST["password"]);
        if ($badLogin != false) print '<script>location.href = "'.$badLogin.'"</script>';
    } else if ($_POST && !empty($_POST["send"])) {
        $send = explode(", ", $_POST["send"]);
        $badSignup = $membership->create_user($send[0], $send[1], $send[2]);
    }

    // User already logged in and hits "log out" button, any page has a logout
    // else user is an admin and hits "log out" (on admin page)
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
        <link rel="stylesheet" href="font-awesome-4.3.0/css/font-awesome.min.css">
        <?php
            if (!(isset($_SESSION["status"]) && $_SESSION["status"] == "authorized"))
                print '<!--<script src="https://www.google.com/recaptcha/api.js"></script>-->';
            else print '<script src="js/correctURL.js"></script>';
        ?>
        <script src="js/mobile.js"></script>
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="css/style3.css">
        <link rel="stylesheet" type="text/css" href="css/style4.css">
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
                        <?php
                            if (isset($_SESSION["status"]) && $_SESSION["status"] == "authorized") {
                                print '<li class="dropdown">
                            <a href="dashboard" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dashboard <span class="caret"></span></a>
                            <ul class="dropdown-menu" style="left: auto; right: 0; background-color: white;">
                                <li><a style="color: black;" href="dashboard">View Dashboard</a></li>
                                <li><a style="color: black;" href="profile">Your profile</a></li>
                                <li><a style="color: black;" href="#" data-toggle="modal" data-target="#myModal">Take Free Web Test</a></li>
                                <li><a style="color: black; cursor: pointer;" onclick="correctURL();" target="_blank">Take Free Mobile Test</a></li>
                                <li><a style="color: black;" href="#" data-toggle="modal" data-target="#myResult">Check Result</a></li>
                            </ul>
                        </li>
                        <li id="../logout"><a href="../?status=loggedout">Log Out</a></li>';
                            } else print '<li><a href="#" data-toggle="modal" data-target="#myModal">Login/Sign Up</a></li>';
                        ?>

                    </ul>
                </div>
            </nav>
            <main class="cd-main-content">
                <div id="main" class="cd-fixed-bg cd-bg-2 row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <div id="mainText">
                            <p>Welcome to Purdue Balderdash!</p>
                            <p>CS252 Lab 6</p>
                            <?php
                                if (isset($_SESSION["status"]) && $_SESSION["status"] == "authorized") {
                                    print '<a class="buttonLink" href="balderdash">
                                <div class="buttonMain">Play Balderdash!</div>
                            </a>';
                                } else print '<a class="buttonLink" href="#" data-toggle="modal" data-target="#myModal">
                                <div class="buttonMain">Login/Sign up</div>
                            </a>';
                            ?>

                        </div>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
            </main>
        </div><?php
            if (!(isset($_SESSION["status"]) && $_SESSION["status"] == "authorized"))
                print '
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="container-fluid" style="min-height: 50px;">
                            <div id="alert_placeholder"></div>
                            <div class="col-md-6">
                                <form method="POST" action="">
                                    <h3 class="modalHeader">Sign In</h3>
                                    <span id="confirmMember" class="confirmMember"></span>
                                    <div class="form-group">
                                        <label class="sr-only" for="email">Email or Username</label>
                                        <input name="user" class="form-control" placeholder="Email or Username" />
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="password">Password</label>
                                        <input name="password" type="password" class="form-control" placeholder="Password" />
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="modalBtn">Login</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6 rightSide">
                                <h3 class="modalHeader">Sign Up</h3>
                                <div class="form-group">
                                    <label class="sr-only" for="name">Username</label>
                                    <input name="username" type="text" class="form-control" id="username" placeholder="Enter in a username" />
                                </div>
                                <span id="alreadyUser" class="alreadyUser"></span>
                                <div class="form-group">
                                    <label class="sr-only" for="email">Email</label>
                                    <input name="email" type="email" class="form-control" id="address" placeholder="Email" />
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="password">Password</label>
                                    <input name="pwd" type="password" class="form-control" id="pass1" placeholder="Password" />
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="confirmpassword">Confirm Password</label>
                                    <input name="confirmpwd" type="password" class="form-control" id="pass2" placeholder="Confirm Password" onkeyup="checkPass(); return false;" />
                                    <span id="confirmPass" class="confirmPass"></span>
                                </div>

                                <div class="form-group">
                                </div>
                                <!--<div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="6LdB8DoUAAAAAOVmm9OGE4hrH7cBz7TAghPJ2f2m"></div>
                                </div>-->
                                <button onclick="subm()" class="modalBtn">Sign Up</button>
                            </div>
                        </div><!-- /.container-fluid -->
                    </div><!-- /.modal-body -->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <form method="POST" action="" name="user">
            <input type="hidden" name="send" id="sendId" />
        </form>';
        ?>

        <script src="js/jquery-2.1.4.min.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                 $(window).scroll(function() {
                    var scroll = $(window).scrollTop();
                    if (scroll >= 1) $(".nav").addClass("dark");
                    else $(".nav").removeClass("dark");
                });
            });
        </script>
        <?php
            if (!(isset($_SESSION["status"]) && $_SESSION["status"] == "authorized")) {
                print '<script type="text/javascript" src="js/register.js"></script>';
                if (isset($badLogin) && $badLogin == false) {
                    print '
        <script type="text/javascript">
            document.getElementById("confirmMember").style.color = "#ff0000";
            document.getElementById("confirmMember").innerHTML = "Invalid email and/or password.";
            $(window).load(function(){
                $("#myModal").modal("show");
            });
        </script>';
                } else if (isset($badSignup) && $badSignup == false) {
                    print '
        <script type="text/javascript">
            document.getElementById("alreadyUser").style.color = "#ff0000";
            document.getElementById("alreadyUser").innerHTML = "This username is already taken.";
            $(window).load(function(){
                $("#myModal").modal("show");
            });
        </script>';
                }
                unset($badLogin, $badSignup);
            }
        ?>
    </body>
</html>
