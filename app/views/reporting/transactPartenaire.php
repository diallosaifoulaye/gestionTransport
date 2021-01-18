
<div id="page-wrapper">
    <div class="container-fluid">
        <?php require_once (ROOT . 'app/views/template/notify.php'); ?>

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['reportingPartenaire']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'home/menu'; ?>">  <?php echo $this->lang['accueil']; ?></a></li>
                    <li><a href="<?= WEBROOT.'reporting/index'; ?>">  <?php echo $this->lang['reporting']; ?></a></li>
                    <li class="active"><?php echo $this->lang['reportingPartenaire']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="white-box">

                    <div class="row bg-title">

                        <form class="form-horizontal" method="POST" action="<?php echo WEBROOT ?>reporting/transactPartenaire">
                            <div class="col-md-1"></div>

                            <div class="form-group col-lg-2 col-sm-2">
                                <label for="from" class="control-label" ><?php echo $this->lang['date_deb']; ?> (*): </label>
                                <input type="text" name="datedeb" required class="form-control mydatepicker" id="from"
                                       value="<?php echo $date_debut ?>" placeholder="<?php echo $this->lang['date_deb']; ?>" autocomplete="off">&nbsp;&nbsp;
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-md-1" style="width: 4%"></div>

                            <div class="form-group col-lg-2 col-sm-2">
                                <label for="from" class="control-label" ><?php echo $this->lang['date_fin']; ?> (*): </label>
                                <input type="text" name="datefin" required class="form-control mydatepicker" id="to"
                                       value="<?php echo $date_fin ?>" placeholder="<?php echo $this->lang['date_fin']; ?>" autocomplete="off">
                            </div>

                            <div class="col-md-1" style="width: 4%"></div>
                            <div class="form-group col-lg-2 col-sm-2">
                                <label for="from" class="control-label"><?php echo $this->lang['listPartenaire']; ?></label>

                                <select id="fk_partenaire" name="fk_partenaire" class="form-control select2">
                                    <option value=""> <?php echo $this->lang['select_partenaire']; ?></option>
                                    <?php foreach ($liste_part as $onelistepart) { ?>
                                        <option value="<?php echo $onelistepart->rowid; ?>"<? if ($part == $onelistepart->rowid) echo "selected=selected" ?>> <?php echo $onelistepart->raison_sociale; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-1" style="width: 4%"></div>

                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success btn-circle btn-lg" title="Rechercher"><i
                                            class="ti-search"></i></button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="white-box">

                    <div class="panel-heading" style="height: 55px; background-color: #2f5088">
                        <div class="col-md-11"><h3 class="panel-title pull-left" style="color: white;"> <?php echo $this->lang['transactionprpart'] ?> </h3>
                        </div>

                        <div class="col-md-1">

                            <form method="post" id="loadform" action="<?php echo WEBROOT ?>reporting/impressionTransactionPart" target="_blank">
                                <input type="hidden" name="datedeb" value="<?= $this->data['datedeb']; ?>">
                                <input type="hidden" name="datefin" value="<?= $this->data['datefin']; ?>">
                                <input type="hidden" name="fk_partenaire" value="<?= $part; ?>">

                                <button name="PDF" type="submit" value="PDF" style="background-color:transparent;border: 0px;" id="topdf" title="<?php echo $this->lang['imprimer']; ?>">
                                    <i class="fa fa-2x fa-file-pdf-o" style="color: #e86010"></i>
                                </button>
                            </form>

                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-hover table-responsive processing"
                                   data-url="<?= WEBROOT; ?>reporting/transactPartenairePro__/<?php echo $part; ?>/<?php echo $datedeb; ?>/<?php echo $datefin; ?>">
                                <thead>
                                <tr>
                                    <th> <?php echo $this->lang['num_transaction']; ?></th>
                                    <th><?php echo $this->lang['date_transaction']; ?></th>
                                    <th><?php echo $this->lang['montant_transact']; ?></th>
                                    <th><?php echo $this->lang['commission']; ?></th>
                                    <th><?php echo $this->lang['thService']; ?></th>
                                    <th><?php echo $this->lang['labAction']; ?></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>




<script>
    $(".select2").select2();
</script>


