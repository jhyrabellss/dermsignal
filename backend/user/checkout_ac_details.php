
<?php
//php for checkout (add delivery for ship/pickup)
// Required configuration file for database connection
require_once("../config/config.php");

if (
    isset($_POST["fname"]) && isset($_POST["mname"]) &&
    isset($_POST["lname"]) && isset($_POST["email"]) && isset($_POST["contactNo"]) &&
    isset($_POST["address"]) && isset($_POST["unit_number"]) && isset($_POST["barangay"]) && isset($_POST["postal_code"]) &&
    isset($_POST["region"]) && isset($_POST["phone_number"])
) {
    // Sanitize user inputs to prevent SQL injection
    $fname = htmlspecialchars(trim($_POST["fname"]));
    $mname = htmlspecialchars(trim($_POST["mname"]));
    $lname = htmlspecialchars(trim($_POST["lname"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $contactNo = htmlspecialchars(trim($_POST["contactNo"]));
    $address = htmlspecialchars(trim($_POST["address"]));
    $unit_number = htmlspecialchars(trim($_POST["unit_number"]));
    $barangay = htmlspecialchars(trim($_POST["barangay"]));
    $postal_code = htmlspecialchars(trim($_POST["postal_code"]));
    $region = htmlspecialchars(trim($_POST["region"]));
    $phone_number = htmlspecialchars(trim($_POST["phone_number"]));
    $role_id = 1; // Assuming 1 is the default role for users

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username or email already exists
    $query = "SELECT * FROM tbl_account WHERE ac_username = ? OR ac_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "existed";
    } else {
        // Insert into tbl_account
        $query2 = "INSERT INTO tbl_account (ac_username, ac_email, ac_password, role_id) VALUES(?, ?, ?, ?)";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("sssi", $username, $email, $hashedPassword, $role_id);

        if ($stmt2->execute()) {
            $account_id = $stmt2->insert_id;

            // Insert into tbl_account_details
            $query3 = "INSERT INTO tbl_account_details (
                account_id, first_name, middle_name, last_name, gender, contact, address,
                unit_number, barangay, postal_code, region, phone_number
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt3 = $conn->prepare($query3);
            $stmt3->bind_param(
                "isssssssssss",
                $account_id, $fname, $mname, $lname, $gender, $contactNo, $address,
                $unit_number, $barangay, $postal_code, $region, $phone_number
            );

            if ($stmt3->execute()) {
                echo "success";
            } else {
                echo "Error: " . $stmt3->error;
            }
        } else {
            echo "Error: " . $stmt2->error;
        }
    }

    // Close the statements and connection
    $stmt->close();
    $stmt2->close();
    $stmt3->close();
    $conn->close();
} else {
    echo "Incomplete data provided.";
}
?>
