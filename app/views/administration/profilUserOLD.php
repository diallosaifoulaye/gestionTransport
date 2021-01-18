<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['detailUser1'];
                    echo $user->prenom . " " . $user->nom; ?></h4></div>

            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="#"> <?php echo $this->lang['tabBord']; ?></a></li>
                    <li class="active"><?php echo $this->lang['detailUser']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row bg-title">
            <div class="row col-lg-12">

                <table class="table table-striped table-hover table-responsive ">
                    <tr>
                        <th class=" "><?php echo $this->lang['labprenom']; ?></th>
                        <td class=" "><?= $user->prenom; ?></td>
                        <td rowspan="8" class="text-center" style="width:400px">
                            <img src="<?= $user->photoPATH; ?>" style="width: 350px;padding: 15px;"/>
                        </td>
                    </tr>
                    <tr>
                        <th class=""><?php echo $this->lang['labnom']; ?></th>
                        <td class=""><?= $user->nom; ?></td>

                    </tr>
                    <tr>
                        <th class=""><?php echo $this->lang['labemail']; ?></th>
                        <td class=" "><?= $user->email; ?></td>
                    </tr>
                    <tr>
                        <th class=" "><?php echo $this->lang['labLogin']; ?></th>
                        <td class=" "><?= $user->login; ?></td>
                    </tr>

                </table>
                <? print $token; ?>

            </div>

            <div class="row col-lg-12">
                <h3 class="panel-title pull-right">
                    <button type="button" class="open-modal btn btn-success"
                            data-modal-controller="administration/modifUtilisateurModal"
                            data-modal-view="<?= base64_encode("administration") ?>/<?= base64_encode("modifUtilisateurModal") ?>/<?= base64_encode($user->id) ?>/r">
                        <i class="fa fa-check"></i>
                        <?php echo $this->lang['btnModifier']; ?>
                    </button>

                    <button type="button" class="open-modal btn btn-primary "
                            data-modal-controller="administration/modifpwdUtilisateurModal"
                            data-modal-view="<?= base64_encode("administration") ?>/<?= base64_encode("modifpwdUtilisateurModal") ?>/<?= base64_encode($user->id) ?>">
                        <i class="fa fa-check"></i>
                        <?php echo $this->lang['btnmodifpwd']; ?>
                    </button>


                </h3>
            </div>
        </div>
    </div>
</div>
