<?php
/**
 * Created by PhpStorm.
 * User: bayedame
 * Date: 31/08/2018
 * Time: 10:57
 */
use app\core\Utils;
?>

<style>
    /*!*CSS HISTOGRAMME*!
    .order-card {
        color: #fff;
    }

    .bg-c-blue {
        background: linear-gradient(45deg,#4099ff,#73b4ff);
    }

    .bg-c-green {
        background: linear-gradient(45deg,#2ed8b6,#59e0c5);
    }

    .bg-c-yellow {
        background: linear-gradient(45deg,#FFB64D,#ffcb80);
    }

    .bg-c-pink {
        background: linear-gradient(45deg,#FF5370,#ff869a);
    }
*/

   /* .card {
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
        box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
        border: none;
        margin-bottom: 30px;
        -webkit-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    .card .card-block {
        padding: 25px;
        height:175px;
    }

    .order-card i {
        font-size: 26px;
    }

    .f-left {
        float: left;
    }

    .f-right {
        float: right;
    }*/

    .my-card
    {
        position:absolute;
        left:40%;
        top:-20px;
        border-radius:50%;
    }

</style>


<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?= $this->lang['detailClient']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'menu/menu'; ?>"><?= $this->lang['accueil']; ?></a></li>

                    <li><a href="<?= WEBROOT.'client/liste'; ?>"><?= $this->lang['listeClients']; ?></a></li>

                    <li class="active"><?= $this->lang['detailClient']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">

            <div class="col-md-12 col-xs-12">
                <div class="white-box">
                    <!-- .tabs -->
                    <ul class="nav nav-tabs tabs customtab">
                        <li class=" tab active">
                            <a href="#info" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['info_client']; ?></span> </a>
                        </li>
                        <li class="tab">
                            <a href="#home" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['historiqueDeCarte']; ?></span> </a>
                        </li>
                        <li class="tab">
                            <a href="#activationBlocage" data-toggle="tab" aria-expanded="false"> <span class="visible-xs">
                                    <i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['historiqueRecharge']; ?></span> </a>
                        </li>


                    </ul>
                    <!-- /.tabs -->
                    <div class="tab-content">
                        <!-- .tabs3 -->

                        <div class="tab-pane active" id="info">
                            <div class="row">
                                <div class="white-box col-md-6" >
                                    <div class="user-btm-box">
                                        <h4><?= $this->lang['InformtationPointDistributeur']; ?></h4>
                                        <br/>
                                        <div class="row text-center m-t-6">
                                            <div class="col-md-5 b-r"><strong><?= $this->lang['nomPoint']; ?></strong>
                                                <p><?= $distributeur->nom_point; ?></p>
                                            </div>
                                            <div class="col-md-5"><strong><?= $this->lang['email']; ?></strong>
                                                <p><?= $distributeur->email_point; ?></p>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                        <hr>
                                        <!-- .row -->
                                        <div class="row text-center m-t-6">
                                            <div class="col-md-5 b-r"><strong><?= $this->lang['telephone']; ?></strong>
                                                <p><?= $distributeur->telephone_point; ?></p>
                                            </div>
                                            <div class="col-md-5"><strong><?= $this->lang['adresse']; ?></strong>
                                                <p><?= $distributeur->adresse_point; ?></p>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                        <hr>
                                        <!-- <div class="row text-center m-t-6">
                                            <div class="col-md-5 b-r"><strong><?/*= $this->lang['region']; */?></strong>
                                                <p><?/*= $distributeur->label; */?></p>
                                            </div>
                                            <div class="col-md-5"><strong><?/*= $this->lang['adresse']; */?></strong>
                                                <p><?/*= $distributeur->adresse_point; */?></p>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                    </div>



                                </div>
                                <div class="white-box col-md-6">
                                    <div class="user-btm-box">
                                        <h4><?= $this->lang['InformtationResponsableDistribution']; ?></h4>
                                        <br/>
                                        <div class="row text-center m-t-6">
                                            <div class="col-md-5 b-r"><strong><?= $this->lang['prenom']; ?></strong>
                                                <p><?= $distributeur->prenom_agent; ?></p>
                                            </div>
                                            <div class="col-md-5"><strong><?= $this->lang['nom']; ?></strong>
                                                <p><?= $distributeur->nom_agent; ?></p>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                        <hr>
                                        <!-- .row -->
                                        <div class="row text-center m-t-6">
                                            <div class="col-md-5 b-r"><strong><?= $this->lang['email']; ?></strong>
                                                <p><?= $distributeur->email_agent; ?></p>
                                            </div>
                                            <div class="col-md-5"><strong><?= $this->lang['telephone']; ?></strong>
                                                <p><?= $distributeur->telephone_agent; ?></p>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                        <hr>
                                        <!-- .row -->
                                        <div class="row text-center m-t-6">
                                            <div class="col-md-5 b-r"><strong><?= $this->lang['labLogin']; ?></strong>
                                                <p><?= $distributeur->login; ?></p>
                                            </div>
                                            <div class="col-md-5 b-r"><strong><?= $this->lang['thEtat']; ?></strong>
                                                <?php
                                                if ($distributeur->etat == 1 ){?>
                                                    <p><?=$this->lang['active']; ?></p>

                                                <?}else{?>
                                                    <p><?= $this->lang['desactive']; ?></p>
                                                <?}?>

                                            </div>
                                        </div>
                                        <!-- /.row -->
                                        <hr>
                                        <!-- .row -->
                                        <hr>
                                    </div>
                                </div>
                            </div>



                        </div>



                        <div class="tab-pane " id="home">
                            <div class="row bg-title">
<!--                                <form class="form-horizontal" method="POST" action="<?/*= WEBROOT */?>distri/venteCarteByDate">
                                    <div class="col-md-1"></div>

                                    <div class="form-group col-lg-2 col-sm-2">
                                        <label for="from" class="control-label" ><?php /*echo $this->lang['date_deb']; */?> (*): </label>
                                        <input type="text" name="date_deb" class="form-control mydatepicker" id="from"
                                               value="<?php /*echo $date_deb */?>" placeholder="<?php /*echo $this->lang['date_deb']; */?>" autocomplete="off">&nbsp;&nbsp;
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="col-md-1" style="width: 4%"></div>

                                    <div class="form-group col-lg-2 col-sm-2">
                                        <label for="from1" class="control-label" ><?php /*echo $this->lang['date_finn']; */?> (*): </label>
                                        <input type="text" name="date_fin" class="form-control mydatepicker" id="from1"
                                               value="<?php /*echo $date_fin */?>" placeholder="<?php /*echo $this->lang['date_finn']; */?>" autocomplete="off">
                                    </div>
                                    <div class="col-md-1" style="width: 4%"></div>

                                    <div class="col-md-1" style="width: 4%"></div>

                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-success btn-circle btn-lg" title="Rechercher"><i
                                                    class="ti-search"></i></button>
                                    </div>
                                </form>
-->                            </div>
                            <div class="jumbotron" >
                                <div class="row w-100">
                                    <div class="col-md-3">
                                        <div class="card border-info mx-sm-1 p-4">
                                            <div class="text-info text-center mt-3"><h4><?php echo $this->lang['nbreCarteVendu'];?></h4></div>
                                            <div class="text text-center mt-2"><h1><?php if($nbreCarte==0) echo 0; else echo $nbreCarte; ?></h1></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-success mx-sm-1 p-4">
                                            <div class="text-success text-center mt-3"><h4><?php echo $this->lang['montantCarte'].' '.$this->lang['currency']; ?></h4></div>
                                            <div class="text-info text-center mt-2"><h1><?php if($montantTotal==0) echo 0; else echo Utils::getFormatMoney($montantTotal); ?></h1></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-danger mx-sm-1 p-4">
                                            <div class="text-danger text-center mt-3"><h4><?php echo $this->lang['montant_verse'].' '.$this->lang['currency']; ?></h4></div>
                                            <div class="text-success text-center mt-2"><h1><?php if($montantVerse==0) echo 0; else echo Utils::getFormatMoney($montantVerse); ?></h1></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-danger mx-sm-1 p-4">
                                            <div class="text-danger text-center mt-3"><h4><?php echo $this->lang['montantNonVerse']; ?></h4></div>
                                            <div class="text-danger text-center mt-2"><h1><?php if($montantNonVerse==0) echo 0; else echo Utils::getFormatMoney($montantNonVerse); ?></h1></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">

                                    <table class="table table-bordered table-hover table-responsive processing"
                                           data-url="<?= WEBROOT; ?>distri/getAllCardByDistributeurMonthEnCours/<?= base64_encode($distributeur->id)?>/<?= $date_deb; ?>/<?= $date_fin; ?>">
                                        <thead>
                                        <tr>
                                            <th> <?php echo $this->lang['nom']; ?></th>
                                            <th> <?php echo $this->lang['prenom']; ?></th>
                                            <th> <?php echo $this->lang['num_serie']; ?></th>
                                            <th><?php echo $this->lang['dateEnrollement']; ?></th>
                                            <th><?php echo $this->lang['solde']; ?></th>
                                            <th><?php echo $this->lang['etatCarte']; ?></th>
<!--                                            <th><?php /*echo $this->lang['labAction']; */?></th>
-->
                                        </tr>
                                        </thead>
                                    </table>

                                </div>
                            </div>

                        </div>


                        <div class="tab-pane " id="activationBlocage">

                            <div class="row bg-title">
<!--                                <form class="form-horizontal" method="POST" action="<?/*= WEBROOT */?>distri/venteCarteByDate">
                                    <div class="col-md-1"></div>

                                    <div class="form-group col-lg-2 col-sm-2">
                                        <label for="from" class="control-label" ><?php /*echo $this->lang['date_deb']; */?> (*): </label>
                                        <input type="text" name="date_deb" class="form-control mydatepicker" id="from"
                                               value="<?php /*echo $date_deb */?>" placeholder="<?php /*echo $this->lang['date_deb']; */?>" autocomplete="off">&nbsp;&nbsp;
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="col-md-1" style="width: 4%"></div>

                                    <div class="form-group col-lg-2 col-sm-2">
                                        <label for="from1" class="control-label" ><?php /*echo $this->lang['date_finn']; */?> (*): </label>
                                        <input type="text" name="date_fin" class="form-control mydatepicker" id="from1"
                                               value="<?php /*echo $date_fin */?>" placeholder="<?php /*echo $this->lang['date_finn']; */?>" autocomplete="off">
                                    </div>
                                    <div class="col-md-1" style="width: 4%"></div>

                                    <div class="col-md-1" style="width: 4%"></div>

                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-success btn-circle btn-lg" title="Rechercher"><i
                                                    class="ti-search"></i></button>
                                    </div>
                                </form>
-->                            </div>
                            <div class="jumbotron" >
                                <div class="row w-100">
                                    <div class="col-md-3">
                                        <div class="card border-info mx-sm-1 p-4">
                                            <div class="text-info text-center mt-3"><h4><?php echo $this->lang['totalRecharge'];?></h4></div>
                                            <div class="text text-center mt-2"><h1><?php if($nbreRecharge==0) echo 0; else echo $nbreRecharge; ?></h1></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-success mx-sm-1 p-4">
                                            <div class="text-success text-center mt-3"><h4><?php echo $this->lang['montantRechargeVendu'].' '.$this->lang['currency']; ?></h4></div>
                                            <div class="text-info text-center mt-2"><h1><?php if($montantTotalRecharge==0) echo 0; else echo Utils::getFormatMoney($montantTotalRecharge); ?></h1></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-danger mx-sm-1 p-4">
                                            <div class="text-danger text-center mt-3"><h4><?php echo $this->lang['montant_verse'].' '.$this->lang['currency']; ?></h4></div>
                                            <div class="text-success text-center mt-2"><h1><?php if($montantRechargeVerse==0) echo 0; else echo Utils::getFormatMoney($montantRechargeVerse); ?></h1></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-danger mx-sm-1 p-4">
                                            <div class="text-danger text-center mt-3"><h4><?php echo $this->lang['montantNonVerse']; ?></h4></div>
                                            <div class="text-danger text-center mt-2"><h1><?php if($montantRechargeNonVerse==0) echo 0; else echo Utils::getFormatMoney($montantRechargeNonVerse); ?></h1></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">

                                    <table class="table table-bordered table-hover table-responsive processing"
                                           data-url="<?= WEBROOT; ?>distri/getAllRechargeByDistributeurMonthEnCours/<?= base64_encode($distributeur->id)?>">
                                        <thead>
                                        <tr>
                                            <th> <?php echo $this->lang['numeroTransaction']; ?></th>
                                            <th><?php echo $this->lang['labdate_cmde']; ?></th>
                                            <th><?php echo $this->lang['prenom']; ?></th>
                                            <th><?php echo $this->lang['nom']; ?></th>
                                            <th><?php echo $this->lang['solde']; ?></th>
                                            <th><?php echo $this->lang['etatRecharge']; ?></th>
                                        </tr>
                                        </thead>
                                    </table>

                                </div>
                            </div>

                        </div>


                    </div>


                        <!-- /.tabs3 -->
                        <!-- .tabs3 -->

                        <!-- /.tabs3 -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="ajoutRechargement" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel"><?= $this->lang['rechargement_carte'] ; ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="text-center"><?=  $this->lang['message_rechargement_carte']; ?></div>
                </div>
            </div>
            <form method="post" action="<?= WEBROOT ?>client/ajoutRechargement">
                <div class="form-group" style="width: 100%;padding: 10px;">
                    <label for="solde" class="control-label"><?php echo $this->lang['montant'].' (*) :'; ?></label>
                    <input type="number" id="montant" name="montant" class="form-control" required="required" placeholder="<?php echo $this->lang['montant']; ?>"
                           style="width: 100%">
                    <span id="msg3"></span>
                    <span class="help-block with-errors"> </span>
                    <input type="hidden" name="ancien_solde" value="<?= $client->solde ?>">
                    <input type="hidden" name="idCarte" value="<?= $client->idCarte ?>">
                    <input type="hidden" name="idClient" value="<?= $client->id ?>">
                </div>


                <div class="modal-footer">
                    <button class="btn btn-success" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
                    <button class="btn btn-default" type="button" data-dismiss="modal"> <i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="blockerCarte" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel"><?= $this->lang['blocage_carte'] ; ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="text-center"><?=  $this->lang['message_blocage_carte']; ?> <span class="text-primary"><?= $client->numero_serie; ?></span></div>
                </div>
            </div>
            <form method="post" action="<?= WEBROOT ?>client/ajoutBlocageOrActivation">
                <div class="form-group" style="width: 100%;padding: 10px;">
                    <label for="commentaire" class="control-label"><?php echo $this->lang['commentaire'].' (*) :'; ?></label>
                    <textarea class="form-control" name="commentaire" rows="5" id="commentaire"></textarea>
                    <input type="hidden" name="type" value="2">
                    <input type="hidden" name="fk_carte" value="<?= $client->idCarte ?>">
                    <input type="hidden" name="fk_client" value="<?= $client->id ?>">
                </div>


                <div class="modal-footer">
                    <button class="btn btn-success" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
                    <button class="btn btn-default" type="button" data-dismiss="modal"> <i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="activerCarte" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel"><?= $this->lang['activation_carte'] ; ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="text-center"><?=  $this->lang['message_activation_carte']; ?> <span class="text-primary"><?= $client->numero_serie; ?></span></div>
                </div>
            </div>
            <form method="post" action="<?= WEBROOT ?>client/ajoutBlocageOrActivation">
                <div class="form-group" style="width: 100%;padding: 10px;">
                    <label for="commentaire" class="control-label"><?php echo $this->lang['commentaire'].' (*) :'; ?></label>
                    <textarea class="form-control" name="commentaire" rows="5" id="commentaire"></textarea>
                    <input type="hidden" name="type" value="1">
                    <input type="hidden" name="fk_carte" value="<?= $client->idCarte ?>">
                    <input type="hidden" name="fk_client" value="<?= $client->id ?>">
                </div>


                <div class="modal-footer">
                    <button class="btn btn-success" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
                    <button class="btn btn-default" type="button" data-dismiss="modal"> <i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>





<script>
    $(function () {
        $("#from").datepicker({
            dateFormat: 'yy-mm-dd',
            defaultDate: "+0w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", "dateFormat", selectedDate);
            }
        });
        $("#from1").datepicker({
            dateFormat: 'yy-mm-dd',
            defaultDate: "+0w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", "dateFormat", selectedDate);
            }
        });

    });
</script>




