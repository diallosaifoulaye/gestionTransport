        <div id="page-wrapper">
            <div class="container-fluid">
                <?php require_once (ROOT . 'app/views/template/notify.php'); ?>
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Gestion des trajets</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                        <ol class="breadcrumb">
                            <li><a href="<?= WEBROOT.'home/menu'; ?>">  <?php echo $this->lang['accueil']; ?></a></li>
                            <li><a href="<?= WEBROOT.'voyages/voyages'; ?>">  <?php echo $this->lang['voyages']; ?></a></li>
                            <li class="active">Gestion des trajets</li>
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
                                    <button type="button" class="open-modal btn btn-success"
                                            data-modal-controller="voyages/ajoutVoyagesModal"
                                            data-modal-view="<?= "voyages/ajoutVoyagesModal"; ?>">
                                        <i class="fa fa-plus"></i> <?php echo $this->lang['newvoyages']; ?>
                                    </button>
                                </h3>
                            </div>
                            </div>

                            <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-hover table-responsive processing"
                                       data-url="<?= WEBROOT; ?>trajets/voyagesPro">
                                    <thead>
                                    <tr>
                                        <th> <?php echo $this->lang['matricule']; ?></th>
                                        <th><?php echo $this->lang['conducteur']; ?></th>
                                        <th><?php echo $this->lang['receveur']; ?></th>
                                        <th><?php echo $this->lang['controleur']; ?></th>
                                        <th><?php echo $this->lang['ligne']; ?></th>
                                        <th><?php echo $this->lang['datevoyage']; ?></th>
                                        <th><?php echo $this->lang['etat']; ?></th>
                                        <th><?php echo $this->lang['action']; ?></th>
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








