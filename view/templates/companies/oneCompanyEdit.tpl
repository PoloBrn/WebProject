<div class="modal fade" id="newaddrModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="container" method="POST">
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

<div class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="container" method="POST">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un secteur d'activité</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Secteur d'activité :</label>
                        <select name="activity" class="mb-3 form-select">
                            {foreach from=$activities item=$activity}
                                <option value="{$activity['id_activity']}">{$activity['activity_name']}
                                </option>
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

<a href="companiesActions.php#{$company['id_company']}" class="btn btn-primary">back</a>
<div class="container">
    {if ($errorMsg != '')}
        <p class="errorMsg">{$errorMsg}</p>
    {/if}
    <h5>Informations :</h5>
    <form class="container" method="POST" enctype="multipart/form-data">
        <div class="form-check form-switch">
<input class="form-check-input" type="checkbox" name="active[]" role="switch" id="flexSwitchCheckDefault" {if ($company['active'] == 'on')}checked{/if}>
            <label class="form-check-label" for="flexSwitchCheckDefault">Entreprise active</label>
        </div>
        <div class="mb-3">
            <label class="form-label">Nom de l'entreprise :</label>
            <input type="text" class="form-control" name="company_name" value="{$company['company_name']}">
        </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Adresse e-mail de contact :</label>
            <input type="email" class="form-control" name="email" value="{$company['email']}">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nombre d'étudiants CESI déjà acceptés en stage :
            </label>
            <input type="number" class="form-control" name="nb_student" value="{$company['nb_student']}">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Logo :</label>
            <input type="file" accept="image/png, image/gif, image/jpeg" multiple class="form-control" name="logo">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Description :</label>
            <textarea class='form-control' name="description">{$company['company_description']}</textarea>
        </div>

        <a href="companiesActions.php?id={$company['id_company']}" class="btn btn-secondary">Annuler</a>
        <button type="submit" class="btn btn-primary" name="update">Enregistrer</button>
        <button type="button" class="btn btn-danger" data-backdrop="static" data-bs-toggle="modal"
            data-bs-target="#deleteCompanyModal">
            Supprimer l'entreprise
        </button>
        <div class="modal fade" id="deleteCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Supprimer une entreprise</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="text-align: center;">
                        <p>Souhaitez vous vraiment supprimer <b>{$company['company_name']}</b> ?</p>
                        <p>Supprimer cette entreprise entraînera la suppression de toutes ses données</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger" name="delete">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
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
                            {elseif count($addresses) > 8}
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
        <button type="button" class="btn btn-info companyType" data-backdrop="static" data-bs-toggle="modal"
            data-bs-target="#newaddrModal">
            Ajouter une adresse
        </button>
        <br>

        <button type="submit" class="btn btn-danger companyType" name="deleteAddress">
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
                                {count($company_activities)}
                            {/if}
                            ">
            {foreach from=$company_activities item=$activity}
            <option value="{$activity['id_activity']}">
                {$activity['activity_name']}
            </option>
            {/foreach}
        </select>
        <br>
        <button type="button" class="btn btn-info companyType" data-backdrop="static" data-bs-toggle="modal"
            data-bs-target="#addActivityModal">
            Ajouter un secteur d'activité
        </button>
        <br>
        <button type="submit" class="btn btn-danger companyType" name="remove_activity">
            Retirer un secteur d'activité
        </button>
    </form>
</div>


<style>
.companyType {
    margin-top: 20px;
    position: relative;
    width: 50%;
    left: 25%;
    transition: all 1s ease-in-out !important;
}

</style>