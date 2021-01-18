
<div class="user-profile">
    <div class="dropdown user-pro-body">
        <div>
<!--            <img src="<?/*= ASSETS;*/?>pictures/<?php /*echo $this->_USER->photo ;*/?>" alt="user-img" class="img-circle">
-->
        </div>
        <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->_USER->nom_agent;?><span class="caret"></span></a>
        <ul class="dropdown-menu animated flipInY">
           <!-- <li>
                <a href="<?/*= WEBROOT."admin/profilUser" */?>">
                    <i class="ti-user"></i>&nbsp;&nbsp<?php /*echo $this->lang['mon_profil']; */?>
                </a>
            </li>-->
            <li><a href="<?php echo WEBROOT."home/unlogin" ?>"><i class="fa fa-power-off"></i>&nbsp;&nbsp;<?php echo $this->lang['se_deconnecter']; ?></a></li>
        </ul>
    </div>
</div>
<div class="user-profile" style="font-weight: bold;padding: 1px 0 20px;color: white;background-color: #325186">


            <?php

            if($this->sidebar=='sidebar_operations') echo  '<br>'.Strtoupper($this->lang['operation']).'</br>';
            if($this->sidebar=='sidebar_agent') echo  '<br>'.Strtoupper($this->lang['agent']).'</br>';
            /*if($this->sidebar=='sidebar_administration') echo  '<br>'.Strtoupper($this->lang['administration']).'</br>';
            if($this->sidebar=='sidebar_partenaire') echo  '<br>'.Strtoupper($this->lang['partenaire']).'</br>';
            if($this->sidebar=='sidebar_commande') echo  '<br>'.$this->lang['commande'].'</br>';
            if($this->sidebar=='sidebar_parametrage') echo  '<br>'.$this->lang['parametrage'].'</br>';
            if($this->sidebar=='sidebar_partner') echo  '<br>'.Strtoupper($this->lang['partenaire']).'</br>';
            if($this->sidebar=='sidebar_boutique') echo  '<br>'.Strtoupper($this->lang['btq']).'</br>';*/

            ?>

</div>
