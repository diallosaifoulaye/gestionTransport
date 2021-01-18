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
                <h4 class="page-title"><?= $this->lang['detailVoyages']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'menu/menu'; ?>"><?= $this->lang['accueil']; ?></a></li>

                    <li><a href="<?= WEBROOT.'trajets/voyages'; ?>"><?= $this->lang['voyages']; ?></a></li>

                    <li class="active"><?= $this->lang['detailVoyages']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="white-box">
                    <!--                    <div class="user-bg"> <img width="100%" alt="user" src="../plugins/images/large/img1.jpg"> </div>-->


                    <div class="user-btm-box">

                        <div class="col-sm-6 col-xs-12">
                            <div class="row text-center m-t-10">
                                <div class="col-md-6 b-r"><strong><?= $this->lang['code_voyage']; ?></strong>
                                    <p><?= $voyage->num_voyage; ?></p>
                                </div>
                                <div class="col-md-6 b-r"><strong><?= $this->lang['date_voyage']; ?></strong>
                                    <p><?= $voyage->date_voyage; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="row text-center m-t-10">
                                <div class="col-md-6"><strong><?= $this->lang['receveur_id']; ?></strong>
                                    <p><?= $voyage->receveur; ?></p>
                                </div>
                                <div class="col-md-6"><strong><?= $this->lang['controleur_id']; ?></strong>
                                    <p><?= $voyage->controleur; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="row text-center m-t-10">
                                <div class="col-md-6"><strong><?= $this->lang['bus']; ?></strong>
                                    <p><?= $voyage->bus; ?></p>
                                </div>
                                <div class="col-md-6"><strong><?= $this->lang['trajet_id']; ?></strong>
                                    <p><?= $voyage->trajet; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="row text-center m-t-10">
                                <div class="col-md-6"><strong><?= $this->lang['etat']; ?></strong>
                                    <p><?php if($voyage->etat == 1) echo $this->lang['encours']; else if($voyage->etat == 2) echo $this->lang['close'] ?></p>
                                </div>
                                <div class="col-md-6">&nbsp;</strong>
                                    <p>&nbsp;</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12" style="margin-top: 20px">
                            <div class="row text-center m-t-10">
                                <div class="col-md-6"><strong><?= $this->lang['nombre_ticket']; ?></strong>
                                    <p><?= $tickets->nombre; ?></p>
                                </div>
                                <div class="col-md-6"><strong><?= $this->lang['ca_voyage']; ?></strong>
                                    <p><?= \app\core\Utils::getFormatMoney($tickets->ca); ?> <?= $this->lang['currency']; ?></p>
                                </div>
                            </div>
                        </div>
                        <!-- .row    -->


                   </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="white-box">

                <div class="panel-heading" style="height: 55px; background-color: #2f5088">
                    <div class="col-md-11"><h3 class="panel-title " > <span class="pull-left" style="color: white;"><?php echo $this->lang['ticket_vendus'] ?></span></h3>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-hover table-responsive processing"
                               data-url="<?= WEBROOT; ?>trajets/ticketsParVoyagePro/<?= base64_encode($voyage->id);?>">
                            <thead>
                            <tr>
                                <th> <?php echo $this->lang['numero_ticket']; ?></th>
                                <th> <?php echo $this->lang['heure_vente']; ?></th>
                                <th><?php echo $this->lang['montant']; ?></th>
                                <th><?php echo $this->lang['nombre_section']; ?></th>
                                <th><?php echo $this->lang['section_courante']; ?></th>
                                <th><?php echo $this->lang['buy_to']; ?></th>
                                <!--<th><?php /*echo $this->lang['action']; */?></th>-->
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

    <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="deleteVoyages" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="gridSystemModalLabel"><?= $this->lang['desactivation'] ; ?></h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="text-center"> <?= $this->lang['message_desactivation']; ?> </div>
                    </div>
                </div>

                <form method="post" action="<?= WEBROOT ?>trajets/updateEtatVoyages">
                    <input type="hidden" name="id" value="<?= base64_encode($voyage->id); ?>"/>
                    <input type="hidden" name="etat" value="0"/>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger pull-left" data-dismiss="modal"><?= $this->lang['non'] ; ?></button>
                        <button type="submit" value="delete" class="btn btn-success pull-right"><?= $this->lang['oui'] ; ?></button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="activeVoyages" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="gridSystemModalLabel"><?= $this->lang['activation'] ; ?></h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="text-center"> <?= $this->lang['message_activation']; ?> </div>
                    </div>
                </div>

                <form method="post" action="<?= WEBROOT ?>trajets/updateEtatVoyages">
                    <input type="hidden" name="id" value="<?= base64_encode($voyage->id); ?>"/>
                    <input type="hidden" name="etat" value="1"/>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger pull-left" data-dismiss="modal"><?= $this->lang['non'] ; ?></button>
                        <button type="submit" value="delete" class="btn btn-success pull-right"><?= $this->lang['oui'] ; ?></button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>
</div>

<script>


    $(function () {
        $("#from").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });


    });
</script>



