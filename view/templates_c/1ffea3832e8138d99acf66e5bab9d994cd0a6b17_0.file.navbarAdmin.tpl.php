<?php
/* Smarty version 4.3.0, created on 2023-03-28 12:56:29
  from 'C:\Users\damie\Desktop\repos2\WebProject\includes\navbar\navbarAdmin.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6422c7dd3d1f32_85594512',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1ffea3832e8138d99acf66e5bab9d994cd0a6b17' => 
    array (
      0 => 'C:\\Users\\damie\\Desktop\\repos2\\WebProject\\includes\\navbar\\navbarAdmin.tpl',
      1 => 1679999442,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6422c7dd3d1f32_85594512 (Smarty_Internal_Template $_smarty_tpl) {
?>
<link rel="stylesheet" href="../assets/CSS/navbar.css">

<nav class="navbar-custom navbar navbar-expand-lg navbar-dark sticky-top">
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
                            <a class="nav-link active" href="../controller/offerActions.php">Gestion des offres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../controller/companiesActions.php">Gestion des entreprises</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../controller/usersActions.php">Gestion des utilisateurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../controller/campusAction.php">Gestion des campus</a>
                        </li>
                        
                <li class="nav-item">
                    <a class="nav-link active" href="../controller/logoutAction.php">Se déconnecter</a>
                </li>
            </ul>
        </div>
    </div>
</nav><?php }
}
