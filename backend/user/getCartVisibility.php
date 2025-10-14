<?php

require_once("../config/config.php");
session_start();
header('Content-Type: application/json');

$cartVisible = isset($_SESSION['cartVisible']) ? $_SESSION['cartVisible'] : false;

echo json_encode(["cartVisible" => $cartVisible]);
?>
