<?php
/* Smarty version 4.3.0, created on 2023-03-25 17:47:41
  from 'C:\Users\damie\Desktop\repos2\WebProject\view\templates\companies.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_641f25ad31ec75_44168583',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd340b63c48d30312c35a7e87a778f9b7ba43d6c0' => 
    array (
      0 => 'C:\\Users\\damie\\Desktop\\repos2\\WebProject\\view\\templates\\companies.tpl',
      1 => 1679762856,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../../includes/footer.php' => 1,
  ),
),false)) {
function content_641f25ad31ec75_44168583 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>

    <?php if ((isset($_smarty_tpl->tpl_vars['errorMsg']->value))) {?>
        <p class="errorMsg"><?php echo $_smarty_tpl->tpl_vars['errorMsg']->value;?>
</p>
    <?php }?>

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
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['allActivities']->value, 'oneactivity');
$_smarty_tpl->tpl_vars['oneactivity']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['oneactivity']->value) {
$_smarty_tpl->tpl_vars['oneactivity']->do_else = false;
?>
                                    <option value="<?php echo '<?'; ?>
= $oneactivity['id_activity']; <?php echo '?>'; ?>
"><?php echo $_smarty_tpl->tpl_vars['oneactivity']->value['activity_name'];?>
</option>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
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

    <?php if ((isset($_GET['activity'])) && !($_SESSION['id_role'] == 3)) {?>
        <p>modifier les secteurs d&#8217;activité<p>

        <div class="container">
            <a href="companiesActions.php" class="btn btn-primary">back</a>
            <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newActivityModal">
                Ajouter un secteur d'activité
            </button>
            <br><br>

            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['allActivities']->value, 'oneActivity');
$_smarty_tpl->tpl_vars['oneActivity']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['oneActivity']->value) {
$_smarty_tpl->tpl_vars['oneActivity']->do_else = false;
?>
                <form class="card" method="POST" id="activity<?php echo $_smarty_tpl->tpl_vars['oneActivity']->value['id_activity'];?>
">
                    <div class="card-body">
                        <input type="text" name="name_activity" class="card-title form-control" id="" value='<?php echo $_smarty_tpl->tpl_vars['oneActivity']->value['activity_name'];?>
'>
                        <input type="hidden" name="id_activity" value="<?php echo $_smarty_tpl->tpl_vars['oneActivity']->value['id_activity'];?>
">
                        <input type="submit" name='update_activity' class="btn btn-primary" value="Modifier">
                        <input type="submit" name='delete_activity' class="btn btn-danger" value="Supprimer">
                    </div>
                </form>
                <br>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
S
        </div>
        <?php } else { ?>

            <?php if ((isset($_GET['id']))) {?>
                <?php if (count($_smarty_tpl->tpl_vars['company']->value) != 0) {?>
                
                <a href="companiesActions.php#company<?php echo $_GET['id'];?>
" class="btn btn-primary">back</a>

                <?php if (((isset($_GET['edit'])) && $_SESSION['id_user'] == $_smarty_tpl->tpl_vars['company']->value['id_user']) || $_SESSION['id_role'] == 1) {?>
                    
                    <div class="container">
                        <h5>Informations :</h5>
                        <form class="container" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nom de l'entreprise :</label>
                                <input type="text" class="form-control" name="company_name" value="<?php echo $_smarty_tpl->tpl_vars['company']->value['company_name'];?>
">
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Adresse e-mail de contact :</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $_smarty_tpl->tpl_vars['company']->value['email'];?>
">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Nombre d'étudiants CESI déjà acceptés en stage : </label>
                                <input type="number" class="form-control" name="nb_student" value="<?php echo $_smarty_tpl->tpl_vars['company']->value['nb_student'];?>
">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Logo :</label>
                                <input type="file" accept="image/png, image/gif, image/jpeg" multiple class="form-control" name="logo">
                            </div>

                            <a href="companiesActions.php?id=<?php echo $_smarty_tpl->tpl_vars['company']->value['id_company'];?>
" class="btn btn-secondary">Annuler</a>
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
                            <?php if (count($_smarty_tpl->tpl_vars['addresses']->value) < 2) {?>
                                2
                            <?php } elseif (count($_smarty_tpl->tpl_vars['addresses']->value)) {?>
                                8
                            <?php } else { ?>
                                <?php echo count($_smarty_tpl->tpl_vars['addresses']->value);?>

                            <?php }?>
                            ">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['addresses']->value, 'address');
$_smarty_tpl->tpl_vars['address']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['address']->value) {
$_smarty_tpl->tpl_vars['address']->do_else = false;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['address']->value['id_address'];?>
">
                                        <?php echo $_smarty_tpl->tpl_vars['address']->value['label'];?>
 <?php echo $_smarty_tpl->tpl_vars['address']->value['postal_code'];?>
 <?php echo $_smarty_tpl->tpl_vars['address']->value['city_name'];?>

                                    </option>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
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
                        <h5>Secteur(s) d&#8217activité :</h5><br>
                        <form class="container" method="post">
                            <select name='id_activity' class="form-control" size="
                            <?php if (count($_smarty_tpl->tpl_vars['company_activities']->value) < 2) {?>
                                2
                            <?php } elseif (count($_smarty_tpl->tpl_vars['company_activities']->value) > 8) {?>
                                8
                            <?php } else { ?>
                                echo count($company_activities);
                            <?php }?>
                            ">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['company_activities']->value, 'acti');
$_smarty_tpl->tpl_vars['acti']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['acti']->value) {
$_smarty_tpl->tpl_vars['acti']->do_else = false;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['acti']->value['id_activity'];?>
">
                                        <?php echo $_smarty_tpl->tpl_vars['acti']->value['activity_name'];?>

                                    </option>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
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
                <?php }?>


            <?php } else { ?>
                <h1>Entreprise Inexistante</h1>
            <?php }?>
        <?php } else { ?>
            <!-- Modal -->

            <br><br>
            <div class="container" id="">

                <?php if ((isset($_smarty_tpl->tpl_vars['errorMsg']->value))) {?>
                    <p class="errorMsg"><?php echo '<?'; ?>
= $errorMsg <?php echo '?>'; ?>
</p>
                <?php }?>
                <?php if ($_SESSION['id_role'] != 3) {?>
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newCompanyModal">
                            Ajouter une entreprise
                        </button>
                        <a href="companiesActions.php?activity" class="btn btn-primary">Gérer les secteurs d'activité</a>
                    </div>
                <?php }?>
                <br><br>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['allCompanies']->value, 'company');
$_smarty_tpl->tpl_vars['company']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['company']->value) {
$_smarty_tpl->tpl_vars['company']->do_else = false;
?>
                    <div class="card flex-row card_company" id="company<?php echo '<?'; ?>
= $company['id_company'] <?php echo '?>'; ?>
">
                        <img alt="logo" class="card-img-left example-card-img-responsive logo_company" src="../assets/company-logos/<?php echo $_smarty_tpl->tpl_vars['company']->value['logo'];?>
" />
                        <div class="card-body">
                            <h5 class="card-title"><a class="nav-link" href="companiesActions.php?id=<?php echo $_smarty_tpl->tpl_vars['company']->value['id_company'];?>
"><<?php echo $_smarty_tpl->tpl_vars['company']->value['company_name'];?>
</a></h5>
                            <p class="card-text">Contact : <a href="mailto:<?php echo $_smarty_tpl->tpl_vars['company']->value['email'];?>
"><?php echo $_smarty_tpl->tpl_vars['company']->value['email'];?>
</a></p>
                            <?php if ($_SESSION['id_user'] == $_smarty_tpl->tpl_vars['company']->value['id_user'] || $_SESSION['id_role'] == 1) {?>
                                <a href="companiesActions.php?id=<?php echo $_smarty_tpl->tpl_vars['company']->value['id_company'];?>
&edit" class="btn btn-primary">Modifier</a>
                            <?php }?>
                        </div>
                    </div>
                    <br>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </div>

        <?php }?>
    <?php }?>

<footer>
<?php $_smarty_tpl->_subTemplateRender('file:../../includes/footer.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</footer><?php }
}
