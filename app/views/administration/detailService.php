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
            <?php require_once (ROOT . 'app/views/template/notify.php'); ?>

            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title"><?= $this->lang['detail_service']; ?></h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                    <ol class="breadcrumb">
                        <li><a href="<?= WEBROOT ?>menu/menu"><?= $this->lang['accueil']; ?></a></li>

                        <li><a href="<?= WEBROOT.'administration/listeService'; ?>"><?= $this->lang['list_service']; ?></a></li>

                        <li class="active"><?= $this->lang['detail_service']; ?></li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">

                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="white-box">

                        <!--<h3 class="box-title">Custom Design Tab</h3>
                        <p class="text-muted m-b-30">Use default tab with class <code>customtab</code></p>-->

                        <!-- Nav tabs -->
                        <ul class="nav customtab nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#home1" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"><strong><?php echo $this->lang['infos']; ?></strong></span></a></li>
                            <li role="presentation" class=""><a href="#profile1" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs"><strong><?php echo $this->lang['tarifs_frais']; ?></strong></span></a></li>
                            <li role="presentation" class=""><a href="#messages1" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs"><strong><?php echo $this->lang['disponibilite_du_pays']; ?></strong></span></a></li>
                            <li role="presentation" class=""><a href="#settings1" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs"><strong><?php echo $this->lang['erreurs_ws']; ?></strong></span></a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane fade active in" id="home1">

                                <table align="center" class="table table-no-bordered table-striped" style="width:95%;">
                                    <tbody>
                                    <tr>
                                        <td ><strong><?php echo $this->lang['thlibService']; ?></strong></td>
                                        <td  align="right"><?php echo $service->service; ?></td>
                                    </tr>

                                    <tr>
                                        <td><strong><?php echo $this->lang['thlibCatService']; ?></strong></td>
                                        <td  align="right"><?php echo $service->categorie; ?></td>
                                    </tr>

                                    <tr>
                                        <?php if($service->disponibilite == '1'){?>
                                            <td ><strong><?php echo $this->lang['disponibilite_partout']; ?></strong></td>
                                            <td  align="right"><?php echo $this->lang['oui']; ?></td>
                                        <?php }else{?>
                                            <td ><strong><?php echo $this->lang['disponibilite_partout']; ?></strong></td>
                                            <td  align="right"><?php echo $this->lang['non']; ?></td>
                                        <?php }?>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;</td>
                                        <td  align="right">&nbsp;</td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="profile1">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="white-box">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table class="table table-bordered table-hover table-responsive processing"
                                                           data-url="<?= WEBROOT; ?>administration/listeTarifFraisPro/<?= $fk_service; ?>">
                                                        <thead>
                                                        <tr>
                                                            <th><?php echo $this->lang['montant_deb']; ?></th>
                                                            <th><?php echo $this->lang['montant_fin']; ?></th>
                                                            <th><?php echo $this->lang['valeur']; ?></th>
                                                            <th><?php echo $this->lang['labAction']; ?></th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="messages1">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="white-box">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table class="table table-bordered table-hover table-responsive processing"
                                                           data-url="<?= WEBROOT; ?>administration/listeDispoServiceInCountryPro/<?= $fk_service; ?>">
                                                        <thead>
                                                        <tr>
                                                            <th><?php echo $this->lang['thService']; ?></th>
                                                            <th><?php echo $this->lang['pays']; ?></th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="settings1">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="white-box">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h3 class="panel-title pull-right">

                                                        <button type="button" class="open-modal btn btn-success"
                                                                data-modal-controller="Administration/ajoutErrorWSModal"
                                                                data-modal-view="<?= base64_encode("administration") ?>/<?= base64_encode("ajoutErrorWSModal") ?>">
                                                            <i class="fa fa-plus"></i> <?php echo $this->lang['btnAjouterErrorWS']; ?>
                                                        </button>
                                                    </h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table class="table table-bordered table-hover table-responsive processing"
                                                           data-url="<?= WEBROOT; ?>administration/listeErrorWSPro/<?= $fk_service; ?>">
                                                        <thead>
                                                        <tr>
                                                            <th><?php echo $this->lang['thlibCode']; ?></th>
                                                            <th><?php echo $this->lang['thlibFr']; ?></th>
                                                            <th><?php echo $this->lang['thlibEn']; ?></th>
                                                            <th><?php echo $this->lang['labAction']; ?></th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div align="center">
                                <a href="javascript:history.back()">
                                    <button type="button" class="btn btn-success"><?= $this->lang['btn_retour'] ; ?></button>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>





