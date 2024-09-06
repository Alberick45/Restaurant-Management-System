<?php
require("config.php");


function add_staff(){
    session_start();
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["firstname"], $_POST["lastname"], $_POST["dob"], $_POST["gender"], $_POST["phone"], $_POST["username"], $_POST["password"], $_POST["access"])) {
            
            // Sanitizing input data
            $firstname = $conn->real_escape_string($_POST["firstname"]);
            $lastname = $conn->real_escape_string($_POST["lastname"]);
            $username = $conn->real_escape_string($_POST["username"]);
            $dob = $conn->real_escape_string($_POST["dob"]);
            $gender = $conn->real_escape_string($_POST["gender"]);
            $phone = $conn->real_escape_string($_POST["phone"]);
            $FullName = $firstname . ' ' . $lastname;
            $password = $conn->real_escape_string($_POST["password"]);
            $access_codes = $conn->real_escape_string($_POST["access"]);
            
            // Convert date of birth to age
            $dob = strtotime($dob);
            $age = date("Y") - date("Y", $dob);
            
            // Adjust age if the birthday hasn't occurred this year
            if (date("md") < date("md", $dob)) {
                $age--;
            }

            // Check if the password length is at least 8 characters
            if (strlen($password) < 8) {
                echo "<script>
                        alert('Password must be at least 8 characters long');
                        window.location.href = '../signup-page.php';
                    </script>";
                exit();
            }

            // Check if the user already exists
            $checkUserQuery = "SELECT staff_id FROM staff WHERE username = ?";
            $stmt = $conn->prepare($checkUserQuery);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // User already exists 
                echo "<script>
                        alert('Username already taken');
                        window.location.href = '../signup-page.php';
                    </script>";
            } else {
                // User does not exist, proceed with registration
                $HashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $access_level = 1;

                // Determine access level based on access codes
                if ($access_codes == "LEV999") {
                    $access_level = 3;
                } elseif ($access_codes[3] == "3") {
                    $access_level = 2;
                } elseif ($access_codes[3] == "1") {
                    $access_level = 1;
                }

                // Insert user into staff table
                $sqlinsert = "call add_staff('$FullName', '$access_codes', $age, '$phone', '$gender', '$username', $access_level, '$HashedPassword')";

                if ($conn -> query($sqlinsert)) {
                    // Retrieve the staff ID and set session variables
                    $passretrieval = "SELECT staff_id FROM staff WHERE username = ?";
                    $stmt = $conn->prepare($passretrieval);
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $staff_id = $row["staff_id"];
                        $_SESSION["staff_id"] = $staff_id;
                        $_SESSION["username"] = $username;
                        $_SESSION["access_level"] = $access_level;
                        $_SESSION['message'] = "You are logged in successfully " . $username ;
                        header("Location: ../index.php");
                        exit();
                    } else {
                        echo "Problem with code: " . $conn->error;
                    }
                } else {
                    echo "Error inserting data: " . $conn->error;
                }
            } 
            
        }
        else{
            echo "isnot set";
        }
    }
    else{
        echo "server requestmethod";
    }

}


function deletestaff($sid) {
    global $conn ;
    $sql = "call delete_staff($sid)";
    $conn -> query($sql);
     header('Location: ../staff.php');
    
    $conn -> close();
}






if (isset($_GET["action"])) {
    
    if (isset($_GET['sid']) && $_GET["action"] === "deletestaff") {
        $staff = htmlspecialchars($_GET['sid']);
        deletestaff($staff);
         exit();
    }
}
else{
    add_staff();
}
?>
