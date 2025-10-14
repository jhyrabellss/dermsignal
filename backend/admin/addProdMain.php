<?php
session_start();
require_once("../reports/reports.php");

if (isset($_POST["prodNameMain"])) {
    $admin_id = $_SESSION["admin_id"];
    $prod_name_main = $_POST['prodNameMain'];
    $l_prod_name = strtolower($prod_name_main);

    // Create a folder with the product name inside the existing assets folder
    $assets_folder = realpath("../../assets"); // Get the absolute path of the existing assets folder
    $folder_name = $assets_folder . '/' . preg_replace('/[^A-Za-z0-9_-]/', '_', $l_prod_name); // Sanitize the folder name

    if (!file_exists($folder_name)) {
        mkdir($folder_name, 0777, true);

        $query = "INSERT INTO tbl_product_type (prod_type_name) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $prod_name_main);
        $stmt->execute();

        $query2 = "SELECT ac_username FROM tbl_account WHERE account_id = ?";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("i", $admin_id);
        $stmt2->execute();
        $result = $stmt2->get_result();
        if($result->num_rows > 0){
            $data = $result->fetch_assoc();
            $username = $data["ac_username"];
            $act = "Add Product";
            $type = "Admin";
            report($conn, $admin_id, $username, $act, $type);
        }

        echo "success";
    } else {
        echo "exist";
    }
}
?>
