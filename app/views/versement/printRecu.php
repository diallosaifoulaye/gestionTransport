
<style>
    .borderTOP
    {
        border-top: 1px solid black;

        margin: 0;
    } .borderLEFT
      {
          border-left: 1px solid black;


      } .borderRIGHT
        {
            border-right: 1px solid black;
        } .borderBOTTOM
          { margin: 0;
              border-bottom: 1px solid black;

          }
</style>


<page backtop="5mm" backbottom="5mm"  backright="5mm" backleft="5mm" orientation="L">

    <table border="0"  cellpadding="0" cellspacing="0">
        <tr>
            <td style="width: 500px;" >
                <table cellpadding="0" cellspacing="0">
                    <tr  >
                        <td width="143" rowspan="2" align="left" valign="middle"  class="borderRIGHT borderLEFT borderTOP borderBOTTOM"  style="width: 115px;"><img src="<?= ROOT ?>assets/plugins/images/white-sunusva.png"  height="30" width="100" style="margin: 15px; " /></td>

                        <td colspan="3" align="center"  valign="middle" class="textNormal borderRIGHT  borderTOP " style="width: 115px;"><?php echo $this->lang['nta']; ?></td>
                    </tr>
                    <tr  >
                        <td colspan="3" align="center"  valign="middle" class="textNormal borderRIGHT  borderTOP borderBOTTOM" style="width: 115px;"><span class="txt_form1" style="color: #1f375a;font-weight: bold"><?php echo $this->lang['recu_versement']; ?></span></td>
                    </tr>

                    <tr>
                        <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form"><!-- <hr align="center" style="border:#999 solid 1px" />-->
                        </td>
                    </tr>

                    <tr >
                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT "><?php echo $this->lang['date']; ?>: </td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT" ><?php echo \app\core\Utils::getDateFR($versement->date_creation)  ?></td>
                    </tr>
                    <tr >
                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT "><?php echo $this->lang['montant_collect']; ?>:</td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT" ><span class="textNormal borderRIGHT borderLEFT borderTOP borderBOTTOM" style="width: 115px;"><?php echo \app\core\Utils::getFormatMoney($versement->montant) ;?> XOF</span>                        </td>
                    </tr>

                    <tr>
                        <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form borderBOTTOM "><span class="txt_form1"></span>
                        </td>
                    </tr>
                    <tr >

                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT ">&nbsp; </td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT">&nbsp; </td>
                    </tr>


                    <tr >

                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT ">DETAILS </td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT"> </td>
                    </tr>


                    <tr >

                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT "><?php echo $this->lang['collecte']; ?>:</td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT"><?php echo $this->lang['montant']; ?></td>
                    </tr>
                    <?php foreach($details as $detail){?>
                        <tr>
                            <td align="left" valign="middle" nowrap="nowrap" class="txt_form borderLEFT"><?php echo \app\core\Utils::getDateFR($detail->date_versement) ?></td>
                            <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo \app\core\Utils::getFormatMoney($detail->montant).' XOF'; ?></td>
                        </tr>
                    <?}?>


                    <tr>
                        <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form borderTOP"><span class="txt_form1"></span>
                        </td>
                    </tr>
                    <tr>
                        <td  align="left" valign="middle" nowrap="nowrap" class="txt_form   borderLEFT"><strong><?php echo $this->lang['receveur']; ?></strong></td>
                        <td colspan="3"  align="left" valign="middle" nowrap="nowrap" class="txt_form   borderLEFT borderRIGHT"><span class="txt_form1"></span><span class="txt_lister borderLEFT borderRIGHT"></span></td>
                    </tr>

                    <tr>
                        <td  align="left" valign="middle" nowrap="nowrap " class="txt_form borderLEFT"><?php echo $this->lang['prenom']; ?> & <?php echo $this->lang['nom']; ?>:</td>
                        <td colspan="3"  align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo $details[0]->label; ?></td>
                    </tr>

                    <tr>
                        <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form borderBOTTOM "><span class="txt_form1"></span>
                        </td>
                    </tr>
                    <tr>
                        <td  align="left" valign="middle" nowrap="nowrap" class="txt_form  borderLEFT">
                            <span class="txt_form1"><strong><?php echo $this->lang['agentCaissier']; ?></strong></span></td>

                        <td colspan="3"  align="left" valign="middle" nowrap="nowrap" class="txt_form   borderLEFT borderRIGHT"><span class="txt_form1"></span><span class="txt_lister borderLEFT borderRIGHT"></span></td>
                    </tr>

                    <tr>
                        <td align="left" valign="middle" nowrap class="txt_form borderLEFT"><?php echo $this->lang['prenom']; ?> & <?php echo $this->lang['nom']; ?>:</td>
                        <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo $this->_USER->prenom.' '.$this->_USER->nom;?></td>
                    </tr>



                    <tr>
                        <td colspan="4"  align="left" valign="middle" nowrap="nowrap" class="txt_form borderTOP   "><span class="txt_form1"></span>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="3" align="center" valign="top" nowrap class="txt_form1  borderLEFT">&nbsp;</td>
                        <td width="157" align="center" valign="top" nowrap="nowrap" class="txt_form1 borderRIGHT">&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="2" align="left" valign="top" nowrap class="txt_form1 borderLEFT"><?php echo $this->lang['signature_collecteur']; ?></td>
                        <td colspan="2" align="center" valign="top" nowrap class="txt_form1  borderRIGHT"><?php echo $this->lang['signature_agent']; ?></td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center" valign="top" nowrap class="txt_form  borderLEFT "><p>&nbsp;</p>
                            <p>&nbsp;</p></td>
                        <td colspan="2" align="center" valign="top" nowrap="nowrap" class="txt_lister  borderRIGHT">&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="4" align="center" valign="top" nowrap class="txt_form borderTOP " ></td>
                    </tr>
                </table>
            </td>
            <td style="width: 35px"></td>
            <td style="width: 500px;" >
                <table cellpadding="0" cellspacing="0">
                    <tr  >
                        <td width="143" rowspan="2" align="left" valign="middle"  class="borderRIGHT borderLEFT borderTOP borderBOTTOM"  style="width: 115px;"><img src="<?= ROOT ?>assets/plugins/images/white-sunusva.png"  height="30" width="100" style="margin: 15px; " /></td>

                        <td colspan="3" align="center"  valign="middle" class="textNormal borderRIGHT  borderTOP " style="width: 115px;"><?php echo $this->lang['nta']; ?></td>
                    </tr>
                    <tr  >
                        <td colspan="3" align="center"  valign="middle" class="textNormal borderRIGHT  borderTOP borderBOTTOM" style="width: 115px;"><span class="txt_form1" style="color: #1f375a;font-weight: bold"><?php echo $this->lang['recu_versement']; ?></span></td>
                    </tr>

                    <tr>
                        <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form"><!-- <hr align="center" style="border:#999 solid 1px" />-->
                        </td>
                    </tr>

                    <tr >
                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT "><?php echo $this->lang['date']; ?>: </td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT" ><?php echo \app\core\Utils::getDateFR($versement->date_creation)  ?></td>
                    </tr>
                    <tr >
                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT "><?php echo $this->lang['montant_collect']; ?>:</td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT" ><span class="textNormal borderRIGHT borderLEFT borderTOP borderBOTTOM" style="width: 115px;"><?php echo \app\core\Utils::getFormatMoney($versement->montant) ;?> XOF</span>                        </td>
                    </tr>

                    <tr>
                        <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form borderBOTTOM "><span class="txt_form1"></span>
                        </td>
                    </tr>
                    <tr >

                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT ">&nbsp; </td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT">&nbsp; </td>
                    </tr>


                    <tr >

                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT ">DETAILS </td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT"> </td>
                    </tr>


                    <tr >

                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT "><?php echo $this->lang['collecte']; ?>:</td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT"><?php echo $this->lang['montant']; ?></td>
                    </tr>
                    <?php foreach($details as $detail){?>
                        <tr>
                            <td align="left" valign="middle" nowrap="nowrap" class="txt_form borderLEFT"><?php echo \app\core\Utils::getDateFR($detail->date_versement) ?></td>
                            <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo \app\core\Utils::getFormatMoney($detail->montant).' XOF'; ?></td>
                        </tr>
                    <?}?>


                    <tr>
                        <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form borderTOP"><span class="txt_form1"></span>
                        </td>
                    </tr>
                    <tr>
                        <td  align="left" valign="middle" nowrap="nowrap" class="txt_form   borderLEFT"><strong><?php echo $this->lang['receveur']; ?></strong></td>
                        <td colspan="3"  align="left" valign="middle" nowrap="nowrap" class="txt_form   borderLEFT borderRIGHT"><span class="txt_form1"></span><span class="txt_lister borderLEFT borderRIGHT"></span></td>
                    </tr>

                    <tr>
                        <td  align="left" valign="middle" nowrap="nowrap " class="txt_form borderLEFT"><?php echo $this->lang['prenom']; ?> & <?php echo $this->lang['nom']; ?>:</td>
                        <td colspan="3"  align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo $details[0]->label; ?></td>
                    </tr>

                    <tr>
                        <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form borderBOTTOM "><span class="txt_form1"></span>
                        </td>
                    </tr>
                    <tr>
                        <td  align="left" valign="middle" nowrap="nowrap" class="txt_form  borderLEFT">
                            <span class="txt_form1"><strong><?php echo $this->lang['agentCaissier']; ?></strong></span></td>

                        <td colspan="3"  align="left" valign="middle" nowrap="nowrap" class="txt_form   borderLEFT borderRIGHT"><span class="txt_form1"></span><span class="txt_lister borderLEFT borderRIGHT"></span></td>
                    </tr>

                    <tr>
                        <td align="left" valign="middle" nowrap class="txt_form borderLEFT"><?php echo $this->lang['prenom']; ?> & <?php echo $this->lang['nom']; ?>:</td>
                        <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo $this->_USER->prenom.' '.$this->_USER->nom;?></td>
                    </tr>



                    <tr>
                        <td colspan="4"  align="left" valign="middle" nowrap="nowrap" class="txt_form borderTOP   "><span class="txt_form1"></span>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="3" align="center" valign="top" nowrap class="txt_form1  borderLEFT">&nbsp;</td>
                        <td width="157" align="center" valign="top" nowrap="nowrap" class="txt_form1 borderRIGHT">&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="2" align="left" valign="top" nowrap class="txt_form1 borderLEFT"><?php echo $this->lang['signature_collecteur']; ?></td>
                        <td colspan="2" align="center" valign="top" nowrap class="txt_form1  borderRIGHT"><?php echo $this->lang['signature_agent']; ?></td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center" valign="top" nowrap class="txt_form  borderLEFT "><p>&nbsp;</p>
                            <p>&nbsp;</p></td>
                        <td colspan="2" align="center" valign="top" nowrap="nowrap" class="txt_lister  borderRIGHT">&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="4" align="center" valign="top" nowrap class="txt_form borderTOP " ></td>
                    </tr>
                </table>
            </td>
            <td style="width: 25px"></td>
        </tr>
    </table>

</page>
