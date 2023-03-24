<?php
/* Smarty version 4.3.0, created on 2023-03-24 10:25:22
  from 'C:\Users\damie\Desktop\repos2\WebProject\view\templates\oneUser.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_641d6c82a06553_47324842',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '544db33db0c33cd0c451d109959dae7be40c6e5c' => 
    array (
      0 => 'C:\\Users\\damie\\Desktop\\repos2\\WebProject\\view\\templates\\oneUser.tpl',
      1 => 1679649808,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../../includes/footer.php' => 1,
  ),
),false)) {
function content_641d6c82a06553_47324842 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>


<?php if ($_SESSION['id_role'] != 3) {?>
    <a href="usersActions.php#user<?php echo $_GET['id'];?>
" class="btn btn-primary">back</a>
<?php }?>

<?php if ((isset($_smarty_tpl->tpl_vars['oneUser']->value))) {?>
    <?php if (count($_smarty_tpl->tpl_vars['oneUser']->value) != 0) {?>
        <?php $_smarty_tpl->_assignInScope('oneUser', $_smarty_tpl->tpl_vars['oneUser']->value[0]);?>
        <br>
        <form class="container" method="POST" action="#">
            <?php if ((isset($_smarty_tpl->tpl_vars['errorMsg']->value))) {?>
                <p> <?php echo $_smarty_tpl->tpl_vars['errorMsg']->value;?>
 </p>
            <?php }?>
            <h5 class="color-white">Informations :</h5>
            <div class="container">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Prénom :</label>
                    <input type="text" class="form-control" name="first_name" value="<?php echo $_smarty_tpl->tpl_vars['oneUser']->value["first_name"];?>
">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nom :</label>
                    <input type="text" class="form-control" name="last_name" value="<?php echo $_smarty_tpl->tpl_vars['oneUser']->value["last_name"];?>
">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Adresse e-mail :</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $_smarty_tpl->tpl_vars['oneUser']->value["email"];?>
">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Changer le mot de passe :</label>
                    <input type="password" class="form-control" name="first_password">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Répéter le mot de passe :</label>
                    <input type="password" class="form-control" name="second_password">
                </div>
            </div>
            <br>
            <hr>
            <h5 class="color-white">Adresse :</h5>
            <div class="container">
                <div class="mb-3">
                    <label class="form-label">Libellé :</label>
                    <input type="text" class="form-control" name="label" id="label" value="test">

                </div>
                <div class="mb-3">
                    <label class="form-label">Code postal :</label>
                    <input type="number" class="form-control" name="postal_code" id="postal_code"
                        value=<?php echo $_smarty_tpl->tpl_vars['oneUser']->value["postal_code"];?>
>
                </div>
                <label class="form-label">Ville :</label>
                <select name="city" id="city" class="mb-3 form-select">
                    <option value="<?php echo $_smarty_tpl->tpl_vars['oneUser']->value["city_name"];?>
">"<?php echo $_smarty_tpl->tpl_vars['oneUser']->value["city_name"];?>
"</option>
                </select>
                <input type="hidden" name="address_id" value="<?php echo $_smarty_tpl->tpl_vars['oneUser']->value["id_address"];?>
">
                <button type="submit" class="btn btn-primary" name="update">Enregistrer</button>

                <?php if ($_SESSION['id_user'] != $_GET['id']) {?>
                    <button type="button" class="btn btn-danger" data-backdrop="static" data-bs-toggle="modal"
                    data-bs-target="#deleteUserModal">
                    Supprimer l'utilisateur
                    </button>
                <?php }?>
                <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Supprimer un utilisateur</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="text-align: center;">
                                <p>Souhaitez vous vraiment supprimer un utilisateur ?</p>
                                <p>Supprimer un utilisateur entraînera la suppression de toutes ses données</p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-danger" name="delete">Supprimer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php } else { ?>
        <h1>Utilisateur Inexistant</h1>
    <?php }?>

<?php }?>


</body>

<?php $_smarty_tpl->_subTemplateRender('file:../../includes/footer.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</html><?php }
}
