<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
         action="<?= WEBROOT ?>client/ajoutRechargement" method="post" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['new_rechargement']; ?></h4>
    </div>
    <div class="modal-body">

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="solde" class="control-label"><?php echo $this->lang['montant'].' (*) :'; ?></label>
                        <input type="number" id="solde" name="solde" class="form-control" required="required" placeholder="<?php echo $this->lang['montant']; ?>"
                               style="width: 100%">
                        <span id="msg3"></span>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <input type="hidden" name="idCarte" value="<?php echo $idcarte ; ?>">




                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" id="valider" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>
</form>



<script>

    $('#validation').formValidation({
        framework: 'bootstrap' ,
        fields: {
            solde: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['montantObligatoire']; ?>'
                    }
                }
            }
        }
    });
</script>


