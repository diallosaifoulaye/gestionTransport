<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form" action="<?= WEBROOT ?>administration/ajoutFournisseur" method="post">

    <input type="hidden" id="user_creation" name="user_creation" value="<?= $this->_USER->id; ?>">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['ajout_four']; ?></h4>
    </div>
    <div class="modal-body">
      <!-- --><?php /*var_dump($pays); die(); */?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="droit" class="control-label"><?php echo $this->lang['nom_four']; ?></label>
                        <input type="text" id="nom" name="nom" class="form-control" placeholder="<?php echo $this->lang['nom_four']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="controller" class="control-label"><?php echo $this->lang['tel_four']; ?></label>
                        <input type="tel" id="tel" name="telephone"  class="form-control" placeholder="<?php echo $this->lang['tel_four']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="action" class="control-label"><?php echo $this->lang['email_four']; ?></label>
                        <input type="email" id="email" name="email"  class="form-control" placeholder="<?php echo $this->lang['email_four']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="action" class="control-label"><?php echo $this->lang['adresse_four']; ?></label>
                        <input type="text" id="adresse" name="adresse"  class="form-control" placeholder="<?php echo $this->lang['adresse_four']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang['pays']; ?> </label>
                        <select id="fk_pays" name="fk_pays" class="select2 form-control" style="width: 100%">
                            <option value="" > Selectionnez le pays</option>
                            <?php foreach ($pays as $onePays) { ?>
                                <option value="<?php echo $onePays->rowid; ?>" > <?php echo $onePays->label; ?></option>
                            <?php }  ?>
                        </select>
                    </div>
                    <? //print $token;?>

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
            nom: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['nomObligatoire']; ?>'
                    }
                }
            },
            prenom: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['prenomObligatoire']; ?>'

                    }
                }
            },
            adresse: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['adresseObligatoire']; ?>'

                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['emailObligatoire']; ?>'

                    }
                }
            },
            telephone: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['telephoneObligatoire']; ?>'
                    }
                }
            }
        }
    });
</script>