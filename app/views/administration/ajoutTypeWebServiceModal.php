<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/ajoutTypeWebService" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['btnAjouterTypeWebService']; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">

                        <label for="profil" class="control-label"><?php echo $this->lang['thlibTypeWebService']; ?></label>
                        <input type="text" id="label" name="label" class="form-control" placeholder="Libelle"
                               style="width: 100%" required>
                        <input type="hidden" name="user_creation" value="<?php echo $this->_USER->id; ?>">
                        <input type="hidden" name="date_creation" value="<?php echo date("Y-m-d H:i:s" ); ?>">
                        <span class="help-block with-errors"> </span>

                    </div>

                </div>
                <div class="col-sm-3"></div>

            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>

</form>

<script>
    $('#validation').formValidation({
            framework: 'bootstrap',
            fields: {
                label: {
                    validators: {
                        notEmpty: {
                            message: '<?= $this->lang['typewebServiceObligatoire']; ?>'
                        }
                    }
                }
            }
        }
    );
</script>