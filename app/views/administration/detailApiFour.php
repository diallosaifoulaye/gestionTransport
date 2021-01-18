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
                    <h4 class="page-title"><?php echo  $this->lang['detail_api_four']; ?></h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                    <ol class="breadcrumb">
                        <li><a href="<?php echo  WEBROOT ?>menu/menu"><?php echo  $this->lang['accueil']; ?></a></li>

                        <li><a href="<?php echo  WEBROOT.'administration/listeFournisseur'; ?>"><?php echo  $this->lang['liste_four']; ?></a></li>

                        <li class="active"><?php echo  $this->lang['detail_api_four']; ?></li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">

                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="white-box">

                        <!-- Nav tabs -->
                        <ul class="nav customtab nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#home1" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"><strong><?php echo $this->lang['infos']; ?></strong></span></a></li>
                            <li role="presentation" class=""><a href="#settings1" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs"><strong><?php echo $this->lang['methodes']; ?></strong></span></a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane fade active in" id="home1">

                                <table align="center" class="table table-no-bordered table-striped" style="width:95%;">
                                    <tbody>
                                    <tr>
                                        <td ><strong><?php echo $this->lang['libelle_api_four']; ?></strong></td>
                                        <td  align="right"><?php echo $api_four->label; ?></td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;</td>
                                        <td  align="right">&nbsp;</td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="settings1">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="white-box">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h3 class="panel-title pull-right">
                                                        <button type="button" class="open-modal btn btn-success"
                                                                data-modal-controller="Administration/ajoutWebServiceModal"
                                                                data-modal-view="<?php echo  base64_encode("administration") ?>/<?php echo  base64_encode("ajoutWebServiceModal") ?>/<?php echo $fk_api; ?>">
                                                            <i class="fa fa-plus"></i> <?php echo $this->lang['ajout_ws']; ?>
                                                        </button>
                                                    </h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table class="table table-bordered table-hover table-responsive processing"
                                                           data-url="<?php echo  WEBROOT; ?>administration/listeWebServicePro/<?php echo  $fk_api; ?>">
                                                        <thead>
                                                        <tr>
                                                            <th> <?php echo $this->lang['label_ws']; ?></th>
                                                            <th><?php echo $this->lang['thEtat']; ?></th>
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
                                    <button type="button" class="btn btn-success"><?php echo  $this->lang['btn_retour'] ; ?></button>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>





