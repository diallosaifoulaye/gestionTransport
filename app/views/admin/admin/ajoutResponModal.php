<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>admin/ajoutRespon" method="post" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['save_Respo']; ?></h4>
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
                                   data-max-file-size="1M" data-allowed-file-extensions="png jpg jpeg" data-default-file="<?php echo ASSETS ?>pictures/20180123151717.jpg" >
                            <span id="msg1"></span>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label"><?php echo $this->lang['labnom']; ?></label>
                        <input type="text" id="nom" name="nom" class="form-control" placeholder="Veuillez entrer le nom"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="prenom" class="control-label"><?php echo $this->lang['labprenom']; ?></label>
                        <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Veuillez entrer le prenom"
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
                        <input type="telephone" id="telephone" name="telephone" class="form-control" placeholder="Veuillez entrer le contact"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="login" class="control-label"><?php echo $this->lang['labLogin']; ?></label>
                        <input type="text" id="login" name="login" onchange="verifLogin()" class="form-control" placeholder="Login"
                               style="width: 100%">
                        <span id="msg3"></span>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label">Liste des profils </label>

                        <select id="idprofil" name="fk_profil" class="form-control" style="width: 100%">
                            <option value=""> Selectionnez le type de profil</option>

                            <?php foreach ($typep as $oneTypep) { ?>
                                <option value="<?php echo $oneTypep->id; ?>"> <?php echo $oneTypep->profil; ?></option>
                            <?php } ?>
                        </select>

                    </div>

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
            url: "<?= WEBROOT.'admin/verifExistenceEmail'; ?>",

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
            nom: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['nomObligatoire']; ?>'
                    }

                }

            },
            prenom: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['prenomObligatoire']; ?>'
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

            }


        }
    });
</script>

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
