<?php
/* Here we receive the CSV file and process it into a dictionary format using fetch_assoc.
   We retrieve the first name, last name, DOB, country code (default is +233), 
   phone number (removing the first 0), and randomly assign a message with type
   as either important, special, or love.
*/
require("config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['contact_file'])) {
    $contact_file = $_FILES['contact_file'];

    // Check if the file is uploaded without errors
    if ($contact_file['error'] == 0) {
        $contact_file_path = $contact_file['tmp_name'];

        // Validate file type
        $file_ext = pathinfo($contact_file['name'], PATHINFO_EXTENSION);
        if ($file_ext !== 'csv') {
            die("Invalid file type. Please upload a CSV file.");
        }
        
        // Open the CSV file
        if (($handle = fopen($contact_file_path, "r")) !== FALSE) {
            
            // Get the first row (header) and validate column count and header names
            $headers = fgetcsv($handle, 1000, ",");
            $expected_headers = ['First Name', 'Last Name', 'DOB', 'Phone Number'];

            // Check if the CSV has exactly 5 columns
            if (count($headers) !== 4) {
                die("Invalid CSV format. The file must have exactly 4 columns.");
            }

            // Check if the headers match the expected headers
            if ($headers !== $expected_headers) {
                die("Invalid CSV format. The file headers must be: 'First Name', 'Last Name', 'DOB', 'Phone Number'.");
            }

            // Retrieve all message IDs from the messages table
            $message_ids = [];
            $result = $conn->query("SELECT m_id FROM messages");
            while ($row = $result->fetch_assoc()) {
                $message_ids[] = $row['m_id'];
            }

            // Check if there are any message IDs available
            if (empty($message_ids)) {
                die("No messages available to assign.");
            }

            // Loop through the CSV rows
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $firstname = $conn->real_escape_string($data[0]);
                $lastname = $conn->real_escape_string($data[1]);
                $dateOfBirth = $conn->real_escape_string($data[2]);
                $FullNum = $conn->real_escape_string($data[3]);
                list($countrycode, $contactNumber)= explode(' ',$FullNum);
                
                // Remove leading zero from phone number
                if (substr($contactNumber, 0, 1) === '0') {
                    $contactNumber = substr($contactNumber, 1);
                }

                // Default country code to +233 if none provided
                $countrycode = empty($countrycode) ? '+233' : $countrycode;

                // Combine country code and phone number
                $PhoneNumber = $countrycode . $contactNumber;

                // Randomly assign a message ID from the list
                $random_message_id = $message_ids[array_rand($message_ids)];

                // Insert the data into the contacts table
                $sql = "INSERT INTO contacts (cf_name, cl_name, c_dob, c_pnum, c_mid, c_ruid, m_stat) VALUES (?, ?, ?, ?, ?, ?, 0)";
                $stmt = $conn->stmt_init();
                if ($stmt->prepare($sql)) {
                    $stmt->bind_param('ssssssi', $firstname, $lastname, $dateOfBirth,  $PhoneNumber, $random_message_id, $_SESSION['user id']);
                    if ($stmt->execute()) {
                        $_SESSION['message'] = "Contact added successfully";
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "Error preparing statement: " . $conn->error;
                }
            }

            // Close the file and database connection
            fclose($handle);
            $conn->close();

            echo "CSV file data successfully imported!";
            header('Location: ../admin_contacts.php?message=CSV file data successfully imported!');
        } else {
            echo "Error opening the file.";
        }
    } else {
        echo "Error uploading the file.";
    }
} else {
    echo "No file was uploaded.";
}

exit();
?>


<!-- it should just upload phone number not country code so edit it so type number and add country code so we store everything -->