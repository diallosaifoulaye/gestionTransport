<link href="<?= ASSETS; ?>css/stath.css" rel="stylesheet">

        <div id="page-wrapper">
            <div class="container-fluid">
                <?php require_once (ROOT . 'app/views/template/notify.php'); ?>
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"><?php echo $this->lang['ges_facturation']; ?></h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                        <ol class="breadcrumb">
                            <li><a href="<?= WEBROOT.'home/menu'; ?>">  <?php echo $this->lang['accueil']; ?></a></li>
                            <li><a href="<?= WEBROOT.'facturation/index'; ?>">  <?php echo $this->lang['facturation']; ?></a></li>
                            <li class="active"><?php echo $this->lang['facturation']; ?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <h3><?php echo $this->lang['facturation'].' '.$this->lang['encours'].' '.$this->lang['du'].' '.$datedebut.' '.$this->lang['au'].' '.$datefin; ?></h3>

                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border" style="background-color: #325186"><?php echo $this->lang['filtre_periodique']; ?></legend><br/>
                                <form class="form-horizontal" method="POST" action="<?php echo WEBROOT ?>facturation/facturation">

                                    <div  class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label for="nom" class="col-lg-3 col-sm-4 control-label"><?php echo $this->lang['du']; ?></label>
                                            <div class="col-lg-9 col-sm-8">
                                                <input type="text" class="form-control" readonly placeholder="dd-mm-yyyy" name="datedebut"  value="<?php echo $datedebut; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label for="nom" class="col-lg-6 col-sm-6 control-label"><?php echo $this->lang['au']; ?></label>
                                            <div class="col-lg-6  col-sm-6">
                                                <input type="text" class="form-control" placeholder="dd-mm-yyyy" name="datefin" id="to" value="<?php echo $datefin; ?>"/>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 pull-right">
                                        <button type="submit" class="btn btn-success btn-circle btn-lg" title="<?php echo $this->lang['facturer']; ?>"><i class="ti-search"></i><?php echo $this->lang['recherche']; ?></button>
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
                                    <div class="circle-tile-description text-faded"> <?php echo $this->lang['number_of'].' '.$this->lang['transactions']; ?></div>
                                    <div class="circle-tile-number text-faded "><?php echo $nbTransactionTotal; ?></div>
                                    <a class="circle-tile-footer" href="#"> <i class="fa fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-3">
                            <div class="circle-tile ">
                                <div class="circle-tile-content dark-blue">
                                    <div class="circle-tile-description text-faded"> <?php echo $this->lang['montant_total'].'  ['.$this->lang['lrd'].' ]'; ?></div>
                                    <div class="circle-tile-number text-faded "><?php echo \app\core\Utils::getFormatMoney(round($montantTotal)) ; ?> </div>
                                    <a class="circle-tile-footer" href="#"><i class="fa fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-3">
                            <div class="circle-tile ">
                                <div class="circle-tile-content red">
                                    <div class="circle-tile-description text-faded">  <?php echo $this->lang['part_nta'].'  ['.$this->lang['lrd'].' ]'; ?></div>
                                    <div class="circle-tile-number text-faded "><?php echo \app\core\Utils::getFormatMoney(round($partNTATotal)); ?> </div>
                                    <a class="circle-tile-footer" href="#"><i class="fa fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-3">
                            <div class="circle-tile ">
                                <div class="circle-tile-content red">
                                    <div class="circle-tile-description text-faded">  <?php echo $this->lang['part_numherit'].'  ['.$this->lang['lrd'].' ]'; ?> </div>
                                    <div class="circle-tile-number text-faded "><?php echo \app\core\Utils::getFormatMoney(round($partNumheritTotal)); ?></div>
                                    <a class="circle-tile-footer" href="#"><i class="fa fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="row white-box ">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div class="text-center">

                            <h2><?php echo $this->lang['facture'].' '.$this->lang['encours'].' '.$this->lang['du'].' '.$datedebut.' '.$this->lang['au'].' '.$datefin; ?></h2>
                            <br> <br>
                        </div>
                        </span>
                        <form onsubmit="return confirm('<?php echo $this->lang['confirm_valide_facture'];  ?>');"  method="POST" action="<?php echo WEBROOT ?>facturation/genererFacture">
                            <input type="hidden" name="dateDebutFacturation" value="<?php echo $datedebut; ?>">
                            <input type="hidden" name="dateFinFacturation" value="<?php echo $datefin; ?>">
                            <table class="table table-hover">
                                <?php if($transactions){?>
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang['service']; ?></th>
                                    <th class="text-center"><?php echo $this->lang['transactions']; ?></th>
                                    <th class="text-center"><?php echo $this->lang['montant']; ?></th>
                                    <th class="text-center"><?php echo $this->lang['part_nta']; ?></th>
                                    <th class="text-center"><?php echo $this->lang['part_numherit']; ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($transactions as $item => $transaction){?>
                                        <tr>
                                            <td class="col-md-2"><em><?php echo $transaction['nomService']; ?></em></h4></td>
                                            <td class="col-md-1" style="text-align: center"> <?php echo $transaction['nombre']; ?> </td>
                                            <td class="col-md-2 text-center"><?php echo \app\core\Utils::getFormatMoney(round($transaction['montant'])) ; ?></td>
                                            <td class="col-md-2 text-center"><?php echo \app\core\Utils::getFormatMoney(round($transaction['partNTA'])) ; ?></td>
                                            <td class="col-md-2 text-center"><?php echo \app\core\Utils::getFormatMoney(round($transaction['partNumherit'])) ; ?></td>
                                        </tr>
                                    <?}?>

                                    <tr>

                                        <td class="text-right">
                                            <p>
                                                <strong><?php echo $this->lang['sous_total']; ?>: </strong>
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p>
                                                <strong><?php echo $nbTransactionTotal; ?></strong>
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p>
                                                <strong><?php echo \app\core\Utils::getFormatMoney(round($montantTotal)) ; ?></strong>
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p>
                                                <strong><?php echo \app\core\Utils::getFormatMoney(round($partNTATotal)); ?></strong>
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p>
                                                <strong><?php echo \app\core\Utils::getFormatMoney(round($partNumheritTotal)); ?></strong>
                                            </p>
                                        </td>
                                    </tr>



                                <?php if($reliquat > 0){?>
                                    <tr>
                                        <input type="hidden" value="<?php echo $reliquat; ?>">
                                        <td class="text-right"><p><?php echo $this->lang['reliquat_last_bill']; ?></p></td>
                                        <td>   </td>
                                        <td>   </td>
                                        <td>   </td>
                                        <td class="text-center"><p><strong><?php echo \app\core\Utils::getFormatMoney(round($reliquat)); ?> </strong></p></td>
                                    </tr>
                                <?}?>

                                <tr>
                                    <td class="text-right"><h5><strong><?php echo $this->lang['total']. ' ['.$this->lang['lrd'].' ]'; ?>: </strong></h5></td>
                                    <td>   </td>
                                    <td>   </td>
                                    <td>   </td>
                                    <td class="text-center text-danger"><h5><strong><?php echo \app\core\Utils::getFormatMoney(round($partNumheritTotal+$reliquat)); ?></strong></h5></td>
                                </tr>
                                </tbody>
                            </table>

                            <br> <br>
                            <button type="submit" class="btn btn-success confirm btn-lg btn-block">
                                <?php echo $this->lang['generer_facture'] ?>   <span class="glyphicon glyphicon-chevron-right"></span>
                            </button></td>
                            <?}?>
                        </form>

                        </form>

                        <br><br>
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





