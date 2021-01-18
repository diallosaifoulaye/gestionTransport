<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>employe/updateControleur" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modifReceveur']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label"><?php echo $this->lang['nom']; ?></label>
                        <input type="text" id="nom" name="nom" value="<?= $controleur->nom ?>" class="form-control"
                               placeholder="Nom" style="width: 100%">
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="prenom" class="control-label"><?php echo $this->lang['prenom']; ?></label>
                        <input type="text" id="prenom" name="prenom" value="<?= $controleur->prenom ?>" class="form-control"
                               placeholder="Prenom" style="width: 100%">
                    </div>
                    <!--<div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="sous_module" class="control-label">Sous Module</label>
                        <input type="text" id="sous_module" name="sous_module"  value="<? /*= $droit->sous_module */ ?>" class="form-control" placeholder="Sous Module" style="width: 100%">
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label">Module</label>
                        <input type="text" id="module" name="module"  value="<? /*= $droit->module */ ?>" class="form-control" placeholder="Module" style="width: 100%">
                    </div>-->

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="controller" class="control-label"><?php echo $this->lang['adresse']; ?></label>
                        <input type="text" id="adresse" name="adresse" value="<?php echo $controleur->adresse ?>"


                               class="form-control" placeholder="Adresse" style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="email" class="control-label"><?php echo $this->lang['email']; ?></label>
                        <input type="email" id="email" name="email" value="<?php echo $controleur->email ?>"
                               class="form-control" placeholder="Email" style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="telephone" class="control-label"><?php echo $this->lang['telephone']; ?></label>
                        <input type="telephone" id="telephone" name="telephone" value="<?php echo $controleur->telephone ?>"
                               class="form-control" placeholder="Telephone" style="width: 100%">

                    </div>

                    <!--                        --><?php// print $token; ?>
                    <input type="hidden" name="id" value="<?php echo base64_encode($controleur->id) ?>">
                </div>
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
    $('input[type="telephone"]').intlTelInput({
        utilsScript: '<?= ASSETS;?>plugins/telPlug/js/utils.js',
        autoPlaceholder: true,
        preferredCountries: [ 'sn', 'gm', 'gb','ci'],
        initialDialCode: true,
        nationalMode: false
    });



</script>