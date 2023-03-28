<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/head.php';    
        include '../includes/scripts.php';
        require('../controller/securityAction.php');  
        include '../includes/background.php'; ?>
    <link rel="stylesheet" href="../assets/CSS/index.css">
</head>

<body>
    <?php 
    ?>
    
    <h1>Bienvenue, <?= $_SESSION['last_name']." ".$_SESSION['first_name']; ?></h1>

<?php include '../includes/footer.php';
?>
</html>