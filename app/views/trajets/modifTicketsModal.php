<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>trajets/updateTickets" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modificationTicket']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="num_ticket" class="control-label"><?php echo $this->lang['num_ticket']; ?></label>
                        <input type="text" id="num_ticket" name="num_ticket" value="<?= $ticket->num_ticket ?>" class="form-control"
                               style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="prix" class="control-label"><?php echo $this->lang['prix']; ?></label>
                        <input type="text" id="prix" name="prix" value="<?= $ticket->prix ?>" class="form-control"
                                style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="date_ticket" class="control-label"><?php echo $this->lang['date_ticket']; ?></label>
                        <input type="text" name="date_ticket" required class="form-control mydatepicker" id="date_ticket"
                               value="<?= $ticket->date_ticket ?>" placeholder="<?php echo $this->lang['date_ticket']; ?>" autocomplete="off" style="width: 100%">
                </div>
                <input type="hidden" name="id" value="<?= base64_encode($ticket->id) ?>">

                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?></button>
    </div>
</form>

<script>
    $(function () {
        $("#date_ticket").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });
    });
</script>