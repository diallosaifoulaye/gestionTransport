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
                <a href="#" class="waves-effect"><i class="mdi mdi-wrench fa-fw"></i> <span class="hide-menu"><?php echo $this->lang['parametrage']; ?>
                        <span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?php echo WEBROOT; ?>administration/listeModule">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['modules']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo WEBROOT; ?>administration/listeDroit">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['action']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo WEBROOT; ?>administration/listePays">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['pays']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo WEBROOT; ?>administration/listeMessage">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['message']; ?></span>
                        </a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="#" class="waves-effect"><i class="mdi mdi-account-multiple fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['user_profil']; ?><span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?= WEBROOT; ?>administration/listeGroupe">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['group']; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= WEBROOT; ?>administration/listeProfil">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['profils']; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= WEBROOT; ?>administration/listeUtilisateur">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['utilisateur']; ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#" class="waves-effect"><i class="mdi mdi-ungroup fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['gest_fourn']; ?><span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">

                    <li>
                        <a href="<?= WEBROOT; ?>administration/listeTypeWebservice">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['type_webservice']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= WEBROOT; ?>administration/listeTypeInterconnexion">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['type_interconnexion']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= WEBROOT; ?>administration/listeFournisseur">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['four']; ?></span>
                        </a>
                    </li>

                    <!--<li>
                        <a href="<?/*= WEBROOT; */?>administration/listeApiFournisseur">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php /*echo $this->lang['api_four']; */?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?/*= WEBROOT; */?>administration/listeWebService">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php /*echo $this->lang['web_service']; */?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?/*= WEBROOT; */?>administration/listeCodeRetour">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php /*echo $this->lang['code_retour']; */?></span>
                        </a>
                    </li>-->


                </ul>
            </li>

            <li>
                <a href="#" class="waves-effect"><i class="mdi mdi-responsive fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['gest_service']; ?><span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?= WEBROOT; ?>administration/listeCatService">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['cat_service']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= WEBROOT; ?>administration/listeService">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['service']; ?></span>
                        </a>
                    </li>
                </ul>
            </li>


        </ul>
    </div>
</div>
