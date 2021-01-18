<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>commande/updateCommande" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modifCommande']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="code_cmde" class="control-label"><?php echo $this->lang['labcode_cmde']; ?></label>
                        <input type="text" id="code_cmde" name="code_cmde" class="form-control"
                               placeholder="Code Commande"
                               style="width: 100%" value="<?= $commande->code_cmde ?>">
                       
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="code_cmde_site"
                               class="control-label"><?php echo $this->lang['labcode_cmde_site']; ?></label>
                        <input type="text" id="code_cmde_site" name="code_cmde_site" class="form-control"
                               placeholder="Code commande du site"
                               style="width: 100%" value="<?= $commande->code_cmde_site ?>">
                      
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="pays_origine"
                               class="control-label"><?php echo $this->lang['labpays_origine']; ?></label>
                        <input type="text" id="pays_origine" name="pays_origine" class="form-control"
                               placeholder="Pays Origine"
                               style="width: 100%" value="<?= $commande->pays_origine ?>">
                        
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="site_cmde" class="control-label"><?php echo $this->lang['labsite_cmde']; ?></label>
                        <input type="text" id="site_cmde" name="site_cmde" class="form-control"
                               placeholder="Site origine"
                               style="width: 100%" value="<?= $commande->site_cmde ?>">
                        
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="pays_dest" class="control-label"><?php echo $this->lang['labpays_dest']; ?></label>
                        <input type="text" id="pays_dest" name="pays_dest" class="form-control"
                               placeholder="Pays destinataire"
                               style="width: 100%" value="<?= $commande->pays_dest ?>">
                        
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="module" class="control-label"><?php echo $this->lang['listestatutCommande']; ?></label>

                        <select id="fk_statut" name="fk_statut" class="form-control" style="width: 100%">
                           
                            <? foreach ($statut as $onestatut) { ?>
                                <option value="<?= $onestatut->id; ?>" <? if ($commande->fk_statut == $onestatut->id) echo "selected=selected" ?> > <?= $onestatut->libelle; ?></option>
                            <? } ?>
                        </select>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="ville_dest"
                               class="control-label"><?php echo $this->lang['labville_dest']; ?></label>
                        <input type="text" id="ville_dest" name="ville_dest" class="form-control"
                               placeholder="Ville destinataire"
                               style="width: 100%" value="<?= $commande->ville_dest ?>">
                        
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="description"
                               class="control-label"><?php echo $this->lang['labdescription']; ?></label>
                        <input type="text" id="description" name="description" class="form-control"
                               placeholder="Description"
                               style="width: 100%" value="<?= $commande->description ?>">
                       
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="tarif" class="control-label"><?php echo $this->lang['labtarif']; ?></label>
                        <input type="text" id="tarif" name="tarif" class="form-control" placeholder="Tarif"
                               style="width: 100%" value="<?= $commande->tarif ?>">
                       
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="date_cmde" class="control-label"><?php echo $this->lang['labdate_cmde']; ?></label>
                        <input type="text" id="date_cmde" name="date_cmde" class="form-control"
                               placeholder="Date Commande"
                               style="width: 100%" value="<?= $commande->date_cmde ?>">
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">

                        <label for="idclient" class="control-label"><?php echo $this->lang['listeclient']; ?></label>
                        <select required id="idclient" name="idclient" class="form-control"  style="width: 100%">
                            <? foreach ($client as $oneclient) { ?>
                                <option value="<?= $oneclient->id; ?>" <? if ($commande->idclient == $oneclient->id) echo "selected=selected" ?>> <?= $oneclient->FirstName. ' ' .$oneclient->LastName?></option>
                            <? } ?>
                        </select>
                        <? print $token; ?>
                        <input type="hidden" name="id" value="<?= base64_encode($commande->id) ?>">
                    </div>


                </div>
            </div>

        </div>
    </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i
                    class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i
                    class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>
</form>