
<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>location/updateBusLoue" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modifBusloue']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label"><?php echo $this->lang['nom']; ?></label>
                        <input type="text" id="nom_locataire" name="nom_locataire" class="form-control" value="<?= $busLoue->nom_locataire ?>" placeholder="Veuillez entrer le nom du locataire"
                               style="width: 100%" required >
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="prenom" class="control-label"><?php echo $this->lang['prenom']; ?></label>
                        <input type="text" id="prenom_locataire" name="prenom_locataire" class="form-control" value="<?= $busLoue->prenom_locataire ?>" placeholder="Veuillez entrer le prenom du locataire"
                               style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="piece_identite" class="control-label"><?php echo $this->lang['piece_identite']; ?></label>
                        <input type="text" name="piece_identite" class="form-control"  id="piece_identite" value="<?= $busLoue->piece_identite ?>"
                               placeholder="<?php echo $this->lang['piece_identite']; ?>"  style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="address" class="control-label"><?php echo $this->lang['labadresse']; ?></label>
                        <textarea rows="4" cols="50" id="adresse" name="adresse" class="form-control"   required ><?php echo $busLoue->adresse ?>
                            </textarea>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="telephone" class="control-label"><?php echo $this->lang['telephone']; ?></label>
                        <input type="telephone" id="telephone" name="telephone" class="form-control" value="<?= $busLoue->telephone ?>" placeholder="Veuillez entrer le telephone"
                               style="width: 100%" required onclick="myFunction1(this.value);">
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <p style="size: 250px">
                            Particulier &nbsp<input type="radio" id="intermediaire" name="intermediaire" value="particulier" <?php if($busLoue->intermediaire === 'particulier')  echo 'checked'?> onchange="myFunction1(this.value);">
                            &nbsp;&nbsp;&nbsp;&nbsp
                            Tiers &nbsp<input type="radio" id="intermediaire" name="intermediaire" value="tiers" <?php if($busLoue->intermediaire === 'tiers')  echo 'checked'?> onchange="myFunction1(this.value);">
                        </p>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px; <?php if($busLoue->intermediaire === 'particulier') echo 'display: none'; else echo 'display: block'?>" id="test">
                        <label for="tiers" class="control-label" id="labelTiers"><?php echo $this->lang['entrepriseName']; ?></label>
                        <input type="text" id="nom_entreprise" name="nom_entreprise" class="form-control" value="<?= $busLoue->nom_entreprise ?>" style="width: 100%;" >
                    </div>

                    <div class="form-group column" style="width: 100%;padding: 10px;">
                        <label for="date_reservation" class="control-label"><?php echo $this->lang['date_reservation']; ?></label>
                        <input id="from1" name="date_reservation" type="text" class="form-control"
                               value="<?php echo date("Y-m-d"); ?>" onchange="myFunction1(this.value);" required>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="date_deb" class="control-label"><?php echo $this->lang['date_debut']; ?></label>

                        <input id="from2" name="date_deb" class="form-control" type="text"  placeholder="<?php echo $this->lang['date_deb']; ?>"
                               onchange="myFunction(this.value);" value="<?php echo date("Y-m-d"); ?>" required>

                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="date_fin" class="control-label "><?php echo $this->lang['date_fin']; ?></label>
                        <input id="from3" name="date_fin" class="form-control" type="text"  placeholder="<?php echo $this->lang['date_fin']; ?>"
                               onchange="myFunction(this.value);" required>

                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <input type="hidden" id="price_by_day" name="price_by_day" class="form-control" value="<?= $busLoue->price_by_day ?>" placeholder="Veuillez entrer le nom du locataire"
                               style="width: 100%" required >
                        <span class="help-block with-errors"> </span>
                    </div>

                </div>
                <input type="hidden" name="id" value="<?= base64_encode($busLoue->id) ?>" >


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
                minTime:0
            }

        );
        $('#from2').datetimepicker({
                minDate: 0
            }
        );
        $('#from3').datetimepicker(
            {
                minDate: '+1970/01/02'
            }
        );
    });

    function myFunction1() {

        var choixIntermediaire = document.querySelector('input[name="intermediaire"]:checked').value;
       //alert(choixIntermediaire)
        if (choixIntermediaire == 'tiers'){
            document.getElementById("test").style.display = "block";
            //document.getElementById("nom_entreprise").style.display = "block";
        }else{
            document.getElementById("test").style.display = "none";

        }
    }
</script>