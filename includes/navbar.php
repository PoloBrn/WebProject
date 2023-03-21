<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <!--<img src="assets/images/logo_ligne.png" alt="Logo" height="50"  class="d-inline-block align-text-middle">-->
            INTERNCHIPS
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php


                switch ($_SESSION['id_role']) {
                    case 1: ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Gestion des offres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="companies.php">Gestion des entreprises</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="users.php">Gestion des utilisateurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="campus.php">Gestion des campus</a>
                        </li>
                    <?php break;

                    case 2: ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Gestion des offres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="companies.php">Gestion des entreprises</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="users.php">Gestion des étudiants</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="users.php?id=<?= $_SESSION['id_user']?>">Mon profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">A propos</a>
                        </li>
                    <?php break;

                    case 3: ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Les offres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="companies.php">Les entreprises</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="users.php?id=<?= $_SESSION['id_user']?>">Mon profil</a>
                        </li>
                <?php break;
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link active" href="../controller/logoutAction.php">Se déconnecter</a>
                </li>
            </ul>
        </div>
    </div>
</nav>