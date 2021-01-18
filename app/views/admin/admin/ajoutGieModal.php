<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>admin/ajoutGie" method="post" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['newGie']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                   <!-- <div class="form-group">
                        <label for="input-file-events" class="col-sm-4 control-label"><?/*= $this->lang['labphoto'].' (*) :' ; */?></label>
                        <div class="col-md-12">
                            <input type="file" id="input-file-events" name="photo" required class="dropify-fr" data-show-errors="true"
                                   data-max-file-size="1M" data-allowed-file-extensions="png jpg jpeg" data-default-file="<?php /*echo WEBROOT */?>app/pictures/20180123151717.jpg" >
                            <span id="msg1"></span>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>-->
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nomgie" class="control-label"><?php echo $this->lang['nomGie']; ?></label>
                        <input type="text" id="nomgie" name="nomgie" class="form-control" placeholder="Veuillez entrer le nom du Gie"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="adresse" class="control-label"><?php echo $this->lang['adresseGie']; ?></label>
                        <input type="text" id="adresse" name="adresse" class="form-control" placeholder="Veuillez entrer le terminus du Gie"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="email" class="control-label"><?php echo $this->lang['labemail']; ?></label>
                        <input type="email" id="email" name="email" class="form-control" onchange="verifEmail()" placeholder="Veuillez entrer l'adresse mail"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="controller" class="control-label"><?php echo $this->lang['telephone']; ?></label>
                        <input type="telephone" id="telephone" name="telephone" class="form-control" placeholder="Veuillez entrer le numero du Gie"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>

                    </div>
<!--                    <div class="form-group" style="width: 100%;padding: 10px;">-->
<!--                        <label for="module" class="control-label">Liste des Responsables </label>-->
<!---->
<!--                        <select id="id_responsable" name="id_responsable" class="form-control" style="width: 100%">-->
<!--                            <option value=""> Selectionnez le responsable du GIE</option>-->
<!---->
<!--                            --><?php //foreach ($utilisateur as $oneTypep) { ?>
<!--                                <option value="--><?php //echo $oneTypep->id; ?><!--"> --><?php //echo $oneTypep->prenom.' '.$oneTypep->nom; ?><!--</option>-->
<!--                            --><?php //} ?>
<!--                        </select>-->
<!---->
<!--                    </div>-->



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
    function verifEmail(){
        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'admin/verifExistenceEmailGie'; ?>",

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

    $('input[type="telephone"]').intlTelInput({
        utilsScript: '<?= ASSETS;?>plugins/telPlug/js/utils.js',
        autoPlaceholder: true,
        preferredCountries: [ 'sn', 'gm', 'gb','ci','gn'],
        initialDialCode: true,
        nationalMode: false
    });
</script>

<script>

    $('#validation').formValidation({
        framework: 'bootstrap',
        fields: {
            nomgie: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['nomGieObligatoire']; ?>'
                    }

                }

            },
            adresse: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['terminus']; ?>'
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
                    },

                }

            },
            id_responsable: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['responsableObligatoire']; ?>'
                    },

                }

            }


        }
    });
</script>
