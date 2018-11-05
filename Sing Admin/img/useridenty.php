<?php 
include("include/config.php");
if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }

$color_arr=array('#FF0F00','#FF6600','#FF9E01','#FCD202','#F8FF01','#B0DE09','#04D215','#0D8ECF','#0D52D1','#2A0CD0','#8A0CCF','#CD0D74','#754DEB','#DDDDDD','#DDDDDD','#333333','#000000');

$err=array();

$title_1="";
$title_2="";

    if(isset($_GET['utype']) && $_GET['utype']=='nru')
    {
        $title_1="New Registered ";
        $title_2="Users";
    }
    else if(isset($_GET['utype']) && $_GET['utype']=='dlu')
    {
        $title_1="Daily Logins ";
        $title_2="Users";
    }
    else if(isset($_GET['utype']) && $_GET['utype']=='nup')
    {
        $title_1="New Users by ";
        $title_2="Provider";
    }
    else if(isset($_GET['utype']) && $_GET['utype']=='lup')
    {
        $title_1="Logged-in Users by ";
        $title_2="Provider";
    }
    else if(isset($_GET['utype']) && $_GET['utype']=='dmg')
    {
        $title_1="Demographics";
        $title_2="";
    }
    else if(isset($_GET['utype']) && $_GET['utype']=='rbp')
    {
        $title_1="Revenue by ";
        $title_2="Provider";
    }
    


include("header.php");
//include_once("common_header.php");
?>
<!-- include js files for charts -->
<!--script type="text/javascript" src="http://www.amcharts.com/lib/3/amcharts.js"></script-->
<script src="amcharts/amcharts.js" type="text/javascript"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/serial.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/pie.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/themes/none.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/exporting/amexport_combined.js"></script>
<!--script src="amcharts/exporting/amexport.js" type="text/javascript"></script>
<script src="amcharts/exporting/rgbcolor.js" type="text/javascript"></script>
<script src="amcharts/exporting/canvg.js" type="text/javascript"></script>
<script src="amcharts/exporting/filesaver.js" type="text/javascript"></script-->

<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
        <ol class="breadcrumb">
            <li>YOU ARE HERE</li>
            <li>User Identities</li>
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
                                <?php if($_GET['utype']!='dmg' && $_GET['utype']!='rbp')
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
                                document.getElementById('day_range').value="0";
                                document.getElementById('datetimepicker1').value=cur_date;
                                document.getElementById('datetimepicker2').value=cur_date;
                                if(document.getElementById('age_range')) { document.getElementById('age_range').value=""; }
                                if(document.getElementById('gender')) { document.getElementById('gender').value=""; }
                            }
                            
                            <?php if(!isset($_POST['btn_search']) && $_GET['utype']!='dlu')
                            {
                                ?>
                                function auto_call()
                                {
                                    document.getElementById('day_range').value="30";
                                    document.getElementById('datetimepicker1').value="";
                                    document.getElementById('datetimepicker2').value="";
                                    document.getElementById('btn_search').click();
                                }
                                auto_call();
                                <?php 
                            } 
                            else if(!isset($_POST['btn_search']) && $_GET['utype']=='dlu')
                            {
                                ?>
                                function auto_call()
                                {
                                    document.getElementById('day_range').value="6";
                                    document.getElementById('datetimepicker1').value="";
                                    document.getElementById('datetimepicker2').value="";
                                    document.getElementById('btn_search').click();
                                }
                                auto_call();
                                <?php 
                            } ?>
                        </script>
                    </div>
                </section>
                <?php if(isset($_GET['utype']) && $_GET['utype']=='nru' && isset($_POST['btn_search']))
                {
                    $dateRange=""; $ageRange="";
                    
                    $select_fb_main="select '1' as is_from, reg_on from cs_fb_share_users where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_li_main="select '2' as is_from, reg_on from cs_li_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_gp_main="select '3' as is_from, reg_on from cs_gp_users where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_yh_main="select '5' as is_from, reg_on from cs_yahoo_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_ig_main="select '6' as is_from, reg_on from cs_ig_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";

                    
                    $select_main="";
                    if($_POST['day_range']=='0' ||  $_POST['day_range']=='1') { $select_main=" and datediff(current_date,reg_on) ='".$_POST['day_range']."'"; }
                    else if($_POST['day_range'] > 1)  { $select_main=" and datediff(current_date,reg_on) <='".$_POST['day_range']."'"; }
                    if(isset($_POST['csdate_2']) && $_POST['csdate_2']!='' && isset($_POST['csdate_3']) && $_POST['csdate_3']!='')  { $select_main.=" and date_format(reg_on,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'"; }
                    $select_fb_main.=$select_main;
                    $select_li_main.=$select_main;
                    $select_gp_main.=$select_main;

                    if($_POST['age_range']=='1') { $select_fb_main.=" and (year(current_date)-year(birthday)) < 13"; }
                    else if($_POST['age_range']=='2') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 13 and (year(current_date)-year(birthday)) <= 17"; }
                    else if($_POST['age_range']=='3') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 18 and (year(current_date)-year(birthday)) <= 34"; }
                    else if($_POST['age_range']=='4') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 35 and (year(current_date)-year(birthday)) <= 49"; }
                    else if($_POST['age_range']=='5') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 50"; }
                    
                    $select_age_main="";
                    if($_POST['age_range']=='1') { $select_age_main=" and (year(current_date)-byear) < 13"; }
                    else if($_POST['age_range']=='2') { $select_age_main=" and (year(current_date)-byear) >= 13 and (year(current_date)-byear) <= 17"; }
                    else if($_POST['age_range']=='3') { $select_age_main=" and (year(current_date)-byear) >= 18 and (year(current_date)-byear) <= 34"; }
                    else if($_POST['age_range']=='4') { $select_age_main=" and (year(current_date)-byear) >= 35 and (year(current_date)-byear) <= 49"; }
                    else if($_POST['age_range']=='5') { $select_age_main=" and (year(current_date)-byear) >= 50"; }
                    $select_li_main.=$select_age_main;
                    $select_gp_main.=$select_age_main;
                    $select_ig_main.=$select_age_main;
                    $select_yh_main.=$select_age_main;
                    
                    
                    $gender_sql="";
                    if(isset($_POST['gender']) && $_POST['gender']=='1') { $gender_sql=" and gender='male' "; $select_li_main.=" and id<0 "; $select_ig_main.=" and csig.id <0 "; }
                    else if(isset($_POST['gender']) && $_POST['gender']=='2') { $gender_sql=" and gender='female' "; $select_li_main.=" and id<0 "; $select_ig_main.=" and csig.id <0 "; }
                    $select_fb_main.=$gender_sql;
                    $select_gp_main.=$gender_sql;
                    $select_yh_main.=$gender_sql;

                    $select_main="select sum(if(a.is_from=1,1,0)) as fb_user, sum(if(a.is_from=2,1,0)) as li_user, sum(if(a.is_from=3,1,0)) as gp_user, sum(if(a.is_from=5,1,0)) as yh_user, sum(if(a.is_from=6,1,0)) as ig_user, date_format(a.reg_on,'%m-%d-%Y') as login_date from 
                                (
                                    ".$select_fb_main." union all ".$select_li_main." union all ".$select_gp_main." union all ".$select_yh_main." union all ".$select_ig_main." 
                                ) as a group by date_format(a.reg_on,'%Y-%m-%d')";
                    
                    $res_grph=re_db_query($select_main);
                    $total=re_db_num_rows($res_grph);
                    ?>
                    <section class="widget">
                        <header>
                            <h4><?php echo $title_1;?><small><?php echo $title_2;?></small></h4>
                            <div class="widget-controls">
                                <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </header>
                        <div class="widget-body">
<script type="text/javascript">
var chart = AmCharts.makeChart("nruBarChartDiv", {
    "type": "serial",
	"theme": "none",
    "startDuration": 2,
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
    while($row_main=re_db_fetch_array($res_grph))
    {
        $i++; ?>
        {
            "date": "<?php echo $row_main['login_date'];?>",
            "facebook": <?php echo $row_main['fb_user'];?>,
            "google": <?php echo $row_main['gp_user'];?>,
            "linkedin": <?php echo $row_main['li_user'];?>,
            "yahoo": <?php echo $row_main['yh_user'];?>,
            "instagram": <?php echo $row_main['ig_user'];?>
        }<?php if($i<$total) {?>,<?php }
    }?>
    ],
    "valueAxes": [{
        "stackType": "regular",
        "axisAlpha": 0.3,
        "gridAlpha": 0
    }],
    "graphs": [{
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "Facebook",
        "type": "column",
		"color": "#000000",
        "valueField": "facebook"
    }, {
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "Google+",
        "type": "column",
		"color": "#000000",
        "valueField": "google"
    }, {
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "LinkedIn",
        "type": "column",
		"color": "#000000",
        "valueField": "linkedin"
    }, {
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "Yahoo",
        "type": "column",
		"color": "#000000",
        "valueField": "yahoo"
    }, {
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "Instagram",
        "type": "column",
		"color": "#000000",
        "valueField": "instagram"
    }],
    "categoryField": "date",
    "categoryAxis": {
        "gridPosition": "start",
        "axisAlpha": 0,
        "gridAlpha": 0,
        "position": "left",
        "labelRotation":45
    },
	"exportConfig": {
        "menuTop": '20px',
        "menuRight": '20px',
        "menuItems": [{
            "textAlign": 'left',
            "onclick": function () {},
            "icon": '<?php echo SITE_URL;?>amcharts/images/export.png',
            "iconTitle": 'Save chart as an image',
            "items": [{
                "title": 'JPG',
                "format": 'jpg'
            }, {
                "title": 'PNG',
                "format": 'png'
            }, {
                "title": 'SVG',
                "format": 'svg'
            }, {
                "title": 'PDF',
                "format": 'pdf'
            }]
        }],
        "menuItemOutput":{
            "fileName":"New-Users-by-Provider"
        },
        "menuItemStyle": {
            "backgroundColor": 'transparent',
            "rollOverBackgroundColor": '#EFEFEF',
            "color": '#000000',
            "rollOverColor": '#CC0000',
            "paddingTop": '6px',
            "paddingRight": '6px',
            "paddingBottom": '6px',
            "paddingLeft": '6px',
            "marginTop": '0px',
            "marginRight": '0px',
            "marginBottom": '0px',
            "marginLeft": '0px',
            "textAlign": 'left',
            "textDecoration": 'none'
        }
    }
});
</script>
                            <div id="nruBarChartDiv" style="width: <?php if($total>2 && $total<=7) {echo ($total*110).'px;';} else if($total>7) { echo '100%;';} else {echo '300px;';}?> height: 300px;"></div>
                        </div>
                    </section>
                    <?php 
                } 
                else if(isset($_GET['utype']) && $_GET['utype']=='dlu' && isset($_POST['btn_search']))
                {
                    $dateRange=""; $ageRange="";
                    
                    $select_fb_main="select csl.* from cs_logins as csl, cs_fb_share_users as csfb where csl.is_from='1' and csl.member_id=csfb.member_id and csl.client_id='".$_SESSION['admin_id']."'";
                    $select_li_main="select csl.* from cs_logins as csl, cs_li_data as csli where csl.is_from='2' and csl.member_id=csli.member_id and csl.client_id='".$_SESSION['admin_id']."'";
                    $select_gp_main="select csl.* from cs_logins as csl, cs_gp_users as csgp where csl.is_from='3' and csl.member_id=csgp.member_id and csl.client_id='".$_SESSION['admin_id']."'";
                    $select_yh_main="select csl.* from cs_logins as csl, cs_yahoo_data as csyh where csl.is_from='5' and csl.member_id=csyh.member_id and csl.client_id='".$_SESSION['admin_id']."'";
                    $select_ig_main="select csl.* from cs_logins as csl, cs_ig_data as csig where csl.is_from='6' and csl.member_id=csig.member_id and csl.client_id='".$_SESSION['admin_id']."'";
                    
                    $select_main="";
                    if($_POST['day_range']=='0' ||  $_POST['day_range']=='1') { $select_main=" and datediff(current_date,csl.date_time) ='".$_POST['day_range']."'"; }
                    else if($_POST['day_range'] > 1) { $select_main=" and datediff(current_date,csl.date_time) <='".$_POST['day_range']."'"; }
                    if(isset($_POST['csdate_2']) && $_POST['csdate_2']!='' && isset($_POST['csdate_3']) && $_POST['csdate_3']!='') { $select_main .=" and date_format(csl.date_time,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'"; }
                    $select_fb_main.=$select_main ;
                    $select_li_main.=$select_main ;
                    $select_gp_main.=$select_main ;
           
                    if($_POST['age_range']=='1') { $select_fb_main.=" and (year(current_date)-year(csfb.birthday)) < 13"; }
                    else if($_POST['age_range']=='2') { $select_fb_main.=" and (year(current_date)-year(csfb.birthday)) >= 13 and (year(current_date)-year(birthday)) <= 17"; }
                    else if($_POST['age_range']=='3') { $select_fb_main.=" and (year(current_date)-year(csfb.birthday)) >= 18 and (year(current_date)-year(birthday)) <= 34"; }
                    else if($_POST['age_range']=='4') { $select_fb_main.=" and (year(current_date)-year(csfb.birthday)) >= 35 and (year(current_date)-year(birthday)) <= 49"; }
                    else if($_POST['age_range']=='5') { $select_fb_main.=" and (year(current_date)-year(csfb.birthday)) >= 50"; }
                    
                    $select_age_main="";
                    if($_POST['age_range']=='1') { $select_age_main=" and (year(current_date)-byear) < 13"; }
                    else if($_POST['age_range']=='2') { $select_age_main=" and (year(current_date)-byear) >= 13 and (year(current_date)-byear) <= 17"; }
                    else if($_POST['age_range']=='3') { $select_age_main=" and (year(current_date)-byear) >= 18 and (year(current_date)-byear) <= 34"; }
                    else if($_POST['age_range']=='4') { $select_age_main=" and (year(current_date)-byear) >= 35 and (year(current_date)-byear) <= 49"; }
                    else if($_POST['age_range']=='5') { $select_age_main=" and (year(current_date)-byear) >= 50"; }
                    $select_li_main.=$select_age_main;
                    $select_gp_main.=$select_age_main;
                    $select_ig_main.=$select_age_main;
                    $select_yh_main.=$select_age_main;
                    

                    $gender_sql="";
                    if(isset($_POST['gender']) && $_POST['gender']=='1') { $gender_sql=" and gender='male' "; $select_li_main.=" and csli.id<0 "; $select_ig_main.=" and csig.id <0 "; }
                    else if(isset($_POST['gender']) && $_POST['gender']=='2') { $gender_sql=" and gender='female' "; $select_li_main.=" and csli.id<0 "; $select_ig_main.=" and csig.id <0 "; }
                    $select_fb_main.=$gender_sql;
                    $select_gp_main.=$gender_sql;
                    $select_yh_main.=$gender_sql;
                    
                    
                    $select_main="select sum(if(a.is_from=1,1,0)) as fb_user, sum(if(a.is_from=2,1,0)) as li_user, sum(if(a.is_from=3,1,0)) as gp_user, sum(if(a.is_from=5,1,0)) as yh_user, sum(if(a.is_from=6,1,0)) as ig_user, date_format(a.date_time,'%m-%d-%Y') as login_date from 
                                (
                                    ".$select_fb_main." union all ".$select_gp_main." union all ".$select_li_main." union all ".$select_yh_main." union all ".$select_ig_main." 
                                ) as a group by date_format(a.date_time,'%Y-%m-%d')";
                    $res_grph=re_db_query($select_main);
                    $total=re_db_num_rows($res_grph);
                    ?>
                    <section class="widget">
                        <header>
                            <h4><?php echo $title_1;?><small><?php echo $title_2;?></small></h4>
                            <div class="widget-controls">
                                <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </header>
                        <div class="widget-body">
<script type="text/javascript">
var chart = AmCharts.makeChart("dluBarChartDiv", {
    "type": "serial",
	"theme": "none",
    "startDuration": 2,
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
    while($row_main=re_db_fetch_array($res_grph))
    {
        $i++; ?>
        {
            "date": "<?php echo $row_main['login_date'];?>",
            "facebook": <?php echo $row_main['fb_user'];?>,
            "google": <?php echo $row_main['gp_user'];?>,
            "linkedin": <?php echo $row_main['li_user'];?>,
            "yahoo": <?php echo $row_main['yh_user'];?>,
            "instagram": <?php echo $row_main['ig_user'];?>
        }<?php if($i<$total) {?>,<?php }
    }?>
    ],
    "valueAxes": [{
        "stackType": "regular",
        "axisAlpha": 0.3,
        "gridAlpha": 0
    }],
    "graphs": [{
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "Facebook",
        "type": "column",
		"color": "#000000",
        "valueField": "facebook"
    }, {
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "Google+",
        "type": "column",
		"color": "#000000",
        "valueField": "google"
    }, {
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "LinkedIn",
        "type": "column",
		"color": "#000000",
        "valueField": "linkedin"
    }, {
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "Yahoo",
        "type": "column",
		"color": "#000000",
        "valueField": "yahoo"
    }, {
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "Instagram",
        "type": "column",
		"color": "#000000",
        "valueField": "instagram"
    }],
    "categoryField": "date",
    "categoryAxis": {
        "gridPosition": "start",
        "axisAlpha": 0,
        "gridAlpha": 0,
        "position": "left",
        "labelRotation":45
    },
	"exportConfig": {
        "menuTop": '20px',
        "menuRight": '20px',
        "menuItems": [{
            "textAlign": 'left',
            "onclick": function () {},
            "icon": '<?php echo SITE_URL;?>amcharts/images/export.png',
            "iconTitle": 'Save chart as an image',
            "items": [{
                "title": 'JPG',
                "format": 'jpg'
            }, {
                "title": 'PNG',
                "format": 'png'
            }, {
                "title": 'SVG',
                "format": 'svg'
            }, {
                "title": 'PDF',
                "format": 'pdf'
            }]
        }],
        "menuItemOutput":{
            "fileName":"New-Users-by-Provider"
        },
        "menuItemStyle": {
            "backgroundColor": 'transparent',
            "rollOverBackgroundColor": '#EFEFEF',
            "color": '#000000',
            "rollOverColor": '#CC0000',
            "paddingTop": '6px',
            "paddingRight": '6px',
            "paddingBottom": '6px',
            "paddingLeft": '6px',
            "marginTop": '0px',
            "marginRight": '0px',
            "marginBottom": '0px',
            "marginLeft": '0px',
            "textAlign": 'left',
            "textDecoration": 'none'
        }
    }
});
</script>
                            <div id="dluBarChartDiv" style="width: <?php if($total>2 && $total<=7) {echo ($total*110).'px;';} else if($total>7) { echo '100%;';} else {echo '350px;';}?> height: 300px;"></div>
                        </div>
                    </section>
                    <?php 
                }
                else if(isset($_GET['utype']) && $_GET['utype']=='nup' && isset($_POST['btn_search']))
                {
                    $dateRange=""; $ageRange="";
                    
                    $select_fb_main="select count(*) as total, 'Facebook' as provider from cs_fb_share_users where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_li_main="select count(*) as total, 'LinkedIn' as provider from cs_li_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_gp_main="select count(*) as total, 'Google+' as provider from cs_gp_users where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_yh_main="select count(*) as total, 'Yahoo' as provider from cs_yahoo_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_ig_main="select count(*) as total, 'Instagram' as provider from cs_ig_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    
                    $select_day_rang="";
                    if($_POST['day_range']=='0' ||  $_POST['day_range']=='1') { $select_day_rang=" and datediff(current_date,reg_on) ='".$_POST['day_range']."'"; }
                    else if($_POST['day_range'] > 1) { $select_day_rang=" and datediff(current_date,reg_on) <='".$_POST['day_range']."'"; }
                    if(isset($_POST['csdate_2']) && $_POST['csdate_2']!='' && isset($_POST['csdate_3']) && $_POST['csdate_3']!='') { $select_day_rang.=" and date_format(reg_on,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'"; }

                    $select_fb_main.=$select_day_rang; $select_gp_main.=$select_day_rang; $select_li_main.=$select_day_rang;
                    $select_yh_main.=$select_day_rang; $select_ig_main.=$select_day_rang;
                    
           
                    if($_POST['age_range']=='1') { $select_fb_main.=" and (year(current_date)-year(birthday)) < 13"; }
                    else if($_POST['age_range']=='2') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 13 and (year(current_date)-year(birthday)) <= 17"; }
                    else if($_POST['age_range']=='3') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 18 and (year(current_date)-year(birthday)) <= 34"; }
                    else if($_POST['age_range']=='4') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 35 and (year(current_date)-year(birthday)) <= 49"; }
                    else if($_POST['age_range']=='5') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 50"; }
                    
                    $select_age_main="";
                    if($_POST['age_range']=='1') { $select_age_main=" and (year(current_date)-byear) < 13"; }
                    else if($_POST['age_range']=='2') { $select_age_main=" and (year(current_date)-byear) >= 13 and (year(current_date)-byear) <= 17"; }
                    else if($_POST['age_range']=='3') { $select_age_main=" and (year(current_date)-byear) >= 18 and (year(current_date)-byear) <= 34"; }
                    else if($_POST['age_range']=='4') { $select_age_main=" and (year(current_date)-byear) >= 35 and (year(current_date)-byear) <= 49"; }
                    else if($_POST['age_range']=='5') { $select_age_main=" and (year(current_date)-byear) >= 50"; }
                    $select_gp_main.=$select_age_main;
                    $select_li_main.=$select_age_main;
                    $select_ig_main.=$select_age_main;
                    $select_yh_main.=$select_age_main;
                    

                    $gender_sql="";
                    if(isset($_POST['gender']) && $_POST['gender']=='1') { $gender_sql=" and gender='male' "; $select_li_main.=" and id<0 "; $select_ig_main.=" and id <0 "; }
                    else if(isset($_POST['gender']) && $_POST['gender']=='2') { $gender_sql=" and gender='female' "; $select_li_main.=" and id<0 "; $select_ig_main.=" and id <0 "; }
                    $select_fb_main.=$gender_sql;
                    $select_gp_main.=$gender_sql;
                    $select_yh_main.=$gender_sql;


                    $select_main=$select_fb_main." union all ".$select_gp_main." union all ".$select_li_main." union all ".$select_yh_main." union all ".$select_ig_main;
                    $res_grph=re_db_query($select_main);
                    $total=re_db_num_rows($res_grph);
                    ?>
                    <section class="widget">
                        <header>
                            <h4><?php echo $title_1;?><small><?php echo $title_2;?></small></h4>
                            <div class="widget-controls">
                                <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </header>
                        <div class="widget-body">
<script type="text/javascript">
var chart = AmCharts.makeChart("nupBarChartDiv", {
    "theme": "none",
    "type": "serial",
	"startDuration": 2,
    "dataProvider": [
    <?php $i=0;
    while($row_main=re_db_fetch_array($res_grph))
    {
        $i++; ?>
        {
            "provider": "<?php echo $row_main['provider'];?>",
            "users": <?php echo $row_main['total'];?>,
            "color": "<?php echo $color_arr[$i-1];?>"
        }<?php if($i<$total) {?>,<?php }
    }?>
    ],
    "valueAxes": [{
        "position": "left",
        "axisAlpha":0,
        "gridAlpha":0         
    }],
    "graphs": [{
        "balloonText": "[[category]]: <b>[[value]]</b>",
        "colorField": "color",
        "fillAlphas": 0.85,
        "lineAlpha": 0.1,
        "type": "column",
        "topRadius":1,
        "valueField": "users"
    }],
    "depth3D": 40,
	"angle": 30,
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    },    
    "categoryField": "provider",
    "categoryAxis": {
        "gridPosition": "start",
        "axisAlpha":0,
        "gridAlpha":0,
        "labelRotation":45
    },
    "exportConfig": {
        "menuTop": '20px',
        "menuRight": '20px',
        "menuItems": [{
            "textAlign": 'left',
            "onclick": function () {},
            "icon": '<?php echo SITE_URL;?>amcharts/images/export.png',
            "iconTitle": 'Save chart as an image',
            "items": [{
                "title": 'JPG',
                "format": 'jpg'
            }, {
                "title": 'PNG',
                "format": 'png'
            }, {
                "title": 'SVG',
                "format": 'svg'
            }, {
                "title": 'PDF',
                "format": 'pdf'
            }]
        }],
        "menuItemOutput":{
            "fileName":"New-Users-by-Provider"
        },
        "menuItemStyle": {
            "backgroundColor": 'transparent',
            "rollOverBackgroundColor": '#EFEFEF',
            "color": '#000000',
            "rollOverColor": '#CC0000',
            "paddingTop": '6px',
            "paddingRight": '6px',
            "paddingBottom": '6px',
            "paddingLeft": '6px',
            "marginTop": '0px',
            "marginRight": '0px',
            "marginBottom": '0px',
            "marginLeft": '0px',
            "textAlign": 'left',
            "textDecoration": 'none'
        }
    }
},0);
</script>
                            <div id="nupBarChartDiv" style="width: <?php echo $total*110;?>px; height: 300px;"></div>
                        </div>
                    </section>
                    <?php 
                }
                else if(isset($_GET['utype']) && $_GET['utype']=='lup' && isset($_POST['btn_search']))
                {
                    $dateRange=""; $ageRange="";

                    $select_fb_main="select count(*) as total, 'Facebook' as provider from cs_logins as csl, cs_fb_share_users as csfb where csl.is_from='1' and csl.member_id=csfb.member_id and csl.client_id='".$_SESSION['admin_id']."'";
                    $select_li_main="select count(*) as total, 'LinkedIn' as provider from cs_logins as csl, cs_li_data as csli where csl.is_from='2' and csl.member_id=csli.member_id and csl.client_id='".$_SESSION['admin_id']."'";
                    $select_gp_main="select count(*) as total, 'Google+' as provider from cs_logins as csl, cs_gp_users as csgp where csl.is_from='3' and csl.member_id=csgp.member_id and csl.client_id='".$_SESSION['admin_id']."'";
                    $select_yh_main="select count(*) as total, 'Yahoo' as provider from cs_logins as csl, cs_yahoo_data as csyh where csl.is_from='5' and csl.member_id=csyh.member_id and csl.client_id='".$_SESSION['admin_id']."'";
                    $select_ig_main="select count(*) as total, 'Instagram' as provider from cs_logins as csl, cs_ig_data as csig where csl.is_from='6' and csl.member_id=csig.member_id and csl.client_id='".$_SESSION['admin_id']."'";
                    
                    $select_main="";
                    if($_POST['day_range']=='0' ||  $_POST['day_range']=='1') { $select_main=" and datediff(current_date,csl.date_time) ='".$_POST['day_range']."'"; }
                    else if($_POST['day_range'] > 1) { $select_main=" and datediff(current_date,csl.date_time) <='".$_POST['day_range']."'"; }
                    if(isset($_POST['csdate_2']) && $_POST['csdate_2']!='' && isset($_POST['csdate_3']) && $_POST['csdate_3']!='') { $select_main .=" and date_format(csl.date_time,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'"; }
                    $select_fb_main.=$select_main;
                    $select_li_main.=$select_main;
                    $select_gp_main.=$select_main;
                    $select_yh_main.=$select_main;
                    $select_ig_main.=$select_main;
           
                    if($_POST['age_range']=='1') { $select_fb_main.=" and (year(current_date)-year(csfb.birthday)) < 13"; }
                    else if($_POST['age_range']=='2') { $select_fb_main.=" and (year(current_date)-year(csfb.birthday)) >= 13 and (year(current_date)-year(birthday)) <= 17"; }
                    else if($_POST['age_range']=='3') { $select_fb_main.=" and (year(current_date)-year(csfb.birthday)) >= 18 and (year(current_date)-year(birthday)) <= 34"; }
                    else if($_POST['age_range']=='4') { $select_fb_main.=" and (year(current_date)-year(csfb.birthday)) >= 35 and (year(current_date)-year(birthday)) <= 49"; }
                    else if($_POST['age_range']=='5') { $select_fb_main.=" and (year(current_date)-year(csfb.birthday)) >= 50"; }

                    $select_age_main="";
                    if($_POST['age_range']=='1') { $select_age_main=" and (year(current_date)-byear) < 13"; }
                    else if($_POST['age_range']=='2') { $select_age_main=" and (year(current_date)-byear) >= 13 and (year(current_date)-byear) <= 17"; }
                    else if($_POST['age_range']=='3') { $select_age_main=" and (year(current_date)-byear) >= 18 and (year(current_date)-byear) <= 34"; }
                    else if($_POST['age_range']=='4') { $select_age_main=" and (year(current_date)-byear) >= 35 and (year(current_date)-byear) <= 49"; }
                    else if($_POST['age_range']=='5') { $select_age_main=" and (year(current_date)-byear) >= 50"; }
                    $select_gp_main.=$select_age_main;
                    $select_li_main.=$select_age_main;
                    $select_ig_main.=$select_age_main;
                    $select_yh_main.=$select_age_main;
                    

                    $gender_sql="";
                    if(isset($_POST['gender']) && $_POST['gender']=='1') { $gender_sql=" and gender='male' "; $select_li_main.=" and id<0 "; $select_ig_main.=" and csig.id <0 "; }
                    else if(isset($_POST['gender']) && $_POST['gender']=='2') { $gender_sql=" and gender='female' "; $select_li_main.=" and id<0 "; $select_ig_main.=" and csig.id <0 "; }
                    $select_fb_main.=$gender_sql." group by csl.is_from";
                    $select_gp_main.=$gender_sql." group by csl.is_from";
                    $select_yh_main.=$gender_sql." group by csl.is_from";
                    $select_li_main.=" group by csl.is_from";
                    $select_ig_main.=" group by csl.is_from";
                    
                    $select_main=$select_fb_main." union all ".$select_gp_main." union all ".$select_li_main." union all ".$select_yh_main." union all ".$select_ig_main;

                    $res_main=re_db_query($select_main);
                    $total=re_db_num_rows($res_main);
                    ?>
                    <section class="widget">
                        <header>
                            <h4><?php echo $title_1;?><small><?php echo $title_2;?></small></h4>
                            <div class="widget-controls">
                                <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </header>
                        <div class="widget-body">
<script type="text/javascript">
var chart = AmCharts.makeChart("lupBarChartDiv", {
    "theme": "none",
    "type": "serial",
	"startDuration": 2,
    "dataProvider": [
    <?php $i=0;
    while($row_main=re_db_fetch_array($res_main))
    {
        $i++; ?>
        {
            "provider": "<?php echo $row_main['provider'];?>",
            "users": <?php echo $row_main['total'];?>,
            "color": "<?php echo $color_arr[$i-1];?>"
        }<?php if($i<$total) {?>,<?php }
    }?>
    ],
    "valueAxes": [{
        "position": "left",
        "axisAlpha":0,
        "gridAlpha":0         
    }],
    "graphs": [{
        "balloonText": "[[category]]: <b>[[value]]</b>",
        "colorField": "color",
        "fillAlphas": 0.85,
        "lineAlpha": 0.1,
        "type": "column",
        "topRadius":1,
        "valueField": "users"
    }],
    "depth3D": 40,
	"angle": 30,
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    },    
    "categoryField": "provider",
    "categoryAxis": {
        "gridPosition": "start",
        "axisAlpha":0,
        "gridAlpha":0,
        "labelRotation":45
    },
	"exportConfig": {
        "menuTop": '20px',
        "menuRight": '20px',
        "menuItems": [{
            "textAlign": 'left',
            "onclick": function () {},
            "icon": '<?php echo SITE_URL;?>amcharts/images/export.png',
            "iconTitle": 'Save chart as an image',
            "items": [{
                "title": 'JPG',
                "format": 'jpg'
            }, {
                "title": 'PNG',
                "format": 'png'
            }, {
                "title": 'SVG',
                "format": 'svg'
            }, {
                "title": 'PDF',
                "format": 'pdf'
            }]
        }],
        "menuItemOutput":{
            "fileName":"New-Users-by-Provider"
        },
        "menuItemStyle": {
            "backgroundColor": 'transparent',
            "rollOverBackgroundColor": '#EFEFEF',
            "color": '#000000',
            "rollOverColor": '#CC0000',
            "paddingTop": '6px',
            "paddingRight": '6px',
            "paddingBottom": '6px',
            "paddingLeft": '6px',
            "marginTop": '0px',
            "marginRight": '0px',
            "marginBottom": '0px',
            "marginLeft": '0px',
            "textAlign": 'left',
            "textDecoration": 'none'
        }
    }
},0);
</script>
                            <div id="lupBarChartDiv" style="width: <?php echo $total*150;?>px; height: 300px;"></div>
                        </div>
                    </section>
                    <?php 
                }
                else if(isset($_GET['utype']) && $_GET['utype']=='rbp' && isset($_POST['btn_search']))
                {
                    $dateRange=""; $ageRange="";
                    
                    $select_rev_main="select sum(if(ot.is_from=1,ot.order_amt,0)) as fb_total, sum(if(ot.is_from=2,ot.order_amt,0)) as li_total, sum(if(ot.is_from=3,ot.order_amt,0)) as gp_total, sum(if(ot.is_from=5,ot.order_amt,0)) as yh_total, sum(if(ot.is_from=6,ot.order_amt,0)) as ig_total, date_format(ot.date_time,'%m-%d-%Y') as order_date from cs_track_orders as ot, `cs_users` as csu where csu.id=ot.ref_by and ot.client_id=csu.client_id and ot.date_time is not null and ot.client_id='".$_SESSION['admin_id']."' ";
                    if($_POST['day_range']=='0' ||  $_POST['day_range']=='1') { $select_rev_main.=" and datediff(current_date,ot.date_time) ='".$_POST['day_range']."'"; }
                    else if($_POST['day_range'] > 1) { $select_rev_main.=" and datediff(current_date,ot.date_time) <='".$_POST['day_range']."'"; }
                    if(isset($_POST['csdate_2']) && $_POST['csdate_2']!='' && isset($_POST['csdate_3']) && $_POST['csdate_3']!='') { $select_rev_main.=" and date_format(ot.date_time,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'"; }
                    $select_rev_main.=" group by date_format(ot.date_time,'%m-%d-%Y')";
                    
                    $rev_main_sql=re_db_query($select_rev_main);
                    $total=re_db_num_rows($rev_main_sql);
                    ?>
                    <section class="widget">
                        <header>
                            <h4><?php echo $title_1;?><small><?php echo $title_2;?></small></h4>
                            <div class="widget-controls">
                                <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </header>
                        <div class="widget-body">
<script type="text/javascript">
var chart = AmCharts.makeChart("rbpBarChartDiv", {
    "type": "serial",
	"theme": "none",
    "startDuration": 2,
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
    while($row_main=re_db_fetch_array($rev_main_sql))
    {
        $i++; ?>
        {
            "date": "<?php echo $row_main['order_date'];?>",
            "facebook": <?php echo $row_main['fb_total'];?>,
            "google": <?php echo $row_main['gp_total'];?>,
            "linkedin": <?php echo $row_main['li_total'];?>,
            "yahoo": <?php echo $row_main['yh_total'];?>,
            "instagram": <?php echo $row_main['ig_total'];?>
        }<?php if($i<$total) {?>,<?php }
    }?>
    ],
    "valueAxes": [{
        "stackType": "regular",
        "axisAlpha": 0.3,
        "gridAlpha": 0
    }],
    "graphs": [{
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "Facebook",
        "type": "column",
		"color": "#000000",
        "valueField": "facebook"
    }, {
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "Google+",
        "type": "column",
		"color": "#000000",
        "valueField": "google"
    }, {
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "LinkedIn",
        "type": "column",
		"color": "#000000",
        "valueField": "linkedin"
    }, {
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "Yahoo",
        "type": "column",
		"color": "#000000",
        "valueField": "yahoo"
    }, {
        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "Instagram",
        "type": "column",
		"color": "#000000",
        "valueField": "instagram"
    }],
    "categoryField": "date",
    "categoryAxis": {
        "gridPosition": "start",
        "axisAlpha": 0,
        "gridAlpha": 0,
        "position": "left",
        "labelRotation":45
    },
	"exportConfig": {
        "menuTop": '20px',
        "menuRight": '20px',
        "menuItems": [{
            "textAlign": 'left',
            "onclick": function () {},
            "icon": '<?php echo SITE_URL;?>amcharts/images/export.png',
            "iconTitle": 'Save chart as an image',
            "items": [{
                "title": 'JPG',
                "format": 'jpg'
            }, {
                "title": 'PNG',
                "format": 'png'
            }, {
                "title": 'SVG',
                "format": 'svg'
            }, {
                "title": 'PDF',
                "format": 'pdf'
            }]
        }],
        "menuItemOutput":{
            "fileName":"New-Users-by-Provider"
        },
        "menuItemStyle": {
            "backgroundColor": 'transparent',
            "rollOverBackgroundColor": '#EFEFEF',
            "color": '#000000',
            "rollOverColor": '#CC0000',
            "paddingTop": '6px',
            "paddingRight": '6px',
            "paddingBottom": '6px',
            "paddingLeft": '6px',
            "marginTop": '0px',
            "marginRight": '0px',
            "marginBottom": '0px',
            "marginLeft": '0px',
            "textAlign": 'left',
            "textDecoration": 'none'
        }
    }
});
</script>

                            <div id="rbpBarChartDiv" style="width: <?php if($total>2 && $total<=7) {echo ($total*110).'px;';} else if($total>7) { echo '100%;';} else {echo '450px;';}?> height: 300px;"></div>
                        </div>
                    </section>
                    <?php 
                }
                else if(isset($_GET['utype']) && $_GET['utype']=='dmg' && isset($_POST['btn_search']))
                {
                    $dateRange=""; $ageRange="";

                    $gender_fb_main="select gender, 'Facebook' as provider from cs_fb_share_users where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $gender_gp_main="select gender, 'Google+' as provider from cs_gp_users where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $gender_yh_main="select gender, 'Yahoo' as provider from cs_yahoo_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $gender_li_main="select 'NA' as gender, 'LinkedIn' as provider from cs_li_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $gender_ig_main="select 'NA' as gender, 'Instagram' as provider from cs_ig_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    
                    $date_range_sql="";
                    if($_POST['day_range']=='0' ||  $_POST['day_range']=='1') { $date_range_sql=" and datediff(current_date,reg_on) ='".$_POST['day_range']."'"; }
                    else if($_POST['day_range'] > 1) { $date_range_sql=" and datediff(current_date,reg_on) <='".$_POST['day_range']."'"; }
                    if(isset($_POST['csdate_2']) && $_POST['csdate_2']!='' && isset($_POST['csdate_3']) && $_POST['csdate_3']!='') { $date_range_sql.=" and date_format(reg_on,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'"; }
                    $gender_fb_main.=$date_range_sql;
                    $gender_gp_main.=$date_range_sql;
                    $gender_yh_main.=$date_range_sql;
                    $gender_li_main.=$date_range_sql;
                    $gender_ig_main.=$date_range_sql;

                    $select_main=$gender_fb_main." union all ".$gender_gp_main." union all ".$gender_li_main." union all ".$gender_yh_main." union all ".$gender_ig_main;

                    $gender_qry="select sum(if(b.gender='male',1,0)) as Male, sum(if(b.gender='female',1,0)) as 'Female', sum(if(b.gender='NA',1,0)) as 'Not_Provided' from ( ".$select_main." ) as b";
                    $gender_sql=re_db_query($gender_qry);
                    $gender_rec=re_db_fetch_array($gender_sql);
                    $total_male=$gender_rec['Male']!="" ? $gender_rec['Male'] : "0";
                    $total_female=$gender_rec['Female']!="" ? $gender_rec['Female'] : "0";
                    $total_na=$gender_rec['Not_Provided']!="" ? $gender_rec['Not_Provided'] : "0";
                    
                    $fe_gender_qry="select sum(if(b.gender='male',1,0)) as Male, sum(if(b.gender='female',1,0)) as 'Female', sum(if(b.gender='NA',1,0)) as 'Not_Provided' from ( ".$gender_fb_main." ) as b";
                    $fe_gender_sql=re_db_query($fe_gender_qry);
                    $fe_gender_rec=re_db_fetch_array($fe_gender_sql);
                    $fb_total_male=$fe_gender_rec['Male']!="" ? $fe_gender_rec['Male'] : "0";
                    $fb_total_female=$fe_gender_rec['Female']!="" ? $fe_gender_rec['Female'] : "0";
                    $fb_total_na=$fe_gender_rec['Not_Provided']!="" ? $fe_gender_rec['Not_Provided'] : "0";


                    $gp_gender_qry="select sum(if(b.gender='male',1,0)) as Male, sum(if(b.gender='female',1,0)) as 'Female', sum(if(b.gender='NA',1,0)) as 'Not_Provided' from ( ".$gender_gp_main." ) as b";
                    $gp_gender_sql=re_db_query($gp_gender_qry);
                    $gp_gender_rec=re_db_fetch_array($gp_gender_sql);
                    $gp_total_male=$gp_gender_rec['Male']!="" ? $gp_gender_rec['Male'] : "0";
                    $gp_total_female=$gp_gender_rec['Female']!="" ? $gp_gender_rec['Female'] : "0";
                    $gp_total_na=$gp_gender_rec['Not_Provided']!="" ? $gp_gender_rec['Not_Provided'] : "0";


                    $li_gender_qry="select sum(if(b.gender='male',1,0)) as Male, sum(if(b.gender='female',1,0)) as 'Female', sum(if(b.gender='NA',1,0)) as 'Not_Provided' from ( ".$gender_li_main." ) as b";
                    $li_gender_sql=re_db_query($li_gender_qry);
                    $li_gender_rec=re_db_fetch_array($li_gender_sql);
                    $li_total_male=$li_gender_rec['Male']!="" ? $li_gender_rec['Male'] : "0";
                    $li_total_female=$li_gender_rec['Female']!="" ? $li_gender_rec['Female'] : "0";
                    $li_total_na=$li_gender_rec['Not_Provided']!="" ? $li_gender_rec['Not_Provided'] : "0";


                    $yh_gender_qry="select sum(if(b.gender='male',1,0)) as Male, sum(if(b.gender='female',1,0)) as 'Female', sum(if(b.gender='NA',1,0)) as 'Not_Provided' from ( ".$gender_gp_main." ) as b";
                    $yh_gender_sql=re_db_query($yh_gender_qry);
                    $yh_gender_rec=re_db_fetch_array($yh_gender_sql);
                    $yh_total_male=$yh_gender_rec['Male']!="" ? $yh_gender_rec['Male'] : "0";
                    $yh_total_female=$yh_gender_rec['Female']!="" ? $yh_gender_rec['Female'] : "0";
                    $yh_total_na=$yh_gender_rec['Not_Provided']!="" ? $yh_gender_rec['Not_Provided'] : "0";


                    $ig_gender_qry="select sum(if(b.gender='male',1,0)) as Male, sum(if(b.gender='female',1,0)) as 'Female', sum(if(b.gender='NA',1,0)) as 'Not_Provided' from ( ".$gender_li_main." ) as b";
                    $ig_gender_sql=re_db_query($ig_gender_qry);
                    $ig_gender_rec=re_db_fetch_array($ig_gender_sql);
                    $ig_total_male=$ig_gender_rec['Male']!="" ? $ig_gender_rec['Male'] : "0";
                    $ig_total_female=$ig_gender_rec['Female']!="" ? $ig_gender_rec['Female'] : "0";
                    $ig_total_na=$ig_gender_rec['Not_Provided']!="" ? $ig_gender_rec['Not_Provided'] : "0";







                    $select_fb_main="select (year(current_date)-year(birthday)) as age, 'Facebook' as provider  from cs_fb_share_users where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_gp_main="select if(byear!='0000',(year(current_date)-byear),0) as age, 'Google+' as provider from cs_gp_users where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_li_main="select if(byear!='0000',(year(current_date)-byear),0) as age, 'LinkedIn' as provider from cs_li_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_ig_main="select if(byear!='0000',(year(current_date)-byear),0) as age, 'Instagram' as provider from cs_ig_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_yh_main="select if(byear!='0000',(year(current_date)-byear),0) as age, 'Yahoo' as provider from cs_yahoo_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";

                    $day_rande_main="";
                    if($_POST['day_range']=='0' ||  $_POST['day_range']=='1') { $day_rande_main=" and datediff(current_date,reg_on) ='".$_POST['day_range']."'"; }
                    else if($_POST['day_range'] > 1) { $day_rande_main=" and datediff(current_date,reg_on) <='".$_POST['day_range']."'"; }
                    if(isset($_POST['csdate_2']) && $_POST['csdate_2']!='' && isset($_POST['csdate_3']) && $_POST['csdate_3']!='') { $day_rande_main.=" and date_format(reg_on,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'"; }
                    $select_fb_main.=$day_rande_main;
                    $select_gp_main.=$day_rande_main;
                    $select_li_main.=$day_rande_main;
                    $select_yh_main.=$day_rande_main;
                    $select_ig_main.=$day_rande_main;
                    
                    $select_main=$select_fb_main." union all ".$select_gp_main." union all ".$select_li_main." union all ".$select_yh_main." union all ".$select_ig_main;

                    $main_age_qry="select sum(if(b.age=0,1,0)) as NP, sum(if(b.age>0 and b.age<13,1,0)) as LT13,sum(if(b.age>=13 and b.age <= 17,1,0)) as GT13_LT17,sum(if(b.age>=18 and b.age <= 34,1,0)) as GT18_LT34,sum(if(b.age>=35 and b.age <= 49,1,0)) as GT35_LT49,sum(if(b.age>=50,1,0)) as GT50, 'Facebook' as provider from ( ".$select_main." ) as b order by b.age";
                    $res_main=re_db_query($main_age_qry);
                    $row_main=re_db_fetch_array($res_main);
                    $total_np=$row_main['NP']!="" ? $row_main['NP'] : "0";
                    $total_13=$row_main['LT13']!="" ? $row_main['LT13'] : "0";
                    $total_13_17=$row_main['GT13_LT17']!="" ? $row_main['GT13_LT17'] : "0";
                    $total_18_34=$row_main['GT18_LT34']!="" ? $row_main['GT18_LT34'] : "0";
                    $total_35_49=$row_main['GT35_LT49']!="" ? $row_main['GT35_LT49'] : "0";
                    $total_50=$row_main['GT50']!="" ? $row_main['GT50'] : "0";

                    $fb_age_qry="select  sum(if(b.age=0,1,0)) as NP, sum(if(b.age>0 and b.age<13,1,0)) as LT13, sum(if(b.age>=13 and b.age <= 17,1,0)) as GT13_LT17, sum(if(b.age>=18 and b.age <= 34,1,0)) as GT18_LT34, sum(if(b.age>=35 and b.age <= 49,1,0)) as GT35_LT49, sum(if(b.age>=50,1,0)) as GT50, 'Facebook' as provider from ( ".$select_fb_main." ) as b order by b.age";
                    $fb_age_sql=re_db_query($fb_age_qry);
                    $fb_age_rec=re_db_fetch_array($fb_age_sql);
                    $fb_total_np=$fb_age_rec['NP']!="" ? $fb_age_rec['NP'] : "0";
                    $fb_total_13=$fb_age_rec['LT13']!="" ? $fb_age_rec['LT13'] : "0";
                    $fb_total_13_17=$fb_age_rec['GT13_LT17']!="" ? $fb_age_rec['GT13_LT17'] : "0";
                    $fb_total_18_34=$fb_age_rec['GT18_LT34']!="" ? $fb_age_rec['GT18_LT34'] : "0";
                    $fb_total_35_49=$fb_age_rec['GT35_LT49']!="" ? $fb_age_rec['GT35_LT49'] : "0";
                    $fb_total_50=$fb_age_rec['GT50']!="" ? $fb_age_rec['GT50'] : "0";

                    $gp_age_qry="select  sum(if(b.age=0,1,0)) as NP, sum(if(b.age>0 and b.age<13,1,0)) as LT13, sum(if(b.age>=13 and b.age <= 17,1,0)) as GT13_LT17, sum(if(b.age>=18 and b.age <= 34,1,0)) as GT18_LT34, sum(if(b.age>=35 and b.age <= 49,1,0)) as GT35_LT49, sum(if(b.age>=50,1,0)) as GT50, 'Facebook' as provider from ( ".$select_gp_main." ) as b order by b.age";
                    $gp_age_sql=re_db_query($gp_age_qry);
                    $gp_age_rec=re_db_fetch_array($gp_age_sql);
                    $gp_total_np=$gp_age_rec['NP']!="" ? $gp_age_rec['NP'] : "0";
                    $gp_total_13=$gp_age_rec['LT13']!="" ? $gp_age_rec['LT13'] : "0";
                    $gp_total_13_17=$gp_age_rec['GT13_LT17']!="" ? $gp_age_rec['GT13_LT17'] : "0";
                    $gp_total_18_34=$gp_age_rec['GT18_LT34']!="" ? $gp_age_rec['GT18_LT34'] : "0";
                    $gp_total_35_49=$gp_age_rec['GT35_LT49']!="" ? $gp_age_rec['GT35_LT49'] : "0";
                    $gp_total_50=$gp_age_rec['GT50']!="" ? $gp_age_rec['GT50'] : "0";


                    $li_age_qry="select  sum(if(b.age=0,1,0)) as NP, sum(if(b.age>0 and b.age<13,1,0)) as LT13, sum(if(b.age>=13 and b.age <= 17,1,0)) as GT13_LT17, sum(if(b.age>=18 and b.age <= 34,1,0)) as GT18_LT34, sum(if(b.age>=35 and b.age <= 49,1,0)) as GT35_LT49, sum(if(b.age>=50,1,0)) as GT50, 'Facebook' as provider from ( ".$select_li_main." ) as b order by b.age";
                    $li_age_sql=re_db_query($li_age_qry);
                    $li_age_rec=re_db_fetch_array($li_age_sql);
                    $li_total_np=$li_age_rec['NP']!="" ? $li_age_rec['NP'] : "0";
                    $li_total_13=$li_age_rec['LT13']!="" ? $li_age_rec['LT13'] : "0";
                    $li_total_13_17=$li_age_rec['GT13_LT17']!="" ? $li_age_rec['GT13_LT17'] : "0";
                    $li_total_18_34=$li_age_rec['GT18_LT34']!="" ? $li_age_rec['GT18_LT34'] : "0";
                    $li_total_35_49=$li_age_rec['GT35_LT49']!="" ? $li_age_rec['GT35_LT49'] : "0";
                    $li_total_50=$li_age_rec['GT50']!="" ? $li_age_rec['GT50'] : "0";


                    $yh_age_qry="select  sum(if(b.age=0,1,0)) as NP, sum(if(b.age>0 and b.age<13,1,0)) as LT13, sum(if(b.age>=13 and b.age <= 17,1,0)) as GT13_LT17, sum(if(b.age>=18 and b.age <= 34,1,0)) as GT18_LT34, sum(if(b.age>=35 and b.age <= 49,1,0)) as GT35_LT49, sum(if(b.age>=50,1,0)) as GT50, 'Facebook' as provider from ( ".$select_yh_main." ) as b order by b.age";
                    $yh_age_sql=re_db_query($yh_age_qry);
                    $yh_age_rec=re_db_fetch_array($yh_age_sql);
                    $yh_total_np=$yh_age_rec['NP']!="" ? $yh_age_rec['NP'] : "0";
                    $yh_total_13=$yh_age_rec['LT13']!="" ? $yh_age_rec['LT13'] : "0";
                    $yh_total_13_17=$yh_age_rec['GT13_LT17']!="" ? $yh_age_rec['GT13_LT17'] : "0";
                    $yh_total_18_34=$yh_age_rec['GT18_LT34']!="" ? $yh_age_rec['GT18_LT34'] : "0";
                    $yh_total_35_49=$yh_age_rec['GT35_LT49']!="" ? $yh_age_rec['GT35_LT49'] : "0";
                    $yh_total_50=$yh_age_rec['GT50']!="" ? $yh_age_rec['GT50'] : "0";


                    $ig_age_qry="select  sum(if(b.age=0,1,0)) as NP, sum(if(b.age>0 and b.age<13,1,0)) as LT13, sum(if(b.age>=13 and b.age <= 17,1,0)) as GT13_LT17, sum(if(b.age>=18 and b.age <= 34,1,0)) as GT18_LT34, sum(if(b.age>=35 and b.age <= 49,1,0)) as GT35_LT49, sum(if(b.age>=50,1,0)) as GT50, 'Facebook' as provider from ( ".$select_ig_main." ) as b order by b.age";
                    $ig_age_sql=re_db_query($ig_age_qry);
                    $ig_age_rec=re_db_fetch_array($ig_age_sql);
                    $ig_total_np=$ig_age_rec['NP']!="" ? $ig_age_rec['NP'] : "0";
                    $ig_total_13=$ig_age_rec['LT13']!="" ? $ig_age_rec['LT13'] : "0";
                    $ig_total_13_17=$ig_age_rec['GT13_LT17']!="" ? $ig_age_rec['GT13_LT17'] : "0";
                    $ig_total_18_34=$ig_age_rec['GT18_LT34']!="" ? $ig_age_rec['GT18_LT34'] : "0";
                    $ig_total_35_49=$ig_age_rec['GT35_LT49']!="" ? $ig_age_rec['GT35_LT49'] : "0";
                    $ig_total_50=$ig_age_rec['GT50']!="" ? $ig_age_rec['GT50'] : "0";



                    
                    
                    
                    // code for generate relationship status

                    $select_fb_main="select if(relationship_status!='',relationship_status,'Not Provided') as relation_status, relationship_status as relation from cs_fb_share_users where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_gp_main="select if(relationship_status!='',relationship_status,'Not Provided') as relation_status, relationship_status as relation from cs_gp_users where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_li_main="select 'Not Provided' as relation_status, '' as relation from cs_li_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_yh_main="select 'Not Provided' as relation_status, '' as relation from cs_yahoo_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";
                    $select_ig_main="select 'Not Provided' as relation_status, '' as relation from cs_ig_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."'";

                    $select_main="";
                    if($_POST['day_range']=='0' ||  $_POST['day_range']=='1') { $select_main.=" and datediff(current_date,reg_on) ='".$_POST['day_range']."'"; }
                    else if($_POST['day_range'] > 1) { $select_main .=" and datediff(current_date,reg_on) <='".$_POST['day_range']."'"; }
                    if(isset($_POST['csdate_2']) && $_POST['csdate_2']!='' && isset($_POST['csdate_3']) && $_POST['csdate_3']!='') { $select_main.=" and date_format(reg_on,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'"; }
                    $select_fb_main.=$select_main;
                    $select_gp_main.=$select_main;
                    $select_li_main.=$select_main;
                    $select_yh_main.=$select_main;
                    $select_ig_main.=$select_main;
                    
                    
                    
                    $select_main_qry="select a.relation_status, count(*) as tot, relation from 
                                    ( ".$select_fb_main." union all ".$select_gp_main." union all ".$select_li_main." union all ".$select_yh_main." union all ".$select_ig_main." ) 
                                    as a group by a.relation_status order by relation_status";
                    $select_main_sql=re_db_query($select_main_qry);
                    $tot_rec=re_db_num_rows($select_main_sql);
                    
                    ?>
                    <section class="widget">
                        <header>
                            <h4>New Users by <small>Gender</small></h4>
                            <div class="widget-controls">
                                <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </header>
                        <div class="widget-body">
<script type="text/javascript">
var chart;
var legend;
var selected;
var chartGender;

var typesGender = [{
    type: "Male Users",
    percent: <?php echo $total_male;?>, 
    color: "#ff9e01",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_male;?> },
        { type: "Google+", percent: <?php echo $gp_total_male;?> },
        { type: "LinkedIn", percent: <?php echo $li_total_male;?> },
        { type: "Yahoo", percent: <?php echo $yh_total_male;?> },
        { type: "Instagram", percent: <?php echo $ig_total_male;?> }
    ]}, {
    type: "Female Users",
    percent: <?php echo $total_female;?>,
    color: "#b0de09",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_female;?> },
        { type: "Google+", percent: <?php echo $gp_total_female;?> },
        { type: "LinkedIn", percent: <?php echo $li_total_female;?> },
        { type: "Yahoo", percent: <?php echo $yh_total_female;?> },
        { type: "Instagram", percent: <?php echo $ig_total_female;?> }
    ]}, {
    type: "Not Provided",
    percent: <?php echo $total_na;?>,
    color: "#04D215",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_na;?> },
        { type: "Google+", percent: <?php echo $gp_total_na;?> },
        { type: "LinkedIn", percent: <?php echo $li_total_na;?> },
        { type: "Yahoo", percent: <?php echo $yh_total_na;?> },
        { type: "Instagram", percent: <?php echo $ig_total_na;?> }
    ]}
];

function generateGenderChartData () {
    var chartData = [];
    for (var i = 0; i < typesGender.length; i++) {
        if (i == selected) {
            for (var x = 0; x < typesGender[i].subs.length; x++) {
                chartData.push({
                    type: typesGender[i].subs[x].type,
                    percent: typesGender[i].subs[x].percent,
                    color: typesGender[i].color,
                    pulled: true
                });
            }
        }
        else {
            chartData.push({
                type: typesGender[i].type,
                percent: typesGender[i].percent,
                color: typesGender[i].color,
                id: i
            });
        }
    }
    return chartData;
}

AmCharts.ready(function() {
    // PIE CHART
    chartGender = new AmCharts.AmPieChart();
    chartGender.dataProvider = generateGenderChartData();
    chartGender.titleField = "type";
    chartGender.valueField = "percent";
    chartGender.outlineColor = "#FFFFFF";
    chartGender.outlineAlpha = 0.4;
    chartGender.outlineThickness = 2;
    chartGender.colorField = "color";
    chartGender.pulledField = "pulled";
    chartGender.depth3D = 15;
    chartGender.angle = 30;
    
    
    // ADD TITLE
    chartGender.addTitle("Click a slice to see the details");
    
    // AN EVENT TO HANDLE SLICE CLICKS
    chartGender.addListener("clickSlice", function (event) {
        if (event.dataItem.dataContext.id != undefined) {
            selected = event.dataItem.dataContext.id;
        }
        else {
            selected = undefined;
        }
        chartGender.dataProvider = generateGenderChartData();
        chartGender.validateData();
    });


  	//custom add export code
    chartGender.exportConfig = {
        "menuTop": '20px',
        "menuRight": '20px',
        "menuItems": [{
            "textAlign": 'left',
            "onclick": function () {},
            "icon": '<?php echo SITE_URL;?>amcharts/images/export.png',
            "iconTitle": 'Save chart as an image',
            "items": [{
                "title": 'JPG',
                "format": 'jpg'
            }, {
                "title": 'PNG',
                "format": 'png'
            }, {
                "title": 'SVG',
                "format": 'svg'
            }, {
                "title": 'PDF',
                "format": 'pdf'
            }]
        }],
        "menuItemOutput":{
            "fileName":"New-Users-by-Provider"
        },
        "menuItemStyle": {
            "backgroundColor": 'transparent',
            "rollOverBackgroundColor": '#EFEFEF',
            "color": '#000000',
            "rollOverColor": '#CC0000',
            "paddingTop": '6px',
            "paddingRight": '6px',
            "paddingBottom": '6px',
            "paddingLeft": '6px',
            "marginTop": '0px',
            "marginRight": '0px',
            "marginBottom": '0px',
            "marginLeft": '0px',
            "textAlign": 'left',
            "textDecoration": 'none'
        }
    };

    // WRITE
    chartGender.write("pieChartGenderDiv");
});
</script>
                            <div id="pieChartGenderDiv" style="width: 100%; height: 500px;"></div>
                        </div>
                    </section>
                    <section class="widget">
                        <header>
                            <h4>New Users by <small>Age</small></h4>
                            <div class="widget-controls">
                                <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </header>
                        <div class="widget-body">
<script type="text/javascript">
var chartAge;
var typesAge = [{
    type: "Age Not Provided",
    percent: <?php echo $total_np;?>, 
    color: "<?php echo $color_arr[5];?>",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_np;?> },
        { type: "Google+", percent: <?php echo $gp_total_np;?> },
        { type: "LinkedIn", percent: <?php echo $li_total_np;?> },
        { type: "Yahoo", percent: <?php echo $yh_total_np;?> },
        { type: "Instagram", percent: <?php echo $ig_total_np;?> }
    ]}, {
    type: "Age Under 13 Year",
    percent: <?php echo $total_13;?>, 
    color: "<?php echo $color_arr[0];?>",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_13;?> },
        { type: "Google+", percent: <?php echo $gp_total_13;?> },
        { type: "LinkedIn", percent: <?php echo $li_total_13;?> },
        { type: "Yahoo", percent: <?php echo $yh_total_13;?> },
        { type: "Instagram", percent: <?php echo $ig_total_13;?> }
    ]}, {
    type: "Age Between 13-17 Year",
    percent: <?php echo $total_13_17;?>,
    color: "<?php echo $color_arr[1];?>",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_13_17;?> },
        { type: "Google+", percent: <?php echo $gp_total_13_17;?> },
        { type: "LinkedIn", percent: <?php echo $li_total_13_17;?> },
        { type: "Yahoo", percent: <?php echo $yh_total_13_17;?> },
        { type: "Instagram", percent: <?php echo $ig_total_13_17;?> }
    ]}, {
    type: "Age Between 18-34 Year",
    percent: <?php echo $total_18_34;?>,
    color: "<?php echo $color_arr[2];?>",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_18_34;?> },
        { type: "Google+", percent: <?php echo $gp_total_18_34;?> },
        { type: "LinkedIn", percent: <?php echo $li_total_18_34;?> },
        { type: "Yahoo", percent: <?php echo $yh_total_18_34;?> },
        { type: "Instagram", percent: <?php echo $ig_total_18_34;?> }
    ]}, {
    type: "Age Between 35-49 Year",
    percent: <?php echo $total_35_49;?>,
    color: "<?php echo $color_arr[3];?>",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_35_49;?> },
        { type: "Google+", percent: <?php echo $gp_total_35_49;?> },
        { type: "LinkedIn", percent: <?php echo $li_total_35_49;?> },
        { type: "Yahoo", percent: <?php echo $yh_total_35_49;?> },
        { type: "Instagram", percent: <?php echo $ig_total_35_49;?> }
    ]}, {
    type: "Age 50 Year or Above",
    percent: <?php echo $total_50;?>,
    color: "<?php echo $color_arr[4];?>",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_50;?> },
        { type: "Google+", percent: <?php echo $gp_total_50;?> },
        { type: "LinkedIn", percent: <?php echo $li_total_50;?> },
        { type: "Yahoo", percent: <?php echo $yh_total_50;?> },
        { type: "Instagram", percent: <?php echo $ig_total_50;?> }
    ]}
];

function generateAgeChartData () {
    var chartAgeData = [];
    for (var i = 0; i < typesAge.length; i++) {
        if (i == selected) {
            for (var x = 0; x < typesAge[i].subs.length; x++) {
                chartAgeData.push({
                    type: typesAge[i].subs[x].type,
                    percent: typesAge[i].subs[x].percent,
                    color: typesAge[i].color,
                    pulled: true
                });
            }
        }
        else {
            chartAgeData.push({
                type: typesAge[i].type,
                percent: typesAge[i].percent,
                color: typesAge[i].color,
                id: i
            });
        }
    }
    return chartAgeData;
}

AmCharts.ready(function() {
    // PIE CHART
    chartAge = new AmCharts.AmPieChart();
    chartAge.dataProvider = generateAgeChartData();
    chartAge.titleField = "type";
    chartAge.valueField = "percent";
    chartAge.outlineColor = "#FFFFFF";
    chartAge.outlineAlpha = 0.4;
    chartAge.outlineThickness = 2;
    chartAge.colorField = "color";
    chartAge.pulledField = "pulled";
    chartAge.depth3D = 15,
    chartAge.angle = 30,
    
    // ADD TITLE
    chartAge.addTitle("Click a slice to see the details");
    
    // AN EVENT TO HANDLE SLICE CLICKS
    chartAge.addListener("clickSlice", function (event) {
        if (event.dataItem.dataContext.id != undefined) {
            selected = event.dataItem.dataContext.id;
        }
        else {
            selected = undefined;
        }
        chartAge.dataProvider = generateAgeChartData();
        chartAge.validateData();
    });

  	//custom add export code
    chartAge.exportConfig = {
        "menuTop": '20px',
        "menuRight": '20px',
        "menuItems": [{
            "textAlign": 'left',
            "onclick": function () {},
            "icon": '<?php echo SITE_URL;?>amcharts/images/export.png',
            "iconTitle": 'Save chart as an image',
            "items": [{
                "title": 'JPG',
                "format": 'jpg'
            }, {
                "title": 'PNG',
                "format": 'png'
            }, {
                "title": 'SVG',
                "format": 'svg'
            }, {
                "title": 'PDF',
                "format": 'pdf'
            }]
        }],
        "menuItemOutput":{
            "fileName":"New-Users-by-Provider"
        },
        "menuItemStyle": {
            "backgroundColor": 'transparent',
            "rollOverBackgroundColor": '#EFEFEF',
            "color": '#000000',
            "rollOverColor": '#CC0000',
            "paddingTop": '6px',
            "paddingRight": '6px',
            "paddingBottom": '6px',
            "paddingLeft": '6px',
            "marginTop": '0px',
            "marginRight": '0px',
            "marginBottom": '0px',
            "marginLeft": '0px',
            "textAlign": 'left',
            "textDecoration": 'none'
        }
    };

    // WRITE
    chartAge.write("pieChartAgeDiv");
});
</script>                            
                            <div id="pieChartAgeDiv" style="width: 100%; height: 500px;"></div>
                        </div>
                    </section>


                    <section class="widget">
                        <header>
                            <h4>New Users by Relationship <small>Status</small></h4>
                            <div class="widget-controls">
                                <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </header>
                        <div class="widget-body">
<script type="text/javascript">
var chartRelation;
var typesRelation = [
    <?php $i=0;
    while($main_rec=re_db_fetch_array($select_main_sql))
    {
        $i++;?>
        {
        type: "<?php echo $main_rec['relation_status'];?>",
        percent: <?php echo $main_rec['tot'];?>, 
        color: "<?php echo $color_arr[$i];?>",
        subs: [
        <?php $j=0;
        $sub_fb_main="select count(*) as total, 'Facebook' as Provider, relationship_status from cs_fb_share_users where reg_on is not null and reg_on!='0000-00-00 00:00:00' and relationship_status='".$main_rec['relation']."' and client_id='".$_SESSION['admin_id']."' ".$select_main." group by relationship_status";
        $sub_gp_main="select count(*) as total, 'Google+' as Provider, relationship_status from cs_gp_users where reg_on is not null and reg_on!='0000-00-00 00:00:00' and relationship_status='".$main_rec['relation']."' and client_id='".$_SESSION['admin_id']."' ".$select_main." group by relationship_status";
        $sub_li_main="select count(*) as total, 'LinkedIn' as Provider, '' as relationship_status from cs_li_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."' ".$select_main." group by relationship_status HAVING relationship_status='".$main_rec['relation']."'";
        $sub_yh_main="select count(*) as total, 'Yahoo' as Provider, '' as relationship_status from cs_yahoo_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."' ".$select_main." group by relationship_status HAVING relationship_status='".$main_rec['relation']."'";
        $sub_ig_main="select count(*) as total, 'Instagram' as Provider, '' as relationship_status from cs_ig_data where reg_on is not null and reg_on!='0000-00-00 00:00:00' and client_id='".$_SESSION['admin_id']."' ".$select_main." group by relationship_status HAVING relationship_status='".$main_rec['relation']."'";
        $sub_main_qry=$sub_fb_main." union all ".$sub_gp_main." union all ".$sub_li_main." union all ".$sub_yh_main." union all ".$sub_ig_main;
        //$sub_main_qry=$sub_fb_main." union all ".$sub_gp_main;
        $sub_main_sql=re_db_query($sub_main_qry);
        $sub_total=re_db_num_rows($sub_main_sql);
        while($sub_main_rec=re_db_fetch_array($sub_main_sql))
        {
            $j++; ?>
            { type: "<?php echo $sub_main_rec['Provider'];?>", percent: <?php echo $sub_main_rec['total'];?> }<?php if($j<$tot_rec) {?>,<?php }
        } ?>
        ]}<?php if($i<$tot_rec) {?>,<?php }
    }?>
];

function generateRelationChartData () {
    var chartData = [];
    for (var i = 0; i < typesRelation.length; i++) {
        if (i == selected) {
            for (var x = 0; x < typesRelation[i].subs.length; x++) {
                chartData.push({
                    type: typesRelation[i].subs[x].type,
                    percent: typesRelation[i].subs[x].percent,
                    color: typesRelation[i].color,
                    pulled: true
                });
            }
        }
        else {
            chartData.push({
                type: typesRelation[i].type,
                percent: typesRelation[i].percent,
                color: typesRelation[i].color,
                id: i
            });
        }
    }
    return chartData;
}

AmCharts.ready(function() {
    // PIE CHART
    chartRelation = new AmCharts.AmPieChart();
    chartRelation.dataProvider = generateRelationChartData();
    chartRelation.titleField = "type";
    chartRelation.valueField = "percent";
    chartRelation.outlineColor = "#FFFFFF";
    chartRelation.outlineAlpha = 0.4;
    chartRelation.outlineThickness = 2;
    chartRelation.colorField = "color";
    chartRelation.pulledField = "pulled";
    chartRelation.depth3D = 15,
    chartRelation.angle = 30,

    
    // ADD TITLE
    chartRelation.addTitle("Click a slice to see the details");
    
    // AN EVENT TO HANDLE SLICE CLICKS
    chartRelation.addListener("clickSlice", function (event) {
        if (event.dataItem.dataContext.id != undefined) {
            selected = event.dataItem.dataContext.id;
        }
        else {
            selected = undefined;
        }
        chartRelation.dataProvider = generateRelationChartData();
        chartRelation.validateData();
    });


  	//custom add export code
    chartRelation.exportConfig = {
        "menuTop": '20px',
        "menuRight": '20px',
        "menuItems": [{
            "textAlign": 'left',
            "onclick": function () {},
            "icon": '<?php echo SITE_URL;?>amcharts/images/export.png',
            "iconTitle": 'Save chart as an image',
            "items": [{
                "title": 'JPG',
                "format": 'jpg'
            }, {
                "title": 'PNG',
                "format": 'png'
            }, {
                "title": 'SVG',
                "format": 'svg'
            }, {
                "title": 'PDF',
                "format": 'pdf'
            }]
        }],
        "menuItemOutput":{
            "fileName":"New-Users-by-Provider"
        },
        "menuItemStyle": {
            "backgroundColor": 'transparent',
            "rollOverBackgroundColor": '#EFEFEF',
            "color": '#000000',
            "rollOverColor": '#CC0000',
            "paddingTop": '6px',
            "paddingRight": '6px',
            "paddingBottom": '6px',
            "paddingLeft": '6px',
            "marginTop": '0px',
            "marginRight": '0px',
            "marginBottom": '0px',
            "marginLeft": '0px',
            "textAlign": 'left',
            "textDecoration": 'none'
        }
    };

    // WRITE
    chartRelation.write("pieChartRelationDiv");
});
</script>
                            <div id="pieChartRelationDiv" style="width: 100%; height: 500px;"></div>
                        </div>
                    </section>


                    <?php 
                }?>
            </div>
        </div>
    </main>
</div>
<?php include_once("common_lib.php"); ?>
</body>
</html>