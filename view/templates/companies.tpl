<body>
    <div class="modal fade" id="newCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="container" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nouvelle entreprise</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nom de l'entreprise :</label>
                            <input type="text" class="form-control" name="company_name">
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Adresse e-mail de contact :</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nombre d'étudiants CESI déjà acceptés en
                                stage</label>
                            <input type="number" class="form-control" name="nb_student">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Logo :</label>
                            <input type="file" accept="image/png, image/gif, image/jpeg" multiple class="form-control"
                                name="logo">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" name="create">Créer</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <br><br>
    <form method="get" class="container">
        {if ($errorMsg != '')}
            <p class="errorMsg">{$errorMsg}</p>
        {/if}
        {if $smarty.session.id_role != 3}
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal"
                    data-bs-target="#newCompanyModal">
                    Ajouter une entreprise
                </button>
                <a href="activitiesActions.php" class="btn btn-primary">Gérer les secteurs d'activité</a>
                </div>
            {/if}
            <br><br>
            <input type='search' name="search" class="form-control" value="{$search}" placeholder="Rechercher">
            <button class="btn btn-success">Rechercher</button>
            <br>
                {foreach from=$companies item=$company}
                <div class="card flex-row card_company" id="{$company['id_company']}">
                    <img alt="logo" class="card-img-left example-card-img-responsive logo_company"
                        src="../assets/company-logos/{$company['logo']}" />
                    <div class="card-body">
                        <h5 class="card-title"><a class="nav-link" href="companiesActions.php?id={$company['id_company']}">
                    {if ($company['active'] != 'on')}[Non-active]
                    {/if} {$company['company_name']}</a>
                        </h5>
                        <p class="card-text">Contact : <a href="mailto:{$company['email']}">{$company['email']}</a></p>
                    {if $smarty.session.id_user == $company['id_user'] || $smarty.session.id_role == 1}
                            <a href="companiesActions.php?id={$company['id_company']}&edit" class="btn btn-primary">Modifier</a>
                    {/if}
                    </div>
                </div>
                <br>
                {/foreach}
            <input type='number' name="userNumberByPage" class="form-control"
                value=
                {if (isset($smarty.get.userNumberByPage))}{$smarty.get.userNumberByPage}
                {else}"4"{/if}>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item 
                {if ($page == 1)}{"disabled"}
                {/if}">
                        <a class="page-link" href="companiesActions.php?search={$search}&userNumberByPage={$nbByPage}&page=1">
                            <span aria-hidden="true">&laquo;&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item 
                {if ($page == 1)}{"disabled"}
                {/if}">
                        <a class="page-link"
                            href="companiesActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$page - 1}">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                {for $i = ($page - 2) to ($page + 2)}
                    {if ($i > 0 and $i <= $maxPage)}
                            <li class="page-item 
                        {if ($page == {$i})}{"active"}
                        {/if}"><a class="page-link"
                                    href="companiesActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$i}">{$i}</a>
                            </li>
                    {/if}
                {/for}
                    <li class="page-item 
                {if ($page == $maxPage)}{"disabled"}
                {/if}">
                        <a class="page-link"
                            href="companiesActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$page + 1}">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <li class="page-item 
                {if ($page == $maxPage)}{"disabled"}
                {/if}">
                        <a class="page-link"
                            href="companiesActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$maxPage}">
                            <span aria-hidden="true">&raquo;&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </form>
        <footer>
                {include file='../../includes/footer.php'}
    </footer>