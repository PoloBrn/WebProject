<div class="modal fade" id="newCampusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="container" method="POST" action="#">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nouveau campus</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nom du campus :</label>
                        <input type="text" class="form-control" name="create_campus_name">
                    </div>
                    <h5>Adresse :</h5>
                    <div class="mb-3">
                        <label class="form-label">Libellé :</label>
                        <input type="text" class="form-control" name="label" id="label">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Code postal :</label>
                        <input type="number" class="form-control" name="postal_code" id="postal_code">
                    </div>
                    <label class="form-label">Ville :</label>
                    <select name="city" id="city" class="mb-3 form-select">
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name="create_campus">Créer</button>
                </div>

            </form>

        </div>
    </div>
</div>


<form method="get" class="container">
    <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal"
        data-bs-target="#newCampusModal">
        Ajouter un campus
    </button>
    <a href="promoTypeActions.php" class="btn btn-primary promoType">Gérer les types de promo</a>
    <style>
        .promoType {
            margin-top: 20px;
            position: relative;
            width: 50%;
            left: 25%;
            transition: all 1s ease-in-out !important;
        }

        .promoType:hover {
            
            width: 60%;
            left: 20%;
        }

    </style>
    <br><br>
    
    <div class="search">    
    <button class="btn btn-success"><i class="fas fa-search"></i></button>
    <input type='search' name="search" class="form-control" value="{$search}" placeholder="Rechercher">*
    </div>
    {foreach from=$campuses item=$campus}
        <div class="card" method="POST" id="{$campus['id_campus']}">
            <div class="card-body">
                <h5 class="card-title">{$campus['campus_name']}</h5>
                <a href="campusAction.php?id={$campus['id_campus']}" class="btn btn-primary">Modifier</a>
            </div>
        </div>
        <br>
    {/foreach}
    <br>
    <input type='number' name="userNumberByPage" class="form-control"
        value="{if (isset($smarty.get.userNumberByPage))}{$smarty.get.userNumberByPage}{else}{4}{/if}">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item 
                            {if ($page == 1)}{"disabled"}
                            {/if}">
                <a class="page-link" href="campusAction.php?search={$search}&userNumberByPage={$nbByPage}&page=
                            {1}">
                    <span aria-hidden="true">&laquo;&laquo;</span>
                </a>
            </li>
            <li class="page-item 
                            {if ($page == 1)}{"disabled"}
                            {/if}">
                <a class="page-link"
                    href="campusAction.php?search={$search}&userNumberByPage={$nbByPage}&page={$page - 1}">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            {for $i = ($page - 2) to ($page + 2)}

                {if ($i > 0 and $i <= $maxPage)}
                    <li class="page-item 
                                    {if ($page == {$i})}{"active"}
                                    {/if}"><a class="page-link"
                            href="campusAction.php?search={$search}&userNumberByPage={$nbByPage}&page={$i}">{$i}</a>
                    </li>

                {/if}

            {/for}
            <li class="page-item 
                            {if ($page == $maxPage)}{"disabled"}
                            {/if}">
                <a class="page-link"
                    href="campusAction.php?search={$search}&userNumberByPage={$nbByPage}&page={$page + 1}">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <li class="page-item 
                            {if ($page == $maxPage)}{"disabled"}
                            {/if}">
                <a class="page-link"
                    href="campusAction.php?search={$search}&userNumberByPage={$nbByPage}&page={$maxPage}">
                    <span aria-hidden="true">&raquo;&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

    <script src="../assets/js/card.js"></script>
</form>