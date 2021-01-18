<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/updateWebService" method="post">

    <input type="hidden" id="date_modification" name="date_modification" value="<?= date('Y-m-d H:i:s'); ?>">
    <input type="hidden" id="user_modification" name="user_modification" value="<?= $this->_USER->id; ?>">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modif_ws']; ?></h4>
    </div>
    <div class="modal-body">

        <?php //var_dump($web_service); die(); ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="label" class="control-label"><?php echo $this->lang['label_ws']; ?></label>
                        <input type="text" id="label" name="label" value="<?php echo $web_service->label ?>" class="form-control"
                               placeholder="<?php echo $this->lang['label_ws']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <input type="hidden" name="rowid" value="<?php echo base64_encode($web_service->rowid) ?>">
                    <input type="hidden" name="fk_api" value="<?php echo base64_encode($web_service->fk_api) ?>">

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

<script>

    $('#validation').formValidation({
        framework: 'bootstrap' ,
        fields: {
            label: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['label_ws_obligatoire']; ?>'
                    }
                }
            },
            fk_api: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['label_api_obligatoire']; ?>'

                    }
                }
            }
        }
    });
</script>

