<?php
session_start();
require_once("../reports/reports.php");

header('Content-Type: application/json');

if (!isset($_SESSION["admin_id"]) ) {
    echo json_encode(["status" => "error", "message" => "unauthorized"]);
    exit();
}

if (!isset($_POST["prod_id"]) || !is_numeric($_POST["prod_id"])) {
    echo json_encode(["status" => "error", "message" => "invalid_request"]);
    exit();
}

if (!isset($_POST["password"])) {
    echo json_encode(["status" => "error", "message" => "password_required"]);
    exit;
}

$prod_id = intval($_POST["prod_id"]);
$account_id = $_SESSION["admin_id"];
$password = $_POST["password"];

// Verify admin password
$query_check = "SELECT ac_password FROM tbl_account WHERE ac_id = ?";
$stmt_check = $conn->prepare($query_check);
if ($stmt_check === false) {
    echo json_encode(["status" => "error", "message" => "db_error_check_prepare"]);
    exit;
}
$stmt_check->bind_param("i", $account_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "unauthorized"]);
    $stmt_check->close();
    exit;
}

$row = $result_check->fetch_assoc();
$hashed_password = $row["ac_password"];
$stmt_check->close();

// Verify password
if (!password_verify($password, $hashed_password)) {
    echo json_encode(["status" => "error", "message" => "invalid_password"]);
    exit;
}

// Get image filenames for the product so we can remove files after deletion
$selectQ = "SELECT prod_img, prod_hover_img, prod_name FROM tbl_products WHERE prod_id = ?";
$selStmt = $conn->prepare($selectQ);
if ($selStmt === false) {
    echo json_encode(["status" => "error", "message" => "db_error_select_prepare"]);
    exit();
}
$selStmt->bind_param("i", $prod_id);
$selStmt->execute();
$res = $selStmt->get_result();
if ($res->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "not_found"]);
    $selStmt->close();
    exit();
}
$row = $res->fetch_assoc();
$prod_img = $row['prod_img'];
$prod_hover_img = $row['prod_hover_img'];
$prod_name = $row['prod_name'];
$selStmt->close();

// Begin delete transaction
$conn->begin_transaction();
try {
    $delQ = "DELETE FROM tbl_products WHERE prod_id = ?";
    $delStmt = $conn->prepare($delQ);
    if ($delStmt === false) {
        throw new Exception('delete_prepare_failed');
    }
    $delStmt->bind_param("i", $prod_id);
    if (!$delStmt->execute()) {
        throw new Exception('delete_execute_failed');
    }
    $delStmt->close();

    // Remove image files from the filesystem (best-effort)
    $imagesDir = realpath(dirname(__FILE__)) . "/../../images/products/";
    $hoverDir = realpath(dirname(__FILE__)) . "/../../images/products-hover/";

    if (!empty($prod_img)) {
        $imgPath = $imagesDir . $prod_img;
        if (file_exists($imgPath)) {
            @unlink($imgPath);
        }
    }

    if (!empty($prod_hover_img)) {
        $hoverPath = $hoverDir . $prod_hover_img;
        if (file_exists($hoverPath)) {
            @unlink($hoverPath);
        }
    }

    // Log the deletion action
    $query2 = "SELECT ac_username FROM tbl_account WHERE ac_id = ?";
    $stmt2 = $conn->prepare($query2);
    if ($stmt2) {
        $stmt2->bind_param("i", $account_id);
        $stmt2->execute();
        $result = $stmt2->get_result();
        if($result && $result->num_rows > 0){
            $data = $result->fetch_assoc();
            $username = $data["ac_username"];
            $act = "Deleted Product: $prod_name (ID: $prod_id)";
            $type = "Admin";
            report($conn, $account_id, $username, $act, $type);
        }
        $stmt2->close();
    }

    $conn->commit();
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

// Close connection
if (isset($conn) && $conn) $conn->close();
?>