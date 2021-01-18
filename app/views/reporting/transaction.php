<?php
use app\core\Utils;

?>

<style>
    /*CSS HISTOGRAMME*/
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
        height:235px;
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

    #container {
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

    /*
        CSS CIRCULAIRE
    */

    .highcharts-figure, .highcharts-data-table table {
        min-width: 320px;
        max-width: 660px;
        margin: 1em auto;
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
                <h4 class="page-title"><?php echo $this->lang['reporting']; ?></h4> </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?php echo WEBROOT ?>menu/menu"><?php echo $this->lang['tabBord']; ?></a></li>
                    <li class="active"><?php echo $this->lang['reporting']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 col-xl-3">
                        <div class="card bg-c-blue order-card">
                            <div class="card-block">
                                <h2 class="m-b-20"><?php echo $this->lang['client']; ?></h2>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['nbreClient']; ?></i><span><?php echo $nbreClient; ?></span></h3>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['active']; ?></i><span><?php echo $nbreClientActif; ?></span></h3>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['desactive']; ?></i><span><?php echo $nbreClientDesactive; ?></span></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-xl-3">
                        <div class="card bg-c-green order-card">
                            <div class="card-block">
                                <h2 class="m-b-20"><?php echo $this->lang['caCarte'].' '.$this->lang['currency']; ?></h2>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['caJournalier']; ?></i><span><?php
                                        if($caJournalierCarte==0) echo 0; else echo Utils::getFormatMoney($caJournalierCarte);
                                        ?></span></h3>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['caMensuel']; ?></i><span><?php
                                        if($caMensuelCarte==0) echo 0; else echo Utils::getFormatMoney($caMensuelCarte);
                                        ?></span></h3>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['caAnnuel']; ?></i><span><?php
                                        if($caAnnuelCarte==0) echo 0; else echo Utils::getFormatMoney($caAnnuelCarte);
                                        ?></span></h3>
                                <h3 class="text-right"><i class="f-left"> </i> <span> </span></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-xl-3">
                        <div class="card bg-c-yellow order-card">
                            <div class="card-block">
                                <h2 class="m-b-20"><?php echo $this->lang['caTransaction'].' '.$this->lang['currency']; ?></h2>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['caJournalier']; ?></i><span><?php
                                        if($caJournalierTicket==0) echo (0); else echo Utils::getFormatMoney($caJournalierTicket);
                                        ?></span></h3>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['caMensuel']; ?></i><span><?php
                                        if($caMensuelTicket==0) echo 0; else echo Utils::getFormatMoney($caMensuelTicket);
                                        ?></span></h3>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['caAnnuel']; ?></i><span><?php
                                        if($caAnnuelTicket==0) echo 0; else echo Utils::getFormatMoney($caAnnuelTicket);
                                        ?></span></h3>
                                <h3 class="text-right"><i class="f-left"> </i> <span> </span></h3>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3 col-xl-3">
                        <div class="card bg-c-pink order-card">
                            <div class="card-block">
                                <h2 class="m-b-20"><?php echo $this->lang['carte']; ?></h2>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['disponible']; ?></i><span><?php
                                        if($carteDispo==0) echo 0; else echo $carteDispo;
                                        ?></span></h3>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['cactive']; ?></i><span><?php
                                        if($carteActive==0) echo 0; else echo $carteActive;
                                        ?></span></h3>
                                <h3 class="text-right"><i class="f-left"><?php echo $this->lang['cadesactive']; ?></i><span><?php
                                        if($carteBloquee==0) echo 0; else echo $carteBloquee;
                                        ?></span></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <figure class="highcharts-figure">
                            <div id="histogramme">

                            </div>

                        </figure>
                    </div>

                    <div class="col-md-6 col-xl-6">

                        <figure class="highcharts-figure">
                            <div id="circulaire"></div>

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


        Highcharts.chart('histogramme', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Reporting des ventes de ticket par mois.'
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
                    text: 'Montant par mois'
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
                        format: '{point.y:.f} $(LRB)'
                    }
                }
            },

            tooltip: {

                headerFormat: '<span style="font-size:11px">Tickets vendus</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.f}<strong> $(LRB)</strong></b>'
            },
            series: [
                {
                    name: "Mois",
                    colorByPoint: true,
                    data: [
                        <?php
                        foreach ($reportByMonth as $month){
                        ?>
                        {
                            name:" <?= $month->mois ?>",
                            y: <?= $month->mnt;?>,
                            drilldown: "<?= $month->mois ?>"
                        },
                        <? }?>

                    ]
                }
            ],
        });






        // Create the chart
        Highcharts.chart('circulaire', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Reporting des ventes de ticket par mois.'
            },
           /* subtitle: {
                text: 'Click the slices to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
            },*/

            accessibility: {
                announceNewData: {
                    enabled: true
                },
                point: {
                    valueSuffix: '%'
                }
            },

            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },

            series: [
                {
                    name: "Mois",
                    colorByPoint: true,
                    data: [
                        <?php
                        foreach ($reportByMonth as $month){
                        ?>
                        {
                            name:" <?= $month->mois ?>",
                            y: <?= ($month->mnt)*100/$caAnnuelTicket;?>,
                            drilldown: "<?= $month->mois ?>"
                        },
                        <? }?>

                    ]
                }
            ],
        });




    </script>