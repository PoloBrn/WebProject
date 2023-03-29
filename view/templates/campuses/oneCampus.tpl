<form class="container" method="POST" action="#">
    <div class="modal fade" id="newPromoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nouvelle Promo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nom de la promo :</label>
                        <input type="text" class="form-control" name="create_promo_name">
                    </div>
                    <input type="hidden" class="form-control" name="create_campus_id" value="{$campus['id_campus']}">
                    <label class="form-label">Type de la promo :</label>
                    <select name="create_promo_type" id="create_promo_type" class="mb-3 form-select">
                        {foreach from=$promoTypes item=$promoType}
                            <option value="{$promoType['id_type']}">{$promoType['type_name']}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name="create_promo">Créer</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="container">
    <form method="post">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nom du campus :</label>
            <input type="text" name="campus_name" class="card-title form-control" id=""
                value='{$campus['campus_name']}'>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Libellé :</label>
            <input type="text" name="campus_label" class="card-title form-control" id="" value='{$campus['label']}'>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Code Postal :</label>
            <input type="text" name="campus_postal_code" class="card-title form-control" id="update_postal_code"
                value='{$campus['postal_code']}'>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Ville :</label>
            <select name="campus_city" id="update_city" class="mb-3 form-select">
                <option value="{$campus['city_name']}">{$campus['city_name']}</option>
            </select>
        </div>
        <input type="hidden" name="id_campus" value="{$campus['id_campus']}">
        <input type="hidden" name="id_address" value="{$campus['id_address']}">
        <input type="submit" name='update_campus' class="btn btn-primary" value="Modifier">
        <button type="button" class="btn btn-danger" data-backdrop="static" data-bs-toggle="modal"
            data-bs-target="#deleteCampusModal">
            Supprimer le campus
        </button>
        <div class="modal fade" id="deleteCampusModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Supprimer le campus</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="text-align: center;">
                        <p>Souhaitez vous vraiment supprimer <b>{$campus['campus_name']}</b> ?</p>
                        <p>Supprimer ce campus entraînera la suppression de toutes ses données et ses promos</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger" name="delete_campus">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="get" class="container">
        <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal"
            data-bs-target="#newPromoModal">
            Ajouter une promo
        </button>
        <br><br>
        <input type="hidden" name="id" value="{$campus['id_campus']}">    
        <div class="search">    
        <button class="btn btn-success"><i class="fas fa-search"></i></button>
        <input type='search' name="search" class="form-control" value="{$search}" placeholder="Rechercher">*
        </div>
        <br>
        {foreach from=$promos item=$promo}
            <div class="card" id="promo{$promo['id_promo']}">
                <div class="card-body">
                    <h5 class="card-title">{$promo['promo_name']}</h5>
                    <a href="promosActions.php?id={$promo['id_promo']}" class="btn btn-info">Modifier</a>
                </div>
            </div>
            <br>
        {/foreach}

        <input type='number' name="userNumberByPage" class="form-control"
            value="{if (isset($smarty.get.userNumberByPage))}{$smarty.get.userNumberByPage}{else}{4}{/if}">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item 
                            {if ($page == 1)}{"disabled"}
                            {/if}">
                    <a class="page-link" href="campusAction.php?id={$campus['id_campus']}&search={$search}&userNumberByPage={$nbByPage}&page=
                            {1}">
                        <span aria-hidden="true">&laquo;&laquo;</span>
                    </a>
                </li>
                <li class="page-item 
                            {if ($page == 1)}{"disabled"}
                            {/if}">
                    <a class="page-link"
                        href="campusAction.php?id={$campus['id_campus']}&search={$search}&userNumberByPage={$nbByPage}&page={$page - 1}">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                {for $i = ($page - 2) to ($page + 2)}

                    {if ($i > 0 and $i <= $maxPage)}
                        <li class="page-item 
                                    {if ($page == {$i})}{"active"}
                                    {/if}"><a class="page-link"
                                href="campusAction.php?id={$campus['id_campus']}&search={$search}&userNumberByPage={$nbByPage}&page={$i}">{$i}</a>
                        </li>

                    {/if}

                {/for}
                <li class="page-item 
                            {if ($page == $maxPage)}{"disabled"}
                            {/if}">
                    <a class="page-link"
                        href="campusAction.php?id={$campus['id_campus']}&search={$search}&userNumberByPage={$nbByPage}&page={$page + 1}">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li class="page-item 
                            {if ($page == $maxPage)}{"disabled"}
                            {/if}">
                    <a class="page-link"
                        href="campusAction.php?id={$campus['id_campus']}&search={$search}&userNumberByPage={$nbByPage}&page={$maxPage}">
                        <span aria-hidden="true">&raquo;&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </form>
</div>

<script src="../assets/js/card.js"></script>