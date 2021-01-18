<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/updateService" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modif_service']; ?></h4>
    </div>

    <input type="hidden" id="date_modification" name="date_modification" value="<?= date('Y-m-d H:i:s'); ?>">
    <input type="hidden" id="user_modification" name="user_modification" value="<?= $this->_USER->id; ?>">

    <div class="modal-body">

        <?php //echo var_dump($serv); die(); ?>

        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="label" class="control-label"><?php echo $this->lang['thlibService']; ?></label>
                        <input type="text" id="label" name="label" value="<?= $serv->label ?>"
                               class="form-control" placeholder="<?php echo $this->lang['thlibCatService']; ?>" style="width: 100%">

                        <input type="hidden" name="rowid" value="<?= base64_encode($serv->rowid) ?>">
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="label" class="control-label"><?php echo $this->lang['methode']; ?></label>
                        <input type="text" id="methode" name="methode" value="<?= $serv->methode ?>"
                               class="form-control" onchange="verifMethode()" placeholder="<?php echo $this->lang['methode']; ?>" style="width: 100%">
                        <span id="msg2"></span>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_categorie" class="control-label"><?php echo $this->lang['thlibCatService']; ?></label>
                        <select required id="fk_categorie" name="fk_categorie" class="form-control" style="width: 100%">
                            <?php foreach ($categ_serv as $oneCatService) { ?>
                                <option value="<?php echo $oneCatService->rowid; ?>" <?php if ($serv->fk_categorie == $oneCatService->rowid) echo "selected=selected" ?> > <?php echo $oneCatService->label; ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_fournisseur" class="control-label"><?php echo $this->lang['nom_four']; ?></label>
                        <select required id="fk_fournisseur" name="fk_fournisseur" class="form-control" style="width: 100%">
                            <?php foreach($fournisseur as $oneFour) { ?>
                                <option value="<?php echo $oneFour->rowid; ?>" <?php if($serv->fk_fournisseur == $oneFour->rowid) echo "selected=selected" ?> > <?php echo $oneFour->nom; ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label class="control-label"><?= $this->lang['disponibilite_partout'].' :' ; ?></label>
                        <div class="radio-list col-sm-7">
                            <label class="radio-inline p-0">
                                <div class="radio radio-info">
                                    <input type="radio" name="disponibilite" id="radio1" value="1" <?php if($serv->disponibilite == 1) echo 'checked'; ?>>
                                    <label for="radio1"><?= $this->lang['oui']; ?></label>
                                </div>
                            </label>
                            <label class="radio-inline p-0">
                                <div class="radio radio-info">
                                    <input type="radio" name="disponibilite" id="radio2" value="0" <?php if($serv->disponibilite == 0) echo 'checked'; ?>>
                                    <label for="radio2"><?= $this->lang['non']; ?></label>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label class="control-label"><?= $this->lang['commission_par_palier'].' :' ; ?></label>
                        <div class="radio-list col-sm-7">
                            <label class="radio-inline p-0">
                                <div class="radio radio-info">
                                    <input type="radio" name="palier" id="oui" value="1" <?php if($serv->palier == 1) echo 'checked'; ?> onclick="show1()">
                                    <label for="radio1"><?= $this->lang['oui']; ?></label>
                                </div>
                            </label>
                            <label class="radio-inline p-0">
                                <div class="radio radio-info">
                                    <input type="radio" name="palier" id="non" value="0" <?php if($serv->palier == 0) echo 'checked'; ?> onclick="show2()">
                                    <label for="radio2"><?= $this->lang['non']; ?></label>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="commissionformgroup" style="width: 100%;padding: 10px; display: none">

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="label" class="control-label"><?php echo $this->lang['commission']; ?></label>
                            <input type="text" id="commission" name="commission" value="<?= $serv->commission ?>"
                                   class="form-control" placeholder="<?php echo $this->lang['commission']; ?>" style="width: 100%">

                        </div>

                    </div>

                </div>

                <div class="col-sm-3"></div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" id="valider" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?></button>
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


    function show1(){
        document.getElementById('commissionformgroup').style.display ='none';
    }
    function show2(){
        document.getElementById('commissionformgroup').style.display = 'block';
    }

</script>

<script>
    function verifMethode(){
        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'administration/verifNomMethode'; ?>",

            data: "methode="+document.getElementById('methode').value,
            success: function(data) {

                if(parseInt(data) == 1){
                    $('#msg2').html("<p style='color:#F00;display: inline;border: 1px solid #F00'> <?= $this->lang['methode_alert_error']; ?></p>");
                    $("#valider").attr("disabled","disabled");
                    document.getElementById('methode').value = '';
                }
                else if(data== -1){
                    $('#msg2').html("");
                    $("#valider").removeAttr("disabled","disabled");
                }
            }
        });
    }
</script>
