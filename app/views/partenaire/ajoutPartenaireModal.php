<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form" action="<?= WEBROOT ?>partenaire/ajoutPartenaire" method="post">

    <input type="hidden" id="user_creation" name="user_creation" value="<?= $this->_USER->id; ?>">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['ajout_partenaire']; ?></h4>
    </div>
    <div class="modal-body">

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="raison_sociale" class="control-label"><?php echo $this->lang['raison_sociale']; ?></label>
                        <input type="text" id="raison_sociale" name="raison_sociale" class="form-control" placeholder="<?php echo $this->lang['raison_sociale']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="controller" class="control-label"><?php echo $this->lang['tel_partenaire']; ?></label>
                        <input type="tel" id="tel" name="telephone"  class="form-control" placeholder="<?php echo $this->lang['tel_partenaire']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="email" class="control-label"><?php echo $this->lang['email_partenaire']; ?></label>
                        <input type="email" id="email" name="email" onchange="verifEmail()" class="form-control" placeholder="<?php echo $this->lang['email_partenaire']; ?>" style="width: 100%">
                        <span id="msg2"></span>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="login" class="control-label"><?php echo $this->lang['labLogin']; ?></label>
                        <input type="text" id="login" name="login" onchange="verifLogin()" class="form-control" placeholder="Login" style="width: 100%">
                        <span id="msg3"></span>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="adresse" class="control-label"><?php echo $this->lang['adresse_partenaire']; ?></label>
                        <input type="text" id="adresse" name="adresse"  class="form-control" placeholder="<?php echo $this->lang['adresse_partenaire']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <?/* print $token;*/?>

                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" id="valider" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
        <button class="btn btn-default" type="button" data-dismiss="modal"> <i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>
</form>

<script>
    $('input[type="tel"]').intlTelInput({
        utilsScript: '<?= ASSETS;?>plugins/telPlug/js/utils.js',
        autoPlaceholder: true,
        preferredCountries: [ 'sn', 'gm', 'gb','ci'],
        initialDialCode: true,
        nationalMode: false
    });

    $('#validation').formValidation({
        framework: 'bootstrap' ,
        fields: {
            raison_sociale: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['raison_sociale_obligatoire']; ?>'
                    }
                }
            },
            telephone: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['telephoneObligatoire']; ?>'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['emailObligatoire']; ?>'
                    },
                    emailAddress: {
                        message: '<?= $this->lang['emailInvalide']; ?>'
                    }
                }
            },
            login: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['loginObligatoire']; ?>'

                    }
                }
            },
            adresse: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['adresseObligatoire']; ?>'

                    }
                }
            }
        }
    });
</script>

<script>
    function verifEmail(){
        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'partenaire/verifExistenceEmail'; ?>",

            data: "email="+document.getElementById('email').value,
            success: function(data) {

                if(parseInt(data) == 1){
                    $('#msg2').html("<p style='color:#F00;display: inline;border: 1px solid #F00'> <?= $this->lang['email_existe']; ?></p>");
                    $("#valider").attr("disabled","disabled");
                    document.getElementById('email').value = '';
                }
                else if(data== -1){
                    $('#msg2').html("");
                    $("#valider").removeAttr("disabled","disabled");
                }
            }
        });
    }

    function verifLogin(){
        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'partenaire/verifExistenceLogin'; ?>",

            data: "login="+document.getElementById('login').value,
            success: function(data) {

                if(parseInt(data) == 1){
                    $('#msg3').html("<p style='color:#F00;display: inline;border: 1px solid #F00'> <?= $this->lang['login_existe']; ?></p>");
                    $("#valider").attr("disabled","disabled");
                    document.getElementById('login').value = '';
                }
                else if(data== -1){
                    $('#msg3').html("");
                    $("#valider").removeAttr("disabled","disabled");
                }
            }
        });
    }
</script>