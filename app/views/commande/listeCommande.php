<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['listeCommande']; ?></h4></div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="#"> <?php echo $this->lang['tabBord']; ?></a></li>
                    <li class="active"><?php echo $this->lang['listeCommande']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row bg-title">
            <div class="row col-lg-12">
                <h3 class="panel-title pull-right">
                    <? if ($this->_USER) {
                        if ($this->_USER->admin == 1 || \app\core\Utils::getModel('commande')->__authorized($this->_USER->idprofil, 'commande', 'ajoutCommandeModal') > 0) { ?>
                            <button type="button" class="open-modal btn btn-default"
                                    data-modal-controller="commande/ajoutCommandeModal"
                                    data-modal-view="<?= base64_encode("commande") ?>/<?= base64_encode("ajoutCommandeModal") ?>">
                                <?php echo $this->lang['btnAjouter']; ?>
                            </button>
                        <?
                        }
                    } ?>
                </h3>
            </div>

            <div class="row col-lg-12">
                <table class="table table-bordered table-hover table-responsive processing"
                       data-url="<?= WEBROOT; ?>commande/listeCommandePro">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang['labcode_cmde']; ?></th>
                        <th><?php echo $this->lang['labcode_cmde_site']; ?></th>
                        <th><?php echo $this->lang['labpays_origine']; ?></th>
                        <th><?php echo $this->lang['labsite_cmde']; ?></th>
                        <th><?php echo $this->lang['labpays_dest']; ?></th>
                        <th><?php echo $this->lang['labville_dest']; ?></th>
                        <th><?php echo $this->lang['labdescription']; ?></th>
                        <th><?php echo $this->lang['labtarif']; ?></th>
                        <th><?php echo $this->lang['labdate_cmde']; ?></th>
                        <th><?php echo $this->lang['labetat']; ?></th>
                        <? if ($this->_USER) {
                            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('commande')->__authorized($this->_USER->idprofil, 'commande', 'modifCommandeModal') > 0) { ?>
                                <th><?php echo $this->lang['labAction']; ?></th><?
                            }
                        } ?>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>

