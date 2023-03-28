<div class="modal fade" id="newActivityModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="container" method="POST" action="">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nouveau secteur d'activité</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nom :</label>
                        <input type="text" class="form-control" name="create_activity_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name="create_activity">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<p>

<form method="get" class="container">
    <a href="companiesActions.php" class="btn btn-primary">back</a>
    <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal"
        data-bs-target="#newActivityModal">
        Ajouter un secteur d'activité
    </button>
    <br><br>   <div class="search">    
    <button class="btn btn-success"><i class="fas fa-search"></i></button>
    <input type='search' name="search" class="form-control" value="{$search}" placeholder="Rechercher">*
    </div>
    <br>

    
<div class="container">
{foreach from=$activities item=$activity}
    <form class="card" method="POST" id="{$activity['id_activity']}">
        <div class="card-body">
            <input type="text" name="name_activity" class="card-title form-control" id=""
                value='{$activity['activity_name']}'>
            <input type="hidden" name="id_activity" value="{$activity['id_activity']}">
            <input type="submit" name='update_activity' class="btn btn-primary" value="Modifier">
            <input type="submit" name='delete_activity' class="btn btn-danger" value="Supprimer">
        </div>
    </form>
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
                <a class="page-link" href="activitiesActions.php?search={$search}&userNumberByPage={$nbByPage}&page=
                            {1}">
                    <span aria-hidden="true">&laquo;&laquo;</span>
                </a>
            </li>
            <li class="page-item 
                            {if ($page == 1)}{"disabled"}
                            {/if}">
                <a class="page-link"
                    href="activitiesActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$page - 1}">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            {for $i = ($page - 2) to ($page + 2)}

                {if ($i > 0 and $i <= $maxPage)}
                    <li class="page-item 
                                    {if ($page == {$i})}{"active"}
                                    {/if}"><a class="page-link"
                            href="activitiesActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$i}">{$i}</a>
                    </li>

                {/if}

            {/for}
            <li class="page-item 
                            {if ($page == $maxPage)}{"disabled"}
                            {/if}">
                <a class="page-link"
                    href="activitiesActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$page + 1}">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <li class="page-item 
                            {if ($page == $maxPage)}{"disabled"}
                            {/if}">
                <a class="page-link"
                    href="activitiesActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$maxPage}">
                    <span aria-hidden="true">&raquo;&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
    </div>
</form>



<script src="../assets/js/card.js"></script>