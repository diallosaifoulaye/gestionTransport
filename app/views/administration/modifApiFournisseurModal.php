<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/updateApiFournisseur" method="post">

    <input type="hidden" id="date_modification" name="date_modification" value="<?= date('Y-m-d H:i:s'); ?>">
    <input type="hidden" id="user_modification" name="user_modification" value="<?= $this->_USER->id; ?>">
    <input type="hidden" id="fk_fournisseur" name="fk_fournisseur" value="<?php echo $api_four->fk_fournisseur; ?>" />

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modifApiFour']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">

                <?php //var_dump($api_four); die(); ?>

                <div class="col-sm-6">

                    <fieldset class="scheduler-border">

                        <legend class="scheduler-border"><?php echo $this->lang['param_generale']; ?></legend>


                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="droit" class="control-label"><?php echo $this->lang['libelle_api_four']; ?></label>
                            <input type="text" id="label" name="label" value="<?php echo $api_four->label ?>" class="form-control" placeholder="<?php echo $this->lang['libelle_api_four']; ?>" style="width: 100%">
                            <span class="help-block with-errors"> </span>
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="module" class="control-label"><?php echo $this->lang['type_webservice']; ?></label>
                            <select required id="fk_type_webservice" name="fk_type_webservice" class="form-control" style="width: 100%">
                                <?php foreach ($typewebservice as $oneFournisseur) { ?>
                                    <option value="<?php echo $oneFournisseur->id; ?>" <?php if ($oneFournisseur->fk_type_webservice == $oneFournisseur->id) echo "selected=selected" ?> > <?php echo $oneFournisseur->label; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="module" class="control-label"><?php echo $this->lang['type_interconnexion']; ?></label>
                            <select required id="fk_type_interconnexion" name="fk_type_interconnexion" class="form-control" style="width: 100%">
                                <?php foreach ($typeinterconnexion as $oneFournisseur) { ?>
                                    <option value="<?php echo $oneFournisseur->id; ?>" <?php if ($oneFournisseur->fk_type_interconnexion == $oneFournisseur->id) echo "selected=selected" ?> > <?php echo $oneFournisseur->label; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="controller" class="control-label"><?php echo $this->lang['lien_api_four']; ?></label>
                            <input type="url" id="lien" name="lien" value="<?php echo $api_four->lien ?>" class="form-control" placeholder="<?php echo $this->lang['lien_api_four']; ?>" style="width: 100%">
                            <span class="help-block with-errors"> </span>
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="action" class="control-label"><?php echo $this->lang['ip_api_four']; ?></label>
                            <input type="text" id="adresse_ip" name="adresse_ip"  value="<?php echo $api_four->adresse_ip ?>" class="form-control" placeholder="<?php echo $this->lang['ip_api_four']; ?>" style="width: 100%">
                        </div>

                    </fieldset>

                </div>

                <div class="col-sm-6">

                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border"><?php echo $this->lang['param_identification']; ?></legend>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="username" class="control-label"><?php echo $this->lang['username']; ?></label>
                            <input type="text" id="username" name="username" value="<?php echo $api_four->username ?>" class="form-control" placeholder="<?php echo $this->lang['username']; ?>" style="width: 100%">
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="controller" class="control-label"><?php echo $this->lang['password']; ?></label>
                            <input type="text" id="password" name="password"  value="<?php echo $api_four->password ?>" class="form-control" placeholder="<?php echo $this->lang['password']; ?>" style="width: 100%">
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="action" class="control-label"><?php echo $this->lang['identifier']; ?></label>
                            <input type="text" id="identification" name="identification"  value="<?php echo $api_four->identification ?>" class="form-control" placeholder="<?php echo $this->lang['identifier']; ?>" style="width: 100%">
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="action" class="control-label"><?php echo $this->lang['key']; ?></label>
                            <input type="text" id="cle" name="cle" value="<?php echo $api_four->cle ?>" class="form-control" placeholder="<?php echo $this->lang['key']; ?>" style="width: 100%">
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="action" class="control-label"><?php echo $this->lang['token']; ?></label>
                            <input type="text" id="token" name="token" value="<?php echo $api_four->token ?>" class="form-control" placeholder="<?php echo $this->lang['token']; ?>" style="width: 100%">
                        </div>

                        <br/>
                        <br/>

                    </fieldset>

                </div>

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
            label: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['labelApiObligatoire']; ?>'
                    }
                }
            },
            lien: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['lienObligatoire']; ?>'
                    }
                }
            },
            adresse_ip: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['ipObligatoire']; ?>'

                    }
                }
            }
        }
    });
</script>

