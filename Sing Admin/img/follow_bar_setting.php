<?php 
include("include/config.php");
if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }


    $file_name="client_".$_SESSION['admin_id']."_follow.js";
    $file_path=DIR_FS_CLIENT_SHARE_JS;
    $file_url=SITE_WS_CLIENT_SHARE_JS.$file_name;


$error=array();
$follow_btn_size="";
$provider[1]="";
$provider_url[1]="";
$provider_title[1]="";
$provider_id[1]="";
$disabled=' disabled="disabled"';


if(isset($_POST['save']) && $_POST['save']=="Save")
{
    $follow_btn_size=isset($_POST['follow_btn_size']) ? $_POST['follow_btn_size'] : '40x40';
    $provider=$_POST['$provider'];
    $provider_url=$_POST['provider_url'];
    $provider_title=$_POST['provider_title'];
    $provider_id=$_POST['provider_id'];
    
    if(!isset($_POST['follow_btn_size'])) { $error[]="Please select social icon size."; }
    
    if(count($error)<=0)
    {
        $u_update = "update cs_sites set follow_btn_size='".$follow_btn_size."' where id='".$_SESSION['admin_id']."'";
        re_db_query($u_update);
        
        $is_change="0";
        foreach($_POST['provider_id'] as $key => $val)
        {
            if($val!="" && isset($_POST['provider'][$key]) && $_POST['provider'][$key]!="" && isset($_POST['provider_url'][$key]) && $_POST['provider_url'][$key]!="" && isset($_POST['provider_title'][$key]) && $_POST['provider_title'][$key]!="")
            {
                $is_change="1";
                re_db_query("update cs_follow_bar_setting set 
                            provider='".$_POST['provider'][$key]."', 
                            provider_url='".$_POST['provider_url'][$key]."', 
                            provider_title='".$_POST['provider_title'][$key]."' 
                            where client_id='".$_SESSION['admin_id']."' and provider_id='".$val."'");
            }
            if($val=="" && isset($_POST['provider'][$key]) && $_POST['provider'][$key]!="" && isset($_POST['provider_url'][$key]) && $_POST['provider_url'][$key]!="" && isset($_POST['provider_title'][$key]) && $_POST['provider_title'][$key]!="")
            {
                $is_change="1";
                re_db_query("insert into cs_follow_bar_setting set 
                            client_id='".$_SESSION['admin_id']."', 
                            provider='".$_POST['provider'][$key]."', 
                            provider_url='".$_POST['provider_url'][$key]."', 
                            provider_title='".$_POST['provider_title'][$key]."'");
            }
            if($val!="" && (!isset($_POST['provider'][$key]) || $_POST['provider'][$key]=="") && (!isset($_POST['provider_url'][$key]) || $_POST['provider_url'][$key]=="") && (!isset($_POST['provider_title'][$key]) || $_POST['provider_title'][$key]==""))
            {
                $is_change="1";
                re_db_query("delete from cs_follow_bar_setting where client_id='".$_SESSION['admin_id']."' and provider_id='".$val."'");
            }
        }


        if($is_change=="1")
        {
            $myfile = fopen($file_path.$file_name,"w") or die("Unable to open file!");
            $txt = "alert('This is testing javascript file.');\n";
            fwrite($myfile, $txt) or die("Unable to file write!");
            $txt = "alert('This is second time testing alert testing javascript file.');\n";
            fwrite($myfile, $txt) or die("Unable to file write!");
            fclose($myfile);
            
            $_SESSION['msg']="update";
        }
        
        //$_SESSION['msg']="update";
        header("location:follow_bar_setting.php"); exit;
    }
    
}


if(!isset($_POST['save']))
{
    $site_data_qry="select * from cs_sites where id='".$_SESSION['admin_id']."'";
    $site_data_sql=re_db_query($site_data_qry);
    
    if(re_db_num_rows($site_data_sql)>0)
    {
        $site_data_rec=re_db_fetch_array($site_data_sql);
        
        $follow_btn_size=$site_data_rec['follow_btn_size'];
        
        $detail_sql=re_db_query("select * from cs_follow_bar_setting where client_id='".$_SESSION['admin_id']."'");
        if(re_db_num_rows($detail_sql)>0)
        {
            $i=0;
            while($detail_rec=re_db_fetch_array($detail_sql))
            {
                $i++;
                $provider[$i]=$detail_rec['provider'];
                $provider_url[$i]=$detail_rec['provider_url'];
                $provider_title[$i]=$detail_rec['provider_title'];
                $provider_id[$i]=$detail_rec['provider_id'];
            }
        }
    }
}

if($provider[1]=="") { $file_url=""; }

if(isset($_SESSION['msg']) && $_SESSION['msg']=="update")
{ 
    $msg="Change Saved Successfully. Copy below code to your site.";
    unset($_SESSION['msg']); 
}



include("header.php");
?>
<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
        <ol class="breadcrumb">
            <li>YOU ARE HERE</li>
            <li class="active">Follow Bar</li>
        </ol>
        <!--h1 class="page-title">Site - <span class="fw-semi-bold">Settings</span></h1-->
        <div class="row">
            <div class="col-md-7">
                <section class="widget">
                    <header>
                        <h4>Follow Bar <small>Setting</small></h4>
                        <div class="widget-controls">
                            <!--a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a-->
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <form class="login-form mt-lg" action="" method="post" enctype="multipart/form-data">
                            <table class="table">
                                <tr><td style="border: medium none;">The Follow Bar plugin makes it easy for partners to configure &amp; embed the buttons that enable users on the site to follow news &amp; updates through different communication channels such as Facebook page, Twitter &amp; others.</td></tr>
                                <?php if(count($error)>0)
                                {
                                    ?><tr><td><?php echo display_error_msg($error);?></td></tr><?php
                                } if(isset($msg) && $msg!="") {?>
                                    <tr><td><span style="color: #008000;" ><?php echo $msg; ?></span></td></tr>
                                <?php } else {?> <tr><th>Copy below code to your site.</th></tr><?php }?>
                                <tr>
                                    <td style="border: medium none;">
                                        <textarea style="background-color:#eee; border: 1px solid #d9d9d9; width: 100%;" id="header" class="grabHeaderCode" readonly="readonly" onclick="this.select();"><?php echo '<script type="text/javascript" src="'.$file_url.'"></script>';?></textarea>
                                    </td>
                                </tr>
                                <tr><th>Select buttons size</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div style="float: left;"><input type="radio" name="follow_btn_size" id="follow_btn_size_1" value="30x30"<?php if($follow_btn_size=="30x30") { echo ' checked="checked"';}?> /></div>
                                        <div style="float: left; margin-left: 10px;">
                                            <img src="<?php echo SITE_URL."img/social_icon/30x30/30x30_facebook.png";?>" alt="Facebook Icon 30 X 30" title="Facebook Icon 30 X 30" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/30x30/30x30_linkedin.png";?>" alt="LinkedIn Icon 30 X 30" title="LinkedIn Icon 30 X 30" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/30x30/30x30_twitter.png";?>" alt="Twitter Icon 30 X 30" title="Twitter Icon 30 X 30" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/30x30/30x30_google_plus.png";?>" alt="Google+ Icon 30 X 30" title="Google+ Icon 30 X 30" />&nbsp;
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="float: left;"><input type="radio" name="follow_btn_size" id="follow_btn_size_2" value="40x40"<?php if($follow_btn_size=="40x40") { echo ' checked="checked"';}?> /></div>
                                        <div style="float: left; margin-left: 10px;">
                                            <img src="<?php echo SITE_URL."img/social_icon/40x40/40x40_facebook.png";?>" alt="Facebook Icon 40 X 40" title="Facebook Icon 40 X 40" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/40x40/40x40_linkedin.png";?>" alt="LinkedIn Icon 40 X 40" title="LinkedIn Icon 40 X 40" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/40x40/40x40_twitter.png";?>" alt="Twitter Icon 40 X 40" title="Twitter Icon 40 X 40" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/40x40/40x40_google_plus.png";?>" alt="Google+ Icon 40 X 40" title="Google+ Icon 40 X 40" />&nbsp;
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="float: left;"><input type="radio" name="follow_btn_size" id="follow_btn_size_3" value="50x50"<?php if($follow_btn_size=="50x50") { echo ' checked="checked"';}?> /></div>
                                        <div style="float: left; margin-left: 10px;">
                                            <img src="<?php echo SITE_URL."img/social_icon/50x50/50x50_facebook.png";?>" alt="Facebook Icon 50 X 50" title="Facebook Icon 50 X 50" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/50x50/50x50_linkedin.png";?>" alt="LinkedIn Icon 50 X 50" title="LinkedIn Icon 50 X 50" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/50x50/50x50_twitter.png";?>" alt="Twitter Icon 50 X 50" title="Twitter Icon 50 X 50" />&nbsp;
                                            <img src="<?php echo SITE_URL."img/social_icon/50x50/50x50_google_plus.png";?>" alt="Google+ Icon 50 X 50" title="Google+ Icon 50 X 50" />&nbsp;
                                        </div>
                                    </td>
                                </tr>
                                <tr><th style="border: medium none;">Set buttons providers</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <?php $i=0;
                                        foreach($provider_id as $key => $val)
                                        {
                                            $i++;
                                            $disabled="";
                                            if($i>=4 && $provider[$key]=="") { $disabled=' disabled="disabled"'; }?>
                                            <div style="margin-bottom: 20px;">
                                                <div style="margin-bottom: 5px;" class="form-group">
                                                    <div><strong>Select Button Provider</strong></div>
                                                    <select style="border: 1px solid #d9d9d9;" name="provider[]" id="provider<?php echo $i;?>" onchange="call_enable_disable_text(this.value,'<?php echo $i;?>')">
                                                        <option value="">Select Button Type</option>
                                                        <option value="fb"<?php if($provider[$key]=="fb") { echo ' selected="selected"';}?>>Facebook</option>
                                                        <option value="li"<?php if($provider[$key]=="li") { echo ' selected="selected"';}?>>LinkedIn</option>
                                                        <option value="tw"<?php if($provider[$key]=="tw") { echo ' selected="selected"';}?>>Twitter</option>
                                                        <option value="gp"<?php if($provider[$key]=="gp") { echo ' selected="selected"';}?>>Google+</option>
                                                    </select>
                                                </div>
                                                <div style="margin-bottom: 5px;" class="form-group">
                                                    <div><strong>URL:</strong></div>
                                                    <input type="text" value="<?php echo $provider_url[$key];?>" placeholder="URL" name="provider_url[]" id="provider<?php echo $i;?>_url" class="form-control"<?php echo $disabled;?> />
                                                </div>
                                                <div style="margin-bottom: 5px;" class="form-group">
                                                    <div><strong>Title:</strong></div>
                                                    <input type="text" value="<?php echo $provider_title[$key];?>" placeholder="Title" name="provider_title[]" id="provider<?php echo $i;?>_title" class="form-control"<?php echo $disabled;?> />
                                                    <input type="hidden" value="<?php echo $provider_id[$key];?>" name="provider_id[]" id="provider<?php echo $i;?>_id" />
                                                </div>
                                            </div>
                                            <?php 
                                        }
                                        $i++;
                                        for($i; $i<=7; $i++)
                                        {   
                                            $disabled="";
                                            if($i>=4) { $disabled=' disabled="disabled"'; }?>
                                            <div style="margin-bottom: 20px;">
                                                <div style="margin-bottom: 5px;" class="form-group">
                                                    <div><strong>Select Button Provider</strong></div>
                                                    <select style="border: 1px solid #d9d9d9;" name="provider[]" id="provider<?php echo $i;?>" onchange="call_enable_disable_text(this.value,'<?php echo $i;?>')">
                                                        <option value="">Select Button Type</option>
                                                        <option value="fb">Facebook</option>
                                                        <option value="li">LinkedIn</option>
                                                        <option value="tw">Twitter</option>
                                                        <option value="gp">Google+</option>
                                                    </select>
                                                </div>
                                                <div style="margin-bottom: 5px;" class="form-group">
                                                    <div><strong>URL:</strong></div>
                                                    <input type="text" value="" placeholder="URL" name="provider_url[]" id="provider<?php echo $i;?>_url" class="form-control"<?php echo $disabled;?> />
                                                </div>
                                                <div style="margin-bottom: 5px;" class="form-group">
                                                    <div><strong>Title:</strong></div>
                                                    <input type="text" value="" placeholder="Title" name="provider_title[]" id="provider<?php echo $i;?>_title" class="form-control"<?php echo $disabled;?> />
                                                    <input type="hidden" value="" name="provider_id[]" id="provider<?php echo $i;?>_id" />
                                                </div>
                                            </div>
                                            <?php 
                                        }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="clearfix">
                                            <div class="btn-toolbar pull-right">
                                                <input type="submit" name="save" class="btn btn-inverse btn-sm" value="Save" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <script type="text/javascript">
    function call_enable_disable_text(val,id)
    {
        if(val=="")
        {
            document.getElementById('provider'+id+'_url').disabled=true;
            document.getElementById('provider'+id+'_title').disabled=true;
        }
        else 
        {
            document.getElementById('provider'+id+'_url').disabled=false;
            document.getElementById('provider'+id+'_title').disabled=false;
        }
    }
                        </script>
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
</body>
</html>