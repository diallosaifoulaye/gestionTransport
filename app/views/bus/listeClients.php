<div id="page-wrapper">
    <?php
        //echo '<pre>';
        //var_dump($nbreResVal);die;
    ?>
    <div class="container-fluid">
        <?php require_once (ROOT . 'app/views/template/notify.php'); ?>
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['listeClient']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'home/menu'; ?>">  <?php echo $this->lang['accueil']; ?></a></li>
                    <li><a href="<?= WEBROOT.'administration/index'; ?>">  <?php echo $this->lang['administration']; ?></a></li>
                    <li class="active"><?php echo $this->lang['liste']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">

            <div class="col-md-12">
                <div class="white-box">

                    <!--<h3 class="box-title">Blank Starter page</h3> </div>-->

<!--                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="panel-title pull-right">
                                <button type="button" class="open-modal btn btn-success"
                                        data-modal-controller="bus/ajoutBusModal"
                                        data-modal-view="<?/*= base64_encode("bus") */?>/<?/*= base64_encode("ajoutBusModal") */?>">
                                    <i class="fa fa-plus"></i> <?php /*echo $this->lang['newBus']; */?>
                                </button>
                            </h3>
                        </div>
                    </div>
-->
                   <div class="row">
                        <div class="col-lg-12">

                            <table class="table table-bordered table-hover table-responsive processing"
                                   data-url="<?= WEBROOT; ?>location/listeclients">
                                <thead>
                                <tr>
                                    <th> <?php echo $this->lang['nom_locataire']; ?></th>
                                    <th><?php echo $this->lang['prenom_locataire']; ?></th>
                                    <th><?php echo $this->lang['piece_identite']; ?></th>
                                    <th><?php echo $this->lang['intermediaire']; ?></th>
                                    <th><?php echo $this->lang['telephone']; ?></th>
                                   <th ><?php echo $this->lang['nombreReservationValidee'];?></th>
                                   <th><?php echo $this->lang['nombreReservationAnnulee'];?></th>
                                   <!-- <th><?php /*echo $this->lang['labAction']; */?></th>-->
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








