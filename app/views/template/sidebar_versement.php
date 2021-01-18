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
                <a href="#" class="waves-effect"><i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu"><?php echo $this->lang['versements']; ?><span
                                class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">

                    <li>
                        <a href="<?php echo WEBROOT; ?>versement/collectEncours">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['faire_versement']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo WEBROOT; ?>versement/historique">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['historique']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo WEBROOT; ?>versement/manquementsReceveur">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['manquements_receveur']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo WEBROOT; ?>versement/manquements">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['manquements']; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo WEBROOT; ?>versement/versementAgent">
                            <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                            <span class="hide-menu"><?php echo $this->lang['distributeur']; ?></span>
                        </a>
                    </li>


                </ul>
            </li>


        </ul>
    </div>
</div>
