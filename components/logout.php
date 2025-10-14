<?php 
    session_start();
    unset($_SESSION["user_id"]);
    session_unset();
    session_destroy();

?>
<script>
    window.location.href =   window.location.href ;
    localStorage.removeItem('')
</script>
