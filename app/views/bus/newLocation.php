<?php
use app\core\Utils;

?>

<link rel="stylesheet" href="<?= ASSETS ?>plugins/telPlug/css/intlTelInput.css">
<div id="page-wrapper">
    <style>
        * {
            box-sizing: border-box;
        }

        /* Create two equal columns that floats next to each other */
        .column {
            float: left;
            width: 50%;
            padding: 10px;
            /*height: 450px; /* Should be removed. Only for demonstration */
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
    <div class="container-fluid" >
        <?php require_once (ROOT . 'app/views/template/notify.php'); ?>
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['gestion_location']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'menu/menu'; ?>">  <?php echo $this->lang['accueil']; ?></a></li>
                    <li><a href="<?= WEBROOT.'location/index'; ?>">  <?php echo $this->lang['gestion_location']; ?></a></li>
                    <li class="active"><?php echo $this->lang['gestion_location']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row" style="background-color: #ffffff">
            <form id="validation" class="form-inline form-validator" data-type="update" role="form" name="location"
                  action="<?= WEBROOT ?>location/ajoutNouvelleLocation" method="post" >

                <div class="column" >
                    <h2 align="right" style="margin-right: 120px">INFORMATION LOCATAIRE</h2>
                    <div class="col-sm-5"></div>
                    <div class="col-sm-6">

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="nom" class="control-label"><?php echo $this->lang['nom']; ?></label>
                            <input type="text" id="nom_locataire" name="nom_locataire" class="form-control" placeholder="Veuillez entrer le nom du locataire"
                                   style="width: 100%" required >
                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="prenom" class="control-label"><?php echo $this->lang['prenom']; ?></label>
                            <input type="text" id="prenom_locataire" name="prenom_locataire" class="form-control" placeholder="Veuillez entrer le prenom du locataire"
                                   style="width: 100%" required>
                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="piece_identite" class="control-label"><?php echo $this->lang['piece_identite']; ?></label>
                            <input type="text" name="piece_identite" class="form-control"  id="piece_identite"
                                   placeholder="<?php echo $this->lang['piece_identite']; ?>" autocomplete="off" style="width: 100%" required>
                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="address" class="control-label"><?php echo $this->lang['labadresse']; ?></label>
                            <textarea rows="4" cols="50" id="adresse" name="adresse" class="form-control"  required >
                            </textarea>
                            <span class="help-block with-errors"> </span>
                        </div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="telephone" class="control-label"><?php echo $this->lang['telephone']; ?></label>

                            <input type="telephone" id="telephone" name="telephone"  class="form-control" placeholder="<?php echo $this->lang['telephone']; ?>" style="width: 100%" required>

                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <p style="size: 250px">
                                Particulier &nbsp<input type="radio" id="intermediaire" name="intermediaire" value="particulier" checked=checked onchange="myFunction1(this.value);">
                                &nbsp;&nbsp;&nbsp;&nbsp
                                Tiers &nbsp<input type="radio" id="intermediaire" name="intermediaire" value="tiers" onchange="myFunction1(this.value);">
                            </p>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="tiers" class="control-label" id="labelTiers" style="display: none"><?php echo $this->lang['entrepriseName']; ?></label>
                            <input type="text" id="nom_entreprise" name="nom_entreprise" class="form-control" placeholder="Veuillez entrer l'adresse du locataire"
                                   style="width: 100%; display: none" >

                            <span class="help-block with-errors"> </span>
                        </div>
                    </div>
                </div>

                <div class="column">
                    <h2 align="left" style="margin-left: 65px">INFORMATION LOCATION</h2>
                    <div class="col-sm-offset-5"></div>
                    <div class="col-sm-6">
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="price_by_day" class="control-label"> <?php echo $this->lang['nbrePlaces']; ?></label>
                            <select id="price_by_day" class="form-control select2" style="width: 100%"   name="price_by_day" onchange="myFunction(this.value);">
                                <option value="">  <?php echo $this->lang["nbrePlaces"]?></option>

                                <?php foreach ($places as $pl) { ?>
                                    <option value="<?php echo $pl->price_by_day; ?>" > [<?php echo $pl->place_min;  ?>-<?php echo $pl->place_max ?>]  PRIX: <?php echo Utils::getFormatMoney($pl->price_by_day); echo $this->lang['currency'] ?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group" style="width: 105%;padding: 10px;">
                            <label for="listeBus" class="control-label ">Liste des Bus</label>
                            <select id="listeBus" name="select_bus" class="form-control select2" style="width: 100%" required>
                                <option value="">  <?php echo $this->lang["select_bus"]?></option>
                                <?php foreach ($location as $loc) { ?>
                                    <option value="<?php echo $loc->id; ?>"> <?php echo $loc->matricule;  ?>  </option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group column" style="width: 100%;padding: 10px;">
                            <label for="date_reservation" class="control-label"><?php echo $this->lang['date_reservation']; ?></label>
                            <input id="from1" name="date_reservation" type="text" class="form-control"
                                   value="<?php echo date("Y-m-d"); ?>" onchange="myFunction1(this.value);" required>
                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="date_deb" class="control-label"><?php echo $this->lang['date_debut']; ?></label>

                            <input id="from2" name="date_deb" class="form-control" type="text"  placeholder="<?php echo $this->lang['date_deb']; ?>"
                                   onchange="myFunction(this.value);" value="<?php echo date("Y-m-d"); ?>" required>

                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="date_fin" class="control-label "><?php echo $this->lang['date_fin']; ?></label>
                            <input id="from3" name="date_fin" class="form-control" type="text"  placeholder="<?php echo $this->lang['date_fin']; ?>"
                                   onchange="myFunction(this.value);" required>

                            <span class="help-block with-errors"> </span>
                        </div>

                        <h2>Montant de la facturation</h2>
                        <table>
                            <tr>
                                <td><h3 id="stringJour" style="display: none"> Nombre de jour: &nbsp;</h3></td>
                                <td><h3 id="jour"></h3></td>
                            </tr>
                            <tr>
                                <td><h3 id="stringMontant" style="display: none"> Montant Total: &nbsp;</h3></td>
                                <td><h3 id="montant"></h3></td>
                            </tr>
                        </table>



                        <h3 id="montant"> </h3>
                    </div>
                </div>
                <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                <button class="btn btn-success  pull-right" id="submit" style="margin-right: 100px; display: none" data-form="my-form" type="submit" onclick="price()"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
                </button>
            </form>

        </div>
        </div>

    </div>

</div>

</div>


<script src="<?= ASSETS; ?>plugins/telPlug/js/intlTelInput.js"></script>
<script src="<?= ASSETS; ?>plugins/telPlug/js/utils.js"></script>


<script src="<?= ASSETS; ?>js/telPlug/js/utils.js"></script>

<script>
    $('input[type="telephone"]').intlTelInput({
        utilsScript: '<?= ASSETS;?>plugins/telPlug/js/utils.js',
        autoPlaceholder: true,
        preferredCountries: [ 'sn','lr', 'gm', 'gb','ci'],
        initialDialCode: true,
        nationalMode: false
    });
</script>
<script type="text/javascript">

    $(document).ready(function() {
        $('#from1').datetimepicker({
            minTime:0
            }

        );
        $('#from2').datetimepicker({
            minDate: 0
            }
        );
        $('#from3').datetimepicker(
            {
                minDate: '+1970/01/02'
            }
        );
    });

    function myFunction1() {

        var choixIntermediaire = document.querySelector('input[name="intermediaire"]:checked').value;
        if (choixIntermediaire == 'tiers'){
            document.getElementById("labelTiers").style.display = "block";
            document.getElementById("nom_entreprise").style.display = "block";
        }else{
            document.getElementById("labelTiers").style.display = "none";
            document.getElementById("nom_entreprise").style.display = "none";
        }
    }

    function myFunction() {
        var int1=new Intl.NumberFormat();
        var price =  document.getElementById("price_by_day").options[document.getElementById('price_by_day').selectedIndex].value;
        var dateDeb = $('#from2').datetimepicker('getValue');
        var dateFin = $('#from3').datetimepicker('getValue');
        var diffDay = 24*60*60*1000;
        var diffDays = Math.round(Math.abs((dateDeb - dateFin )/(diffDay)));

        if(price != '' && dateDeb != null && dateFin != null){
                document.getElementById("stringJour").style.display= "block";
                document.getElementById("jour").innerHTML= (diffDays +" ").bold();
                document.getElementById("stringMontant").style.display= "block";
                document.getElementById("montant").innerHTML=(int1.format( diffDays*price) +" LRD").bold();
                document.getElementById("submit").style.display= "block";
          /*  }else{
                document.getElementById("jour").innerHTML= "La date fin doit être superieure à la date debut";
            }*/
        }
        else{
            document.getElementById("jour").innerHTML= "Veuillez selectionnez le nombre de place";
        }
    }

</script>
<script type="text/javascript">
    function price(){
        var price_by_day = $("#price_by_day").val();
        if(price_by_day != ""){
            $.ajax({
                type: "POST",
                url: "<?= WEBROOT ?>/bus/ajoutNouvelleLocation",
                data: {
                    nom_locataire: $("#nom_locataire").val(),
                    prenom_locataire: $("#prenom_locataire").val(),
                    piece_identite: $("#piece_identite").val(),
                    adresse : $("#adresse").val(),
                    telephone: $("#telephone").val(),
                    intermediaire: $("#intermediaire").val(),
                    nom_entreprise: $("#nom_entreprise").val(),
                    price_by_day: parseInt($("#price_by_day").val()),
                    select_bus: $("#select_bus").val(),
                    date_reservation: $("#date_reservation").val(),
                    date_deb: $("date_deb").val(),
                    date_fin: $("date_fin").val()

                },
                success: function (data)
                {
                    data=JSON.parse(data);
                    //if(data.ok == 1){
                    //  location.href  = "<?= WEBROOT ?>/bus/listeBusL";
                    //}else {
                    //  alert('Veuillez revoir la saisie des données')
                    //}
                }
            })
        }
    }


</script>


