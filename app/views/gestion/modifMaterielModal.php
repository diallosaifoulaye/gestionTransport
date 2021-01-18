<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>gestion/updateMateriel" method="post">
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
                        <label for="marque" class="control-label"><?php echo $this->lang['nom']; ?></label>
                        <input type="text" id="nom" name="nom" value="<?= $materiel->nom ?>" class="form-control"
                               placeholder="<?php echo $this->lang['marque']; ?>" style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="marque" class="control-label"><?php echo $this->lang['numIdentification']; ?></label>
                        <input type="text" id="uuid" name="uuid" value="<?= $materiel->uuid ?>" class="form-control"
                               placeholder="<?php echo $this->lang['numIdentification']; ?>" style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="marque" class="control-label"><?php echo $this->lang['marque']; ?></label>
                        <input type="text" id="manufacture" name="manufacture" value="<?= $materiel->manufacture ?>" class="form-control"
                               placeholder="<?php echo $this->lang['marque']; ?>" style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="marque" class="control-label"><?php echo $this->lang['descript']; ?></label>
                        <input type="text" id="model" name="model" value="<?= $materiel->model ?>" class="form-control"
                               placeholder="<?php echo $this->lang['descript']; ?>" style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="marque" class="control-label"><?php echo $this->lang['platform']; ?></label>
                        <input type="text" id="platform" name="platform" value="<?= $materiel->platform ?>" class="form-control"
                               placeholder="<?php echo $this->lang['descript']; ?>" style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <input type="hidden" id="user_modification" name="user_modification" class="form-control"
                               value="<?= base64_encode($this->_USER->id) ?>"    style="width: 100%">

                    </div>

                    </div>
                <input type="hidden" name="rowid" value="<?= base64_encode($materiel->rowid) ?>">

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


