<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require('../controller/securityAction.php');
require('../controller/companiesActions.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/head.php'; ?>
</head>

<body>
    <?php include '../includes/scripts.php'; ?>
    
    <?php include '../includes/navbar.php' ?>

    <div class="modal fade" id="newCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="container" method="POST" action="#">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nouvelle entreprise</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nom de l'entreprise :</label>
                            <input type="text" class="form-control" name="company_name">
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Adresse e-mail de contact :</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nombre d'étudiants CESI déjà acceptés en stage</label>
                            <input type="number" class="form-control" name="nb_student">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Logo</label>
                            <input type="file" accept="image/png, image/gif, image/jpeg" class="form-control" name="logo">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" name="create">Créer</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="newaddrModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="container" method="POST" action="#">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nouvelle adresse</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                        <button type="submit" class="btn btn-primary" name="createAddress">Ajouter</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <?php if (isset($_GET['id'])) {
        if (count($company_infos) != 0) {
            $company = $company_infos[0]; ?>
            <a href="companies.php#company<?= $_GET['id'] ?>" class="btn btn-primary">back</a>
            <h1><?= $company['name'] ?></h1>

            <?php



            if (isset($_GET['edit']) && ($_SESSION['id_user'] == $company['id_user'] || $_SESSION['id_role'] == 1)) { ?>
                <form class="container" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nom de l'entreprise :</label>
                        <input type="text" class="form-control" name="company_name" value="<?= $company['name'] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Adresse e-mail de contact :</label>
                        <input type="email" class="form-control" name="email" value="<?= $company['email'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nombre d'étudiants CESI déjà acceptés en stage</label>
                        <input type="number" class="form-control" name="nb_student" value="<?= $company['nb_student'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Logo</label>
                        <input type="file" accept="image/png, image/gif, image/jpeg" class="form-control" name="logo">
                    </div>
                    </div>

                    <a href="companies.php?id=<?= $company['id_company'] ?>" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary" name="update">Modifier</button>
                    <button type="submit" class="btn btn-danger" name="delete">Supprimer</button>
                </form>
                <br><br>
                <form class="container" method="post">
                    <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newaddrModal">
                        Ajouter une adresse
                    </button>
                    <button type="submit" class="btn btn-danger" name="deleteAddress">
                        Supprimer une adresse
                    </button>
                    <select name='address' id="address" class="form-control" size="10">
                        <?php

                        foreach ($addresses as $address) {
                        ?>
                            <option value="<?= $address['id_address'] ?>">
                                <?= $address['name'] ?> <?= $address['postal_code'] ?> <?= $address['city_name'] ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </form>
            <?php } ?>





        <?php } else { ?>
            <h1>Entreprise Inexistante</h1>
        <?php }
    } else { ?>
        <!-- Modal -->

        <br><br>
        <div class="container">

            <?php if (isset($errorMsg)) { ?>
                <p><?= $errorMsg ?></p>
            <?php } ?>
            <?php if ($_SESSION['id_role'] != 3) { ?>
                <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newCompanyModal">
                    Ajouter une entreprise
                </button>
            <?php } ?>
            <br><br>
            <?php foreach ($allCompanies as $company) { ?>
                <div class="card" id="company<?= $company['id_company'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><a class="nav-link" href="companies.php?id=<?= $company['id_company'] ?>"><?= $company['name'] ?></a></h5>
                        <p class="card-text">Contact : <a href="mailto:<?= $company['email'] ?>"><?= $company['email'] ?></a></p>
                        <?php if ($_SESSION['id_user'] == $company['id_user'] || $_SESSION['id_role'] == 1) { ?>
                            <a href="companies.php?id=<?= $company['id_company'] ?>&edit" class="btn btn-primary">Modifier</a>
                        <?php } ?>
                    </div>
                </div>
                <br>
            <?php } ?>
        </div>

    <?php } ?>

</body>
<?php include '../includes/footer.php';?>
</html>