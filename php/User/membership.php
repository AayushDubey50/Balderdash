<?php
    class membership {
        private function run_query($query, $select) {
            //$db_server = mysql_connect("localhost", "id3790675_aayushdubey50", "PurdueBalderdash238!");
            $db_server = mysqli_connect("localhost", "id3790675_aayushdubey50", "PurdueBalderdash238!", "id3790675_balderdash");
            if (!$db_server) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
            //mysql_select_db("id3790675_balderdash", $db_server);
            $result = mysqli_query($db_server, $query);
            if (!$result) {
                $row = NULL;
            } else if ($select) $row = mysqli_fetch_assoc($result);
            mysqli_close($db_server);
            if ($select) return $row;
        }
        function create_user($username, $email, $password) {
            $query = "SELECT username FROM users_information WHERE username='$username' AND email='$email' LIMIT 1";
            $row = $this->run_query($query, True);
            if ($row["username"] == $username || $username == "computer") return false;
            else {
                $timeStamp = date("D. m/d/Y H:i:s");
                $salt = substr(md5($timeStamp), 0, 7);
                $password = md5($salt.$password);

                $query = "INSERT INTO users_information (username, email, password, salt) VALUES ('$username', '$email', '$password', '$salt')";
                $this->run_query($query, False);

                $query = "SELECT * FROM users_information WHERE username='$username' LIMIT 1";
                $row = $this->run_query($query, True);

                $_SESSION["status"] = "authorized";
                $_SESSION["userID"] = $row["userID"];
                $_SESSION["username"] = $row["username"];
                header("location: https://purduebalderdash.000webhostapp.com/balderdash");
            }
        }
        function validate_user($username, $password) {
            $query = "";
            if (strpos($username, '@') !== FALSE)
                $query .= "SELECT * FROM users_information WHERE email='$username' LIMIT 1";
            else $query .= "SELECT * FROM users_information WHERE username='$username' LIMIT 1";
            $row = $this->run_query($query, True);

            if (md5($row["salt"].$password) != $row["password"]) return false;

            if ($row["username"] != "" && $row["password"] != "") {
                $_SESSION["status"] = "authorized";
                $_SESSION["userID"] = $row["userID"];
                $_SESSION["username"] = $row["username"];
                return "https://purduebalderdash.000webhostapp.com/balderdash";
            } else return false;
        }
        function log_out() {
            if (isset($_SESSION["status"]) && $_SESSION["status"] == "loggedout") {
                foreach ($_SESSION as $key => $value)
                    unset($_SESSION[$key]);
                header("location: https://purduebalderdash.000webhostapp.com/");
            }
        }
        function confirm_user() {
            session_start();
            if ($_SESSION["status"] != "authorized") header("location: https://purduebalderdash.000webhostapp.com/");
        }
    }
?>
