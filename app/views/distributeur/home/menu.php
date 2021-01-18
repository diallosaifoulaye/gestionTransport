
<? //var_dump(ASSETS."pictures/".$this->_USER->photo);die; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <!---------- Dan Enriqué ----------->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?= ASSETS; ?>plugins/images/favicon.ico" type="image/x-icon">

    <title><?= $this->lang['titre3'] ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= ASSETS; ?>ampleadmin-minimal/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="<?= ASSETS; ?>plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet"
    <!-- animation CSS -->
    <link href="<?= ASSETS; ?>ampleadmin-minimal/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= ASSETS; ?>ampleadmin-minimal/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="<?= ASSETS; ?>ampleadmin/css/colors/blue-dark.css" id="theme" rel="stylesheet">
    <link href="<?= ASSETS; ?>ampleadmin-minimal/css/dan.css" rel="stylesheet" type="text/css"/>

    <!-- Font-awesome CSS -->
    <link href="<?= ASSETS; ?>plugins/font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
</head>

<body class="fix-header">
<!-- ============================================================== -->
<!-- Preloader -->
<!-- ============================================================== -->
<!--<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>-->
<!-- ============================================================== -->
<!-- Wrapper -->
<!-- ============================================================== -->
<div id="wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header">
            <div class="top-left-part" style="padding-left: 30px;">
                <!-- Logo -->
                <a class="logo" href="<?php echo WEBROOT ?>menu/menu">
                    <!-- Logo icon image, you can use font-icon also -->
                    <b>
                        <!--This is dark logo icon-->
                        <img src="<?= ASSETS; ?>plugins/images/white-sunusva.png" alt="home" class="dark-logo"/>

                    </b>
                    <!-- Logo text image you can use text also -->
                    <span class="hidden-xs">
                        <!--This is light logo text-->
                        <img src="<?= ASSETS; ?>plugins/images/white-sunusva.png" alt="home" class="light-logo">
                     </span>
                </a>
            </div>
            <!-- /Logo -->
            <ul class="nav navbar-top-links navbar-right pull-right">

                <li class="dropdown">
                <li class="dropdown">
                    <a class="dropdown-toggle profile-pic " data-toggle="dropdown" href="#">

                        <b class="hidden-xs"><i style="position: relative;top: 5px;right: 5px;" class="fa fa-2x fa-globe"></i><?= $this->lang[\app\core\Session::getAttribut('lang')] ; ?></b><span class="caret"></span> </a>
                    <ul class="dropdown-menu dropdown-user animated flipInY" style="width: inherit;">
                        <li><a href="javascript:;" class="_lang_" data-lang="fr" style="vertical-align: inherit;">Français</a></li>
                        <li><a href="javascript:;" class="_lang_" data-lang="us" style="vertical-align: inherit;">English</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
                        <img src="<?= ASSETS;?>pictures/<?php echo $this->_USER->photo ;?>" alt="user-img" width="36" class="img-circle">
                        <b class="hidden-xs"><?php echo $this->_USER->nom;?></b><span class="caret"></span> </a>
                    <ul class="dropdown-menu dropdown-user animated flipInY">
                        <li>
                            <div class="dw-user-box">
                                <div class="u-img"><img src="<?= ASSETS;?>pictures/<?php echo $this->_USER->photo ;?>" alt="user"/></div>
                                <div class="u-text">
                                    <h4><?php echo  $this->_USER->prenom.' '.$this->_USER->nom?></h4>
                                    <p class="text-muted"><?php echo  $this->_USER->email;?></p>
                                </div>
                            </div>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="<?= WEBROOT."admin/profilUser" ?>">
                                <i class="ti-user"></i>&nbsp;&nbsp<?php echo $this->lang['mon_profil']; ?>
                            </a>
                        </li>

                        <li><a href="<?php echo WEBROOT."home/unlogin" ?>"><i class="fa fa-power-off"></i>&nbsp;&nbsp;<?php echo $this->lang['se_deconnecter']; ?></a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>

                <!-- /.dropdown -->
            </ul>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <!-- End Top Navigation -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- End Left Sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div id="page-wrapper" style="margin: 50px 0px;">
        <div class="container-fluid">
            <?php require_once (ROOT . 'app/views/template/notify.php'); ?>
            <br>
            <br>
            <br>
            <!-- ============================================================== -->
            <!-- Different data widgets -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-sm-12">
                    <!--<div class="white-box">

                    </div>-->
                </div>
            </div>

            <!--======================== actuality & Event =============-->

            <!-- ======================== Event ==============================-->

            <!-- ============= Blocs du menu ========= -->
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 big_team_grid">
                    <a href="<?= WEBROOT?>distrib/operationIndex">
                        <div class="big_text text1-big">
                            <h3><i class="mdi mdi-account-multiple fa-fw icones-big"></i></h3>
                            <p><?php echo $this->lang['operation']; ?> <br>_</p>
                        </div>
                    </a>
                </div>

            <!-- ============= Blocs du menu ========= -->

            <!-- col-md-3 -->
            <div class="col-md-4 col-lg-3 hidden">
                <div class="panel wallet-widgets">
                    <div class="panel-body">
                        <ul class="side-icon-text">
                            <li class="m-0"><a href="#"><span class="circle circle-md bg-success di vm"><i
                                                class="ti-plus"></i></span><span class="di vm"><h1 class="m-b-0">$458.50</h1><h5
                                                class="m-t-0">Your wallet Banalce</h5></span></a></li>
                        </ul>
                    </div>
                    <div id="morris-area-chart2" style="height:208px"></div>
                    <ul class="wallet-list">
                        <li><i class="icon-wallet"></i><a href="javascript:void(0)">Withdrow money</a></li>
                        <li><i class="icon-handbag"></i><a href="javascript:void(0)">Shop Now</a></li>
                        <li><i class="ti-archive"></i><a href="javascript:void(0)">Add funds</a></li>
                        <li><i class=" ti-wallet"></i><a href="javascript:void(0)">Withdrow money</a></li>
                        <li><i class="icon-wallet"></i><a href="javascript:void(0)">Withdrow money</a></li>
                        <li><i class="icon-handbag"></i><a href="javascript:void(0)">Shop Now</a></li>
                    </ul>
                </div>
            </div>
            <!-- /col-md-3 -->
        </div>
    </div>
    <!-- /.container-fluid -->
    <footer class="footer text-center"> © 2019 BY NUMHERIT SA</footer>
</div>

</div>

<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->

<script src="<?= ASSETS; ?>plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?= ASSETS; ?>ampleadmin/bootstrap/dist/js/bootstrap.min.js"></script>
<!--slimscroll JavaScript -->
<script src="<?= ASSETS; ?>ampleadmin/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?= ASSETS; ?>ampleadmin/js/waves.js"></script>
<!--Counter js -->
<script src="<?= ASSETS; ?>plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
<script src="<?= ASSETS; ?>plugins/bower_components/counterup/jquery.counterup.min.js"></script>
<!--Morris JavaScript -->
<script src="<?= ASSETS; ?>plugins/bower_components/raphael/raphael-min.js"></script>
<script src="<?= ASSETS; ?>plugins/bower_components/morrisjs/morris.js"></script>
<!-- chartist chart -->
<script src="<?= ASSETS; ?>plugins/bower_components/chartist-js/dist/chartist.min.js"></script>
<script src="<?= ASSETS; ?>plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
<!-- Calendar JavaScript -->
<script src="<?= ASSETS; ?>plugins/bower_components/moment/moment.js"></script>
<script src="<?= ASSETS; ?>plugins/bower_components/calendar/dist/cal-init.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?= ASSETS; ?>ampleadmin/js/custom.min.js"></script>
<script src="<?= ASSETS; ?>ampleadmin/js/dashboard1.js"></script>
<!-- Custom tab JavaScript -->
<script src="<?= ASSETS; ?>ampleadmin/js/cbpFWTabs.js"></script>
<script type="text/javascript">
    (function () {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
            new CBPFWTabs(el);
        });
    })();
</script>
<!--Style Switcher -->
<script src="<?= ASSETS; ?>plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>
<!-- Localized -->