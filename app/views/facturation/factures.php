        <div id="page-wrapper">
            <div class="container-fluid">
                <?php require_once (ROOT . 'app/views/template/notify.php'); ?>
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"><?php echo $this->lang['ges_facturation']; ?></h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                        <ol class="breadcrumb">
                            <li><a href="<?= WEBROOT.'home/menu'; ?>">  <?php echo $this->lang['accueil']; ?></a></li>
                            <li><a href="<?= WEBROOT.'facturation/facture'; ?>">  <?php echo $this->lang['factures']; ?></a></li>
                            <li class="active"><?php echo $this->lang['factures']; ?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row white-box">
                    <div class="col-lg-12">
                        <!--  <a href="<?/*= WEBROOT*/?>versement/export/<?php /*echo $datedebut; */?>/<?php /*echo $datefin; */?>/<?php /*echo $collecteurT; */?>" target="_blank" class="btn btn-plus pull-right m-l-20  waves-effect waves-light" >
                                <i class="fa fa-file-pdf-o"></i> <?/*= $this->lang['export']; */?>
                            </a>-->
                        <table class="table table-bordered table-hover table-responsive processing"
                               data-url="<?= WEBROOT; ?>facturation/facturesProcessing">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang['periode']; ?></th>
                                <th><?php echo $this->lang['date_facturation']; ?></th>
                                <th><?php echo $this->lang['date_reglement']; ?></th>
                                <th style="text-align: right"><?php echo $this->lang['montant']; ?> ( <?php echo $this->lang['lrd'] ?>)</th>
                                <th style="text-align: center"><?php echo $this->lang['montant_regle']; ?>( <?php echo $this->lang['lrd'] ?>)</th>
                                <th><?php echo $this->lang['labetat']; ?></th>
                                <th><?php echo $this->lang['labAction']; ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>

        </div>








