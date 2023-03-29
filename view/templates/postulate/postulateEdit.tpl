<a href="offerActions.php#{$offer['id_offer']}" class="btn btn-primary">back</a>
<img alt="logo" class="card-img-left example-card-img-responsive logo_company"
    src="../assets/company-logos/{$offer['logo']}" />
<div class="container">
    <h1>{$offer['company_name']}</h1>
    <h4>Description de l'entreprise :</h4>
    <p>{$offer['company_description']}</p>
    <h4>Description de l'offre :</h4>
    <p>{$offer['offer_description']}</p>
    <h4>Secteur d'activité : {$offer['activity_name']}</h4>
    {if $offer['nb_student'] > 1}
    <p>{$offer['nb_student']} étudiants on déjà été acceptés dans cette entreprise</p>
    {else}
    <p>{$offer['nb_student']} étudiant a déjà été accepté dans cette entreprise</p>
    {/if}
    <h4>Lieu : {$offer['label']} {$offer['postal_code']} {$offer['city_name']}</h4>

    <p>Contact : <a href="mailto:{$offer['email']}">{$offer['email'] }</a></p>

    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="offer_id" value="{$offer['id_offer']}">
        <input type="hidden" name="user_id" value="{$user['id_user']}">
        <h1>Etat de la candidature {if $smarty.session.id_role == 1} de {$user['first_name']} {$user['last_name']}{/if} :
        </h1>
        <div class="mb-3">
            <label for="cv" class="form-label">CV :</label>
            <label for="cv" class="form-label"><a href="../assets/users/cv/{$postulate['cv']}" target="_blank" rel="noopener noreferrer">CV</a></label>
        </div>
        <div class="mb-3">
            <label for="lm" class="form-label">Lettre de motivation :</label>
            <label for="lm" class="form-label"><a href="../assets/users/lm/{$postulate['lm']}" target="_blank" rel="noopener noreferrer">Lettre de motivation</a></label>
        </div>
        <div class="mb-3">
            <label for="lm" class="form-label">Informations complémentaires :</label>
            <p>{$postulate['infos']}</p>
        </div>
        <div class="mb-3">
            <label for="progress" class="form-label">Etat de la candidature :</label>
            <textarea class="form-control" name="progress">{$postulate['progress']}</textarea>
        </div>
        <div class="mb-3">
            <a href="offerActions.php" class="btn btn-danger">Annuler</a>
            <button type="submit" class="btn btn-primary" name="update">Enregistrer</button>
        </div>
</div>
</form>
</div>