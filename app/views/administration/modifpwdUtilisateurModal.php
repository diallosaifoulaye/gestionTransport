<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/updatepwdUtilisateur" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modifpwdUtilisateur']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="motdepasse" class="control-label"><?php echo $this->lang['labpwd']; ?></label>
                        <input type="password" id="password" name="password"
                               class="form-control" placeholder="Mot de passe" style="width: 100%">
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="password" class="control-label"><?php echo $this->lang['labnpwd']; ?></label>
                        <input type="password" id="npassword" name="npassword" class="form-control"
                               placeholder="Nouveau mot de passe" style="width: 100%">
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="cpassword" class="control-label"><?php echo $this->lang['labcnpwd']; ?></label>
                        <input type="password" id="cpassword" name="cpassword" class="form-control"
                               placeholder="Confirmation nouveau mot de passe" style="width: 100%">
                        <? print $token; ?>
                        <input type="hidden" name="id" value="<?= base64_encode($this->_USER->id) ?>">
                    </div>

                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i
                    class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i
                    class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?></button>
    </div>
</form>
<script>
    $('#validation').formValidation({
        framework: 'bootstrap',
        fields: {
            password: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['pwdObligatoire']; ?>'
                    }
                }
            },
            npassword: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['npasswordObligatoire']; ?>'
                    }
                }
            },

            cpassword: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['cpasswordObligatoire']; ?>'
                    },

                }
            }
        }
    });
</script>