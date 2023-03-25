<!DOCTYPE html>
<html lang="en">

<body>

{if $smarty.session.id_role != 3 }
    <a href="usersActions.php#user{$smarty.get.id}" class="btn btn-primary">back</a>
{/if}

{if isset($oneUser)}
    {if count($oneUser) != 0 }
        {$oneUser = $oneUser[0]}
        <br>
        <form class="container" method="POST" action="#">
            {if isset($errorMsg)}
                <p> {$errorMsg} </p>
            {/if}
            <h5 class="color-white">Informations :</h5>
            <div class="container">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Prénom :</label>
                    <input type="text" class="form-control" name="first_name" value="{$oneUser["first_name"]}">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nom :</label>
                    <input type="text" class="form-control" name="last_name" value="{$oneUser["last_name"]}">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Adresse e-mail :</label>
                    <input type="email" class="form-control" name="email" value="{$oneUser["email"]}">
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
                    <input type="text" class="form-control" name="label" id="label" value="{$oneUser["label"]}">

                </div>
                <div class="mb-3">
                    <label class="form-label">Code postal :</label>
                    <input type="number" class="form-control" name="postal_code" id="postal_code"
                        value={$oneUser["postal_code"]}>
                </div>
                <label class="form-label">Ville :</label>
                <select name="city" id="city" class="mb-3 form-select">
                    <option value="{$oneUser["city_name"]}">{$oneUser["city_name"]}</option>
                </select>
                <input type="hidden" name="address_id" value="{$oneUser["id_address"]}">
                <button type="submit" class="btn btn-primary" name="update">Enregistrer</button>

                {if $smarty.session.id_user != $smarty.get.id}
                    <button type="button" class="btn btn-danger" data-backdrop="static" data-bs-toggle="modal"
                    data-bs-target="#deleteUserModal">
                    Supprimer l'utilisateur
                    </button>
                {/if}
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
    {else}
        <h1>Utilisateur Inexistant</h1>
    {/if}

{/if}


</body>

{include file='../../includes/footer.php'}

</html>