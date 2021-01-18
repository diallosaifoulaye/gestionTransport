<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>admin/updateRespo" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modifCategorie']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label"><?php echo $this->lang['labnom']; ?></label>
                        <input type="text" id="nomgie" name="nom" value="<?= $responsableGie->nom ?>" class="form-control"
                               placeholder="responsableGie" style="width: 100%">

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="prenom" class="control-label"><?php echo $this->lang['labprenom']; ?></label>
                        <input type="text" id="prenom" name="prenom" value="<?= $responsableGie->prenom ?>" class="form-control"
                               placeholder="responsableGie" style="width: 100%">

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="email" class="control-label"><?php echo $this->lang['labemail']; ?></label>
                        <input type="text" id="email" name="prenom" value="<?= $responsableGie->email ?>" class="form-control"
                               placeholder="responsableGie" style="width: 100%">

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="telephone class="control-label"><?php echo $this->lang['telephone']; ?></label>
                        <input type="text" id="telephone" name="telephone" value="<?= $responsableGie->telephone ?>" class="form-control"
                               placeholder="responsableGie" style="width: 100%">

                    </div>

                </div>
                <input type="hidden" name="id" value="<?= base64_encode($responsableGie->id) ?>">

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

