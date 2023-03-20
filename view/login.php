<?php
require('../controller/authActions.php');

if (isset($_SESSION['auth'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/head.php'; ?>
</head>

<body>

    <br><br>
    <form class="container" method="POST">
        <?php if (isset($errorMsg)) {
            echo '<p>' . $errorMsg . '</p>';
        } ?>
        <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" name="password">
        </div>

        <button type="submit" class="btn btn-primary" name="login">Se connecter</button>
    </form>
</body>

</html>