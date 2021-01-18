<div id="page-wrapper">
    <div class="container-fluid">
        <?php require_once (ROOT . 'app/views/template/notify.php'); ?>
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['gestion_rechargement']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'home/menu'; ?>">  <?php echo $this->lang['accueil']; ?></a></li>
                    <li><a href="<?= WEBROOT.'home/index'; ?>">  <?php echo $this->lang['gestion_rechargement']; ?></a></li>
                    <li class="active"><?php echo $this->lang['rechargement']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">

                    <!--<h3 class="box-title">Blank Starter page</h3> </div>-->

                    <div class="col-lg-12">
                        <h3 class="panel-title pull-right">
                            <button type="button" class="open-modal btn btn-success"
                                    data-modal-controller="distributeur/distrib/ajoutRechargementModal"
                                    data-modal-view="<?= base64_encode("distributeur") ?>/<?= base64_encode("ajoutRechargementModal") ?>">
                                <i class="fa fa-plus"></i> <?php echo $this->lang['ajout']; ?>
                            </button>
                        </h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <table class="table table-bordered table-hover table-responsive processing"
                                   data-url="<?= WEBROOT; ?>distrib/rechargementPro">
                                <thead>
                                <tr>
                                    <th> <?php echo $this->lang['date']; ?></th>
                                    <th> <?php echo $this->lang['num_transaction']; ?></th>
                                    <th><?php echo $this->lang['montant']; ?></th>
                                    <th><?php echo $this->lang['solde_avant']; ?></th>
                                    <th><?php echo $this->lang['solde_apres']; ?></th>
                                    <th><?php echo $this->lang['fait_par']; ?></th>

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








