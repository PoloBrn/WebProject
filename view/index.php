<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();



include '../includes/head.php';   
?><link rel="stylesheet" href="../assets/CSS/index.css"> <?php



        include '../includes/scripts.php';
        require('../controller/securityAction.php');  
        include '../includes/background.php'; ?>
    


<body>
    <?php 
    ?>
    
    <h1>Bienvenue, <?= $_SESSION['last_name']." ".$_SESSION['first_name']; ?></h1>

<?php include '../includes/footer.php';
?>
</html>