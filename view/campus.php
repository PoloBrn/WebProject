<?php
require '../controller/campusAction.php';

if ($_SESSION['id_role'] != 1) {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/head.php'; ?>
</head>

<body>
    <?php include '../includes/navbar.php';
    include '../includes/scripts.php'; ?>
    <div class="modal fade" id="newTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="container" method="POST" action="#">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nouveau type de promo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nom :</label>
                            <input type="text" class="form-control" name="create_type_name">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" name="create_type">Créer</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="newCampusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="container" method="POST" action="#">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nouveau campus</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nom du campus :</label>
                            <input type="text" class="form-control" name="create_campus_name">
                        </div>
                        <h5>Adresse :</h5>
                        <div class="mb-3">
                            <label class="form-label">Libellé :</label>
                            <input type="text" class="form-control" name="label" id="label">

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Code postal :</label>
                            <input type="number" class="form-control" name="postal_code" id="postal_code">
                        </div>
                        <label class="form-label">Ville :</label>
                        <select name="city" id="city" class="mb-3 form-select">
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" name="create_campus">Créer</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="newPilotModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="container" method="POST" action="#">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nouveau pilote</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pilote :</label>
                            <select name="new_pilot" id="new_pilot" class="mb-3 form-select">
                                <?php foreach ($pilots as $pilot) { ?>
                                    <option value="<?= $pilot['id_user'] ?>"><?= $pilot['first_name'] ?> <?= $pilot['last_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" name="addPilot">Ajouter</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="container" method="POST" action="#">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nouveal Etudiant</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Etudiant :</label>
                            <select name="new_student" id="new_student" class="mb-3 form-select">
                                <?php foreach ($students as $student) { ?>
                                    <option value="<?= $student['id_user'] ?>"><?= $student['first_name'] ?> <?= $student['last_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" name="addStudent">Ajouter</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['promo'])) {
        if (empty($_GET['promo'])) { ?>
            <h1>Promotion Inconnue</h1>
            <?php } else {
            if (count($promo_infos) != 0) {
                $promo = $promo_infos[0]; ?>
                <a href="campus.php#promo<?= $promo['id_promo'] ?>" class="btn btn-primary">back</a>
                <h1><?= $promo[1] ?></h1>
                <form class="container" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nom de la promotion :</label>
                        <input type="text" class="form-control" name="update_promo_name" value="<?= $promo[1] ?>">
                    </div>
                    <input type="hidden" name="promo_id" value="<?= $promo['id_promo'] ?>">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Type de la promotion :</label>
                        <select name="update_promo_type" id="update_promo_type" class="mb-3 form-select">
                            <?php foreach ($promoTypes as $promoType) { ?>
                                <option value="<?= $promoType['id_type'] ?>"><?= $promoType['name'] ?></option>
                            <?php } ?>
                        </select>
                        <script>
                            $('#update_promo_type').val(<?= $promo['id_type'] ?>);
                        </script>
                    </div>
                    </div>

                    <button type="submit" class="btn btn-primary" name="update">Enregistrer</button>
                    <a href="campus.php#promo=<?= $promo['id_promo'] ?>" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-danger" name="delete">Supprimer</button>
                </form>

                <br><br>
                <h5>Pilote(s) :</h5>
                <br>
                <form class="container" method="post">
                    <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newPilotModal">
                        Ajouter un pilote
                    </button>
                    <button type="submit" class="btn btn-danger" name="deletePilotStudent">
                        Supprimer un pilote
                    </button>
                    <br><br>
                    <select name='user' id="tutor" class="form-control" size="5">
                        <?php

                        foreach ($promo_pilots as $pilot) {
                        ?>
                            <option value="<?= $pilot['id_user'] ?>">
                                <?= $pilot['first_name'] ?> <?= $pilot['last_name'] ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </form>
                <br>
                <h5>Etudiant(s) :</h5>
                <br>
                <form class="container" method="post">
                    <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newStudentModal">
                        Ajouter un étudiant
                    </button>
                    <button type="submit" class="btn btn-danger" name="deletePilotStudent">
                        Supprimer un étudiant
                    </button>
                    <br><br>
                    <select name='user' id="tutor" class="form-control" size="5">
                        <?php

                        foreach ($promo_students as $student) {
                        ?>
                            <option value="<?= $student['id_user'] ?>">
                                <?= $student['first_name'] ?> <?= $student['last_name'] ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </form>





            <?php } else { ?>
                <h1>Promotion Inexistante</h1>
        <?php }
        }
    } elseif (isset($_GET['type'])) {
        echo 'modifier les types de promo'; ?>






        <div class="container">
            <a href="campus.php" class="btn btn-primary">back</a>
            <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newTypeModal">
                Ajouter un type de promo
            </button>
            <br><br>

            <?php foreach ($promoTypes as $promoType) { ?>
                <form class="card" method="POST" id="<?= $promoType['id_type'] ?>">
                    <div class="card-body">
                        <input type="text" name="name_type" class="card-title form-control" id="" value='<?= $promoType['name'] ?>'>
                        <input type="hidden" name="id_asso" value="<?= $promoType['id_type'] ?>">
                        <input type="submit" name='update_type' class="btn btn-primary" value="Modifier">
                        <input type="submit" name='delete_type' class="btn btn-danger" value="Supprmer">
                    </div>
                </form>
                <br>
            <?php } ?>

        </div>





    <?php } else {
        echo 'affichage des campus et promos'; ?>
        <a href="campus.php?type" class="btn btn-primary">Gérer les types de promo</a>

        <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newCampusModal">
            Ajouter un campus
        </button>
        <div class="container">
            <?php foreach ($campuses as $campus) { ?>
                <form class="card" method="POST" id="<?= $campus['id_campus'] ?>">
                    <div class="card-body">
                        <input type="text" name="campus_name" class="card-title form-control" id="" value='<?= $campus[1] ?>'>
                        <input type="text" name="campus_label" class="card-title form-control" id="" value='<?= $campus[4] ?>'>
                        <input type="text" name="campus_postal_code" class="card-title form-control" id="update_postal_code" value='<?= $campus['postal_code'] ?>'>
                        <select name="campus_city" id="update_city" class="mb-3 form-select">
                            <option value="<?= $campus['city_name'] ?>"><?= $campus['city_name'] ?></option>
                        </select>
                        <input type="hidden" name="id_campus" value="<?= $campus['id_campus'] ?>">
                        <input type="hidden" name="id_address" value="<?= $campus['id_address'] ?>">
                        <input type="submit" name='update_campus' class="btn btn-primary" value="Modifier">
                        <input type="submit" name='delete_campus' class="btn btn-danger" value="Supprimer">

                        <form class="container" method="POST" action="#">
                            <div class="modal fade" id="newPromoModalForCampus<?= $campus['id_campus'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Nouvelle Promo</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Nom de la promo :</label>
                                                <input type="text" class="form-control" name="create_promo_name">
                                            </div>
                                            <input type="text" class="form-control" name="create_campus_id" value="<?= $campus['id_campus'] ?>">
                                            <label class="form-label">Type de la promo :</label>
                                            <select name="create_promo_type" id="create_promo_type" class="mb-3 form-select">
                                                <?php foreach ($promoTypes as $promoType) { ?>
                                                    <option value="<?= $promoType['id_type'] ?>"><?= $promoType['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary" name="create_promo">Créer</button>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </form>
                        <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newPromoModalForCampus<?= $campus['id_campus'] ?>">
                            Ajouter une promo
                        </button>




                    </div>
                </form>
                <div class="container">
                    <?php
                    foreach (getPromoByIDcampus($campus['id_campus']) as $promo) { ?>
                        <form class="card" method="POST" id="promo<?= $promo['id_promo'] ?>">
                            <div class="card-body">
                                <label for="promo_name">Nom de la promo :</label>
                                <input type="text" disabled name="promo_name" class="card-title form-control" id="" value='<?= $promo[1] ?>'>
                                <label for="promo_type">Type de la promo :</label>
                                <input type="text" disabled name="promo_name" class="card-title form-control" id="" value='<?= $promo['name'] ?>'>
                                <a href="campus.php?promo=<?= $promo['id_promo'] ?>&edit" class="btn btn-info">Modifier</a>
                            </div>
                        </form>
                    <?php } ?>
                </div>

                <br>
            <?php } ?>
        </div>
    <?php } ?>

</body>
<?php include '../includes/footer.php';?>
</html>