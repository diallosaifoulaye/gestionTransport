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
                <h4 class="page-title"><?= $this->lang['detailRes']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'menu/menu'; ?>"><?= $this->lang['accueil']; ?></a></li>

                    <li><a href="<?= WEBROOT.'admin/listeUtilisateur'; ?>"><?= $this->lang['list_users']; ?></a></li>

                    <li class="active"><?= $this->lang['detailRes']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <div class="white-box">
                    <!--                    <div class="user-bg"> <img width="100%" alt="user" src="../plugins/images/large/img1.jpg"> </div>-->
                    <div class="col-sm-7" align="center">  </div>
                    <div class="user-btm-box">
                        <!-- .row    -->
                        <?//= var_dump($responsableGie->photo); exit(); ?>
                        <div class="col-sm-7" align="center">
                            <img class="img-circle" width="200"   alt="<?= $responsableGie->photo ?>" src="<?= ASSETS.'pictures/'.$responsableGie->photo  ?>">
                        </div>

                        <div class="row text-center m-t-10">
                            <div class="col-md-6 b-r"><strong><?= $this->lang['labnom']; ?></strong>
                                <p><?= $responsableGie->nom; ?></p>
                            </div>
                            <div class="col-md-6"><strong><?= $this->lang['labprenom']; ?></strong>
                                <p><?= $responsableGie->prenom; ?></p>
                            </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->
                        <div class="row text-center m-t-10">
                            <div class="col-md-6 b-r"><strong><?= $this->lang['labemail']; ?></strong>
                                <p><?= $responsableGie->email; ?></p>
                            </div>
                            <div class="col-md-6 "><strong><?= $this->lang['telephone']; ?></strong>
                                <p><?= $responsableGie->telephone; ?></p>
                            </div>

                        </div>

                        <!-- /.row -->


                    </div>
                </div>
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="white-box">
                    <!-- .tabs -->
                    <ul class="nav nav-tabs tabs customtab">
                        <li class="active tab">
                            <a href="#home" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['modification_Respo']; ?></span> </a>
                        </li>
                        <li class="tab">
                            <a href="#picture" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['update_photo']; ?></span> </a>
                        </li>
                    </ul>
                    <!-- /.tabs -->
                    <div class="tab-content">
                        <!-- .tabs3 -->
                        <div class="tab-pane active" id="home">

                            <form class="form-horizontal form-material" method="post" action="<?= WEBROOT ?>admin/updateResponDetail" data-toggle="validator">
                                <input type="hidden" name="id" value="<?= base64_encode($responsableGie->id); ?>" />

                                <div class="form-group">
                                    <label class="col-md-12"><?= $this->lang['labnom'].'(*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input type="text" required class="form-control"  id="nom" name="nom" value="<?= $responsableGie->nom; ?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?= $this->lang['labprenom'].'(*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input type="text" required class="form-control"  id="prenom" name="prenom" value="<?= $responsableGie->prenom; ?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?= $this->lang['labemail'].'(*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input type="text" required class="form-control"  id="email" name="email" value="<?= $responsableGie->email; ?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?= $this->lang['telephone'].'(*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input type="text" required class="form-control"  id="telephone" name="telephone" value="<?= $responsableGie->telephone; ?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <input type="hidden" id="date_modification" name="date_modification" value="<?= date('Y-m-d H:i:s'); ?>">

                                </div>



                                <div class="form-group">


                                    <div class="col-sm-3 col-xs-3 pull-left">
                                        <a href="<?= WEBROOT ?>admin/listeResGiePro" >
                                            <button type="button" class="btn btn-success"><?= $this->lang['btn_retour'] ; ?></button>
                                        </a>

                                    </div>
                                    <?php if ($responsableGie->etat == 0){?>
                                        <div class="col-sm-3 col-xs-3">
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#activeBus"><?= $this->lang['btn_activer'] ; ?></button>
                                        </div>
                                    <?php }?>
                                    <?php if ($responsableGie->etat == 1){?>
                                        <div class="col-sm-3 col-xs-3">
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#deleteBus"><?= $this->lang['btn_desactiver'] ; ?></button>
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
                            <form class="form-horizontal form-material" method="post" enctype="multipart/form-data"  action="<?= WEBROOT ?>admin/updatePhoto" data-toggle="validator">
                                <input type="hidden" name="id" value="<?= base64_encode($responsableGie->id); ?>" />
                                <div class="form-group">
                                    <label for="input-file-events" class="col-md-12"><?= $this->lang['labphoto'].' (*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input width="36" type="file" id="input-file-events" name="photo" class="dropify-fr" data-show-errors="true"
                                               data-max-file-size="1M" data-allowed-file-extensions="png jpg jpeg" data-default-file="<?= ASSETS.'pictures/'.$responsableGie->photo  ?>"
                                        <span id="msg1"></span>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="row">

                                        <div class="col-sm-3 col-xs-3 pull-left">
                                            <a href="<?= WEBROOT ?>admin/listeResGiePro" >
                                                <button type="button" class=" btn btn-success"><?= $this->lang['btn_retour'] ; ?></button>
                                            </a>
                                        </div>


                                        <?php if ($responsableGie->etat==0){?>
                                            <div class="col-sm-3 col-xs-3">

                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#activeBus"><?= $this->lang['btn_activer'] ; ?></button>

                                            </div>
                                        <?php }?>

                                        <?php if ($responsableGie->etat==1){?>
                                            <div class="col-sm-3 col-xs-3">

                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#deleteBus"><?= $this->lang['btn_desactiver'] ; ?></button>

                                            </div>
                                        <?php }?>


                                        <div class="col-sm-3 col-xs-3">

                                            <button type="submit" class="btn btn-warning"><?= $this->lang['update'] ; ?></button>

                                        </div>

                                        <!--div class="col-sm-3 col-xs-3 pull-right">

                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#validation"><?= $this->lang['reinitialiser']; ?></button>

                                        </div-->


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

    <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="deleteBus" data-keyboard="false" data-backdrop="static">
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

                <form method="post" action="<?= WEBROOT ?>admin/updateEtatRespon">
                    <input type="hidden" name="id" value="<?= base64_encode($responsableGie->id); ?>"/>
                    <input type="hidden" name="etat" value="0"/>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger pull-left" data-dismiss="modal"><?= $this->lang['non'] ; ?></button>
                        <button type="submit" value="delete" class="btn btn-success pull-right"><?= $this->lang['oui'] ; ?></button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="activeBus" data-keyboard="false" data-backdrop="static">
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

                <form method="post" action="<?= WEBROOT ?>admin/updateEtatRespon">
                    <input type="hidden" name="id" value="<?= base64_encode($responsableGie->id); ?>"/>
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





