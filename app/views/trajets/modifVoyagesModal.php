<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>trajets/updateVoyages" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modification_voyage']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["listedesbus"]?> </label>

                        <select id="bus_id" required name="bus_id" class="form-control" style="width: 100%">
                            <option value=""><?php echo $this->lang["selectionnerunbus"]?></option>

                            <?php foreach ($bus as $onebus) {?>
                                <option value="<?php echo $onebus->id; ?>" <?php if($onebus->id == $voyage->bus_id) echo "selected=selected"; ?>><?php echo $onebus->matricule ?></option>

                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["listedesconducteurs"]?></label>

                        <select id="conducteur_id<" required name="conducteur_id" class="form-control" style="width: 100%">
                            <option value=""> <?php echo $this->lang["selectionnerunconducteur"]?></option>

                            <?php foreach ($employe as $oneemploye) { ?>
                                <option value="<?php echo $oneemploye->id; ?>" <?php if($oneemploye->id == $voyage->conducteur_id) echo "selected=selected"; ?>><?php echo  $oneemploye->prenom,' ',$oneemploye->nom; ?></option>


                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["listedesreceveurs"]?></label>

                        <select id="receveur_id<" required name="receveur_id" class="form-control" style="width: 100%">
                            <option value=""><?php echo $this->lang["selectionnerunreceveur"]?></option>

                            <?php foreach ($utilisateur as $onerecev) { ?>
                                <option value="<?php echo $onerecev->id; ?>" <?php if($onerecev->id == $voyage->receveur_id) echo "selected=selected"; ?>><?php echo $onerecev->prenom,' ',$onerecev->nom; ?></option>

                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["listedescontroleurs"]?></label>

                        <select id="controleur_id<" required name="controleur_id" class="form-control" style="width: 100%">
                            <option value=""> <?php echo $this->lang["selectionnerunconducteur"]?></option>

                            <?php foreach ($controleur as $onecontro) { ?>
                                <option value="<?php echo $onecontro->id; ?>" <?php if($onecontro->id == $voyage->controleur_id) echo "selected=selected"; ?>><?php echo $onecontro->prenom,' ',$onecontro->nom; ?></option>

                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label">Liste des trajets</label>

                        <select id="trajet_id<" required name="trajet_id" class="form-control" style="width: 100%">
                            <option value=""><?php echo $this->lang["selectionneruntrajet"]?></option>

                            <?php foreach ($trajet as $onetraj) { ?>
                                <option value="<?php echo $onetraj->id; ?>" <?php if($onetraj->id == $voyage->trajet_id) echo "selected=selected"; ?>><?php echo $onetraj->lieu_depart,' ',$onetraj->lieu_arrive; ?></option>

                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="from" class="control-label"><?php echo $this->lang['date_voyage']; ?>(*): </label>
                        <input type="text" name="date_voyage" required class="form-control mydatepicker" id="from"
                               value="<?php echo $voyage->date_voyage; ?>"
                               placeholder="<?php echo $this->lang['date_voyage']; ?>" autocomplete="off" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    </div>
                <input type="hidden" name="id" value="<?= base64_encode($voyage->id) ?>">

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


    $(function () {
        $("#from").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });


    });

</script>




