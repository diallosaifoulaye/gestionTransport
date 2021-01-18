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
        <ul class="nav" id="side-menu">


            <?php include("profil_user.php"); ?>
            <br>

            <li>
                <a href="<?= WEBROOT; ?>transaction/index">
                    <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['ca']; ?></span>
                </a>
            </li>

            <li>
                <a href="<?= WEBROOT; ?>reporting/reportingTicket">
                    <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['ticket']; ?></span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                    <span class="hide-menu"><?php echo $this->lang['carte']; ?></span>
                </a>
            </li>

        </ul>
    </div>
</div>
