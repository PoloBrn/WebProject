<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require('../controller/securityAction.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../includes/head.php'; ?>
    <link rel="stylesheet" href="../assets/CSS/index.css">
</head>

<body>
    <?php include '../includes/scripts.php'; ?>
    <script>
        /*
        window.addEventListener("load",()=> {
           if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('serviceWorker.js');
        } 
        });
        */
    </script>
    <h1>Nom : <?= $_SESSION['last_name'] ?></h1>
    <h1>Prénom : <?= $_SESSION['first_name'] ?></h1>

</body>
<?php include '../includes/footer.php';

?>
</html>