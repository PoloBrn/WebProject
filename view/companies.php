<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require('../controller/companiesActions.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/head.php'; ?>
</head>

<body>
    <?php require('../controller/securityAction.php');
    include '../includes/scripts.php'; ?>

    <?php if (isset($errorMsg)) { ?>
        <p class="errorMsg"><?= $errorMsg ?></p>
    <?php } ?>
    <div class="modal fade" id="newCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="container" method="POST" enctype="multipart/form-data">
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
                            <label for="exampleInputPassword1" class="form-label">Logo :</label>
                            <input type="file" accept="image/png, image/gif, image/jpeg" multiple class="form-control" name="logo">
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

    <div class="modal fade" id="newActivityModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="container" method="POST" action="">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nouveau secteur d'activité</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nom :</label>
                            <input type="text" class="form-control" name="create_activity_name">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" name="create_activity">Créer</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="container" method="POST" action="">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un secteur d'activité</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Secteur d'activité :</label>
                            <select name="activity" class="mb-3 form-select">
                                <?php foreach ($allActivities as $oneactivity) { ?>
                                    <option value="<?= $oneactivity['id_activity']; ?>"><?= $oneactivity['activity_name']; ?></option>
                                <?php } ?>

                            </select><br>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" name="add_activity">Ajouter</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <?php if (isset($_GET['activity']) && !($_SESSION['id_role'] == 3)) {
        echo 'modifier les secteurs d\'activité'; ?>






        <div class="container">
            <a href="companies.php" class="btn btn-primary">back</a>
            <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newActivityModal">
                Ajouter un secteur d'activité
            </button>
            <br><br>

            <?php foreach ($allActivities as $oneActivity) { ?>
                <form class="card" method="POST" id="activity<?= $oneActivity['id_activity'] ?>">
                    <div class="card-body">
                        <input type="text" name="name_activity" class="card-title form-control" id="" value='<?= $oneActivity['activity_name'] ?>'>
                        <input type="hidden" name="id_activity" value="<?= $oneActivity['id_activity'] ?>">
                        <input type="submit" name='update_activity' class="btn btn-primary" value="Modifier">
                        <input type="submit" name='delete_activity' class="btn btn-danger" value="Supprimer">
                    </div>
                </form>
                <br>
            <?php } ?>

        </div>
    <?php } else { ?>

        <?php if (isset($_GET['id'])) {
            if (count($company_infos) != 0) {
                $company = $company_infos[0]; ?>
                <a href="companies.php#company<?= $_GET['id'] ?>" class="btn btn-primary">back</a>

                <?php



                if (isset($_GET['edit']) && ($_SESSION['id_user'] == $company['id_user'] || $_SESSION['id_role'] == 1)) { ?>
                    <div class="container">
                        <h5>Informations :</h5>
                        <form class="container" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nom de l'entreprise :</label>
                                <input type="text" class="form-control" name="company_name" value="<?= $company['company_name'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Adresse e-mail de contact :</label>
                                <input type="email" class="form-control" name="email" value="<?= $company['email'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Nombre d'étudiants CESI déjà acceptés en stage : </label>
                                <input type="number" class="form-control" name="nb_student" value="<?= $company['nb_student'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Logo :</label>
                                <input type="file" accept="image/png, image/gif, image/jpeg" multiple class="form-control" name="logo">
                            </div>

                            <a href="companies.php?id=<?= $company['id_company'] ?>" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary" name="update">Enregistrer</button>
                            <button type="submit" class="btn btn-danger" name="delete">Supprimer</button>
                        </form>
                    </div>
                    <hr>
                    <br>
                    <div class="container">
                        <h5>Addresse(s) :</h5><br>
                        <form class="container" method="post">
                            <select name='address' id="address" class="form-control" size="
                            <?php if (count($addresses) < 2) {
                                echo "2";
                            } elseif (count($addresses) > 8) {
                                echo "8";
                            } else {
                                echo count($addresses);
                            }
                            ?>">
                                <?php

                                foreach ($addresses as $address) {
                                ?>
                                    <option value="<?= $address['id_address'] ?>">
                                        <?= $address['label'] ?> <?= $address['postal_code'] ?> <?= $address['city_name'] ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select><br>
                            <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newaddrModal">
                                Ajouter une adresse
                            </button>
                            <button type="submit" class="btn btn-danger" name="deleteAddress">
                                Supprimer une adresse
                            </button>
                        </form>
                    </div>
                    <hr>
                    <br>
                    <div class="container">
                        <h5>Secteur(s) d'activité :</h5><br>
                        <form class="container" method="post">
                            <select name='id_activity' class="form-control" size="
                            <?php if (count($company_activities) < 2) {
                                echo "2";
                            } elseif (count($company_activities) > 8) {
                                echo "8";
                            } else {
                                echo count($company_activities);
                            }
                            ?>">
                                <?php

                                foreach ($company_activities as $acti) {
                                ?>
                                    <option value="<?= $acti['id_activity'] ?>">
                                        <?= $acti['activity_name'] ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                            <br>
                            <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                                Ajouter un secteur d'activité
                            </button>
                            <button type="submit" class="btn btn-danger" name="remove_activity">
                                Retirer un secteur d'activité
                            </button>
                        </form>
                    </div>
                <?php } ?>





            <?php } else { ?>
                <h1>Entreprise Inexistante</h1>
            <?php }
        } else { ?>
            <!-- Modal -->

            <br><br>
            <div class="container" id="">

                <?php if (isset($errorMsg)) { ?>
                    <p class="errorMsg"><?= $errorMsg ?></p>
                <?php } ?>
                <?php if ($_SESSION['id_role'] != 3) { ?>
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newCompanyModal">
                            Ajouter une entreprise
                        </button>
                        <a href="companies.php?activity" class="btn btn-primary">Gérer les secteurs d'activité</a>
                    </div>
                <?php } ?>
                <br><br>
                <?php foreach ($allCompanies as $company) { ?>
                    <div class="card flex-row card_company" id="company<?= $company['id_company'] ?>">
                        <img alt="logo" class="card-img-left example-card-img-responsive logo_company" src="../assets/company-logos/<?= $company['logo'] ?>" />
                        <div class="card-body">
                            <h5 class="card-title"><a class="nav-link" href="companies.php?id=<?= $company['id_company'] ?>"><?= $company['company_name'] ?></a></h5>
                            <p class="card-text">Contact : <a href="mailto:<?= $company['email'] ?>"><?= $company['email'] ?></a></p>
                            <?php if ($_SESSION['id_user'] == $company['id_user'] || $_SESSION['id_role'] == 1) { ?>
                                <a href="companies.php?id=<?= $company['id_company'] ?>&edit" class="btn btn-primary">Modifier</a>
                            <?php } ?>
                        </div>
                    </div>
                    <br>
                <?php } ?>
            </div>

    <?php }
    } ?>

</body>
<?php include '../includes/footer.php'; ?>

</html>