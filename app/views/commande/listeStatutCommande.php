<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['listestatutCommande']; ?></h4></div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="#"> <?php echo $this->lang['tabBord']; ?></a></li>
                    <li class="active"><?php echo $this->lang['listestatutCommande']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row bg-title">
            <div class="row col-lg-12">
                <h3 class="panel-title pull-right">

                    <button type="button" class="open-modal btn btn-default"
                            data-modal-controller="commande/ajoutStCommandeModal"
                            data-modal-view="<?= base64_encode("commande") ?>/<?= base64_encode("ajoutStCommandeModal") ?>">
                        <?php echo $this->lang['btnAjouter']; ?>
                    </button>

                </h3>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover table-responsive processing"
                           data-url="<?= WEBROOT; ?>commande/listeStatutCommandePro">
                        <thead>
                        <tr>
                             <th><?php echo $this->lang['labstcmde']; ?></th>
                            <th><?php echo $this->lang['labAction']; ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


