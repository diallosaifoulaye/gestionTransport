<?php
use app\core\Utils;

?>

<style>
    /*CSS BOX*/
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


    .card {
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
        height:200px;
    }

    .order-card i {
        font-size: 26px;
    }

    .f-left {
        float: left;
    }

    .f-right {
        float: right;
    }

    /*CSS DU GRAPHE*/
    .highcharts-figure, .highcharts-data-table table {
        min-width: 310px;
        max-width: 800px;
        margin: 1em auto;
    }

    #cash {
        height: 400px;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }
    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }
    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
        padding: 0.5em;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }



    .highcharts-figure, .highcharts-data-table table {
        min-width: 310px;
        max-width: 800px;
        margin: 1em auto;
    }

    #cash {
        height: 400px;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }
    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }
    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
        padding: 0.5em;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }

</style>

<div id="page-wrapper">
    <div class="container-fluid">
        <?php require_once (ROOT . 'app/views/template/notify.php'); ?>
        <div class="row bg-title">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['ticket']; ?></h4> </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?php echo WEBROOT ?>menu/menu"><?php echo $this->lang['tabBord']; ?></a></li>
                    <li class="active"><?php echo $this->lang['ticket']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <?php //var_dump($ticketByMonth)?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
<!--                    <div class="row bg-title">
                        <form class="form-horizontal" method="POST" action="<?/*= WEBROOT */?>bus/reportingByDate">
                            <div class="col-md-1"></div>
                            <div class="col-md-1" style="width: 4%"></div>

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
                                       value="<?php /*echo $date_fin */?>" placeholder="<?php /*echo $this->lang['date_finn']; */?>" autocomplete="off">
                            </div>
                            <div class="col-md-1" style="width: 4%"></div>

                            <div class="form-group col-lg-2 col-sm-2">
                                <label for="from1" class="control-label" ><?php /*echo $this->lang['choixAnne']; */?> (*): </label>
                                <div ></div>

                                <select id="annee" name="annee">
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                </select>
                            </div>
                            <div class="col-md-1" style="width: 4%"></div>

                            <div class="col-md-1" style="width: 4%"></div>

                            <div class="col-md-1" style="width: 4%"></div>

                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success btn-circle btn-lg" title="Rechercher"><i
                                            class="ti-search"></i></button>
                            </div>
                        </form>
                    </div>
-->                    <div class="col-md-6 col-xl-6">
                        <div class="card bg-c-yellow order-card">
                            <div class="card-block">
                                <h2 class="m-b-20"><?php echo $this->lang['cash']; ?></h2>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['nombreTotalTicketVendus']; ?></i><span><?php
                                        if($nbreTicketCash==0) echo 0; else echo $nbreTicketCash;
                                        ?></span></h3>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['montantTotal']; ?></i><span><?php
                                        if($ticketVenduCash==0) echo 0; else echo $ticketVenduCash.' '.$this->lang['currency'];;
                                        ?></span></h3>

                                <h3 class="text-right"><i class="f-left"> </i> <span> </span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-6">

                        <div class="card bg-c-pink order-card">
                            <div class="card-block">
                                <h2 class="m-b-20"><?php echo $this->lang['card']; ?></h2>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['nombreTotalTicketVendus']; ?></i><span><?php
                                        if($nbreTicketCard==0) echo 0; else echo $nbreTicketCard;
                                        ?></span></h3>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['montantTotal']; ?></i><span><?php
                                        if($ticketVenduCard==0) echo 0; else echo $ticketVenduCard.' '.$this->lang['currency'];;
                                        ?></span></h3>

                                <h3 class="text-right"><i class="f-left"> </i> <span> </span></h3>
                            </div>
                        </div>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <figure class="highcharts-figure">
                            <div id="cash">

                            </div>

                        </figure>
                    </div>

                    <div class="col-md-6 col-xl-6">

                        <figure class="highcharts-figure">
                            <div id="card"></div>

                        </figure>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <?php         //var_dump($nbreTickets[0]->nbreTicket);die;
            ?>
        </div>
    </div>


    <script src="<?= ASSETS; ?>js/highcharts.js"></script>
    <script src="<?= ASSETS; ?>js/data.js"></script>
    <script src="<?= ASSETS; ?>js/drilldown.js"></script>
    <script src="<?= ASSETS; ?>js/exporting.js"></script>
    <script src="<?= ASSETS; ?>js/export-data.js">
        <script src="<?= ASSETS; ?>js/accessibility.js"></script>



<script>


        Highcharts.chart('cash', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Reporting du nombre de ticket par mois.'
            },
            /*subtitle: {
                text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
            },*/
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Nombre de ticket par mois'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.f}'
                    }
                }
            },

            tooltip: {

                headerFormat: '<span style="font-size:11px">Nombre de tickets vendus</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.f}</b>'
            },
            series: [
                {
                    name: "Mois",
                    colorByPoint: true,
                    data: [
                        <?php
                          foreach ($ticketCashByMonth as $month){
                            ?>
                        {
                            name:" <?= $month->mois ?>",
                            y: <?= $month->nbreTicket;?>,
                            drilldown: "<?= $month->mois ?>"
                        },
                        <? }?>

                    ]
                }
            ],
        });


        Highcharts.chart('card', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Reporting du nombre de ticket par mois.'
            },
            /*subtitle: {
                text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
            },*/
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Nombre de ticket par mois'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.f}'
                    }
                }
            },

            tooltip: {

                headerFormat: '<span style="font-size:11px">Nombre de tickets vendus</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.f}</b>'
            },
            series: [
                {
                    name: "Mois",
                    colorByPoint: true,
                    data: [
                        <?php
                        foreach ($ticketCardByMonth as $month){
                        ?>
                        {
                            name:" <?= $month->mois ?>",
                            y: <?= $month->nbreTicket;?>,
                            drilldown: "<?= $month->mois ?>"
                        },
                        <? }?>

                    ]
                }
            ],
        });

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