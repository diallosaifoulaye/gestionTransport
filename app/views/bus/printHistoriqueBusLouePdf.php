<?php
/*/**
 * Created by PhpStorm.
 * User: bayedame
 * Date: 31/08/2018
 * Time: 10:57
 */
use app\core\Utils;

?>

<page backtop="2mm" backbottom="0mm" backleft="10mm" backright="10mm">

    <table width="642" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
            <td width="29%" align="left" valign="middle"><img src="<?/*= WEBROOT;*/?>assets/plugins/images/white-sunusva.png" width="80" /></td>
            <td width="25%" align="right" valign="middle" class="textNormal">&nbsp;</td>
            <td width="23%" align="right" valign="middle" class="textNormal">&nbsp;</td>
        </tr>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <tr>
            <td colspan="4" style="font-size: 50px;" align="center" valign="middle" class="txt_legend"><?= $this->lang['historiqueBusLoue'] ?></td>
        </tr>
    </table>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <table align="center" border="1" style="" cellspacing="0">
        <thead>

        <tr width = 100% style=" background: #ededed;color: #000000;">
            <th> <?php echo $this->lang['nom_locataire']; ?></th>
<!--            <th><?php /*echo $this->lang['prenom_locataire']; */?></th>
-->            <th><?php echo $this->lang['telephone']; ?></th>
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
<!--                <td class="designtd" style="border-left:solid 1px #3c4451;"> <?php /*echo $busL->prenom_locataire */?></td>
-->                <td class="designtd" style="border-left:solid 1px #3c4451;"> <?php echo $busL->telephone ?></td>
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
