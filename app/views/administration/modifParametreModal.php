<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/updateParametre" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modif_par']; ?></h4>
    </div>
    <div class="modal-body">

        <?php //echo var_dump($parametre); die(); ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="code" class="control-label"><?php echo $this->lang['parametre']; ?></label>
                        <input type="text" id="parametre" name="parametre" value="<?php echo $parametre->parametre ?>" class="form-control"
                               placeholder="<?php echo $this->lang['parametre']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="message_fr" class="control-label"><?php echo $this->lang['nbre_parametre']; ?></label>
                        <input type="text" id="nbre_parametre" name="nbre_parametre" value="<?php echo $parametre->nbre_parametre ?>" class="form-control"
                               placeholder="<?php echo $this->lang['nbre_parametre']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <input type="hidden" name="rowid" value="<?php echo base64_encode($parametre->rowid) ?>">
                    <input type="hidden" id="fk_webservice" name="fk_webservice" value="<?php echo base64_encode($parametre->fk_webservice) ?>" />

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
            parametre: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['code_cr_obligatoire']; ?>'
                    }
                }
            },nbre_parametre: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['msg_fr_cr_obligatoire']; ?>'
                    }
                }
            }
        }
    });
</script>

