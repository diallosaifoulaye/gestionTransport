<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>client/updateClient" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modifClient']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="email" class="control-label"><?php echo $this->lang['num_serie'].' (*) :'; ?></label>
                        <input type="number" id="numcarte" value="<?= $client->numcarte ?>" name="numcarte" class="form-control" onchange="verifCarte()" placeholder="<?php echo $this->lang['num_serie']; ?>"
                               style="width: 100%">
                        <span id="msg3"></span>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="prenom" class="control-label"><?php echo $this->lang['prenom'].' (*) :'; ?></label>
                        <input type="text" id="prenom"  value="<?= $client->prenom ?>" name="prenom" class="form-control" placeholder="<?php echo $this->lang['prenom']; ?>"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label"><?php echo $this->lang['nom'].' (*) :'; ?></label>
                        <input type="text" id="nom" name="nom" value="<?= $client->nom ?>" class="form-control" placeholder="<?php echo $this->lang['nom']; ?>"
                               style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="email" class="control-label"><?php echo $this->lang['email'].' (*) :'; ?></label>
                        <input type="email" id="email" name="email" value="<?= $client->email ?>" class="form-control" onchange="verifEmail()" placeholder="<?php echo $this->lang['email']; ?>"
                               style="width: 100%">
                        <span id="msg2"></span>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="controller" class="control-label"><?php echo $this->lang['telephone'].' (*) :'; ?></label>
                        <input type="tel" id="tel" name="telephone" value="<?= $client->telephone ?>"  class="form-control" placeholder="<?php echo $this->lang['telephone']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <input type="hidden" name="id" value="<?= base64_encode($client->id) ?>">


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
