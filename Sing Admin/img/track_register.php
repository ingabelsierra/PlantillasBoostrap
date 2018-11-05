<?php
switch($_GET['siteid'])
{
case '1':    
header('Access-Control-Allow-Origin: http://www.coupay.co.in');
break;
case '4':
header('Access-Control-Allow-Origin: http://www.soclever.net');
break;
case '5':
header('Access-Control-Allow-Origin: http://www.coupay.com');
break;
}
include("include/config.php");

if(isset($_GET['action']) && $_GET['action']=='notifycs' )
{
    $reg_on='';
    if(isset($_GET['is_new']) && $_GET['is_new']=='1')
    {
        $reg_on=",reg_on='".date('Y-m-d H:i:s',mktime(gmdate('H'),gmdate('i'),gmdate('s'),gmdate('m'),gmdate('d'),gmdate('Y')))."'";
    }
    if($_GET['is_from']=='1')
    {
        $update_cs="update cs_fb_share_users set site_uid='".mysql_real_escape_string($_GET['siteUid'])."' ".$reg_on." where member_id='".mysql_real_escape_string($_GET['member_id'])."'";
        
        mysql_query($update_cs);
        
    }
    exit;
}

$udata=json_decode($_GET['other']);

if(isset($_GET['is_fb']) && $_GET['is_fb']=='1' )
{
    $u_email=$udata->email;
}
else if(isset($_GET['is_li']) && $_GET['is_li']=='1' )
{
    
    $u_email=$udata->emailAddress;
}
else
{
    $u_email='';
}

if($u_email!='')
{
    
if($_GET['is_fb']=='1')
{
    $set_query=" is_fb='1' ";
}
else if($_GET['is_li']=='1')
{
    $set_query=" is_li='1'";
}

$select_cs="select id from cs_users where email='".mysql_real_escape_string($u_email)."' and client_id='".mysql_real_escape_string($_GET['siteid'])."'";

$res_cs=re_db_query($select_cs);
if(mysql_num_rows($res_cs) > 0)
{
    $row_cs=mysql_fetch_array($res_cs);
    $member_id=$row_cs['id'];
    
    re_db_query("update cs_users set ".$set_query." where id='".$member_id."'");
}
else
{
    
    re_db_query("insert into cs_users set email='".mysql_real_escape_string($u_email)."',".$set_query.",client_id='".mysql_real_escape_string($_GET['siteid'])."'");
    $member_id=mysql_insert_id();
    
}

if($_GET['is_fb']=='1')
{
$select_user="select id from cs_fb_share_users where email='".mysql_real_escape_string($udata->email)."' and app_id='".mysql_real_escape_string($_GET['app_id'])."' and client_id='".mysql_real_escape_string($_GET['siteid'])."'";
$res_user=re_db_query($select_user);
$csuser_id=0;
if(mysql_num_rows($res_user) > 0)
{
    $row_user=mysql_fetch_array($res_user);
    $csuser_id=$row_user['id'];
    $update_query="update cs_fb_share_users";
    $where=" where email='".mysql_real_escape_string($udata->email)."' and app_id='".mysql_real_escape_string($_GET['app_id'])."' and client_id='".mysql_real_escape_string($_GET['siteid'])."'";
    
}  
else
{
    $update_query="insert into cs_fb_share_users";
    $where="";
} 
$likes="";
for($i=0;$i<count($udata->likes->data);$i++)
{    
$likes .=$udata->likes->data[$i]->name.",";

}

if($udata->id)
{
$set_query=$update_query." set

                    profile_pic='".mysql_real_escape_string($udata->picture->data->url)."',
                    relationship_status='".mysql_real_escape_string($udata->relationship_status)."', 
                    member_id='".mysql_real_escape_string($member_id)."',
                    uid='".mysql_real_escape_string($udata->id)."',
                    client_id='".mysql_real_escape_string($_GET['siteid'])."',
                    app_id='".mysql_real_escape_string($_GET['app_id'])."',  
                    uname='".mysql_real_escape_string($udata->first_name.' '.$udata->last_name)."',
                    birthday='".date('Y-m-d',strtotime($udata->birthday))."',
                    gender='".mysql_real_escape_string($udata->gender)."',
                    email='".mysql_real_escape_string($udata->email)."',
                    location='".mysql_real_escape_string($udata->location->name)."',
                    username='".mysql_real_escape_string($udata->link)."',
                    hometown='".mysql_real_escape_string($udata->hometown->name)."',
                    school='".mysql_real_escape_string($udata->school->name)."',
                    interests='".mysql_real_escape_string($udata->interests)."',
                    timezone='".mysql_real_escape_string($udata->timezone)."',
                    locale='".mysql_real_escape_string($udata->locale)."',
                    friends='".mysql_real_escape_string($udata->friends->summary->total_count)."',
                    likes='".mysql_real_escape_string($likes)."'
                    ".$where."
           ";
        //echo $set_query;   
 re_db_query($set_query); 
 if(!isset($_GET['clickurl']))
 {
    $inser_logins="insert into cs_logins (client_id,member_id,date_time,ip,is_from)
                  values ('".mysql_real_escape_string($_GET['siteid'])."','".$member_id."','".date('Y-m-d H:i:s',mktime(gmdate('H'),gmdate('i'),gmdate('s'),gmdate('m'),gmdate('d'),gmdate('Y')))."','".$_SERVER['REMOTE_ADDR']."','1')";
    mysql_query($inser_logins);              
    echo json_encode( array('email'=>$udata->email,'first_name'=>$udata->first_name,'last_name'=>$udata->last_name,'member_id'=>$member_id));
exit;
 }
   
 }
}
}

/*FB DATA END*/

?>