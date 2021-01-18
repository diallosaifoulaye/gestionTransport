<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>bus/insertParamFact" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['ajoutParametrage']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="place_min" class="control-label"><?php echo $this->lang['nbreDePlaceMin']; ?></label>
                        <input type="text" id="place_min" name="place_min" class="form-control" placeholder="Veuillez entrer le minimum de place" required
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="place_max" class="control-label"><?php echo $this->lang['nbreDePlaceMax']; ?></label>
                        <input type="text" id="place_max" name="place_max" class="form-control" placeholder="Veuillez entrer le maximum de place" required
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="couleur" class="control-label"><?php echo $this->lang['price']; ?></label>
                        <input type="text" id="price_by_day" name="price_by_day" class="form-control" placeholder="Veuillez entrer le prix de la location"
                               style="width: 100%">
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


