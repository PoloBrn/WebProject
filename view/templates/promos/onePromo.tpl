<div class="modal fade" id="newPilotModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="container" method="POST" action="#">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nouveau pilote</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilote :</label>
                        <select name="new_pilot" id="new_pilot" class="mb-3 form-select">
                            {foreach from=$pilots item=$pilot}
                                <option value="{$pilot['id_user']}">{$pilot['first_name']} {$pilot['last_name']}</option>
                            {/foreach}
                        </select>
                    </div><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name="addPilot">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="newStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="container" method="POST" action="#">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nouveal Etudiant</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Etudiant :</label>
                        <select name="new_student" id="new_student" class="mb-3 form-select">
                            {foreach from=$students item=$student}
                                <option value="{$student['id_user']}">{$student['first_name']} {$student['last_name']}
                                </option>
                            {/foreach}
                        </select>
                    </div><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name="addStudent">Ajouter</button>
                </div>

            </form>
        </div>
    </div>
</div>

<a href="campusActions.php#promo{$promo['id_promo']}" class="btn btn-primary">back</a>
<form class="container" method="POST">
    <h5>Informations :</h5>
    <div class="mb-3">
        <label class="form-label">Nom de la promotion :</label>
        <input type="text" class="form-control" name="update_promo_name" value="{$promo['promo_name']}">
    </div>
    <input type="hidden" name="promo_id" value="{$promo['id_promo']}">
    <input type="hidden" name="campus_id" value="{$promo['id_campus']}">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Type de la promotion :</label>
        <select name="update_promo_type" id="update_promo_type" class="mb-3 form-select">
            {foreach from=$promoTypes item=$promoType}
                <option value="{$promoType['id_type']}">{$promoType['type_name']}</option>
            {/foreach}
        </select>
        <script>
            $('#update_promo_type').val({$promo['id_type']});
        </script>
    </div>
    <a href="campusActions.php#promo={$promo['id_promo']}" class="btn btn-secondary">Annuler</a>
    <button type="submit" class="btn btn-primary" name="update">Enregistrer</button>
    <button type="submit" class="btn btn-danger" name="delete">Supprimer</button>
</form>
<hr>
<br>
<form class="container" method="post">
    <h5>Pilote(s) :</h5>
    <br>
    <select name='user' id="tutor" class="form-control"
        size="{if (count($promo['pilots']) < 2)}2{elseif (count($promo['pilots'])> 8)}8{else}{count($promo['pilots'])}{/if}">
        {foreach from=$promo['pilots'] item=$pilot}
            <option value="{$pilot['id_user']}">{$pilot['first_name']} {$pilot['last_name']}</option>
        {/foreach}
    </select>
    <br>
    <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal"
        data-bs-target="#newPilotModal">
        Ajouter un pilote
    </button>
    <button type="submit" class="btn btn-danger" name="deletePilotStudent">
        Enlever un pilote
    </button>
</form>
<hr>
<br>
<form class="container" method="post">
    <h5>Etudiant(s) :</h5>
    <br>
    <select name='user' id="tutor" class="form-control"
        size="{if (count($promo['students']) < 2)}2{elseif (count($promo['students'])> 8)}8{else}{count($promo['students'])}{/if}">
        {foreach from=$promo['students'] item=$student}
            <option value="{$student['id_user']}">{$student['first_name']} {$student['last_name']}</option>
        {/foreach}
    </select>
    <br>
    <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal"
        data-bs-target="#newStudentModal">
        Ajouter un étudiant
    </button>
    <button type="submit" class="btn btn-danger" name="deletePilotStudent">
        Enlever un étudiant
    </button>
</form>