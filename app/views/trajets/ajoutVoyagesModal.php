<form id="validation" class="form-inline form-validator" data-type="update" role="form"
      name="form" action="<?= WEBROOT ?>trajets/insertVoyages" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['newvoyages']; ?></h4>
    </div>
    <div class="modal-body">
       <!-- --><?php /*var_dump($module); die(); */?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="lieu_depart" class="control-label"><?php echo $this->lang['code_voyage']; ?></label>
                            <input required type="text" id="code_voyage" value="<?= $code_voyage; ?>" name="code_voyage" class="form-control" placeholder="<?php echo $this->lang['code_voyage']; ?>" readonly style="width: 100%">
                            <span class="help-block with-errors"> </span>
                        </div>
                        <label for="module" class="control-label"><?php echo $this->lang["listedesaffectation"]?></label>

                        <select id="affectation" name="affectation" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang["selectionnerunaffectation"]?></option>

                            <?php foreach ($affectation as $oneaffectation) { ?>
                                <option value="<?php echo $oneaffectation->rowid.'-'.$oneaffectation->bus_id.'-'.$oneaffectation->device_id.'-'.$oneaffectation->receveur_id; ?>"> <?php echo $oneaffectation->receveur.'#'.$oneaffectation->matricule.'#'.$oneaffectation->uuid; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["listedesconducteurs"]?></label>

                        <select id="conducteur_id" name="conducteur_id" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang["selectionnerunconducteur"]?></option>

                            <?php foreach ($employe as $oneemploye) { ?>
                                <option value="<?php echo $oneemploye->id; ?>"> <?php echo $oneemploye->prenom,' ',$oneemploye->nom; ?></option>
                            <?php } ?>
                        </select>

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["listedescontroleurs"]?></label>

                        <select id="controleur_id" name="controleur_id" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang["selectionneruncontroleur"]?></option>

                            <?php foreach ($controleur as $onecontroleur) { ?>
                                <option value="<?php echo $onecontroleur->id; ?>"> <?php echo $onecontroleur->prenom,' ',$onecontroleur->nom; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["listedestrajets"]?></label>

                        <select id="trajet_id" name="trajet_id" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang["selectionneruntrajet"]?></option>

                            <?php foreach ($trajet as $onetrajet) { ?>
                                <option value="<?php echo $onetrajet->id; ?>"> <?php echo $onetrajet->ligne,'-',$onetrajet->lieu_depart,'-',$onetrajet->lieu_arrive; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="from" class="control-label"><?php echo $this->lang['date_voyage']; ?>(*): </label>
                        <input type="text" name="date_voyage" required class="form-control mydatepicker" id="from"
                               placeholder="<?php echo $this->lang['date_voyage']; ?>" autocomplete="off" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>
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
    $(".select2").select2();
</script>
<script>


    $(function () {
        $("#from").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });


    });



</script>
<!--<script>
    $('input[type="telephone"]').intlTelInput({
        utilsScript: '<?/*= ASSETS;*/?>plugins/telPlug/js/utils.js',
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
                        message: '<?/*= $this->lang['nomObligatoire']; */?>'
                    }
                }
            },

            prenom: {
                validators: {
                    notEmpty: {
                        message: '<?/*= $this->lang['prenomObligatoire']; */?>'

                    }
                }
            },
            adresse: {
                validators: {
                    notEmpty: {
                        message: '<?/*= $this->lang['adresseObligatoire']; */?>'

                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: '<?/*= $this->lang['emailObligatoire']; */?>'
                    }
                }
            },
            telephone: {
                validators: {
                    notEmpty: {
                        message: '<?/*= $this->lang['telephoneObligatoire']; */?>'

                    }
                }
            }
        }
    });
</script>-->

<script>
    function create() {

        var lelibelle = $('#bus_id').val();

        if(lelibelle !== ""){
            $.ajax({
                type: "POST",
                url: "<?php echo WEBROOT.'trajets/checkLibelle'; ?>",
                data: "libelle=" + lelibelle,
                success: function (data) {
                    alert(data);
                    if (data == 0) {
                        $('#groupValidation').submit();

                    }
                    if(data != 0){
                        swal("<?php echo $this->lang['gec_alert_libelle_groupe']; ?>");
                    }

                }
            });
        }
        else{
            swal("<?php echo $this->lang['gec_alert_libelle_groupe_pas_vide']; ?>");
        }
    }


</script>
