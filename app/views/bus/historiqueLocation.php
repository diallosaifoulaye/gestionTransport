<div id="page-wrapper">
    <div class="container-fluid">
        <?php require_once (ROOT . 'app/views/template/notify.php'); ?>
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['gestion_location']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'home/menu'; ?>">  <?php echo $this->lang['accueil']; ?></a></li>
                    <li><a href="<?= WEBROOT.'administration/index'; ?>">  <?php echo $this->lang['administration']; ?></a></li>
                    <li class="active"><?php echo $this->lang['gestion_location']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">

                    <!--<h3 class="box-title">Blank Starter page</h3> </div>-->


                    <div class="row">
                        <div class="col-lg-12">

                            <h3 class="panel-title pull-right">
                                <a href="<?= WEBROOT.'location/imprimerHistoriqueBusLoueExcel'; ?>"  title="Exporter en excel" class=" btn btn-success fa fa-file-excel-o" style="color: #ffffff"></a>
                                <a href="<?= WEBROOT.'location/imprimerHistoriqueBusLouePdf'; ?>"  title="Exporter en pdf" class=" btn btn-success fa fa-file-pdf-o" style="color: #ffffff"></a>

                                <a href="<?= WEBROOT.'location/nouvelleLocation'; ?>" class=" btn btn-success" style="color: #ffffff">  <?php echo $this->lang['nouvelle_location']; ?></a>
                           </h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-hover table-responsive processing"
                                   data-url="<?= WEBROOT; ?>location/listeBusLoues">
                                <thead>
                                <tr>
                                    <th> <?php echo $this->lang['nom_locataire']; ?></th>
                                    <th><?php echo $this->lang['prenom_locataire']; ?></th>
                                    <th><?php echo $this->lang['telephone']; ?></th>
                                    <th><?php echo $this->lang['matriculeBus']; ?></th>
                                    <th><?php echo $this->lang['date_deb'];?></th>
                                    <th><?php echo $this->lang['date_fin']; ?></th>
                                    <th><?php echo $this->lang['montant']; ?></th>
                                    <th><?php echo $this->lang['etat']; ?></th>
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








