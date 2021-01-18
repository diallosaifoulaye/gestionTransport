<form id="validation" class="form-inline form-validator" data-type="update" role="form"
      name="form" action="<?= WEBROOT ?>gestion/insertAffectMateriel" method="post" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['ajoutAffectMateriel']; ?></h4>
    </div>
    <div class="modal-body">
       <!-- --><?php /*var_dump($module); die(); */?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["bus"]?></label>

                        <select id="bus_id" name="bus_id" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang["selectionnerunbus"]?></option>

                            <?php foreach ($bus as $oneBus) { ?>
                                <option value="<?php echo $oneBus->id; ?>"> <?php echo $oneBus->matricule; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["receveur"]?></label>

                        <select id="receveur" name="receveur_rowid" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang["Selectionnezunreceveur"]?></option>

                            <?php foreach ($receveur as $oneReceveur) { ?>
                                <option value="<?php echo $oneReceveur->id; ?>"> <?php echo $oneReceveur->nom,' ' ,$oneReceveur->prenom; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["carte_receveur"]?></label>

                        <select id="id_carte_receveur" name="id_carte_receveur" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang["selectionnerunecarte"]?></option>

                            <?php foreach ($carteReceveur as $val) { ?>
                                <option value="<?php echo $val->id; ?>"> <?php echo $val->libelle; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["chauffeur"]?></label>

                        <select id="chauffeur" name="chauffeur_id" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang["Selectionnezunchauffeur"]?></option>

                            <?php foreach ($chauffeur as $oneChauffeur) { ?>
                                <option value="<?php echo $oneChauffeur->id; ?>"> <?php echo $oneChauffeur->nom,' ' ,$oneChauffeur->prenom; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["carte_chauffeur"]?></label>

                        <select id="id_carte_chauffeur" name="id_carte_chauffeur" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang["selectionnerunecarte"]?></option>

                            <?php foreach ($carteChauffeur as $val) { ?>
                                <option value="<?php echo $val->id; ?>"> <?php echo $val->libelle; ?></option>
                            <?php } ?>
                        </select>

                    </div>


                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["materiel"]?></label>

                        <select id="materiel" name="materiel" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang["Selectionnezunmateriel"]?></option>

                            <?php foreach ($materiel as $oneMateriel) { ?>
                                <option value="<?php echo $oneMateriel->rowid.'-'.$oneMateriel->uuid; ?>"> <?php echo $oneMateriel->nom.' ('.$oneMateriel->uuid.' - '.$oneMateriel->model. ' - '.$oneMateriel->manufacture.')'; ?></option>
                            <?php } ?>
                        </select>

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["trajet"]?></label>

                        <select id="trajet_id" name="trajet_id" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang["selectionneruntrajet"]?></option>

                            <?php foreach ($trajet as $onetrajet) { ?>
                                <option value="<?php echo $onetrajet->id; ?>"> <?php echo $onetrajet->lieu_depart,' ' ,$onetrajet->lieu_arrive; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="from" class="control-label"><?php echo $this->lang['date_debut_affect']; ?>(*): </label>
                        <input type="text" name="date_debut_affect" required class="form-control mydatepicker" id="from"
                               placeholder="<?php echo $this->lang['date_debut_affect']; ?>" autocomplete="off" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="from" class="control-label"><?php echo $this->lang['date_fin_affect']; ?></label>
                        <input type="text"  name="date_fin_affect" class="form-control mydatepicker" id="to"
                               placeholder="<?php echo $this->lang['date_fin_affect']; ?>" autocomplete="off" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
        <button class="btn btn-default" type="button" data-dismiss="modal"> <i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>
</form>

<script>
    $(".select2").select2();
</script>
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



        $("#to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#from").datepicker("option", "maxDate", selectedDate);
            }
        });
    });



</script>

