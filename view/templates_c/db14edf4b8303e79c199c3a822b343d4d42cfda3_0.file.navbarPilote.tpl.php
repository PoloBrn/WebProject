<?php
/* Smarty version 4.3.0, created on 2023-03-26 15:12:35
  from 'C:\Users\damie\Desktop\repos2\WebProject\includes\navbar\navbarPilote.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_642044c36868d2_03984902',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'db14edf4b8303e79c199c3a822b343d4d42cfda3' => 
    array (
      0 => 'C:\\Users\\damie\\Desktop\\repos2\\WebProject\\includes\\navbar\\navbarPilote.tpl',
      1 => 1679762917,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642044c36868d2_03984902 (Smarty_Internal_Template $_smarty_tpl) {
?><nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
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
                            <a class="nav-link active" href="../view/companiesActions.php">Gestion des entreprises</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../controller/usersActions.php">Gestion des étudiants</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../controller/usersActions.php?id=<?php echo $_SESSION['id_user'];?>
">Mon profil</a>
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
</nav><?php }
}
