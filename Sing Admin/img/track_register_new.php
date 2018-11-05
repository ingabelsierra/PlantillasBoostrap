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

if(isset($_GET['is_ig']) && $_GET['is_ig']=='1' && $_GET['action']=='is_check_ig')
{
        $select_cs="select id from cs_users where email='".mysql_real_escape_string($_GET['email'])."' and client_id='".mysql_real_escape_string($_GET['siteid'])."'";
        
        $res_cs=re_db_query($select_cs);
        if(mysql_num_rows($res_cs) > 0)
        {
            $row_cs=mysql_fetch_array($res_cs);
            $member_id=$row_cs['id'];
            
            re_db_query("update cs_users set is_ig='1',ig_id='".mysql_real_escape_string($_GET['ig_id'])."' where id='".$member_id."'");
        }
        else
        {
            
            re_db_query("insert into cs_users set email='".mysql_real_escape_string($_GET['email'])."',is_ig='1',ig_id='".mysql_real_escape_string($_GET['ig_id'])."',client_id='".mysql_real_escape_string($_GET['siteid'])."'");
            $member_id=mysql_insert_id();
            
        }
  
    $set_query=" set client_id='".re_db_input($_GET['siteid'])."',member_id='".$member_id."',
                    insta_id='".re_db_input($_GET['ig_id'])."',full_name='".re_db_input($_GET['full_name'])."',username='".re_db_input($_GET['username'])."',bio='".re_db_input($_GET['bio'])."',profile_pic='".re_db_input($_GET['profile_pic'])."',
                    website='".re_db_input($_GET['website'])."',email='".re_db_input($_GET['email'])."',bday='".intval($_GET['bday'])."',bmonth='".intval($_GET['bmonth'])."',byear='".intval($_GET['byear'])."'";
    
        $select_user="select id from cs_ig_data where email='".mysql_real_escape_string($_GET['email'])."'  and client_id='".mysql_real_escape_string($_GET['siteid'])."'";
        $res_user=re_db_query($select_user);
        $csuser_id=0;
        if(mysql_num_rows($res_user) > 0)
        {
            $row_user=mysql_fetch_array($res_user);
            $csuser_id=$row_user['id'];
            $update_query="update cs_ig_data";
            $where=" where email='".mysql_real_escape_string($_GET['email'])."'  and client_id='".mysql_real_escape_string($_GET['siteid'])."'";
            
        }  
        else
        {
            $update_query="insert into cs_ig_data";
            $where="";
        } 
        $set_query=$update_query.$set_query.$where;
        re_db_query($set_query);
        echo re_db_output($_GET['email'])."~".re_db_input($_GET['ig_id']);
    exit;
}



if(isset($_GET['is_ig']) && $_GET['is_ig']=='1')
{
    
    $select_email="select id,email from cs_users where is_ig='1' and ig_id='".re_db_input($_GET['ig_id'])."' and client_id='".re_db_input($_GET['siteid'])."'";
    $res_email=re_db_query($select_email);
    $set_query="set client_id='".re_db_input($_GET['siteid'])."',
                    insta_id='".re_db_input($_GET['ig_id'])."',full_name='".re_db_input($_GET['full_name'])."',username='".re_db_input($_GET['username'])."',bio='".re_db_input($_GET['bio'])."',profile_pic='".re_db_input($_GET['profile_pic'])."',
                    website='".re_db_input($_GET['website'])."'";
    if(re_db_num_rows($res_email) > 0)
    {
        $row_user=re_db_fetch_array($res_email);
        $member_id=$row_user['id'];
        echo $row_user['email']."~".$_GET['ig_id']."~".$row_user['id'];
        $update_query="update cs_ig_data ".$set_query.",member_id='".$member_id."' where insta_id='".re_db_input($_GET['ig_id'])."' and client_id='".re_db_input($_GET['siteid'])."'";
        re_db_query($update_query);
        
    }
    else
    {
      /*$insert_into="insert into cs_users set is_ig='1',client_id='".re_db_input($_GET['site_id'])."',ig_id='".$_GET['ig_id']."'";
      re_db_query($insert_into);*/   
      echo "0~".$_GET['ig_id']."~".$row_user['id'];
      /*$member_id=re_db_insert_id();
      $insert_into="insert into cs_ig_data ".$set_query.",member_id='".$member_id."',reg_on='".date('Y-m-d H:i:s',mktime(gmdate('H'),gmdate('i'),gmdate('s'),gmdate('m'),gmdate('d'),gmdate('Y')))."'";
      re_db_query($insert_into);*/
    }
    
    exit;
}

if(isset($_GET['is_from']) && $_GET['is_from']=='6' && $_GET['action']!='notifycs')
{
    
    $select_data="update cs_users set email='".mysql_real_escape_string($_GET['email'])."' where ig_id='".mysql_real_escape_string($_GET['id'])."' and client_id='".re_db_input($_GET['siteid'])."'";
    re_db_query($select_data);
    $get_ig_data="update cs_ig_data set email='".mysql_real_escape_string($_GET['email'])."' where email is null or email='' and insta_id='".mysql_real_escape_string($_GET['id'])."' and client_id='".re_db_input($_GET['siteid'])."'";
    re_db_query($get_ig_data);
    $sel_data="select full_name,email,member_id from cs_ig_data where insta_id='".mysql_real_escape_string($_GET['id'])."' and client_id='".re_db_input($_GET['siteid'])."'";
    $res_sel=re_db_query($sel_data);
    $row_sel=re_db_fetch_array($res_sel);
    
    $inser_logins="insert into cs_logins (client_id,member_id,date_time,ip,is_from)
                  values ('".mysql_real_escape_string($_GET['siteid'])."','".$row_sel['member_id']."','".date('Y-m-d H:i:s',mktime(gmdate('H'),gmdate('i'),gmdate('s'),gmdate('m'),gmdate('d'),gmdate('Y')))."','".$_SERVER['REMOTE_ADDR']."','6')";
    mysql_query($inser_logins);  
    $first_last=explode(" ",$row_sel['full_name']);           
    echo json_encode( array('email'=>$row_sel['email'],'first_name'=>$first_last[0],'last_name'=>$first_last[1],'member_id'=>$row_sel['member_id']));
exit;
  

    
}



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
    if($_GET['is_from']=='3')
    {
        $update_cs="update cs_gp_users set siteUid='".mysql_real_escape_string($_GET['siteUid'])."' ".$reg_on." where member_id='".mysql_real_escape_string($_GET['member_id'])."'";
        
        mysql_query($update_cs);
        
    }
    if($_GET['is_from']=='2')
    {
        $update_cs="update cs_li_data set siteUid='".mysql_real_escape_string($_GET['siteUid'])."' ".$reg_on." where member_id='".mysql_real_escape_string($_GET['member_id'])."'";
        
        mysql_query($update_cs);
        
    }
    if($_GET['is_from']=='6')
    {
        $update_cs="update cs_ig_data set siteUid='".mysql_real_escape_string($_GET['siteUid'])."' ".$reg_on." where member_id='".mysql_real_escape_string($_GET['member_id'])."'";
        
        mysql_query($update_cs);
        
    }
    if($_GET['is_from']=='5')
    {
        $update_cs="update cs_yahoo_data set siteUid='".mysql_real_escape_string($_GET['siteUid'])."' ".$reg_on." where member_id='".mysql_real_escape_string($_GET['member_id'])."'";
        
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
else if(isset($_GET['is_gp']) && $_GET['is_gp']=='1' )
{
    
    $u_email=$udata->emails[0]->value;
}
else if(isset($_GET['is_yh']) && $_GET['is_yh']=='1' )
{
    
    $u_email=$udata->{'contact/email'};
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
else if($_GET['is_gp']=='1')
{
    $set_query=" is_gp='1'";
}
else if($_GET['is_yh']=='1')
{
    $set_query=" is_yh='1'";
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
if($udata->likes->data[$i]->name!='')
{
 manage_fb_page($udata->likes->data[$i]->name,$udata->likes->data[$i]->id,$member_id,$_GET['siteid'],$udata->likes->data[$i]->likes);
} 
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


if($_GET['is_gp']=='1')
{
$select_user="select id from cs_gp_users where email='".mysql_real_escape_string($udata->emails[0]->value)."' and client_id='".mysql_real_escape_string($_GET['siteid'])."'";
$res_user=re_db_query($select_user);
$csuser_id=0;
if(mysql_num_rows($res_user) > 0)
{
    $row_user=mysql_fetch_array($res_user);
    $csuser_id=$row_user['id'];
    $update_query="update cs_gp_users";
    $where=" where email='".mysql_real_escape_string($udata->emails[0]->value)."'  and client_id='".mysql_real_escape_string($_GET['siteid'])."'";
    
}  
else
{
    $update_query="insert into cs_gp_users";
    $where="";
} 

$bday=explode("-",$udata->birthday);
if($udata->id)
{
$set_query=$update_query." set

                    profile_pic='".mysql_real_escape_string($udata->image->url)."',                    
                    relationship_status='".mysql_real_escape_string($udata->relationshipStatus)."', 
                    member_id='".mysql_real_escape_string($member_id)."',
                    profile_id='".mysql_real_escape_string($udata->id)."',
                    client_id='".mysql_real_escape_string($_GET['siteid'])."',                      
                    name='".mysql_real_escape_string($udata->displayName)."',
                    bday='".$bday[2]."',
                    bmonth='".$bday[1]."',
                    byear='".$bday[0]."',
                    gender='".mysql_real_escape_string($udata->gender)."',
                    email='".mysql_real_escape_string($udata->emails[0]->value)."',
                    location='".mysql_real_escape_string($udata->placesLived[0]->value)."',
                    username='".mysql_real_escape_string($udata->url)."'                    
                    ".$where."
           ";
      
 re_db_query($set_query); 
 if(!isset($_GET['clickurl']) && $_GET['is_gp']=='1')
 {
    $inser_logins="insert into cs_logins (client_id,member_id,date_time,ip,is_from)
                  values ('".mysql_real_escape_string($_GET['siteid'])."','".$member_id."','".date('Y-m-d H:i:s',mktime(gmdate('H'),gmdate('i'),gmdate('s'),gmdate('m'),gmdate('d'),gmdate('Y')))."','".$_SERVER['REMOTE_ADDR']."','3')";
    mysql_query($inser_logins);  
    $first_last=explode(" ",$udata->displayName);           
    echo json_encode( array('email'=>$udata->emails[0]->value,'first_name'=>$first_last[0],'last_name'=>$first_last[1],'member_id'=>$member_id));
exit;
 }
   
 }
}

if($_GET['is_li']=='1')
{
    $select_user="select id from cs_li_data where member_id='".$member_id."'";

$res_user=re_db_query($select_user);
$csuser_id=0;
if(mysql_num_rows($res_user) > 0)
{
    $row_user=mysql_fetch_array($res_user);
    $csuser_id=$row_user['id'];
    $update_query="update cs_li_data";
    $where=" where member_id='".mysql_real_escape_string($member_id)."'";
    
}  
else
{
    $update_query="insert into cs_li_data";
    $where="";
}
if(intval($udata->byear)=='0')
{
    $byear="0000";
}
else
{
    $byear=intval($udata->byear);
}
$set_query=$update_query." set                    
                    member_id='".mysql_real_escape_string($member_id)."',
                    client_id='".mysql_real_escape_string($_GET['siteid'])."',
                    profile_id='".mysql_real_escape_string($udata->id)."',                      
                    firstname='".mysql_real_escape_string($udata->firstName)."',
                    lastname='".mysql_real_escape_string($udata->lastName)."',
                    bday='".mysql_real_escape_string(intval($udata->bday))."',
                    bmonth='".mysql_real_escape_string(intval($udata->bmonth))."',
                    byear='".mysql_real_escape_string($byear)."',
                    headline='".mysql_real_escape_string($udata->headline)."',
                    industry='".mysql_real_escape_string($udata->industry)."',
                    location='".mysql_real_escape_string($udata->location)."',
                    numConnections='".mysql_real_escape_string($udata->numConnections)."',
                    pictureUrl='".mysql_real_escape_string($udata->pictureUrl)."',
                    publicProfileUrl='".mysql_real_escape_string($udata->publicProfileUrl)."'                    
                    ".$where."
           ";
    
 re_db_query($set_query);

if(!isset($_GET['clickurl']) && $_GET['is_li']=='1')
 {
    $inser_logins="insert into cs_logins (client_id,member_id,date_time,ip,is_from)
                  values ('".mysql_real_escape_string($_GET['siteid'])."','".$member_id."','".date('Y-m-d H:i:s',mktime(gmdate('H'),gmdate('i'),gmdate('s'),gmdate('m'),gmdate('d'),gmdate('Y')))."','".$_SERVER['REMOTE_ADDR']."','2')";
    mysql_query($inser_logins);
    echo json_encode( array('email'=>$udata->emailAddress,'first_name'=>$udata->firstName,'last_name'=>$udata->lastName,'member_id'=>$member_id));
exit;
 }
 
}

//Yahoo Data 


if($_GET['is_yh']=='1')
{
$select_user="select id from cs_yahoo_data where email='".mysql_real_escape_string($udata->{'contact/email'})."' and client_id='".mysql_real_escape_string($_GET['siteid'])."'";
$res_user=re_db_query($select_user);
$csuser_id=0;
if(mysql_num_rows($res_user) > 0)
{
    $row_user=mysql_fetch_array($res_user);
    $csuser_id=$row_user['id'];
    $update_query="update cs_yahoo_data";
    $where=" where email='".mysql_real_escape_string($udata->{'contact/email'})."'  and client_id='".mysql_real_escape_string($_GET['siteid'])."'";
    
}  
else
{
    $update_query="insert into cs_yahoo_data";
    $where="";
} 


if($udata->{'contact/email'})
{
$gender=$udata->{'person/gender'};    
$set_query=$update_query." set

                    profile_pic='".mysql_real_escape_string($udata->{'media/image/default'})."',
                    member_id='".mysql_real_escape_string($member_id)."',
                    client_id='".mysql_real_escape_string($_GET['siteid'])."',                      
                    full_name='".mysql_real_escape_string($udata->namePerson)."',
                    gender='".mysql_real_escape_string($gender)."',
                    email='".mysql_real_escape_string($udata->{'contact/email'})."',
                    pref_lang   ='".mysql_real_escape_string($udata->{'pref/language'})."'
                    
                                        
                    ".$where."
           ";
      
 re_db_query($set_query); 
 if(!isset($_GET['clickurl']) && $_GET['is_yh']=='1')
 {
    $inser_logins="insert into cs_logins (client_id,member_id,date_time,ip,is_from)
                  values ('".mysql_real_escape_string($_GET['siteid'])."','".$member_id."','".date('Y-m-d H:i:s',mktime(gmdate('H'),gmdate('i'),gmdate('s'),gmdate('m'),gmdate('d'),gmdate('Y')))."','".$_SERVER['REMOTE_ADDR']."','5')";
    mysql_query($inser_logins);  
    $first_last=explode(" ",$udata->namePerson);           
    echo json_encode( array('email'=>$udata->{'contact/email'},'first_name'=>$first_last[0],'last_name'=>$first_last[1],'member_id'=>$member_id));
exit;
 }
   
 }
}

}

/*FB DATA END*/
function manage_fb_page($fb_page_title,$fb_page_id,$member_id,$client_id,$total_likes)
{
   $select_all="select * from `cs_like_pages` where page_title='".mysql_real_escape_string($fb_page_title)."'";
   $res_like=re_db_query($select_all);
   if(re_db_num_rows($res_like) > 0)
   {
    $row_page=re_db_fetch_array($res_like);
    re_db_query("update cs_like_pages set fb_page_id='".$fb_page_id."',total_likes='".$total_likes."' where id='".$row_page['id']."'");
    $user_entry=re_db_query("select id from `cs_member_pages_like` where page_id='".$row_page['id']."' and client_id='".$client_id."' and member_id='".$member_id."'");
    if(re_db_num_rows($user_entry) <= 0)
    {
      $insert_user="insert into `cs_member_pages_like` set page_id='".$row_page['id']."',member_id='".$member_id."',client_id='".$client_id."'";
      re_db_query($insert_user);  
    }
   } 
   else
   {
    
    $insert_cs=re_db_query("insert into cs_like_pages set page_title='".mysql_real_escape_string($fb_page_title)."',fb_page_id='".$fb_page_id."',total_likes='".$total_likes."'");
    $last_page_id=mysql_insert_id();
    $insert_user="insert into `cs_member_pages_like` set page_id='".$last_page_id."',member_id='".$member_id."',client_id='".$client_id."'";
    re_db_query($insert_user);
       
    
   }
}
?>