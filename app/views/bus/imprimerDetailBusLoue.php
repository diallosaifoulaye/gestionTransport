<?php
/**
 * Created by PhpStorm.
 * User: bayedame
 * Date: 31/08/2018
 * Time: 10:57
 */
?>



    <page  >
        <div id="page-wrapper">
        <h3 style="text-align: center">
            <strong >CONTRAT LOCATION BUS</strong>
        </h3>
        <br/>
        <div style="margin-left: 50px;">

                ENTRE LES SOUSSIGNÉS,<br/>
                La société DEM DIKK, <br/>
                Appelé ci-après le <strong>loueur</strong><br/>
                ET
                <?= $busLoue->nom_locataire; ?>,<br/>
                Appelé ci-après <strong>locataire</strong>,<br>
                IL A ETE CONVENU CE QUI SUIT,

            <h4><strong>1.1- Nature et date d'effet du contrat</strong></h4>
            <strong>DEM DIKK</strong> met à disposition du <strong> <?= $busLoue->nom_locataire; ?></strong>, un bus immatriculé <?= $busLoue->matricule; ?>, à titre onéreux et à compter du DATE_DEBUT
            <h4><strong>1.2- Etat du bus</strong></h4>
            Lors de la remise du bus et de sa restitution, un procès verbal de l'état du bus sera établi entre le locataire et le loueur.<br>
            Le bus devra être restitué le même état que lors de sa remise. Toutes les détériorations sur le bus constatées sur le PV de sortie seront à la charge du locataire.<br>
            Le locataire certifie être en possession du permis l'autorisant à conduire le present bus.
            <h4><strong>1.3- Prix de la location du bus</strong></h4>
            Les parties s'entendent sur un prix de location <?=  $busLoue->price_by_day; ?> LDR par jour. Le locataire a choisi NOMBRE_DE_JOUR. Le montant total est: <?= $busLoue->montant_total; ?>.
            <h4><strong>1.4- Jours supplémentaires</strong></h4>
            Toute restitution du bus allant au délà du nombre de jour precisé à l'article 1.3 du present contrat sera facturé au double du prix par jour.
            <h4><strong>1.5- Durée et restitution du bus</strong></h4>
            Le contrat est à durée determiné. Il ne pourra être annulé une fois que le locataire sera en possession du bus.
            <h4><strong>1.6- Autres éléments et accessoires</strong></h4>
            Le locataire prendra en charge l'ensemble des charges afférentes à la mise à disposition du bus:<br>
             Frais d'entretien en cas de panne
             Les frais de carburant
             L'assurance des passagers à bord
            <h4><strong>1.7- Clause en cas de litige</strong></h4>
            Les parties conviennent expressément que tout litige pouvant naître de l'exécution du présent contrat relèvera de la compétence du tribunal de ...........<br>
            Fait en deux exemplaires originaux remis à chacune des parties,
            <br><br>
            Fait en deux exemplaires originaux remis à chacune des parties,<br><br><br>
            A ..........................., le ................................

            <table border="0" >
                <tr>
                    <td>Le locataire<br>
                        Signature précédée de la mention manuscrite LU ET APPROUVÉ
                    </td>
                    <td> </td>
                    <td> </td>
                    <td>Le loueur<br>
                        Signature précédée de la mention manuscrite LU ET APPROUVÉ

                    </td>
                </tr>
            </table>
        </div>
        </div>

    </page>




