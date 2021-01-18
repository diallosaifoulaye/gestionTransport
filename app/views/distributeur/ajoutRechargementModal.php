
<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>distrib/ajoutRechargement" method="post" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['rechargement_carte']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="numero_serie" class="control-label"><?php echo $this->lang['numeroSerie'].' (*) :'; ?></label>
                        <input type="number" id="numcarte" name="numcarte" onchange="verifCarte()" class="form-control" required="required" placeholder="<?php echo $this->lang['numeroSerie']; ?>"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>
                        <span id="msg3"></span>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="recharge_max" class="control-label"><?php echo  $this->lang['montant'].' (*) :'; ?></label>
                        <input type="number" id="montant" name="montant" class="form-control" required="required" placeholder="<?php echo $this->lang['montant']; ?>"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>

                    </div>

                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" id="valider" disabled data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>
</form>

<script>

    $('#validation').formValidation({
        framework: 'bootstrap' ,
        fields: {
            solde: {
                validators: {
                    notEmpty: {
                        message: '<?= $this->lang['montantObligatoire']; ?>'
                    }
                }
            }
        }
    });
</script>

<script>
    function verifCarte(){
        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'distrib/verifExistenceCarte'; ?>",

            data: "numcarte="+document.getElementById('numcarte').value,
            success: function(data) {
                //console.log(data);
                var data = JSON.parse(data);

                if(parseInt(data.code) == 1  || parseInt(data.code) ==-2){
                    //$('#msg3').html("<p style='color:#067001;display: inline;border: 1px solid #27ab2b'>"+data.message+"</p>");
                    $("#valider").removeAttr("disabled","disabled")
                }
                else if(parseInt(data.code) < 0){
                    $('#msg3').html("<p style='color:#F00;display: inline;border: 1px solid #F00'>"+data.message+"</p>");
                    $("#valider").attr("disabled","disabled");
                    document.getElementById('numcarte').value = '';
                }
            }
        });
    }

</script>




