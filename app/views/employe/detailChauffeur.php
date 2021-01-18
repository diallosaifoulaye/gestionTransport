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
                <h4 class="page-title"><?= $this->lang['detail_chauffeur']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'menu/menu'; ?>"><?= $this->lang['accueil']; ?></a></li>

                    <li><a href="<?= WEBROOT.'employe/listeChauffeur'; ?>"><?= $this->lang['listeChauffeur']; ?></a></li>

                    <li class="active"><?= $this->lang['detail_chauffeur']; ?></li>
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
                        <div class="col-sm-7" align="center">
                            <img class="img-circle" width="200"   alt="<?= $employe->photo ?>" src="<?= ASSETS."pictures/".$employe->photo ?>">
                        </div>

                        <div class="row text-center m-t-10">
                            <div class="col-md-6 b-r"><strong><?= $this->lang['prenom']; ?></strong>
                                <p><?= $employe->prenom; ?></p>
                            </div>
                            <div class="col-md-6"><strong><?= $this->lang['nom']; ?></strong>
                                <p><?= $employe->nom; ?></p>
                            </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->
                        <div class="row text-center m-t-10">
                            <div class="col-md-6 b-r"><strong><?= $this->lang['email']; ?></strong>
                                <p><?= $employe->email; ?></p>
                            </div>
                            <div class="col-md-6"><strong><?= $this->lang['telephone']; ?></strong>
                                <p><?= $employe->telephone; ?></p>
                            </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->
                        <div class="row text-center m-t-10">
                            <div class="col-md-6 b-r"><strong><?= $this->lang['adresse']; ?></strong>
                                <p><?= $employe->adresse; ?></p>
                            </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->

                        <hr>

                    </div>
                </div>
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="white-box">
                    <!-- .tabs -->
                    <ul class="nav nav-tabs tabs customtab">
                        <li class="active tab">
                            <a href="#home" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['modification_Chauffeur']; ?></span> </a>
                        </li>
                        <li class="tab">
                            <a href="#picture" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['update_photo']; ?></span> </a>
                        </li>
                    </ul>
                    <!-- /.tabs -->
                    <div class="tab-content">
                        <!-- .tabs3 -->
                        <div class="tab-pane active" id="home">

                            <form class="form-horizontal form-material" method="post" action="<?= WEBROOT ?>employe/updateChauffeurDetail" data-toggle="validator">
                                <input type="hidden" name="id" value="<?= base64_encode($employe->id); ?>" />

                                <div class="form-group">
                                    <label class="col-md-12"><?= $this->lang['prenom'].'(*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input type="text" required class="form-control"  id="prenom" name="prenom" value="<?= $employe->prenom; ?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?= $this->lang['nom'].'(*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input type="text" required class="form-control"  id="nom" name="nom" value="<?= $employe->nom; ?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12"><?=  $this->lang['email'].'(*) :'; ?></label>
                                    <div class="col-md-12">
                                        <input type="email" required="required" class="form-control"  id="email" name="email" value="<?= $employe->email; ?>" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?= $this->lang['telephone'].'(*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input type="text" required class="form-control"  id="telephone" name="telephone" value="<?= $employe->telephone; ?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?= $this->lang['adresse'].'(*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input type="text" required class="form-control"  id="adresse" name="adresse" value="<?= $employe->adresse; ?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                



                                <div class="form-group">


                                    <div class="col-sm-3 col-xs-3 pull-left">
                                        <a href="<?= WEBROOT ?>employe/listeChauffeur" >
                                            <button type="button" class="btn btn-success"><?= $this->lang['btn_retour'] ; ?></button>
                                        </a>
                                    </div>
                                    <?php if ($employe->etat == 0){?>
                                        <div class="col-sm-3 col-xs-3">
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#activeChauffeur"><?= $this->lang['btn_activer'] ; ?></button>
                                        </div>
                                    <?php }?>
                                    <?php if ($employe->etat == 1){?>
                                        <div class="col-sm-3 col-xs-3">
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#deleteChauffeur"><?= $this->lang['btn_desactiver'] ; ?></button>
                                        </div>
                                    <?php }?>
                                    <div class="col-sm-3 col-xs-3">

                                        <button type="submit" class="btn btn-warning"><?= $this->lang['modifier'] ; ?></button>
                                     
                                    </div>

                                </div>

                            </form>

                        </div>
                        <!-- /.tabs3 -->
                        <!-- .tabs3 -->
                        <div class="tab-pane " id="picture">
                            <form class="form-horizontal form-material" method="post" enctype="multipart/form-data"  action="<?= WEBROOT ?>employe/updatePhotoChauffeur" data-toggle="validator">
                                <input type="hidden" name="id" value="<?= base64_encode($employe->id); ?>" />
                                <div class="form-group">
                                    <label for="input-file-events" class="col-md-12"><?= $this->lang['photo'].' (*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input width="36" type="file" id="input-file-events" name="photo" class="dropify-fr" data-show-errors="true"
                                               data-max-file-size="1M" data-allowed-file-extensions="png jpg jpeg" data-default-file="<?= ASSETS."pictures/".$employe->photo ?>"/>
                                        <span id="msg1"></span>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="row">

                                        <div class="col-sm-3 col-xs-3 pull-left">
                                            <a href="<?= WEBROOT ?>employe/listeChauffeur" >
                                                <button type="button" class=" btn btn-success"><?= $this->lang['btn_retour'] ; ?></button>
                                            </a>
                                        </div>


                                        <?php if ($employe->etat==0){?>
                                            <div class="col-sm-3 col-xs-3">

                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#activeChauffeur"><?= $this->lang['btn_activer'] ; ?></button>

                                            </div>
                                        <?php }?>

                                        <?php if ($employe->etat==1){?>
                                            <div class="col-sm-3 col-xs-3">

                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#deleteChauffeur"><?= $this->lang['btn_desactiver'] ; ?></button>

                                            </div>
                                        <?php }?>


                                        <div class="col-sm-3 col-xs-3">

                                            <button type="submit" class="btn btn-warning"><?= $this->lang['update'] ; ?></button>

                                        </div>




                                    </div>

                                </div>
                                <div class="form-group">

                                    <input type="hidden" id="date_modification" name="date_modification" value="<?= date('Y-m-d H:i:s'); ?>">
                                    <input type="hidden" id="user_modification" name="user_modification" value="<?= $this->_USER->id; ?>">

                                </div>

                            </form>

                        </div>
                        <!-- /.tabs3 -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="deleteChauffeur" data-keyboard="false" data-backdrop="static">
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

                <form method="post" action="<?= WEBROOT ?>employe/updateChauffeurUser">
                    <input type="hidden" name="id" value="<?= base64_encode($employe->id); ?>"/>
                    <input type="hidden" name="etat" value="0"/>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger pull-left" data-dismiss="modal"><?= $this->lang['non'] ; ?></button>
                        <button type="submit" value="delete" class="btn btn-success pull-right"><?= $this->lang['oui'] ; ?></button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="activeChauffeur" data-keyboard="false" data-backdrop="static">
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
                <form method="post" action="<?= WEBROOT ?>employe/updateEtatChauffeur">
                    <input type="hidden" name="id" value="<?= base64_encode($employe->id); ?>"/>
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





