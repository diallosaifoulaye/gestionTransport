<div class="modal-header">
    <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
    <h4 class="modal-title"><?php echo $this->lang['detailTransact']; echo ' : '.$transaction->id; ?></h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="row col-lg-12">
                <table class="table table-striped table-hover table-responsive ">
                    <tr>
                        <th><?php echo $this->lang['bus']; ?></th>
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
                        <th><?php echo $this->lang['ticket']; ?></th>
                        <td><?php echo $transaction->ticket; ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang['receveur']; ?></th>
                        <td><?php echo $transaction->receveur; ?></td>
                    </tr>


                    <tr>
                        <th><?php echo $this->lang['etat']; ?></th>
                        <td><?php if ($transaction->etat == 0) echo '<span style="color: #f00">Echoué</span>'; else echo '<span style="color: green">Succès</span>' ?></td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
</div>

