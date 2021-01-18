<div id="page-wrapper">
    <div class="container-fluid">
        <?php require_once (ROOT . 'app/views/template/notify.php'); ?>
        <div class="row bg-title">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['administration']; ?></h4> </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?php echo WEBROOT ?>menu/menu"><?php echo $this->lang['tabBord']; ?></a></li>
                    <li class="active"><?php echo $this->lang['administration']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- ============= Blocs du menu ========= -->
        <div class="row">

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 big_team_grid">
                <a href="<?php echo WEBROOT ?>administration/listeModule">
                    <div class="big_text text1-big">
                        <h3><i class="mdi mdi-wrench fa-fw icones-big"></i></h3>
                        <p><?php echo $this->lang['parametrage']; ?> <br>_</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 big_team_grid">
                <a href="<?php echo WEBROOT ?>administration/listeGroupe">
                    <div class="big_text text1-big">
                        <h3><i class="mdi mdi-account-multiple fa-fw icones-big"></i></h3>
                        <p><?php echo $this->lang['user_profil']; ?><br>_</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo WEBROOT ?>administration/listeFournisseur">
                    <div class="big_text text1-big">
                        <h3><i class="mdi mdi-ungroup fa-fw icones-big"></i></h3>
                        <p><?php echo $this->lang['gest_fourn']; ?><br>_</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo WEBROOT ?>administration/listeService">
                    <div class="big_text text1-big">
                        <h3><i class="mdi mdi-responsive fa-fw icones-big"></i></h3>
                        <p><?php echo $this->lang['gest_service']; ?><br> _</p>
                    </div>
                </a>
            </div>

        </div>
        <!-- ============= Blocs du menu ========= -->
    </div>
    <!-- /.container-fluid -->

</div>