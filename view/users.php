<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require('../controller/securityAction.php');
require('../controller/usersActions.php');

if ($_SESSION['id_role'] == 3) {
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/head.php'; ?>
</head>

<body>
    <?php include '../includes/scripts.php'; ?>
    <?php include '../includes/navbar.php' ?>





    <?php if (isset($_GET['id']) && in_array($_GET['id'], array_column($users, 'id_user'))) {
        if (count($oneUser) != 0) {
            $oneUser = $oneUser[0];

    ?>
            <a href="users.php#user<?= $_GET['id'] ?>" class="btn btn-primary">back</a>
            <h1><?= $oneUser['last_name'] ?></h1>
            <form class="container" method="POST" action="#">
                <?php if (isset($errorMsg)) {
                    echo '<p>' . $errorMsg . '</p>';
                } ?>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Prénom :</label>
                    <input type="text" class="form-control" name="first_name" value="<?= $oneUser['first_name'] ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nom :</label>
                    <input type="text" class="form-control" name="last_name" value="<?= $oneUser['last_name'] ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Adresse e-mail :</label>
                    <input type="email" class="form-control" name="email" value="<?= $oneUser['email'] ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Changer le mot de passe :</label>
                    <input type="password" class="form-control" name="first_password">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Répéter le mot de passe :</label>
                    <input type="password" class="form-control" name="second_password">
                </div>
                <br>
                <h5>Adresse :</h5>
                <div class="mb-3">
                    <label class="form-label">Libellé :</label>
                    <input type="text" class="form-control" name="label" id="label" value="<?= $oneUser['name'] ?>">

                </div>
                <div class="mb-3">
                    <label class="form-label">Code postal :</label>
                    <input type="number" class="form-control" name="postal_code" id="postal_code" value="<?= $oneUser['postal_code'] ?>">
                </div>
                <label class="form-label">Ville :</label>
                <select name="city" id="city" class="mb-3 form-select">
                    <option value="<?= $oneUser['city_name'] ?>"><?= $oneUser['city_name'] ?></option>
                </select>
                <input type="hidden" name="address_id" value="<?= $oneUser['id_address'] ?>">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary" name="update">Modifier</button>
                <button type="submit" class="btn btn-danger" name="delete">Supprimer</button>
                <script>
                    //startCity(<?= $oneUser['city_name'] ?>);
                </script>
            </form>






        <?php } else { ?>
            <h1>Utilisateur Inexistant</h1>
        <?php }
    } else { ?>
        <!-- Modal -->

        <br><br>
        <div class="container">
            <div class="modal fade" id="newUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="container" method="POST" action="#">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Nouvel utilisateur</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php if (isset($errorMsg)) {
                                    echo '<p>' . $errorMsg . '</p>';
                                } ?>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Prénom :</label>
                                    <input type="text" class="form-control" name="first_name">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nom :</label>
                                    <input type="text" class="form-control" name="last_name">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Adresse e-mail :</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Mot de passe :</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="" class="form-label">Role :</label>
                                    <select name="role" id="role" class="mb-3 form-select">
                                        <?php
                                        if ($_SESSION['id_role'] == '1') {
                                            echo '<option value="2">Pilote</option>
                        <option value="3">Etudiant</option>';
                                        } else {
                                            echo ' <option value="3">Etudiant</option>';
                                        } ?>
                                    </select>
                                </div><br>
                                <div class="mb-3" id="promodiv">
                                    <label for="" class="form-label">Promotion :</label>
                                    <select name="promo" class="mb-3 form-select">
                                        <?php foreach ($campuses as $onecampus) { ?>
                                            <optgroup label="<?= $onecampus[1] ?>">
                                                <?php if ($_SESSION['id_role'] == 1) { ?>
                                                    <?php foreach (getPromoByIDcampus($onecampus['id_campus']) as $onepromo) { ?>
                                                        <option value="<?= $onepromo['id_promo'] ?>"><?= $onepromo[1] ?></option>
                                                    <?php }
                                                } else { ?>
                                                    <?php foreach (getPromoByIDcampusAndPilot($onecampus['id_campus']) as $onepromo) { ?>
                                                        <option value="<?= $onepromo['id_promo'] ?>"><?= $onepromo['name'] ?></option>
                                                <?php }
                                                } ?>

                                            </optgroup>
                                        <?php } ?>
                                    </select>
                                    <script>
                                        $(document).ready(function() {

                                            if ($('#role').val() == 3) {
                                                document.getElementById('promodiv').hidden = false;
                                                //$('#promodiv').(false);
                                            } else {
                                                document.getElementById('promodiv').hidden = true;
                                                //$('#promodiv').hidden(true);
                                            }
                                            $('#role').change(function() {

                                                if ($('#role').val() == 3) {
                                                    document.getElementById('promodiv').hidden = false;
                                                    //$('#promodiv').(false);
                                                } else {
                                                    document.getElementById('promodiv').hidden = true;
                                                    //$('#promodiv').hidden(true);
                                                }
                                            });
                                        });
                                    </script>
                                </div>




                                <div class="mb-3">
                                    <label class="form-label">Libellé :</label>
                                    <input type="text" class="form-control" name="label" id="label" value>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Code postal :</label>
                                    <input type="text" class="form-control" name="postal_code" id="postal_code">
                                </div>
                                <label class="form-label">Ville :</label>
                                <select name="city" id="city" class="mb-3 form-select">

                                </select><br>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary" name="create">Créer</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
            <?php if (isset($errorMsg)) { ?>
                <p><?= $errorMsg ?></p>
            <?php } ?>
            <?php if ($_SESSION['id_role'] != 3) { ?>
                <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newUserModal">
                    Ajouter un utilisateur
                </button>
            <?php } ?>
            <br><br>
            <?php foreach ($users as $user) { ?>
                <div class="card" id="user<?= $user['id_user'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><a class="nav-link" href="users.php?id=<?= $user['id_user'] ?>"><?= $user['last_name'] ?> <?= $user['first_name'] ?></a></h5>
                        <p class="card-text">Contact : <a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a></p>
                        <?php if (true || $_SESSION['id_role'] == 1) { ?>
                            <a href="users.php?id=<?= $user['id_user'] ?>" class="btn btn-primary">Modifier</a>
                        <?php } ?>
                    </div>
                </div>
                <br>
            <?php } ?>
        </div>

    <?php } ?>

</body>
<?php include '../includes/footer.php'; ?>

</html>