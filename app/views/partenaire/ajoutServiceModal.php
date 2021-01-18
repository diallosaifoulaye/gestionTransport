<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/ajoutCatService" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['btnAjouterCatService']; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">

                        <label for="label" class="control-label"><?php echo $this->lang['thlibService']; ?></label>
                        <input type="text" id="label" name="label" class="form-control" placeholder="<?php echo $this->lang['thlibService']; ?>"
                               style="width: 100%" required>
                        <input type="hidden" name="user_creation" value="<?php echo $this->_USER->id; ?>">
                        <input type="hidden" name="date_creation" value="<?php echo date("Y-m-d H:i:s" ); ?>">
                        <span class="help-block with-errors"> </span>

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_categorie" class="control-label"><?php echo $this->lang['thlibCatService']; ?> </label>
                        <select id="fk_categorie" name="fk_categorie" class="select2 form-control" style="width: 100%">
                            <option value="" > <?php echo $this->lang['select_cat_service']; ?></option>
                            <?php foreach ($serv as $oneServ) { ?>
                                <option value="<?php echo $oneServ->rowid; ?>" > <?php echo $oneServ->label; ?></option>
                            <?php }  ?>
                        </select>
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
                            message: '<?= $this->lang['serviceObligatoire']; ?>'
                        }
                    }
                },
                fk_categorie: {
                    validators: {
                        notEmpty: {
                            message: '<?= $this->lang['catServiceObligatoire']; ?>'
                        }
                    }
                }
            }
        }
    );
</script>