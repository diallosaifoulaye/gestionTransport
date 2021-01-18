<?php
/**
 * Created by PhpStorm.
 * User: bayedame
 * Date: 11/09/2018
 * Time: 14:34
 */
?>
<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>administration/addParamWS" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['parametrage_ws']; ?></h4>
    </div>


    <div style="padding: 25px 10px ;">
        <div class="row">

            <div class="col-sm-12">
                <table class="table table-no-bordered table-striped" id="dynamic_field" align="center"  style="width:100%">
                        <tr style="border-bottom: 1px solid #0f0f0f;background: #d7dbde !important;">
                            <td>
                                <input type="text" class="form-control" placeholder="Paramètre" id="parametre" name="parametre1[]" >
                            </td>

                            <td>
                                <button id="add" type="button" class="btn btn-info btn-outline btn-circle btn-sm m-r-5" style="background-color:#ececec;margin-left: 30px;"><i class="fa fa-plus"></i></button>
                                <input type="hidden" value="1" id="nbrow">
<!--                                <input type="hidden" id="nbre_parametre" name="nbre_parametre[]" >
-->                                <input type="hidden" id="fk_webservice" name="fk_webservice" value="<?php echo $fk_webservice; ?>">
                            </td>
                        </tr>
                    </table>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" onclick="checkBeforeSubmit();" id="lebtnValider" type="button" disabled><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?></button>
    </div>
</form>


<script>

    var i =0;
    $('#add').click(function(){

        var parametre = $("#parametre").val();

        if(parametre != '')
        {
                i++;
                $('#dynamic_field').append(
                    '<tr class="" id="row' + i + '">' +
                    '<td>' + parametre + '<input type="hidden" name="parametre[]" value="' + parametre + '" ></td>' +
                    '<td><button id="minus" data-i="' + i + '" class="btn btn-info btn-outline btn-circle btn-sm m-r-5 btn_remove" style="background-color:#ececec;margin-left: 30px;margin-bottom: 30px;"><i class="fa fa-minus"></i></button></td>' +
                    '</tr>');
                $('#my-form')[0].reset();
                $('#lebtnValider').removeAttr('disabled');
                $('#lebtnValider').removeClass('disabled');
                document.getElementById('nbrow').value = i + 1;
                //$('#parametre').prop('readonly','true');
        }
        else
        {
            $('#lebtnValider').attr('disabled','disabled');
            $('#lebtnValider').addClass('disabled');
            swal({
                title: "<?= $this->lang['Msg_error']; ?>",
                text: "<?= $this->lang['Msg_par_req']; ?>",
                type: "warning"
            });
        }
    });
    $(document).on('click', '.btn_remove', function(){

        var button_id = $(this).data('i');
        $('#row'+button_id+'').remove();
        document.getElementById('nbrow').value = parseInt(document.getElementById('nbrow').value)-1 ;

        $('#lebtnValider').attr('disabled','disabled');
        $('#lebtnValider').addClass('disabled');
        swal({
            title: "<?= $this->lang['Msg_error']; ?>",
            text: "<?= $this->lang['Msg_Ecr']; ?>",
            type: "warning"
        });
    });
    function checkBeforeSubmit() {
        $('#lebtnValider').attr('type','submit');
        $("#my-form").submit();
    }

</script>
