<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>trajets/updatePoint" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modification_Bus']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label"><?php echo $this->lang['point']; ?></label>
                        <input type="text" id="nom" name="nom" value="<?= $points->nom ?>" class="form-control"
                               style="width: 100%">
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="longitude" class="control-label"><?php echo $this->lang['longitude']; ?></label>
                        <input type="text" id="longitude" name="longitude" value="<?= $points->longitude ?>" class="form-control"
                               style="width: 100%">
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="latitude" class="control-label"><?php echo $this->lang['latitude']; ?></label>
                        <input type="text" id="latitude" name="latitude" value="<?= $points->latitude ?>" class="form-control"
                               style="width: 100%">
                    </div>
                </div>
                <input type="hidden" name="rowid" value="<?= base64_encode($points->rowid) ?>">
                <input type="hidden" name="id_trajet" value="<?= base64_encode($points->ligne) ?>">

                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?></button>
    </div>
</form>


