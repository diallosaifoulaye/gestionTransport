<style>
    .errmsg
    {
        color: red;
    }
</style>
<form id="validation" class="form-inline form-validator" data-type="update" role="form" name="form" action="<?= WEBROOT ?>partenaire/ajoutServicePartenaire" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['config_service_partenaire']. ' : <b style="font-weight: 600;">' .$partenaire->raison_sociale.'</b>' ; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">

                <div class="box-body">



                    <div class="padding_box">
                        <div class="row">

                            <div class="panel-group" id="accordion">
                                <?php foreach($allCatServices as $mod){?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background: #e7e7e7;">

                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $mod->rowid; ?>"></a>
                                            </h4>
                                            <?= $mod->label.'  '; ?>
                                        </div>
                                        <div id="collapse<?= $mod->rowid; ?>" class="panel-wrapper panel-collapse collapse <? if($mod->rowid==1){echo 'in';}else{echo '';} ?>">
                                            <div class="panel-body">
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Services</th>
                                                        <th>%sunusva</th>
                                                        <th>%fournisseurs</th>
                                                        <th>%partenaires</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $allActions = \app\core\Utils::getModel('partenaire')->allServiceyCat($mod->rowid);
                                                    foreach($allActions as $action){
                                                        $pourcentagePartenaire = \app\core\Utils::getModel('partenaire')->pourcentage_partenaire($fk_partenaire,$action->rowid);
                                                        ?>
                                                        <tr class="tr<?= $mod->rowid; ?>">
                                                            <td align="center">
                                                                <input id="check_<?= $action->rowid; ?>" onclick="recupVal(this)" class="check<?= $action->rowid; ?>" type="checkbox"  value="<?= $action->rowid; ?>" <?php if(in_array($action->rowid, $actions_autorisees)) echo 'checked' ?> />
                                                                <input id="chec_<?= $action->rowid; ?>" type="hidden" name="fk_service[]" value="<?= $action->rowid; ?>">
                                                            </td>
                                                            <td><label for="checkbox"><?= $action->label; ?></label></td>
                                                            <td><input  autocomplete="off" onchange="sva(this);" type="text" class="tio<?= $action->rowid; ?> num" id="sva_<?= $action->rowid; ?>" name="pourcentage_sva[]" value="<?php if(in_array($action->rowid, $actions_autorisees)){echo $pourcentagePartenaire->pourcentage_sva;}else{echo '';} ?>" style="height: 30px;" <?php if(!in_array($action->rowid, $actions_autorisees)) echo "readonly" ?>>&nbsp;<span class="errmsg"></span></td>
                                                            <td><input autocomplete="off" onchange="sva(this);" type="text" class="tio<?= $action->rowid; ?> num" id="fourn_<?= $action->rowid; ?>" name="pourcentage_fournisseur[]" value="<?php if(in_array($action->rowid, $actions_autorisees)){echo $pourcentagePartenaire->pourcentage_fournisseur;}else{echo '';} ?>" style="height: 30px;" <?php if(!in_array($action->rowid, $actions_autorisees)) echo "readonly" ?>>&nbsp;<span class="errmsg"></span></td>
                                                            <td><input autocomplete="off" onchange="sva(this);" type="text" class="tio<?= $action->rowid; ?> num" id="partn_<?= $action->rowid; ?>" name="pourcentage_partenaire[]" value="<?php if(in_array($action->rowid, $actions_autorisees)){echo $pourcentagePartenaire->pourcentage_partenaire;}else{echo '';} ?>" style="height: 30px;" <?php if(!in_array($action->rowid, $actions_autorisees)) echo "readonly" ?>>&nbsp;<span class="errmsg"></span></td>
                                                        </tr>
                                                    <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>


                        </div>
                    </div>


                </div>
                <input type="hidden" name="fk_partenaire" value="<?= $fk_partenaire; ?>">

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" id="confirm" data-form="my-form" type="button"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
        <button class="btn btn-danger" type="button" data-dismiss="modal"> <i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>
</form>
<script>
    <?php foreach($allCatServices as $module2){?>
    $("#checkAll<?= $module2->rowid; ?>").click(function () {
        $(".check<?= $module2->rowid; ?>").prop('checked', $(this).prop('checked'));
    });
    <?php } ?>
    function recupVal(obj){
        var idcheck = $(obj).attr("id");
        //var valuee = $(obj).attr("value");
        //alert(valuee);
        var checki = idcheck.split("_");
        var i = checki[1];
        if($(obj).prop('checked')){
            $('.tio'+i).removeAttr("readonly");

        }else{
            $('.tio'+i).attr("readonly",true);
            $('.tio'+i).val('');
            //$('#validation')[0].reset();
        }
    }

    function sva(obj){
        var id = $(obj).attr("id");
        var checki = id.split("_");
        var i = checki[1];
        var sva =  $('#sva_'+i).val();
        var fourn =  $('#fourn_'+i).val();
        var partn =  $('#partn_'+i).val();
        var tot = parseInt(sva)+parseInt(fourn)+parseInt(partn);
        console.log(tot);
        if(tot != 100){
            $('#confirm').attr('disabled','disabled');
            $('#confirm').addClass('disabled');
            swal({
                title: "Répartition des frais de services",
                text: "Veuillez équilibrer la répartition",
                type: "warning"
            });
        }else{
            $('#confirm').removeAttr('disabled');
            $('#confirm').removeClass('disabled');
            $('#confirm').attr('type', 'submit');

        }

    }
    $(".num").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $(".errmsg").html("veuillez saisir un chiffre").show().fadeOut("slow");
            return false;
        }
    });

</script>