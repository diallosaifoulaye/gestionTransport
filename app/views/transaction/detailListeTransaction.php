<?php
/**
 * Created by PhpStorm.
 * User: bayedame
 * Date: 31/08/2018
 * Time: 10:57
 */
?>



<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?= $this->lang['detail_transaction']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'menu/menu'; ?>"><?= $this->lang['accueil']; ?></a></li>

                    <li><a href="<?= WEBROOT.'transaction/listeTransaction'; ?>"><?= $this->lang['liste_transaction']; ?></a></li>

                    <li class="active"><?= $this->lang['detail_transaction']; ?></li>
                </ol>
            </div>
<!--
    <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
    <h4 class="modal-title"><?php /*echo $this->lang['detailTransact']; echo ' : '.$transaction->id; */?></h4>
</div>-->
<!--<div class="modal-body">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="row col-lg-12">-->

                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <div class="white-box">
                            <div class="d-flex justify-content-end">
                                <div class="mr-auto p-2"></div>
                                <div class="p-2"></div>

                            <table class="table table-striped table-hover table-responsive ">
                    <tr>
                        <th><?php echo $this->lang['matricule']; ?></th>
                        <td><?php echo $transaction->bus; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang['date']; ?></th>
                        <td><?php echo \app\core\Utils::getDateFR($transaction->date); ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang['montant']; ?></th>
                        <td><?php echo \app\core\Utils::getFormatMoney($transaction->montant); ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang['numticket']; ?></th>
                        <td><?php echo $transaction->numticket; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang['dateticket']; ?></th>
                        <td><?php echo \app\core\Utils::getDateFR($transaction->dateticket);  ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang['nomreceveur']; ?></th>
                        <td><?php echo $transaction->nomprenom; ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang['etat']; ?></th>
                        <td><?php if ($transaction->etat == 0) echo '<span style="color: #f00">'.$this->lang['Succes'].'</span>'; else echo '<span style="color: green">'.$this->lang['Succes'].'</span>' ?></td>
                    </tr>

                </table>
            </div>
                        </div>
                    </div>
    </div>
<div class="modal-footer">
    <a href="<?= WEBROOT ?>transaction/listeTransaction" >
        <button type="button" class=" btn btn-success"><?= $this->lang['btn_retour'] ; ?></button>
<!--    <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> --><?php //echo $this->lang['btnFermer']; ?><!-- </button>-->
    </a>
</div>

