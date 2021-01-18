<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['detailCommande1'];
                    echo $commande->code_cmde ?></h4></div>

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

                <table class="table table-striped table-hover table-responsive ">
                    <tr>
                        <th><?php echo $this->lang['labcode_cmde']; ?></th>
                        <td><?= $commande->code_cmde; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang['labcode_cmde_site']; ?></th>
                        <td><?= $commande->code_cmde_site; ?></td>

                    </tr>
                    <tr>
                        <th><?php echo $this->lang['labpays_origine']; ?></th>
                        <td><?= $commande->pays_origine; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang['labsite_cmde']; ?></th>
                        <td><?= $commande->site_cmde; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang['labpays_dest']; ?></th>
                        <td><?= $commande->pays_dest; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang['labville_dest']; ?></th>
                        <td><?= $commande->ville_dest; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang['labdescription']; ?></th>
                        <td><?= $commande->description; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang['labtarif']; ?></th>
                        <td><?= $commande->tarif; ?></td>

                    </tr>
                    <tr>
                        <th><?php echo $this->lang['labdate_cmde']; ?></th>
                        <td><?= $commande->date_cmde; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang['leclient']; ?></th>
                        <td><?= $client->FirstName. ' ' .$client->LastName; ?></td>
                    </tr>
                <tr>
                        <th><?php echo $this->lang['statutCommande']; ?></th>
                        <td><?= $statut->libelle;?></td>
                    </tr>

                </table>
                <? print $token;?>

            </div>
            <div class="row col-lg-12">
                <h3 class="panel-title pull-right">
                    <button type="button" class="open-modal btn btn-success" data-modal-controller="commande/modifCommandeModal" data-modal-view="<?= base64_encode("commande") ?>/<?= base64_encode("modifCommandeModal") ?>/<?= base64_encode($commande->id) ?>">
                        <i class="fa fa-check"></i>
                        <?php echo $this->lang['btnModifier']; ?>
                    </button>

                   <!-- <?/* if ($commande->etat == 1 ){  */?>
                        <a  class="action confirm-modal "  href="<?/*= WEBROOT."commande/deactivate/".base64_encode($commande->id);*/?>" >
                            <button type="button" class="btn btn-primary "  >
                                <i class="fa fa-check"></i>
                                <?php /*echo $this->lang['btnDesactiver']; */?>
                            </button></a>
                    <?/* }else{  */?>
                        <a  class="action confirm-modal "  href="<?/*= WEBROOT."commande/activate/".base64_encode($commande->id);*/?>" >
                            <button type="button" class="btn btn-primary "  >
                                <i class="fa fa-check"></i>
                                <?php /*echo $this->lang['btnActiver']; */?>
                            </button></a>
                    --><?/* } */?>


                    <a href="<?= WEBROOT."commande/listeCommande";?>">  <button type="button" class="btn btn-default">
                            <i  class="fa fa-times"></i> <?php echo $this->lang['btnRetour']; ?> </button></a>
                </h3>
            </div>
        </div>


    </div>
</div>