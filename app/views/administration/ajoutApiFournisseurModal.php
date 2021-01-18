<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form" action="<?= WEBROOT ?>administration/ajoutApiFournisseur" method="post" enctype="multipart/form-data">

    <input type="hidden" id="user_creation" name="user_creation" value="<?php echo $this->_USER->id; ?>"/>
    <input type="hidden" id="fk_fournisseur" name="fk_fournisseur" value="<?php echo $this->data['fk_fournisseur']; ?>" />

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['ajout_api_four']; ?></h4>
    </div>
    <div class="modal-body">

        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-6">

                    <fieldset class="scheduler-border">

                        <legend class="scheduler-border"><?php echo $this->lang['param_generale']; ?></legend>


                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="droit" class="control-label"><?php echo $this->lang['libelle_api_four']; ?></label>
                            <input type="text" id="label" name="label" class="form-control" placeholder="<?php echo $this->lang['libelle_api_four']; ?>" style="width: 100%">
                            <span class="help-block with-errors"> </span>
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="module" class="control-label"><?php echo $this->lang['type_webservice']; ?> </label>
                            <select id="fk_type_webservice" name="fk_type_webservice" class="select2 form-control" style="width: 100%" required>
                                <option value="" > <?php echo $this->lang['select_typewebservice']; ?></option>
                                <?php foreach ($typewebservice as $oneFournisseur) { ?>
                                    <option value="<?php echo $oneFournisseur->id; ?>" > <?php echo $oneFournisseur->label; ?></option>
                                <?php }  ?>
                            </select>
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="module" class="control-label"><?php echo $this->lang['type_interconnexion']; ?> </label>
                            <select id="fk_type_interconnexion" name="fk_type_interconnexion" class="select2 form-control" style="width: 100%" required>
                                <option value="" > <?php echo $this->lang['select_typeinterconnexion']; ?></option>
                                <?php foreach ($typeinterconnexion as $oneFournisseur) { ?>
                                    <option value="<?php echo $oneFournisseur->id; ?>" > <?php echo $oneFournisseur->label; ?></option>
                                <?php }  ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="input-file-events" class="control-label"><?= $this->lang['documentation']; ?></label>
                            <div class="col-md-12">
                                <input type="file" id="input-file-events" name="documentation" class="dropify-fr" data-show-errors="true"
                                       data-max-file-size="5M" data-allowed-file-extensions="pdf doc docx xls xlsx txt csv" />
                                <span id="msg1"></span>
                            </div>
                        </div>

                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>

                    </fieldset>

                </div>

                <div class="col-sm-6">

                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border"><?php echo $this->lang['param_identification']; ?></legend>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="controller" class="control-label"><?php echo $this->lang['lien_api_four']; ?></label>
                            <input type="url" id="lien" name="lien"  class="form-control" placeholder="<?php echo $this->lang['lien_api_four']; ?>" style="width: 100%">
                            <span class="help-block with-errors"> </span>
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="action" class="control-label"><?php echo $this->lang['ip_api_four']; ?></label>
                            <input type="text" id="adresse_ip" name="adresse_ip"  class="form-control" placeholder="<?php echo $this->lang['ip_api_four']; ?>" style="width: 100%">
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="username" class="control-label"><?php echo $this->lang['username']; ?></label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="<?php echo $this->lang['username']; ?>" style="width: 100%">
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="controller" class="control-label"><?php echo $this->lang['password']; ?></label>
                            <input type="text" id="password" name="password"  class="form-control" placeholder="<?php echo $this->lang['password']; ?>" style="width: 100%">
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="action" class="control-label"><?php echo $this->lang['identifier']; ?></label>
                            <input type="text" id="identification" name="identification"  class="form-control" placeholder="<?php echo $this->lang['identifier']; ?>" style="width: 100%">
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="action" class="control-label"><?php echo $this->lang['key']; ?></label>
                            <input type="text" id="cle" name="cle" class="form-control" placeholder="<?php echo $this->lang['key']; ?>" style="width: 100%">
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="action" class="control-label"><?php echo $this->lang['token']; ?></label>
                            <input type="text" id="token" name="token" class="form-control" placeholder="<?php echo $this->lang['token']; ?>" style="width: 100%">
                        </div>



                    </fieldset>






                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">

        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
        <button class="btn btn-default" type="button" data-dismiss="modal"> <i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
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