<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/ajoutService" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['btnAjouterService']; ?></h4>
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

                        <label for="label" class="control-label"><?php echo $this->lang['methode']; ?></label>
                        <input type="text" id="methode" name="methode" class="form-control" onchange="verifMethode()" placeholder="<?php echo $this->lang['methode']; ?>"
                               style="width: 100%" required>
                        <span id="msg2"></span>
                        <span class="help-block with-errors"> </span>

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_categorie" class="control-label"><?php echo $this->lang['thlibCatService']; ?> </label>
                        <select id="fk_categorie" name="fk_categorie" class="select2 form-control" style="width: 100%">
                            <option value="" > <?php echo $this->lang['select_cat_service']; ?></option>
                            <?php foreach ($cat_serv as $oneServ) { ?>
                                <option value="<?php echo $oneServ->rowid; ?>" > <?php echo $oneServ->label; ?></option>
                            <?php }  ?>
                        </select>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_fournisseur" class="control-label"><?php echo $this->lang['nom_four']; ?> </label>
                        <select id="fk_fournisseur" name="fk_fournisseur" class="select2 form-control" style="width: 100%">
                            <option value="" > <?php echo $this->lang['select_fournisseur']; ?></option>
                            <?php foreach ($fournisseur as $oneFour) { ?>
                                <option value="<?php echo $oneFour->rowid; ?>" > <?php echo $oneFour->nom; ?></option>
                            <?php }  ?>
                        </select>
                    </div>

                    <br/>
                    <br/>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label class="control-label"><?= $this->lang['disponibilite_partout'].' :' ; ?></label>
                        <div class="radio-list col-sm-7">
                            <label class="radio-inline p-0">
                                <div class="radio radio-info">
                                    <input type="radio" name="disponibilite" id="radio1" value="1">
                                    <label for="radio1"><?= $this->lang['oui']; ?></label>
                                </div>
                            </label>
                            <label class="radio-inline p-0">
                                <div class="radio radio-info">
                                    <input type="radio" name="disponibilite" id="radio2" value="0" checked>
                                    <label for="radio2"><?= $this->lang['non']; ?></label>
                                </div>
                            </label>
                        </div>
                    </div>

                    <br/>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label class="control-label"><?= $this->lang['commission_par_palier'].' :' ; ?></label>
                        <div class="radio-list col-sm-7">
                            <label class="radio-inline p-0">
                                <div class="radio radio-info">
                                    <input type="radio" name="palier" id="oui" value="1" checked onclick="show1()">
                                    <label for="radio1"><?= $this->lang['oui']; ?></label>
                                </div>
                            </label>
                            <label class="radio-inline p-0">
                                <div class="radio radio-info">
                                    <input type="radio" name="palier" id="non" value="0"  onclick="show2()">
                                    <label for="radio2"><?= $this->lang['non']; ?></label>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="commissionformgroup" style="width: 100%;padding: 10px; display: none">

                        <label for="label" class="control-label"><?php echo $this->lang['commission']; ?></label>
                        <input type="text" id="commission" name="commission" class="form-control" placeholder="<?php echo $this->lang['commission']; ?>"
                               style="width: 100%" required>
                        <span class="help-block with-errors"> </span>

                    </div>


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
                },
                fk_fournisseur: {
                    validators: {
                        notEmpty: {
                            message: '<?= $this->lang['fourObligatoire']; ?>'
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