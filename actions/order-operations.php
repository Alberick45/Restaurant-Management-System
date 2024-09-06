<?php
require("config.php");
session_start();

$staffid = $_SESSION['staff_id'];
function addorders() {
    global $conn , $staffid;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['customers'], $_POST['dish'], $_POST['ordermode'], $_POST['orderquantity'])) {
            // Escape and assign POST data to variables
            $customerid = $conn->real_escape_string($_POST['customers']);
            $dishid = $conn->real_escape_string($_POST['dish']);
            $ordermode = $conn->real_escape_string($_POST['ordermode']);

            $orderquantity = isset($_POST['orderquantity']) ? $conn->real_escape_string($_POST['orderquantity']) : '1';

            
   

            // SQL query for inserting dish details including additional fields
            $sql = "call place_orders($customerid, $dishid, '$ordermode',$orderquantity,$staffid)";
            if($conn -> query($sql)){
                $_SESSION['message'] = "Order added successfully";
                    header('Location: ../orders.php');
                    exit();
            }

            
         }else {
            $_SESSION['message'] = "Please fill all fields.";
        }
    }

    $conn->close();
}



            

      

function cancelorder($orderid) {
    global $conn ;
    $sql = "call cancel_order($orderid)";
    $conn -> query($sql);

    header('Location: ../orders.php');
    $conn -> close();
}

function updateorders() {
    global $conn, $staffid;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $orderid = $conn->real_escape_string($_POST['order_id']);

        if (isset($_POST['orderstatus']) && !empty($_POST['orderstatus'])) {
            $updated_order_stat = $conn->real_escape_string($_POST['orderstatus']);
            
            $sql = "call update_order_text('order_status','$updated_order_stat',$orderid)";
            $conn -> query($sql);
        }
        if (isset($_POST['ordermode']) && !empty($_POST['ordermode'])) {
            $updated_order_mode = $conn->real_escape_string($_POST['ordermode']);
            
            $sql = "call update_order_text('order_mode','$updated_order_mode',$orderid)";
            $conn -> query($sql);
        }
        if (isset($_POST['orderquantity']) && !empty($_POST['orderquantity'])) {
            $updated_order_quantity = $conn->real_escape_string($_POST['orderquantity']);
            
            $sql = "call update_order_int('order_quantity','$updated_order_quantity',$orderid)";
            $conn -> query($sql);
        }
        if (isset($_POST['paymentstatus']) && !empty($_POST['paymentstatus'])) {
            $updated_payment_status= $conn->real_escape_string($_POST['paymentstatus']);
            
            $sql = "call update_order_text('payment_status','$updated_payment_status',$orderid)";
            $conn -> query($sql);
        }
        header('Location: ../orders.php');
    }
    $conn->close();
}
    
   


/* Function calls */
if (isset($_POST['orderlist'])) {
    if ($_POST['orderlist'] === "Add") {
        addorders();
        exit();
    } elseif ($_POST['orderlist'] === "Update"){
            updateorders();
            exit();
        
    } 
    else {
        $_SESSION['message'] =  "Invalid function call: " . $_POST['orderlist'];
        header('Location: ../orders.php');
        
    }
} 

else {
    if (isset($_GET["action"])) {
    
    if (isset($_GET['orderid']) && $_GET["action"] === "cancel_order") {
        $orderid = htmlspecialchars($_GET['orderid']);
        cancelorder($orderid);
         exit();
    }
}else{
   $_SESSION['message'] =  "Form submission error.";
   header('Location: ../orders.php');
}
}




