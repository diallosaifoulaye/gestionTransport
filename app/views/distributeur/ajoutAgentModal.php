
<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>agent/ajoutAgent" method="post" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['nouveauAgent']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label"><?php echo $this->lang['labnom']; ?></label>
                        <input type="text" id="nom_agent" name="nom_agent" class="form-control" placeholder=<?php echo $this->lang['labnom']; ?>
                        style="width: 100%" required >
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="prenom" class="control-label"><?php echo $this->lang['labprenom']; ?></label>
                        <input type="text" id="prenom_agent" name="prenom_agent" class="form-control" placeholder=<?php echo $this->lang['labprenom']; ?>
                        style="width: 100%" required >
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="email" class="control-label"><?php echo $this->lang['labemail']; ?></label>
                        <input type="email" id="email_agent" name="email_agent" onchange="verifEmail()" class="form-control" placeholder="<?php echo $this->lang['labemail']; ?>"
                               style="width: 100%" required >
                        <span id="msg2"></span>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="adresse" class="control-label"><?php echo $this->lang['labadresse']; ?></label><br/>
                        <textarea rows="4" cols="120" id="adresse_agent" name="adresse_agent" class="form-control"  required >
                            </textarea>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="telephone" class="control-label"><?php echo $this->lang['telephone']; ?></label>
                        <input type="telephone" id="telephone_agent" name="telephone_agent"  class="form-control" placeholder="<?php echo $this->lang['telephone']; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
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



<script src="<?= ASSETS; ?>plugins/telPlug/js/intlTelInput.js"></script>
<script src="<?= ASSETS; ?>plugins/telPlug/js/utils.js"></script>
<script src="<?= ASSETS; ?>js/telPlug/js/utils.js"></script>



<script >

    $('input[type="telephone"]').intlTelInput({
        utilsScript: '<?= ASSETS;?>plugins/telPlug/js/utils.js',
        autoPlaceholder: true,
        preferredCountries: [ 'lr', 'gm', 'gb','ci'],
        initialDialCode: true,
        nationalMode: false
    });

</script>

<script>
    function verifEmail(){
        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'agent/verifExistenceEmail'; ?>",

            data: "email_agent="+document.getElementById('email_agent').value,
            success: function(data) {

                if(parseInt(data) == 1){
                    $('#msg2').html("<p style='color:#F00;display: inline;border: 1px solid #F00'> <?= $this->lang['email_existe']; ?></p>");
                    document.getElementById('email_agent').value = '';


                }

            }
        });
    }

</script>






