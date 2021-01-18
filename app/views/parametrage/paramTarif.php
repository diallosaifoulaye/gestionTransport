<<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['paramtarif']; ?></h4></div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="#"> <?php echo $this->lang['tabBord']; ?></a></li>
                    <li class="active"><?php echo $this->lang['paramtarif']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <form id="formaddPrix" class="form-inline form-validator" data-toggle="validator" data-type="update" role="form"
              name="form"
              action="<?= WEBROOT ?>parametrage/ajoutTarif" method="post">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-sm-6">
                            <table class="table table-no-bordered ">
                                <tbody>
                                <tr>
                                    <th class="col-lg-4"><?php echo $this->lang['labpoidsmin']; ?></th>
                                    <th class="col-lg-4"><?php echo $this->lang['labpoidsmax']; ?></th>
                                    <th class="col-lg-4"><?php echo $this->lang['labprix']; ?></th>
                                </tr>
                                </tbody>
                            </table>

                            <table class="table table-striped  ">
                                <tbody id="bill">
                                <? if (count($tarif) == 0) {?>
                                <tr class="MyClass">
                                    <td><input id="poidsmin0" name="poidsmin[]" type="text"></td>
                                    <td><input id="poidsmax0" name="poidsmax[]"  type="text"></td>
                                    <td><input id="prix0" name="prix[]"  type="text"></td>

                                </tr>
                                <?}else{?>
                                    <? foreach ($tarif as $key => $item) {?>
                                    <tr class="MyClass">
                                        <td><input id="poidsmin<?php echo $key; ?>" disabled value="<?php echo $item->poidsmin; ?>" type="text"></td>
                                        <td><input id="poidsmax<?php echo $key; ?>" disabled value="<?php echo $item->poidsmax; ?>" type="text"></td>
                                        <td><input id="prix<?php echo $key; ?>" disabled value="<?php echo $item->prix; ?>" type="text"></td>
                                        <?}?>
                                    </tr>
                                <?}?>
                                <tr class="MyClass">
                                    <td><input id="poidsmin<?php echo count($tarif); ?>" readonly value="<?php echo $max+1; ?>" name="poidsmin[]" type="text"></td>
                                    <td><input id="poidsmax<?php echo count($tarif); ?>" required name="poidsmax[]"  type="text"></td>
                                    <td><input id="prix<?php echo count($tarif); ?>" required name="prix[]"  type="text"></td>

                                </tr>
                                </tbody>
                            </table>

                            <table class="table">
                                <tbody>
                                <tr>
                                    <td class="pull-right">
                                        <button type="button" class="btn btn-danger" onclick="deleteRow('bill');">
                                            <i class="fa fa-remove"></i></button>
                                        <input type="hidden" id="sizetableau" name="sizetableau" value="<?= count($tarif)?>">
                                        <button type="button" class="btn btn-success" onclick="addRow();"
                                                id="btn_addtr"><i class="fa fa-plus-square-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr id="tralert" hidden="">
                                    <td>
                                        <div class="alert alert-danger">
                                            Merci de bien remplir les champs!
                                    </td>

                                </tr>
                                </tbody>
                            </table>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3 col-sm-offset-2 pull-left">
                                        <button id="annuler" class="btn btn-danger" type="button"
                                                data-dismiss="modal"><?php echo $this->lang['btnAnnuler']; ?></button>
                                    </div>

                                    <div class="col-sm-3 pull-right">
                                        <button type="submit"  id="btnMinMax"
                                                class="btn btn-success "><?php echo $this->lang['btnValider']; ?></button>
                                    </div>


                                </div>


                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6">


                    </div>


                </div>

            </div>

        </form>
    </div>
</div>


<script >

    function recupSize(idobject){
        var sie = $('#'+idobject).val();
        return sie;
    }

     function addRow() {

        var lastTR = $("#bill");
        var min = parseInt(lastTR[0].children[lastTR[0].children.length-1].cells[0].children[0].value);
        var max = parseInt(lastTR[0].children[lastTR[0].children.length-1].cells[1].children[0].value);

        if (max > min) {

            var clonedRow = '<tr class="MyClass">'
                + '<td><input type="text" readonly id="poidsmin" value="'+(max+1)+'" name="poidsmin[]" required/></td>'
                + '<td><input type="text" id="poidsmax" required name="poidsmax[]" required /></td>'
                + '<td><input type="text" id="prix" required name="prix[]" required/></td>'
                + '</tr>';

            $("#bill").append(clonedRow);

        }
        else {
            $("#tralert").show();
        }


    }

    function deleteRow(tableid) {
        var lastTR = $("#bill");
        var line = lastTR[0].children[lastTR[0].children.length-1];
        $(line).remove();
    }



</script>