{foreach from=$company['feedbacks'] item=$feedback}


    <form method="post" class="modal fade" id="deleteFeedbackModal{$feedback['id_user']}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Supprimer une évaluation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align: center;">
                    <p>Souhaitez vous vraiment supprimer l'évaluation ?</p>
                <p>Supprimer l'évaluation entraînera la suppression de toutes ses données</p>
                </div>
                <input type="hidden" name="id_user" value="{$feedback['id_user']}">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger" name="deleteFeedback">Supprimer</button>
                </div>
            </div>
        </div>
    </form>
{/foreach}

<div class="modal fade" id="editFeedbackModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="container" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier l'évaluation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Note :</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rate" id="radio1" value="1">
                            <label class="form-check-label" for="radio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rate" id="radio2" value="2">
                            <label class="form-check-label" for="radio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" checked type="radio" name="rate" id="radio3" value="3">
                            <label class="form-check-label" for="radio3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rate" id="radio4" value="4">
                            <label class="form-check-label" for="radio4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rate" id="radio5" value="5">
                            <label class="form-check-label" for="radio5">5</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Commentaire :</label>
                        <textarea class="form-control" name="comment" id="comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name="editFeedback">Modifier</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="newFeedbackModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="container" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Evaluer l'entreprise</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Note :</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rate" id="radio1" value="1">
                            <label class="form-check-label" for="radio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rate" id="radio2" value="2">
                            <label class="form-check-label" for="radio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" checked type="radio" name="rate" id="radio3" value="3">
                            <label class="form-check-label" for="radio3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rate" id="radio4" value="4">
                            <label class="form-check-label" for="radio4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rate" id="radio5" value="5">
                            <label class="form-check-label" for="radio5">5</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Commentaire :</label>
                        <textarea class="form-control" name="comment" id="comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name="addFeedback">Créer</button>
                </div>

            </form>
        </div>
    </div>
</div>





<a href="companiesActions.php#{$company['id_company']}" class="btn btn-primary">back</a>

<div class="container companyCard">
<img alt="logo" class="card-img-left example-card-img-responsive logo_company"
    src="../assets/company-logos/{$company['logo']}" width="200px" />
<div class="container">
    <h1>{$company['company_name']}</h1>
    <p>{$company['company_description']}</p>
    <h4>Secteur(s) d'activité :</h4>
    <ul>
        {foreach from=$company_activities item=$activity}
        <li>{$activity['activity_name']}</li>
        {/foreach}
    </ul>
    {if $company['nb_student'] > 1}
    <p>{$company['nb_student']} étudiants on déjà été acceptés dans cette entreprise</p>
    {else}
    <p>{$company['nb_student']} étudiant a déjà été accepté dans cette entreprise</p>
    {/if}
    <h4>Localité(s) :</h4>
    <ul>
        {foreach from=$addresses item=$address}
        <li>{$address['label']} {$address['postal_code']} {$address['city_name']}</li>
        {/foreach}
    </ul>
    <p>Contact : <a href="mailto:{$company['email']}">{$company['email'] }</a></p>
</div>
</div>
<button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal"
    data-bs-target="#newFeedbackModal" style="margin-bottom: 20px">
    Evaluer l'entreprise
</button>

<div class="container">
    {foreach from=$company['feedbacks'] item=$feedback}
        <form method="post" class="card flex-row" id="{$feedback['id_user']}">
            <div class="card-body">
                <input type="hidden" name="id_user" value="{$feedback['id_user']}" />
                <h5 class="card-title">De {$feedback['first_name']} {$feedback['last_name']}</h5>
                <p class="card-text">Note de {$feedback['rate']}/5</p>
                <p class="card-text">Commentaire : {$feedback['comment']}</p>

                {if $smarty.session.id_user == $feedback['id_user']}
                    <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal"
                        data-bs-target="#editFeedbackModal" style="margin-bottom: 20px">
                        Modifier
                    </button>

                {/if}
                {if $smarty.session.id_user == $feedback['id_user'] || $smarty.session.id_role == 1}
                    <br>
                    <button type="button" class="btn btn-danger" data-backdrop="static" data-bs-toggle="modal"
                        data-bs-target="#deleteFeedbackModal{$feedback['id_user']}">
                        Supprimer
                    </button>

                {/if}


            </div>
        </form>


    {/foreach}
</div>



{if $smarty.session.id_user == $company['id_user'] || $smarty.session.id_role == 1}
    <a href="companiesActions.php?id={$company['id_company']}&edit" class="btn btn-primary">Modifier</a>
{/if}

<style>

.companyCard{
    background: rgba( 255, 255, 255, 0.05 );
    box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
    backdrop-filter: blur( 7.5px );
    -webkit-backdrop-filter: blur( 7.5px );
    border-radius: 10px;
    border: 1px solid rgba( 255, 255, 255, 0.18 );

    width: 40%;
    color: white;
}
</style>


<script src="../assets/js/card.js"></script>
