<?php
include("include/config.php");

$placement=$_GET['placement'];
$btn_style=$_GET['btn_style'];
$button_size=$_GET['button_size'];
$plugin_size=$_GET['plugin_size'];
$custom_w=$_GET['custom_w'];
$custom_h=$_GET['custom_h'];
$social_network=$_GET['social_network'];
$social_network_arr=explode(",",$social_network);

    if($button_size=="30") { $max_disp=6; }   
    if($button_size=="40" || $button_size=="50") { $max_disp=6; }
    if($button_size>="60") { $max_disp=6; }


    if($btn_style=="ic") {
        $btn_width=$button_size;
    }
    else if($btn_style=="fc" || $btn_style=="fg")
    {
        if($button_size=="30") {$btn_width="78"; }
        if($button_size=="40") {$btn_width="104"; }
        if($button_size=="50") {$btn_width="130"; }
        if($button_size=="60") {$btn_width="156"; }
        if($button_size=="65") {$btn_width="169"; }
    }

if(count($social_network_arr)>$max_disp) { $tot=$max_disp; }
else { $tot=count($social_network_arr); }

    $imgdiv="";
    for($i=0; $i<$tot; $i++)
    {
        $img='social_login_'.$btn_style.'_'.$button_size.'.png';
        $bg_position=(($social_network_arr[$i]-1)*$btn_width);
        $imgdiv.='<div style="float: left; margin: 5px; width: '.$btn_width.'px; height: '.$button_size.'px; background-image: url('.SITE_URL.'img/social_icon/'.$img.'); background-position: -'.$bg_position.'px 0px;"></div>';
    }
    
    echo $imgdiv;
?>
<!--div id="preview_div">
<div style="float: left; margin-right: 10px; width: 30px; height: 30px; background-image: url(<?php echo SITE_URL;?>img/social_icon/social_login_ic_30.png); background-position: -30px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 30px; height: 30px; background-image: url(<?php echo SITE_URL;?>img/social_icon/social_login_ic_30.png); background-position: -180px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 30px; height: 30px; background-image: url(<?php echo SITE_URL;?>img/social_icon/social_login_ic_30.png); background-position: -360px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 30px; height: 30px; background-image: url(<?php echo SITE_URL;?>img/social_icon/social_login_ic_30.png); background-position: -90px 0px;"></div>
</div>
<div style="clear: both;">&nbsp;</div>
<div id="preview_div">
<div style="float: left; margin-right: 10px; width: 40px; height: 40px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_40.png); background-position: -40px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 40px; height: 40px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_40.png); background-position: -240px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 40px; height: 40px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_40.png); background-position: -480px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 40px; height: 40px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_40.png); background-position: -120px 0px;"></div>
</div>
<div style="clear: both;">&nbsp;</div>
<div id="preview_div">
<div style="float: left; margin-right: 10px; width: 50px; height: 50px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_50.png); background-position: -50px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 50px; height: 50px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_50.png); background-position: -300px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 50px; height: 50px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_50.png); background-position: -600px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 50px; height: 50px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_50.png); background-position: -150px 0px;"></div>
</div>
<div style="clear: both;">&nbsp;</div>
<div id="preview_div">
<div style="float: left; margin-right: 10px; width: 60px; height: 60px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_60.png); background-position: -60px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 60px; height: 60px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_60.png); background-position: -360px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 60px; height: 60px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_60.png); background-position: -720px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 60px; height: 60px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_60.png); background-position: -180px 0px;"></div>
</div>
<div style="clear: both;">&nbsp;</div>
<div id="preview_div">
<div style="float: left; margin-right: 10px; width: 65px; height: 65px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_65.png); background-position: -65px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 65px; height: 65px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_65.png); background-position: -390px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 65px; height: 65px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_65.png); background-position: -780px 0px;"></div>
<div style="float: left; margin-right: 10px; width: 65px; height: 65px; background-image: url(<?php //echo SITE_URL;?>img/social_icon/social_login_ic_65.png); background-position: -195px 0px;"></div>
</div>
<div style="clear: both;">&nbsp;</div-->