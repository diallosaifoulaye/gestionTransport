<style type="text/css">

    .circle-tile {
        margin-bottom: 15px;
        text-align: center;
    }
    .circle-tile-heading {
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 100%;
        color: #FFFFFF;
        height: 80px;
        margin: 0 auto -40px;
        position: relative;
        transition: all 0.3s ease-in-out 0s;
        width: 80px;
    }
    .circle-tile-heading .fa {
        line-height: 80px;
    }
    .circle-tile-content {
        padding-top: 50px;
    }
    .circle-tile-number {
        font-size: 26px;
        font-weight: 700;
        line-height: 1;
        padding: 5px 0 15px;
    }
    .circle-tile-description {
        text-transform: uppercase;
    }
    .circle-tile-footer {
        background-color: rgba(0, 0, 0, 0.1);
        color: rgba(255, 255, 255, 0.5);
        display: block;
        padding: 5px;
        transition: all 0.3s ease-in-out 0s;
    }
    .circle-tile-footer:hover {
        background-color: rgba(0, 0, 0, 0.2);
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
    }
    .circle-tile-heading.dark-blue:hover {
        background-color: #325186;
    }
    .circle-tile-heading.green:hover {
        background-color: #138F77;
    }
    .circle-tile-heading.orange:hover {
        background-color: #DA8C10;
    }
    .circle-tile-heading.blue:hover {
        background-color: #2473A6;
    }
    .circle-tile-heading.red:hover {
        background-color: #E86010;
    }
    .circle-tile-heading.purple:hover {
        background-color: #7F3D9B;
    }
    .tile-img {
        text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.9);
    }

    .dark-blue {
        background-color: #325186;
    }
    .green {
        background-color: #16A085;
    }
    .blue {
        background-color: #2980B9;
    }
    .orange {
        background-color: #F39C12;
    }
    .red {
        background-color: #E86010;
    }
    .purple {
        background-color: #8E44AD;
    }
    .dark-gray {
        background-color: #7F8C8D;
    }
    .gray {
        background-color: #95A5A6;
    }
    .light-gray {
        background-color: #BDC3C7;
    }
    .yellow {
        background-color: #F1C40F;
    }
    .text-dark-blue {
        color: #325186;
    }
    .text-green {
        color: #16A085;
    }
    .text-blue {
        color: #2980B9;
    }
    .text-orange {
        color: #F39C12;
    }
    .text-red {
        color: #E86010;
    }
    .text-purple {
        color: #8E44AD;
    }
    .text-faded {
        color: rgba(255, 255, 255, 0.7);
    }


</style>



<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['com_num_ticket']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'home/menu'; ?>">  <?php echo $this->lang['accueil']; ?></a></li>
                    <li><a href="<?= WEBROOT.'reporting/index'; ?>">  <?php echo $this->lang['reporting']; ?></a></li>
                    <li class="active"><?php echo $this->lang['commission']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="background-color: #325186"><?php echo $this->lang['filtre_periodique']; ?></legend><br/>
                        <form class="form-horizontal" method="POST" action="<?php echo WEBROOT ?>reporting/commission">

                            <div  class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="nom" class="col-lg-3 col-sm-4 control-label"><?php echo $this->lang['du']; ?></label>
                                    <div class="col-lg-9 col-sm-8">
                                        <input type="date" class="form-control" placeholder="dd-mm-yyyy" name="datedebut" id="from" value="<?php echo $datedebut; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="nom" class="col-lg-6 col-sm-6 control-label"><?php echo $this->lang['au']; ?></label>
                                    <div class="col-lg-6  col-sm-6">
                                        <input type="date" class="form-control" placeholder="dd-mm-yyyy" name="datefin" id="to" value="<?php echo $datefin; ?>"/>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label for="nom" class="col-lg-6 col-sm-6 control-label"><?php echo $this->lang['rechercher']; ?></label>
                                    <div class="col-lg-6  col-sm-6">
                                        <button type="submit" class="btn btn-success btn-circle btn-lg" title="Rechercher"><i class="ti-search"></i></button>

                                    </div>
                                </div>
                            </div>



                        </form>
                    </fieldset>
                </div>
            </div>

        </div>


        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <div class="circle-tile ">

                        <div class="circle-tile-content dark-blue">
                            <div class="circle-tile-description text-faded">  <?php echo $this->lang['nb_ticket']; ?></div>
                            <div class="circle-tile-number text-faded "><?php echo $commission->nb_ticket; ?></div>
                            <a class="circle-tile-footer" href="#"> <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-4">
                    <div class="circle-tile ">
                        <div class="circle-tile-content dark-blue">
                            <div class="circle-tile-description text-faded"> <?php echo $this->lang['montant_total']; ?> </div>
                            <div class="circle-tile-number text-faded "><?php echo \app\core\Utils::getFormatMoney($commission->montant_total) ; ?></div>
                            <a class="circle-tile-footer" href="#"><i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <div class="circle-tile ">
                        <div class="circle-tile-content red">
                            <div class="circle-tile-description text-faded">  <?php echo $this->lang['commission']; ?> </div>
                            <div class="circle-tile-number text-faded "><?php echo \app\core\Utils::getFormatMoney($commission->com_numherit); ?></div>
                            <a class="circle-tile-footer" href="#"><i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<br><br>
        <div class="row">

            <div class="col-md-12">
                <div class="white-box">


                    <div class="row">
                        <div class="col-lg-12">
                          <!--  <a href="<?/*= WEBROOT*/?>versement/export/<?php /*echo $datedebut; */?>/<?php /*echo $datefin; */?>/<?php /*echo $collecteurT; */?>" target="_blank" class="btn btn-plus pull-right m-l-20  waves-effect waves-light" >
                                <i class="fa fa-file-pdf-o"></i> <?/*= $this->lang['export']; */?>
                            </a>-->
                            <table class="table table-bordered table-hover table-responsive processing"
                                   data-url="<?= WEBROOT; ?>reporting/commissionProcessing/<?php echo $datedebut; ?>/<?php echo $datefin; ?>/<?php echo $collecteurT; ?>">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang['date']; ?></th>
                                    <th style="text-align: center"><?php echo $this->lang['nombre']; ?></th>
                                    <th style="text-align: center"><?php echo $this->lang['montant']; ?> (XOF)</th>
                                    <th style="text-align: center"><?php echo $this->lang['com_numherit']; ?>(XOF)</th>

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
<style>
    legend.scheduler-border {
        font-size: 1.1em !important;
        font-weight: normal !important;
        text-align: left !important;
        border-bottom: none;
        background-color: #0a7242;
        color: #fff;
        padding: 5px 30px;
        display: block;
        width: auto;
        margin-bottom: auto;}

    .btn-plus, .btn-plus.disabled {
        background: #0a7242;!important;
        margin-bottom: 10px;!important;
    }
</style>




