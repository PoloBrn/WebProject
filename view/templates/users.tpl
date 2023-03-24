<!DOCTYPE html>
<html lang="en">

<head>
    {include file='../../includes/head.php'}
</head>

<body>

    {include file='../../includes/scripts.php'}


    <!-- Modal -->

    <br><br>

    <div class="modal fade" id="newUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="container" method="POST" action="#">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nouvel utilisateur</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {if isset($errorMsg)}
                            <p> {$errorMsg} </p>
                        {/if}
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
                                {if $smarty.session.id_role == 1}
                                    <option value="2">Pilote</option>
                                <option value="3">Etudiant</option>';
                                {else}
                                <option value="3">Etudiant</option>';
                                {/if}
                            </select>
                        </div><br>
                        <div class="mb-3" id="promodiv">
                            <label for="" class="form-label">Promotion :</label>
                            <select name="promo" class="mb-3 form-select">
                                {foreach from=$campuses item=$campus}

                                    <optgroup label="{$campus[1]}">

                                        {if ($smarty.session.id_role == 1)}

                                            {foreach from=$campuses item=$onePromo}
                                                <option value="{$onepromo['id_promo']}">
                                                    {$onePromo[1]}
                                                </option>
                                            {/foreach}

                                        {else}
                                            {foreach from=$campuses item=$onePromo}
                                                <option value="{$onepromo['id_promo']}">
                                                    {$onePromo['name']}
                                                </option>
                                            {/foreach}
                                        {/if}

                                    </optgroup>

                                {/foreach}

                            </select>
                            {literal}
                                <script>
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
                                </script>
                            {/literal}
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
    <div class="container">
        {if isset($errorMsg) }
            <p> {$errorMsg} </p>
        {/if}
        {if $smarty.session.id_role != 3 }
            <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal"
                data-bs-target="#newUserModal">
                Ajouter un utilisateur
            </button>
            <br><br>

            <form method="get">
                <div class="form-group">
                    <input type='search' name="search" class="form-control"
                        value="{if isset($smarty.get.search)}{$smarty.get.search}{/if}">
                    <button class="btn btn-success">Rechercher</button>
                    <br>

                    {foreach from=$users item=$user}
                        <div class=" card" id="user {$user['id_user']}">
                            <div class="card-body">
                                <h5 class="card-title"><a class="nav-link" href="usersActions.php?id={$user['id_user']}">
                                        {$user['last_name'] }
                                        {$user['first_name'] }
                                    </a></h5>
                                <p class="card-text">Contact : <a href="mailto:{$user['email']}">
                                        {$user['email'] }
                                    </a></p>

                                {if (true || $smarty.session.role_id == 1)}
                                    <a href="usersActions.php?id={$user['id_user']}" class="btn btn-primary">Modifier</a>
                                {/if}
                            </div>
                        </div>
                        <br>
                    {/foreach}
                </div>
                <input type='number' name="userNumberByPage" class="form-control"
                    value="{if isset($smarty.get.userNumberByPage)}{$smarty.get.userNumberByPage}{else}{3}{/if}">
                <input type='number' name="page" class="form-control"
                    value="{if isset($smarty.get.page)}{$smarty.get.page}{else}{1}{/if}">
            </form>
        {/if}
    </div>

</body>
{include file='../../includes/footer.php'}

</html>