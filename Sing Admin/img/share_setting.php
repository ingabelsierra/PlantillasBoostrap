<?php 
include("include/config.php");
if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }

    $file_name="client_".$_SESSION['admin_id']."_share.js";
    $file_path=DIR_FS_CLIENT_SHARE_JS;
    $file_url=SITE_WS_CLIENT_SHARE_JS.$file_name;
    

$error=array();
$counter_type="0";
$button_style="0";
$share_button=array();
$short_order=array();

$site_sql="select * from cs_sites where id='".$_SESSION['admin_id']."'";
$res_site=re_db_query($site_sql);
$row_site=re_db_fetch_array($res_site);

switch($_SESSION['admin_id'])
{
    case '5':
    $valid_domain='coupay.com';
    break;
    case '4':
    $valid_domain='soclever.net';
    break;
     case '1':
    $valid_domain='coupay.co.in';
    break;
    
}

if(isset($_POST['save']) && $_POST['save']=="Save")
{
    $share_button=isset($_POST['share_button']) ? $_POST['share_button'] : array();
    $short_order=$_POST['short_order'];
    $counter_type=isset($_POST['counter_type']) ? $_POST['counter_type'] : '';
    $button_style=isset($_POST['button_style']) ? $_POST['button_style'] : '';

    if(count($share_button)<=0) { $error[]="Please select at least any one button."; }
    else
    {
        $social_ids=""; $social_odr="";
        foreach($share_button as $key => $val)
        {
            if($social_ids=="")
            {
                $social_ids = $val;
                $social_odr=$short_order[$key];
            }
            else
            { 
                $social_ids.=",".$val;
                $social_odr.=",".$short_order[$key];
            }
        }
        
        $chk_cs_sql=re_db_query("select * from `cs_share_bar_setting` where client_id='".$_SESSION['admin_id']."'");
        if(re_db_num_rows($chk_cs_sql)<=0)
        {
            $insert="insert into cs_share_bar_setting set 
                    client_id='".$_SESSION['admin_id']."', 
                    social_id='".$social_ids."', 
                    social_odr='".$social_odr."', 
                    counter_type='".$counter_type."', 
                    btn_style='".$button_style."'";
            re_db_query($insert);
        }
        else
        {
            $update="update cs_share_bar_setting set 
                    social_id='".$social_ids."', 
                    social_odr='".$social_odr."', 
                    counter_type='".$counter_type."', 
                    btn_style='".$button_style."' where client_id='".$_SESSION['admin_id']."'";
            re_db_query($update);
        }
        
        
        $myfile = fopen($file_path.$file_name,"w") or die("Unable to open file!");
        $fileContent="";
        
        $fileContent .='var cslikebarjs = cslikebarjs || (function(){
                        var _args = {}; // private

                    return {
                        init : function(Args) {
                            _args = Args;
                            // some other initialising
                        },
                    validateCsApi : function() {
                            if(_args[0]==\''.$row_site['api_key'].'\' && _args[1]==\''.$_SESSION['admin_id'].'\' && _args[2]==\''.$row_site['api_secret'].'\' &&  _args[3]==\''.$valid_domain.'\' )
                            {'.PHP_EOL;
                            $fileContent .='var client_id="'.$_SESSION['admin_id'].'";
                             var sitepath="'.SITE_URL.'";
                            ';
            
        if(in_array('2',$share_button))
        {
            $fb_app_id=$row_site['fb_app_id'];
           $fileContent .='var app_id=\''.$row_site['fb_app_id'].'\';
                        document.write(\'<div id="fb-root"></div>\');
                         window.fbAsyncInit = function() {
                         FB.init({appId:'.$fb_app_id.', status: true, cookie: true, xfbml: true});
                         FB.Event.subscribe(\'edge.create\', function(href, widget) {
                         
        var url_share=removeURLParameter(document.URL,\'csid\');
        var myurl_share=removeURLParameter(url_share,\'site_id\');
        var myurl_share2=removeURLParameter(myurl_share,\'is_fb\');
        var myurl2_share=removeURLParameter(myurl_share2,\'is_li\');
        var myurl3_share=removeURLParameter(myurl_share2,\'is_tw\');
        if(myurl3_share.slice(-1)==\'?\')
        {
            var final_url=myurl2_share.slice(-1);
        }
        else
        {
            var final_url=myurl3_share;
        }
        
           track_like_unlike(final_url,\'1\'); 
 
        });
 
     FB.Event.subscribe(\'edge.remove\', function(href, widget) {
     
     var url_share=removeURLParameter(document.URL,\'csid\');
            var myurl_share=removeURLParameter(url_share,\'site_id\');
            var myurl_share2=removeURLParameter(myurl_share,\'is_fb\');
            var myurl2_share=removeURLParameter(myurl_share2,\'is_li\');
            var myurl3_share=removeURLParameter(myurl_share2,\'is_tw\');
            if(myurl3_share.slice(-1)==\'?\')
            {
                var final_url=myurl2_share.slice(-1);
            }
            else
            {
                var final_url=myurl3_share;
            }
            
               track_like_unlike(final_url,\'0\');
               
     });
    
    };

    (function() {
     var e = document.createElement(\'script\');
     e.type = \'text/javascript\';
     e.src = document.location.protocol + \'//connect.facebook.net/en_US/all.js\';
     e.async = true;
     document.getElementById(\'fb-root\').appendChild(e);
     }());
    '.PHP_EOL;
        }
        if(in_array('4',$share_button))
        {
            
         $fileContent .='document.writeln(\'<script src="https://apis.google.com/js/platform.js" async defer></script>\');'.PHP_EOL;  
        }
        
        if(in_array('13',$share_button))
        {
            
         $fileContent .='document.writeln(\'<script src="https://platform.twitter.com/widgets.js" async ></script>\');'.PHP_EOL;
         $fileContent .='setTimeout(function() {

                        twttr.ready(function (twttr) { twttr.events.bind(\'tweet\', function (event) 
                         {
                             var url_share=removeURLParameter(document.URL,\'csid\');
                             var myurl_share=removeURLParameter(url_share,\'site_id\');
                             var myurl_share2=removeURLParameter(myurl_share,\'is_fb\');
                             var myurl2_share=removeURLParameter(myurl_share2,\'is_li\');
                             var myurl3_share=removeURLParameter(myurl_share2,\'is_tw\');
                            if(myurl3_share.slice(-1)==\'?\')
                            {
                                var final_url=myurl2_share.slice(-1);
                            }
                            else
                            {
                                var final_url=myurl3_share;
                            }
                            
                               track_like_unlike(final_url,\'2\'); 
                     
                                                        
                                                        });
                                   }); },1000);
                    '; 
        
        }
        if(in_array('7',$share_button))
        {
            
         $fileContent .='document.writeln(\'<script src="http://platform.linkedin.com/in.js" async ></script>\');'.PHP_EOL;
         
         $fileContent .='function cslisharesuccess()
                        {
        var   url_share=removeURLParameter(document.URL,\'csid\');
        var myurl_share=removeURLParameter(url_share,\'site_id\');
        var myurl_share2=removeURLParameter(myurl_share,\'is_fb\');
        var myurl2_share=removeURLParameter(myurl_share2,\'is_li\');
        var myurl3_share=removeURLParameter(myurl_share2,\'is_tw\');
        if(myurl3_share.slice(-1)==\'?\')
        {
            var final_url=myurl2_share.slice(-1);
        }
        else
        {
            var final_url=myurl3_share;
        }
        
           track_like_unlike(final_url,\'3\'); 
    
        }'.PHP_EOL; 
        $fileContent .='function cslishareerror()
                        {
                            alert(\'li share error\');
                        }
                        '.PHP_EOL;      
        }
        $fileContent .='function addParameterToURLnew(new_url,param){
                        _url = new_url;
                        _url += (_url.split(\'?\')[1] ? \'&\':\'?\') + param;
                        return _url;
                    }


                function addParameterToURL(param){
                _url = document.URL;
                _url += (_url.split(\'?\')[1] ? \'&\':\'?\') + param;
                return _url;
            }
            function GetXmlHttpObject(handler)

		{ 
          
		var objXmlHttp=null

		

		if (navigator.userAgent.indexOf("Opera")>=0)

		{

		alert("This example doesn\'t work in Opera") 

		return 

		}

		if (navigator.userAgent.indexOf("MSIE")>=0)

		{ 

		var strName="Msxml2.XMLHTTP"

		if (navigator.appVersion.indexOf("MSIE 5.5")>=0)

		{

		strName="Microsoft.XMLHTTP"

		} 

		try

		{ 

		objXmlHttp=new ActiveXObject(strName)

		objXmlHttp.onreadystatechange=handler 

		return objXmlHttp

		} 	

		catch(e)

		{ 

		alert("Error. Scripting for ActiveX might be disabled") 

		return 

		} 

		} 

		if (navigator.userAgent.indexOf("Mozilla")>=0)

		{

		objXmlHttp=new XMLHttpRequest()

		objXmlHttp.onload=handler

		objXmlHttp.onerror=handler 

		return objXmlHttp

		}

		}

		

		var url = sitepath+"track_status.php?"; // The server-side scripts	



        function removeURLParameter(url, parameter) {
            //prefer to use l.search if you have a location/link object
            var urlparts= url.split(\'?\');   
            if (urlparts.length>=2) {
        
                var prefix= encodeURIComponent(parameter)+\'=\';
                var pars= urlparts[1].split(/[&;]/g);
        
                //reverse iteration as may be destructive
                for (var i= pars.length; i-- > 0;) {    
                    //idiom for string.startsWith
                    if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                        pars.splice(i, 1);
                    }
                }
        
                url= urlparts[0]+\'?\'+pars.join(\'&\');
                return url;
            } else {
                return url;
            }
        }

        function track_like_unlike(like_url,like_unlike)
        {
            
            xmlHttp_149=GetXmlHttpObject(handleHttpResponse_like_unlike);
        
        	xmlHttp_149.open("GET",url + "like_url="+encodeURIComponent(like_url)+\'&site_id=\'+client_id+\'&is_like=\'+like_unlike);				
        
        	xmlHttp_149.send(null);
        }
        
        function handleHttpResponse_like_unlike()
        {
            if (xmlHttp_149.readyState == 4) {
                alert(xmlHttp_149.responseText);
               
            }    
        }
        function csGpshare(plusone)
                            {

                                if(plusone.type==\'confirm\')
                                	{
                                	   track_like_unlike(document.URL,\'4\');
                                       
                                	}

                            }        
        ';
        $fileContent .='document.write(\'<div id="csshareicons" style="width:auto;float:left;" >\');'.PHP_EOL;
        
        if($_POST['counter_type']=='2')
            {
                $button_styles=' data-size="medium" data-annotation="none"';
                $fb_count_show='button';
                $twit_count="none";
                $li_count='';
                $li_left="10px";
            }
            else
            {
                if($_POST['counter_type']=='0')
                {
                   $button_styles='data-size="medium" data-annotation="bubble"';
                   $fb_count_show='button_count';
                   $twit_count="horizontal";
                   $li_count='data-counter="right"';
                   $li_left="-20px"; 
                }
                else
                {
                    $button_styles='data-size="tall" data-annotation="bubble"';
                    $fb_count_show='box_count';
                    $twit_count="vertical";
                    $li_count='data-counter="top"';
                    $li_left="10px";
                }
            }
         $share_arr[2]='document.write(\'<div style="float:left;margin-left:10px;" id="cslike" class="fb-like" data-href="\'+document.URL+\'" data-send="false" data-layout="'.$fb_count_show.'" data-width="50" data-show-faces="false"></div>\');'.PHP_EOL;
         $share_arr[4]='document.write(\'<div id="gp" style="float:left;margin-left:10px;"><div class="g-plusone" data-onendinteraction="csGpshare" '.$button_styles.' ></div></div>\');'.PHP_EOL;
         $share_arr[7]='document.write(\'<div id="li" style="float:left;margin-left:'.$li_left.';"><script type="IN/Share" '.$li_count.'   data-onSuccess="cslisharesuccess"   data-onError="cslishareerror"  ></script></div>\');'.PHP_EOL;
         $share_arr[13]='document.write(\'<div id="tw" style="float:left;margin-left:10px;"><a href="\'+document.URL+\'" class="twitter-share-button" data-count="'.$twit_count.'"  data-lang="en">Tweet</a></div>\');'.PHP_EOL;
        foreach($share_button as $key=>$val)
        {
            
               $fileContent .=$share_arr[$val];
        }    
        $fileContent .='document.write(\'</div>\');'.PHP_EOL;
        $fileContent .=' }
            else
            {
                alert("Authentication fail.");
                return;
            }
        }
    };
}());';
        fwrite($myfile, $fileContent) or die("Unable to file write!");
        /*$txt = "alert('This is testing javascript file.');\n";
        fwrite($myfile, $txt) or die("Unable to file write!");
        $txt = "alert('This is second time testing alert testing javascript file.');\n";
        fwrite($myfile, $txt) or die("Unable to file write!");
        fclose($myfile);
        */
        
        $_SESSION['msg']="insert";
        header("location:share_setting.php"); exit;
    }
}


if(!isset($_POST['save']))
{
    $chk_cs_sql=re_db_query("select * from `cs_share_bar_setting` where client_id='".$_SESSION['admin_id']."'");
    if(re_db_num_rows($chk_cs_sql)>0)
    {
        $chk_cs_rec=re_db_fetch_array($chk_cs_sql);
        
        $social_id=$chk_cs_rec['social_id'];
        $social_odr=$chk_cs_rec['social_odr'];
        $counter_type=$chk_cs_rec['counter_type'];
        $button_style=$chk_cs_rec['btn_style'];
        
        $share_button=explode(",",$social_id);
        $short_order=explode(",",$social_odr);
    }
}


if(isset($_SESSION['msg']) && $_SESSION['msg']=="insert")
{ 
    $msg="Change Saved Successfully.";
    unset($_SESSION['msg']); 
}

    $chk_cs_sql=re_db_query("select * from `cs_share_bar_setting` where client_id='".$_SESSION['admin_id']."'");
    if(re_db_num_rows($chk_cs_sql)<=0) {
        $file_url="";
    }


include("header.php");
?>
<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
        <ol class="breadcrumb">
            <li>YOU ARE HERE</li>
            <li class="active">Like Bar Settings</li>
        </ol>
        <!--h1 class="page-title">Site - <span class="fw-semi-bold">Settings</span></h1-->
        <div class="row">
            <div class="col-md-6 col-lg-5">
                <section class="widget">
                    <header>
                        <h4>Like Bar <small>Setting</small></h4>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <form class="login-form mt-lg" action="" method="post" enctype="multipart/form-data">
                            <table class="table">
                                <tr><td style="border: medium none; font-size: 13px;">The Like Bar makes it easy for users to syndicate content to social networks. The like bar setup allows partners to customize the share button type and style, making it easier to integrate sharing through a button on their site pages that enables users to publish reviews, comments and any other activity to their friends.</td></tr>
                                <?php if(count($error)>0) { ?>
                                    <tr><td><?php echo display_error_msg($error);?></td></tr>
                                <?php } if(isset($msg) && $msg!="")
                                {?>
                                    <tr><td><span style="color: #008000;" ><?php echo $msg; ?></span></td></tr>
                                <?php } ?>
                                <tr><th>Select buttons &amp; Sort Order</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div style="text-align: right; border-bottom: 1px solid; margin-bottom: 5px;width: 180px;">
                                            <a href="javascript:void(0);" onclick="call_check_uncheck_all('all')">All</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="call_check_uncheck_all('none')">None</a>
                                        </div>
                                        <div id="social_list_div" style="width: 180px;">
                                            <?php $i=0;
                                            if(count($share_button)>0)
                                            {
                                                foreach($share_button as $key => $val)
                                                {
                                                    $i++;
                                                    if(is_array($short_order) && isset($short_order[$key])) { $odr=$short_order[$key]; } else { $odr=$i;}
                                                    $social_sql=re_db_query("select * from cs_social_network_master where social_id='".$val."'");
                                                    $social_rec=re_db_fetch_array($social_sql);
                                                    ?>
                                                    <div style="margin-bottom: 5px;">
                                                        <input type="checkbox" name="share_button[<?php echo $i;?>]" id="share_button_<?php echo $i;?>" value="<?php echo $val;?>" checked="checked" onclick="call_manage_display()" />&nbsp;&nbsp;<?php echo $social_rec['social_name'];?>
                                                        <span style="float: right;">
                                                            <a href="javascript:void(0);" onclick="call_ordering('<?php echo $odr;?>','up')">up</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="call_ordering('<?php echo $odr;?>','down')">down</a>
                                                        </span>
                                                        <input type="hidden" name="short_order[<?php echo $odr;?>]" id="short_order_<?php echo $odr;?>" value="<?php echo $odr;?>" /> 
                                                    </div>
                                                    <?php 
                                                }
                                            }
                                            $social_sql=re_db_query("select * from cs_social_network_master where social_id not in ('".implode("','",$share_button)."') and is_display='1'");
                                            if(re_db_num_rows($social_sql)>0)
                                            {
                                                while($social_rec=re_db_fetch_array($social_sql))
                                                {
                                                    $i++; $checked=''; 
                                                    ?>
                                                    <div style="margin-bottom: 5px;">
                                                        <input type="checkbox" name="share_button[<?php echo $i;?>]" id="share_button_<?php echo $i;?>" value="<?php echo $social_rec['social_id'];?>"<?php echo $checked;?> onclick="call_manage_display()" />&nbsp;&nbsp;<?php echo $social_rec['social_name'];?>
                                                        <span style="float: right;">
                                                            <a href="javascript:void(0);" onclick="call_ordering('<?php echo $i;?>','up')">up</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="call_ordering('<?php echo $i;?>','down')">down</a>
                                                        </span>
                                                        <input type="hidden" name="short_order[<?php echo $i;?>]" id="short_order_<?php echo $i;?>" value="<?php echo $i;?>" /> 
                                                    </div>
                                                    <?php 
                                                }
                                            } ?>
                                            <input type="hidden" name="odr_id" id="odr_id" value="" />
                                            <input type="hidden" name="odr_type" id="odr_type" value="" />
                                            <input type="hidden" name="total_social" id="total_social" value="<?php echo $i;?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr><th>Counter Display</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div><input type="radio" name="counter_type" id="counter_type_1" value="0"<?php if($counter_type=="0") { echo ' checked="checked"'; };?> onclick="change_counter_style()" />&nbsp;&nbsp;Horizontal</div>
                                        <div><input type="radio" name="counter_type" id="counter_type_2" value="1"<?php if($counter_type=="1") { echo ' checked="checked"'; };?> onclick="change_counter_style()" />&nbsp;&nbsp;Vertical</div>
                                        <div><input type="radio" name="counter_type" id="counter_type_3" value="2"<?php if($counter_type=="2") { echo ' checked="checked"'; };?> onclick="change_counter_style()" />&nbsp;&nbsp;No Counter</div>
                                    </td>
                                </tr>
                                <tr><th>Select Your Style</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div><input type="radio" name="button_style" id="button_style_1" value="0"<?php if($button_style=="0") { echo ' checked="checked"'; };?> onclick="call_manage_display()" />&nbsp;&nbsp;<img src="<?php echo SITE_URL;?>img/social_icon/Share_ButtonStyle.gif" alt="Social Share Button Style" /></div>
                                        <div><input type="radio" name="button_style" id="button_style_2" value="1"<?php if($button_style=="1") { echo ' checked="checked"'; };?> onclick="call_manage_display()" />&nbsp;&nbsp;<img src="<?php echo SITE_URL;?>img/social_icon/Share_IconStyle.gif" alt="Social Share Icon Style" /></div>
                                        <div><input type="radio" name="button_style" id="button_style_3" value="2"<?php if($button_style=="2") { echo ' checked="checked"'; };?> onclick="call_manage_display()" />&nbsp;&nbsp;<img src="<?php echo SITE_URL;?>img/social_icon/Share_ButtonIconStyle.gif" alt="Social Share Button & Icon Style" /></div>
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
                    </div>
                </section>
            </div>
            <div class="col-md-6 col-lg-5">
                <section class="widget">
                    <header>
                        <h4>Like Bar <small>Preview</small></h4>
                        <div class="widget-controls">
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <table class="table">
                            <tr><th style="border: medium none;">Button Preview</th></tr>
                            <tr>
                                <td>
                                    <div id="social_icon_div" style="text-align: center; display: block;">
                                        <img id="fb" style="float: left; margin-right: 5px; display: block;" src="<?php echo SITE_URL."img/social_icon/fb_like_btn_0.jpg";?>" alt="Facebook Like Button" title="Facebook Like Button" />
                                        <img id="li" style="float: left; margin-right: 5px; display: block;" src="<?php echo SITE_URL."img/social_icon/li_share_btn_0.jpg";?>" alt="LinkedIn Share Button" title="LinkedIn Share Button" />
                                        <img id="tw" style="float: left; margin-right: 5px; display: block;" src="<?php echo SITE_URL."img/social_icon/tw_tweet_btn_0.jpg";?>" alt="Twitter Tweet Button" title="Twitter Tweet Button" />
                                        <img id="gp" style="float: left; margin-right: 5px; display: block;" src="<?php echo SITE_URL."img/social_icon/gp_share_btn_0.jpg";?>" alt="Google+ Share Button" title="Google+ Share Button" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </section>
                <section class="widget">
                    <header>
                        <h4>Grab <small>Code</small></h4>
                        <div class="widget-controls">
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <table class="table">
                            <tr><th>Copy below code to your site.</th></tr>
                            <tr>
                                <td style="border: medium none;">
                                    <textarea style="background-color:#eee; border: 1px solid #d9d9d9; width: 100%;" id="header" class="grabHeaderCode" readonly="readonly" onclick="this.select();"><?php echo '<script type="text/javascript" src="'.$file_url.'"></script>'.PHP_EOL.
                                                                '<script>
    cslikebarjs.init([\''.$row_site['api_key'].'\', \''.$_SESSION['admin_id'].'\',\''.$row_site['api_secret'].'\',\''.$valid_domain.'\']);
    cslikebarjs.validateCsApi();
    </script>';?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                </section>
            </div>
<script type="text/javascript">

    function call_check_uncheck_all(chk)
    {
        if(chk!="N/A")
        {
            for(i=1;i<=4;i++)
            {
                if(chk=="all") {
                    document.getElementById('share_button_'+i).checked=true;
                }
                else if(chk=="none") {
                    document.getElementById('share_button_'+i).checked=false;
                }
            }
        }
        call_manage_display();
    }
    
    function change_counter_style()
    {
        for(var i=1; i<=3; i++)
        {
            if(document.getElementById('counter_type_'+i).checked) {
                var val = document.getElementById('counter_type_'+i).value;
            }
            if(document.getElementById('button_style_'+i).checked) {
                var btn_style = document.getElementById('button_style_'+i).value; 
            }
        }

        if(val=="1")
        {
            document.getElementById('button_style_1').checked=true;
            document.getElementById('button_style_2').disabled=true;
            document.getElementById('button_style_3').disabled=true;
        }
        else 
        {
            document.getElementById('button_style_2').disabled=false;
            document.getElementById('button_style_3').disabled=false;
        }
        
        call_manage_display();
    }
    
    function call_ordering(id,odr)
    {
        document.getElementById('odr_id').value=id;
        document.getElementById('odr_type').value=odr;
        
        call_manage_display();
    }
    
    function call_manage_display()
    {
        for(var i=1; i<=3; i++) {
            if(document.getElementById('counter_type_'+i).checked) {
                var counter_type = document.getElementById('counter_type_'+i).value; 
            }
            if(document.getElementById('button_style_'+i).checked) {
                var btn_style = document.getElementById('button_style_'+i).value; 
            }
        }
        
        var all_sel_social=""; all_sel_social_odr="";
        var tot=document.getElementById('total_social').value;
        for(var i=1; i<=tot; i++)
        {
            if(document.getElementById('share_button_'+i).checked)
            {
                all_sel_social=all_sel_social+","+document.getElementById('share_button_'+i).value;
                all_sel_social_odr=all_sel_social_odr+","+document.getElementById('short_order_'+i).value;
            }
        }
        
        var odr_id=document.getElementById('odr_id').value;
        var odr_type=document.getElementById('odr_type').value;
        
        var url="all_sel_social="+all_sel_social+"&all_sel_social_odr="+all_sel_social_odr+"&counter_type="+counter_type+"&btn_style="+btn_style+"&odr_id="+odr_id+"&odr_type="+odr_type;
    
        var xmlhttp;
        if (window.XMLHttpRequest) {
            xmlhttp=new XMLHttpRequest(); // code for IE7+, Firefox, Chrome, Opera, Safari
        } else {
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); // code for IE6, IE5
        }
        
        xmlhttp.onreadystatechange=function()
        {
            if(xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var res = xmlhttp.responseText;
                var res_arr = res.split('~!##!~');
                document.getElementById("social_icon_div").innerHTML=res_arr[0];
                document.getElementById("social_list_div").innerHTML=res_arr[1];
            }
        }
        
        xmlhttp.open("GET","ajax_share_bar_setting.php?"+url,true);
        xmlhttp.send();

    }
    
    change_counter_style();
</script>
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
<!--script src="js/share_setting.js"></script-->
</body>
</html>