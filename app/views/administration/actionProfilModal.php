<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form" action="<?= WEBROOT ?>administration/ajoutDroitProfil" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['action_profil_autorise']. ' : <b>' .$profil->profil.'</b>' ; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">

                    <div class="box-body">

                        <?php foreach($module as $mod){?>

                            <div class="padding_box">
                                <div class="row">
                                    <dl>
                                        <dt style="padding: 15px 0px 0px 0px;"><?= $mod->libelle; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type="checkbox" class="check<?= $mod->id; ?>" id="checkAll<?= $mod->id; ?>"> <?= $this->lang['select_all'] ; ?></dt>
                                    </dl>
                                </div>
                                <div class="row" style="margin-top: -13px;">
                                    <dl>
                                        <dd>
                                            <?php

                                            $allActions = \app\core\Utils::getModel('Profil')->allActionsByModule($mod->id);

                                            foreach($allActions as $action){ ?>

                                                <div class="checkbox checkbox-success checkbox-circle col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-top: 0px;">
                                                    <input class="check<?= $mod->id; ?>" type="checkbox" name="fk_droit[]" value="<?= $action->id; ?>" id="checkbox-10" <?php if(in_array($action->id, $actions_autorisees)) echo 'checked' ?> /><label for="checkbox"><?= $action->droit; ?></label>
                                                </div>


                                            <?php } ?>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                    <input type="hidden" name="fk_profil" value="<?= $profil->id; ?>">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
        <button class="btn btn-danger" type="button" data-dismiss="modal"> <i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>
</form>
<script>
    <?php foreach($module as $module2){?>

    $("#checkAll<?= $module2->id; ?>").click(function () {
        $(".check<?= $module2->id; ?>").prop('checked', $(this).prop('checked'));

    });

    <?php } ?>
</script>