<?php
/**
 * Created by PhpStorm.
 * User: bayedame
 * Date: 31/08/2018
 * Time: 10:57
 */
?>



<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?= $this->lang['detailTrajets']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'menu/menu'; ?>"><?= $this->lang['accueil']; ?></a></li>

                    <li><a href="<?= WEBROOT.'trajets/trajets'; ?>"><?= $this->lang['trajet']; ?></a></li>

                    <li class="active"><?= $this->lang['detailTrajets']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <div class="white-box">
                    <!--                    <div class="user-bg"> <img width="100%" alt="user" src="../plugins/images/large/img1.jpg"> </div>-->

                    <div class="col-sm-7" align="center"> <img class="img-circle" width="200"  > </div>
                    <div class="user-btm-box">
                        <!-- .row    -->
                        <div class="row text-center m-t-10">
                            <div class="col-md-6 b-r"><strong><?= $this->lang['ligne']; ?></strong>
                                <p><?= $trajet->ligne; ?></p>
                            </div>
                            <div class="col-md-6 b-r"><strong><?= $this->lang['lieu_depart']; ?></strong>
                                <p><?= $trajet->lieu_depart; ?></p>
                            </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->
                        <div class="row text-center m-t-10">

                            <div class="col-md-6"><strong><?= $this->lang['lieu_arrive']; ?></strong>
                                <p><?= $trajet->lieu_arrive; ?></p>
                            </div>
                            <div class="col-md-6"><strong><?= $this->lang['nombre_section']; ?></strong>
                                <p><?= $trajet->nombre_section; ?></p>
                            </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->
                        <div class="row text-center m-t-10">

                            <div class="col-md-6"><strong><?= $this->lang['ecart_section']; ?></strong>
                                <p><?= $trajet->ecart_section; ?></p>
                            </div>
                            <div class="col-md-6"><strong><?= $this->lang['prix_base']; ?></strong>
                                <p><?= $trajet->prix_base; ?></p>
                            </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->
                        <!-- <div class="row text-center m-t-10">

                                <div class="col-md-6"><strong><?/*= $this->lang['etat']; */?></strong>
                                    <p><?/*= $trajet->etat; */?></p>
                                </div>

                            </div>-->

                        <hr>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="white-box">
                    <!-- .tabs -->
                    <ul class="nav nav-tabs tabs customtab">
                        <li class="active tab">
                            <a href="#home" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['itineraire']; ?></span> </a>
                        </li>
                    </ul>
                    <!-- /.tabs -->
                    <div class="tab-content">
                        <!-- .tabs3 -->
                        <div class="tab-pane active" id="home">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h3 class="panel-title pull-right">

                                        <button type="button" class="open-modal btn btn-success"
                                                data-modal-controller="trajets/nouveauPointModal"
                                                data-modal-view="<?= base64_encode("trajets") ?>/<?= base64_encode("nouveauPointModal") ?>"
                                                data-modal-param="<?php echo base64_encode($trajet->id)?>">
                                            <i class="fa fa-plus"></i> <?php echo $this->lang['nouveauPoint']; ?>
                                        </button>

                                        <!-- <button type="button" class="open-modal btn btn-success"
                                                 data-modal-controller="trajets/nouveauPointModal/<?/*= base64_encode($trajet->id)*/?>"
                                                 data-modal-view="<?/*= base64_encode("trajets") */?>/<?/*= base64_encode("nouveauPointModal") */?>">
                                             <i class="fa fa-plus"></i> <?php /*echo $this->lang['nouveauPoint']; */?>
                                         </button>-->
                                    </h3>
                                </div>
                            </div>

                            <div class="row">
                            <table class="table table-bordered table-hover table-responsive processing"
                                   data-url="<?= WEBROOT; ?>trajets/itineraire/<?php echo base64_encode($trajet->id)?>">
                                <thead>
                                <tr>
                                    <th> <?php echo $this->lang['itineraire']; ?></th>
                                    <th><?php echo $this->lang['longitude']; ?></th>
                                    <th><?php echo $this->lang['latitude']; ?></th>
                                    <th><?php echo $this->lang['labAction']; ?></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.tabs3 -->

                        <!-- /.tabs3 -->
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





