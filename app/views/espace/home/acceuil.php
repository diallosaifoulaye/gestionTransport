<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Espace partenaire</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content=""/>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= ASSETS; ?>plugins/images/favicon.ico">
    <link rel="icon" href="<?= ASSETS; ?>plugins/images/favicon.ico" type="image/x-icon">

    <!-- vector map CSS -->
    <link href="<?= ASSETS; ?>partenaire/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css"/>

    <!-- Custom CSS -->
    <link href="<?= ASSETS; ?>partenaire/dist/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<!--Preloader-->
<div class="preloader-it">
    <div class="la-anim-1"></div>
</div>
<!--/Preloader-->

<div class="wrapper  pa-0">
    <header class="sp-header">
        <div class="sp-logo-wrap pull-left">
            <a href="#">
                <img class="brand-img mr-10" src="<?= ASSETS; ?>partenaire/img/white-sunusva.png" alt="brand"/>
                <span class="brand-text"><img  src="<?= ASSETS; ?>partenaire/img/white-sunusva.png" alt="brand"/></span>
            </a>
        </div>
        <!--<div class="form-group mb-0 pull-right">
            <span class="inline-block pr-10">Don't have an account?</span>
            <a class="inline-block btn btn-orange btn-rounded " href="signup.html">Sign Up</a>
        </div>-->
        <div class="clearfix"></div>
    </header>

    <!-- Main Content -->
    <div class="page-wrapper pa-0 ma-0 auth-page" style="background: #243f6b;">
        <div class="container">
            <!-- Row -->
            <div class="table-struct full-width full-height">
                <div class="table-cell vertical-align-middle auth-form-wrap">
                    <div class="auth-form  ml-auto mr-auto no-float card-view pt-30 pb-30">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">Connexion</h3>
                                    <h6 class="text-center nonecase-font txt-grey">Entrer les paramètres de connexion</h6>
                                </div>
                                <div class="form-wrap">
                                    <form action="#">
                                        <div class="form-group">
                                            <label class="control-label mb-10" for="exampleInputEmail_2">Login</label>
                                            <input type="email" class="form-control" required="" id="exampleInputEmail_2" placeholder="Entrer votre email">
                                        </div>
                                        <div class="form-group">
                                            <label class="pull-left control-label mb-10" for="exampleInputpwd_2">Password</label>

                                            <input type="password" class="form-control" required="" id="exampleInputpwd_2" placeholder="Entrer votre mot de passe">
                                        </div>

                                        <div class="form-group">
                                            <div class="checkbox checkbox-primary pr-10 pull-left">
                                                <input id="checkbox_2" required="" type="checkbox">
                                                <label for="checkbox_2"> restez connecté</label>
                                            </div>
                                            <a class="capitalize-font txt-orange block mb-10 pull-right font-12" href="#">Mot de passe oublié ?</a>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-orange btn-rounded">Se connecter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Row -->
        </div>

    </div>
    <!-- /Main Content -->

</div>
<!-- /#wrapper -->

<!-- JavaScript -->

<!-- jQuery -->
<script src="<?= ASSETS; ?>partenaire/vendors/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?= ASSETS; ?>partenaire/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= ASSETS; ?>partenaire/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>

<!-- Slimscroll JavaScript -->
<script src="<?= ASSETS; ?>partenaire/dist/js/jquery.slimscroll.js"></script>

<!-- Init JavaScript -->
<script src="<?= ASSETS; ?>partenaire/dist/js/init.js"></script>
</body>
</html>





