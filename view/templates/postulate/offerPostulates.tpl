

<div class="container">
    <a href="offerActions.php?id={$offer['id_offer']}" class="btn btn-primary">back</a>


{if count($users) > 0}
    {foreach from=$users item=$user}
        <div class=" card" id="user {$user['id_user']}">
            <div class="card-body">
                <h5 class="card-title">{$user['last_name'] } {$user['first_name'] }</h5>
                <p class="card-text">Contact : <a href="mailto:{$user['email']}">{$user['email'] }</a></p>
                <a href="postulateActions.php?user={$user['id_user']}&offer={$offer['id_offer']}" class="btn btn-primary">Modifier</a>
            </div>
        </div>
        <br>
    {/foreach}
{else}
    <h1>Il n'y a aucun utilisateur correspondante à votre recherche</h1>
{/if}

</div>