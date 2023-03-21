<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION['auth'])) {
    header('Location: ../controller/authActions.php');
} 