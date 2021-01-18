<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>distri/updateDistributeur" method="post">
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
                        <label for="nom_point" class="control-label"><?php echo $this->lang['pointDistri']; ?></label>
                        <input type="text" id="nom_point" name="nom_point" value="<?= $distributeur->nom_point ?>" class="form-control"
                               placeholder="<?php echo $this->lang['pointDistri']; ?>" style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nomRespo" class="control-label"><?php echo $this->lang['nomRespo']; ?></label>
                        <input type="text" id="nom_agent" name="nom_agent" value="<?= $distributeur->nom_agent ?>" class="form-control"
                               placeholder="<?php echo $this->lang['couleur']; ?>" style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="prenom_responsable" class="control-label"><?php echo $this->lang['prenomRespo']; ?></label>
                        <input type="text" id="prenom_agent" name="prenom_agent" value="<?= $distributeur->prenom_agent ?>" class="form-control"
                               placeholder="<?php echo $this->lang['prenomRespo']; ?>" style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="email_responsable" class="control-label"><?php echo $this->lang['labadresse']; ?></label>
                        <input type="text" id="email_agent" name="email_agent" value="<?= $distributeur->email_agent ?>" class="form-control"
                               placeholder="<?php echo $this->lang['labadresse']; ?>" style="width: 100%">
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="adresse_responsable" class="control-label"><?php echo $this->lang['email_four']; ?></label>
                        <input type="text" id="adresse_agent" name="adresse_agent" value="<?= $distributeur->adresse_agent ?>" class="form-control"
                               placeholder="<?php echo $this->lang['email_four']; ?>" style="width: 100%">
                    </div>
                </div>

            </div>
            <input type="hidden" name="id" value="<?= base64_encode($distributeur->id) ?>">

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


