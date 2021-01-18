
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
    <link href="<?php echo ASSETS;?>ampleadmin-minimal/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="<?php echo ASSETS;?>ampleadmin-minimal/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo ASSETS;?>ampleadmin-minimal/css/style.css" rel="stylesheet">

    <!-- color CSS -->
    <link href="<?php echo ASSETS;?>ampleadmin/css/colors/blue-dark.css" id="theme" rel="stylesheet">
    <link href="<?php echo ASSETS;?>ampleadmin-minimal/css/dan.css" rel="stylesheet" type="text/css"/>

    <!-- Font-awesome CSS -->
    <link href="<?php echo ASSETS;?>plugins/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo ASSETS;?>plugins/passtrength/passtrength.css" rel="stylesheet" type="text/css">

</head>

<body class="fix-header">

<div id="wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header">
            <div class="top-left-part" style="padding-left: 30px;">
                <!-- Logo -->
                <a class="logo" href="#">
                    <!-- Logo icon image, you can use font-icon also -->
                    <b>
                        <!--This is dark logo icon-->
                        <img src="<?php echo ASSETS;?>plugins/images/white-sunusva.png" alt="home" class="dark-logo"/>
                        <!--This is light logo icon-->
                        <img src="<?php echo ASSETS;?>/plugins/images/admin-logo-dark.png" alt="home" class="light-logo"/>
                    </b>
                    <span class="hidden-xs">
                        <img src="<?php echo ASSETS;?>/plugins/images/admin-text-dark.png" alt="home" class="light-logo" />
                    </span>
                </a>
            </div>
            <!-- /Logo -->
        </div>
    </nav>

    <!-- Page Content -->
        <div class="new-login-box">

            <di class="col-lg-3 col-md-3"></di>
            <div class="white-box col-lg-6 col-md-6 col-xs-12" style="background-color: #ededed; top: 150px">
                <form class="form-horizontal new-lg-form" id="loginform" action="<?php echo WEBROOT;?>distrib/updatePasswordDistributeur" method="post">


                    <div class="row" style="background-color: #325186">
                        <div class="col-xs-12">
                            <h3 style="text-align: center"><p style="color: white"><?php echo $this->lang['Modifier_motpass']?></p></h3>
                        </div>
                    </div>

                    <div class="form-group  m-t-20">
                        <div class="col-xs-12">
                            <label style="color: black"><?php echo $this->lang['ancienmotdepasse'] ?></label>
                            <input type="password" name="ancienpass" id="ancienpass" class="form-control" placeholder="<?php echo $this->lang['ancienmotdepasse'] ?>" autocomplete="off" onchange="verifAncienMotPasse()" required>
                            <span id="msg1"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <label style="color: black"><?php echo $this->lang['newmotdepasse'] ?></label>
                            <input type="password" name="password" id="mot_de_passe" class="form-control" placeholder="<?php echo $this->lang['newmotdepasse'] ?>" autocomplete="off" required>
                            <input type="hidden" name="connect" value="1">
                            <input type="hidden" name="date_modification" value="<?php echo date('Y-m-d H:i:s');?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <label style="color: black"><?php echo $this->lang['confirmmotdepasse']; ?></label>
                            <input type="password" name="mot_de_passe1" id="mot_de_passe1" class="form-control" placeholder="<?php echo $this->lang['confirmmotdepasse']; ?>" autocomplete="off" required onchange="confirmPass()">
                            <span id="msg2"></span>
                        </div>
                    </div>

                    <br/>

                    <div class="col-xs-6 col-sm-6">
                        <a href="javascript:history.back()">
                            <button type="button" class="btn btn-info btn-rounded text-uppercase waves-effect waves-light pull-left">
                                <?php echo $this->lang['btnAnnuler'] ?>
                            </button>
                        </a>
                    </div>

                    <div class="col-xs-6 col-sm-6">
                        <button type="submit" class="btn btn-success  btn-rounded text-uppercase waves-effect waves-light pull-right" id="valider">
                            <?php echo $this->lang['btnValider'] ?>
                        </button>
                    </div>
                    <input type="hidden" name="type" id="type" class="form-control" value="<?= $type ?>" autocomplete="off" required>

                </form>

            </div>
            <di class="col-lg-3 col-md-3"></di>

        </div>
    <!-- /.container-fluid -->

    <footer class="footer text-center"> © 2019 BY NUMHERIT SA</footer>
</div>


<script src="<?php echo ASSETS;?>plugins/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo ASSETS;?>ampleadmin/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo ASSETS;?>plugins/passtrength/jquery.passtrength.js"></script>

<script>
    $('#mot_de_passe').passtrength({
        minChars: 8
    });

    $('#mot_de_passe').passtrength({
        passwordToggle: true,
        eyeImg : "<?php echo ASSETS;?>plugins/images/eye.svg" // toggle icon
    });

    $('#mot_de_passe').passtrength({
        tooltip: true,
        textWeak: "Faible",
        textMedium: "Moyen",
        textStrong: "Fort",
        textVeryStrong: "Très fort",
    });
</script>

<script>
    function verifAncienMotPasse(){
        $.ajax({
            type: "POST",
            url: "<?php echo WEBROOT.'administration/verifAncienMotPasse'; ?>",
            data: "ancienpasse="+document.getElementById('ancienpass').value,
            success: function(data) {
                if(data == 1){
                    $('#msg1').html("<p style='color:#7ACE4C;display: inline;border: 1px solid #7ACE4C'> <?php echo $this->lang['pass_alert_success']; ?></p>");
                    $("#valider").removeAttr("disabled","disabled");
                }
                else if(data== -1){
                    $('#msg1').html("<p style='color:#F00;display: inline;border: 1px solid #F00'> <?php echo $this->lang['pass_alert_error']; ?></p>");
                    $("#valider").attr("disabled","disabled");
                }
            }
        });
    }

</script>

<script>
    function confirmPass()
    {
        var mot_de_passe= document.getElementById('mot_de_passe').value;
        var mot_de_passe1= document.getElementById('mot_de_passe1').value;
        if(mot_de_passe == mot_de_passe1){
            $('#msg2').html("<p style='color:#7ACE4C;display: inline;border: 1px solid #7ACE4C'> <?php echo  $this->lang['confirmpass_alert_success'];  ?></p>");
            $("#valider").removeAttr("disabled","disabled");
        }
        else{
            $('#msg2').html("<p style='color:#F00;display: inline;border: 1px solid #F00'> <?php echo $this->lang['confirmpass_alert_error']; ?></p>");
            $("#valider").attr("disabled","disabled");
        }
    }

</script>

</body>

</html>
<!-- Localized -->