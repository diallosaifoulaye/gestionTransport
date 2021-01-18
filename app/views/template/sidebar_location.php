
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span>
                <span class="hide-menu">Navigation</span></h3></div>
        <ul class="nav" id="side-menu">


            <?php include("profil_user.php"); ?>
            <br>
            <li>

            <li>
                <a href="<?= WEBROOT; ?>location/nouvelleLocation">
                    <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['nouvelle_location']; ?></span>
                </a>
            </li>
            <li>
                <a href="<?= WEBROOT; ?>location/listeBusL">
                    <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['historique_location']; ?></span>
                </a>
            </li>
            <li>
                <a href="<?= WEBROOT; ?>location/listeClient">
                    <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['listeClient']; ?></span>
                </a>

            </li>
            <li>
                <a href="<?= WEBROOT; ?>location/reporting">
                    <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['reporting_location']; ?></span>
                </a>
            </li>
            <li>
                <a href="<?= WEBROOT; ?>location/parametrageFacture">
                    <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['parametrage_facture']; ?></span>
                </a>
            </li>



            </li>


        </ul>



    </div>
</div>