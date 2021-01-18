<!DOCTYPE html>
<html lang="<?= \app\core\Session::getAttribut('lang');?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <!---------- Dan Enriqué ----------->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<link rel="icon" type="image/png" sizes="16x16" href="<?/*= ASSETS; */?>plugins/images/favicon.ico">-->

    <link rel="shortcut icon" href="<?= ASSETS; ?>plugins/images/favicon.ico" type="image/x-icon">

    <title><?= $this->lang['titre3'] ?></title>

    <!-- jQuery JavaScript -->
    <script src="<?= ASSETS; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Telephone CSS -->
    <link rel="stylesheet" href="<?= ASSETS ?>plugins/telPlug/css/intlTelInput.css">
    <!-- Bootstrap Core CSS -->
    <link href="<?= ASSETS; ?>ampleadmin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="<?= ASSETS; ?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="<?= ASSETS; ?>plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- morris CSS -->
    <link href="<?= ASSETS; ?>plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <!-- chartist CSS -->

    <link href="<?= ASSETS; ?>plugins/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="<?= ASSETS; ?>plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <!-- Calendar CSS -->
    <link href="<?= ASSETS; ?>plugins/bower_components/calendar/dist/fullcalendar.css" rel="stylesheet"/>
    <!-- animation CSS -->
    <link href="<?= ASSETS; ?>ampleadmin-minimal/css/animate.css" rel="stylesheet">
<!--    <link href="https://wrappixel.com/ampleadmin/ampleadmin-html/plugins/bower_components/jquery-wizard-master/css/wizard.css" rel="stylesheet">
-->    <!-- Custom CSS -->
    <link href="<?= ASSETS; ?>ampleadmin-minimal/css/styleadmin.css" rel="stylesheet"  />
    <!-- color CSS -->
    <link href="<?= ASSETS; ?>ampleadmin-minimal/css/dan.css" rel="stylesheet" />
    <link href="<?= ASSETS; ?>ampleadmin-minimal/css/graphe.css"  />
    <link href="<?= ASSETS; ?>ampleadmin-minimal/css/colors/default.css" id="theme" rel="stylesheet">
    <link href="<?= ASSETS; ?>plugins/datatables/jquery.dataTables.css">
    <link href="<?= ASSETS; ?>plugins/datatables/dataTables.bootstrap.css">
    <link href="<?= ASSETS; ?>plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" >
    <link    href="<?= ASSETS; ?>plugins/jquery-timepicker-1.3.5/jquery.timepicker.min.css" rel="stylesheet">

    <!-- CSS Validation -->
    <link  src="<?= ASSETS; ?>plugins/formValidation.min.css">

    <!-- Font-awesome CSS -->
    <link href="<?= ASSETS; ?>plugins/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= ASSETS; ?>plugins/jquery-wizard-master/formValidation.min.css">

    <link rel="stylesheet" href="<?= ASSETS; ?>css/dropify.min.css">
    <link rel="stylesheet" href="<?= ASSETS; ?>plugins/bower_components/dropify/dist/css/dropify.min.css">

    <!-- Jquery-confirm CSS -->
    <link rel="stylesheet" href="<?= ASSETS; ?>plugins/jconfirm/css/jquery-confirm.css"/>

    <link rel="stylesheet" href="<?= ASSETS ?>plugins/jconfirm/css/jquery-confirm.css"/>
    <link rel="stylesheet" src="<?= ASSETS; ?>plugins/passtrength/passtrength.css">

    <link rel="stylesheet" href="<?= ASSETS ?>plugins/select2/select2.min.css">


    <!-- CSS DATEPICKER PLUGINS -->
    <link href="<?php echo ASSETS; ?>plugins/jquery-ui/jquery-ui.theme.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ASSETS; ?>plugins/jquery-ui/jquery-ui.structure.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ASSETS; ?>plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <style>
        .fa-toggle-on{
            color: green !important;
        }
        .fa-toggle-off{
            color: red !important;
        }
    </style>
</head>
<body data-racine="<?= RACINE; ?>" class="fix-header"
      data-assets="<?= ASSETS; ?>"
      data-webroot="<?= WEBROOT; ?>"
>

<!-- ============================================================== -->

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
                <!-- Logo -->
                <a class="logo" href="#">
                    <!-- Logo icon image, you can use font-icon also -->
                    <b>
                        <!--This is dark logo icon-->
                        <img src="<?php echo ASSETS; ?>plugins/images/admin-logo.png" alt="home" class="dark-logo">
                        <!--This is light logo icon-->
                        <img src="<?php echo ASSETS; ?>plugins/images/espace-vide.png" alt="home" class="light-logo">
                    </b>
                    <!-- Logo text image you can use text also -->
                    <span class="hidden-xs">
                        <!--This is dark logo text-->
                        <img src="<?php echo ASSETS; ?>plugins/images/admin-text.png" alt="home" class="dark-logo">
                        <!--This is light logo text-->
                        <img src="<?php echo ASSETS; ?>plugins/images/white-sunusva.png" alt="home" class="light-logo">
                     </span>
                </a>

            </div>
            <!-- /Logo -->
            <!-- Search input and Toggle icon -->
            <ul class="nav navbar-top-links navbar-left">
                <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a></li>
                <?php //require_once (ROOT . 'app/views/notify.php'); ?>

            </ul>

            <ul class="nav navbar-top-links navbar-right pull-right">
                <li class="dropdown">
                    <a class="dropdown-toggle profile-pic " data-toggle="dropdown" href="#">

                        <b class="hidden-xs"><i style="position: relative;top: 5px;right: 5px;" class="fa fa-2x fa-globe"></i><?= $this->lang[\app\core\Session::getAttribut('lang')] ; ?></b><span class="caret"></span> </a>
                    <ul class="dropdown-menu dropdown-user animated flipInY" style="width: inherit;">
                        <li><a href="javascript:;" class="_lang_" data-lang="fr" style="vertical-align: inherit;">Français</a></li>
                        <li><a href="javascript:;" class="_lang_" data-lang="us" style="vertical-align: inherit;">English</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
<!--                        <img src="<?/*= ASSETS;*/?>pictures/<?php /*echo $this->_USER->photo ;*/?>" alt="user-img" width="36" class="img-circle">
-->                        <b class="hidden-xs"><?php echo $this->_USER->nom_agent;?></b><span class="caret"></span> </a>
                    <ul class="dropdown-menu dropdown-user animated flipInY">
                        <li>
                            <div class="dw-user-box">
<!--                                <div class="u-img"><img src="<?/*= ASSETS;*/?>pictures/<?php /*echo $this->_USER->photo ;*/?>" alt="user"/></div>
-->                                <div class="u-text">
                                    <h4><?php echo  $this->_USER->prenom_agent.' '.$this->_USER->nom_agent?></h4>
                                    <p class="text-muted"><?php echo  $this->_USER->email_agent;?></p>
                                </div>
                            </div>
                        </li>
                        <li role="separator" class="divider"></li>
                        <!--<li>
                            <a href="<?/*= WEBROOT."admin/profilUser" */?>">
                                <i class="ti-user"></i>&nbsp;&nbsp<?php /*echo $this->lang['mon_profil']; */?>
                            </a>
                        </li>-->

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