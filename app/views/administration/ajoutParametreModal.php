<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form" action="<?= WEBROOT ?>administration/ajoutCodeRetour" method="post">

    <input type="hidden" id="user_creation" name="user_creation" value="<?= $this->_USER->id; ?>">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['ajout_cr']; ?></h4>
    </div>
    <div class="modal-body">

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="code" class="control-label"><?php echo $this->lang['code_cr']; ?></label>
                        <input type="text" id="code" name="code" class="form-control" placeholder="<?php echo $this->lang['code_cr']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="message_fr" class="control-label"><?php echo $this->lang['msg_fr_cr']; ?></label>
                        <input type="text" id="message_fr" name="message_fr" class="form-control" placeholder="<?php echo $this->lang['msg_fr_cr']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="message_en" class="control-label"><?php echo $this->lang['msg_en_cr']; ?></label>
                        <input type="text" id="message_en" name="message_en" class="form-control" placeholder="<?php echo $this->lang['msg_en_cr']; ?>" style="width: 100%">

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_webservice" class="control-label"><?php echo $this->lang['label_ws']; ?> </label>
                        <select id="fk_webservice" name="fk_webservice" class="select2 form-control" style="width: 100%">
                            <option value="" > <?php echo $this->lang['select_ws']; ?></option>
                            <?php foreach ($ws as $oneWs) { ?>
                                <option value="<?php echo $oneWs->rowid; ?>" > <?php echo $oneWs->label; ?></option>
                            <?php }  ?>
                        </select>
                    </div>
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
                        message: '<?= $this->lang['code_cr_obligatoire']; ?>'
                    }
                }
            },message_fr: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['msg_fr_cr_obligatoire']; ?>'
                    }
                }
            },
            fk_webservice: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['label_ws_obligatoire']; ?>'

                    }
                }
            }
        }
    });
</script>