<?php
    // start the session
    session_start();
    
    // unset the session variables
    $_SESSION = array();
    
    // destroy the session
    session_destroy();
    
    // redirect to the login page
    header("Location: home.php");
    exit;
?>
