<?php 
include("include/config.php");
ini_set("display_errors","0");
if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }

$color_arr=array('#4875B4','#3b5998','#FF9E01','#FCD202','#F8FF01','#B0DE09','#04D215','#0D8ECF','#0D52D1','#2A0CD0','#8A0CCF','#CD0D74','#754DEB','#DDDDDD','#DDDDDD','#333333','#000000');

$err=array();

$title_1="";
$title_2="";

    if(isset($_GET['stype']) && $_GET['stype']=='totalshare')
    {
        $title_1="Total";
        $title_2=" Shares";
        
    }
    else if(isset($_GET['stype']) && $_GET['stype']=='sbp')
    {
        $title_1="Shares By ";
        $title_2="Providers";
    }
    else if(isset($_GET['stype']) && $_GET['stype']=='msu')
    {
        $title_1="Most Shared ";
        $title_2="URLs";
    }
    else if(isset($_GET['stype']) && $_GET['stype']=='trs')
    {
        $title_1="Traffic Referred ";
        $title_2="to Site ";
    }
    else if(isset($_GET['stype']) && $_GET['stype']=='tlp')
    {
        $title_1="Top 10 liked ";
        $title_2="FB Pages";
    }
    /*else if(isset($_GET['utype']) && $_GET['utype']=='dmg')
    {
        $title_1="Demographics";
        $title_2="";
    }*/
    


include("header.php");
//include_once("common_header.php");
?>
<!-- include js files for charts -->
<!--script type="text/javascript" src="http://www.amcharts.com/lib/3/amcharts.js"></script-->
<script src="amcharts/amcharts.js" type="text/javascript"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/serial.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/pie.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/themes/none.js"></script>


<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
        <ol class="breadcrumb">
            <li>YOU ARE HERE</li>
            <li>Social Sharings</li>
            <li class="active"><?php echo $title_1.$title_2;?></li>
        </ol>
        <!--h1 class="page-title"><span class="fw-semi-bold">New Registered Users</span></h1-->
        <div class="row">
            <div class="col-md-12">
                <section class="widget">
                    <header>
                        <h4><?php echo $title_1;?><small><?php echo $title_2;?></small></h4>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <div style="border: 1px solid;border-radius: 4px;padding:5px;">
                            <form name="nru_filter" id="nru_filter" action="" method="post">
                            <?php if($_GET['stype']!='tlp') { ?>
                                <div>
                                    <div style="float: left;width:auto;">
                                        <div style="float: left;width:auto;margin-left: 10px">Range</div>
                                        <div style="float: left;width:auto;padding-left: 10px;">                                
                                            <select name="day_range" id="day_range" onchange="call_set_date(this.value)">
                                                <option value="0"<?php if(isset($_POST['day_range']) && $_POST['day_range']=="0") { echo ' selected="selected"';}?>>Today</option>
                                                <option value="1"<?php if(isset($_POST['day_range']) && $_POST['day_range']=="1") { echo ' selected="selected"';}?>>Yesterday</option>
                                                <option value="6"<?php if(isset($_POST['day_range']) && $_POST['day_range']=="6") { echo ' selected="selected"';}?>>Last 7 Days</option>
                                                <option value="30"<?php if(isset($_POST['day_range']) && $_POST['day_range']=="30") { echo ' selected="selected"';}?>>Last 30 Days</option>
                                                <option value="-1"<?php if(isset($_POST['day_range']) && $_POST['day_range']=="-1") { echo ' selected="selected"';}?>>Custom</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="padding-left: 10px;float:left;">
                                        <div style="margin-left: 10px;float:left;">Start Date</div>
                                        <div style="padding-left: 10px;float:left;">
                                            <input style="padding-left: 5px; width: 90px;" name="csdate_2" id="datetimepicker1" type="text" value="<?php if(isset($_POST['day_range']) && $_POST['day_range']<=1 && isset($_POST['csdate_2'])) {echo $_POST['csdate_2'];} else if(!isset($_POST['csdate_2'])) { echo date("m-d-Y");} ?>" onblur="call_set_day_rande();"/>
                                        </div>
                                    </div>
                                    <div style="padding-left: 10px;float:left;">
                                        <div style="margin-left: 10px;float:left;">End Date</div>
                                        <div style="padding-left: 10px;float:left;">
                                            <input style="padding-left: 5px; width: 90px;" name="csdate_3" id="datetimepicker2" type="text" value="<?php if(isset($_POST['day_range']) && $_POST['day_range']<=1 && isset($_POST['csdate_3'])) {echo $_POST['csdate_3'];} else if(!isset($_POST['csdate_3'])) { echo date("m-d-Y");} ?>" onblur="call_set_day_rande()"/>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if($_GET['stype']=='tlp')
                                {
                                    ?>
                                    <div style="display: block;float:left;width:auto;margin-left:10px;">
                                        <div style="float:left;width:auto;padding-left: 10px;">Age</div>
                                        <div style="float: left;width:auto;padding-left: 10px;">
                                            <select name="age_range" id="age_range">
                                                <option value="">All</option>
                                                <option value="1"<?php if(isset($_POST['age_range']) && $_POST['age_range']=="1") { echo ' selected="selected"';}?>>Under 13</option>
                                                <option value="2"<?php if(isset($_POST['age_range']) && $_POST['age_range']=="2") { echo ' selected="selected"';}?>>13-17</option>
                                                <option value="3"<?php if(isset($_POST['age_range']) && $_POST['age_range']=="3") { echo ' selected="selected"';}?>>18-34</option>
                                                <option value="4"<?php if(isset($_POST['age_range']) && $_POST['age_range']=="4") { echo ' selected="selected"';}?>>35-49</option>
                                                <option value="5"<?php if(isset($_POST['age_range']) && $_POST['age_range']=="5") { echo ' selected="selected"';}?>>50+</option>
                                                <option value="6"<?php if(isset($_POST['age_range']) && $_POST['age_range']=="6") { echo ' selected="selected"';}?>>Not Provided</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="float: left;width:auto;margin-left:10px;">
                                        <div style="float: left;width:auto;padding-left: 10px;">Gender</div>
                                        <div style="float: left;width:auto;padding-left: 10px;">
                                            <select name="gender" id="gender">
                                                <option value="">All</option>
                                                <option value="1"<?php if(isset($_POST['gender']) && $_POST['gender']=="1") { echo ' selected="selected"';}?>>Male</option>
                                                <option value="2"<?php if(isset($_POST['gender']) && $_POST['gender']=="2") { echo ' selected="selected"';}?>>Female</option>
                                                <option value="3"<?php if(isset($_POST['gender']) && $_POST['gender']=="3") { echo ' selected="selected"';}?>>Not Provided</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php 
                                }?>
                                <br style="clear: both;" />
                                <div style="float: right;">
                                    <div style="margin-top: 15px;" style="float: left;" ></div>
                                    <div  style="float:right;padding-top: 15px; padding-bottom: 10px;">
                                        &nbsp;&nbsp;&nbsp;
                                        <input type="submit" name="btn_search" id="btn_search" style="font-weight: bold;" value="Show Result" />&nbsp;
                                        <input type="button" name="btn_clear" id="btn_clear" value="Clear" onclick="call_resate_val()" />
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <br style="clear: both" />
                            </form>
                        </div>
                        <script type="text/javascript">
                            function call_set_date(val)
                            {
                                var cur_date="<?php echo date('m-d-Y');?>";
                                
                                if(val=="0")
                                {
                                    document.getElementById('datetimepicker1').value=cur_date;
                                    document.getElementById('datetimepicker2').value=cur_date;
                                }
                                
                                else if(val!="-1")
                                {
                                    document.getElementById('datetimepicker1').value="";
                                    document.getElementById('datetimepicker2').value="";
                                }
                            }
                            
                            function call_set_day_rande()
                            {
                                document.getElementById('day_range').value="-1";
                            }
                            
                            function call_resate_val()
                            {
                                var cur_date="<?php echo date('m-d-Y');?>";
                                <?php if($stype!='tlp') { ?>
                                document.getElementById('day_range').value="0";
                                document.getElementById('datetimepicker1').value=cur_date;
                                document.getElementById('datetimepicker2').value=cur_date;
                                <?php } ?>
                                if(document.getElementById('age_range')) { document.getElementById('age_range').value=""; }
                                if(document.getElementById('gender')) { document.getElementById('gender').value=""; }
                            }
                            
                            <?php if(!isset($_POST['btn_search']))
                            {
                                ?>
                                function auto_call()
                                {
                                    <?php if($stype!='tlp') { ?>
                                    document.getElementById('day_range').value="30";
                                    document.getElementById('datetimepicker1').value="";
                                    document.getElementById('datetimepicker2').value="";
                                    <?php } ?>
                                    document.getElementById('btn_search').click();
                                }
                                auto_call();
                                <?php 
                            } ?>
                        </script>
                    </div>
                </section>
                
                <?php 
                $stypearr=array('totalshare','sbp','msu','trs');
                if( (isset($_GET['stype']) && in_array($_GET['stype'],$stypearr))  && isset($_POST['btn_search']))
                {
                    $dateRange=""; $ageRange="";
                    $grp_sql=($_GET['stype']!='msu')?' group by share_date':' group by shared_url';
                    $ord_sql=($_GET['stype']!='msu')?' order by share_date':' order by total_shared desc';
                    if($stype!='trs')
                    {
                        $select_fb_main="select count(*) as total, 'Facebook' as provider,cs.member_id,date_format(cs.date_time,'%Y-%m-%d') as share_date,cs.url as shared_url from cs_fb_share cs join (select member_id,birthday,gender from cs_fb_share_users where client_id='".$_SESSION['admin_id']."') as cu on cu.member_id=cs.member_id  where cs.client_id='".$_SESSION['admin_id']."'";
                        $select_li_main="select count(*) as total, 'LinkedIn' as provider,cl.member_id,date_format(cl.datetime,'%Y-%m-%d') as share_date,cl.share_url as shared_url from cs_li_share cl join (select member_id,concat(byear,'-',bmonth,'-',bday) as birthday,byear from cs_li_data where client_id='".$_SESSION['admin_id']."') as cu on cu.member_id=cl.member_id where cl.client_id='".$_SESSION['admin_id']."'";
                    }
                    else                    
                    {
                        $grp_sql=' group by clicked_date';
                        $ord_sql=' order by clicked_date desc';
                        
                        $select_fb_main="select count(*) as total, 'Facebook' as provider,cs.shared_by,date_format(cs.date_time,'%Y-%m-%d') as clicked_date from cs_share_clicked cs join (select member_id,birthday,gender from cs_fb_share_users where client_id='".$_SESSION['admin_id']."') as cu on cu.member_id=cs.shared_by  where cs.client_id='".$_SESSION['admin_id']."' and cs.is_from='1'";
                        $select_li_main="select count(*) as total, 'LinkedIn' as provider,cl.shared_by,date_format(cl.date_time,'%Y-%m-%d') as clicked_date from cs_share_clicked cl join (select member_id,concat(byear,'-',bmonth,'-',bday) as birthday,byear from cs_li_data where client_id='".$_SESSION['admin_id']."') as cu on cu.member_id=cl.shared_by where cl.client_id='".$_SESSION['admin_id']."' and cl.is_from='2'";
                    }
                    
                    if($_POST['day_range']=='0' ||  $_POST['day_range']=='1')
                    { 
                        $select_fb_main.=" and datediff(current_date,date_time) ='".$_POST['day_range']."'";
                        $select_li_main.=($stype=='trs')?" and datediff(current_date,date_time) ='".$_POST['day_range']."'":" and datediff(current_date,datetime) ='".$_POST['day_range']."'"; 
                    }
                    else if($_POST['day_range'] > 1) 
                    { 
                        $select_fb_main .=" and datediff(current_date,date_time) <='".$_POST['day_range']."'"; 
                        $select_li_main .=($stype=='trs')?" and datediff(current_date,date_time) <='".$_POST['day_range']."'":" and datediff(current_date,datetime) <='".$_POST['day_range']."'";
                    }
                    if(isset($_POST['csdate_2']) && $_POST['csdate_2']!='' && isset($_POST['csdate_3']) && $_POST['csdate_3']!='') 
                    { 
                        $select_fb_main.=" and date_format(date_time,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'"; 
                        $select_li_main.=($stype=='trs')?" and date_format(date_time,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'":" and date_format(datetime,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'";
                    }
           
                    if($_POST['age_range']=='1') { $select_fb_main.=" and (year(current_date)-year(birthday)) < 13"; }
                    else if($_POST['age_range']=='2') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 13 and (year(current_date)-year(birthday)) <= 17"; }
                    else if($_POST['age_range']=='3') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 18 and (year(current_date)-year(birthday)) <= 34"; }
                    else if($_POST['age_range']=='4') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 35 and (year(current_date)-year(birthday)) <= 49"; }
                    else if($_POST['age_range']=='5') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 50"; }
                    else if($_POST['age_range']=='6') { $select_fb_main.=" and year(birthday)='0000'"; }
                    
                    if($_POST['age_range']=='1') { $select_li_main.=" and (year(current_date)-byear) < 13 and byear!='0000'"; }
                    else if($_POST['age_range']=='2') { $select_li_main.=" and (year(current_date)-byear) >= 13 and (year(current_date)-byear) <= 17 and byear!='0000'"; }
                    else if($_POST['age_range']=='3') { $select_li_main.=" and (year(current_date)-byear) >= 18 and (year(current_date)-byear) <= 34 and byear!='0000'"; }
                    else if($_POST['age_range']=='4') { $select_li_main.=" and (year(current_date)-byear) >= 35 and (year(current_date)-byear) <= 49 and byear!='0000'"; }
                    else if($_POST['age_range']=='5') { $select_li_main.=" and (year(current_date)-byear) >= 50 and byear!='0000'"; }
                    else if($_POST['age_range']=='6') { $select_li_main.=" and byear='0000'"; }

                    
                    if($_POST['gender']!='')
                    {
                        if($_POST['gender']=='1' || $_POST['gender']=='2' )
                        {
                            $select_fb_main.=($_POST['gender']=='1')?" and gender='male' ":" and gender='female'";
                        }
                        if($_POST['gender']=='3')
                        {
                            $select_fb_main.= " and gender not in ('male','female')";
                        }
                    }
                   // $gender_sql=($_POST['gender']!='')?($_POST['gender']=='1')?" and gender='male' ":" and gender='female'":'';
                    //$select_fb_main.=$gender_sql;
                    //$select_gp_main.=$gender_sql;
                    
                    $select_fb_main .= $grp_sql;
                    $select_li_main .= $grp_sql;
                    
                    
                    $select_main .=$select_fb_main." union all ".$select_li_main;
                    
                    
                    $select_main .=($stype=='trs')?' order by clicked_date desc':' order by share_date desc';
                    
                    $msu_query=" select sum(total) as total_shared,shared_url from ( ".$select_main .") as t group by shared_url ".$ord_sql."";
                    
                    if($stype!='msu')
                    {
                        
                    $res_grph_1=re_db_query($select_main);
                    
                    $total_shares=array();
                    $total_shares_dates=array();
                   
                    while($row_share=re_db_fetch_array($res_grph_1))
                    {
                        $date_field=($stype=='trs')?$row_share['clicked_date']:$row_share['share_date'];
                        $total_shares[$date_field][$row_share['provider']][]=$row_share['total'];
                        
                    }
                    $total=sizeof($total_shares);
                    }
                    ?>
                    <section class="widget">
                        <header>
                            <h4><?php echo $title_1;?><small><?php echo $title_2;?></small>&nbsp;&nbsp;<span id="total_shares"></span></h4>
                            <div class="widget-controls">
                                <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </header>
                        <div class="widget-body">
 <?php if($stype!='msu') { ?>                       
<script type="text/javascript">
var chart = AmCharts.makeChart("barChartDiv", {
    "theme": "none",
    "type": "serial",
	"startDuration": 2,
     <?php if($stype=='totalshare') { ?>
     "dataProvider": [
    <?php $i=0;
    $final_total=0;
    foreach($total_shares as $date=>$pro_arr)
    {
        
        $total_shares=(is_array($pro_arr['Facebook']))?array_sum($pro_arr['Facebook']):'0';
        $total_shares +=(is_array($pro_arr['LinkedIn']))?array_sum($pro_arr['LinkedIn']):'0';
        $final_total +=$total_shares;
        $i++; ?>
        {
            "provider": "<?php echo date('m/d/Y',strtotime($date));?>",
            "users": <?php echo $total_shares;?>,
            "color": "<?php echo $color_arr[$i-1];?>"
        }<?php if($i<$total) {?>,<?php }
    }?>
    ],   
    <?php } ?>
    <?php if($stype=='sbp' || $stype=='trs' ) { ?>
     "depth3D":20,
    "angle":30,   
    "legend": {
        "horizontalGap": 10,
        "maxColumns": 1,
        "position": "right",
		"useGraphSettings": true,
		"markerSize": 10
    },
    "dataProvider": [
    <?php $i=0;
    $final_total=0;
    foreach($total_shares as $date=>$pro_arr)
    {
        
        $total_shares=(is_array($pro_arr['Facebook']))?array_sum($pro_arr['Facebook']):'0';
        $total_shares +=(is_array($pro_arr['LinkedIn']))?array_sum($pro_arr['LinkedIn']):'0';
        $final_total +=$total_shares;
        $i++; ?>
        {
            "provider": "<?php echo date('m/d/Y',strtotime($date));?>",
            "Facebook": <?php echo (is_array($pro_arr['Facebook']))?array_sum($pro_arr['Facebook']):'0';?>,
            "LinkedIn": <?php echo (is_array($pro_arr['LinkedIn']))?array_sum($pro_arr['LinkedIn']):'0';?>
        }<?php if($i<$total) {?>,<?php }
    }?>
    ],
    <?php } ?>
    <?php if($stype=='totalshare') { ?>
    "valueAxes": [{
        "position": "left",
        "axisAlpha":0,
        "gridAlpha":0         
    }],
    <?php } ?>
    
    <?php if($stype=='sbp' || $stype=='trs' ) { ?>
    "valueAxes": [{
        "stackType": "regular",
        "axisAlpha": 0.3,
        "gridAlpha": 0
    }],
    
    <?php } ?>
    <?php if($stype=='totalshare') { ?>
    "graphs": [{
        "balloonText": "[[category]]: <b>[[value]]</b>",
        "colorField": "color",
        "fillAlphas": 0.85,
        "lineAlpha": 0.1,
        "type": "column",
        "topRadius":1,
        "valueField": "users"
    }],
    <?php } ?> 
    <?php if($stype=='sbp' || $stype=='trs' ) { ?>
     "graphs": [{
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "Facebook",
        "type": "column",
		"color": "#3b5998",
        "valueField": "Facebook"
    }, {
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "LinkedIn",
        "type": "column",
		"color": "#000000",
        "valueField": "LinkedIn"
    }],
   
    <?php } ?>
    <?php if($stype=='totalshare') { ?>
    "depth3D": 40,
	"angle": 30,
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    }, 
    <?php } ?>   
    "categoryField": "provider",
    "categoryAxis": {
        "gridPosition": "start",
        "axisAlpha":0,
        "gridAlpha":0,
        "position":"left",
        "labelRotation":45
    },
},0);
document.getElementById('total_shares').innerHTML='<b>(<?php echo $final_total;?>)&nbsp;&nbsp;</b>';


</script>

                            <div id="barChartDiv" style="width: <?php if($total>2 && $total<=7) {echo ($total*110).'px;';} else if($total>7) { echo '100%;';} else {echo '350px;';}?> height: 400px;"></div>
<?php } ?>

                   <?php if($stype=='msu') { ?>
                    
                     <table class="table table-striped">
                            <thead>
                            <tr>
                                <!--th>
                                    <div class="checkbox">
                                        <input id="checkbox1" type="checkbox" data-check-all>
                                        <label for="checkbox1"></label>
                                    </div>
                                </th-->
                                <th>URL</th>
                                <th>Share Count</th>
                                <th>Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                                <?php 
                                $res_msu=re_db_query($msu_query);
                                if(re_db_num_rows($res_msu)>0)
                                {
                                    $i=1;
                                    while($row_msu=re_db_fetch_array($res_msu))
                                    {	 
                                        $i++;
                                        ?>
                                        <tr>
                                            <!--td>
                                                <div class="checkbox">
                                                    <input id="checkbox<?php //echo $i;?>" type="checkbox" />
                                                    <label for="checkbox<?php //echo $i;?>"></label>
                                                </div>
                                            </td-->
                                            <td><?php echo re_db_output($row_msu['shared_url']); ?></td>                                            
                                            <td><?php echo re_db_output($row_msu['total_shared']); ?></td>
                                            <td><a href="#">View Detail</a></td>
                                        </tr>
                                        <?php 
                                    }
                                }
                                else { ?>
                                    <tr><td style="text-align: center;" class="subheading" colspan="4">No Record Found</td></tr>
                                <?php } ?>                            
                                <tr>
                                    <td colspan="4" style="text-align: center;"><?php echo isset($prev)?$prev:''; ?>&nbsp;&nbsp;<?php echo isset($showingpage)?$showingpage:''; ?>&nbsp;&nbsp;<?php echo isset($next)?$next:''; ?></td>
                                </tr>
                            </tbody>
                        </table>
                   <?php } ?>         
                        </div>
                    </section>
                   
                    <?php 
                } 
                
                if( (isset($_GET['stype']) && $_GET['stype']=='tlp')  && isset($_POST['btn_search']))
                {
                    $select_fb_main="";
                    if($_POST['age_range']=='1') { $select_fb_main.=" and (year(current_date)-year(birthday)) < 13"; }
                    else if($_POST['age_range']=='2') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 13 and (year(current_date)-year(birthday)) <= 17"; }
                    else if($_POST['age_range']=='3') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 18 and (year(current_date)-year(birthday)) <= 34"; }
                    else if($_POST['age_range']=='4') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 35 and (year(current_date)-year(birthday)) <= 49"; }
                    else if($_POST['age_range']=='5') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 50"; }
                    else if($_POST['age_range']=='6') { $select_fb_main.=" and year(birthday)='0000'"; }
                    if($_POST['gender']!='')
                    {
                        if($_POST['gender']=='1' || $_POST['gender']=='2' )
                        {
                            $select_fb_main.=($_POST['gender']=='1')?" and gender='male' ":" and gender='female'";
                        }
                        if($_POST['gender']=='3')
                        {
                            $select_fb_main.= " and gender not in ('male','female')";
                        }
                    }
                 $sel_tlp="select page_title,id,fb_page_id,cp.total from cs_like_pages cl join (select count(*) as total,page_id from cs_member_pages_like cpl join (select member_id,birthday,gender from cs_fb_share_users where client_id='".$_SESSION['admin_id']."' ".$select_fb_main.") as cup on cup.member_id=cpl.member_id where cpl.client_id='".$_SESSION['admin_id']."' group by page_id) as cp on cp.page_id=cl.id order by total desc,page_title asc limit 10";
                 
                 $res_tlp=re_db_query($sel_tlp);
                 $total=re_db_num_rows($res_tlp);    
                ?>
                <section class="widget">
                        <header>
                            <h4><?php echo $title_1;?><small><?php echo $title_2;?></small>&nbsp;&nbsp;<span id="total_shares"></span></h4>
                            <div class="widget-controls">
                                <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </header>
                        <div class="widget-body">
                        
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <!--th>
                                    <div class="checkbox">
                                        <input id="checkbox1" type="checkbox" data-check-all>
                                        <label for="checkbox1"></label>
                                    </div>
                                </th-->
                                <th>Page</th>
                                <th>No. of Likes</th>
                                <th>View</th>
                            </tr>
                            </thead>
                            <tbody>
                         <?php 
                        if(re_db_num_rows($res_tlp) > 0)
                        {
                        while($row_tlp=re_db_fetch_array($res_tlp))  { ?>
                        
                        <tr>
                                            
                                            <td><?php echo re_db_output($row_tlp['page_title']); ?></td>                                            
                                            <td><?php echo re_db_output($row_tlp['total']); ?></td>
                                            <td><a href="<?php echo ($row_tlp['fb_page_id'])?"https://www.facebook.com/".$row_tlp['fb_page_id']."":"#";  ?>" target="_blank">View</a></td>
                                        </tr>
                                        
                        
                        <?php } } else {?>
                         <tr><td style="text-align: center;" class="subheading" colspan="4">No Record Found</td></tr>
                        <?php } ?>
                        </div>
                
                <?php     
                }    
                 ?>
            </div>
        </div>
    </main>
</div>
<?php include_once("common_lib.php"); ?>
</body>
</html>