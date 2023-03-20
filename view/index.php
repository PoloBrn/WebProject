<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require('../controller/securityAction.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/head.php'; ?>
</head>

<body>
    <?php include '../includes/navbar.php'; ?>
    <?php include '../includes/scripts.php'; ?>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js');
        }
    </script>
    <h1>Nom : <?= $_SESSION['last_name'] ?></h1>
    <h1>Prénom : <?= $_SESSION['first_name'] ?></h1>

</body>
<?php include '../includes/footer.php';?>
</html>