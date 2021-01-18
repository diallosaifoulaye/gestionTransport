
<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>distri/insertDistribution" method="post" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['nouvelleDistribution']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="distribution" class="control-label"> <?php echo $this->lang["distributeur"]?> </label>

                        <select id="distribution" name="distribution" class="form-control" style="width: 100%" required>
                            <option value="">  <?php echo $this->lang["selectionnerDistributeur"]?></option>

                            <?php foreach ($distributeur as $oneDistri) { ?>
                                <option value="<?php echo $oneDistri->id; ?>"> <?php echo $oneDistri->nom_point; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="debut_numeroSerie" class="control-label"><?php echo $this->lang['debutNumeroSerie']; ?></label>
                        <input type="text" id="debut_numeroSerie" name="debut_numeroSerie" class="form-control" onchange="verifCarte()" placeholder="<?php echo $this->lang['debutNumeroSerie']; ?>"
                        style="width: 100%" required >
                        <span id="msg3"></span>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nbre_carte" class="control-label"><?php echo $this->lang['nombre']; ?></label>
                        <input type="number" id="nbre_carte" name="nbre_carte" class="form-control" placeholder="<?php echo $this->lang['nombre']; ?>"
                               style="width: 100%" required >
                        <span id="msg2"></span>
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



<script src="<?= ASSETS; ?>plugins/telPlug/js/intlTelInput.js"></script>
<script src="<?= ASSETS; ?>plugins/telPlug/js/utils.js"></script>
<script src="<?= ASSETS; ?>js/telPlug/js/utils.js"></script>



<script>
    function verifCarte(){
        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'distri/verifExistenceCarte'; ?>",

            data: "debut_numeroSerie="+document.getElementById('debut_numeroSerie').value,
            success: function(data) {
                //console.log(data);
                var data = JSON.parse(data);

                if(parseInt(data.code) == 1 ){
                    //$('#msg3').html("<p style='color:#067001;display: inline;border: 1px solid #27ab2b'>"+data.message+"</p>");
                    $("#valider").removeAttr("disabled","disabled")
                }
                else if(parseInt(data.code) < 0){
                    $('#msg3').html("<p style='color:#F00;display: inline;border: 1px solid #F00'>"+data.message+"</p>");
                    $("#valider").attr("disabled","disabled");
                    document.getElementById('debut_numeroSerie').value = '';
                }
            }
        });
    }

</script>






