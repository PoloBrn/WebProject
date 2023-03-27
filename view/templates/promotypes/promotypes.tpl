<div class="modal fade" id="newTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="container" method="POST" action="#">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nouveau type de promo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nom :</label>
                        <input type="text" class="form-control" name="create_type_name">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name="create_type">Créer</button>
                </div>

            </form>

        </div>
    </div>
</div>

<div class="container">
    <a href="campusAction.php" class="btn btn-primary">back</a>
    <button type="button" class="btn btn-info" data-backdrop="static" data-bs-toggle="modal"
        data-bs-target="#newTypeModal">
        Ajouter un type de promo
    </button>
    <br>
    {if $errorMsg != ''}
        <p>{$errorMsg}</p>
    {/if}
    <br>
    {foreach from=$promoTypes item=$promoType}
        <form class="card" method="POST" id="{$promoType['id_type']}">
            <div class="card-body">
                <input type="text" name="name_type" class="card-title form-control" id="" value='{$promoType['type_name']}'>
                <input type="hidden" name="id_asso" value="{$promoType['id_type']}">
                <input type="submit" name='update_type' class="btn btn-primary" value="Modifier">
                <input type="submit" name='delete_type' class="btn btn-danger" value="Supprimer">
            </div>
        </form>
        <br>
    {/foreach}

</div>

<script src="../assets/js/card.js"></script>