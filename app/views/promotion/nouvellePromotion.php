<?php
use app\core\Utils;

?>

<div id="page-wrapper">

    <div class="container-fluid" >
        <?php require_once (ROOT . 'app/views/template/notify.php'); ?>
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['gestionPromotion']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'menu/menu'; ?>">  <?php echo $this->lang['accueil']; ?></a></li>
                    <li><a href="<?= WEBROOT.'administration/index'; ?>">  <?php echo $this->lang['gestionPromotion']; ?></a></li>
                    <li class="active"><?php echo $this->lang['ajout']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row" style="background-color: #ffffff">
            <form id="validation" class="form-inline form-validator" data-type="update" role="form" name="promotion"
                  action="<?= WEBROOT ?>promotion/ajoutPromotion" method="post" >

                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="libelle" class="control-label"><?php echo $this->lang['libelle']; ?></label>
                            <input type="text" id="libelle" name="libelle" class="form-control" placeholder="<?php echo $this->lang['libelle']; ?>" required
                                   style="width: 100%">
                            <span class="help-block with-errors"> </span>

                        </div>
                        <div class="form-group col-lg-2 col-sm-2" class="form-group" style="width: 100%;padding: 10px;">
                            <label for="from1" class="control-label" ><?php echo $this->lang['date_debut']; ?> (*): </label><br/>
                            <input type="text" name="date_debut" required class="form-control" id="from1" placeholder="<?php echo $this->lang['date_deb']; ?>" style="width: 100%" autocomplete="off">&nbsp;&nbsp;
                        </div>
                        <div class="form-group col-lg-2 col-sm-2" class="form-group" style="width: 100%;padding: 10px;">
                            <label for="from2" class="control-label" ><?php echo $this->lang['date_fin']; ?> (*): </label><br/>
                            <input type="text" name="date_fin" required class="form-control" id="from2" placeholder="<?php echo $this->lang['date_deb']; ?>" style="width: 100%" autocomplete="off">&nbsp;&nbsp;
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="pourcentage_carte" class="control-label"><?php echo $this->lang['pourcentageCarte']; ?></label>
                            <input type="text" id="pourcentage_carte" name="pourcentage_carte" class="form-control" placeholder="<?php echo $this->lang['pourcentageCarte']; ?>"
                                   style="width: 100%">
                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="pourcentage_recharge" class="control-label"><?php echo $this->lang['pourcentageRecharge']; ?></label>
                            <input type="text" id="pourcentage_recharge" name="pourcentage_recharge" class="form-control" placeholder="<?php echo $this->lang['pourcentageRecharge']; ?>"
                                   style="width: 100%">
                            <span class="help-block with-errors"> </span>
                        </div>

                    <div class="col-sm-3"></div>
                </div>

                <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                <button class="btn btn-success  pull-right" id="submit" style="margin-right: 90px" data-form="my-form" type="submit" onclick="price()"><i class="fa fa-check"></i> <?php echo $this->lang['btnAjouter']; ?>
                </button>
            </form>

        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('#from1').datetimepicker({
                minDate: 0

            }

        );
        $('#from2').datetimepicker({
                minDate: 0
            }
        );
    });
</script>
