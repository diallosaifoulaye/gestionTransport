
<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
         action="<?= WEBROOT ?>client/ajoutClient" method="post" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['ajoutclient']; ?></h4>
    </div>
    <div class="modal-body">

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="numcarte" class="control-label"><?php echo $this->lang['num_serie'].' (*) :'; ?></label>
                        <input type="number" id="numcarte" name="numcarte" class="form-control" onchange="verifCarte()" placeholder="<?php echo $this->lang['num_serie']; ?>"
                               style="width: 100%">
                        <span id="msg3"></span>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang['montant']; ?></label>

                        <input type="number" id="montant" name="montant" class="form-control" placeholder="<?php echo $this->lang['montant']; ?>"
                               style="width: 100%">

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="prenom" class="control-label"><?php echo $this->lang['prenom'].' (*) :'; ?></label>
                        <input type="text" id="prenom" name="prenom" class="form-control" placeholder="<?php echo $this->lang['prenom']; ?>"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label"><?php echo $this->lang['nom'].' (*) :'; ?></label>
                        <input type="text" id="nom" name="nom" class="form-control" placeholder="<?php echo $this->lang['nom']; ?>"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="email" class="control-label"><?php echo $this->lang['email'].' (*) :'; ?></label>
                        <input type="email" id="email" name="email" class="form-control" onchange="verifEmail()" placeholder="<?php echo $this->lang['email']; ?>"
                               style="width: 100%">
                        <span id="msg2"></span>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="controller" class="control-label"><?php echo $this->lang['telephone'].' (*) :'; ?></label>
                        <input type="tel" id="tel" required name="telephone"  class="form-control" placeholder="<?php echo $this->lang['telephone']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="from" class="control-label"><?php echo $this->lang['labdatenaiss'].' (*) :'; ?></label>
                        <input type="text" id="from" name="date_naissance"  class="form-control" placeholder="<?php echo $this->lang['labdatenaiss']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="profession" class="control-label"><?php echo $this->lang['typeCarte'].' (*) :'; ?></label>
                        <select id="profession" name="type_carte" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang["selectionneruntypeCarte"]?></option>
                            <option value="1"><?php echo $this->lang['cni']; ?> </option>
                            <option value="2"><?php echo $this->lang['passport']; ?> </option>
                        </select>
                    </div>


                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="cni" class="control-label"><?php echo $this->lang['numIdentification'].' (*) :'; ?></label>
                        <input type="text" id="cni" name="cni"  class="form-control" placeholder="<?php echo $this->lang['numIdentification']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="profession" class="control-label"><?php echo $this->lang['profession'].' (*) :'; ?></label>
                        <select id="profession" name="profession" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang["selectionneruneprofession"]?></option>

                            <?php foreach ($professions as $profession) { ?>
                                <option value="<?php echo $profession->rowid; ?>"> <?php echo $profession->libelle; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="adresse" class="control-label"><?php echo $this->lang['adresse'].' (*) :'; ?></label>
                        <textarea type="text" id="adresse" name="adresse"  class="form-control" placeholder="<?php echo $this->lang['adresse']; ?>" style="width: 100%"></textarea>

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



    $(function () {
        $("#from").datepicker({
            defaultDate: "+1w",
            changeYear: true,
            numberOfYears: 1,
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });


    });

</script>



<script>
    $('#validation').formValidation({
        framework: 'bootstrap',
        fields: {
            prenom: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['prenomObligatoire']; ?>'
                    },
                    regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message: '<?= $this->lang['prenomLettre']; ?>'
                    }
                }

            },
            nom: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['nomObligatoire']; ?>'
                    },
                    regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message:'<?= $this->lang['nomLettre']; ?>'
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
            }

        }
    });
</script>

<script>
    $('input[type="tel"]').intlTelInput({
        utilsScript: '<?= ASSETS;?>plugins/telPlug/js/utils.js',
        autoPlaceholder: true,
        preferredCountries: [ 'lr','sn', 'gm', 'gb','ci'],
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



<script>
    function verifEmail(){
        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'client/verifExistenceEmail'; ?>",

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

</script>


<script>
    function verifCarte(){
        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'client/verifExistenceCarte'; ?>",

            data: "numcarte="+document.getElementById('numcarte').value,
            success: function(data) {
                console.log(data);
                var data = JSON.parse(data);

                if(parseInt(data.code) == 1){
                    $('#msg3').html("<p style='color:#067001;display: inline;border: 1px solid #27ab2b'>"+data.message+"</p>");
                    $("#valider").removeAttr("disabled","disabled")
                }
                else if(parseInt(data.code) < 0){
                    $('#msg3').html("<p style='color:#F00;display: inline;border: 1px solid #F00'>"+data.message+"</p>");
                    $("#valider").attr("disabled","disabled");
                    //document.getElementById('numcarte').value = '';
                }
            }
        });
    }

</script>