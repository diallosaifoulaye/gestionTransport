<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form" action="<?= WEBROOT ?>administration/ajoutDispoService" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['dispo_service'].' : <b>'.$dispo->label.'</b> '.$this->lang['est_dispo'].'</b>' ; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">

                    <div class="box-body">

                        <?php //echo var_dump($dispo); die(); ?>


                            <!--<div class="padding_box">

                                <div class="row">
                                <dl>
                                    <dt style="padding: 15px 0px 0px 0px;"><?php /*echo $this->lang['pays']. ' : <b>' .'</b>' ; */?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </dt>
                                </dl>
                            </div>-->

                                <br>
                                <br>
                                <div class="row" style="margin-top: -13px;">
                                    <dl>
                                        <dd>
                                            <?php

                                            $allPays = $pays;

                                            foreach($allPays as $pays){ ?>

                                                <div class="checkbox checkbox-success checkbox-circle col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-top: 0px; margin-bottom: 12px">
                                                    <input class="check<?= $pays->rowid; ?>" type="checkbox" name="fk_pays[]" value="<?= $pays->rowid; ?>" id="checkbox-10" <?php if(in_array($pays->rowid, $service_disponibles)) echo 'checked' ?> /><label for="checkbox"><?= $pays->label; ?></label>
                                                </div>


                                            <?php } ?>
                                        </dd>
                                    </dl>
                                </div>
                    </div>


                    </div>
                    <input type="hidden" name="rowid" value="<?= $dispo->rowid; ?>">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
        <button class="btn btn-default" type="button" data-dismiss="modal"> <i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>
</form>
<script>
    <?php foreach($service as $service2){?>

    $("#checkAll<?= $service2->rowid; ?>").click(function () {
        $(".check<?= $service2->rowid; ?>").prop('checked', $(this).prop('checked'));

    });

    <?php } ?>
</script>