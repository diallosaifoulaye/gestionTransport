<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>promotion/updatePromotion" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modificationPromotion']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="libelle" class="control-label"><?php echo $this->lang['libelle']; ?></label>
                        <input type="text" id="libelle" name="libelle" value="<?= $promotion->libelle ?>" class="form-control"
                               placeholder="<?php echo $this->lang['libelle']; ?>" style="width: 100%">

                    </div>
                    <div class="form-group col-lg-2 col-sm-2" class="form-group" style="width: 100%;padding: 10px;">
                        <label for="from1" class="control-label" ><?php echo $this->lang['date_debut']; ?> (*): </label><br/>
                        <input type="text" name="date_debut" required class="form-control" id="from1" value="<?= $promotion->date_debut ?>" placeholder="<?php echo $this->lang['date_deb']; ?>" style="width: 100%" autocomplete="off">&nbsp;&nbsp;
                    </div>
                    <div class="form-group col-lg-2 col-sm-2" class="form-group" style="width: 100%;padding: 10px;">
                        <label for="from2" class="control-label" ><?php echo $this->lang['date_fin']; ?> (*): </label><br/>
                        <input type="text" name="date_fin" required class="form-control" id="from2" value="<?= $promotion->date_fin ?>" placeholder="<?php echo $this->lang['date_deb']; ?>" style="width: 100%" autocomplete="off">&nbsp;&nbsp;
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="pourcentage_carte" class="control-label"><?php echo $this->lang['pourcentageCarte']; ?></label>
                        <input type="text" id="pourcentage_carte" name="pourcentage_carte" class="form-control" value="<?= $promotion->pourcentage_carte ?>" placeholder="<?php echo $this->lang['pourcentageCarte']; ?>"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="pourcentage_recharge" class="control-label"><?php echo $this->lang['pourcentageRecharge']; ?></label>
                        <input type="text" id="pourcentage_recharge" name="pourcentage_recharge" class="form-control" value="<?= $promotion->pourcentage_recharge ?>" placeholder="<?php echo $this->lang['pourcentageRecharge']; ?>"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>
                </div>

            </div>
            <input type="hidden" name="id" value="<?= base64_encode($promotion->id) ?>">

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


<script>
    $(document).ready(function() {
        $('#from1').datetimepicker({
                minDate: 0

            }

        );
        $('#from2').datetimepicker({
                minDate: 0
            }
        );
    });
</script>
