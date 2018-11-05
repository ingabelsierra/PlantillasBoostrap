<?php 
include("include/config.php");
ini_set("display_errors","1");
error_reporting(E_ALL);
if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }

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


    $file_name="client_".$_SESSION['admin_id']."_login.js";
    $file_path=DIR_FS_CLIENT_SHARE_JS;
    $file_url=SITE_WS_CLIENT_SHARE_JS.$file_name;


$error=array();
$total_rec="";
$placement="page";
$btn_style="fc";
$button_size="30";
$plugin_size="standard";
$custom_w="320";
$custom_h="100";
$network=array('2','4','7','13');


if(isset($_POST['save']) && $_POST['save']=="Save")
{
    $placement=isset($_POST['placement']) ? $_POST['placement'] : 'page';
    $btn_style=isset($_POST['btn_style']) ? $_POST['btn_style'] : "ic";
    $button_size=isset($_POST['button_size']) ? $_POST['button_size'] : "30";
    $plugin_size=isset($_POST['plugin_size']) ? $_POST['plugin_size'] : "standard";
    $custom_w=$_POST['custom_w'];
    $custom_h=$_POST['custom_h'];
    $network=isset($_POST['network']) ? $_POST['network'] : array();
    
    
    if(count($network)<=0) { $error[]="Please select social networks."; }
    
    
    if(count($error)<=0)
    {
        $all_network=implode(",",$network);

        $site_data_sql=re_db_query("select * from cs_client_social_network where client_id='".$_SESSION['admin_id']."'");
        if(re_db_num_rows($site_data_sql)<=0)
        {
            $insert="insert into cs_client_social_network set 
                    client_id='".$_SESSION['admin_id']."', 
                    placement='".$placement."', 
                    btn_style='".$btn_style."', 
                    button_size='".$button_size."', 
                    plugin_size='".$plugin_size."', 
                    custom_w='".$custom_w."', 
                    custom_h='".$custom_h."', 
                    network='".$all_network."'";
            re_db_query($insert);
        }
        else
        {
            $update="update cs_client_social_network set 
                    placement='".$placement."', 
                    btn_style='".$btn_style."', 
                    button_size='".$button_size."', 
                    plugin_size='".$plugin_size."', 
                    custom_w='".$custom_w."', 
                    custom_h='".$custom_h."', 
                    network='".$all_network."' where client_id='".$_SESSION['admin_id']."'";
            re_db_query($update);
        }
        
        $fileContent='';
        
        $fileContent='var csloginjs = csloginjs || (function(){
    var _args = {}; // private

    return {
        init : function(Args) {
            _args = Args;
            // some other initialising
        },
        validateCsApi : function() {
        if(_args[0]==\''.$row_site['api_key'].'\' && _args[1]==\''.$_SESSION['admin_id'].'\' && _args[2]==\''.$row_site['api_secret'].'\' &&  _args[3]==\''.$valid_domain.'\' )
         {'.PHP_EOL;
         $fileContent .='}
            else
            {
                alert("Authentication fail.");
                return;
            }
        }
    };
}());
';
                             
            $fileContent .='var client_id="'.$_SESSION['admin_id'].'";
                             var sitepath="'.SITE_URL.'";
                             var clientSite="'.$row_site['site_url'].'";
                            ';    
             if(in_array('2',$network))
             {
                $fb_app_id=$row_site['fb_app_id'];
                $fileContent .='var app_id=\''.$fb_app_id.'\';

            window.fbAsyncInit = function () {
                FB.init({
                appId: app_id,
                status: true, 
                cookie: true, 
                xfbml: true  
                });
            
                
            };
            
            
            (function (d) {
                var js, id = \'facebook-jssdk\', ref = d.getElementsByTagName(\'script\')[0];
                if (d.getElementById(id)) { return; }
                js = d.createElement(\'script\'); js.id = id; js.async = true;
                js.src = "https://connect.facebook.net/en_US/all.js";
                ref.parentNode.insertBefore(js, ref);
            }(document));
            '.PHP_EOL;
                
             }   
             
             if(in_array('7',$network))
             {
                
                $fileContent .='document.writeln("<script type=\'text/javascript\' src=\'http://platform.linkedin.com/in.js\'>");
                                document.writeln("api_key:'.$row_site['linkedin_app_id'].'");
                                document.writeln("authorize: true");   
                                document.writeln("scope: r_basicprofile r_emailaddress r_emailaddress r_fullprofile");                
                                document.writeln("</script>");                   
                                '.PHP_EOL;
               $fileContent .='
                            function onLinkedInLoad() {
                                    IN.UI.Authorize().place();
                                    IN.Event.on(IN, "auth", function () { onLogin(); });
                                    IN.Event.on(IN, "logout", function () { onLogout(); });
                                }
                            
                                function onLogin() {
                                    IN.API.Profile("me")
                                    .fields("firstName", "lastName", "industry", "location:(name)", "picture-url", "headline", "summary", "num-connections", "public-profile-url", "distance", "positions", "email-address", "educations", "date-of-birth")   
                                    .result(displayResult);
                                        
                                }  
                                function displayResult(profiles) {
                                    member = profiles.values[0];
                                    
                                    var myarray ={};
                                myarray[\'emailAddress\']=member.emailAddress;
                                myarray[\'id\']=member.id;
                                myarray[\'firstName\']=member.firstName;
                                myarray[\'lastName\']=member.lastName;
                                myarray[\'pictureUrl\']=member.pictureUrl;
                                myarray[\'headline\']=member.headline;
                                if(member.dateOfBirth.day)    
                                myarray[\'bday\']=member.dateOfBirth.day;
                                else
                                myarray[\'bday\']=\'0\';
                                
                                if(member.dateOfBirth.month)
                                myarray[\'bmonth\']=member.dateOfBirth.month;
                                else
                                myarray[\'bmonth\']=\'0\';
                                
                                if(member.dateOfBirth.year)
                                myarray[\'byear\']=member.dateOfBirth.year;
                                else
                                myarray[\'byear\']=\'0000\';
                                
                                
                                myarray[\'industry\']=member.industry;
                                myarray[\'location\']=member.location.name;
                                myarray[\'numConnections\']=member.numConnections;
                                myarray[\'publicProfileUrl\']=member.publicProfileUrl;
                                track_info_li(JSON.stringify(myarray),\'1\');
                            
                                                            }  
                            
                            '.PHP_EOL;   
                                          
             }
             
             if(in_array('4',$network))
             {
                
                $fileContent .='(function() {
                               var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
                               po.src = \'https://apis.google.com/js/client:plusone.js\';
                               var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
                             })();
                             
    

                    function signinCallback(authResult) {
                        
                        var initializedGoogleCallback = false
                      if (authResult[\'status\'][\'signed_in\']) {
                         if(!initializedGoogleCallback)
                         {
                            var initializedGoogleCallback=true;
                         gapi.client.load(\'plus\', \'v1\', apiClientLoaded);
                         }
                      } else {
                         //console.log(authResult[\'error\']);
                        alert("Login/Registration with Google+ failed");
                      }
                    }
                    
                    function apiClientLoaded() {
                        
                        gapi.client.plus.people.get({userId: \'me\'}).execute(handleEmailResponse);
                      }
                    
                    function handleEmailResponse(resp) {
                        
                        var gobj=JSON.parse(JSON.stringify(resp));
                        
                        track_user_gp(gobj);
                    }
                    ';
             }  
             if(in_array('2',$network))
             {
             $fileContent .='if(typeof csfblogin !== \'function\' )
               {

                function csfblogin(type) {
    
               FB.getLoginStatus(function(response) {
        
        
            });
    
    FB.login(function (response) {
    if (response.authResponse) {
      
        FB.api(\'/me?fields=picture,interests,link,relationship_status,id,first_name,last_name,name,birthday,gender,location,email,hometown,locale,timezone,likes{name,likes}\', function (info) {
                        //console.log(info);
                        if(type==\'1\')
                        {
                        track_url_new(info);
                        }
                        else
                        {
                          track_user(info);
                            
                        }            
                        });
        
    } else {

		window.location=document.URL;
        
    }
    },{scope: \'email,publish_stream,user_relationships,user_birthday,user_hometown,user_interests,user_location,user_likes,user_friends\'});
}
}';
}
 if(in_array('7',$network))
 {
    $fileContent .=PHP_EOL;
    $fileContent .='function track_info_li(info,to_share) {
                

				xmlHttp=GetXmlHttpObject(handleHttpResponse_li);
                xmlHttp.open("GET",url+\'is_li=1&is_from=2&to_share=\'+to_share+\'&siteid=\'+client_id+\'&other=\'+encodeURIComponent(info));				
                xmlHttp.send(null);

		          }
                function handleHttpResponse_li()
                {
                     if (xmlHttp.readyState == 4) {
                        var liobj=JSON.parse(xmlHttp.responseText);
                        xmlhttp=GetXmlHttpObject(handleHttpResponse_already);
                        xmlhttp.open("POST",clientSite+"csfiles/csposts_new.php",true);
                        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                        xmlhttp.send("member_id="+liobj.member_id+"&email="+liobj.email+"&first_name="+liobj.first_name+"&last_name="+liobj.last_name+"&action=already"+"&is_from=2");
            
                    }
                    }';
    
 }
$fileContent .='
        if(typeof addParameterToURLnew !== \'function\')
        {
            
            function addParameterToURLnew(new_url,param){
            _url = new_url;
            _url += (_url.split(\'?\')[1] ? \'&\':\'?\') + param;
            return _url;
        }
        
        }

if(typeof removeURLParameter !== \'function\' )
{

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
}
if(typeof GetXmlHttpObject !== \'function\' )
{


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

		
}'.PHP_EOL;

$fileContent .='var url = sitepath+"track_register_new.php?"; // The server-side scripts	
        var csShareurl = sitepath+"track_status_new.php?"; // The server-side scripts
                
        function track_user(info) {					

				xmlHttp=GetXmlHttpObject(handleHttpResponse_user);
                
                
                var uname=encodeURIComponent(info.first_name+\' \'+info.last_name);
                
                var uid=info.id;
                
				xmlHttp.open("GET",url+\'app_id=\'+app_id+\'&is_fb=1&siteid=\'+client_id+\'&other=\'+encodeURIComponent(JSON.stringify(info)));				

				xmlHttp.send(null);

		}



		function handleHttpResponse_user() {
		  
          if (xmlHttp.readyState == 4) {
            var gobj=JSON.parse(xmlHttp.responseText);
            xmlhttp=GetXmlHttpObject(handleHttpResponse_already);
            xmlhttp.open("POST",clientSite+"csfiles/csposts_new.php",true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("member_id="+gobj.member_id+"&email="+gobj.email+"&first_name="+gobj.first_name+"&last_name="+gobj.last_name+"&action=already&is_from=1");
            
            }
    }

function handleHttpResponse_already()
{
     if (xmlhttp.readyState == 4) {
        var res_arr=xmlhttp.responseText.split("~");
        if(res_arr[0] > 0)
        {
            
            xmlhttp=GetXmlHttpObject(handleHttpResponse_askpassword);
            xmlhttp.open("POST",clientSite+"csfiles/csposts_new.php",true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("uname="+res_arr[1]+"&member_id="+res_arr[2]+"&action=allogin&is_from="+res_arr[3]);
            
        }
        else
        {
           xmlhttp=GetXmlHttpObject(handleHttpResponse_register);
            xmlhttp.open("POST",clientSite+"csfiles/csposts_new.php",true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("email="+res_arr[1]+"&first_name="+res_arr[2]+"&last_name="+res_arr[3]+"&member_id="+res_arr[4]+"&action=csRegistration&is_from="+res_arr[5]);
            
        }
        }
}
var popup;
var popup_register;
function handleHttpResponse_askpassword()
{
    
    if (xmlhttp.readyState == 4) {
        var res_arr=xmlhttp.responseText.split("~");
        if(res_arr[0]==\'incative_account\')
        {
            popup = window.open("","Login With Social Network","width=400, height=300");
            popup.document.write(\'<html><body>Sorry, your account is deactivated.</body></html>\');
            
        }
        else
        {
          notify_cs(res_arr[1],\'0\',res_arr[3],res_arr[2]);  
         
        }
     
  }
} '.PHP_EOL;
	
$fileContent .='function handleHttpResponse_register()
{
    
    if (xmlhttp.readyState == 4) {
        var res_arr=xmlhttp.responseText.split("~");
     if(res_arr[0]==\'registration_success\')
     {
       notify_cs(res_arr[1],\'1\',res_arr[3],res_arr[2]); 
        
     }
     else
     {
        alert("Registation with FB failed.");
     }
  }
} 


function notify_cs(siteUid,is_new,is_from,member_id)
{
  	            xmlHttp=GetXmlHttpObject(handleHttpResponse_notify);
                
				xmlHttp.open("GET",url+\'action=notifycs&is_from=\'+is_from+\'&siteid=\'+client_id+\'&siteUid=\'+encodeURIComponent(siteUid)+\'&member_id=\'+member_id+\'&is_new=\'+is_new);				

				xmlHttp.send(null);
  
    
}
function handleHttpResponse_notify()
{
  if (xmlhttp.readyState == 4) {
    window.open(clientSite+\'myaccount.php\',\'_self\');
    }
}
';


		





  
  /*google plus login */
  if(in_array('2',$network))
  {
  $fileContent .='
  function track_user_gp(info) {


				xmlHttp=GetXmlHttpObject(handleHttpResponse_user_gp);
                
                
                
                
                var uid=info.id;
                
				xmlHttp.open("GET",url+\'is_gp=1&siteid=\'+client_id+\'&other=\'+encodeURIComponent(JSON.stringify(info)));				

				xmlHttp.send(null);

		}



		function handleHttpResponse_user_gp() {
		  
          if (xmlHttp.readyState == 4) {
            var gobj=JSON.parse(xmlHttp.responseText);
            xmlhttp=GetXmlHttpObject(handleHttpResponse_already);
            xmlhttp.open("POST",clientSite+"csfiles/csposts_new.php",true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("member_id="+gobj.member_id+"&email="+gobj.email+"&first_name="+gobj.first_name+"&last_name="+gobj.last_name+"&action=already"+"&is_from=3");
            
            }
    }
';
}
                       
            
            
        /*$myfile = fopen($file_path.$file_name,"w") or die("Unable to open file!");
        $txt = "alert('This is testing javascript file.');\n";
        fwrite($myfile, $txt) or die("Unable to file write!");
        $txt = "alert('This is second time testing alert testing javascript file.');\n";
        fwrite($myfile, $txt) or die("Unable to file write!");
        fclose($myfile);
        */
        
        $myfile = fopen($file_path.$file_name,"w") or die("Unable to open file!");
        fwrite($myfile, $fileContent) or die($myfile);
        
        
        
        $_SESSION['msg']="update";
        header("location:social_login_setting.php"); exit;
    }
    
}


if(!isset($_POST['save']))
{
    $site_data_qry="select * from cs_client_social_network where client_id='".$_SESSION['admin_id']."'";
    $site_data_sql=re_db_query($site_data_qry);
    $total_rec=re_db_num_rows($site_data_sql);
    
    if($total_rec>0)
    {
        $site_data_rec=re_db_fetch_array($site_data_sql);
        
        $placement=$site_data_rec['placement'];
        $btn_style=$site_data_rec['btn_style'];
        $button_size=$site_data_rec['button_size'];
        $plugin_size=$site_data_rec['plugin_size'];
        $custom_w=$site_data_rec['custom_w'];
        $custom_h=$site_data_rec['custom_h'];
        $network=explode(",",$site_data_rec['network']);
    }
}

if(isset($_SESSION['msg']) && $_SESSION['msg']=="update")
{ 
    $msg="Change Saved Successfully.";
    unset($_SESSION['msg']); 
}

    $site_data_sql=re_db_query("select * from cs_client_social_network where client_id='".$_SESSION['admin_id']."'");
    if(re_db_num_rows($site_data_sql)<=0) {
        $file_url="";
    }


    $social_display_sql=re_db_query("select fb_app_id,twitter_app_id,linkedin_app_id,gplus_app_id,yahoo_app_id,insta_app_id from cs_sites where id='".$_SESSION['admin_id']."'");
    $social_display_rec=re_db_fetch_array($social_display_sql);


include("header.php");
?>
<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
        <ol class="breadcrumb">
            <li>YOU ARE HERE</li>
            <li class="active">Login Setting</li>
        </ol>
        <!--h1 class="page-title">Site - <span class="fw-semi-bold">Settings</span></h1-->
        <div class="row">
            <div class="col-md-6 col-lg-5">
                <section class="widget">
                    <header>
                        <h4>Login <small>Setting</small></h4>
                        <div class="widget-controls">
                            <!--a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a-->
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <form class="login-form mt-lg" action="" method="post" enctype="multipart/form-data">
                            <table class="table">
                                <tr><td style="border: medium none;">Coupay Social offers an authentication service that you can use on your site. Presenting the login plugin on your login / registration page enables your users to sign into your site via their social network / OpenID account.</td></tr>
                                <?php if(count($error)>0)
                                {
                                    ?><tr><td><?php echo display_error_msg($error);?></td></tr><?php
                                } if(isset($msg) && $msg!="") {?>
                                    <tr><td><span style="color: #008000;" ><?php echo $msg; ?></span></td></tr>
                                <?php } ?>
                                <tr><th>Plugin placement</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div><input type="radio" name="placement" id="placement_1" value="popup"<?php if($placement=="popup") { echo ' checked="checked"';}?> disabled="disabled" onclick="call_change_preview()" />&nbsp;&nbsp;Pop-up</div>
                                        <div style="margin-top: 5px;"><input type="radio" name="placement" id="placement_2" value="page"<?php if($placement=="page") { echo ' checked="checked"';}?> onclick="call_change_preview()" />&nbsp;&nbsp;On Page</div>
                                    </td>
                                </tr>
                                <tr><th>Button style</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div><input type="radio" name="btn_style" id="btn_style_1" value="ic"<?php if($btn_style=="ic") { echo ' checked="checked"';}?> onclick="call_change_preview()" />&nbsp;&nbsp;Icon</div>
                                        <div style="margin-top: 5px;"><input type="radio" name="btn_style" id="btn_style_2" value="fc"<?php if($btn_style=="fc") { echo ' checked="checked"';}?> onclick="call_change_preview()" />&nbsp;&nbsp;Full Logos - Colored</div>
                                        <div style="margin-top: 5px;"><input type="radio" name="btn_style" id="btn_style_3" value="fg"<?php if($btn_style=="fg") { echo ' checked="checked"';}?> onclick="call_change_preview()" />&nbsp;&nbsp;Full Logos - Gray</div>
                                    </td>
                                </tr>
                                <tr><th>Select buttons size</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <select name="button_size" id="button_size" onchange="call_change_preview()">
                                            <option value="30"<?php if($button_size=="30") { echo ' selected="selected"';}?>>30px</option>
                                            <option value="40"<?php if($button_size=="40") { echo ' selected="selected"';}?>>40px</option>
                                            <option value="50"<?php if($button_size=="50") { echo ' selected="selected"';}?>>50px</option>
                                            <option value="60"<?php if($button_size=="60") { echo ' selected="selected"';}?>>60px</option>
                                            <option value="65"<?php if($button_size=="65") { echo ' selected="selected"';}?>>65px</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr><th>Plugin size</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div><input type="radio" name="plugin_size" id="plugin_size_1" value="standard"<?php if($plugin_size=="standard") { echo ' checked="checked"';}?> />&nbsp;&nbsp;Standard</div>
                                        <div style="float: left; margin-right: 20px;"><input type="radio" name="plugin_size" id="plugin_size_1" value="custom"<?php if($plugin_size=="custom") { echo ' checked="checked"';}?> disabled="disabled" />&nbsp;&nbsp;Custom</div>
                                        <div>
                                            <strong>W: </strong>&nbsp;&nbsp;<input style="border: 1px solid; width: 50px;" type="text" name="custom_w" id="custom_w" value="<?php echo $custom_w;?>" />&nbsp;&nbsp;
                                            <strong>H: </strong>&nbsp;&nbsp;<input style="border: 1px solid; width: 50px;" type="text" name="custom_h" id="custom_h" value="<?php echo $custom_h;?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr><th>Choose network</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <?php $social_sql=re_db_query("select * from cs_social_network_master where is_display='1'");
                                        if(re_db_num_rows($social_sql)>0)
                                        {
                                            $i=0;
                                            while($social_rec=re_db_fetch_array($social_sql))
                                            {
                                                $display="0";
                                                if($social_rec['social_name']=="Facebook" && $social_display_rec['fb_app_id']!="") { $display="1"; }
                                                else if($social_rec['social_name']=="Twitter" && $social_display_rec['twitter_app_id']!="") { $display="1"; }
                                                else if($social_rec['social_name']=="LinkedIn" && $social_display_rec['linkedin_app_id']!="") { $display="1"; }
                                                else if($social_rec['social_name']=="Google Plus" && $social_display_rec['gplus_app_id']!="") { $display="1"; }
                                                else if($social_rec['social_name']=="Yahoo" && $social_display_rec['yahoo_app_id']!="") { $display="1"; }
                                                else if($social_rec['social_name']=="Instagram" && $social_display_rec['insta_app_id']!="") { $display="1"; }
                                               
                                                if($display=="1")
                                                {
                                                    $i++; $checked="";
                                                    if(is_array($network) && in_array($social_rec['social_id'],$network)) { $checked=' checked="checked"'; }
                                                    
                                                    ?>
                                                    <div style="float: left; padding: 2px; margin: 2px; width: 170px;">
                                                        <input type="checkbox" name="network[<?php echo $i;?>]" id="network_<?php echo $i;?>" value="<?php echo $social_rec['social_id'];?>"<?php echo $checked;?> onclick="call_change_preview()" />&nbsp;&nbsp;<?php echo $social_rec['social_name'];?>
                                                    </div>
                                                    <?php
                                                } 
                                            }
                                            ?><input type="hidden" name="total_net" id="total_net" value="<?php echo $i;?>" /><?php 
                                        } 
                                        else 
                                        {
                                            $i=0;
                                            if($social_rec['social_name']=="Facebook" && $social_display_rec['fb_app_id']!="")
                                            {
                                                $i++; ?>
                                                <div style="float: left; padding: 2px; margin: 2px; width: 170px;">
                                                    <input type="checkbox" name="network[<?php echo $i;?>]" id="network_<?php echo $i;?>" value="2"<?php if(is_array($network) && in_array('2',$network)) { echo ' checked="checked"'; }?> onclick="call_change_preview()" />&nbsp;&nbsp;Facebook
                                                </div>
                                                <?php 
                                            }
                                            if($social_rec['social_name']=="Google Plus" && $social_display_rec['gplus_app_id']!="")
                                            {
                                                $i++; ?>
                                                <div style="float: left; padding: 2px; margin: 2px; width: 170px;">
                                                    <input type="checkbox" name="network[<?php echo $i;?>]" id="network_<?php echo $i;?>" value="4"<?php if(is_array($network) && in_array('4',$network)) { echo ' checked="checked"'; }?> onclick="call_change_preview()" />&nbsp;&nbsp;Google Plus
                                                </div>
                                                <?php 
                                            }
                                            if($social_rec['social_name']=="LinkedIn" && $social_display_rec['linkedin_app_id']!="")
                                            {
                                                $i++; ?>
                                                <div style="float: left; padding: 2px; margin: 2px; width: 170px;">
                                                    <input type="checkbox" name="network[<?php echo $i;?>]" id="network_<?php echo $i;?>" value="7"<?php if(is_array($network) && in_array('7',$network)) { echo ' checked="checked"'; }?> onclick="call_change_preview()" />&nbsp;&nbsp;LinkedIn
                                                </div>
                                                <?php
                                            }
                                            if($social_rec['social_name']=="Twitter" && $social_display_rec['twitter_app_id']!="")
                                            {
                                                $i++; ?>
                                                <div style="float: left; padding: 2px; margin: 2px; width: 170px;">
                                                    <input type="checkbox" name="network[<?php echo $i;?>]" id="network_<?php echo $i;?>" value="13"<?php if(is_array($network) && in_array('13',$network)) { echo ' checked="checked"'; }?> onclick="call_change_preview()" />&nbsp;&nbsp;Twitter
                                                </div>
                                                <?php 
                                            }
                                            if($social_rec['social_name']=="Yahoo" && $social_display_rec['yahoo_app_id']!="")
                                            {
                                                $i++; ?>
                                                <div style="float: left; padding: 2px; margin: 2px; width: 170px;">
                                                    <input type="checkbox" name="network[<?php echo $i;?>]" id="network_<?php echo $i;?>" value="15"<?php if(is_array($network) && in_array('15',$network)) { echo ' checked="checked"'; }?> onclick="call_change_preview()" />&nbsp;&nbsp;Yahoo
                                                </div>
                                                <?php 
                                            }
                                            ?>
                                            <input type="hidden" name="total_net" id="total_net" value="<?php echo $i;?>" />
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
                    </div>
                </section>
            </div>
            <div class="col-md-6 col-lg-5">
                <section class="widget">
                    <header>
                        <h4>Login <small>Preview</small></h4>
                        <div class="widget-controls">
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <table class="table">
                            <tr><th>Button Preview</th></tr>
                            <tr>
                                <td style="border: medium none;">
                                    <div id="preview_div">
                                        <div style="float: left; margin-right: 10px; width: 30px; height: 30px; background-image: url(<?php echo SITE_URL;?>img/social_icon/social_login_ic_30.png); background-position: -30px 0px;"></div>
                                        <div style="float: left; margin-right: 10px; width: 30px; height: 30px; background-image: url(<?php echo SITE_URL;?>img/social_icon/social_login_ic_30.png); background-position: -180px 0px;"></div>
                                        <div style="float: left; margin-right: 10px; width: 30px; height: 30px; background-image: url(<?php echo SITE_URL;?>img/social_icon/social_login_ic_30.png); background-position: -360px 0px;"></div>
                                        <div style="float: left; margin-right: 10px; width: 30px; height: 30px; background-image: url(<?php echo SITE_URL;?>img/social_icon/social_login_ic_30.png); background-position: -90px 0px;"></div>
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
                        <?php if($file_url!="")
                        {
                            ?>
                            <table class="table">
                                <tr><th>Copy below code and paste it to your site header.</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <textarea style="background-color:#eee; border: 1px solid #d9d9d9; width: 100%;" id="header" class="grabHeaderCode" readonly="readonly" onclick="this.select();"><?php echo '<script type="text/javascript" src="'.$file_url.'"></script>';?></textarea>
                                    </td>
                                </tr>
                            </table>
                            <table class="table">
                        <?php 
                        
                        $buttonContent="var csbutton = csbutton || (function(){
    var _args = {}; // private

    return {
        init : function(Args) {
            _args = Args;            
        },
        putCsbutton : function() {
            if(_args[3]=='login')
            {
                var is_share_login='0';
            }
            else
            {
                var is_share_login='1';
            }
            
            if(_args[4] && _args[4]!='')
            {
                if(_args[4]=='li')
                {";
                
                if(in_array("7",$network))
            { 
            $buttonContent.="document.write('<a href=\"javascript:void(0);\" onclick=\"onLinkedInLoad();\">'+_args[0]+'</a>');";
            }
                    
              $buttonContent .="  } 
              else if(_args[4]=='yahoo')
              {";
                
                if(in_array("15",$network))
                {
                    
                   
                   
                   $buttonContent.="document.write('<a href=\"javascript:void(0);\" onclick=\"window.open(\'".$row_site['site_url']."csfiles/yahoo.php?login&amp;site_id=".$_SESSION['admin_id']."\',\'Login with Yahoo\',\'width=500,height=300\');\">'+_args[0]+'</a>');"; 
                    
                }
                
               $buttonContent .="}
               else if(_args[4]=='instagram')
               {";
                
                if(in_array("5",$network))
                {
                    
                   
                   
                   $buttonContent.="document.write('<a href=\"javascript:void(0);\" onclick=\"window.open(\'https://api.instagram.com/oauth/authorize?client_id=".$row_site['insta_app_id']."&amp;redirect_uri=".SITE_URL."instagram/success.php?site_id=".$_SESSION['admin_id']."&amp;scope=basic&amp;response_type=code\',\'Login with Instagram\',\'width=400,height=300\');\">'+_args[0]+'</a>');"; 
                    
                }
                
                
               $buttonContent .=" }
                else
                {    
                
                ";
            if(in_array("4",$network))
            { 
            $buttonContent.="document.write('<a href=\"javascript:void(0);\" onclick=\"gapi.auth.signIn({\'clientid\' : \''+_args[4]+'\',\'callback\': signinCallback,\'scope\':\'https://www.googleapis.com/auth/plus.login  https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile\',\'cookiepolicy\':\'single_host_origin\',\'approvalprompt\':\'force\',\'access_type\':\'online\'});return;\">'+_args[0]+'</a>');";
            }
           $buttonContent.=" }
             }
            else
            {
                document.write('<a href=\"javascript:void(0)\" onclick=\"csfblogin('+is_share_login+')\">'+_args[0]+'</a>');
            }
            
        }
    };
}());

";    

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

$img='social_login_'.$btn_style.'_'.$button_size.'.png';
$file_div ='<script src="'.SITE_URL.'/client_share_js/csloginbuttons.js"></script>'.PHP_EOL;

$fb_div="";
if(in_array('2',$network))
{
    $bg_position=$btn_width;
    $fb_div .='<script type="text/javascript">';
    $imgdiv='<div style="float: left; margin-right: 10px; width: '.$btn_width.'px; height: '.$button_size.'px; background-image: url('.SITE_URL.'img/social_icon/'.$img.'); background-position: -'.$bg_position.'px 0px;"></div>';
    $fb_div .='csbutton.init([\''.$imgdiv.'\',\''.$btn_width.'px\' ,\''.$button_size.'\',\'login\']);'.PHP_EOL;
    $fb_div .='csbutton.putCsbutton();         
              </script>';

    
}
$gp_div="";
if(in_array('4',$network))
{
    $bg_position=((3)*$btn_width);
    $gp_div .='<script type="text/javascript">';
    $imgdiv='<div style="float: left; margin-right: 10px; width: '.$btn_width.'px; height: '.$button_size.'px; background-image: url('.SITE_URL.'img/social_icon/'.$img.'); background-position: -'.$bg_position.'px 0px;"></div>';
    $gp_div .='csbutton.init([\''.$imgdiv.'\',\''.$btn_width.'px\' ,\''.$button_size.'px\',\'login\',\''.$row_site['gplus_app_id'].'\']);'.PHP_EOL;
    $gp_div .='csbutton.putCsbutton();         
              </script>';
  
}
$li_div="";
if(in_array('7',$network))
{
    $bg_position=((6)*$btn_width);
    $li_div .='<script type="text/javascript">';
    $imgdiv='<div style="float: left; margin-right: 10px; width: '.$btn_width.'px; height: '.$button_size.'px; background-image: url('.SITE_URL.'img/social_icon/'.$img.'); background-position: -'.$bg_position.'px 0px;"></div>';
    $li_div .='csbutton.init([\''.$imgdiv.'\',\''.$btn_width.'px\' ,\''.$button_size.'px\',\'login\',\'li\']);'.PHP_EOL;
    $li_div .='csbutton.putCsbutton();         
              </script>';
  
}
$yh_div="";
if(in_array('15',$network))
{
    $bg_position=((14)*$btn_width);
    $yh_div .='<script type="text/javascript">';
    $imgdiv='<div style="float: left; margin-right: 10px; width: '.$btn_width.'px; height: '.$button_size.'px; background-image: url('.SITE_URL.'img/social_icon/'.$img.'); background-position: -'.$bg_position.'px 0px;"></div>';
    $yh_div .='csbutton.init([\''.$imgdiv.'\',\''.$btn_width.'px\' ,\''.$button_size.'px\',\'login\',\'yahoo\']);'.PHP_EOL;
    $yh_div .='csbutton.putCsbutton();         
              </script>';
  
}
$ig_div="";
if(in_array('5',$network))
{
    $bg_position=((4)*$btn_width);
    $ig_div .='<script type="text/javascript">';
    $imgdiv='<div style="float: left; margin-right: 10px; width: '.$btn_width.'px; height: '.$button_size.'px; background-image: url('.SITE_URL.'img/social_icon/'.$img.'); background-position: -'.$bg_position.'px 0px;"></div>';
    $ig_div .='csbutton.init([\''.$imgdiv.'\',\''.$btn_width.'px\' ,\''.$button_size.'px\',\'login\',\'instagram\']);'.PHP_EOL;
    $ig_div .='csbutton.putCsbutton();         
              </script>';
  
}


$login_file_name="csloginbuttons_".$_SESSION['admin_id'].".js";

$login_file = fopen($file_path.$login_file_name,"w") or die("Unable to open file!");
$login_file_url=SITE_WS_CLIENT_SHARE_JS.$login_file_name;
        fwrite($login_file, $buttonContent) or die($myfile);
        
                        ?>
                        
                            <tr><th>Copy below code and paste it within body tag where you want social login buttons/icons.</th></tr>
                            <tr>
                                <td style="border: medium none;">
                                    <textarea style="background-color:#eee; border: 1px solid #d9d9d9; width: 100%;" id="header" class="grabHeaderCode" readonly="readonly" onclick="this.select();"><?php echo '<script type="text/javascript" src="'.$login_file_url.'"></script>'.PHP_EOL.$fb_div.PHP_EOL.$gp_div.PHP_EOL.$li_div.PHP_EOL.$yh_div.PHP_EOL.$ig_div;?></textarea>
                                </td>
                            </tr>
                        </table>
                        <?php }?>
                    </div>
                </section>
<script type="text/javascript">
    function call_change_preview()
    {
        if(document.getElementById('placement_1').checked) { var placement=document.getElementById('placement_1').value; }
        else if(document.getElementById('placement_2').checked) { var placement=document.getElementById('placement_2').value; }

        if(document.getElementById('btn_style_1').checked) { var btn_style=document.getElementById('btn_style_1').value; }
        else if(document.getElementById('btn_style_2').checked) { var btn_style=document.getElementById('btn_style_2').value; }
        else if(document.getElementById('btn_style_3').checked) { var btn_style=document.getElementById('btn_style_3').value; }
        
        var button_size=document.getElementById('button_size').value;
        
        if(document.getElementById('plugin_size_1').checked) { var plugin_size=document.getElementById('plugin_size_1').value; }
        else if(document.getElementById('plugin_size_2').checked) { var plugin_size=document.getElementById('plugin_size_2').value; }
        var custom_w=document.getElementById('custom_w').value;
        var custom_h=document.getElementById('custom_h').value;
        
        var social_network="";
        var total_net=document.getElementById('total_net').value;
        for(var i=1; i<=total_net; i++)
        {
            if(document.getElementById('network_'+i).checked && social_network=="") {
                social_network=document.getElementById('network_'+i).value;
            }
            else if(document.getElementById('network_'+i).checked && social_network!="") {
                social_network=social_network+","+document.getElementById('network_'+i).value;
            }
        }
        
        var url="placement="+placement+"&btn_style="+btn_style+"&button_size="+button_size+"&plugin_size="+plugin_size+"&custom_w="+custom_w+"&custom_h="+custom_h+"&social_network="+social_network;
        
        if(social_network!="")
        {
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
                    document.getElementById("preview_div").innerHTML=res;
                }
            }
            
            xmlhttp.open("GET","ajax_login_setting.php?"+url,true);
            xmlhttp.send();
        }
        else {
            alert("Please select network");
        }
    }
    call_change_preview();
</script>
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