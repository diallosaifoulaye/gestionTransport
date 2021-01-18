<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/ajoutCatService" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['btnAjouterCatService']; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">

                        <label for="profil" class="control-label"><?php echo $this->lang['code_cr']; ?></label>
                        <input type="text" id="code" name="code" class="form-control" placeholder="code" style="width: 100%" required onchange="verifCode()">
                        <span id="msg2"></span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">

                        <label for="profil" class="control-label"><?php echo $this->lang['thlibCatService']; ?></label>
                        <input type="text" id="label" name="label" class="form-control" placeholder="Libelle" style="width: 100%" required>

                        <input type="hidden" name="user_creation" value="<?php echo $this->_USER->id; ?>">
                        <input type="hidden" name="date_creation" value="<?php echo date("Y-m-d H:i:s" ); ?>">

                    </div>

                </div>
                <div class="col-sm-3"></div>

            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-success confirm" id="valider" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
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
                            message: '<?= $this->lang['catServiceObligatoire']; ?>'
                        }
                    }
                },
                code: {
                    validators: {
                        notEmpty: {
                            message: '<?= $this->lang['catServiceObligatoire']; ?>'
                        }
                    }
                }

            }
        }
    );
</script>

<script>
    function verifCode(){
        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'administration/verifCodeCatSerice'; ?>",

            data: "code="+document.getElementById('code').value,
            success: function(data) {

                if(parseInt(data) == 1){
                    $('#msg2').html("<p style='color:#F00;display: inline;border: 1px solid #F00'> <?= $this->lang['code_alert_error']; ?></p>");
                    $("#valider").attr("disabled","disabled");
                    document.getElementById('code').value = '';
                }
                else if(data== -1){
                    $('#msg2').html("");
                    $("#valider").removeAttr("disabled","disabled");
                }
            }
        });
    }
</script>