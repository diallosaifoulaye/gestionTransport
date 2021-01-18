<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/updateMessage" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modifMessage']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="droit" class="control-label"><?php echo $this->lang['expediteur']; ?></label>
                        <input type="text" id="expediteur" name="expediteur" class="form-control" placeholder="Expéditeur" style="width: 100%" value="<?php echo $message->expediteur; ?>" required >
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="controller" class="control-label"><?php echo $this->lang['message']; ?></label>
                        <textarea id="messenger" name="txt_messenger" class="form-control" style="width: 100%" required><?php echo $message->txt_messenger; ?></textarea>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang['listeModule']; ?></label>
                        <select required id="fk_module" name="fk_module" class="form-control" style="width: 100%">
                            <?php foreach ($module as $oneModule) { ?>
                                <option value="<?php echo $oneModule->id; ?>" <?php if($message->fk_module == $oneModule->id) echo "selected=selected" ?> > <?php echo $oneModule->libelle; ?></option>
                            <?php } ?>
                        </select>
                      <?php //print $token; ?>
                        <input type="hidden" name="id" value="<?php echo base64_encode($message->id) ?>">
                        <input type="hidden" name="date_modification" value="<?php echo date('Y-m-d H:i:s'); ?>">
                    </div>

                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?></button>
    </div>
</form>

