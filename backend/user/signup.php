<?php require_once("../config/config.php");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["email"], $_POST["username"], $_POST["password"], $_POST["fname"], $_POST["mname"], $_POST["lname"])){
       
        $fname = $_POST["fname"];
        $mname = $_POST["mname"];
        $lname = $_POST["lname"];
        $user = $_POST['username'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $role_id = 1;

        // Debugging
        error_log("Received Data: Username = $user, Email = $email");

        // Hash the password
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        // Check if user exists
        $query = "SELECT * FROM tbl_account WHERE ac_username = ? OR ac_email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $user, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "existed";
        } else {
            // Insert data into the database
            $query2 = "INSERT INTO tbl_account (ac_username, ac_email, ac_password, role_id) VALUES (?, ?, ?, ?)";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bind_param("sssi", $user, $email, $hashed_password, $role_id);

            if ($stmt2->execute()) {
                
            } else {
                error_log("SQL Error: " . $stmt2->error);
                echo "SQL Error: " . $stmt2->error;
            }

            $account_id = $stmt2->insert_id;

            $query3 = "INSERT INTO tbl_account_details (ac_id, first_name, middle_name, last_name)
            VALUES(?, ?, ?, ?)";
            $stmt3 = $conn->prepare($query3);
            $stmt3->bind_param("isss", $account_id, $fname, $mname, $lname);
            $stmt3->execute();
        }
    } else {
        echo "Invalid request data.";
    }
} else {
    echo "Invalid request method.";
}


?>