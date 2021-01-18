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
                <h4 class="page-title"><?= $this->lang['detail_receveur']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'menu/menu'; ?>"><?= $this->lang['accueil']; ?></a></li>

                    <li><a href="<?= WEBROOT.'employe/listeReceveur'; ?>"><?= $this->lang['listeReceveur']; ?></a></li>



                    <li class="active"><?= $this->lang['detail_receveur']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <div class="white-box">
                    <!--                    <div class="user-bg"> <img width="100%" alt="user" src="../plugins/images/large/img1.jpg"> </div>-->
                    <div class="col-sm-7" align="center"> <img width="200" class="img-circle" src="<?= ASSETS;?>pictures/<?php echo $this->_USER->photo ;?>" alt="user"/> </div>
                    <div class="user-btm-box">
                        <!-- .row    -->


                        <div class="row text-center m-t-10">
                            <div class="col-md-6 b-r"><strong><?= $this->lang['labprenom']; ?></strong>
                                <p><?= $user->prenom; ?></p>
                            </div>
                            <div class="col-md-6"><strong><?= $this->lang['labnom']; ?></strong>
                                <p><?= $user->nom; ?></p>
                            </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->
                        <div class="row text-center m-t-10">
                            <div class="col-md-6 b-r"><strong><?= $this->lang['labemail']; ?></strong>
                                <p><?= $user->email; ?></p>
                            </div>
                            <div class="col-md-6"><strong><?= $this->lang['tel']; ?></strong>
                                <p><?= $user->telephone; ?></p>
                            </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->
                        <div class="row text-center m-t-10">
                            <div class="col-md-6 b-r"><strong><?= $this->lang['labLogin']; ?></strong>
                                <p><?= $user->login; ?></p>
                            </div>
                            <div class="col-md-6 b-r"><strong><?= $this->lang['profils']; ?></strong>
                                <p><?= $user->profil; ?></p>
                            </div>

                        </div>
                        <hr>

                    </div>
                </div>
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="white-box">
                    <!-- .tabs -->
                    <ul class="nav nav-tabs tabs customtab">
                        <li class="active tab">
                            <a href="#home" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['detail_receveur']; ?></span> </a>
                        </li>
                    </ul>
                    <!-- /.tabs -->
                    <div class="tab-content">
                        <!-- .tabs3 -->
                        <div class="tab-pane active" id="home">

                            <form class="form-horizontal form-material" method="post" action="<?= WEBROOT ?>employe/updateReceveurDetail" data-toggle="validator">
                                <input type="hidden" name="id" value="<?= base64_encode($user->id); ?>" />

                                <div class="form-group">
                                    <label class="col-md-12"><?= $this->lang['labprenom'].'(*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input type="text" required class="form-control"  id="prenom" name="prenom" value="<?= $user->prenom; ?>" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?= $this->lang['labnom'].'(*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input type="text" required class="form-control"  id="nom" name="nom" value="<?= $user->nom; ?>" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12"><?=  $this->lang['labemail'].'(*) :'; ?></label>
                                    <div class="col-md-12">
                                        <input type="email" required="required" class="form-control"  id="email" name="email" value="<?= $user->email; ?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?= $this->lang['tel'].'(*) :' ; ?></label>
                                    <div class="col-md-12">
                                        <input type="text" required class="form-control"  id="tel" name="telephone" value="<?= $user->telephone; ?>" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12"><?= $this->lang['profils'].'(*) :' ; ?></label>
                                    <div class="col-sm-12">
                                        <select class="form-control" required  name="fk_profil" style="width: 100%;" id="fk_profil" >
                                        <option value=""><?= $this->lang['profils']; ?></option>
                                        <?php foreach($profil as $cat){ ?>
                                            <option value="<?php echo $cat->id; ?>"<?php if($user->profil === $cat->profil) echo "selected=selected"; ?>> <?= $cat->profil; ?></option>
                                        <?php } ?>
                                        </select>

                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>



                                <div class="form-group">


                                    <div class="col-sm-4 col-xs-4">

                                        <a href="<?php echo WEBROOT ?>employe/listeReceveur">
                                            <button type="button" class="btn btn-success"><?= $this->lang['btn_retour'] ; ?></button>
                                        </a>

                                    </div>
                                    <div class="col-sm-4 col-xs-4">

                                        <a href="<?php echo WEBROOT ?>menu/firstConnect" >
                                            <button type="button" class="btn btn-warning"><?= $this->lang['btnmodifpwd']; ?></button>
                                        </a>

                                    </div>
                                    <div class="col-sm-4 col-xs-4">

                                        <button type="submit" class="btn btn-warning"><?= $this->lang['modifier'] ; ?></button>

                                    </div>

                                </div>

                            </form>

                        </div>
                        <!-- /.tabs3 -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="deleteReceveur" data-keyboard="false" data-backdrop="static">
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

                <form method="post" action="<?= WEBROOT ?>employe/updateReceveurUser">
                    <input type="hidden" name="id" value="<?= base64_encode($user->id); ?>"/>
                    <input type="hidden" name="etat" value="0"/>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger pull-left" data-dismiss="modal"><?= $this->lang['non'] ; ?></button>
                        <button type="submit" value="delete" class="btn btn-success pull-right"><?= $this->lang['oui'] ; ?></button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="activeReceveur" data-keyboard="false" data-backdrop="static">
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
                <form method="post" action="<?= WEBROOT ?>employe/updateEtatReceveur">
                    <input type="hidden" name="id" value="<?= base64_encode($user->id); ?>"/>
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
<script>
    $(".select2").select2();
</script>



