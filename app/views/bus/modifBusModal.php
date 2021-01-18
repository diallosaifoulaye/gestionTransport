<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>bus/updateBus" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modification_Bus']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="matricule" class="control-label"><?php echo $this->lang['matricule']; ?></label>
                        <input type="text" id="matricule" name="matricule" value="<?= $bus->matricule ?>" class="form-control"
                               placeholder="bus" style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="couleur" class="control-label"><?php echo $this->lang['couleur']; ?></label>
                        <input type="text" id="couleur" name="couleur" value="<?= $bus->couleur ?>" class="form-control"
                               placeholder="bus" style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="places" class="control-label"><?php echo $this->lang['place']; ?></label>
                        <input type="text" id="places" name="places" value="<?= $bus->places ?>" class="form-control"
                               placeholder="bus" style="width: 100%">

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label">Liste des Types de categorie </label>

                        <select id="categorie" required name="categorie" class="form-control" style="width: 100%">
                            <option value=""> Selectionnez le type de categoire</option>

                            <?php foreach ($categorie as $oneTypep) { ?>
                                <option value="<?php echo $oneTypep->id; ?>"> <?php echo $oneTypep->libelle; ?></option>

                            <?php } ?>
                        </select>
<!--                        <input type="hidden" name="id" value=">--><?//= base64_encode($categorie->id) ?>

                    </div>

                    </div>
                <input type="hidden" name="id" value="<?= base64_encode($bus->id) ?>">

                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?></button>
    </div>
</form>


