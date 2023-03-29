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
<h1>Postuler {if $smarty.session.id_role == 1} en tant que {$user['first_name']} {$user['last_name']}{/if} :</h1>
        <div class="mb-3">
            <label for="cv" class="form-label">CV :</label>
            <input type="file" accept=".pdf" class="form-control" name="file[]">
        </div>
        <div class="mb-3">
            <label for="lm" class="form-label">Lettre de motivation :</label>
            <input type="file" accept=".pdf, .doc, .docx, .odt" class="form-control" name="file[]">
        </div>
        <div class="mb-3">
            <label for="infos" class="form-label">Informations complémentaires :</label>
            <textarea class="form-control" name="infos"></textarea>
        </div>
        <div class="mb-3">
            <a href="offerActions.php" class="btn btn-danger">Annuler</a>
            <button type="submit" class="btn btn-primary" name="create">Postuler</button>
        </div>
        
</div>
</form>
</div>