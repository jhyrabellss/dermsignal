<?php 
    session_start();
    session_destroy();
    unset($_SESSION["derm_id"]);

    header("Location: ../index.php");
?>