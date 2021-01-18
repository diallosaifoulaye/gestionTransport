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
                <h4 class="page-title"><?= $this->lang['detailTrajets']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'menu/menu'; ?>"><?= $this->lang['accueil']; ?></a></li>

                    <li><a href="<?= WEBROOT.'trajets/trajets'; ?>"><?= $this->lang['trajet']; ?></a></li>

                    <li class="active"><?= $this->lang['detailTrajets']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <div class="white-box">
                    <!--                    <div class="user-bg"> <img width="100%" alt="user" src="../plugins/images/large/img1.jpg"> </div>-->

                    <div class="col-sm-7" align="center"> <img class="img-circle" width="200"  > </div>
                    <div class="user-btm-box">
                        <!-- .row    -->
                        <div class="row text-center m-t-10">
                            <div class="col-md-6 b-r"><strong><?= $this->lang['ligne']; ?></strong>
                                <p><?= $trajet->ligne; ?></p>
                            </div>
                            <div class="col-md-6 b-r"><strong><?= $this->lang['lieu_depart']; ?></strong>
                            <p><?= $trajet->lieu_depart; ?></p>
                            </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->
                        <div class="row text-center m-t-10">

                            <div class="col-md-6"><strong><?= $this->lang['lieu_arrive']; ?></strong>
                                <p><?= $trajet->lieu_arrive; ?></p>
                            </div>
                            <div class="col-md-6"><strong><?= $this->lang['nombre_section']; ?></strong>
                                <p><?= $trajet->nombre_section; ?></p>
                            </div>
                        </div>
                            <!-- /.row -->
                            <hr>
                            <!-- .row -->
                            <div class="row text-center m-t-10">

                                <div class="col-md-6"><strong><?= $this->lang['ecart_section']; ?></strong>
                                    <p><?= $trajet->ecart_section; ?></p>
                                </div>
                                <div class="col-md-6"><strong><?= $this->lang['prix_base']; ?></strong>
                                    <p><?= $trajet->prix_base; ?></p>
                                </div>
                            </div>
                            <!-- /.row -->
                            <hr>
                            <!-- .row -->
                           <!-- <div class="row text-center m-t-10">

                                <div class="col-md-6"><strong><?/*= $this->lang['etat']; */?></strong>
                                    <p><?/*= $trajet->etat; */?></p>
                                </div>

                            </div>-->

                            <hr>
                   </div>
                </div>
            </div>
                <div class="col-md-8 col-xs-12">
                    <div class="white-box">
                        <!-- .tabs -->
                        <ul class="nav nav-tabs tabs customtab">
                            <li class="active tab">
                                <a href="#home" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['modifTrajet']; ?></span> </a>
                            </li>
                        </ul>
                        <!-- /.tabs -->
                        <div class="tab-content">
                            <!-- .tabs3 -->
                            <div class="tab-pane active" id="home">

                                <form class="form-horizontal form-material" method="post" action="<?= WEBROOT ?>trajets/updateTrajetsDetail" data-toggle="validator">
                                    <input type="hidden" name="id" value="<?= base64_encode($trajet->id); ?>" />

                                    <div class="form-group" style="width: 100%;padding: 10px;">
                                        <label for="module" class="control-label"><?php echo $this->lang["listedesligne"]?></label>

                                        <select id="ligne" name="ligne" class="form-control " style="width: 100%">
                                            <option value=""> <?php echo $trajet->ligne?></option>

                                            <?php foreach ($lignes as $oneligne) { ?>
                                                <option value="<?php echo $oneligne->id; ?>"<?php if($oneligne->id == $trajet->ligne) echo "selected=selected" ?>> <?php echo $oneligne->libelle; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?= $this->lang['lieu_depart'].'(*) :' ; ?></label>
                                        <div class="col-md-12">
                                            <input type="text" required class="form-control" id="lieu_depart" name="lieu_depart" value="<?= $trajet->lieu_depart; ?>">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?= $this->lang['lieu_arrive'].'(*) :' ; ?></label>
                                        <div class="col-md-12">
                                            <input type="text" required class="form-control"  id="lieu_arrive" name="lieu_arrive" value="<?= $trajet->lieu_arrive; ?>">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?= $this->lang['nombre_section'].'(*) :' ; ?></label>
                                        <div class="col-md-12">
                                            <input type="text" required class="form-control"  id="nombre_section" name="nombre_section" value="<?= $trajet->nombre_section; ?>">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?= $this->lang['ecart_section'].'(*) :' ; ?></label>
                                        <div class="col-md-12">
                                            <input type="text" required class="form-control"  id="ecart_section" name="ecart_section" value="<?= $trajet->ecart_section; ?>">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?= $this->lang['prix_base'].'(*) :' ; ?></label>
                                        <div class="col-md-12">
                                            <input type="text" required class="form-control"  id="prix_base" name="prix_base" value="<?= $trajet->prix_base; ?>">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <!--<div class="form-group">
                                        <label class="col-md-12"><?/*= $this->lang['etat'].'(*) :' ; */?></label>
                                        <div class="col-md-12">
                                            <input type="text" required class="form-control"  id="etat" name="etat" value="<?/*= $trajet->etat; */?>">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>-->

                                    <div class="form-group">


                                        <div class="col-sm-3 col-xs-3 pull-left">
                                            <a href="<?= WEBROOT ?>trajets/trajets" >
                                                <button type="button" class="btn btn-success"><?= $this->lang['btn_retour'] ; ?></button>
                                            </a>
                                        </div>
                                        <?php if ($trajet->etat == 0){?>
                                            <div class="col-sm-3 col-xs-3">
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#active"><?= $this->lang['btn_activer'] ; ?></button>
                                            </div>
                                        <?php }?>
                                        <?php if ($trajet->etat == 1){?>
                                            <div class="col-sm-3 col-xs-3">
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#deleteTrajets"><?= $this->lang['btn_desactiver'] ; ?></button>
                                            </div>
                                        <?php }?>
                                        <div class="col-sm-3 col-xs-3">

                                            <button type="submit" class="btn btn-warning"><?= $this->lang['modifier'] ; ?></button>

                                        </div>

                                    </div>

                                </form>

                            </div>
                            <!-- /.tabs3 -->

                            <!-- /.tabs3 -->
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </div>

    <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="deleteTrajets" data-keyboard="false" data-backdrop="static">
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

                <form method="post" action="<?= WEBROOT ?>trajets/updateEtatTrajets">
                    <input type="hidden" name="id" value="<?= base64_encode($trajet->id); ?>"/>
                    <input type="hidden" name="etat" value="0"/>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger pull-left" data-dismiss="modal"><?= $this->lang['non'] ; ?></button>
                        <button type="submit" value="delete" class="btn btn-success pull-right"><?= $this->lang['oui'] ; ?></button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="active" data-keyboard="false" data-backdrop="static">
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

                <form method="post" action="<?= WEBROOT ?>trajets/updateEtatTrajets">
                    <input type="hidden" name="id" value="<?= base64_encode($trajet->id); ?>"/>
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
    $(".select2").select2();
</script>





