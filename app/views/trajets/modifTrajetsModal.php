<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>trajets/updateTrajets" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modification_Trajets']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang["listedesligne"]?></label>

                        <select id="ligne" name="ligne" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang["selectionneruneligne"]?></option>

                            <?php foreach ($ligne as $oneligne) { ?>
                                <option value="<?php echo $oneligne->id; ?>"> <?php echo $oneligne->libelle; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="lieu_depart" class="control-label"><?php echo $this->lang['lieu_depart']; ?></label>
                        <input type="text" id="lieu_depart" name="lieu_depart" value="<?= $trajet->lieu_depart ?>" class="form-control"
                               placeholder="<?php echo $this->lang['trajet']; ?>" style="width: 100%">
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="lieu_arrive" class="control-label"><?php echo $this->lang['lieu_arrive']; ?></label>
                        <input type="text" id="lieu_arrive" name="lieu_arrive" value="<?= $trajet->lieu_arrive ?>" class="form-control"
                               placeholder="<?php echo $this->lang['trajet']; ?>" style="width: 100%">
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nombre_section" class="control-label"><?php echo $this->lang['nombre_section']; ?></label>
                        <input type="text" id="nombre_section" name="nombre_section" value="<?= $trajet->nombre_section ?>" class="form-control"
                               placeholder="<?php echo $this->lang['trajet']; ?>" style="width: 100%">
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="ecart_section" class="control-label"><?php echo $this->lang['ecart_section']; ?></label>
                        <input type="text" id="ecart_section" name="ecart_section" value="<?= $trajet->ecart_section ?>" class="form-control"
                               placeholder="<?php echo $this->lang['trajet']; ?>" style="width: 100%">
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="prix_base" class="control-label"><?php echo $this->lang['prix_base']; ?></label>
                        <input type="text" id="prix_base" name="prix_base" value="<?= $trajet->prix_base ?>" class="form-control"
                               placeholder="<?php echo $this->lang['trajet']; ?>" style="width: 100%">
                    </div>



                    </div>
                <input type="hidden" name="id" value="<?= base64_encode($trajet->id) ?>">

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
    $(".select2").select2();
</script>

