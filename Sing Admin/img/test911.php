<?php
include("include/config.php");
$sel="select id,likes,client_id from cs_users cs join (select member_id,likes from cs_fb_share_users where likes!='' ) as cu on cu.member_id=cs.id where cs.is_fb='1'";

$res_sel=re_db_query($sel);
while($row_sel=re_db_fetch_array($res_sel))
{
    $likes=explode(",",$row_sel['likes']);
    
    foreach($likes as $key=>$val)
    {
      if($val!='')
      {
        
         re_db_query("insert into cs_member_pages_like (member_id,page_id,client_id) values ('".mysql_real_escape_string($row_sel['id'])."',(select id from cs_like_pages where page_title='".mysql_real_escape_string($val)."'),'".$row_sel['client_id']."')");
         
       
     }     
    }
    
} 

exit("Dilip it is all over");
?>