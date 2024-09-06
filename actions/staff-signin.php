<?php
/* connect to database custom messages */
require("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["username"],$_POST["password"])){
        $username = $_POST["username"];
        $password = $_POST["password"];

        $username = $conn -> real_escape_string($username);
        $password = $conn -> real_escape_string($password);

        $passretrieval = "SELECT staff_id, username, access_level, password FROM staff WHERE username = '$username'";
        $result = $conn -> query($passretrieval);
        if($result && $result -> num_rows > 0){
            $row = $result -> fetch_assoc();
            $staff_id = $row["staff_id"];
            $username = $row["username"];
            $access_level = $row["access_level"];
            $HashedPassword = $row["password"];

            if(password_verify($password,$HashedPassword)){
                    $_SESSION["staff_id"] = $staff_id;
                    $_SESSION["username"] = $username;
                    $_SESSION["access_level"] = $access_level;
                    $_SESSION['message'] = "You are logged in successfully " . $username;
                    header("Location: ../index.php");
                    exit();
            }
            else{
                echo  "<script>
                        alert('Incorrect password');
                        window.location.href = '../signup-page.php';
                      </script>";
                exit();
                
            }
        }else{
            echo  "<script>
                        alert('user not found');
                        window.location.href = '../signup-page.php';
                      </script>";
        }

        
    }
}