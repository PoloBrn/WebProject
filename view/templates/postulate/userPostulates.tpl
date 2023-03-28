<div class="container">
    <a href="usersActions.php?id={$user['id_user']}" class="btn btn-primary">back</a>


{if count($offers) > 0}
    {foreach from=$offers item=$offer}
        <form method="post" class="card flex-row card_company" style="height:135px;" id="{$offer['id_offer']}">
            <img alt="logo" class="card-img-left example-card-img-responsive logo_company"
                src="../assets/company-logos/{$offer['logo']}" />
            <div class="card-body">
                <h5 class="card-title"><a class="nav-link" href="offerActions.php?id={$offer['id_offer']}">

                        {if ($offer['offer_active'] != 'on')}[Non-active]{/if}
                        {$offer['offer_name']} - {$offer['company_name']} - {$offer['city_name']}</a>
                </h5>
            <p class="card-text">Secteur d'activité : {$offer['activity_name']}</p>

                <a href="postulateActions.php?user={$user['id_user']}&offer={$offer['id_offer']}"
                    class="btn btn-primary">Consulter</a>

            </div>
        </form>
        <br>
    {/foreach}
{else}
    <h1>Il n'y a aucune offre correspondante à votre recherche</h1>
{/if}

</div>