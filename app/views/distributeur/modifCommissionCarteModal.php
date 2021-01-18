<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>distri/updateCommissionCarte" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modificationCommission']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="montant_carte" class="control-label"><?php echo $this->lang['montantCarte']; ?></label>
                        <input type="text" id="montant_carte" name="montant_carte" value="<?= $commission->montant_carte ?>" class="form-control"
                               placeholder="<?php echo $this->lang['carteVendue']; ?>" style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="commission" class="control-label"><?php echo $this->lang['commission']; ?></label>
                        <input type="text" id="commission" name="commission" value="<?= $commission->commission ?>" class="form-control"
                               placeholder="<?php echo $this->lang['commission']; ?>" style="width: 100%">

                    </div>
                </div>

            </div>
            <input type="hidden" name="id" value="<?= base64_encode($commission->id) ?>">

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


