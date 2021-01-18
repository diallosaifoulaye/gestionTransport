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
                <h4 class="page-title"><?php echo $this->lang['gestionDistributeur']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="<?= WEBROOT.'menu/menu'; ?>">  <?php echo $this->lang['accueil']; ?></a></li>
                    <li><a href="<?= WEBROOT.'location/index'; ?>">  <?php echo $this->lang['gestionDistributeur']; ?></a></li>
                    <li class="active"><?php echo $this->lang['ajoutDistributeur']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row" style="background-color: #ffffff">
            <form id="validation" class="form-inline form-validator" data-type="update" role="form" name="location"
                action="<?= WEBROOT ?>distri/ajoutDistributeur" method="post" >

                <div class="column col-sm-6">
                    <h2 style="margin-left: 330px"><?php echo $this->lang['InformtationPointDistributeur']; ?></h2>
                    <div class="col-sm-5"></div>

                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="nom_point" class="control-label"><?php echo $this->lang['nomPoint']; ?></label>
                            <input type="text" id="nom_point" name="nom_point" class="form-control" placeholder="<?php echo $this->lang['nomPoint']; ?>"
                                   style="width: 100%" required >
                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="email_point" class="control-label"><?php echo $this->lang['labemail']; ?></label>
                            <input type="email" id="email_point" name="email_point" class="form-control" placeholder="<?php echo $this->lang['labemail']; ?>"
                                   style="width: 100%" required >
                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="adresse_point" class="control-label"><?php echo $this->lang['labadresse']; ?></label><br/>
                            <textarea rows="4" cols="120" id="adresse_point" name="adresse_point" class="form-control"  required >
                            </textarea>
                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="region" class="control-label"><?php echo $this->lang['region']; ?></label>
                            <select id="idRegion" required class="form-control select2" onchange="getDepartementBy();"  name="region"  style="width: 100%"  >
                                <option value="">Sélectionner une region</option>
                                <?php foreach ($regions as $value) { ?>
                                    <option <?= $value->rowid ?> value="<?= $value->rowid ?>"><?= $value->label ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="idDepartement" class="control-label"><?php echo $this->lang['departement']; ?></label>

                            <select id="idDepartement" required class="form-control select2"  name="departement" style="width: 100%" >
                                <option value="">Sélectionner un département</option>

                            </select>
                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="telephone" class="control-label"><?php echo $this->lang['telephone']; ?></label>

                            <input type="telephone" id="telephone_point" name="telephone_point"  class="form-control" placeholder="<?php echo $this->lang['telephone']; ?>" style="width: 100%" required>

                            <span class="help-block with-errors"> </span>
                        </div>
                </div>

                <div class="column col-sm-6">
                    <h2  style="margin-left: 120px"><?php echo $this->lang['InformtationResponsableDistribution']; ?></h2>
                    <div class="col-sm-5"></div>


                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="nom_locataire" class="control-label"><?php echo $this->lang['labnom']; ?></label>
                            <input type="text" id="nom_agent" name="nom_agent" class="form-control" placeholder=<?php echo $this->lang['labnom']; ?>
                                   style="width: 100%" required >
                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="prenom" class="control-label"><?php echo $this->lang['labprenom']; ?></label>
                            <input type="text" id="prenom_agent" name="prenom_agent" class="form-control" placeholder=<?php echo $this->lang['labprenom']; ?>
                                   style="width: 100%" required >
                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="email" class="control-label"><?php echo $this->lang['labemail']; ?></label>
                            <input type="email" id="email_agent" name="email_agent" onchange="verifEmail()" class="form-control" placeholder="<?php echo $this->lang['labemail']; ?>"
                                   style="width: 100%" required >
                            <span id="msg2"></span>
                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="address" class="control-label"><?php echo $this->lang['labadresse']; ?></label><br/>
                            <textarea rows="4" cols="120" id="adresse_agent" name="adresse_agent" class="form-control"  required >
                            </textarea>
                            <span class="help-block with-errors"> </span>
                        </div>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="telephone" class="control-label"><?php echo $this->lang['telephone']; ?></label>
                            <input type="telephone" id="telephone" name="telephone_agent"  class="form-control" placeholder="<?php echo $this->lang['telephone']; ?>" style="width: 100%" required>
                            <span class="help-block with-errors"> </span>
                        </div>
                    <input type="hidden" id="type" name="type"  class="form-control" value="<?php echo 1; ?>" style="width: 100%" required>

                </div>
                <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                <button class="btn btn-success  pull-right" id="submit" style="margin-right: 100px" data-form="my-form" type="submit" onclick="price()"><i class="fa fa-check"></i> <?php echo $this->lang['btnAjouter']; ?>
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




<script >

    function getDepartementBy()
    {

        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'distri/getDepartementByRegion'; ?>",

            data: "idRegion="+$('#idRegion').val(),
            success: function(data) {
                data = JSON.parse(data);
                var collect = '';
                collect += '<option value="" ><?= $this->lang['select_departement']; ?></option>';
                for(var i = 0; i<data.length; i++){
                    var first1 = data[i].label;
                    var first = data[i].rowid;
                    collect += '<option value="'+first+'">'+first1+'</option>';
                }
                document.getElementById("idDepartement").innerHTML = collect;

            }
        });

    }

    $('input[type="telephone"]').intlTelInput({
        utilsScript: '<?= ASSETS;?>plugins/telPlug/js/utils.js',
        autoPlaceholder: true,
        preferredCountries: [ 'lr', 'gm', 'gb','ci'],
        initialDialCode: true,
        nationalMode: false
    });

</script>

<script>
    function verifEmail(){
        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'distri/verifExistenceEmail'; ?>",

            data: "email_agent="+document.getElementById('email_agent').value,
            success: function(data) {

                if(parseInt(data) == 1){
                    $('#msg2').html("<p style='color:#F00;display: inline;border: 1px solid #F00'> <?= $this->lang['email_existe']; ?></p>");
                    document.getElementById('email_agent').value = '';


                }

            }
        });
    }

</script>

