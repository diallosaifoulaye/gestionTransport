<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form" action="<?= WEBROOT ?>administration/ajoutErrorWS" method="post">

    <input type="hidden" id="user_creation" name="user_creation" value="<?= $this->_USER->id; ?>">
    <input type="hidden" name="date_creation" value="<?php echo date("Y-m-d H:i:s" ); ?>">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['ajout_error_ws']; ?></h4>
    </div>
    <div class="modal-body">

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="code" class="control-label"><?php echo $this->lang['thlibCode']; ?></label>
                        <input type="text" id="code" name="code" class="form-control" placeholder="<?php echo $this->lang['thlibCode']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="message_fr" class="control-label"><?php echo $this->lang['thlibFr']; ?></label>
                        <input type="text" id="message_fr" name="message_fr" class="form-control" placeholder="<?php echo $this->lang['thlibFr']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="message_en" class="control-label"><?php echo $this->lang['thlibEn']; ?></label>
                        <input type="text" id="message_en" name="message_en" class="form-control" placeholder="<?php echo $this->lang['thlibEn']; ?>" style="width: 100%">
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_service" class="control-label"><?php echo $this->lang['thService']; ?> </label>
                        <select id="fk_service" name="fk_service" class="select2 form-control" style="width: 100%">
                            <option value="" > <?php echo $this->lang['select_service']; ?></option>
                            <?php foreach ($service as $oneService) { ?>
                                <option value="<?php echo $oneService->rowid; ?>" > <?php echo $oneService->label; ?></option>
                            <?php }  ?>
                        </select>
                    </div>


                    <!--<input type="hidden" name="fk_service" value="<?php /*echo $this->fk_service; */?>">-->

                    <?/* print $token;*/?>

                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
        <button class="btn btn-default" type="button" data-dismiss="modal"> <i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>
</form>
<script>

    $('#validation').formValidation({
        framework: 'bootstrap' ,
        fields: {
            code: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['code_error_ws_obligatoire']; ?>'
                    }
                }
            },message_fr: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['libelle_fr_error_ws_obligatoire']; ?>'
                    }
                }
            },message_en: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['libelle_en_error_ws_obligatoire']; ?>'
                    }
                }
            },
            fk_service: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['error_ws_serviceObligatoire']; ?>'

                    }
                }
            }
        }
    });
</script>