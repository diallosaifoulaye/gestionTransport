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
                <h4 class="page-title"><?= $this->lang['detail_type']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'menu/menu'; ?>"><?= $this->lang['accueil']; ?></a></li>

                    <li><a href="<?= WEBROOT.'gestion/listeType'; ?>"><?= $this->lang['listeType']; ?></a></li>

                    <li class="active"><?= $this->lang['detail_type']; ?></li>
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


                        <!-- /.row -->
                        <hr>
                        <!-- .row -->
                        <div class="row text-center m-t-10">
                            <div class="col-md-6 b-r"><strong><?= $this->lang['libelle']; ?></strong>
                                <p><?= $type_materiel->libelle; ?></p>
                            </div>
                            <div class="col-md-6 b-r"><strong><?= $this->lang['etat']; ?></strong>
                                <p><?= $type_materiel->etat; ?></p>
                            </div>

                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->


                    </div>
                </div>
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="white-box">
                    <!-- .tabs -->
                    <ul class="nav nav-tabs tabs customtab">
                        <li class="active tab">
                            <a href="#home" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['modifType']; ?></span> </a>
                        </li>
                    </ul>
                    <!-- /.tabs -->
                    <div class="tab-content">
                        <!-- .tabs3 -->
                        <div class="tab-pane active" id="home">

                            <form class="form-horizontal form-material" method="post" action="<?= WEBROOT ?>gestion/updateTypeDetail" data-toggle="validator">
                                <input type="hidden" name="rowid" value="<?= base64_encode($type_materiel->rowid); ?>" />

                                <div class="form-group">
                                    <label class="col-md-12"><?= $this->lang['libelle'].'(*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input type="text" required class="form-control"  id="libelle" name="libelle" value="<?= $type_materiel->libelle; ?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?= $this->lang['etat'].'(*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input type="text" required class="form-control"  id="etat" name="etat" value="<?= $type_materiel->etat; ?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="form-group">


                                    <div class="col-sm-3 col-xs-3 pull-left">
                                        <a href="<?= WEBROOT ?>gestion/listeType" >
                                            <button type="button" class="btn btn-success"><?= $this->lang['btn_retour'] ; ?></button>
                                        </a>
                                    </div>
                                    <?php if ($type_materiel->etat == 0){?>
                                        <div class="col-sm-3 col-xs-3">
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#activeType"><?= $this->lang['btn_activer'] ; ?></button>
                                        </div>
                                    <?php }?>
                                    <?php if ($type_materiel->etat == 1){?>
                                        <div class="col-sm-3 col-xs-3">
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#deleteType"><?= $this->lang['btn_desactiver'] ; ?></button>
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

    <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="deleteType" data-keyboard="false" data-backdrop="static">
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

                <form method="post" action="<?= WEBROOT ?>gestion/updateTypeUser">
                    <input type="hidden" name="rowid" value="<?= base64_encode($type_materiel->rowid); ?>"/>
                    <input type="hidden" name="etat" value="0"/>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger pull-left" data-dismiss="modal"><?= $this->lang['non'] ; ?></button>
                        <button type="submit" value="delete" class="btn btn-success pull-right"><?= $this->lang['oui'] ; ?></button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="activeType" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel"><?= $this->lang['activation'] ; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="text-center"><?=  $this->lang['message_activation']; ?></div>
                    </div>
                </div>
                <form method="post" action="<?= WEBROOT ?>gestion/updateEtatType">
                    <input type="hidden" name="rowid" value="<?= base64_encode($type_materiel->rowid); ?>"/>
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





