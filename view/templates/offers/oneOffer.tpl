
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
</div>


{if $smarty.session.id_role == 3}
    <a href="postulateActions.php?offer={$offer['id_offer']}&user={$smarty.session.id_user}" class="btn btn-primary">Postuler</a>
{/if}

<a href="companiesActions.php?id={$offer['id_company']}" class="btn btn-primary">Voir l'entreprise</a>

{if $smarty.session.id_user == $offer['id_user'] || $smarty.session.id_role == 1}
<a href="offerActions.php?id={$offer['id_offer']}&edit" class="btn btn-primary">Modifier</a>
{/if}