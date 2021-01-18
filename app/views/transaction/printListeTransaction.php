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
        border-right: 0.5px solid #0073a9;
    }

</style>

<page backtop="5mm" backbottom="10mm" backleft="5mm" backright="5mm"  backimg="<?= ROOT ?>" >

    <page_header>

    </page_header>



    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="font-size:10px; font-family: Arial, Helvetica, sans-serif">

        <tr>
            <td>
                <img src="<?= ROOT ?>assets/plugins/images/suNuSVA_logo.png" width="110"/ >
            </td>

            <td style="padding-left: 15px">
                <table>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </td>

            <td style="padding-left: 15px">
                <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </td>

            <td>
                <table>
                    <tr>
                        <td><img src="<?= ROOT ?>assets/plugins/images/icone_adresse.jpg" width="30" height="30"/></td>
                        <td>
                            <span class="gray-text">9927, VDN Amitié 3<br>Dakar</span>
                        </td>
                    </tr>
                </table>
            </td>

            <td >
                <table>
                    <tr>
                        <td colspan="1"></td>
                        <td><img src="<?= ROOT ?>assets/plugins/images/icone_tel.jpg"  width="40" height="40" /></td>
                        <td>
                            <span class="gray-text">+221 33 859 23 47<br>+221 33 859 23 48</span>
                        </td>
                    </tr>
                </table>
            </td>

            <td>
                <table>
                    <tr>
                        <td colspan="1"></td>
                        <td><img src="<?= ROOT ?>assets/plugins/images/icone_wsite.png" width="30" height="30" /></td>
                        <td>
                            <span class="gray-text">www.sunubus.sn</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td><br><br></td>
            <td colspan="5" style="font-weight: bold; font-size: 11px;" ></td>
        </tr>

        <tr style="background-color: #2f5088; font-weight: bold; color: #FFFFFF;font-size:18px">
            <td colspan="3"></td>
            <td  colspan="2" style="padding:7px 7px 7px 7px; align: center">
                <strong class="tiret"><?php echo "Transactions du Bus". " : " .$bus ;?></strong>
            </td>
            <td colspan="1"></td>
        </tr>

        <tr style="height: 5px; padding-bottom: 120px">
            <td colspan="6">&nbsp;</td>
        </tr>

        <tr style="font-size:18px">
            <td colspan="3"></td>
            <td style="padding:7px 27px 7px 7px; text-align: center" colspan="2">
            <td>&nbsp;</td>
            </td>
            <td colspan="1"></td>
        </tr>

        <tr style="height: 5px; padding-bottom: 120px">
            <td colspan="6">&nbsp;</td>
        </tr>
    </table>

    <table align="center" cellpadding="70px" cellspacing="0">
        <thead>

        <tr width = 100% style=" background: #ededed;color: #000000;">
            <th class="designth"><?= $this->lang['date']; ?></th>
            <th class="designth"><?= $this->lang['nomreceveur']; ?></th>
            <th class="designth"><?= $this->lang['matricule']; ?></th>
            <th class="designth"><?= $this->lang['dateticket']; ?></th>
            <th class="designth"><?= $this->lang['num_ticket']; ?></th>
            <th class="designth" ><?= $this->lang['montant']; ?> </th>
            <th class="designth" ><?= $this->lang['etat']; ?> </th>
        </tr>
        </thead>

        <tbody>
        <?php if($this->data['transaction'] != null) {
            foreach ($this->data['transaction'] as $item => $transac) { //var_dump($transaction);
                $i++; ?>

                <tr>
                    <td class="designtd" style="border-left:solid 1px #3c4451;"> <?php echo \app\core\Utils::getDateFR($transac->date) ?></td>
                    <td class="designtd" style="border-left:solid 1px #3c4451;"> <?php echo $transac->nomprenom ?></td>
                    <td class="designtd" style="border-left:solid 1px #3c4451;"> <?php echo $transac->bus ?></td>
                    <td class="designtd" style="text-align: right"><?php echo \app\core\Utils::getDateFR($transac->dateticket) ?></td>
                    <td class="designtd"><?php echo $transac->numticket ?></td>
                    <td class="designtd" style="text-align: right"><?php echo \app\core\Utils::getFormatMoney($transac->montant )?></td>
                    <td class="designtd"><?php echo $transac->etat ?></td>
                </tr>
            <?php  }
        }

        else { ?>
            <td><img src="<?= ROOT ?>app/pictures/noTransac.png"/></td>

        <?php } ?>
        </tbody>

    </table>

</page>