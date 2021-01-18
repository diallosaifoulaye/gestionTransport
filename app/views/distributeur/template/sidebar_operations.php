<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3>
                <span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i>
                    <i class="ti-close visible-xs"></i>
                </span>
                <span class="hide-menu">Navigation</span>
            </h3>
        </div>
        <?php include("profil_user.php"); ?>
        <ul class="nav" id="side-menu">
            <?php if($this->_USER->type==1){?>
                <li>
                    <a href="#" class="waves-effect"><i class="mdi mdi-account-multiple fa-fw"></i>
                        <span class="hide-menu"><?php echo $this->lang['gestion_rechargement']; ?><span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="#" class="open-modal"
                               data-modal-controller="distributeur/distrib/ajoutRechargementModal"
                               data-modal-view="<?= base64_encode("distributeur") ?>/<?= base64_encode("ajoutRechargementModal") ?>">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['ajout']; ?></span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= WEBROOT; ?>distrib/historiqueRechargementAll">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['liste']; ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a style="cursor:pointer;" class="waves-effect"><i class="mdi mdi-wrench fa-fw"></i> <span class="hide-menu"><?php echo $this->lang['gestionClient']; ?>
                            <span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="#" class="open-modal"
                               data-modal-controller="distributeur/distrib/ajoutClientModal"
                               data-modal-view="<?= base64_encode("distributeur") ?>/<?= base64_encode("ajoutRechargementModal") ?>">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['ajout']; ?></span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo WEBROOT; ?>distrib/listeClient">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['liste']; ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo WEBROOT; ?>distrib/compteBlocked">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['comptes_blocked']; ?></span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="#" class="waves-effect"><i class="mdi mdi-account-multiple fa-fw"></i>
                        <span class="hide-menu"><?php echo $this->lang['gestionAgent']; ?><span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="#" class="open-modal"
                               data-modal-controller="distributeur/agent/ajoutAgentModal"
                               data-modal-view="<?= base64_encode("distributeur") ?>/<?= base64_encode("ajoutAgentModal") ?>">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['ajout']; ?></span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= WEBROOT; ?>agent/listeAgent">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['liste']; ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
<!--                <li>
                    <a href="#" class="waves-effect"><i class="mdi mdi-account-multiple fa-fw"></i>
                        <span class="hide-menu"><?php /*echo $this->lang['versement']; */?><span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php /*echo WEBROOT;*/?>distrib/versementAgent">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php /*echo $this->lang['faire_versement']; */?></span>
                            </a>
                        </li>
                    </ul>
                </li>
-->
                <li>
                    <a href="#" class="waves-effect"><i class="mdi mdi-account-multiple fa-fw"></i>
                        <span class="hide-menu"><?php echo $this->lang['reporting']; ?><span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo WEBROOT;?>distrib/reportingRechargement">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['rechargement']; ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo WEBROOT;?>distrib/reportingCarte">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['carte']; ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
            <?}else{?>
                <li>
                    <a href="#" class="waves-effect"><i class="mdi mdi-account-multiple fa-fw"></i>
                        <span class="hide-menu"><?php echo $this->lang['gestion_rechargement']; ?><span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="#" class="open-modal"
                               data-modal-controller="distributeur/distrib/ajoutRechargementModal"
                               data-modal-view="<?= base64_encode("distributeur") ?>/<?= base64_encode("ajoutRechargementModal") ?>">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['ajout']; ?></span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= WEBROOT; ?>distrib/historiqueRechargementAll">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['liste']; ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a style="cursor:pointer;" class="waves-effect"><i class="mdi mdi-wrench fa-fw"></i> <span class="hide-menu"><?php echo $this->lang['gestionClient']; ?>
                            <span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="#" class="open-modal"
                               data-modal-controller="distributeur/distrib/ajoutClientModal"
                               data-modal-view="<?= base64_encode("distributeur") ?>/<?= base64_encode("ajoutRechargementModal") ?>">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['ajout']; ?></span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo WEBROOT; ?>distrib/listeClient">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['liste']; ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo WEBROOT; ?>distrib/compteBlocked">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['comptes_blocked']; ?></span>
                            </a>
                        </li>

                    </ul>
                </li>

                </li>
                <li>
                    <a href="#" class="waves-effect"><i class="mdi mdi-account-multiple fa-fw"></i>
                        <span class="hide-menu"><?php echo $this->lang['reporting']; ?><span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo WEBROOT;?>distrib/reportingRechargement">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['rechargement']; ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo WEBROOT;?>distrib/reportingCarte">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['carte']; ?></span>
                            </a>
                        </li>
                    </ul>
                </li>

            <?}?>
        </ul>
    </div>
</div>
