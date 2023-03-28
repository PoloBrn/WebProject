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

<iframe width="560" height="315" src="https://www.youtube.com/embed/tkwmB6n3s_g" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></body>
<?php include '../includes/footer.php';
?>
</html>