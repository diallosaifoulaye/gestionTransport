<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>bus/ajoutBus" method="post" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['saveBus']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="input-file-events" class="col-sm-4 control-label"><?= $this->lang['labphoto'].' (*) :' ; ?></label>
                        <div class="col-md-12">
                            <input type="file" id="input-file-events" name="photo" required class="dropify-fr" data-show-errors="true"
                                   data-max-file-size="1M" data-allowed-file-extensions="png jpg jpeg" data-default-file="<?php echo ASSETS ?>pictures/20180123151717.jpg">
                            <span id="msg1"></span>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="matricule" class="control-label"><?php echo $this->lang['matricule']; ?></label>
                        <input type="text" id="matricule" name="matricule" class="form-control" placeholder="Veuillez entrer le matricule du bus" required
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="couleur" class="control-label"><?php echo $this->lang['couleur']; ?></label>
                        <input type="text" id="couleur" name="couleur" class="form-control" placeholder="Veuillez entrer la couleur du bus"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="places" class="control-label"><?php echo $this->lang['place']; ?></label>
                        <input type="number" id="places" name="places" class="form-control" placeholder="Veuillez entrer le nombre de place"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang['listeTypeCategorie']; ?> </label>

                        <select id="categorie" name="categorie" class="form-control" style="width: 100%">
                            <option value=""> Selectionnez le type de categoire</option>

                            <?php foreach ($categorie as $oneTypep) { ?>
                                <option value="<?php echo $oneTypep->id; ?>"> <?php echo $oneTypep->libelle; ?></option>
                            <?php } ?>
                        </select>

                    </div>

<!--                    <div class="form-group" style="width: 100%;padding: 10px;">-->
<!--                        <label for="module" class="control-label">Liste des Gie </label>-->
<!---->
<!--                        <select id="numGIE" name="numGIE" class="form-control" style="width: 100%">-->
<!--                            <option value=""> Selectionnez le Gie du bus</option>-->
<!---->
<!--                            --><?php //foreach ($gie as $oneTypep) { ?>
<!--                                <option value="--><?php //echo $oneTypep->id; ?><!--"> --><?php //echo $oneTypep->nomgie; ?><!--</option>-->
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
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: '<?= $this->lang['default'];  ?>',
                replace: '<?= $this->lang['replace'];  ?>',
                remove:  '<?= $this->lang['remove'];  ?>',
                error:   '<?= $this->lang['error'];  ?>'
            },
            error: {
                'fileSize': 'The file size is too big ({{ value }} max).',
                'minWidth': 'The image width is too small ({{ value }}}px min).',
                'maxWidth': 'The image width is too big ({{ value }}}px max).',
                'minHeight': 'The image height is too small ({{ value }}}px min).',
                'maxHeight': 'The image height is too big ({{ value }}px max).',
                'imageFormat': 'The image format is not allowed ({{ value }} only).'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();
        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });
        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });
        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });
        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
</script>
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

