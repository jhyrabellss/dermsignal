<?php 
    session_start();
    require_once("../config/config.php");

    if(isset($_POST["username"]) && isset($_POST["password"]))
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $query = "SELECT ac_id, ac_password, ac_username, account_status_id, role_id 
        FROM tbl_account 
        WHERE ac_username = ?"; 

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $data = $result->fetch_assoc();
            $hashedPassword = $data["ac_password"];

            if(password_verify($password, $hashedPassword))
            {
                $status = $data["account_status_id"];
                if($status == 2){
                    echo "deactivated";
                    exit();
                }
                $query2 = "INSERT INTO tbl_audit_log(log_user_id, log_username, log_user_type) VALUES(?, ?, ?)";
                $stmt2 = $conn->prepare($query2);
                $stmt2->bind_param("isi", $data["ac_id"], $data["ac_username"], $data["role_id"]);
                $stmt2->execute();

                $role_id = $data["role_id"];
                $sessionData = array(
                    "account_id" => $data["ac_id"],
                    "role_id" => $data["role_id"],
                    "username" =>  $data["ac_username"],
                ); //array_associative
                if($role_id == 1){
                    $_SESSION["user_id"] = $data["ac_id"];
                }else if($role_id == 2){
                    $_SESSION["admin_id"] = $data["ac_id"];
                }else if($role_id == 3){
                    $_SESSION["derm_id"] = $data["ac_id"];
                }
                echo json_encode($sessionData);
            }else{
                echo "Invalid Password";
            }

        }else{
            echo "Invalid Password";
        }
    }


?>