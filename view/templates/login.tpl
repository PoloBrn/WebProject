
<!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>

    <br><br>
    <form class="container" method="POST">

        {if isset($errorMsg)}
            {$errorMsg}
        {/if}

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
