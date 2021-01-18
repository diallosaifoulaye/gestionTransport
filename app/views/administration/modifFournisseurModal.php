<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/updateFournisseur" method="post">

    <input type="hidden" id="date_modification" name="date_modification" value="<?= date('Y-m-d H:i:s'); ?>">
    <input type="hidden" id="user_modification" name="user_modification" value="<?= $this->_USER->id; ?>">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modifFour']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label"><?php echo $this->lang['nom_four']; ?></label>
                        <input type="text" id="nom" name="nom" value="<?= $four->nom ?>" class="form-control"
                               placeholder="<?php echo $this->lang['nom_four']; ?>" style="width: 100%">
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="telephone" class="control-label"><?php echo $this->lang['tel_four']; ?></label>
                        <input type="tel" id="telephone" name="telephone" value="<?php echo $four->telephone ?>"
                               class="form-control" placeholder="<?php echo $this->lang['tel_four']; ?>" style="width: 100%">
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="email" class="control-label"><?php echo $this->lang['email_four']; ?></label>
                        <input type="email" id="email" name="email" value="<?php echo $four->email ?>" class="form-control"
                               placeholder="<?php echo $this->lang['email_four']; ?>" style="width: 100%">
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="adresse" class="control-label"><?php echo $this->lang['adresse_four']; ?></label>
                        <input type="text" id="adresse" name="adresse" value="<?php echo $four->adresse ?>"
                               class="form-control" placeholder="<?php echo $this->lang['adresse_four']; ?>" style="width: 100%">
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang['pays']; ?></label>
                        <select required id="fk_pays" name="fk_pays" class="form-control" style="width: 100%">
                            <?php foreach ($pays as $onePays) { ?>
                                <option value="<?php echo $onePays->rowid; ?>" <?php if ($four->fk_pays == $onePays->rowid) echo "selected=selected" ?> > <?php echo $onePays->label; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!--                        --><?php// print $token; ?>
                    <input type="hidden" name="rowid" value="<?php echo base64_encode($four->rowid) ?>">

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
            fk_pays: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['paysObligatoire']; ?>'

                    }
                }
            }
        }
    });
</script>

