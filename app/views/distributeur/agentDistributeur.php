<div id="page-wrapper">
    <div class="container-fluid">
        <?php require_once (ROOT . 'app/views/template/notify.php'); ?>
        <div class="row bg-title">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['administration']; ?></h4> </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?php echo WEBROOT ?>home/menu"><?php echo $this->lang['tabBord']; ?></a></li>
                    <li class="active"><?php echo $this->lang['administration']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
<?php var_dump($this->_USER);?>
        <!-- ============= Blocs du menu ========= -->
<!--        <div class="row">


            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php /*echo WEBROOT */?>employe/listeChauffeur">
                    <div class="big_text text1-big">
                        <h3><i class="mdi mdi-ungroup fa-fw icones-big"></i></h3>
                        <p><?php /*echo $this->lang['gest_personnels']; */?><br>_</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php /*echo WEBROOT */?>bus/liste">
                    <div class="big_text text1-big">
                        <h3><i class="mdi mdi-responsive fa-fw icones-big"></i></h3>
                        <p><?php /*echo $this->lang['gest_bus']; */?><br> _</p>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php /*echo WEBROOT */?>gestion/listeType">
                    <div class="big_text text1-big">
                        <h3><i class="mdi mdi-ungroup fa-fw icones-big"></i></h3>
                        <p><?php /*echo $this->lang['gestion_materiel']; */?><br>_</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php /*echo WEBROOT */?>trajets/trajets">
                    <div class="big_text text1-big">
                        <h3><i class="mdi mdi-ungroup fa-fw icones-big"></i></h3>
                        <p><?php /*echo $this->lang['gestionTrajetVoyage']; */?><br>_</p>
                    </div>
                </a>
            </div>


        </div>
-->        <!-- ============= Blocs du menu ========= -->
    </div>
    <!-- /.container-fluid -->

</div>