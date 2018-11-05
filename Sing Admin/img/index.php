<?php
include("include/config.php");

if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }

$color_arr=array('#FF0F00','#FF6600','#FF9E01','#FCD202','#F8FF01','#B0DE09','#04D215','#0D8ECF','#0D52D1','#2A0CD0','#8A0CCF','#CD0D74','#754DEB','#DDDDDD','#DDDDDD','#333333','#000000');


include("header.php");
?>
<script src="amcharts/amcharts.js" type="text/javascript"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/serial.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/pie.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/themes/none.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/exporting/amexport_combined.js"></script>
<div class="chat-sidebar" id="chat">
    <div class="chat-sidebar-content">
        <header class="chat-sidebar-header">
            <h4 class="chat-sidebar-title">Contacts</h4>
            <div class="form-group no-margin">
                <div class="input-group input-group-dark">
                    <input class="form-control fs-mini" id="chat-sidebar-search" type="text" placeholder="Search..." />
                    <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </span>
                </div>
            </div>
        </header>
    </div>
</div>

<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
        <h1 class="page-title">Dashboard <small><small>The Lucky One</small></small></h1>
        <!--div class="row">
            <div class="col-md-8">
                <section class="widget bg-transparent">
                    <div class="widget-body">
                        <div id="map" class="mapael">
                            <div class="stats">
                                <h5 class="text-white">GEO-LOCATIONS</h5>
                                <p class="h3 text-warning no-margin"><strong id="geo-locations-number">1 656 843</strong> <i class="fa fa-map-marker"></i></p>
                            </div>
                            <div class="map">
                                <span>Alternative content for the map</span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="widget bg-transparent">
                    <header>
                        <h4>
                            Map
                            <span class="fw-semi-bold">Statistics</span>
                        </h4>
                        <div class="widget-controls widget-controls-hover">
                            <a href="#"><i class="glyphicon glyphicon-cog"></i></a>
                            <a href="#"><i class="fa fa-refresh"></i></a>
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <p>Status: <strong>Live</strong></p>
                        <p>
                            <span class="circle bg-warning"><i class="fa fa-map-marker"></i></span>
                            146 Countries, 2759 Cities
                        </p>
                        <div class="row progress-stats">
                            <div class="col-sm-9">
                                <h5 class="name">Foreign Visits</h5>
                                <p class="description deemphasize">Some Cool Text</p>
                                <div class="progress progress-sm js-progress-animate bg-white">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                         data-width="60%"
                                         aria-valuemax="100" style="width: 0;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 text-align-center">
                                <span class="status rounded rounded-lg bg-body-light">
                                    <small><span id="percent-1">75</span>%</small>
                                </span>
                            </div>
                        </div>
                        <div class="row progress-stats">
                            <div class="col-sm-9">
                                <h5 class="name">Local Visits</h5>
                                <p class="description deemphasize">P. to C. Conversion</p>
                                <div class="progress progress-sm js-progress-animate bg-white">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="39"
                                         data-width="39%"
                                         aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 text-align-center">
                                <span class="status rounded rounded-lg bg-body-light">
                                    <small><span  id="percent-2">84</span>%</small>
                                </span>
                            </div>
                        </div>
                        <div class="row progress-stats">
                            <div class="col-sm-9">
                                <h5 class="name">Sound Frequencies</h5>
                                <p class="description deemphasize">Average Bitrate</p>
                                <div class="progress progress-sm js-progress-animate bg-white">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80"
                                         data-width="80%"
                                         aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 text-align-center">
                                <span class="status rounded rounded-lg bg-body-light">
                                    <small><span id="percent-3">92</span>%</small>
                                </span>
                            </div>
                        </div>
                        <h5 class="fw-semi-bold mt">Map Distributions</h5>
                        <p>Tracking: <strong>Active</strong></p>
                        <p>
                            <span class="circle bg-warning"><i class="fa fa-cog"></i></span>
                            391 elements installed, 84 sets
                        </p>
                        <div class="input-group mt">
                            <input type="text" class="form-control" placeholder="Search Map">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-search text-gray"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </section>
            </div>
        </div-->
        <div class="row">
            <div class="col-md-12">
                <section class="widget">
                    <header>
                        <h5>View Statistics in Chart for</h5>
                        <div class="widget-controls">
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <form name="chart_frm" id="chart_frm" action="" method="post">
                            <table class="table">
                                <tr>
                                    <td>
                                        <div class="col-sm-3" style="width: auto;">
                                            <div class="radio">
                                                <input type="radio" name="day_range" id="radio1" value="0"<?php if(isset($_POST['day_range']) && $_POST['day_range']=="0") { echo ' checked="checked"';}?> />
                                                <label for="radio1">Today</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3" style="width: auto;">
                                            <div class="radio">
                                                <input type="radio" name="day_range" id="radio2" value="1"<?php if(isset($_POST['day_range']) && $_POST['day_range']=="1") { echo ' checked="checked"';}?> />
                                                <label for="radio2">Yesterday</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3" style="width: auto;">
                                            <div class="radio">
                                                <input type="radio" name="day_range" id="radio3" value="6"<?php if(isset($_POST['day_range']) && $_POST['day_range']=="6") { echo ' checked="checked"';}?> />
                                                <label for="radio3">Last 7 Days</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3" style="width: auto;">
                                            <div class="radio">
                                                <input type="radio" name="day_range" id="radio4" value="30"<?php if((isset($_POST['day_range']) && $_POST['day_range']=="30") || !isset($_POST['day_range'])) { echo ' checked="checked"';}?> />
                                                <label for="radio4">Last 30 Days</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3" style="width: auto;"><div class="radio"><input class="btn btn-default btn-sm" type="submit" name="submit_btn" value="Show Result" /></div></div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <section class="widget">
                    <header>
                        <h5>New Registered Users</h5>
                        <div class="widget-controls">
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                    <?php
                    $dateRange=""; $ageRange="";
                    
                    $select_fb_main="select '1' as is_from, reg_on from cs_fb_share_users where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_li_main="select '2' as is_from, reg_on from cs_li_data where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_gp_main="select '3' as is_from, reg_on from cs_gp_users where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_yh_main="select '5' as is_from, reg_on from cs_yahoo_data where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_ig_main="select '6' as is_from, reg_on from cs_ig_data where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    
                    $select_main="";
                    if(isset($_POST['day_range']) && $_POST['day_range']<='1') { $select_main.=" and datediff(current_date,reg_on) ='".$_POST['day_range']."'"; }
                    else if(isset($_POST['day_range']) && $_POST['day_range'] > 1)  { $select_main .=" and datediff(current_date,reg_on) <='".$_POST['day_range']."'"; }
                    else { $select_main .=" and datediff(current_date,reg_on) <='30'"; }
                    $select_fb_main.=$select_main;
                    $select_li_main.=$select_main;
                    $select_gp_main.=$select_main;
                    $select_yh_main.=$select_main;
                    $select_ig_main.=$select_main;

                    $select_main="select sum(if(a.is_from=1,1,0)) as fb_user, sum(if(a.is_from=2,1,0)) as li_user, sum(if(a.is_from=3,1,0)) as gp_user, sum(if(a.is_from=5,1,0)) as yh_user, sum(if(a.is_from=6,1,0)) as ig_user, date_format(a.reg_on,'%m-%d-%Y') as login_date from 
                                (
                                    ".$select_fb_main." union all ".$select_gp_main." union all ".$select_li_main." union all ".$select_yh_main." union all ".$select_ig_main." 
                                ) as a group by date_format(a.reg_on,'%Y-%m-%d')";
                    
                    $res_grph=re_db_query($select_main);
                    $total=re_db_num_rows($res_grph);
                    ?>
<script type="text/javascript">
var chart = AmCharts.makeChart("nruBarChartDiv", {
    "type": "serial",
	"theme": "none",
    "startDuration": 2,
    "depth3D":20,
    "angle":30,
    "legend": {
        "menuTop": '0px',
        "horizontalGap": 1,
        "maxColumns": 1,
        "position": "right",
		"useGraphSettings": true,
		"markerSize": 10,
        "marginRight": 0,
        "valueWidth":15
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
        "menuRight": '0px',
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
                        <div id="nruBarChartDiv" style="width: 100%; height: 300px;"></div>
                    </div>
                </section>
            </div>
            <div class="col-md-6">
                <section class="widget">
                    <header>
                        <h5>New Users by Gender</h5>
                        <div class="widget-controls">
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">

<?php
                    $dateRange=""; $ageRange="";

                    $gender_fb_main="select gender, 'Facebook' as provider from cs_fb_share_users where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $gender_gp_main="select gender, 'Google+' as provider from cs_gp_users where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $gender_yh_main="select gender, 'Yahoo' as provider from cs_yahoo_data where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $gender_li_main="select 'NA' as gender, 'LinkedIn' as provider from cs_li_data where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $gender_ig_main="select 'NA' as gender, 'Instagram' as provider from cs_ig_data where reg_on is not null and client_id='".$_SESSION['admin_id']."'";

                    
                    $gender_main="";
                    if(isset($_POST['day_range']) && ($_POST['day_range']=='0' || $_POST['day_range']=='1')) { $gender_main=" and datediff(current_date,reg_on) ='".$_POST['day_range']."'"; }
                    else if(isset($_POST['day_range']) && $_POST['day_range'] > 1) { $gender_main=" and datediff(current_date,reg_on) <='".$_POST['day_range']."'"; }
                    else { $gender_main=" and datediff(current_date,reg_on) <='30'"; }
                    
                    $gender_fb_main.=$gender_main;
                    $gender_gp_main.=$gender_main;
                    $gender_yh_main.=$gender_main;
                    $gender_li_main.=$gender_main;
                    $gender_ig_main.=$gender_main;

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
?>
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
    chartGender.marginTop = 0;
    //chartGender.labelRadius = -1;
    chartGender.labelsEnabled = 0;
    chartGender.titleField = "type";
    chartGender.valueField = "percent";
    chartGender.outlineColor = "#FFFFFF";
    chartGender.outlineAlpha = 0.4;
    chartGender.outlineThickness = 2;
    chartGender.colorField = "color";
    chartGender.pulledField = "pulled";

    // add legende
    chartGender.legend = {
        markerType: "circle",
        marginRight: 0,
        valueWidth:15,
        position: "right",
		autoMargins: false
    };
    
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
        "menuRight": '0px',
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
                        <div id="pieChartGenderDiv" style="width: 100%; height: 300px;"></div>
                    </div>
                </section>
            </div>
            <div class="col-md-6">
                <section class="widget">
                    <header>
                        <h5>New Users by Age</h5>
                        <div class="widget-controls">
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
<?php
                    $select_fb_main="select (year(current_date)-year(birthday)) as age, 'Facebook' as provider  from cs_fb_share_users where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_gp_main="select if(byear!='0000',(year(current_date)-year(byear)),0) as age, 'Google+' as provider from cs_gp_users where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_li_main="select if(byear!='0000',(year(current_date)-byear),0) as age, 'LinkedIn' as provider from cs_li_data where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_yh_main="select '0' as age, 'Yahoo' as provider from cs_yahoo_data where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_ig_main="select '0' as age, 'Instagram' as provider from cs_ig_data where reg_on is not null and client_id='".$_SESSION['admin_id']."'";


                    $day_rande_main="";
                    if(isset($_POST['day_range']) && ($_POST['day_range']=='0' ||  $_POST['day_range']=='1')) { $day_rande_main=" and datediff(current_date,reg_on) ='".$_POST['day_range']."'"; }
                    else if(isset($_POST['day_range']) && $_POST['day_range'] > 1) { $day_rande_main=" and datediff(current_date,reg_on) <='".$_POST['day_range']."'"; }
                    else { $day_rande_main=" and datediff(current_date,reg_on) <='30'";}
                    $select_fb_main.=$day_rande_main;
                    $select_gp_main.=$day_rande_main;
                    $select_li_main.=$day_rande_main;
                    $select_yh_main.=$day_rande_main;
                    $select_ig_main.=$day_rande_main;

                    
                    $select_main=$select_fb_main." union all ".$select_gp_main." union all ".$select_li_main." union all ".$select_yh_main." union all ".$select_ig_main;


                    $main_age_qry="select sum(if(b.age=0,1,0)) as NP, sum(if(b.age>0 and b.age<13,1,0)) as LT13, sum(if(b.age>=13 and b.age <= 17,1,0)) as GT13_LT17, sum(if(b.age>=18 and b.age <= 34,1,0)) as GT18_LT34, sum(if(b.age>=35 and b.age <= 49,1,0)) as GT35_LT49, sum(if(b.age>=50,1,0)) as GT50, 'Facebook' as provider from ( ".$select_main." ) as b order by b.age";
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
?>
<script type="text/javascript">
var chartAge;
var typesAge = [{
    type: "Not Provided",
    percent: <?php echo $total_np;?>, 
    color: "<?php echo $color_arr[5];?>",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_np;?> },
        { type: "Google+", percent: <?php echo $gp_total_np;?> },
        { type: "LinkedIn", percent: <?php echo $li_total_np;?> },
        { type: "Yahoo", percent: <?php echo $yh_total_np;?> },
        { type: "Instagram", percent: <?php echo $ig_total_np;?> }
    ]}, {
    type: "Under 13 Year",
    percent: <?php echo $total_13;?>, 
    color: "<?php echo $color_arr[0];?>",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_13;?> },
        { type: "Google+", percent: <?php echo $gp_total_13;?> },
        { type: "LinkedIn", percent: <?php echo $li_total_13;?> },
        { type: "Yahoo", percent: <?php echo $yh_total_13;?> },
        { type: "Instagram", percent: <?php echo $ig_total_13;?> }
    ]}, {
    type: "13 to 17 Year",
    percent: <?php echo $total_13_17;?>,
    color: "<?php echo $color_arr[1];?>",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_13_17;?> },
        { type: "Google+", percent: <?php echo $gp_total_13_17;?> },
        { type: "LinkedIn", percent: <?php echo $li_total_13_17;?> },
        { type: "Yahoo", percent: <?php echo $yh_total_13_17;?> },
        { type: "Instagram", percent: <?php echo $ig_total_13_17;?> }
    ]}, {
    type: "18 to 34 Year",
    percent: <?php echo $total_18_34;?>,
    color: "<?php echo $color_arr[2];?>",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_18_34;?> },
        { type: "Google+", percent: <?php echo $gp_total_18_34;?> },
        { type: "LinkedIn", percent: <?php echo $li_total_18_34;?> },
        { type: "Yahoo", percent: <?php echo $yh_total_18_34;?> },
        { type: "Instagram", percent: <?php echo $ig_total_18_34;?> }
    ]}, {
    type: "35 to 49 Year",
    percent: <?php echo $total_35_49;?>,
    color: "<?php echo $color_arr[3];?>",
    subs: [
        { type: "Facebook", percent: <?php echo $fb_total_35_49;?> },
        { type: "Google+", percent: <?php echo $gp_total_35_49;?> },
        { type: "LinkedIn", percent: <?php echo $li_total_35_49;?> },
        { type: "Yahoo", percent: <?php echo $yh_total_35_49;?> },
        { type: "Instagram", percent: <?php echo $ig_total_35_49;?> }
    ]}, {
    type: "50 Year or Above",
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
    chartAge.marginTop = 0;
    //chartAge.labelRadius = -1;
    chartAge.labelsEnabled = 0;
    chartAge.titleField = "type";
    chartAge.valueField = "percent";
    chartAge.outlineColor = "#FFFFFF";
    chartAge.outlineAlpha = 0.4;
    chartAge.outlineThickness = 2;
    chartAge.colorField = "color";
    chartAge.pulledField = "pulled";

    // add legende
    chartAge.legend = {
        markerType: "circle",
        marginRight: 0,
        valueWidth:15,
        position: "right",
		autoMargins: false
    };
    
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
        "menuRight": '0px',
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
                        <div id="pieChartAgeDiv" style="width: 100%; height: 300px;"></div>
                    </div>
                </section>
            </div>
            <div class="col-md-6">
                <section class="widget">
                    <header>
                        <h5>New Users by Relationship Status</h5>
                        <div class="widget-controls">
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
<?php
                    // code for generate relationship status

                    $select_fb_main="select if(relationship_status!='',relationship_status,'Not Provided') as relation_status, relationship_status as relation from cs_fb_share_users where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_gp_main="select if(relationship_status!='',relationship_status,'Not Provided') as relation_status, relationship_status as relation from cs_gp_users where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_li_main="select 'Not Provided' as relation_status, '' as relation from cs_li_data where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_yh_main="select 'Not Provided' as relation_status, '' as relation from cs_yahoo_data where reg_on is not null and client_id='".$_SESSION['admin_id']."'";
                    $select_ig_main="select 'Not Provided' as relation_status, '' as relation from cs_ig_data where reg_on is not null and client_id='".$_SESSION['admin_id']."'";

                    $select_main="";
                    if(isset($_POST['day_range']) && ($_POST['day_range']=='0' ||  $_POST['day_range']=='1')) { $select_main.=" and datediff(current_date,reg_on) ='".$_POST['day_range']."'"; }
                    else if(isset($_POST['day_range']) && $_POST['day_range'] > 1) { $select_main .=" and datediff(current_date,reg_on) <='".$_POST['day_range']."'"; }
                    else { $select_main .=" and datediff(current_date,reg_on) <='30'"; }
                    $select_fb_main.=$select_main;
                    $select_gp_main.=$select_main;
                    $select_li_main.=$select_main;
                    $select_yh_main.=$select_main;
                    $select_ig_main.=$select_main;

                    
                    $select_main_qry="select a.relation_status, count(*) as tot, relation from 
                                    ( ".$select_fb_main." union all ".$select_gp_main." union all ".$select_li_main." ) 
                                    as a group by a.relation_status order by relation_status";
                    $select_main_sql=re_db_query($select_main_qry);
                    $tot_rec=re_db_num_rows($select_main_sql);

?>
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
        $sub_fb_main="select count(*) as total, 'Facebook' as Provider, relationship_status from cs_fb_share_users where reg_on is not null and relationship_status='".$main_rec['relation']."' and client_id='".$_SESSION['admin_id']."' ".$select_main." group by relationship_status";
        $sub_gp_main="select count(*) as total, 'Google+' as Provider, relationship_status from cs_gp_users where reg_on is not null and relationship_status='".$main_rec['relation']."' and client_id='".$_SESSION['admin_id']."' ".$select_main." group by relationship_status";
        $sub_li_main="select count(*) as total, 'LinkedIn' as Provider, '' as relationship_status from cs_li_data where reg_on is not null and client_id='".$_SESSION['admin_id']."' ".$select_main." group by relationship_status HAVING relationship_status='".$main_rec['relation']."'";
        $sub_yh_main="select count(*) as total, 'Yahoo' as Provider, '' as relationship_status from cs_yahoo_data where reg_on is not null and client_id='".$_SESSION['admin_id']."' ".$select_main." group by relationship_status HAVING relationship_status='".$main_rec['relation']."'";
        $sub_ig_main="select count(*) as total, 'Instagram' as Provider, '' as relationship_status from cs_ig_data where reg_on is not null and client_id='".$_SESSION['admin_id']."' ".$select_main." group by relationship_status HAVING relationship_status='".$main_rec['relation']."'";
        $sub_main_qry=$sub_fb_main." union all ".$sub_gp_main." union all ".$sub_li_main." union all ".$sub_yh_main." union all ".$sub_ig_main;
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
    chartRelation.marginTop = 0;
    //chartRelation.labelRadius = -1;
    chartRelation.labelsEnabled = 0;
    chartRelation.titleField = "type";
    chartRelation.valueField = "percent";
    chartRelation.outlineColor = "#FFFFFF";
    chartRelation.outlineAlpha = 0.4;
    chartRelation.outlineThickness = 2;
    chartRelation.colorField = "color";
    chartRelation.pulledField = "pulled";

    // add legende
    chartRelation.legend = {
        markerType: "circle",
        marginRight: 0,
        valueWidth:15,
        position: "right",
		autoMargins: false
    };

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
        "menuRight": '0px',
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
                        <div id="pieChartRelationDiv" style="width: 100%; height: 300px;"></div>
                    </div>
                </section>
            </div>
            <div class="col-md-6">
                <section class="widget">
                    <header>
                        <h5>Revenue by Provider</h5>
                        <div class="widget-controls">
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
<?php
                    $dateRange=""; $ageRange="";
                    
                    $select_rev_main="select sum(if(ot.is_from=1,ot.order_amt,0)) as fb_total, sum(if(ot.is_from=2,ot.order_amt,0)) as li_total, sum(if(ot.is_from=3,ot.order_amt,0)) as gp_total, sum(if(ot.is_from=5,ot.order_amt,0)) as yh_total, sum(if(ot.is_from=6,ot.order_amt,0)) as ig_total, date_format(ot.date_time,'%m-%d-%Y') as order_date from cs_track_orders as ot, `cs_users` as csu where csu.id=ot.ref_by and ot.client_id=csu.client_id and ot.date_time is not null and ot.client_id='".$_SESSION['admin_id']."' ";
                    if(isset($_POST['day_range']) && ($_POST['day_range']=='0' ||  $_POST['day_range']=='1')) { $select_rev_main.=" and datediff(current_date,ot.date_time) ='".$_POST['day_range']."'"; }
                    else if(isset($_POST['day_range']) && $_POST['day_range'] > 1) { $select_rev_main.=" and datediff(current_date,ot.date_time) <='".$_POST['day_range']."'"; }
                    else { $select_rev_main.=" and datediff(current_date,ot.date_time) <='30'"; }
                    $select_rev_main.=" group by date_format(ot.date_time,'%m-%d-%Y')";
                    
                    $rev_main_sql=re_db_query($select_rev_main);
                    $total=re_db_num_rows($rev_main_sql);
?>
<script type="text/javascript">
var chart = AmCharts.makeChart("rbpBarChartDiv", {
    "type": "serial",
	"theme": "none",
    "startDuration": 2,
    "depth3D":20,
    "angle":30,
    "legend": {
        "menuTop": '0px',
        "horizontalGap": 1,
        "maxColumns": 1,
        "position": "right",
		"useGraphSettings": true,
		"markerSize": 10,
        "marginRight": 0,
        "valueWidth":15
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
        "menuRight": '0px',
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
                        <div id="rbpBarChartDiv" style="width: 100%; height: 300px;"></div>
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
<script src="vendor/jquery-touchswipe/jquery.touchSwipe.js"></script>

<!-- common app js -->
<script src="js/settings.js"></script>
<script src="js/app.js"></script>

<!-- page specific libs -->
<script id="test" src="vendor/underscore/underscore.js"></script>
<!--script src="vendor/jquery.sparkline/dist/jquery.sparkline.js"></script>
<script src="vendor/d3/d3.min.js"></script>
<script src="vendor/rickshaw/rickshaw.min.js"></script>
<script src="vendor/raphael/raphael-min.js"></script>
<script src="vendor/jQuery-Mapael/js/jquery.mapael.js"></script>
<script src="vendor/jQuery-Mapael/js/maps/usa_states.js"></script>
<script src="vendor/jQuery-Mapael/js/maps/world_countries.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/popover.js"></script>
<script src="vendor/bootstrap-calendar/bootstrap_calendar/js/bootstrap_calendar.min.js"></script>
<script src="vendor/jquery-animateNumber/jquery.animateNumber.min.js"></script-->

<!-- page specific js -->
<script src="js/index.js"></script>
</body>
</html>