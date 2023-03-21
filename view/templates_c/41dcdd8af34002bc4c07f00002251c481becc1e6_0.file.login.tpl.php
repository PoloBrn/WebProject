<?php
/* Smarty version 4.3.0, created on 2023-03-21 12:01:10
  from 'C:\Users\damie\Desktop\repos2\WebProject\view\templates\login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_64198e7683b408_06484374',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '41dcdd8af34002bc4c07f00002251c481becc1e6' => 
    array (
      0 => 'C:\\Users\\damie\\Desktop\\repos2\\WebProject\\view\\templates\\login.tpl',
      1 => 1679396337,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../../includes/head.php' => 1,
  ),
),false)) {
function content_64198e7683b408_06484374 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php $_smarty_tpl->_subTemplateRender("file:../../includes/head.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</head>

<body>

    <br><br>
    <form class="container" method="POST">

        <?php if ((isset($_smarty_tpl->tpl_vars['errorMsg']->value))) {?>
            <?php echo $_smarty_tpl->tpl_vars['errorMsg']->value;?>

        <?php }?>

        <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" name="password">
        </div>

        <button type="submit" class="btn btn-primary" name="login">Se connecter</button>
    </form>
</body>

</html>
<?php }
}
