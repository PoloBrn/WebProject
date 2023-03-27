<link rel="stylesheet" href="../assets/CSS/navbar.css">

<nav class="navbar-custom navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="../view/index.php">
            <!--<img src="assets/images/logo_ligne.png" alt="Logo" height="50"  class="d-inline-block align-text-middle">-->
            INTERNCHIPS
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link active" href="#">Gestion des offres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../controller/companiesActions.php">Gestion des entreprises</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../controller/usersActions.php">Gestion des étudiants</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../controller/usersActions.php?id={$smarty.session.id_user}">Mon profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">A propos</a>
                        </li>
                        
                <li class="nav-item">
                    <a class="nav-link active" href="../controller/logoutAction.php">Se déconnecter</a>
                </li>
            </ul>
        </div>
    </div>
</nav>