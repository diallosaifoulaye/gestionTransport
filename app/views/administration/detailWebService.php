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
                    <h4 class="page-title"><?= $this->lang['detail_ws']; ?></h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                    <ol class="breadcrumb">
                        <li><a href="<?= WEBROOT ?>menu/menu"><?= $this->lang['accueil']; ?></a></li>

                        <li><a href="<?= WEBROOT.'administration/listeWebService'; ?>"><?= $this->lang['liste_ws']; ?></a></li>

                        <li class="active"><?= $this->lang['detail_ws']; ?></li>
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
                            <li role="presentation" class=""><a href="#settings1" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs"><strong><?php echo $this->lang['code_retour']; ?></strong></span></a></li>
                            <li role="presentation" class=""><a href="#messages1" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs"><strong><?php echo $this->lang['parametre']; ?></strong></span></a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane fade active in" id="home1">

                                <table align="center" class="table table-no-bordered table-striped" style="width:95%;">
                                    <tbody>
                                    <tr>
                                        <td ><strong><?php echo $this->lang['label_ws']; ?></strong></td>
                                        <td  align="right"><?php echo $ws->label; ?></td>
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
                                                                data-modal-controller="Administration/ajoutCodeRetourModal"
                                                                data-modal-view="<?= base64_encode("administration") ?>/<?= base64_encode("ajoutCodeRetourModal") ?>/<?= $fk_webservice; ?>">
                                                            <i class="fa fa-plus"></i> <?php echo $this->lang['ajout_cr']; ?>
                                                        </button>
                                                    </h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table class="table table-bordered table-hover table-responsive processing"
                                                           data-url="<?= WEBROOT; ?>administration/listeCodeRetourPro/<?= $fk_webservice; ?>">
                                                        <thead>
                                                        <tr>
                                                            <th> <?php echo $this->lang['code_cr']; ?></th>
                                                            <th><?php echo $this->lang['msg_fr_cr']; ?></th>
                                                            <th><?php echo $this->lang['msg_en_cr']; ?></th>
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

                            <div role="tabpanel" class="tab-pane fade" id="messages1">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3 class="panel-title pull-right">
                                            <button type="button" class="open-modal btn btn-success"
                                                    data-modal-controller="Administration/parametrageWSModal"
                                                    data-modal-view="<?= base64_encode("administration") ?>/<?= base64_encode("parametrageWSModal") ?>/<?= $fk_webservice; ?>">
                                                <i class="fa fa-plus"></i> <?php echo $this->lang['parametre']; ?>
                                            </button>
                                        </h3>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered table-hover table-responsive processing"
                                               data-url="<?= WEBROOT; ?>administration/listeParametrePro/<?= $fk_webservice; ?>">
                                            <thead>
                                            <tr>
                                                <th> <?php echo $this->lang['parametre']; ?></th>
                                                <th><?php echo $this->lang['nbre_parametre']; ?></th>
                                                <th><?php echo $this->lang['labAction']; ?></th>
                                            </tr>
                                            </thead>
                                        </table>
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





<script>

    var i =0;
    $('#add').click(function(){

        var parametre = $("#parametre").val();

        if(parametre != '')
        {
            if (){
                swal({
                    title: "<?= $this->lang['Msg_error']; ?>",
                    text: "<?= $this->lang['Msg_erreur']; ?>",
                    type: "warning"
                });
            }
            else {
                i++;
                $('#dynamic_field').append(
                    '<tr class="" id="row' + i + '">' +
                    '<td>' + parametre + '<input type="hidden" name="parametre[]" value="' + parametre + '" ></td>' +
                    '<td><button id="minus" data-i="' + i + '" class="btn btn-info btn-outline btn-circle btn-sm m-r-5 btn_remove" style="background-color:#ececec;margin-left: 30px;margin-bottom: 30px;"><i class="fa fa-minus"></i></button></td>' +
                    '</tr>');
                $('#my-form')[0].reset();
                $('#lebtnValider').removeAttr('disabled');
                $('#lebtnValider').removeClass('disabled');
                document.getElementById('nbrow').value = i + 1;
                document.getElementById("parametre").value = parametre;
                $('#montant_deb').prop('readonly','true');
            }
        }
        else
        {
            $('#lebtnValider').attr('disabled','disabled');
            $('#lebtnValider').addClass('disabled');
            swal({
                title: "<?= $this->lang['Msg_error']; ?>",
                text: "<?= $this->lang['Msg_par_req']; ?>",
                type: "warning"
            });
        }
    });
    $(document).on('click', '.btn_remove', function(){

        var button_id = $(this).data('i');
        $('#row'+button_id+'').remove();
        document.getElementById('nbrow').value = parseInt(document.getElementById('nbrow').value)-1 ;

        $('#lebtnValider').attr('disabled','disabled');
        $('#lebtnValider').addClass('disabled');
        swal({
            title: "<?= $this->lang['Msg_error']; ?>",
            text: "<?= $this->lang['Msg_Ecr']; ?>",
            type: "warning"
        });
    });
    function checkBeforeSubmit() {
        $('#lebtnValider').attr('type','submit');
        $("#my-form").submit();
    }

</script>