<?php 
    session_start();
    session_destroy();  
    header("location: /Helpdesk/View/index.php");
?>