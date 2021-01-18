<div class="row">
    <div class="row white-box" style="margin-top:0px; margin-bottom: 4px">
        <div class="col-lg-2 col-sm-6 bg-theme text-white"
             style="height: 40px; vertical-align: middle; padding-top:10px;background-color: #325186 !important;">
            <center><b>A la une SunuSVA</b></center>
        </div>
        <div class="col-lg-10 col-sm-6 annulation">
            <marquee>
                <a href="">
                    <?php
                    $allmessage = \app\core\Utils::getModel('Message')->getMessage(["condition" => ["etat = " => 1]]);
                    foreach ($allmessage as $message)
                    {
                        //if($admin==1 || $this->profil->Acces_module($message['module'], $profil, $groupe, $entite)==1) {

                            echo '<b>'. $message->expediteur.': </b>'.$message->txt_messenger.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+++---+++&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

                        //}

                    }
                    ?>
                </a>
            </marquee>

        </div>
    </div>

</div>