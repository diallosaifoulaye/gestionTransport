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
                <a href="#" class="open-modal"
                   data-modal-controller="distributeur/agent/ajoutAgentModal"
                   data-modal-view="<?= base64_encode("distributeur") ?>/<?= base64_encode("ajoutAgentModal") ?>">
                    <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['ajout']; ?></span>
                </a>
            </li>
            <li>
                <a href="<?= WEBROOT; ?>employe/listeChauffeur">
                    <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['liste']; ?></span>
                </a>
            </li>
        </ul>
    </div>
</div>
