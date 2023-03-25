<?php
/* Smarty version 4.3.0, created on 2023-03-24 16:00:20
  from 'C:\Users\damie\Desktop\repos2\WebProject\view\templates\users.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_641dbb0458eb35_28049572',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0644a0a72e7dd353151222495fe0111819f1e371' => 
    array (
      0 => 'C:\\Users\\damie\\Desktop\\repos2\\WebProject\\view\\templates\\users.tpl',
      1 => 1679654796,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../../includes/head.php' => 1,
    'file:../../includes/scripts.php' => 1,
    'file:../../includes/footer.php' => 1,
  ),
),false)) {
function content_641dbb0458eb35_28049572 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">

<head>
    <?php $_smarty_tpl->_subTemplateRender('file:../../includes/head.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</head>

<body>

    <?php $_smarty_tpl->_subTemplateRender('file:../../includes/scripts.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


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
                            <?php if ((isset($_smarty_tpl->tpl_vars['errorMsg']->value))) {?>
                                <p> <?php echo $_smarty_tpl->tpl_vars['errorMsg']->value;?>
 </p>
                            <?php }?>
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
                                    <?php if ($_SESSION['id_role'] == 1) {?>
                                        <option value="2">Pilote</option>
                                    <option value="3">Etudiant</option>';
                                    <?php } else { ?>
                                    <option value="3">Etudiant</option>';
                                    <?php }?>
                                </select>
                            </div><br>
                            <div class="mb-3" id="promodiv">
                                <label for="" class="form-label">Promotion :</label>
                                <select name="promo" class="mb-3 form-select">
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['campuses']->value, 'campus');
$_smarty_tpl->tpl_vars['campus']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['campus']->value) {
$_smarty_tpl->tpl_vars['campus']->do_else = false;
?>

                                        <optgroup label="<?php echo $_smarty_tpl->tpl_vars['campus']->value[1];?>
">

                                            <?php if (($_SESSION['id_role'] == 1)) {?>
                                                
                                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['campuses']->value, 'onePromo');
$_smarty_tpl->tpl_vars['onePromo']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['onePromo']->value) {
$_smarty_tpl->tpl_vars['onePromo']->do_else = false;
?>
                                                    <option value="<?php echo $_smarty_tpl->tpl_vars['onepromo']->value['id_promo'];?>
">
                                                        <?php echo $_smarty_tpl->tpl_vars['onePromo']->value[1];?>

                                                    </option>
                                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

                                            <?php } else { ?>
                                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['campuses']->value, 'onePromo');
$_smarty_tpl->tpl_vars['onePromo']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['onePromo']->value) {
$_smarty_tpl->tpl_vars['onePromo']->do_else = false;
?>
                                                    <option value="<?php echo $_smarty_tpl->tpl_vars['onepromo']->value['id_promo'];?>
">
                                                        <?php echo $_smarty_tpl->tpl_vars['onePromo']->value['name'];?>

                                                    </option>
                                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                            <?php }?>

                                        </optgroup>

                                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

                                </select>
                                
                                    <?php echo '<script'; ?>
>
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
                                    <?php echo '</script'; ?>
>
                                
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

        <?php if ((isset($_smarty_tpl->tpl_vars['errorMsg']->value))) {?>
            <p> <?php echo $_smarty_tpl->tpl_vars['errorMsg']->value;?>
 </p>
        <?php }?>
        <?php if ($_SESSION['id_role'] != 3) {?>
            <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal"
                data-bs-target="#newUserModal">
                Ajouter un utilisateur
            </button>
            <br><br>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['users']->value, 'user');
$_smarty_tpl->tpl_vars['user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['user']->value) {
$_smarty_tpl->tpl_vars['user']->do_else = false;
?>
                
                <div class="card" id="user <?php echo $_smarty_tpl->tpl_vars['user']->value['id_user'];?>
">
                    <div class="card-body">
                        <h5 class="card-title"><a class="nav-link" href="usersActions.php?id=<?php echo $_smarty_tpl->tpl_vars['user']->value['id_user'];?>
">
                                <?php echo $_smarty_tpl->tpl_vars['user']->value['last_name'];?>

                                <?php echo $_smarty_tpl->tpl_vars['user']->value['first_name'];?>

                            </a></h5>
                        <p class="card-text">Contact : <a href="mailto:<?php echo $_smarty_tpl->tpl_vars['user']->value['email'];?>
">
                                <?php echo $_smarty_tpl->tpl_vars['user']->value['email'];?>

                            </a></p>
                        <?php if ((true || $_SESSION['role_id'] == 1)) {?>
                            <a href="usersActions.php?id=<?php echo $_smarty_tpl->tpl_vars['user']->value['id_user'];?>
" class="btn btn-primary">Modifier</a>
                        <?php }?>
                    </div>
                </div>
                <br>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        <?php }?>
    </div>

</body>
<?php $_smarty_tpl->_subTemplateRender('file:../../includes/footer.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</html><?php }
}
