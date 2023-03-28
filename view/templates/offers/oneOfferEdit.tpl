<div class="modal fade" id="addWishlistModal" tabindex="-1" aria-hidden="true">
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
                        <select name="promo" id="promo" class="mb-3 form-select">
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
                    <select name="student" id="student" class="mb-3 form-select">
                    </select><br>
                    <script>
                        $(function() {
                            $('#promo').change(function(e) {
                                e.preventDefault();
                                getStudents($('#promo').val());
                            });
                        });

                        function getStudents(id_promo) {
                            let html = "";

                            let campuses = {json_encode($campuses)};
                            let onepromo;
                            campuses.forEach(campus => {
                                campus.promos.forEach(promo => {
                                    if (promo.id_promo == $('#promo').val()) {
                                        onepromo = promo;
                                    }
                                });
                            });

                            let students = onepromo.students;
                            students.forEach(student => {
                                html += "<option value='" + student.id_user + "'>" +
                                    student.first_name + " " + student.last_name + '</option>';
                            });
                            $('#student').html(html);
                        }
                        getStudents($('#promo').val());
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

<div class="modal fade" id="postModal" tabindex="-1" aria-hidden="true">
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
                        <select name="promo" id="promopost" class="mb-3 form-select">
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
                    <select name="student" id="studentpost" class="mb-3 form-select">
                    </select><br>
                    <script>
                        $(function() {
                            $('#promopost').change(function(e) {
                                e.preventDefault();
                                getStudentspost($('#promopost').val());
                            });
                        });

                        function getStudentspost(id_promo) {
                            let html = "";

                            let campuses = {json_encode($campuses)};
                            let onepromo;
                            campuses.forEach(campus => {
                                campus.promos.forEach(promo => {
                                    if (promo.id_promo == $('#promopost').val()) {
                                        onepromo = promo;
                                    }
                                });
                            });

                            let students = onepromo.students;
                            students.forEach(student => {
                                html += "<option value='" + student.id_user + "'>" +
                                    student.first_name + " " + student.last_name + '</option>';
                            });
                            $('#studentpost').html(html);
                        }
                        getStudentspost($('#promopost').val());
                    </script>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name="post">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="container" method="POST">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un type de promo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Type de prmo :</label>
                        <select name="promotype" class="mb-3 form-select">
                            {foreach from=$promotypes item=$promotype}
                                <option value="{$promotype['id_type']}">{$promotype['type_name']}
                                </option>
                            {/foreach}
                        </select><br>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name="addType">Ajouter</button>
                </div>

            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="addSkillModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="container" method="POST">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter une compétence</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Compétence :</label>
                        <select name="skill" class="mb-3 form-select">
                            {foreach from=$skills item=$skill}
                                <option value="{$skill['id_skill']}">{$skill['skill_name']}
                                </option>
                            {/foreach}
                        </select><br>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name="addSkill">Ajouter</button>
                </div>

            </form>

        </div>
    </div>
</div>

<form method="post" class="container">
    <a href="offerActions.php#{$offer['id_offer']}" class="btn btn-primary">back</a>
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" name="active[]" role="switch" id="flexSwitchCheckDefault"
            {if ($offer['offer_active'] == 'on')}checked{/if}>
        <label class="form-check-label" for="flexSwitchCheckDefault">Offre active</label>
    </div>
    <div class="mb-3">
        <label class="form-label">Nom de l'offre :</label>
        <input type="text" class="form-control" name="offer_name" value="{$offer['offer_name']}">
    </div>
    <div class="mb-3">
        <label class="form-label">Localité :</label>
        <select class="form-control" name="offer_locality" id="offer_locality">
            {foreach from=$offer['localities'] item=$locality}
            <option value="{$locality['id_locality']}">{$locality['label']} {$locality['postal_code']}
                {$locality['city_name']}</option>
            {/foreach}
        </select>
        <script>
            $('#offer_locality').val({$offer['id_locality']});
        </script>

    </div>
    <div class="mb-3">
        <label class="form-label">Secteur d'activité :</label>
        <select class="form-control" name="offer_activity" id="offer_activity">
            {foreach from=$offer['activities'] item=$activity}
                <option value="{$activity['id_activity']}">{$activity['activity_name']}</option>
            {/foreach}
        </select>
        <script>
            $('#offer_activity').val({$offer['id_activity']});
        </script>
    </div>
    <div class="mb-3">
        <label class="form-label">Date de début :</label>
        <input type="date" class="form-control" name="offer_start_date" value="{$offer['start_date']}">
    </div>
    <div class="mb-3">
        <label class="form-label">Date de fin :</label>
        <input type="date" class="form-control" name="offer_end_date" value="{$offer['end_date']}">
    </div>

    <div class="mb-3">
        <label class="form-label">Places disponibles :</label>
        <input type="number" class="form-control" name="offer_places" value="{$offer['places']}">
    </div>
    <div class="mb-3">
        <label class="form-label">Salaire horaire :</label>
        <input type="text" class="form-control" name="offer_salary" value="{$offer['salary']}">
    </div>
    <div class="mb-3">
        <label class="form-label">Description (optionnel) :</label>
        <textarea class="form-control" name="offer_description">{$offer['offer_description']}</textarea>
    </div>

    <a href="offerActions.php?id={$offer['id_offer']}" class="btn btn-secondary">Annuler</a>
    <button type="submit" class="btn btn-primary" name="update">Enregistrer</button>
    <button type="button" class="btn btn-danger" data-backdrop="static" data-bs-toggle="modal"
        data-bs-target="#deleteCompanyModal">
        Supprimer l'offre
    </button>
    <div class="modal fade" id="deleteCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Supprimer une offre</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align: center;">
                    <p>Souhaitez vous vraiment supprimer <b>{$offer['offer_name']}</b> ?</p>
                    <p>Supprimer cette offre entraînera la suppression de toutes ses données</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger" name="delete">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
    {if $smarty.session.id_role == 1}
    <button type="button" class="btn btn-danger" data-backdrop="static" data-bs-toggle="modal"
        data-bs-target="#addWishlistModal">
        Ajouter à une wishlist
    </button>
    <button type="button" class="btn btn-danger" data-backdrop="static" data-bs-toggle="modal"
        data-bs-target="#postModal">
        Créer une candidature
    </button>
    {/if}
    {if $smarty.session.id_role != 3}
    <a href="postulateActions.php?offer={$offer['id_offer']}" class="btn btn-secondary">Consulter les candidatures</a>
    {/if}
</form>
<div class="container">
    <h5>Type(s) de promo :</h5><br>
    <form class="container" method="post">
        <select name='id_type' id="address" class="form-control" size="
                            {if count($offer['promotypes']) < 2}
                                2
                            {elseif count($offer['promotypes']) > 8}
                                8
                            {else}
                                {count($offer['promotypes'])}
                            {/if}
                            ">
            {foreach from=$offer['promotypes'] item=$promotype}
            <option value="{$promotype['id_type']}">
                {$promotype['type_name']}
            </option>
            {/foreach}
        </select><br>
        <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal"
            data-bs-target="#addTypeModal">
            Ajouter un type de promo
        </button>
        <button type="submit" class="btn btn-danger" name="removeType">
            Supprimer un type de promo
        </button>
    </form>
</div>
<hr>
<br>
<div class="container">
    <h5>Compétence(s) :</h5><br>
    <form class="container" method="post">
        <select name='id_skill' class="form-control" size="
                            {if count($offer['skills']) < 2}
                                2
                            {elseif count($offer['skills']) > 8}
                                8
                            {else}
                                {count($offer['skills'])}
                            {/if}
                            ">
            {foreach from=$offer['skills'] item=$skill}
            <option value="{$skill['id_skill']}">{$skill['skill_name']}</option>
            {/foreach}
        </select>
        <br>
        <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal"
            data-bs-target="#addSkillModal">
            Ajouter une compétence
        </button>
        <button type="submit" class="btn btn-danger" name="removeSkill">
            Retirer une compétence
        </button>
    </form>
</div>