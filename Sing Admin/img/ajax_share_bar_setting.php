<?php
include("include/config.php");


$new_social_arr=array();
$all_sel_social=$_GET['all_sel_social'];
$all_sel_social_odr=$_GET['all_sel_social_odr'];
$counter_type=$_GET['counter_type'];
$btn_style=$_GET['btn_style'];
$odr_id=$_GET['odr_id'];
$odr_type=$_GET['odr_type'];

$all_sel_social_arr=explode(",",$all_sel_social);
$all_sel_social_odr_arr=explode(",",$all_sel_social_odr);

    if($odr_type=="up") { $new_odr=($odr_id-1); }
    else if($odr_type=="down") { $new_odr=($odr_id+1); }



    if((($odr_type=="up" && $odr_id!="1") ||  ($odr_type=="down" && $odr_id!=(count($all_sel_social_arr)-1))) && $odr_id<=(count($all_sel_social_arr)-1))
    {
        $temp=$all_sel_social_arr[$new_odr];
        $all_sel_social_arr[$new_odr]=$all_sel_social_arr[$odr_id];
        $all_sel_social_arr[$odr_id]=$temp;
    }
    
    $img_div=""; $social_div=""; $i=0; 
    foreach($all_sel_social_arr as $key => $val)
    {
        if($val!="")
        {
            $new_social_arr[]=$val; $i++;
            $social_sql=re_db_query("select * from cs_social_network_master where social_id='".$val."'");
            $social_rec=re_db_fetch_array($social_sql);
            
            if(($btn_style=="1" || $btn_style=="2") && $social_rec['short_name']=="li") {
                $img_div.='<img style="float: left; margin-right: 5px; " src="'.SITE_URL.'img/social_icon/'.$social_rec['short_name'].'_share_icon_'.$counter_type.'.jpg" alt="" title="" />';
            }
            else {
                $img_div.='<img style="float: left; margin-right: 5px; " src="'.SITE_URL.'img/social_icon/'.$social_rec['short_name'].'_share_btn_'.$counter_type.'.jpg" alt="" title="" />';
            }
            
            $social_div.='<div style="margin-bottom: 5px;">
                            <input type="checkbox" name="share_button['.$i.']" id="share_button_'.$i.'" value="'.$val.'" checked="checked" onclick="call_manage_display()" />&nbsp;&nbsp;'.$social_rec['social_name'].'
                            <span style="float: right;">
                                <a href="javascript:void(0);" onclick="call_ordering(\''.$i.'\',\'up\')">up</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="call_ordering(\''.$i.'\',\'down\')">down</a>
                            </span>
                            <input type="hidden" name="short_order['.$i.']" id="short_order_'.$i.'" value="'.$i.'" /> 
                        </div>';
        }
    }
    
    $social_sql=re_db_query("select * from cs_social_network_master where social_id not in ('".implode("','",$new_social_arr)."') and is_display='1'");
    if(re_db_num_rows($social_sql)>0)
    {
        while($social_rec=re_db_fetch_array($social_sql))
        {
            $i++;
            $social_div.='<div style="margin-bottom: 5px;">
                            <input type="checkbox" name="share_button['.$i.']" id="share_button_'.$i.'" value="'.$social_rec['social_id'].'" onclick="call_manage_display()" />&nbsp;&nbsp;'.$social_rec['social_name'].'
                            <span style="float: right;">
                                <a href="javascript:void(0);" onclick="call_ordering(\''.$i.'\',\'up\')">up</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="call_ordering(\''.$i.'\',\'down\')">down</a>
                            </span>
                            <input type="hidden" name="short_order['.$i.']" id="short_order_'.$i.'" value="'.$i.'" /> 
                        </div>';
        }
    }


    $social_div.='<input type="hidden" name="odr_id" id="odr_id" value="" />
                <input type="hidden" name="odr_type" id="odr_type" value="" />
                <input type="hidden" name="total_social" id="total_social" value="4" />';
    
    echo $img_div.'~!##!~'.$social_div;
?>