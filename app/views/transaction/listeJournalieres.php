
<div id="page-wrapper">
    <div class="container-fluid">
        <?php require_once (ROOT . 'app/views/template/notify.php'); ?>

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['transactionsJournalieres']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'home/menu'; ?>">  <?php echo $this->lang['accueil']; ?></a></li>
                    <li><a href="<?= WEBROOT.'transaction/index'; ?>">  <?php echo $this->lang['transaction']; ?></a></li>
                    <li class="active"><?php echo $this->lang['transactionsJournalieres']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="row bg-title">

            <form class="form-horizontal" method="POST"
                  action="<?php echo WEBROOT ?>transaction/transactionsJournalieres">

                <div class="col-md-1"></div>

                <div class="form-group col-lg-2 col-sm-2">
                    <label for="from" class="control-label" ><?php echo $this->lang['date_deb']; ?> (*): </label>
                    <input type="text" name="datedeb" required class="form-control mydatepicker" id="from" placeholder="<?php echo $this->lang['date_deb']; ?>" autocomplete="off">&nbsp;&nbsp;
                </div>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="col-md-1" style="width: 4%"></div>

                <div class="form-group col-lg-2 col-sm-2">
                    <label for="from" class="control-label" ><?php echo $this->lang['date_fin']; ?> (*): </label>
                    <input type="text" name="datefin" required class="form-control mydatepicker" id="to" placeholder="<?php echo $this->lang['date_fin']; ?>" autocomplete="off">
                </div>

                <div class="col-md-1" style="width: 4%"></div>
                <div class="form-group col-lg-2 col-sm-2">
                    <label for="from" class="control-label"><?php echo $this->lang['transactionprjour']; ?></label>

                    <select id="bus" name="bus" class="form-control select2">
                        <option value=""> <?php echo $this->lang['select_bus']; ?></option>
                        <?php foreach ($bus as $onelistetransactionsjournalieres) { ?>
                            <option value="<?php echo $onelistetransactionsjournalieres->id; ?>"<? if ($liste == $onelistetransactionsjournalieres->id) echo "selected=selected" ?>>
                                <?php echo $onelistetransactionsjournalieres->matricule; ?> /
                                <?php echo $onelistetransactionsjournalieres->categorie; ?> /
                                <?php echo $onelistetransactionsjournalieres->Places; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-1" style="width: 4%"></div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-success btn-circle btn-lg" title="Rechercher"><i
                            class="ti-search"></i></button>
                </div>

            </form>
        </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $(".select2").select2();
</script>



