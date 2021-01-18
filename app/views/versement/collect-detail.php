<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['collectnonversees']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="#">  <?php echo $this->lang['versements']; ?></a></li>
                    <li class="active"><?php echo $this->lang['do_versement']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-md-8 col-xs-offset-2 col-sm-8">
                                <dl class="dl-horizontal">
                                    <?php

                                    if ($collecteur->etat == 0 ){
                                        $text =strtoupper($this->lang['blocked']);
                                        $classe = 'text-danger' ;

                                    }elseif($collecteur->etat == 1){
                                        $text = strtoupper($this->lang['actived']);
                                        $classe = 'text-success' ;
                                    }
                                    ?>
                                    <dt><?php echo $this->lang['receveur']; ?> : </dt>
                                    <dd><?php  echo $collects[0]->prenom." ".$collects[0]->nom; ?>  (<span class="<?= $classe ?>"><?=  $text ?></span>)</dd>
                                </dl>

                                <div class="row">
                                    <div class="dropdownPanel panel panel-default">
                                        <div class="panel-heading clearfix">
                                            <br>
                                            <div class="col-xs-4 col-sm-4 col-md-4 text-left">
                                                <div class="pull-left">
                                                    <p><b><?= $this->lang['date_collect']; ?></b></p>
                                                </div>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4">
                                                    <p><b><?= $this->lang['montant_collect'].' (XOF)'; ?></b></p>
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


                                            //var_dump($collects);exit;

                                            foreach ($collects  as $item => $collect){
                                                //var_dump($collect);
                                                $total+= $collect->montant;
                                                ?>
                                                <li class="list-group-item">
                                                    <div class="dropdown-heading" role="tab" id="heading-1">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i; ?>" aria-expanded="true" aria-controls="collapse-1">
                                                            <i class="more-less pull-right glyphicon glyphicon-chevron-down"></i>
                                                            <br>
                                                        </a>
                                                        <div class="col-xs-4 col-sm-4 col-md-4 text-left">
                                                            <div class="pull-left">
                                                                <p><?= \app\core\Utils::getDateFR($collect->date_transaction) ; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-3 col-sm-3 col-md-3">
                                                            <div style="text-align: right">
                                                                <p><b><?= \app\core\Utils::getFormatMoney($collect->montant) ; ?></b></p>
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-3 col-sm-3 col-md-3">
                                                            <div style="text-align: right">

                                                                <button type="button" style="background: #325186; border:1px solid #325186;" class="btn btn-info" data-toggle="modal"
                                                                        data-target="#modal<?= $item ?>"><?= $this->lang['verser'] ; ?></button>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-1 col-sm-1 col-md-1">

                                                        </div>

                                                        <br> <br> <br>
                                                    </div>
                                                   <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div id="collapse<?= $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-1">
                                                        <div class="panel-body">

                                                            <table class="table table-bordered table-hover table-responsive dataTable">
                                                                <thead>
                                                                <tr>
                                                                    <th>Heure transaction</th>
                                                                    <th>Nombre section</th>
                                                                    <th style="text-align: right">Montant</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                $text = str_replace('-','', $collect->date_transaction);
                                                                $lescollectes = ${'collect'.$text} ;
                                                                //var_dump($lescollectes);

                                                                foreach($lescollectes as $collecte){ ?>
                                                                    <tr>
                                                                        <td><?php echo \app\core\Utils::heure_minute_seconde($collecte->date) ; ?></td>
                                                                        <td><?php echo $collecte->nombre_section ; ?></td>

                                                                        <td align="right"><? echo \app\core\Utils::getFormatMoney($collecte->montant); ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php $i++ ;} ?>

                                        </ul>
                                    </div>
                                </div>

                                <br>
                                <div class="col-xs-4 col-sm-4 col-md-4 text-left">
                                    <div class="pull-left">
                                        <p><b><?= $this->lang['total']; ?></b></p>
                                    </div>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3">
                                    <div class="pull-right">
                                        <p><b><?= \app\core\Utils::getFormatMoney($total).' XOF'; ?></b></p>
                                    </div>
                                </div>


                                <br> <br> <br> <br><br> <br> <br> <br><br> <br> <br> <br>
                                <div class="row">
                                    <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4 pull-left">
                                        <a href="<?= WEBROOT.'versement/collectEncours'; ?>"><button class="btn btn-success" ><span  ><?= $this->lang['btnRetour'] ; ?></button></button></a>
                                    </div>

                                    <?php if ($collecteur->etat == 1){?>
                                        <div class="col-xs-4 col-lg-4 col-sm-4 pull-right">

                                            <button type="button" style="background: #325186; border:1px solid #325186;" class="btn btn-info" data-toggle="modal"
                                                    data-target="#desactiverReceveur"><?= $this->lang['desactiver_receveur'] ; ?></button>

                                        </div>
                                    <?php }?>

                                    <?php if ($collecteur->etat == 0){?>
                                        <div class="col-xs-4 col-lg-4 col-sm-4 pull-right">

                                            <button type="button" style="background: #325186; border:1px solid #325186;" class="btn btn-info" data-toggle="modal"
                                                    data-target="#desactiverReceveur"><?= $this->lang['activer_receveur'] ; ?></button>
                                        </div>
                                    <?php }?>

                                   <!-- <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4 pull-right">
                                        <button type="button" style="background: #325186; border:1px solid #325186;" class="btn btn-info" data-toggle="modal"
                                                data-target="#doVersement"><?/*= $this->lang['do_versement'] ; */?></button>

                                    </div>
-->

                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
<br/><br/>



<?php foreach ($collects  as $item => $collect){?>
    <div class="modal fade bs-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" id="modal<?= $item ?>" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="panel panel-default">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="panel-title">Versement de <?php  echo $collects[0]->prenom." ".$collects[0]->nom; ?>  </h3>
                    </div>

                    <div class="panel-body">

                        <?php if($collect){ ?>
                        <form class="form-horizontal" method="post" action="<?= WEBROOT.'versement/insertUnVersement'; ?>">

                            <div class="form-group">
                                <div class="col-sm-offset-1 col-sm-3 col-md-3 col-xs-3">
                                    <label for="identifiant" ><?php echo $this->lang['date_collect'] ; ?></label>
                                </div>
                                <div class="col-sm-3 col-md-3 col-xs-3">
                                    <label for="identifiant"><?php echo $this->lang['montant_collect'] ; ?> ( XOF)</label>
                                </div>
                                <div class="col-sm-3 col-md-3 pull-right">
                                    <label for="identifiant"><?php echo $this->lang['montant_verse'] ; ?></label>
                                </div>
                            </div>
                            <input type="hidden" name="fk_collecteur" value="<?= $collect->rowid; ?>" />

                            <div class="form-group">

                                <div class="col-sm-offset-1 col-sm-3 col-md-3 col-xs-3">

                                    <input type="hidden" name="date" value="<?= $collect->date_transaction; ?>" />

                                    <input type="checkbox" name="lid" value="<?= $collect->rowid ; ?>" id="lid"  checked class="flat-red"  >&nbsp;&nbsp;
                                    <?= $collect->date_transaction; ?>

                                </div>
                                <div class="col-sm-2 col-md-2 col-xs-2">
                                    <input type="hidden" class="collect"  min="0" onkeypress="return isNumberKey(event)" required id="montant_collect"  readonly name="montant_collect"  value="<?= $collect->montant ; ?>">
                                    <label class="pull-right" for="montant_collect" ><?= \app\core\Utils::getFormatMoney($collect->montant) ; ?></label>
                                    <span id="msg2"></span>
                                </div>
                                <div class="col-sm-3 col-md-3 pull-right">
                                    <input type="text"  class="fee" min="0" onkeypress="return isNumberKey(event)" max ="<?= $collect->montant; ?>" required id="montant_verse" name="montant_verse" value="<?= $collect->montant; ?>">
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

    <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="desactiverReceveur" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel"><?= $this->lang['activation_carte'] ; ?></h4>
                </div>
                <div class="modal-body">
                    <?php if ($collecteur->etat == 1){ ?>
                        <div class="row">
                            <div class="text-center"><?=  $this->lang['message_activation_receveur']; ?> <span class="text-primary"><?php  echo $collects[0]->prenom." ".$collects[0]->nom; ?></span></div>
                        </div>
                    <?}?>
                    <?php if ($collecteur->etat == 0){ ?>
                        <div class="row">
                            <div class="text-center"><?=  $this->lang['message_desactivation_receveur']; ?> <span class="text-primary"><?php  echo $collects[0]->prenom." ".$collects[0]->nom; ?></span></div>
                        </div>
                    <?}?>
                </div>
                <form method="post" action="<?= WEBROOT ?>versement/desactiverReceveur">

                    <input type="hidden" name="id" value="<?= base64_encode($collects[0]->rowid)  ; ?>">
                    <input type="hidden" name="etat" value="<?= $collecteur->etat; ?>">

                    <div class="modal-footer">
                        <button class="btn btn-success" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
                        <button class="btn btn-default" type="button" data-dismiss="modal"> <i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>





    <div class="modal fade bs-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" id="doVersement" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="panel panel-default">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="panel-title">Versement de <?php  echo $collects[0]->prenom." ".$collects[0]->nom; ?>  </h3>
                    </div>

                    <div class="panel-body">

                        <?php if(count($collects)>0){ ?>
                        <form class="form-horizontal" method="post" action="<?= WEBROOT.'versement/insertVersement'; ?>">

                            <div class="form-group">
                                <div class="col-sm-offset-1 col-sm-3 col-md-3 col-xs-3">
                                    <label for="identifiant" ><?php echo $this->lang['date_collect'] ; ?></label>
                                </div>
                                <div class="col-sm-3 col-md-3 col-xs-3">
                                    <label for="identifiant"><?php echo $this->lang['montant_collect'] ; ?> ( XOF)</label>
                                </div>
                                <div class="col-sm-3 col-md-3 pull-right">
                                    <label for="identifiant"><?php echo $this->lang['montant_verse'] ; ?></label>
                                </div>
                            </div>
                            <input type="hidden" name="fk_collecteur" value="<?= $collects[0]->rowid; ?>" />
                            <?php
                            $montantTotal=0;
                            $versementTotal=0;
                            $l = 1 ;
                            foreach ($collects as $item => $collect){
                                $montantTotal+=$collect->montant ;

                                ?>

                                <div class="form-group">

                                    <div class="col-sm-offset-1 col-sm-3 col-md-3 col-xs-3">

                                        <input type="hidden" name="date<?= $item ; ?>" value="<?= $collect->date_transaction; ?>" />

                                        <input type="checkbox" onclick="return false;" name="lesids[]" value="<?= $collect->rowid ; ?>" id="lesids"  checked class="flat-red"  >&nbsp;&nbsp;
                                        <?= $collect->date_transaction; ?>

                                    </div>
                                    <div class="col-sm-2 col-md-2 col-xs-2">
                                        <input type="hidden" class="collect"  min="0" onkeypress="return isNumberKey(event)" required id="montant_collect<?= $item ; ?>"  readonly name="montant_collect<?= $item; ?>"  value="<?= $collect->montant ; ?>">
                                        <label class="pull-right" for="montant_collect<?= $item ; ?>" ><?= \app\core\Utils::getFormatMoney($collect->montant) ; ?></label>
                                        <span id="msg2"></span>
                                    </div>
                                    <div class="col-sm-3 col-md-3 pull-right">
                                        <input type="text"  class="fee" min="0" onkeypress="return isNumberKey(event)" required id="montant_verse<?= $item ; ?>" name="montant_verse<?= $item ;?>" value="<?= $collect->montant; ?>">
                                        <span id="msg2"></span>
                                    </div>
                                </div>

                            <?php $l++ ;} ?>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-offset-1 col-sm-3 col-md-3 col-xs-3">
                                    <label for="identifiant" ><?= $this->lang['montantTotal'] ; ?></label>
                                </div>
                                <div class="col-sm-2 col-md-2 col-xs-2">
                                    <input type="hidden" name="montant_collect" value="<?php echo $montantTotal ;?>">
                                    <label class="pull-right" for="identifiant"><?= \app\core\Utils::getFormatMoney($montantTotal) ; ?></label>
                                </div>
                                <div class="col-sm-3 col-md-3 col-xs-3 pull-right">
                                    <input type="hidden" id="montant_verse" name="montant_verse" value="<?php echo $montantTotal ;?>">

                                    <label id="totalVersement" for="identifiant"><?= \app\core\Utils::getFormatMoney($montantTotal)  ; ?></label> XOF
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

</div>

<script>
    function dump(obj) {
        var out = '';
        for (var i in obj) {
            out += i + ": " + obj[i] + "\n";
        }

        alert(out);

        // or, if you wanted to avoid alerts...

        var pre = document.createElement('pre');
        pre.innerHTML = out;
        document.body.appendChild(pre)
    }

    function addition() {
        var total = 0;
        array = document.getElementsByClassName('fee') ;
        collect = document.getElementsByClassName('collect') ;

        for (j=0; j<array.length; j++) {
            var montantCollecte =parseInt($.trim(array[j].value)) ||0);
            var montantVerse = parseInt($.trim(collect[j].value)) ||0);
            if (montantVerse > montantCollecte){
                alert("Le montant versé: "+montantVerse+ " ne dot pas être supérieur au montant collecté: "+montantCollecte) ;
            }

            total += (parseInt($.trim(array[j].value)) ||0)
        }
        //$("#totalVersement").innerHTML = total ;
        $('#totalVersement').text(total);
        $('#montant_verse').val(parseInt(total));
    }


    $('#doVersement').click(function(){
        array = document.getElementsByClassName('fee') ;
        for (j=0; j<array.length; j++) {   array[j].addEventListener("keyup", addition) }
    });

</script>










