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
            <td width="29%" align="left" valign="middle"><img src="<?/*= WEBROOT;*/?>assets/plugins/images/white-sunusva.png"" width="80" /></td>
            <td width="25%" align="right" valign="middle" class="textNormal">&nbsp;</td>
            <td width="23%" align="right" valign="middle" class="textNormal">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" align="center" valign="middle" class="txt_legend"><?= $this->lang['recu'] ?></td>

        </tr>

        <tr>
            <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form"><span class="txt_form1">Locataire</span>
                <hr align="center" style="border:#999 solid 1px" /></td>
        </tr>
        <tr>
            <td width="29%" align="left" valign="middle" nowrap="nowrap" class="txt_form"><strong>Nom:&nbsp;&nbsp;</strong><?= $busLoue->nom_locataire; ?></td>
            <!--            <td width="25%" align="left" valign="middle" class="txt_lister"><?/*= $busLoue->nom_locataire; */?></td>-->
            <td></td>
            <td width="23%" align="left" valign="middle" nowrap="nowrap" class="txt_form"><strong>Pr&eacute;nom: &nbsp;&nbsp;</strong><?= $busLoue->prenom_locataire; ?></td>
            <!-- <td width="23%" align="left" valign="middle" class="txt_lister"><?/*= $busLoue->prenom_locataire; */?></td>-->
        </tr>

        <tr>
            <td align="left" valign="middle" nowrap="nowrap" class="txt_form"><strong>N&ordm; d'identification: &nbsp;&nbsp;</strong><?= $busLoue->piece_identite; ?></td>
            <!--            <td align="left" valign="middle" class="txt_lister"><?/*= $busLoue->piece_identite; */?></td>
-->            <td></td>
            <td align="left" valign="middle" nowrap="nowrap" class="txt_form"><strong> N&ordm; de t&eacute;l&eacute;phone: &nbsp;&nbsp;</strong><?= $busLoue->telephone; ?></td>
            <!--<td align="left" valign="middle" class="txt_lister"><?/*= $busLoue->telephone; */?></td>-->

        </tr>
        <tr>
            <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form"><span class="txt_form1">Detail location bus</span>
                <hr align="center" style="border:#999 solid 1px" /></td>
        </tr>

        <tr>
            <td width="29%" align="left" valign="middle" nowrap class="txt_form"><strong>Matricule: &nbsp;&nbsp;</strong><?= $busLoue->matricule; ?></td>
            <!--<td width="25%" align="left" valign="middle" class="txt_lister"><?/*= $busLoue->matricule; */?></td>-->
            <td></td>
            <td width="23%" align="left" valign="middle" nowrap="nowrap" class="txt_lister"><span class="txt_form"><strong>Date debut: &nbsp;&nbsp;</strong><?= $busLoue->date_deb; ?></span></td>
            <!-- <td width="23%" align="left" valign="middle" class="txt_lister"><?/*= $busLoue->date_deb; */?></td>-->
        </tr>

        <tr>
            <td align="left" valign="middle" nowrap class="txt_form"><strong>Date fin: &nbsp;&nbsp;</strong><?= $busLoue->date_fin; ?></td>
            <td></td>
            <!-- <td align="left" valign="middle" class="txt_lister"><?/*= $busLoue->date_fin; */?></td>-->
            <?php
            $dateDeb = strtotime($busLoue->date_deb);
            $dateFin = strtotime($busLoue->date_fin);
            $nbJoursTimestamp = $dateFin - $dateDeb;
            $nbJours = $nbJoursTimestamp/86400;
            ?>
            <td align="left" valign="middle" nowrap class="txt_form"><strong>Nombre de jours: &nbsp;&nbsp;</strong><?= $nbJours; ?></td>

            <!-- <td align="left" valign="middle" class="txt_lister"><?/*= $nbJours; */?></td>-->

        </tr>
        <tr>
            <td align="left"  nowrap="nowrap" class="txt_lister"><span class="txt_form"><strong>Montant journalier: &nbsp;&nbsp;</strong>
                    <?= Utils::getFormatMoney($busLoue->price_by_day) ;?><?= $this->lang['currency']; ?></span></td>
            <!--<td align="left" valign="middle" class="txt_lister"><?/*= $busLoue->price_by_day; */?></td>-->
            <td></td>
            <td align="left" valign="middle" nowrap="nowrap" class="txt_lister"><span class="txt_form"><strong>Montant total: &nbsp;&nbsp;</strong><?= Utils::getFormatMoney($busLoue->montant_total); ?><?= $this->lang['currency']; ?></span></td>
            <!--<td align="left" valign="middle" class="txt_lister"><?/*= $busLoue->montant_total; */?></td>-->
        </tr>
        <tr>
            <td colspan="2" align="center" valign="top" nowrap class="txt_form1">&nbsp;</td>
            <td colspan="2" align="center" valign="top" nowrap="nowrap" class="txt_form1">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" align="center" valign="top" nowrap class="txt_form1">Signature client</td>
            <td colspan="2" align="center" valign="top" nowrap="nowrap" class="txt_form1">Cachet de l'agent<br/><?= $this->_USER->prenom.' '.$this->_USER->nom; ?></td>
        </tr>

        <tr>
            <td height="31" colspan="2" align="center" valign="top" nowrap class="txt_form">&nbsp;</td>
            <td colspan="2" align="center" valign="top" nowrap="nowrap" class="txt_lister">&nbsp;</td>
        </tr>
        <tr>
            <td height="31" colspan="2" align="center" valign="top" nowrap class="txt_form">&nbsp;</td>
            <td colspan="2" align="center" valign="top" nowrap="nowrap" class="txt_lister">&nbsp;</td>
        </tr>

        <tr>
            <td height="31" colspan="4" align="center" valign="top" nowrap class="txt_form">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="border-bottom:#CCC solid 0.5px"></td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" colspan="4">
                            <span style="font-size:13px; color: #666;">
                                <?= $this->lang['contact']; ?>: <?= $this->lang['tel_client']; ?>
                                <?= $this->lang['email']; ?>: <?= $this->lang['email_client']; ?>
                                <?= $this->lang['site_web']; ?>
                                : <?= $this->lang['site_client']; ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="middle">-------------------------------------------------------------------------------------------------------------------</td>
        </tr>
    </table>


    <table width="642" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
            <td width="29%" align="left" valign="middle"><img src="<?/*= WEBROOT;*/?>assets/plugins/images/white-sunusva.png"" width="80" /></td>
            <td width="25%" align="right" valign="middle" class="textNormal">&nbsp;</td>
            <td width="23%" align="right" valign="middle" class="textNormal">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" align="center" valign="middle" class="txt_legend"><?= $this->lang['recu'] ?></td>

        </tr>


        <tr>
            <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form"><span class="txt_form1">Locataire</span>
                <hr align="center" style="border:#999 solid 1px" /></td>
        </tr>
        <tr>
            <td width="29%" align="left" valign="middle" nowrap="nowrap" class="txt_form"><strong>Nom:&nbsp;&nbsp;</strong><?= $busLoue->nom_locataire; ?></td>
            <!--            <td width="25%" align="left" valign="middle" class="txt_lister"><?/*= $busLoue->nom_locataire; */?></td>-->
            <td></td>
            <td width="23%" align="left" valign="middle" nowrap="nowrap" class="txt_form"><strong>Pr&eacute;nom: &nbsp;&nbsp;</strong><?= $busLoue->prenom_locataire; ?></td>
            <!-- <td width="23%" align="left" valign="middle" class="txt_lister"><?/*= $busLoue->prenom_locataire; */?></td>-->
        </tr>

        <tr>
            <td align="left" valign="middle" nowrap="nowrap" class="txt_form"><strong>N&ordm; d'identification: &nbsp;&nbsp;</strong><?= $busLoue->piece_identite; ?></td>
            <!--            <td align="left" valign="middle" class="txt_lister"><?/*= $busLoue->piece_identite; */?></td>
-->            <td></td>
            <td align="left" valign="middle" nowrap="nowrap" class="txt_form"><strong> N&ordm; de t&eacute;l&eacute;phone: &nbsp;&nbsp;</strong><?= $busLoue->telephone; ?></td>
            <!--<td align="left" valign="middle" class="txt_lister"><?/*= $busLoue->telephone; */?></td>-->

        </tr>
        <tr>
            <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form"><span class="txt_form1">Detail location bus</span>
                <hr align="center" style="border:#999 solid 1px" /></td>
        </tr>

        <tr>
            <td width="29%" align="left" valign="middle" nowrap class="txt_form"><strong>Matricule: &nbsp;&nbsp;</strong><?= $busLoue->matricule; ?></td>
            <!--<td width="25%" align="left" valign="middle" class="txt_lister"><?/*= $busLoue->matricule; */?></td>-->
            <td></td>
            <td width="23%" align="left" valign="middle" nowrap="nowrap" class="txt_lister"><span class="txt_form"><strong>Date debut: &nbsp;&nbsp;</strong><?= $busLoue->date_deb; ?></span></td>
            <!-- <td width="23%" align="left" valign="middle" class="txt_lister"><?/*= $busLoue->date_deb; */?></td>-->
        </tr>

        <tr>
            <td align="left" valign="middle" nowrap class="txt_form"><strong>Date fin: &nbsp;&nbsp;</strong><?= $busLoue->date_fin; ?></td>
            <td></td>
            <!-- <td align="left" valign="middle" class="txt_lister"><?/*= $busLoue->date_fin; */?></td>-->
            <?php
            $dateDeb = strtotime($busLoue->date_deb);
            $dateFin = strtotime($busLoue->date_fin);
            $nbJoursTimestamp = $dateFin - $dateDeb;
            $nbJours = $nbJoursTimestamp/86400;
            ?>
            <td align="left" valign="middle" nowrap class="txt_form"><strong>Nombre de jours: &nbsp;&nbsp;</strong><?= $nbJours; ?></td>

            <!-- <td align="left" valign="middle" class="txt_lister"><?/*= $nbJours; */?></td>-->

        </tr>
        <tr>
            <td align="left"  nowrap="nowrap" class="txt_lister"><span class="txt_form"><strong>Montant journalier: &nbsp;&nbsp;</strong>
                    <?= Utils::getFormatMoney($busLoue->price_by_day) ;?><?= $this->lang['currency']; ?></span></td>
            <!--<td align="left" valign="middle" class="txt_lister"><?/*= $busLoue->price_by_day; */?></td>-->
            <td></td>
            <td align="left" valign="middle" nowrap="nowrap" class="txt_lister"><span class="txt_form"><strong>Montant total: &nbsp;&nbsp;</strong><?= Utils::getFormatMoney($busLoue->montant_total); ?><?= $this->lang['currency']; ?></span></td>
            <!--<td align="left" valign="middle" class="txt_lister"><?/*= $busLoue->montant_total; */?></td>-->
        </tr>
        <tr>
            <td colspan="2" align="center" valign="top" nowrap class="txt_form1">&nbsp;</td>
            <td colspan="2" align="center" valign="top" nowrap="nowrap" class="txt_form1">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" align="center" valign="top" nowrap class="txt_form1">Signature client</td>
            <td colspan="2" align="center" valign="top" nowrap="nowrap" class="txt_form1">Cachet de l'agent<br/><?= $this->_USER->prenom.' '.$this->_USER->nom; ?></td>
        </tr>

        <tr>
            <td height="31" colspan="2" align="center" valign="top" nowrap class="txt_form">&nbsp;</td>
            <td colspan="2" align="center" valign="top" nowrap="nowrap" class="txt_lister">&nbsp;</td>
        </tr>
        <tr>
            <td height="31" colspan="2" align="center" valign="top" nowrap class="txt_form">&nbsp;</td>
            <td colspan="2" align="center" valign="top" nowrap="nowrap" class="txt_lister">&nbsp;</td>
        </tr>

        <tr>
            <td height="31" colspan="4" align="center" valign="top" nowrap class="txt_form">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="border-bottom:#CCC solid 0.5px"></td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" colspan="4">
                            <span style="font-size:13px; color: #666;">
                                <?= $data['lang']['contact']; ?>
                                : +222 45 25 72 27 / <?= $data['lang']['email']; ?>
                                : serviceclient@postecash.mr /
                                <?= $data['lang']['site_web']; ?>
                                : www.postecash.mr
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</page>
