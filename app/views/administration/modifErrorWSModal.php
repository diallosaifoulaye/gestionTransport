<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/updateErrorWS" method="post">

    <input type="hidden" id="date_modification" name="date_modification" value="<?= date('Y-m-d H:i:s'); ?>">
    <input type="hidden" id="user_modification" name="user_modification" value="<?= $this->_USER->id; ?>">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modif_error_ws']; ?></h4>
    </div>
    <div class="modal-body">

        <?php //echo var_dump($error_ws); die(); ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="code" class="control-label"><?php echo $this->lang['thlibCode']; ?></label>
                        <input type="text" id="code" name="code" value="<?php echo $error_ws->code ?>" class="form-control"
                               placeholder="<?php echo $this->lang['thlibCode']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="message_fr" class="control-label"><?php echo $this->lang['thlibFr']; ?></label>
                        <input type="text" id="message_fr" name="message_fr" value="<?php echo $error_ws->message_fr ?>" class="form-control"
                               placeholder="<?php echo $this->lang['thlibFr']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="message_en" class="control-label"><?php echo $this->lang['thlibEn']; ?></label>
                        <input type="text" id="message_en" name="message_en" value="<?php echo $error_ws->message_en ?>" class="form-control"
                               placeholder="<?php echo $this->lang['thlibEn']; ?>" style="width: 100%">
                        <span class="help-block with-errors"> </span>
                    </div>

                    <!--<div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_service" class="control-label"><?php /*echo $this->lang['thService']; */?></label>
                        <select required id="fk_service" name="fk_service" class="form-control" style="width: 100%">
                            <?php /*foreach ($serv as $oneServ) { */?>
                                <option value="<?php /*echo $oneServ->rowid; */?>" <?php /*if ($error_ws->fk_service == $oneServ->rowid) echo "selected=selected" */?> > <?php /*echo $oneServ->label; */?></option>
                            <?php /*} */?>
                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>-->

                    <!--                        --><?php// print $token; ?>
                    <input type="hidden" name="id" value="<?php echo base64_encode($error_ws->id) ?>">
                    <input type="hidden" name="fk_service" value="<?php echo $error_ws->fk_service; ?>">

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
