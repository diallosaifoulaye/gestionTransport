<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/updateCatService" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modif_catservice']; ?></h4>
    </div>

    <input type="hidden" id="date_modification" name="date_modification" value="<?= date('Y-m-d H:i:s'); ?>">
    <input type="hidden" id="user_modification" name="user_modification" value="<?= $this->_USER->id; ?>">

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="code" class="control-label"><?php echo $this->lang['code_cr']; ?></label>
                        <input type="text" id="code" name="code" value="<?= $cat_serv->code ?>" class="form-control" placeholder="<?php echo $this->lang['code_cr']; ?>" style="width: 100%">
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="label" class="control-label"><?php echo $this->lang['thlibCatService']; ?></label>
                        <input type="text" id="label" name="label" value="<?= $cat_serv->label ?>"
                               class="form-control" placeholder="<?php echo $this->lang['thlibCatService']; ?>" style="width: 100%">
                        <?/* print $token; */?>
                        <input type="hidden" name="rowid" value="<?= base64_encode($cat_serv->rowid) ?>">
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

