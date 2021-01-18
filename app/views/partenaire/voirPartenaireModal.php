<div class="modal-header">
    <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
    <h4 class="modal-title"><?php echo $this->lang['Informations_partenaire']. ' : <b style="font-weight: 600;">' .$partenaire->raison_sociale.'</b>'; ?></h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <!-- .tabs -->
                <ul class="nav nav-tabs tabs customtab">
                    <li class="active tab">
                        <a href="#home" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?php echo $this->lang['Informations_partenaire']; ?></span> </a>
                    </li>
                    <li class="tab">
                        <a href="#picture" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?php echo $this->lang['Services_souscrits']; ?></span> </a>
                    </li>
                    <li class="tab">
                        <a href="#userPartenaire" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?php echo $this->lang['utilisateur']; ?></span> </a>
                    </li>
                </ul>
                <!-- /.tabs -->
                <div class="tab-content">
                    <!-- .tabs3 -->
                    <div class="tab-pane active" id="home">
                        <div class="form-group" style="width: 100%;">
                            <label for="raison_sociale" class="control-label"><?php echo $this->lang['raison_sociale']; ?></label>
                            <input type="text" id="raison_sociale" name="raison_sociale" value="<?= $partenaire->raison_sociale; ?>" class="form-control"
                                   placeholder="<?php echo $this->lang['raison_sociale']; ?>" style="width: 100%" disabled>
                        </div>

                        <div class="form-group" style="width: 100%;">
                            <label for="telephone" class="control-label"><?php echo $this->lang['tel_partenaire']; ?></label>
                            <input type="tel" id="telephone" name="telephone" value="<?php echo $partenaire->telephone; ?>"
                                   class="form-control" placeholder="<?php echo $this->lang['tel_partenaire']; ?>" style="width: 100%" disabled>
                        </div>

                        <div class="form-group" style="width: 100%;">
                            <label for="email" class="control-label"><?php echo $this->lang['email_partenaire']; ?></label>
                            <input type="email" id="email" name="email" value="<?php echo $partenaire->email; ?>" class="form-control"
                                   placeholder="<?php echo $this->lang['email_partenaire']; ?>" style="width: 100%" disabled>
                        </div>

                        <div class="form-group" style="width: 100%;">
                            <label for="adresse" class="control-label"><?php echo $this->lang['adresse_partenaire']; ?></label>
                            <input type="text" id="adresse" name="adresse" value="<?php echo $partenaire->adresse; ?>"
                                   class="form-control" placeholder="<?php echo $this->lang['adresse_partenaire']; ?>" style="width: 100%" disabled>
                        </div>

                    </div>
                    <!-- /.tabs3 -->
                    <!-- .tabs3 -->
                    <div class="tab-pane " id="picture">
                        <div class="panel-group" id="accordion">
                            <?php foreach($allCatServices as $mod){?>
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background: #e7e7e7;">

                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $mod->rowid; ?>"><?= $mod->label; ?></a>
                                        </h4>

                                    </div>
                                    <div id="collapse<?= $mod->rowid; ?>" class="panel-wrapper panel-collapse collapse <? if($mod->rowid==1){echo 'in';}else{echo '';} ?>">
                                        <div class="panel-body">
                                            <table class="table table-hover table-responsive">
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
                                                        <td align="center"><input disabled id="check_<?= $mod->rowid; ?>" onclick="recupVal(this)" class="check<?= $mod->rowid; ?>" type="checkbox" name="fk_service[]" value="<?= $action->rowid; ?>" <?php if(in_array($action->rowid, $actions_autorisees)) echo 'checked' ?> /></td>
                                                        <td><label for="checkbox"><?= $action->label; ?></label></td>
                                                        <td><input disabled  autocomplete="off" onchange="sva(this);" type="text" class="tio<?= $mod->rowid; ?> num" id="sva_<?= $mod->rowid; ?>" name="pourcentage_sva[]" value="<?php if(in_array($action->rowid, $actions_autorisees)){echo $pourcentagePartenaire->pourcentage_sva;}else{echo '';} ?>" style="height: 30px;" <?php if(!in_array($action->rowid, $actions_autorisees)) echo "readonly='readonly'" ?>>&nbsp;<span class="errmsg"></span></td>
                                                        <td><input disabled autocomplete="off" onchange="sva(this);" type="text" class="tio<?= $mod->rowid; ?> num" id="fourn_<?= $mod->rowid; ?>" name="pourcentage_fournisseur[]" value="<?php if(in_array($action->rowid, $actions_autorisees)){echo $pourcentagePartenaire->pourcentage_fournisseur;}else{echo '';} ?>" style="height: 30px;" <?php if(!in_array($action->rowid, $actions_autorisees)) echo "readonly='readonly'" ?>>&nbsp;<span class="errmsg"></span></td>
                                                        <td><input disabled autocomplete="off" onchange="sva(this);" type="text" class="tio<?= $mod->rowid; ?> num" id="partn_<?= $mod->rowid; ?>" name="pourcentage_partenaire[]" value="<?php if(in_array($action->rowid, $actions_autorisees)){echo $pourcentagePartenaire->pourcentage_partenaire;}else{echo '';} ?>" style="height: 30px;" <?php if(!in_array($action->rowid, $actions_autorisees)) echo "readonly='readonly'" ?>>&nbsp;<span class="errmsg"></span></td>
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
                    <!-- /.tabs3 -->
                    <!-- .tabs3 -->
                    <div class="tab-pane" id="userPartenaire">
                        <table class="table color-bordered-table muted-bordered-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Login</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $allUserPart = \app\core\Utils::getModel('partenaire')->allUserPart($fk_partenaire);
                            foreach($allUserPart as $action){?>
                                <tr>
                                    <td><?= $action->rowid; ?></td>
                                    <td><?= $action->nom_complet; ?></td>
                                    <td><?= $action->login; ?></td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>

                    </div>
                    <!-- /.tabs3 -->
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-danger" type="button" data-dismiss="modal"> <i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
</div>