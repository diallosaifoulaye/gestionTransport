<?php
/*/**
 * Created by PhpStorm.
 * User: bayedame
 * Date: 31/08/2018
 * Time: 10:57
 */
use app\core\Utils;

?>
<style>
    td.test {
        width: 3em;
        word-wrap: break-word;
    }

    .designth {

        border-top:1px solid #3c4451;
        border-left:solid 1px #3c4451;
        border-right: solid 1px #3c4451;
        border-bottom:solid 1px #3c4451;
        padding: 5px;
        font-weight: bold;

    }

    .designtd {

        border-top:solid 1px #888888;
        border-right: solid 1px #888888;
        padding: 3px;
        border-bottom:solid 1px #3c4451;
        color: black;
    }

    .tiret {
        border-bottom: 1px solid #0073a9;
        border-top: 1px solid #0073a9;
        border-left: 0.5px solid #0073a9;
        border-right: 2.5px solid #0073a9;
    }



</style>

<page backtop="5mm" backbottom="10mm" backleft="5mm" backright="5mm"  backimg="<?= ROOT ?>" >

    <page_header>

    </page_header>



    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="font-size:10px; font-family: Arial, Helvetica, sans-serif">

        <tr>
            <td><br><br></td>
            <td colspan="5" style="font-weight: bold; font-size: 11px;" ></td>
        </tr>

        <tr style="background-color: #2f5088; font-weight: bold; color: #FFFFFF;font-size:18px">
            <td colspan="3"></td>
            <td  colspan="5" style=" align: center; font-size: 15px;" >
                <strong class="tiret"><?php echo $this->lang['historiqueBusLoue'] ;?></strong>
            </td>
            <td colspan="1"></td>
        </tr>

        <tr style="font-size:18px">
            <td colspan="3"></td>
            <td style="padding:7px 27px 7px 7px; text-align: center" colspan="2">
            <td>&nbsp;</td>
            </td>
            <td colspan="1"></td>
        </tr>
    </table>
    <table align="center" cellpadding="70px" cellspacing="0"  style="font-size: 12px;">
        <thead>

        <tr width = 100% style=" background: #ededed;color: #000000;">
            <th> <?php echo $this->lang['nom_locataire']; ?></th>
            <th><?php echo $this->lang['prenom_locataire']; ?></th>
            <th><?php echo $this->lang['telephone']; ?></th>
            <th><?php echo $this->lang['matriculeBus']; ?></th>
            <th><?php echo $this->lang['date_deb'];?></th>
            <th><?php echo $this->lang['date_fin']; ?></th>
            <th><?php echo $this->lang['priceByDay']; ?></th>
            <th><?php echo $this->lang['montant']; ?></th>
            <th><?php echo $this->lang['thEtat']; ?></th>
        </tr>
        </thead>

        <tbody>
        <?php
            foreach ($busLoue as $busL) { ?>
                <tr>
                    <td class="designtd" style="border-left:solid 1px #3c4451;"> <?php echo $busL->nom_locataire ?></td>
                    <td class="designtd" style="border-left:solid 1px #3c4451;"> <?php echo $busL->prenom_locataire ?></td>
                    <td class="designtd" style="border-left:solid 1px #3c4451;"> <?php echo $busL->telephone ?></td>
                    <td class="designtd" style="border-left:solid 1px #3c4451;"> <?php echo $busL->matricule ?></td>
                    <td class="designtd" style="border-left:solid 1px #3c4451;"> <?php echo $busL->date_deb ?></td>
                    <td class="designtd" style="border-left:solid 1px #3c4451;"> <?php echo $busL->date_fin ?></td>
                    <td class="designtd" style="border-left:solid 1px #3c4451;"> <?php echo Utils::getFormatMoney($busL->price_by_day) ?></td>
                    <td class="designtd" style="border-left:solid 1px #3c4451;"> <?php echo Utils::getFormatMoney($busL->montant_total) ?></td>
                    <td class="designtd" style="border-left:solid 1px #3c4451;">
                        <?php
                            if($busL->etat == 0){
                                echo "Annulé";
                            }elseif ($busL->etat == 1){
                                echo "Réservé";
                            }elseif ($busL->etat == 2){
                                echo "Validé";
                            }elseif ($busL->etat == 3){
                                echo "Traité";
                            }else{
                                echo " ";
                            }

                        ?>
                    </td>
                </tr>
            <?php  }?>

        </tbody>

    </table>

</page>