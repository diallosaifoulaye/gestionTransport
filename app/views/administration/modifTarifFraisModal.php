<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/updateTarifFrais" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modif_tarif_frais']; ?></h4>
    </div>

    <!--<input type="hidden" id="date_modification" name="date_modification" value="<?/*= date('Y-m-d H:i:s'); */?>">
    <input type="hidden" id="user_modification" name="user_modification" value="<?/*= $this->_USER->id; */?>">-->

    <div class="modal-body">

        <?php /*echo var_dump($serv); die(); */?>

        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-3"></div>

                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="montant_deb" class="control-label"><?php echo $this->lang['montant_deb']; ?></label>
                        <input type="text" id="montant_deb" name="montant_deb" value="<?= $tarif_frais->montant_deb ?>"
                               class="form-control" placeholder="<?php echo $this->lang['montant_deb']; ?>" style="width: 100%">
                        <?/* print $token; */?>
                        <input type="hidden" name="rowid" value="<?= base64_encode($tarif_frais->rowid) ?>">
                        <input type="hidden" name="fk_service" value="<?= base64_encode($tarif_frais->fk_service) ?>">
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="montant_fin" class="control-label"><?php echo $this->lang['montant_fin']; ?></label>
                        <input type="text" id="montant_fin" name="montant_fin" value="<?= $tarif_frais->montant_fin ?>"
                               class="form-control" placeholder="<?php echo $this->lang['montant_fin']; ?>" style="width: 100%">
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="valeur" class="control-label"><?php echo $this->lang['valeur']; ?></label>
                        <input type="text" id="valeur" name="valeur" value="<?= $tarif_frais->valeur ?>"
                               class="form-control" placeholder="<?php echo $this->lang['valeur']; ?>" style="width: 100%">
                    </div>

                </div>

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

