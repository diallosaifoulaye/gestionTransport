<div class="modal-header">
    <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
    <h4 class="modal-title"><?php echo $this->lang['detailTransact']; echo ' : '.$transactPart->num_transaction; ?></h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="row col-lg-12">
                <table class="table table-striped table-hover table-responsive ">
                    <tr>
                        <th><?php echo $this->lang['num_transaction']; ?></th>
                        <td><?php echo $transactPart->num_transaction; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang['date_transaction']; ?></th>
                        <td><?php echo \app\core\Utils::getDateFR($transactPart->date_transaction); ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang['montant_transact']; ?></th>
                        <td><?php echo \app\core\Utils::getFormatMoney($transactPart->montant); ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang['commission']; ?></th>
                        <td><?php echo \app\core\Utils::getFormatMoney($transactPart->commission); ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang['commentaire']; ?></th>
                        <td><?php echo $transactPart->commentaire; ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang['service']; ?></th>
                        <td><?php echo $transactPart->service; ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang['statut_transact']; ?></th>
                        <td><?php if ($transactPart->statut == 0) echo '<span style="color: #f00">Echoué</span>'; else echo '<span style="color: green">Succès</span>' ?></td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
</div>

