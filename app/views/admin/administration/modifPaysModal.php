<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/updatePays" method="post">

    <input type="hidden" id="date_modification" name="date_modification" value="<?= date('Y-m-d H:i:s'); ?>">
    <input type="hidden" id="user_modification" name="user_modification" value="<?= $this->_USER->id; ?>">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modifPays']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="profil" class="control-label"><?php echo $this->lang['labPays']; ?></label>
                        <input type="text" id="label" name="label" value="<?= $pays->label ?>"
                               class="form-control" placeholder="libelle pays" style="width: 100%">
                        <? //print $token; ?>
                        <input type="hidden" name="rowid" value="<?= base64_encode($pays->rowid) ?>">
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

