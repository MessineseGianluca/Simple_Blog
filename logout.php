<?php
session_start();
$_SESSION['authenticated'] = false;

// remove all session variables
session_unset(); 

// destroy the session 
session_destroy();
header('Location: login.html');
?>
