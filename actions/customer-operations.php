
<?php
require("config.php");
session_start();

$staffid = $_SESSION['staff_id'];
function addcustomer() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['customer-firstname'], $_POST['customer-lastname'], $_POST['customer-dob'], $_POST['customer-phone'], $_POST['gender'])) {
            // Escape and assign POST data to variables
            $firstname = $conn->real_escape_string($_POST['customer-firstname']);
            $lastname = $conn->real_escape_string($_POST['customer-lastname']);
            $dateOfBirth = $conn->real_escape_string($_POST['customer-dob']);
            $customerNumber = $conn->real_escape_string($_POST['customer-phone']);
            $gender = $conn->real_escape_string($_POST['gender']);
            $Full_customer_Name = $firstname . ' ' . $lastname;

            $dob = strtotime($dateOfBirth);
            $age = date("Y") - date("Y", $dob);

            // Additional fields
            $location = isset($_POST['location']) ? $conn->real_escape_string($_POST['location']) : null;
            $allergy = isset($_POST['allergy']) ? $conn->real_escape_string($_POST['allergy']) : null;
            $likes = isset($_POST['likes']) ? $conn->real_escape_string($_POST['likes']) : null;
            $dislikes = isset($_POST['dislikes']) ? $conn->real_escape_string($_POST['dislikes']) : null;


        // check if customer already exists
        $checksql = "select * from customers where phone_number = '$customerNumber'";
        $results = $conn -> query($checksql);
        if ($results -> num_rows > 0){
            echo "<script>
            alert('Customer already exists');
            window.location.href = '../customers.php';
            </script>";
        } else {

            // SQL query for inserting customer details including additional fields
            $sql = "call add_customers('$Full_customer_Name', $age, '$gender', '$customerNumber', '$location', '$allergy', '$likes', '$dislikes')";
            if($conn -> query($sql)){
                $_SESSION['message'] = "Customer added successfully";
                    header('Location: ../customers.php');
                    exit();
            }else {
                $_SESSION['message'] = "Error executing statement: " . $conn->error;
            }

            
        } }else {
            $_SESSION['message'] = "Please fill all fields.";
        }
    }

    $conn->close();
}



            

      

function deletecustomer($cid) {
    global $conn ;
    $sql = "call delete_customers($cid)";
    if ($conn ->query($sql)) {
        // Set session variable for success message
        $_SESSION['message'] = "customer deleted successfully";
        header('Location: ../customers.php');
        exit();
    } else {
        $_SESSION['message'] =  "Error deleting customer: " . $conn -> error;
    }
    $conn -> close();
}

function updatecustomer() {
    global $conn, $staffid;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $updated_customerid = $conn->real_escape_string($_POST['customer_id']);


        if ((isset($_POST['customer-firstname']) && !empty($_POST['customer-firstname'])) || (isset($_POST['customer-lastname']) && !empty($_POST['customer-lastname'])) ){
            $updated_name = $conn->real_escape_string($_POST['customer-firstname']." ".$_POST['customer-lastname']);
            
            $sql = "call update_customers_text('customer_name','$updated_name',$updated_customerid)";
            if($conn -> query($sql)){
                echo "updated name successfully";
            };
        }
        
        if (isset($_POST['gender']) && !empty($_POST['gender'])) {
            $updated_gender = $conn->real_escape_string($_POST['gender']);
            
            $sql = "call update_customers_text('gender','$updated_gender',$updated_customerid)";
            if($conn -> query($sql)){
                echo "updated gender successfully";
            };
        }
        
        if (isset($_POST['customer-phone']) && !empty($_POST['customer-phone'])) {
            $updated_phone = $conn->real_escape_string($_POST['customer-phone']);
            
            $sql = "call update_customers_text('phone_number','$updated_phone',$updated_customerid)";
            if($conn -> query($sql)){
                echo "updated phone successfully";
            };
        }
        
        if (isset($_POST['customer-dob']) && !empty($_POST['customer-dob']) ) {
            $updated_dob = $conn->real_escape_string($_POST['customer-dob']);
            $updated_dob = strtotime($updated_dob);
            $updated_age = date("Y") - date("Y", $updated_dob); 
            
            
            $sql = "call update_customers_int('age',$updated_age,$updated_customerid)";
            if($conn -> query($sql)){
                echo "updated successfully";
            };
        }
        

        if (isset($_POST['location'])  && !empty($_POST['location'])) {
            $updated_location = $conn->real_escape_string($_POST['location']);
            
            $sql = "call update_customers_text('location','$updated_location',$updated_customerid)";
            if($conn -> query($sql)){
                echo "updated successfully";
            };}
        }
        

        if (isset($_POST['allergy'])  && !empty($_POST['allergy'])) {
            $updated_allergy = $conn->real_escape_string($_POST['allergy']);
            
            $sql = "call update_customers_text('allergy','$updated_allergy',$updated_customerid)";
            if($conn -> query($sql)){
                echo "updated successfully";
            };
        }
        

        if (isset($_POST['likes'])  && !empty($_POST['likes'])) {
            $updated_likes = $conn->real_escape_string($_POST['likes']);
            
            $sql = "call update_customers_text('likes','$updated_likes',$updated_customerid)";
            if($conn -> query($sql)){
                echo "updated successfully";
            };
        }
        

        if (isset($_POST['dislikes'])  && !empty($_POST['dislikes'])) {
            $updated_dislikes = $conn->real_escape_string($_POST['dislikes']);
            
            $sql = "call update_customers_text('dislikes','$updated_dislikes',$updated_customerid)";
            if($conn -> query($sql)){
                echo "updated successfully";
            };
        }
        header('Location: ../customers.php');
    $conn->close();
    
}
  
   


/* Function calls */
if (isset($_POST['customerlist'])) {
    if ($_POST['customerlist'] === "Add") {
        addcustomer();
        header("location : ../customers.php");
        exit();
    } elseif ($_POST['customerlist'] === "Update"){
            updatecustomer();
            header("location : ../customers.php");
            exit();
        
    } 
    else {
        $_SESSION['message'] =  "Invalid function call: " . $_POST['customerlist'];
        header('Location: ../customers.php');
        
    }
} 

else {
   $_SESSION['message'] =  "Form submission error.";
   header('Location: ../customers.php');
}


 if (isset($_GET["action"])) {
     if (isset($_GET['cid']) && $_GET["action"] === "delete_customer") {
         $customer = htmlspecialchars($_GET['cid']);
         deletecustomer($customer);
         exit();
     }else {
         $_SESSION['message'] =  "Invalid function call: " . $_POST['customerlist'];
     }
 } else {
    $_SESSION['message'] =  "Form submission error.";
 }

