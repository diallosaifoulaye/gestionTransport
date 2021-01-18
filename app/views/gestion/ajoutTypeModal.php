<form id="validation" class="form-inline form-validator" data-type="update" role="form"
      name="form" action="<?= WEBROOT ?>gestion/insertType" method="post" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['ajoutType']; ?></h4>
    </div>
    <div class="modal-body">
       <!-- --><?php /*var_dump($module); die(); */?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="libelle" class="control-label"><?php echo $this->lang['libelle']; ?></label>
                        <input type="text" id="libelle" name="libelle" class="form-control" placeholder="Libelle" style="width: 100%">
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