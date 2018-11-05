<?php 
include("include/config.php");
if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }

$error=array();
$icon_size="";
$req_custom="";
$custom_icon_size="";
$is_size_approved="";
$icon_w="";
$icon_h="";
$disabled=' disabled="disabled"';


if(isset($_POST['update']) && $_POST['update']=="Update")
{
    $icon_size=isset($_POST['icon_size']) ? $_POST['icon_size'] : '40x40';
    $req_custom=isset($_POST['req_custom']) ? $_POST['req_custom'] : '0';
    $is_size_approved=isset($_POST['is_size_approved']) ? $_POST['is_size_approved'] : '0';
    $icon_w=isset($_POST['icon_w']) ? $_POST['icon_w'] : '';
    $icon_h=isset($_POST['icon_h']) ? $_POST['icon_h'] : '';
    $custom_icon_size=$icon_w."x".$icon_h;
    
    if(!isset($_POST['icon_size'])) { $error[]="Please select social icon size."; }
    if(isset($_POST['req_custom']))
    {
        if($_POST['icon_w']=="") { $error[]="Please enter icon width."; }
        else if (!preg_match('/^[0-9]*$/', $_POST['icon_w'])) { $error[]="Please enter proper icon width."; }
        if($_POST['icon_h']=="") { $error[]="Please enter icon height."; }
        else if (!preg_match('/^[0-9]*$/', $_POST['icon_h'])) { $error[]="Please enter proper icon height."; }
        $disabled="";
    }
    
    if(count($error)<=0)
    {
        $u_update = "update cs_sites set 
                    icon_size='".$icon_size."', 
                    req_custom='".$req_custom."', 
                    custom_icon_size='".$custom_icon_size."' 
                    where id='".$_SESSION['admin_id']."'";
        re_db_query($u_update);
        
        $_SESSION['msg']="update";
        header("location:social_icon_setting.php"); exit;
    }
    
}


if(!isset($_POST['update']))
{
    $site_data_qry="select * from cs_sites where id='".$_SESSION['admin_id']."'";
    $site_data_sql=re_db_query($site_data_qry);
    
    if(re_db_num_rows($site_data_sql)>0)
    {
        $site_data_rec=re_db_fetch_array($site_data_sql);
        
        $icon_size=$site_data_rec['icon_size'];
        $req_custom=$site_data_rec['req_custom'];
        $custom_icon_size=$site_data_rec['custom_icon_size'];
        $is_size_approved=$site_data_rec['is_size_approved'];
        
        if($req_custom=="1")
        { 
            $custom_icon_size_arr=explode('x',$custom_icon_size);
            $icon_w=$custom_icon_size_arr[0];
            $icon_h=$custom_icon_size_arr[1];
            $disabled="";
        }
    }
}

if(isset($_SESSION['msg']) && $_SESSION['msg']=="update")
{ 
    $msg="Change Saved Successfully.";
    unset($_SESSION['msg']); 
}


include("header.php");
?>
<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
        <ol class="breadcrumb">
            <li>YOU ARE HERE</li>
            <li class="active">Social Settings</li>
        </ol>
        <!--h1 class="page-title">Site - <span class="fw-semi-bold">Settings</span></h1-->
        <div class="row">
            <div class="col-md-12">
                <section class="widget">
                    <header>
                        <h4>Social Icon <small>Setting</small></h4>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <form class="login-form mt-lg" action="" method="post" enctype="multipart/form-data">
                            <table class="table">
                                <tr><td style="border: medium none;">Please select any one social icon(Button) size for your service implementation.</td></tr>
                                <?php if(count($error)>0)
                                {
                                    ?><tr><td><?php echo display_error_msg($error);?></td></tr><?php
                                } if(isset($msg) && $msg!="") {?>
                                    <tr><td><span style="color: #008000;" ><?php echo $msg; ?></span></td></tr>
                                <?php }?>
                                <tr><th>Social Icon(Button) Size 30 X 30</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div style="float: left;"><input type="radio" name="icon_size" id="icon_size_1" value="30x30"<?php if($icon_size=="30x30") { echo ' checked="checked"';}?> /></div>
                                        <div style="float: left; margin-left: 10px;">
                                            <img src="<?php echo SITE_URL."img/social_icon/30x30/30x30_facebook.png";?>" alt="Facebook Icon 30 X 30" title="Facebook Icon 30 X 30" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/30x30/30x30_linkedin.png";?>" alt="LinkedIn Icon 30 X 30" title="LinkedIn Icon 30 X 30" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/30x30/30x30_twitter.png";?>" alt="Twitter Icon 30 X 30" title="Twitter Icon 30 X 30" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/30x30/30x30_google_plus.png";?>" alt="Google+ Icon 30 X 30" title="Google+ Icon 30 X 30" />&nbsp;
                                        </div>
                                    </td>
                                </tr>
                                <tr><th>Social Icon(Button) Size 40 X 40</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div style="float: left;"><input type="radio" name="icon_size" id="icon_size_2" value="40x40"<?php if($icon_size=="40x40") { echo ' checked="checked"';}?> /></div>
                                        <div style="float: left; margin-left: 10px;">
                                            <img src="<?php echo SITE_URL."img/social_icon/40x40/40x40_facebook.png";?>" alt="Facebook Icon 40 X 40" title="Facebook Icon 40 X 40" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/40x40/40x40_linkedin.png";?>" alt="LinkedIn Icon 40 X 40" title="LinkedIn Icon 40 X 40" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/40x40/40x40_twitter.png";?>" alt="Twitter Icon 40 X 40" title="Twitter Icon 40 X 40" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/40x40/40x40_google_plus.png";?>" alt="Google+ Icon 40 X 40" title="Google+ Icon 40 X 40" />&nbsp;
                                        </div>
                                    </td>
                                </tr>
                                <tr><th>Social Icon(Button) Size 50 X 50</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div style="float: left;"><input type="radio" name="icon_size" id="icon_size_3" value="50x50"<?php if($icon_size=="50x50") { echo ' checked="checked"';}?> /></div>
                                        <div style="float: left; margin-left: 10px;">
                                            <img src="<?php echo SITE_URL."img/social_icon/50x50/50x50_facebook.png";?>" alt="Facebook Icon 50 X 50" title="Facebook Icon 50 X 50" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/50x50/50x50_linkedin.png";?>" alt="LinkedIn Icon 50 X 50" title="LinkedIn Icon 50 X 50" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/50x50/50x50_twitter.png";?>" alt="Twitter Icon 50 X 50" title="Twitter Icon 50 X 50" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/50x50/50x50_google_plus.png";?>" alt="Google+ Icon 50 X 50" title="Google+ Icon 50 X 50" />&nbsp;
                                        </div>
                                    </td>
                                </tr>
                                <tr><th>Social Icon(Button) Size 70 X 70</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div style="float: left;"><input type="radio" name="icon_size" id="icon_size_5" value="70x70"<?php if($icon_size=="70x70") { echo ' checked="checked"';}?> /></div>
                                        <div style="float: left; margin-left: 10px;">
                                            <img src="<?php echo SITE_URL."img/social_icon/70x70/70x70_facebook.png";?>" alt="Facebook Icon 70 X 70" title="Facebook Icon 70 X 70" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/70x70/70x70_linkedin.png";?>" alt="LinkedIn Icon 70 X 70" title="LinkedIn Icon 70 X 70" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/70x70/70x70_twitter.png";?>" alt="Twitter Icon 70 X 70" title="Twitter Icon 70 X 70" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/70x70/70x70_google_plus.png";?>" alt="Google+ Icon 70 X 70" title="Google+ Icon 70 X 70" />&nbsp;
                                        </div>
                                    </td>
                                </tr>
                                <tr><th>Social Icon(Button) Size 100 X 100</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div style="float: left;"><input type="radio" name="icon_size" id="icon_size_7" value="100x100"<?php if($icon_size=="100x100") { echo ' checked="checked"';}?> /></div>
                                        <div style="float: left; margin-left: 10px;">
                                            <img src="<?php echo SITE_URL."img/social_icon/100x100/100x100_facebook.png";?>" alt="Facebook Icon 100 X 100" title="Facebook Icon 100 X 100" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/100x100/100x100_linkedin.png";?>" alt="LinkedIn Icon 100 X 100" title="LinkedIn Icon 100 X 100" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/100x100/100x100_twitter.png";?>" alt="Twitter Icon 100 X 100" title="Twitter Icon 100 X 100" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/100x100/100x100_google_plus.png";?>" alt="Google+ Icon 100 X 100" title="Google+ Icon 100 X 100" />&nbsp;
                                        </div>
                                    </td>
                                </tr>
                                <tr><th>Request Custom Size Icon(Button)</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div style="float: left;">
                                            <input type="checkbox" name="req_custom" id="req_custom" value="1"<?php if($req_custom=="1") { echo ' checked="checked"';}?> onclick="call_enable_custom_text(this.checked)" />
                                            <input type="hidden" name="is_size_approved" id="is_size_approved" value="<?php echo $is_size_approved;?>" />
                                        </div>
                                        <div style="float: left; margin-left: 10px;">
                                            W: <input style="width: 50px;" type="text" name="icon_w" id="icon_w"<?php echo $disabled;?> value="<?php echo $icon_w;?>" /> &nbsp;&nbsp;
                                            H: <input style="width: 50px;" type="text" name="icon_h" id="icon_h"<?php echo $disabled;?> value="<?php echo $icon_h;?>" /> &nbsp;&nbsp;
                                        </div>
                                        <?php if($req_custom=="1" && $is_size_approved=="1")
                                        {
                                            ?>
                                            <div style="clear: both;"></div>
                                            <div style="float: left; margin-left: 20px; margin-top: 10px;">
                                                <img src="<?php echo SITE_URL."img/social_icon/".$custom_icon_size."/".$custom_icon_size."_facebook.png";?>" alt="Facebook Icon <?php echo $icon_w;?> X <?php echo $icon_h;?>" title="Facebook Icon <?php echo $icon_w;?> X <?php echo $icon_h;?>" />&nbsp;
                                                <img src="<?php echo SITE_URL."img/social_icon/".$custom_icon_size."/".$custom_icon_size."_linkedin.png";?>" alt="LinkedIn Icon <?php echo $icon_w;?> X <?php echo $icon_h;?>" title="LinkedIn Icon <?php echo $icon_w;?> X <?php echo $icon_h;?>" />&nbsp;
                                                <img src="<?php echo SITE_URL."img/social_icon/".$custom_icon_size."/".$custom_icon_size."_twitter.png";?>" alt="Twitter Icon <?php echo $icon_w;?> X <?php echo $icon_h;?>" title="Twitter Icon <?php echo $icon_w;?> X <?php echo $icon_h;?>" />&nbsp;
                                                <img src="<?php echo SITE_URL."img/social_icon/".$custom_icon_size."/".$custom_icon_size."_google_plus.png";?>" alt="Google+ Icon <?php echo $icon_w;?> X <?php echo $icon_h;?>" title="Google+ Icon <?php echo $icon_w;?> X <?php echo $icon_h;?>" />&nbsp;
                                            </div>
                                            <?php 
                                        }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="clearfix">
                                            <div class="btn-toolbar pull-right">
                                                <input type="submit" name="update" class="btn btn-inverse btn-sm" value="Update" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </main>
</div>
<!-- The Loader. Is shown when pjax happens -->
<div class="loader-wrap hiding hide">
    <i class="fa fa-circle-o-notch fa-spin-fast"></i>
</div>

<!-- common libraries. required for every page-->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-pjax/jquery.pjax.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/transition.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/collapse.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/dropdown.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/button.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/alert.js"></script>
<script src="vendor/jQuery-slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/widgster/widgster.js"></script>
<script src="vendor/pace.js/pace.min.js"></script>
<script src="vendor/jquery-touchswipe/jquery.touchSwipe.js"></script>

<!-- common app js -->
<script src="js/settings.js"></script>
<script src="js/app.js"></script>

<!-- page specific libs -->
<script src="vendor/parsleyjs/dist/parsley.min.js"></script>
<!-- page specific js -->
<script src="js/form-validation.js"></script>
<script type="text/javascript">
    function call_enable_custom_text(checked)
    {
        if(checked==true)
        {
            document.getElementById('icon_w').disabled=false;
            document.getElementById('icon_h').disabled=false;
        }
        else if(checked==false)
        {
            document.getElementById('icon_w').disabled=true;
            document.getElementById('icon_h').disabled=true;
        }
    }
    call_enable_custom_text('n/a');
</script>
</body>
</html>