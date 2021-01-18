
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span>
                <span class="hide-menu">Navigation</span></h3></div>
        <ul class="nav" id="side-menu">


            <?php include("profil_user.php"); ?>
            <br>
            <li>
               <!-- --><?php /*if($admin==1 || $this->profil->Est_autoriser(74,$profil)==1) {*/?>
            <li>
                <a href="<?= WEBROOT; ?>facturation/facturation">
                    <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['encours']; ?></span>
                </a>
            </li>


            <li>
                <a href="<?= WEBROOT; ?>facturation/factures">
                    <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['factures']; ?></span>
                </a>
            </li>

            <li>
                <a href="<?= WEBROOT; ?>facturation/historique">
                    <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['etat_commission']; ?></span>
                </a>
            </li>


            <li>
                <a href="<?= WEBROOT; ?>facturation/historique">
                    <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['historique']; ?></span>
                </a>
            </li>


          <!--  --><?php /*}*/?>

            </li>



        </ul>



    </div>
</div>