<a href="companiesActions.php#{$company['id_company']}" class="btn btn-primary">back</a>
<img alt="logo" class="card-img-left example-card-img-responsive logo_company"
    src="../assets/company-logos/{$company['logo']}" />
<div class="container">
    <h1>{$company['company_name']}</h1>
    <p>{$company['company_description']}</p>
    <h4>Secteur(s) d'activité :</h4>
    <ul>
        {foreach from=$company_activities item=$activity}
        <li>{$activity['activity_name']}</li>
        {/foreach}
    </ul>
    {if $company['nb_student'] > 1}
    <p>{$company['nb_student']} étudiants on déjà été acceptés dans cette entreprise</p>
    {else}
    <p>{$company['nb_student']} étudiant a déjà été accepté dans cette entreprise</p>
    {/if}
    <h4>Localité(s) :</h4>
    <ul>
        {foreach from=$addresses item=$address}
        <li>{$address['label']} {$address['postal_code']} {$address['city_name']}</li>
        {/foreach}
    </ul>
    <p>Contact : <a href="mailto:{$company['email']}">{$company['email'] }</a></p>
</div>






{if $smarty.session.id_user == $company['id_user'] || $smarty.session.id_role == 1}
<a href="companiesActions.php?id={$company['id_company']}&edit" class="btn btn-primary">Modifier</a>
{/if}