<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>client/reenrolement" method="post" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['reenrolementTitle']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="numero_serie" class="control-label"><?php echo $this->lang['numeroSerieCarte']; ?></label>
                        <input type="hidden" id="id" name="id" class="form-control" value="<?= $idClient ?>" required
                               style="width: 100%">
                        <input type="number" id="numero_serie" name="numero_serie" class="form-control" placeholder="<?= $this->lang['numeroSerieCarte']; ?>" required
                               style="width: 100%" onkeyup="numeroSerie()" size="20">
                        <span id="msg3"></span>
                        <span class="help-block with-errors"> </span>
                    </div>
                </div>
                <div id="message" class="col-sm-3"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button id="confirmation" disabled class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>
</form>

<script type="text/javascript">

    function numeroSerie(){
        var numSerie = document.getElementById("numero_serie");
        if((numSerie.value).length >= 10){
            $.ajax({
                type: "POST",
                url: "<?= WEBROOT ?>/client/verifNumSerie",
                data: {
                    numero_serie: $("#numero_serie").val()
                },
                success: function (data)
                {
                    data=JSON.parse(data);
                    if(data.ok == 1){
                        $('#msg3').html("<p style='color:#008000;display: inline;border: 1px solid #F00'>"+data.message+"</p>");
                        $('#confirmation').prop('disabled', false);

                    }
                    else if(data.ok == 2){
                        $('#msg3').html("<p style='color:#F00;display: inline;border: 1px solid #F00'>"+data.message+"</p>");
                    }
                    else if(data.ok == 3){
                        $('#msg3').html("<p style='color:#F00;display: inline;border: 1px solid #F00'>"+data.message+"</p>");
                    }
                    else {
                        $('#msg3').html("<p style='color:#F00;display: inline;border: 1px solid #F00'>"+data.message+"</p>");
                    }
                }
            })
        }
    }

</script>