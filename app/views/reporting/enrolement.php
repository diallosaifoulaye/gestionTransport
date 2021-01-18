<link href="<?= ASSETS; ?>css/stath.css" rel="stylesheet">
<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['etat_enrolement']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'home/menu'; ?>">  <?php echo $this->lang['accueil']; ?></a></li>
                    <li><a href="<?= WEBROOT.'reporting/index'; ?>">  <?php echo $this->lang['reporting']; ?></a></li>
                    <li class="active"><?php echo $this->lang['etat_enrolement']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="background-color: #325186"><?php echo $this->lang['filtre_periodique']; ?></legend><br/>
                        <form class="form-horizontal" method="POST" action="<?php echo WEBROOT ?>reporting/enrolement">

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
                                    <label for="nom" class="col-lg-6 col-sm-6 control-label"><?php echo $this->lang['distributeur']; ?></label>
                                    <div class="col-lg-6  col-sm-6">
                                        <select name="distributeurSelected" class="select2">
                                            <option value=""><?php echo $this->lang['select_distributeur']; ?></option>
                                            <?php foreach($distributeurs as $distributeur){ ?>
                                                <option  <?= ($distributeur->id == $distributeurSelected) ? "selected" : "" ?> value="<?php echo $distributeur->id ?>"><?php echo $distributeur->label ?></option>
                                            <?}?>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                <button type="submit" class="btn btn-success btn-circle btn-lg" title="Rechercher"><i class="ti-search"></i><?php echo $this->lang['recherche']; ?></button>
                            </div>

                        </form>
                    </fieldset>
                </div>
            </div>

        </div>


        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-3">
                    <div class="circle-tile ">

                        <div class="circle-tile-content dark-blue">
                            <div class="circle-tile-description text-faded">  <?php echo $this->lang['nb_enrolement']; ?></div>
                            <div class="circle-tile-number text-faded "><?php echo $enrolement->nb_enrolement; ?></div>
                            <a class="circle-tile-footer" href="#"> <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-3">
                    <div class="circle-tile ">
                        <div class="circle-tile-content dark-blue">
                            <div class="circle-tile-description text-faded"> <?php echo $this->lang['montant_total']; ?> (XOF)</div>
                            <div class="circle-tile-number text-faded "><?php echo \app\core\Utils::getFormatMoney($enrolement->nb_enrolement*5000) ; ?> </div>
                            <a class="circle-tile-footer" href="#"><i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3">
                    <div class="circle-tile ">
                        <div class="circle-tile-content red">
                            <div class="circle-tile-description text-faded">  <?php echo $this->lang['part_nta']; ?> (XOF)</div>
                            <div class="circle-tile-number text-faded "><?php echo \app\core\Utils::getFormatMoney($enrolement->nb_enrolement * 4800); ?> </div>
                            <a class="circle-tile-footer" href="#"><i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3">
                    <div class="circle-tile ">
                        <div class="circle-tile-content red">
                            <div class="circle-tile-description text-faded">  <?php echo $this->lang['part_distributeur']; ?> (XOF)</div>
                            <div class="circle-tile-number text-faded "><?php echo \app\core\Utils::getFormatMoney($enrolement->nb_enrolement * 200); ?></div>
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
                            <table class="table table-bordered table-hover table-responsive processing"
                                   data-url="<?= WEBROOT; ?>reporting/enrolementProcessing__/<?php echo $datedebut; ?>/<?php echo $datefin; ?>/<?php echo $distributeurSelected; ?>">
                                <thead>


                                <tr>
                                    <th><?php echo $this->lang['dateEnrollement']; ?></th>
                                    <th> <?php echo $this->lang['nom']; ?></th>
                                    <th> <?php echo $this->lang['prenom']; ?></th>
                                    <th> <?php echo $this->lang['num_serie']; ?></th>
                                    <th style="text-align: center"><?php echo $this->lang['solde']; ?></th>
                                    <th><?php echo $this->lang['distributeur']; ?></th>
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




