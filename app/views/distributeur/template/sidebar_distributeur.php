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

            <li>
                <a href="#" class="waves-effect"><i class="mdi mdi-ungroup fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['gest_personnels']; ?><span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">

                    <li>
                        <a href="<?= WEBROOT; ?>employe/listeChauffeur">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['listeChauffeur']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= WEBROOT; ?>employe/listeReceveur">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['listeReceveur']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= WEBROOT; ?>employe/listeControleur">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['listeControleur']; ?></span>
                        </a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="#" class="waves-effect"><i class="mdi mdi-responsive fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['gest_bus']; ?><span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?= WEBROOT; ?>bus/listeCategorie">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['gestionCategorie']; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= WEBROOT; ?>bus/liste">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['liste']; ?></span>
                        </a>
                    </li>


                </ul>
            </li>
            <li>
                <a href="#" class="waves-effect"><i class="mdi mdi-responsive fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['gestion_materiel']; ?><span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">

                    <!-- <li>
                        <a href="<?/*= WEBROOT; */?>gestion/listeType">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php /*echo $this->lang['typeMateriel']; */?></span>
                        </a>
                    </li>-->

                    <li>
                        <a href="<?= WEBROOT; ?>gestion/listeMateriel">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['listemateriel']; ?></span>
                        </a>

                    </li>
                    <li>
                        <a href="<?= WEBROOT; ?>gestion/affectMateriel">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['affectMateriel']; ?></span>
                        </a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="#" class="waves-effect"><i class="mdi mdi-responsive fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['gestionTrajetVoyage']; ?><span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">

                    <li>
                        <a href="<?= WEBROOT; ?>trajets/trajets">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['trajet']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= WEBROOT; ?>trajets/voyages">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['voyages']; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= WEBROOT; ?>trajets/Lignes">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['lignes']; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= WEBROOT; ?>trajets/tickets">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['tickets']; ?></span>
                        </a>
                    </li>
                </ul>
            </li>


            <li>
                <a href="#" class="waves-effect"><i class="mdi mdi-responsive fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['gestionParametrage']; ?><span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">

                    <li>
                        <a href="<?= WEBROOT; ?>param/quotepart">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['les_quotes_part']; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo WEBROOT; ?>param/listeModule">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['modules']; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo WEBROOT; ?>param/listeDroit">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['action']; ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#" class="waves-effect"><i class="mdi mdi-account-multiple fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['user_profil']; ?><span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?= WEBROOT; ?>param/listeGroupe">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['group']; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= WEBROOT; ?>param/listeProfil">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['profils']; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= WEBROOT; ?>param/listeUtilisateur">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['utilisateur']; ?></span>
                        </a>
                    </li>
                </ul>
            </li>



        </ul>
    </div>
</div>
