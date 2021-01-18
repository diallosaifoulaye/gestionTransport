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
                <h4 class="page-title"><?= $this->lang['versement']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'menu/menu'; ?>"><?= $this->lang['accueil']; ?></a></li>

                    <li><a href="<?= WEBROOT.'versement/versementAgent'; ?>"><?= $this->lang['liste']; ?></a></li>

                    <li class="active"><?= $this->lang['versement']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">

            <div class="col-md-12 col-xs-12">
                <div class="white-box">
                    <!-- .tabs -->
                    <ul class="nav nav-tabs tabs customtab">
                        <li class="tab active">
                            <a href="#home" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['historiqueDeCarte']; ?></span> </a>
                        </li>
                        <li class="tab">
                            <a href="#tab" data-toggle="tab" aria-expanded="false"> <span class="visible-xs">
                                    <i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['historiqueRecharge']; ?></span> </a>
                        </li>
                    </ul>
                    <!-- /.tabs -->
                    <div class="tab-content">
                        <!-- .tabs3 -->

                        <div class="tab-pane active" id="home">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-md-8 col-xs-offset-2 col-sm-8">
                                        <dl class="dl-horizontal">
                                            <dt><?php echo $this->lang['agent']; ?> : </dt>
                                            <dd><?php  echo $agent->prenom_agent." ".$agent->nom_agent; ?>
                                        </dl>
                                        <div class="row">
                                            <div class="dropdownPanel panel panel-default">
                                                <div class="panel-heading clearfix">
                                                    <br>
                                                    <div class="col-xs-4 col-sm-4 col-md-4 text-left">
                                                        <div class="pull-left">
                                                            <p><b><?= $this->lang['montant_collect'].' (XOF)'; ?></b></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                                    </div>
                                                    <div class="col-xs-2 col-sm-2 col-md-2 text-right">
                                                        <div class="pull-right">
                                                            <p><b><?= $this->lang['action']; ?></b></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-1 col-sm-1 col-md-1">

                                                    </div>

                                                </div>
                                                <ul class="list-group">
                                                    <?php
                                                    $total = 0 ;
                                                    $i = 0 ;
                                                    foreach ($collects  as $item => $collect){
                                                        //var_dump($collect);
                                                        $total+= $collect->montant;
                                                        ?>
<!--                                                        <li class="list-group-item">
                                                            <div class="dropdown-heading" role="tab" id="heading-1">
                                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?/*= $i; */?>" aria-expanded="true" aria-controls="collapse-1">
                                                                   <i class="more-less pull-right glyphicon glyphicon-chevron-down"></i>
                                                                    <br>
                                                                </a>
                                                                <div class="col-xs-4 col-sm-4 col-md-4 text-left">
                                                                    <div class="pull-left">
                                                                        <p><?/*= \app\core\Utils::getDateFR($collect->date_creation) ; */?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                                    <div style="text-align: right">
                                                                        <p><b><?/*= \app\core\Utils::getFormatMoney($collect->montant) ; */?></b></p>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                                    <div style="text-align: right">

                                                                        <button type="button" style="background: #325186; border:1px solid #325186;" class="btn btn-info" data-toggle="modal"
                                                                                data-target="#modal<?/*= $item */?>"><?/*= $this->lang['verser'] ; */?></button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-1 col-sm-1 col-md-1">

                                                                </div>

                                                                <br> <br> <br>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <div id="collapse<?/*= $i; */?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-1">
                                                                        <div class="panel-body">

                                                                            <table class="table table-bordered table-hover table-responsive dataTable">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Heure transaction</th>
                                                                                    <th>Nombre d'enrolement</th>
                                                                                    <th style="text-align: right">Montant</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php
/*                                                                               $text = str_replace('-','', $collect->date_creation);
                                                                                $lescollectes = ${'collect'.$text} ;

                                                                                foreach($lescollectes as $collecte){ */?>
                                                                                    <tr>
                                                                                        <td><?php /*echo \app\core\Utils::heure_minute_seconde($collecte->date_creation) ; */?></td>
                                                                                        <td><?php /*echo $collecte->nbreEnroelement ; */?></td>

                                                                                        <td align="right"><?/* echo \app\core\Utils::getFormatMoney($collecte->montant); */?></td>
                                                                                    </tr>
                                                                                <?php /*} */?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                     </li>
-->                                                        <?php $i++ ;} ?>

                                                </ul>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="col-xs-4 col-sm-4 col-md-4 text-left">
                                            <div class="pull-left">
                                                <p><b><?= \app\core\Utils::getFormatMoney($total).' XOF'; ?></b></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 text-left">
                                            <div class="pull-left">
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 text-right">
                                            <div class="pull-right">
                                                <p><button type="button" style="background: #325186; border:1px solid #325186;" class="btn btn-info" data-toggle="modal"
                                                            data-target="#modal<?= $item ?>"><?= $this->lang['verser'] ; ?></button></b></p>
                                            </div>
                                        </div>

                                        <br> <br> <br> <br><br> <br> <br> <br><br> <br> <br> <br>
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4 pull-left">
                                                <a href="<?= WEBROOT.'versement/versementAgent'; ?>"><button class="btn btn-success" ><span  ><?= $this->lang['btnRetour'] ; ?></button></button></a>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab">


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-md-8 col-xs-offset-2 col-sm-8">
                                        <dl class="dl-horizontal">

                                            <dt><?php echo $this->lang['agent']; ?> : </dt>
                                            <dd><?php  echo $agent->prenom_agent." ".$agent->nom_agent; ?>
                                        </dl>

                                        <div class="row">
                                            <div class="dropdownPanel panel panel-default">
                                                <div class="panel-heading clearfix">
                                                    <br>
                                                    <div class="col-xs-4 col-sm-4 col-md-4 text-left">
                                                        <div class="pull-left">
                                                            <p><b><?= $this->lang['montant_collect'].' (XOF)'; ?></b></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                                    </div>
                                                    <div class="col-xs-2 col-sm-2 col-md-2 text-right">
                                                        <div class="pull-right">
                                                            <p><b><?= $this->lang['action']; ?></b></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-1 col-sm-1 col-md-1">

                                                    </div>

                                                </div>
                                                <ul class="list-group">

                                                    <?php
                                                    $total = 0 ;
                                                    $j = 0 ;

                                                    foreach ($collectes  as $items => $collecte){
                                                        //var_dump($collect);
                                                        $total+= $collecte->montant;
                                                        ?>
                                                        <?php $j++ ;} ?>
                                                </ul>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="col-xs-4 col-sm-4 col-md-4 text-left">
                                            <div class="pull-left">
                                                <p><b><?= \app\core\Utils::getFormatMoney($total).' XOF'; ?></b></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 text-left">
                                            <div class="pull-left">
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 text-right">
                                            <div class="pull-right">
                                                <p><button type="button" style="background: #325186; border:1px solid #325186;" class="btn btn-info" data-toggle="modal"
                                                           data-target="#modalR<?= $items ?>"><?= $this->lang['verser'] ; ?></button></b></p>
                                            </div>
                                        </div>

                                        <br> <br> <br> <br><br> <br> <br> <br><br> <br>
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4 pull-left">
                                                <a href="<?= WEBROOT.'versement/versementAgent'; ?>"><button class="btn btn-success" ><span  ><?= $this->lang['btnRetour'] ; ?></button></button></a>
                                            </div>

                                        </div>


                                    </div>
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


<?php
$total = 0 ;
$i = 0 ;
foreach ($collects  as $item => $collect){?>
    <div class="modal fade bs-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" id="modal<?= $item ?>" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="panel panel-default">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="panel-title">Versement de <?php  echo $agent->prenom_agent." ".$agent->nom_agent; ?>  </h3>
                    </div>

                    <div class="panel-body">

                        <?php if($collect){
                        //var_dump($collect);
                        $total+= $collect->montant;
                        $i++;
                            ?>

                        <form class="form-horizontal" method="post" action="<?= WEBROOT.'versement/insertUnVirementCarte'; ?>">

                            <div class="form-group">
                                <div class="col-sm-offset-1 col-sm-3 col-md-3 col-xs-3">
                                    <label for="identifiant" ><?php echo $this->lang['montant_verse'] ; ?></label>
                                </div>
                                <div class="col-sm-3 col-md-3 col-xs-3">
<!--                                    <label for="identifiant"><?php /*echo $this->lang['montant_collect'] ; */?> ( XOF)</label>
-->                                </div>
                                <div class="col-sm-3 col-md-3 pull-right">
<!--                                    <label for="identifiant">--><?php //echo $this->lang['montant_verse'] ; ?><!--</label>-->
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-sm-offset-1 col-sm-3 col-md-3 col-xs-3">

<!--                                    <input type="hidden" name="date_creation" value="--><?//= $collect->date_creation; ?><!--" />-->
                                    <input type="hidden" name="fk_distributeur" value="<?= $collect->fk_distributeur; ?>" />
<!--                                    <input type="hidden" name="gie" value="--><?//= $agent->gie; ?><!--" />-->

                                    <input type="hidden" name="id" value="<?= $collect->agentId ; ?>" id="id"  checked class="flat-red"  >&nbsp;&nbsp;
                                    <?//= $collect->date_creation; ?>

                                </div>
                                <div class="col-sm-2 col-md-2 col-xs-2">
                                    <input type="hidden" class="collect"  min="0" onkeypress="return isNumberKey(event)" required id="montant_collect"  readonly name="montant_collect"  value="<?= $total; ?>">
<!--                                    <label class="pull-right" for="montant_collect" ><?/*= \app\core\Utils::getFormatMoney($collect->montant) ; */?></label>
-->                                    <span id="msg2"></span>
                                </div>
                                <div class="col-sm-3 col-md-3 pull-right">
                                    <label class="pull-right" for="montant_collect" ><?= \app\core\Utils::getFormatMoney($total) ; ?></label>
                                    <span id="msg2"></span>
                                </div>
                            </div>


                            <br>

                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-offset-2 pull-left">
                            <button type="reset" class="btn btn-danger" data-dismiss="modal"><?= $this->lang['btnAnnuler'] ; ?></button>
                        </div>
                        <div class="col-sm-7 col-md-7 col-xs-7">
                            <button type="submit" name="valider" value="valider" class="btn btn-success"><?= $this->lang['verser'] ; ?></button>
                        </div>


                    </div>
                    </form>

                    <?php }else{?>
                        <h2>Aucune collecte</h2>
                    <?php }?>
                </div>
            </div>

        </div>
    </div>

<?}?>

<?php
$total = 0 ;
$j = 0 ;
foreach ($collectes  as $items => $collecte){?>
    <div class="modal fade bs-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" id="modalR<?= $items ?>" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="panel panel-default">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="panel-title">Versement de <?php  echo $agent->prenom_agent." ".$agent->nom_agent; ?>  </h3>
                    </div>

                    <div class="panel-body">

                        <?php if($collecte){
                        $totall+= $collecte->montant;
                        $j++;
                        ?>
                        <form class="form-horizontal" method="post" action="<?= WEBROOT.'versement/insertUnVirementRechargement'; ?>">

                            <div class="form-group">
                                <div class="col-sm-offset-1 col-sm-3 col-md-3 col-xs-3">
                                    <label for="identifiant" ><?php echo $this->lang['montant_verse'] ; ?></label>
                                </div>
                                <div class="col-sm-3 col-md-3 col-xs-3">
                                    <!--                                    <label for="identifiant"><?php /*echo $this->lang['montant_collect'] ; */?> ( XOF)</label>
-->                                </div>
                                <div class="col-sm-3 col-md-3 pull-right">
                                    <!--                                    <label for="identifiant">--><?php //echo $this->lang['montant_verse'] ; ?><!--</label>-->
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-sm-offset-1 col-sm-3 col-md-3 col-xs-3">

                                    <!--                                    <input type="hidden" name="date_creation" value="--><?//= $collect->date_creation; ?><!--" />-->
                                    <input type="hidden" name="fk_distributeur" value="<?= $collect->fk_distributeur; ?>" />
                                    <!--                                    <input type="hidden" name="gie" value="--><?//= $agent->gie; ?><!--" />-->

                                </div>
                                <div class="col-sm-2 col-md-2 col-xs-2">
                                    <input type="hidden" class="collect"  min="0" onkeypress="return isNumberKey(event)" required id="montant_collect"  readonly name="montant_collect"  value="<?= $totall; ?>">
                                    <!--                                    <label class="pull-right" for="montant_collect" ><?/*= \app\core\Utils::getFormatMoney($collect->montant) ; */?></label>
-->                                    <span id="msg2"></span>
                                </div>
                                <div class="col-sm-3 col-md-3 pull-right">
                                    <label class="pull-right" for="montant_collect" ><?= \app\core\Utils::getFormatMoney($totall) ; ?></label>
                                    <span id="msg2"></span>
                                </div>
                            </div>


                            <br>

                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-offset-2 pull-left">
                            <button type="reset" class="btn btn-danger" data-dismiss="modal"><?= $this->lang['btnAnnuler'] ; ?></button>
                        </div>
                        <div class="col-sm-7 col-md-7 col-xs-7">
                            <button type="submit" name="valider" value="valider" class="btn btn-success"><?= $this->lang['verser'] ; ?></button>
                        </div>


                    </div>
                    </form>

                    <?php }else{?>
                        <h2>Aucune collecte</h2>
                    <?php }?>
                </div>
            </div>

        </div>
    </div>

<?}?>





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




