<body>
    <div class="modal fade" id="newOfferModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="container" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Nouvelle offre</h1>
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
                                companies.forEach(company => {
                                    if (company.id_company == id_company) {
                                        onecompany = company;
                                    }

                                });
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
    {foreach from=$offers item=$offer}
        <div class="modal fade" id="addWishlistModal{$offer['id_offer']}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="container" method="POST" action="#">
                        <input type="hidden" name="offer_id" value="{$offer['id_offer']}">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Ajouter à une wishlist</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3" id="promodiv">
                                <label for="" class="form-label">Promotion :</label>
                                <select name="promo" id="promo{$offer['id_offer']}" class="mb-3 form-select">
                                    {foreach from=$campuses item=$campus}
                                        <optgroup label="{$campus['campus_name']}">
                                            {foreach from=$campus['promos'] item=$promo}
                                                <option value="{$promo['id_promo']}">
                                                    {$promo['promo_name']}
                                                </option>
                                            {/foreach}
                                        </optgroup>
                                    {/foreach}
                                </select>
                            </div>
                            <label class="form-label">Etudiant :</label>
                            <select name="student" id="student{$offer['id_offer']}" class="mb-3 form-select">
                            </select><br>
                            <script>
                                $(function() {
                                $('#promo{$offer['id_offer']}').change(function(e) {
                                e.preventDefault();
                                getStudents{$offer['id_offer']}($('#promo{$offer['id_offer']}').val());
                                });
                                });

                                function getStudents{$offer['id_offer']}(id_promo) {
                                let html = "";

                                let campuses = {json_encode($campuses)};
                                let onepromo;
                                campuses.forEach(campus => {
                                    campus.promos.forEach(promo => {
                                            if (promo.id_promo == $('#promo{$offer['id_offer']}').val()) {
                                            onepromo = promo;
                                        }
                                    });
                                });

                                let students = onepromo.students;
                                students.forEach(student => {
                                    html += "<option value='" + student.id_user + "'>" +
                                        student.first_name + " " + student.last_name + '</option>';
                                });
                                console.log(html);
                                $('#student{$offer['id_offer']}').html(html);
                                }
                                getStudents{$offer['id_offer']}($('#promo{$offer['id_offer']}').val());
                            </script>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary" name="addWishlist">Créer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    {/foreach}



    <form method="get" class="container">
        {if ($errorMsg != '')}
            <p class="errorMsg">{$errorMsg}</p>
        {/if}
        {if $smarty.session.id_role != 3 && $wishlist == 0}
            <div style="gap: 10px; justify-content: center;">
                <button type="button" class="btn btn-info offersType" data-backdrop="static" data-bs-toggle="modal"
                    data-bs-target="#newOfferModal">
                    Ajouter une offre
                </button>
                <a href="skillsActions.php" class="btn btn-primary offersType">Gérer les compétences</a>
            </div>    
            <style>
                .offersType {
                    margin-top: 20px;
                    position: relative;
                    width: 50%;
                    left: 25%;
                    transition: all 1s ease-in-out !important;
                }

            </style>
        {/if}        
        <br>

        <div class="search">    
        <button class="btn btn-success"><i class="fas fa-search"></i></button>
        <input type='search' name="search" class="form-control" value="{$search}" placeholder="Rechercher">
        
        </div>
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
            <input type='number' name="userNumberByPage" class="form-control"
                value={if (isset($smarty.get.userNumberByPage))}{$smarty.get.userNumberByPage} {else}"4"{/if}>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item 
                {if ($page == 1)}{"disabled"}
                {/if}">
                        <a class="page-link"
                            href="offerActions.php?search={$search}&userNumberByPage={$nbByPage}&page=1&skill={$skill}&type={$type}&wishlist={$wishlist}">
                            <span aria-hidden="true">&laquo;&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item 
                {if ($page == 1)}{"disabled"}
                {/if}">
                        <a class="page-link"
                            href="offerActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$page - 1}&skill={$skill}&type={$type}&wishlist={$wishlist}">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    {for $i = ($page - 2) to ($page + 2)}
                        {if ($i > 0 and $i <= $maxPage)}
                            <li class="page-item 
                        {if ($page == {$i})}{"active"}
                        {/if}"><a class="page-link"
                                    href="offerActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$i}&skill={$skill}&type={$type}&wishlist={$wishlist}">{$i}</a>
                            </li>
                        {/if}
                    {/for}
                    <li class="page-item 
                {if ($page == $maxPage)}{"disabled"}
                {/if}">
                        <a class="page-link"
                            href="offerActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$page + 1}&skill={$skill}&type={$type}&wishlist={$wishlist}">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <li class="page-item 
                {if ($page == $maxPage)}{"disabled"}
                {/if}">
                        <a class="page-link"
                            href="offerActions.php?search={$search}&userNumberByPage={$nbByPage}&page={$maxPage}&skill={$skill}&type={$type}&wishlist={$wishlist}">
                            <span aria-hidden="true">&raquo;&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </form>
        {foreach from=$offers item=$offer}
            <form method="post" class="card flex-row card_company" id="{$offer['id_offer']}">
                <img alt="logo" class="card-img-left example-card-img-responsive logo_company"
                    src="../assets/company-logos/{$offer['logo']}" />
                <div class="card-body">
                    <h5 class="card-title"><a class="nav-link" href="offerActions.php?id={$offer['id_offer']}">

                            {if ($offer['offer_active'] != 'on')}[Non-active]{/if}
                            {$offer['offer_name']} - {$offer['company_name']} - {$offer['city_name']}</a>
                    </h5>
                    <input type="hidden" name="student" value="{$smarty.session.id_user}">
                    <input type="hidden" name="offer_id" value="{$offer['id_offer']}">
                    <p class="card-text">Secteur d'activité : {$offer['activity_name']}</p>
            {if ($smarty.session.id_user == $offer['id_user'] || $smarty.session.id_role == 1) && $wishlist == 0}
            <a href="offerActions.php?id={$offer['id_company']}&edit" class="btn btn-primary">Modifier</a>
            {/if}
            {if $smarty.session.id_role == 3 and !in_array($smarty.session.id_user, array_column($offer['wishes'], 'id_user'))}
            <button type="submit" class="btn btn-outline-danger" name="addWishlist">Ajouter à la wishlist</button>
            {/if}
            {if ($smarty.session.id_role == 3 and in_array($smarty.session.id_user, array_column($offer['wishes'], 'id_user'))) || ($smarty.session.id_role == 1 && $wishlist != 0)}
            <button type="submit" class="btn btn-danger" name="removeWishlist">Retirer de la wishlist</button>
            {/if}
            {if $smarty.session.id_role == 1 && $wishlist ==0}
            <button type="button" class="btn btn-danger" data-backdrop="static" data-bs-toggle="modal"
                data-bs-target="#addWishlistModal{$offer['id_offer']}">
                Ajouter à une wishlist
            </button>
            {/if}
        </div>
    </form>
    <br>

    {/foreach}

    {else}
    <h1>Il n'y a aucune offre correspondante à votre recherche</h1>
        {/if}




        <script src="../assets/js/card.js"></script>

    </body>