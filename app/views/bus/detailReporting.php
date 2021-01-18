<?php
/**
 * Created by PhpStorm.
 * User: bayedame
 * Date: 31/08/2018
 * Time: 10:57
 */
use app\core\Utils;
?>



<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?= $this->lang['DetailLocation']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'menu/menu'; ?>"><?= $this->lang['accueil']; ?></a></li>

                    <li><a href="<?= WEBROOT.'bus/listeBusL'; ?>"><?= $this->lang['listeBusLoues']; ?></a></li>

                    <li class="active"><?= $this->lang['DetailLocation']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">

            <div class="col-md-offset-3 col-lg-offset-3 col-xs-offset-3 col-md-6 col-xs-6 col-lg-6">
                <div class="white-box" >
                    <!--                    <div class="user-bg"> <img width="100%" alt="user" src="../plugins/images/large/img1.jpg"> </div>-->

                    <div class="user-btm-box">
                        <div class=" col-md-9 col-lg-9 ">
                            <table class="table table-user-information">
                                <tbody>
                                <tr>
                                    <td><strong><?= $this->lang['nom_locataire']; ?></strong>:</td>
                                    <td><?= $busLoue->nom_locataire; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?= $this->lang['numeroIdentification']; ?></strong>:</td>
                                    <td><?=  $busLoue->prenom_locataire; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?= $this->lang['adresse']; ?></strong></td>
                                    <td><?= $busLoue->piece_identite; ?></td>
                                </tr>

                                <tr>
                                <tr>
                                    <td><strong><?= $this->lang['telephone']; ?></strong></td>
                                    <td><?=  $busLoue->adresse; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?= $this->lang['matriculeBus']; ?></strong></td>
                                    <td><?= $busLoue->matricule; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?= $this->lang['date_reservation']; ?></strong></td>
                                    <td><?= $busLoue->date_reservation; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?= $this->lang['date_debut']; ?></strong></td>
                                    <td><?= $busLoue->date_deb; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?= $this->lang['date_fin']; ?></strong></td>
                                    <td><?= $busLoue->date_fin; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?= $this->lang['priceByDay']; ?></strong></td>
                                    <td><?= $busLoue->price_by_day; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?= $this->lang['thEtat']; ?></strong></td>
                                    <td>
                                        <?php
                                        if( $busLoue->etat==0){
                                            echo "<i class='text-danger'>".$this->lang['annule']." </i>";
                                        }
                                        elseif ($busLoue->etat==1){
                                            echo "<i class='text-success'>".$this->lang['reserve']."</i>";
                                        }elseif($busLoue->etat==2){
                                            echo"<i class='text-success'>".$this->lang['valide']."</i>";
                                        }elseif ($busLoue->etat==3){
                                            echo "<i class='text-info'>".$this->lang['traite']."</i>";
                                        }else{
                                            echo "ETAT INEXISTANT";
                                        }
                                        ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?= $this->lang['nombreDeJours']; ?></strong></td>
                                    <td><?= $nbJours; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?= $this->lang['montant']; ?></td>
                                    <td><strong><?= Utils::getFormatMoney($busLoue->montant_total); ?></strong></td>
                                </tr>

                                </tbody>
                            </table>
                            <br>
                            <br>


                            <div class="row">
                                <div class="pull-left">
                                    <a  href="<?= WEBROOT ?>location/reporting" >
                                        <button type="button" class="btn btn-success" ><?= $this->lang['btn_retour'];?></button>
                                    </a>

                                </div>
                                <form action="" method="post" >
                                    <input type="hidden" name="id" value="<?= base64_encode($busLoue->id) ?>" >
                                </form>
                               <!-- <?php /*if ($busLoue->etat == 1 or $busLoue->etat == 2){*/?>
                                    <form method="post" action="<?/*= WEBROOT */?>location/annuleBusLoueDetail">
                                        <div class="col-lg-4 col-sm-4 col-xs-4 ">
                                            <input type="hidden" name="id" value="<?/*= base64_encode($busLoue->id) */?>" >
                                            <button style="font-size:14px" type="submit" class="btn btn-success fa-pull-left" ><?/*= $this->lang['annule'];*/?></button>
                                        </div>
                                    </form>
                                <?php /*}*/?>
                                <?php /*if ($busLoue->etat == 1){*/?>
                                    <form method="post" action="<?/*= WEBROOT */?>location/valideBusLoueDetail">
                                        <div class="col-lg-4 col-sm-4 col-xs-4 ">
                                            <input type="hidden" name="id" value="<?/*= base64_encode($busLoue->id) */?>" >
                                            <button style="font-size:14px" type="submit" class="btn btn-success fa-pull-left" ><?/*= $this->lang['valide'];*/?></button>
                                        </div>
                                    </form>
                                <?php /*}*/?>
                                <?php /*if ($busLoue->etat == 2){*/?>
                                    <form method="post" action="<?/*= WEBROOT */?>bus/traiteBusLoueDetail">
                                        <div class="col-lg-4 col-sm-4 col-xs-4 ">
                                            <input type="hidden" name="id" value="<?/*= base64_encode($busLoue->id) */?>" >
                                            <button style="font-size:14px" type="submit" class="btn btn-success fa-pull-left" ><?/*= $this->lang['traite'];*/?></button>
                                        </div>
                                    </form>

                                --><?php /*}*/?>

                                <form action="<?= WEBROOT ?>location/imprimerDetailBusLoue" method="post" >
                                    <div class="pull-right ">
                                        <input type="hidden" name="id" value="<?= base64_encode($busLoue->id) ?>" >
                                        <button style="font-size:19px" type="submit" class="btn btn-success pull-right fa fa-file-pdf-o " ></button>
                                    </div>

                                </form>


                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>







    <script>

        $(function () {
            $("#from").datepicker({
                dateFormat: 'yy-mm-dd',
                defaultDate: "+0w",
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function (selectedDate) {
                    $("#to").datepicker("option", "minDate", "dateFormat", selectedDate);
                }
            });
        }

    </script>


