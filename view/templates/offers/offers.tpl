<body>
    <div class="modal fade" id="newOfferModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="container" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nouvelle offre</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nom de l'offre :</label>
                            <input type="text" class="form-control" name="offer_name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Entreprise :</label>
                            <select class="form-control" name="offer_company" id="offer_company">
                                {foreach from=$companies item=$company}
                                <option value='{$company['id_company']}'>{$company['company_name']}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Localité :</label>
                            <select class="form-control" name="offer_locality" id="offer_locality">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Secteur d'activité :</label>
                            <select class="form-control" name="offer_activity" id="offer_activity">
                            </select>
                        </div>
                        <script>
                            $(function() {
                                $('#offer_company').change(function(e) {
                                    e.preventDefault();
                                    test($('#offer_company').val());
                                });
                            });

                            function test(id_company) {
                                let html_localities = "";
                                let html_activities = "";
                                let onecompany;
                                let companies = {json_encode($companies)};
                                console.log('companies');
                                console.log(companies);
                                companies.forEach(company => {
                                    if (company.id_company == id_company) {
                                        onecompany = company;
                                    }

                                });
                                console.log('onecompany');
                                console.log(onecompany);
                                let localities = onecompany.localities;
                                localities.forEach(locality => {
                                    html_localities += "<option value='" + locality.id_locality + "'>" +
                                        locality.label + " " + locality.postal_code + " " + locality
                                        .city_name + '</option>';
                                });

                                $('#offer_locality').html(html_localities);
                                let activities = onecompany.activities;
                                activities.forEach(activity => {
                                    html_activities += "<option value='" + activity.id_activity + "'>" +
                                        activity.activity_name + '</option>';
                                });

                                $('#offer_activity').html(html_activities);
                            }
                            test($('#offer_company').val());
                        </script>
                        <div class="mb-3">
                            <label class="form-label">Date de début :</label>
                            <input type="date" class="form-control" name="offer_start_date">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date de fin :</label>
                            <input type="date" class="form-control" name="offer_end_date">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Places disponibles :</label>
                            <input type="number" class="form-control" name="offer_places">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Salaire horaire :</label>
                            <input type="text" class="form-control" name="offer_salary">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description (optionnel) :</label>
                            <textarea class="form-control" name="offer_description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" name="offer_create">Créer</button>
                    </div>

                </form>
            </div>
        </div>
    </div>





    <form method="get" class="container">
        {if ($errorMsg != '')}
            <p class="errorMsg">{$errorMsg}</p>
        {/if}
        {if $smarty.session.id_role != 3}
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal"
                    data-bs-target="#newOfferModal">
                    Ajouter une offre
                </button>
                <a href="skillsActions.php" class="btn btn-primary">Gérer les compétences</a>
            </div>
        {/if}
        <br><br>
        <input type='search' name="search" class="form-control" value="{$search}" placeholder="Rechercher">
        <button class="btn btn-success">Rechercher</button>
        <br>
        <label for="exampleInputEmail1" class="form-label">Compétence :</label>
        <select name="skill" id="skill" class="mb-3 form-select">
            <option value="0">(peu importe)</option>
            {foreach from=$skills item=$oneskill}
                <option value="{$oneskill['id_skill']}">{$oneskill['skill_name']}</option>
            {/foreach}
        </select>
        <script>
            $('#skill').val({$skill});
        </script>
        <label for="exampleInputEmail1" class="form-label">Types de promo :</label>
        <select name="type" id="type" class="mb-3 form-select">
            <option value="0">(peu importe)</option>
            {foreach from=$types item=$promotype}
                <option value="{$promotype['id_type']}">{$promotype['type_name']}</option>
            {/foreach}
        </select>
        <script>
            $('#type').val({$type});
        </script>
        {if count($offers) > 0}
            {foreach from=$offers item=$offer}
                <div class="card flex-row card_company" style="height:135px;" id="{$offer['id_offer']}">
                    <img alt="logo" class="card-img-left example-card-img-responsive logo_company"
                        src="../assets/company-logos/{$offer['logo']}" />
                    <div class="card-body">
                        <h5 class="card-title"><a class="nav-link" href="offerActions.php?id={$offer['id_offer']}">

                                {if ($offer['offer_active'] != 'on')}[Non-active]{/if}
                                {$offer['offer_name']} - {$offer['company_name']} - {$offer['city_name']}</a>
                        </h5>
                        <p class="card-text">Secteur d'activité : {$offer['activity_name']}</p>
                {if $smarty.session.id_user == $offer['id_user'] || $smarty.session.id_role == 1}
                <a href="offerActions.php?id={$offer['id_company']}&edit" class="btn btn-primary">Modifier</a>

                {/if}
            </div>
        </div>
        <br>
        {/foreach}
        <input type='number' name="userNumberByPage" class="form-control"
            value={if (isset($smarty.get.userNumberByPage))}{$smarty.get.userNumberByPage} {else}"4"{/if}>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item 
                {if ($page == 1)}{"disabled"}
                {/if}">
                    <a class="page-link"
                        href="offerActions.php?search={$search}&userNumberByPage={$nbByPage}&page=1&skill={$skill}&type={$type}">
                        <span aria-hidden="true">&laquo;&laquo;</span>
                    </a>
                </li>
                <li class="page-item 
                {if ($page == 1)}{"disabled"}
                {/if}">
                    <a class="page-link"
                        href="offerActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$page - 1}&skill={$skill}&type={$type}">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                {for $i = ($page - 2) to ($page + 2)}
                {if ($i > 0 and $i <= $maxPage)}
                <li class="page-item 
                        {if ($page == {$i})}{"active"}
                        {/if}"><a class="page-link"
                        href="offerActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$i}&skill={$skill}&type={$type}">{$i}</a>
                </li>
                {/if}
                {/for}
                <li class="page-item 
                {if ($page == $maxPage)}{"disabled"}
                {/if}">
                    <a class="page-link"
                        href="offerActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$page + 1}&skill={$skill}&type={$type}">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li class="page-item 
                {if ($page == $maxPage)}{"disabled"}
                {/if}">
                    <a class="page-link"
                        href="offerActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$maxPage}&skill={$skill}&type={$type}">
                        <span aria-hidden="true">&raquo;&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </form>
    {else}
    <h1>Il n'y a aucune offre correspondante à votre recherche</h1>
        {/if}




        <script src="../assets/js/card.js"></script>

    </body>