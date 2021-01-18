<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>distri/updateCommissionRechargement" method="post">
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
                        <label for="recharge_min" class="control-label"><?php echo $this->lang['min']; ?></label>
                        <input type="text" id="recharge_min" name="recharge_min" value="<?= $commission->recharge_min ?>" class="form-control"
                               placeholder="<?php echo $this->lang['min']; ?>" style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="recharge_max" class="control-label"><?php echo $this->lang['max']; ?></label>
                        <input type="text" id="recharge_max" name="recharge_max" value="<?= $commission->recharge_max ?>" class="form-control"
                               placeholder="<?php echo $this->lang['max']; ?>" style="width: 100%">

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


