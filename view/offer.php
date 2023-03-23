<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require('../controller/securityAction.php');
require_once '../controller/offerActions.php';

?>

<!DOCTYPE html>
<html lang="en">
<?php require '../includes/head.php'; ?>

<body>
    <?php include '../includes/scripts.php'; ?>

    <?php include '../includes/navbar.php'; ?>

    <div class="modal fade" id="newSkillModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="container" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nouvelle compétence</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nom de la compétence :</label>
                            <input type="text" class="form-control" name="skill_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" name="skill_create">Créer</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['id'])) { ?>

    <?php } elseif (isset($_GET['skill'])) { ?>
        liste des skills
        <div class="container">
            <a href="offer.php" class="btn btn-primary">back</a>
            <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newSkillModal">
                Ajouter une compétece
            </button>
            <?php foreach ($allSkills as $skill) { ?>
                <form class="card" method="POST" id="skill<?= $skill['id_skill'] ?>">
                    <div class="card-body">
                        <input type="text" name="name_skill" class="card-title form-control" id="" value='<?= $skill['skill_name'] ?>'>
                        <input type="hidden" name="id_skill" value="<?= $skill['id_skill'] ?>">
                        <input type="submit" name='update_skill' class="btn btn-primary" value="Modifier">
                        <input type="submit" name='delete_skill' class="btn btn-danger" value="Supprimer">
                    </div>
                </form>
                <br>
            <?php } ?>
        </div>
    <?php
    } else { ?>
        <a href="offer.php?skill" class="btn btn-primary">Gérer les compétences</a>
    <?php } ?>



    <?php require '../includes/footer.php';?>
</body>

</html>