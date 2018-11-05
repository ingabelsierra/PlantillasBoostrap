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
                                <?php if($_GET['utype']!='dmg')
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
                            
                            <?php if(!isset($_POST['btn_search']))
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
                            } ?>
                        </script>
                    </div>
                </section>
                <?php if(isset($_GET['utype']) && $_GET['utype']=='nru' && isset($_POST['btn_search']))
                {
                    $dateRange=""; $ageRange="";
                    
                    $select_fb_main="select count(*) as total, 'Facebook' as provider from cs_fb_share_users where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_gp_main="select count(*) as total, 'Google+' as provider from cs_gp_users where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    if($_POST['day_range']=='0' ||  $_POST['day_range']=='1')
                    { 
                        $select_fb_main.=" and datediff(current_date,reg_on) >='".$_POST['day_range']."'";
                        $select_gp_main.=" and datediff(current_date,reg_on) >='".$_POST['day_range']."'"; 
                    }
                    else if($_POST['day_range'] > 1) 
                    { 
                        $select_fb_main .=" and datediff(current_date,reg_on) <='".$_POST['day_range']."'"; 
                        $select_gp_main .=" and datediff(current_date,reg_on) <='".$_POST['day_range']."'";
                    }
                    if(isset($_POST['csdate_2']) && $_POST['csdate_2']!='' && isset($_POST['csdate_3']) && $_POST['csdate_3']!='') 
                    { 
                        $select_fb_main.=" and date_format(reg_on,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'"; 
                        $select_gp_main.=" and date_format(reg_on,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'";
                    }
           
                    if($_POST['age_range']=='1') { $select_fb_main.=" and (year(current_date)-year(birthday)) < 13"; }
                    else if($_POST['age_range']=='2') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 13 and (year(current_date)-year(birthday)) <= 17"; }
                    else if($_POST['age_range']=='3') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 18 and (year(current_date)-year(birthday)) <= 34"; }
                    else if($_POST['age_range']=='4') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 35 and (year(current_date)-year(birthday)) <= 49"; }
                    else if($_POST['age_range']=='5') { $select_fb_main.=" and (year(current_date)-year(birthday)) >= 50"; }
                    
                    if($_POST['age_range']=='1') { $select_gp_main.=" and (year(current_date)-year(byear)) < 13"; }
                    else if($_POST['age_range']=='2') { $select_gp_main.=" and (year(current_date)-year(byear)) >= 13 and (year(current_date)-year(byear)) <= 17"; }
                    else if($_POST['age_range']=='3') { $select_gp_main.=" and (year(current_date)-year(byear)) >= 18 and (year(current_date)-year(byear)) <= 34"; }
                    else if($_POST['age_range']=='4') { $select_gp_main.=" and (year(current_date)-year(byear)) >= 35 and (year(current_date)-year(byear)) <= 49"; }
                    else if($_POST['age_range']=='5') { $select_gp_main.=" and (year(current_date)-year(byear)) >= 50"; }

                    
                    $gender_sql=($_POST['gender']!='')?($_POST['gender']=='1')?" and gender='male' ":" and gender='female'":'';
                    $select_fb_main.=$gender_sql;
                    $select_gp_main.=$gender_sql;


                    $select_main=$select_fb_main." union all ".$select_gp_main;
                    
                    $res_grph_1=re_db_query($select_main);
                    $total=re_db_num_rows($res_grph_1);
                    
                    
                    
                    
                    
                    
                    
                    
                    $gender_fb_main="select gender, 'Facebook' as provider from cs_fb_share_users where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $gender_gp_main="select gender, 'Google+' as provider from cs_gp_users where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    if($_POST['day_range']=='0' ||  $_POST['day_range']=='1') 
                    { 
                        $gender_fb_main.=" and datediff(current_date,reg_on) >='".$_POST['day_range']."'"; 
                        $gender_gp_main.=" and datediff(current_date,reg_on) >='".$_POST['day_range']."'";
                    }
                    else if($_POST['day_range'] > 1) 
                    { 
                        $gender_fb_main.=" and datediff(current_date,reg_on) <='".$_POST['day_range']."'"; 
                        $gender_gp_main.=" and datediff(current_date,reg_on) <='".$_POST['day_range']."'";
                    }
                    if(isset($_POST['csdate_2']) && $_POST['csdate_2']!='' && isset($_POST['csdate_3']) && $_POST['csdate_3']!='') 
                    { 
                        $gender_fb_main.=" and date_format(reg_on,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'"; 
                        $gender_gp_main.=" and date_format(reg_on,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'";
                    }

                    $select_main=$gender_fb_main." union all ".$gender_gp_main;

                    $gender_qry="select sum(if(b.gender='male',1,0)) as Male, sum(if(b.gender='female',1,0)) as 'Female' from ( ".$select_main." ) as b";
                    $gender_sql=re_db_query($gender_qry);
                    $gender_rec=re_db_fetch_array($gender_sql);
                    $total_male=$gender_rec['Male']!="" ? $gender_rec['Male'] : "0";
                    $total_female=$gender_rec['Female']!="" ? $gender_rec['Female'] : "0";
                    
                    $fe_gender_qry="select sum(if(b.gender='male',1,0)) as Male, sum(if(b.gender='female',1,0)) as 'Female' from ( ".$gender_fb_main." ) as b";
                    $fe_gender_sql=re_db_query($fe_gender_qry);
                    $fe_gender_rec=re_db_fetch_array($fe_gender_sql);
                    $fb_total_male=$fe_gender_rec['Male']!="" ? $fe_gender_rec['Male'] : "0";
                    $fb_total_female=$fe_gender_rec['Female']!="" ? $fe_gender_rec['Female'] : "0";


                    $gp_gender_qry="select sum(if(b.gender='male',1,0)) as Male, sum(if(b.gender='female',1,0)) as 'Female' from ( ".$gender_gp_main." ) as b";
                    $gp_gender_sql=re_db_query($gp_gender_qry);
                    $gp_gender_rec=re_db_fetch_array($gp_gender_sql);
                    $gp_total_male=$gp_gender_rec['Male']!="" ? $gp_gender_rec['Male'] : "0";
                    $gp_total_female=$gp_gender_rec['Female']!="" ? $gp_gender_rec['Female'] : "0";

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
var chart = AmCharts.makeChart("barChartDiv", {
    "theme": "none",
    "type": "serial",
	"startDuration": 2,
    "dataProvider": [
    <?php $i=0;
    while($row_main=re_db_fetch_array($res_grph_1))
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
},0);
</script>

<script type="text/javascript">
var chart;
var legend;
var selected;

var types = [{
    type: "Male Users",
    percent: <?php echo $total_male;?>, 
    color: "#ff9e01",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_male;?> },
        { type: "Google+", percent: <?php echo $gp_total_male;?> }
    ]},
{
    type: "Female Users",
    percent: <?php echo $total_female;?>,
    color: "#b0de09",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_female;?> },
        { type: "Google+", percent: <?php echo $gp_total_female;?> }
    ]}
];

function generateChartData () {
    var chartData = [];
    for (var i = 0; i < types.length; i++) {
        if (i == selected) {
            for (var x = 0; x < types[i].subs.length; x++) {
                chartData.push({
                    type: types[i].subs[x].type,
                    percent: types[i].subs[x].percent,
                    color: types[i].color,
                    pulled: true
                });
            }
        }
        else {
            chartData.push({
                type: types[i].type,
                percent: types[i].percent,
                color: types[i].color,
                id: i
            });
        }
    }
    return chartData;
}

AmCharts.ready(function() {
    // PIE CHART
    chart = new AmCharts.AmPieChart();
    chart.dataProvider = generateChartData();
    chart.titleField = "type";
    chart.valueField = "percent";
    chart.outlineColor = "#FFFFFF";
    chart.outlineAlpha = 0.8;
    chart.outlineThickness = 2;
    chart.colorField = "color";
    chart.pulledField = "pulled";
    chart.depth3D = 15,
    chart.angle = 30,

    
    // ADD TITLE
    chart.addTitle("Click a slice to see the details");
    
    // AN EVENT TO HANDLE SLICE CLICKS
    chart.addListener("clickSlice", function (event) {
        if (event.dataItem.dataContext.id != undefined) {
            selected = event.dataItem.dataContext.id;
        }
        else {
            selected = undefined;
        }
        chart.dataProvider = generateChartData();
        chart.validateData();
    });

    // WRITE
    chart.write("pieChartDiv");
});
</script>
                            <div id="barChartDiv" style="width: 300px; height: 250px;"></div>
                            <div id="pieChartDiv" style="width: 100%; height: 500px;"></div>
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
<?php
                    $select_fb_main="select (year(current_date)-year(birthday)) as age, 'Facebook' as provider  from cs_fb_share_users where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_gp_main="select if(byear!='0000',(year(current_date)-byear),0) as age, 'Google+' as provider from cs_gp_users where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_li_main="select if(byear!='0000',(year(current_date)-byear),0) as age, 'LinkedIn' as provider from cs_li_data where reg_on is not null and client_id='".$_SESSION['admin_id']."'";

                    $day_rande_main="";
                    if($_POST['day_range']=='0' ||  $_POST['day_range']=='1') { $day_rande_main=" and datediff(current_date,reg_on) ='".$_POST['day_range']."'"; }
                    else if($_POST['day_range'] > 1) { $day_rande_main=" and datediff(current_date,reg_on) <='".$_POST['day_range']."'"; }
                    if(isset($_POST['csdate_2']) && $_POST['csdate_2']!='' && isset($_POST['csdate_3']) && $_POST['csdate_3']!='') { $day_rande_main.=" and date_format(reg_on,'%Y-%m-%d') between '".input_date($_POST['csdate_2'])."' and '".input_date($_POST['csdate_3'])."'"; }
                    $select_fb_main.=$day_rande_main;
                    $select_gp_main.=$day_rande_main;
                    $select_li_main.=$day_rande_main;
                    
                    $select_main=$select_fb_main." union all ".$select_gp_main." union all ".$select_li_main;

                    $main_age_arr=array(); $fb_age_arr=array(); $gp_age_arr=array(); $li_age_arr=array();
                    $main_age_qry="SELECT COUNT(*) as total, CASE WHEN age = 0 THEN 'NP' WHEN age > 0 AND age < 13 THEN '13' WHEN age >=13 AND age <=17 THEN '13-17' WHEN age >=18 AND age <=34 THEN '18-34' WHEN age >=35 AND age <= 49 THEN '35-49' WHEN age >=50 THEN '50+' END AS ageband FROM ( ".$select_main." ) as tbl GROUP BY ageband";
                    $main_age_sql=re_db_query($main_age_qry);
                    if(re_db_num_rows($main_age_sql)>0)
                    {
                        while($main_age_rec=re_db_fetch_array($main_age_sql)) {
                            $main_age_arr[$main_age_rec['ageband']]=$main_age_rec['total'];
                        }
                    }
                    $fb_sub_age_qry="SELECT COUNT(*) as total, CASE WHEN age = 0 THEN 'NP' WHEN age > 0 AND age < 13 THEN '13' WHEN age >=13 AND age <=17 THEN '13-17' WHEN age >=18 AND age <=34 THEN '18-34' WHEN age >=35 AND age <= 49 THEN '35-49' WHEN age >=50 THEN '50+' END AS ageband FROM ( ".$select_fb_main." ) as tbl GROUP BY ageband";
                    $fb_sub_age_sql=re_db_query($fb_sub_age_qry);
                    if(re_db_num_rows($fb_sub_age_sql)>0)
                    {
                        while($fb_sub_age_rec=re_db_fetch_array($fb_sub_age_sql)) {
                            $fb_age_arr[$fb_sub_age_rec['ageband']]=$fb_sub_age_rec['total'];
                        }
                    }
                    
                    $gp_sub_age_qry="SELECT COUNT(*) as total, CASE WHEN age = 0 THEN 'NP' WHEN age > 0 AND age < 13 THEN '13' WHEN age >=13 AND age <=17 THEN '13-17' WHEN age >=18 AND age <=34 THEN '18-34' WHEN age >=35 AND age <= 49 THEN '35-49' WHEN age >=50 THEN '50+' END AS ageband FROM ( ".$select_gp_main." ) as tbl GROUP BY ageband";
                    $gp_sub_age_sql=re_db_query($gp_sub_age_qry);
                    if(re_db_num_rows($gp_sub_age_sql)>0)
                    {
                        while($gp_sub_age_rec=re_db_fetch_array($gp_sub_age_sql)) {
                            $gp_age_arr[$gp_sub_age_rec['ageband']]=$gp_sub_age_rec['total'];
                        }
                    }

                    $li_sub_age_qry="SELECT COUNT(*) as total, CASE WHEN age = 0 THEN 'NP' WHEN age > 0 AND age < 13 THEN '13' WHEN age >=13 AND age <=17 THEN '13-17' WHEN age >=18 AND age <=34 THEN '18-34' WHEN age >=35 AND age <= 49 THEN '35-49' WHEN age >=50 THEN '50+' END AS ageband FROM ( ".$select_li_main." ) as tbl GROUP BY ageband";
                    $li_sub_age_sql=re_db_query($li_sub_age_qry);
                    if(re_db_num_rows($li_sub_age_sql)>0)
                    {
                        while($li_sub_age_rec=re_db_fetch_array($li_sub_age_sql)) {
                            $li_age_arr[$li_sub_age_rec['ageband']]=$li_sub_age_rec['total'];
                        }
                    }
?>
<script type="text/javascript">
var chartAge;
var typesAge = [
    <?php $i=0; $total=count($main_age_arr);
    foreach($main_age_arr as $key => $val)
    {
        $i++;
        if($key=="NP") { $title = 'Age Not Provided'; }
        else if($key=="13") { $title = 'Age Under 13 Year'; }
        else if($key=="50+") { $title = 'Age 50 Year or Above'; }
        else { $title = 'Age Between '.$key.' Year'; }
        ?>
        {
        type: "<?php echo $title;?>",
        percent: <?php echo $val;?>, 
        color: "<?php echo $color_arr[$i];?>",
        subs: [
            { type: "Facebook", percent: <?php echo isset($fb_age_arr[$key]) ? $fb_age_arr[$key] : "0";?> },
            { type: "Google+", percent: <?php echo isset($gp_age_arr[$key]) ? $gp_age_arr[$key] : "0";?> },
            { type: "LinkedIn", percent: <?php echo isset($li_age_arr[$key]) ? $li_age_arr[$key] : "0";?> }
        ]}<?php if($i<$total) { echo ','; } 
    } ?>
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
                    <?php 
                } ?>
            </div>
        </div>
    </main>
</div>
<?php include_once("common_lib.php"); ?>
</body>
</html>