<?php
    use app\core\Utils;
?>
<style>
    .content-wrapper {
        margin-left: 50px;
        margin-right: 20px;
    }
    .inforide {
        box-shadow: 1px 2px 8px 0px #f1f1f1;
        background-color: white;
        border-radius: 8px;
        height: 125px;
    }
    .rideone img {
        width: 70%;
    }
    .ridetwo img {
        width: 60%;
    }
    .ridethree img {
        width: 50%;
    }
    .rideone {
        background-color: #6CC785;
        padding-top: 25px;
        border-radius: 8px 0px 0px 8px;
        text-align: center;
        height: 125px;
        margin-left: 15px;
    }

    .ridetwo {
        background-color: #9A75FE;
        padding-top: 30px;
        border-radius: 8px 0px 0px 8px;
        text-align: center;
        height: 125px;
        margin-left: 15px;
    }

    .ridethree {
        background-color: #4EBCE5;
        padding-top: 35px;
        border-radius: 8px 0px 0px 8px;
        text-align: center;
        height: 125px;
        margin-left: 15px;
    }

    .fontsty {
        margin-right: -15px;
    }

    .fontsty h2{
        color: #6E6E6E;
        font-size: 35px;
        margin-top: 15px;
        text-align: right;
        margin-right: 30px;
    }

    .fontsty h4{
        color: #6E6E6E;
        font-size: 25px;
        margin-top: 20px;
        text-align: right;
        margin-right: 30px;
    }

</style>
<div id="page-wrapper">
    <div class="container-fluid">
        <?php require_once (ROOT . 'app/views/template/notify.php'); ?>
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['reporting']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'home/menu'; ?>">  <?php echo $this->lang['accueil']; ?></a></li>
                    <li><a href="<?= WEBROOT.'transaction/transactionsJournalieres'; ?>">  <?php echo $this->lang['reporting']; ?></a></li>
                    <li class="active"><?php echo $this->lang['location']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="white-box">

<!--                    <div class="row bg-title">
                        <form class="form-horizontal" method="POST" action="<?/*= WEBROOT */?>bus/reportingByDate">
                            <div class="col-md-1"></div>

                            <div class="form-group col-lg-2 col-sm-2">
                                <label for="from" class="control-label" ><?php /*echo $this->lang['date_deb']; */?> (*): </label>
                                <input type="text" name="date_deb" class="form-control mydatepicker" id="from"
                                       value="<?php /*echo $date_deb */?>" placeholder="<?php /*echo $this->lang['date_deb']; */?>" autocomplete="off">&nbsp;&nbsp;
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-md-1" style="width: 4%"></div>

                            <div class="form-group col-lg-2 col-sm-2">
                                <label for="from1" class="control-label" ><?php /*echo $this->lang['date_fin']; */?> (*): </label>
                                <input type="text" name="date_fin" class="form-control mydatepicker" id="from1"
                                       value="<?php /*echo $date_fin */?>" placeholder="<?php /*echo $this->lang['date_fin']; */?>" autocomplete="off">
                            </div>
                            <div class="col-md-1" style="width: 4%"></div>
                            <div class="form-group col-lg-2 col-sm-2">
                                <label for="from" class="control-label"><?php /*echo $this->lang['select_bus']; */?></label>
                                <select id="select_bus" name="select_bus" class="form-control select2" style="width: 100%" >
                                    <option value="">  <?php /*echo $this->lang["select_bus"]*/?></option>
                                    <?php /*foreach ($location as $loc) { */?>
                                        <option value="<?php /*echo $loc->id; */?>" <?/* if ($liste == $loc->id) echo "selected=selected" */?>>
                                            <?php /*echo $loc->matricule;*/?>
                                        </option>

                                    <?php /*} */?>
                                </select>
                            </div>
                            <div class="col-md-1" style="width: 4%"></div>
                            <div class="form-group col-lg-2 col-sm-2">
                                <label for="etat" class="control-label"><?php /*echo $this->lang['etat']; */?></label>
                                <select id="etat" name="etat" class="form-control select2" style="width: 100%" >
                                    <option value="">  <?php /*echo $this->lang["etat"]*/?></option>
                                    <option value="0"  <?/* if ($etatBus == "0") echo "selected=selected" */?>><?php /*echo $this->lang['annule']; */?></option>
                                    <option value="2" <?/* if ($etatBus == "1") echo "selected=selected" */?>><?php /*echo $this->lang['reserve']; */?></option>
                                    <option value="3" <?/* if ($etatBus == "2") echo "selected=selected" */?>><?php /*echo $this->lang['valide']; */?></option>
                                    <option value="3" <?/* if ($etatBus == "3") echo "selected=selected" */?>><?php /*echo $this->lang['traite']; */?></option>
                                </select>
                                </select>
                            </div>
                            <div class="col-md-1" style="width: 4%"></div>

                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success btn-circle btn-lg" title="Rechercher"><i
                                            class="ti-search"></i></button>
                            </div>
                        </form>
                    </div>
-->
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">

                    <!-- Icon Cards-->
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-2 mt-4">
                        <div class="inforide">
                            <div class="row">
                               <!-- <div class="col-lg-3 col-md-4 col-sm-4 col-4 rideone">
                                    <img src="<?/*= WEBROOT;*/?>assets/plugins/images/white-sunusva.png">
                                </div>-->
                                <div class="col-lg-9 col-md-8 col-sm-8 col-8 fontsty">
                                    <table>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td><h3><?php echo $this->lang['nombreLocation'].": ";?></h3></td>
                                            <td></td>
                                            <td><h3><strong><?php echo $nbreBusLoue; /*echo $nbreBusLoueFiltre*/?></strong></h3></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td><h3><?php echo $this->lang['montantTotal'].": ";?></h3></td>
                                            <td><h5><strong><?php echo Utils::getFormatMoney($montantTotalBus); /*echo Utils::getFormatMoney($montantBusApresFiltre);*/ echo $this->lang['currency']?></strong></h5></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-2 mt-4">
                        <div class="inforide">
                            <div class="row">
                                <table>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td><h3><?php echo $this->lang['nbreDeReservation'].": ";?></h3></td>
                                        <td></td>
                                        <td><h3><strong><?php echo $nbreReservation;/* echo $nbreBusReserveFiltre*/?></strong></h3></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td><h3><?php echo $this->lang['montantTotal'].": ";?></h3></td>
                                        <td><h5><strong><?php echo Utils::getFormatMoney($montantBusReserve);/* echo Utils::getFormatMoney($montantBusReserveFiltre);*/echo $this->lang['currency']?></strong></h5></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-2 mt-4">
                        <div class="inforide">
                            <div class="row">
                                <!--<div class="col-lg-3 col-md-4 col-sm-4 col-4 ridethree">
                                    <img src="<?/*= WEBROOT;*/?>assets/plugins/images/white-sunusva.png">
                                </div>-->
                                <div class="col-lg-9 col-md-8 col-sm-8 col-8 fontsty">
                                    <h4>Montant total bus traités</h4>
                                    <h2><?php echo Utils::getFormatMoney($montantBusTraite); echo $this->lang['currency']?></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">

                    <div class="panel-heading" style="height: 55px; background-color: #2f5088">
                        <div class="col-md-11"><h3 class="panel-title pull-left" style="color: white;"> <?php echo $this->lang['reportingByDate'] ?> </h3>
                        </div>

                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">

                                <!--<h3 class="box-title">Blank Starter page</h3> </div>-->

                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered table-hover table-responsive processing"
                                               data-url="<?= WEBROOT; ?>location/getLocationByDate">
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

        </div>
    </div>
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
    $(".select2").select2();
</script>

