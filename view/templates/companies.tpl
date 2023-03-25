<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>

    {if isset($errorMsg)}
        <p class="errorMsg">{$errorMsg}</p>
    {/if}

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
                                {foreach from=$allActivities item=$oneactivity}
                                    <option value="<?= $oneactivity['id_activity']; ?>">{$oneactivity['activity_name']}</option>
                                {/foreach}
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

    {if isset($smarty.get.activity) && !($smarty.session.id_role == 3)}
        <p>modifier les secteurs d&#8217;activité<p>

        <div class="container">
            <a href="companiesActions.php" class="btn btn-primary">back</a>
            <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newActivityModal">
                Ajouter un secteur d'activité
            </button>
            <br><br>

            {foreach from=$allActivities item=$oneActivity}
                <form class="card" method="POST" id="activity{$oneActivity['id_activity']}">
                    <div class="card-body">
                        <input type="text" name="name_activity" class="card-title form-control" id="" value='{$oneActivity['activity_name']}'>
                        <input type="hidden" name="id_activity" value="{$oneActivity['id_activity']}">
                        <input type="submit" name='update_activity' class="btn btn-primary" value="Modifier">
                        <input type="submit" name='delete_activity' class="btn btn-danger" value="Supprimer">
                    </div>
                </form>
                <br>
            {/foreach}
S
        </div>
        {else}

            {if isset($smarty.get.id)}
                {if count($company) != 0}
                
                <a href="companiesActions.php#company{$smarty.get.id}" class="btn btn-primary">back</a>

                {if (isset($smarty.get.edit) && $smarty.session.id_user == $company['id_user']) || $smarty.session.id_role == 1}
                    
                    <div class="container">
                        <h5>Informations :</h5>
                        <form class="container" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nom de l'entreprise :</label>
                                <input type="text" class="form-control" name="company_name" value="{$company['company_name']}">
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Adresse e-mail de contact :</label>
                                <input type="email" class="form-control" name="email" value="{$company['email']}">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Nombre d'étudiants CESI déjà acceptés en stage : </label>
                                <input type="number" class="form-control" name="nb_student" value="{$company['nb_student']}">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Logo :</label>
                                <input type="file" accept="image/png, image/gif, image/jpeg" multiple class="form-control" name="logo">
                            </div>

                            <a href="companiesActions.php?id={$company['id_company']}" class="btn btn-secondary">Annuler</a>
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
                            {if count($addresses) < 2}
                                2
                            {elseif count($addresses)}
                                8
                            {else}
                                {count($addresses)}
                            {/if}
                            ">
                            {foreach from=$addresses item=$address}
                                    <option value="{$address['id_address']}">
                                        {$address['label']} {$address['postal_code']} {$address['city_name']}
                                    </option>
                            {/foreach}
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
                            {if count($company_activities) < 2}
                                2
                            {elseif count($company_activities) > 8}
                                8
                            {else}
                                echo count($company_activities);
                            {/if}
                            ">
                                {foreach from=$company_activities item=$acti}
                                    <option value="{$acti['id_activity']}">
                                        {$acti['activity_name']}
                                    </option>
                                {/foreach}
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
                {/if}


            {else}
                <h1>Entreprise Inexistante</h1>
            {/if}
        {else}
            <!-- Modal -->

            <br><br>
            <div class="container" id="">

                {if isset($errorMsg)}
                    <p class="errorMsg"><?= $errorMsg ?></p>
                {/if}
                {if $smarty.session.id_role != 3}
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal" data-bs-target="#newCompanyModal">
                            Ajouter une entreprise
                        </button>
                        <a href="companiesActions.php?activity" class="btn btn-primary">Gérer les secteurs d'activité</a>
                    </div>
                {/if}
                <br><br>
                {foreach from=$allCompanies item=$company}
                    <div class="card flex-row card_company" id="company<?= $company['id_company'] ?>">
                        <img alt="logo" class="card-img-left example-card-img-responsive logo_company" src="../assets/company-logos/{$company['logo']}" />
                        <div class="card-body">
                            <h5 class="card-title"><a class="nav-link" href="companiesActions.php?id={$company['id_company']}"><{$company['company_name']}</a></h5>
                            <p class="card-text">Contact : <a href="mailto:{$company['email']}">{$company['email']}</a></p>
                            {if $smarty.session.id_user == $company['id_user'] || $smarty.session.id_role == 1}
                                <a href="companiesActions.php?id={$company['id_company']}&edit" class="btn btn-primary">Modifier</a>
                            {/if}
                        </div>
                    </div>
                    <br>
                {/foreach}
            </div>

        {/if}
    {/if}

<footer>
{include file='../../includes/footer.php'}
</footer>