<?php 
    session_start();
    unset($_SESSION["admin_id"]);
    unset($_SESSION["admin_fullname"]);
?>

<script>
    localStorage.removeItem("adminDetails");
    window.location.href =  "../index.php";
</script>