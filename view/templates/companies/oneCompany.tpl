<a href="companiesActions.php#{$company['id_company']}" class="btn btn-primary">back</a>
<p> tkt ca arrive </p>
{if $smarty.session.id_user == $company['id_user'] || $smarty.session.id_role == 1}
    <a href="companiesActions.php?id={$company['id_company']}&edit" class="btn btn-primary">Modifier</a>
{/if}