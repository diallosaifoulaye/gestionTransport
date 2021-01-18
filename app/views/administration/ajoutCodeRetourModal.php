<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form" action="<?= WEBROOT ?>administration/ajoutCodeRetour" method="post">

    <input type="hidden" id="user_creation" name="user_creation" value="<?= $this->_USER->id; ?>"/>

    <input type="hidden" id="fk_webservice" name="fk_webservice" value="<?php echo $this->data['fk_webservice']; ?>" />

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['ajout_cr']; ?></h4>
    </div>
    <div class="modal-body">

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="code" class="control-label"><?php echo $this->lang['code_cr']; ?></label>
                        <input type="text" id="code" name="code" class="form-control" placeholder="<?php echo $this->lang['code_cr']; ?>"  style="width: 100%" onchange="verifCode()">
                        <span id="msg2"></span>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="message_fr" class="control-label"><?php echo $this->lang['msg_fr_cr']; ?></label>
                        <input type="text" id="message_fr" name="message_fr" class="form-control" placeholder="<?php echo $this->lang['msg_fr_cr']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="message_en" class="control-label"><?php echo $this->lang['msg_en_cr']; ?></label>
                        <input type="text" id="message_en" name="message_en" class="form-control" placeholder="<?php echo $this->lang['msg_en_cr']; ?>" style="width: 100%">

                    </div>

                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" id="valider" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
        <button class="btn btn-default" type="button" data-dismiss="modal"> <i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>
</form>
<script>

    $('#validation').formValidation({
        framework: 'bootstrap' ,
        fields: {
            code: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['code_cr_obligatoire']; ?>'
                    }
                }
            },message_fr: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['msg_fr_cr_obligatoire']; ?>'
                    }
                }
            }
        }
    });
</script>

<script>
    function verifCode(){
        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'administration/verifCodeRetour'; ?>",

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