<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>location/updateFacture" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modifFacture']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="place_min" class="control-label"><?php echo $this->lang['nbreDePlaceMin']; ?></label>
                        <input type="text" id="place_min" name="place_min" class="form-control" value="<?= $parametrage->place_min ?>" placeholder="Veuillez entrer le matricule du bus" required
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="place_max" class="control-label"><?php echo $this->lang['nbreDePlaceMax']; ?></label>
                        <input type="text" id="place_max" name="place_max" class="form-control" value="<?= $parametrage->place_max ?>" placeholder="Veuillez entrer le matricule du bus" required
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="couleur" class="control-label"><?php echo $this->lang['prix']; ?></label>
                        <input type="text" id="prix" name="price_by_day" class="form-control" value="<?= $parametrage->price_by_day ?>" placeholder="Veuillez entrer la couleur du bus"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>

                    </div>

                </div>
                <input type="hidden" name="id" value="<?= base64_encode($parametrage->id) ?>">
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
    $('#validation').formValidation({
        framework: 'bootstrap',
        fields: {
            matricule: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['matriculeObligatoire']; ?>'
                    }

                }

            },
            couleur: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['couleurObligatoire']; ?>'
                    },
                    regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message:'<?= $this->lang['couleurLettre']; ?>'
                    }
                }

            },
            categorie: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['categorieObligatoire']; ?>'
                    },

                }

            },
            places: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['placesObligatoire']; ?>'
                    },

                }

            }

        }
    });
</script>


<!--<script>-->
<!--    function getCategorie() {-->
<!---->
<!---->
<!--        var categorie = document.getElementById('categorie');-->
<!--        var valider = document.getElementById('idvalider');-->
<!--        if (categorie ==""){-->
<!--            valider.style.display="none";-->
<!--        }-->
<!---->
<!--        else {-->
<!--            valider.style.display="block";-->
<!--        }-->
<!---->
<!--    }-->
<!---->
<!--</script>-->

