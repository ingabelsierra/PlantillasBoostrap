<?php 
include("include/config.php");
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');

if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }

$gender_sql=mysql_query("SELECT SUM(CASE WHEN gender = 'male' THEN 1 ELSE 0 END) `male`, SUM(CASE WHEN gender = 'female' THEN 1 ELSE 0 END) `female` FROM `cs_fb_share_users` WHERE client_id='".$_SESSION['admin_id']."'");
$gender_rec=mysql_fetch_array($gender_sql);
$male=$gender_rec['male'];
$female=$gender_rec['female'];

//$rel_status_sql=mysql_query("SELECT relationship_status, count(relationship_status) as total_user FROM `cs_fb_share_users` WHERE client_id='".$_SESSION['admin_id']."' GROUP BY relationship_status");
$rel_status_sql=mysql_query("SELECT relationship_status, count(*) as total_user FROM `cs_fb_share_users` WHERE client_id='".$_SESSION['admin_id']."' GROUP BY relationship_status ORDER BY relationship_status");
$tot_rel_status=mysql_num_rows($rel_status_sql);

$location_sql=mysql_query("SELECT location, count(location) as tot_location FROM `cs_fb_share_users` WHERE client_id='".$_SESSION['admin_id']."' GROUP BY location");
$tot_location=mysql_num_rows($location_sql);


$likes_sql=mysql_query("SELECT likes, count(likes) as tot_likes FROM `cs_fb_share_users` WHERE client_id='".$_SESSION['admin_id']."' GROUP BY likes");
$tot_likes=mysql_num_rows($likes_sql);


$friends_sql=mysql_query("SELECT SUM(CASE WHEN friends = '1' THEN 1 ELSE 0 END) `lt1`, SUM(CASE WHEN friends > '1' and friends <=5 THEN 1 ELSE 0 END) `gt1_5`, SUM(CASE WHEN friends > '5' and friends <=15 THEN 1 ELSE 0 END) `gt5_15`, SUM(CASE WHEN friends > '15' THEN 1 ELSE 0 END) `gt15` FROM `cs_fb_share_users` WHERE client_id='".$_SESSION['admin_id']."'");
$friends_rec=mysql_fetch_array($friends_sql);
$tot_1=$friends_rec['lt1'];
$tot_1_5=$friends_rec['gt1_5'];
$tot_5_15=$friends_rec['gt5_15'];
$tot_15=$friends_rec['gt15'];
//$female=$friends_rec['female'];


$fb_age_qry="select b.age, count(b.age) as tot_user from (
	           SELECT TIMESTAMPDIFF(YEAR,birthday,CURDATE()) AS age FROM cs_fb_share_users WHERE client_id='".$_SESSION['admin_id']."'
            ) as b group by b.age order by b.age";
$fb_age_sql=mysql_query($fb_age_qry);
$tot_fb_age=mysql_num_rows($fb_age_sql);

$li_age_qry="select b.age, count(b.age) as tot_user from (
	           SELECT if(lid.byear!='0000', TIMESTAMPDIFF(YEAR,concat(lid.byear,'-',lid.bmonth,'-',lid.bday),CURDATE()), '0') as age FROM cs_li_data as lid, cs_users as csu WHERE csu.id=lid.member_id and csu.client_id='".$_SESSION['admin_id']."'
            ) as b group by b.age order by b.age";
$li_age_sql=mysql_query($li_age_qry);
$tot_li_age=mysql_num_rows($li_age_sql);

$common_age_qry="select a.age, count(a.age) as tot_user from 
                ( 
                    select b.* from (
                        SELECT email, TIMESTAMPDIFF(YEAR,birthday,CURDATE()) AS age, 'fb' as type FROM cs_fb_share_users WHERE client_id='".$_SESSION['admin_id']."'
                        union
                        SELECT csu.email, if(byear!='0000', TIMESTAMPDIFF(YEAR,concat(byear,'-',bmonth,'-',bday),CURDATE()), '0') as age, 'li' as type FROM cs_li_data as lid, cs_users as csu WHERE csu.id=lid.member_id and csu.client_id='".$_SESSION['admin_id']."'
                    ) as b group by b.email 
                ) as a group by a.age order by a.age";
$common_age_sql=mysql_query($common_age_qry);
$tot_common_age=mysql_num_rows($common_age_sql);




include("header.php");
?>
<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
        <ol class="breadcrumb">
            <li>YOU ARE HERE</li>
            <li class="active">Reports</li>
        </ol>
        <h1 class="page-title">Visual - <span class="fw-semi-bold">Charts</span></h1>
        <div class="row">
            <div class="col-md-12">
                <section class="widget">
                    <header>
                        <h5>FB Share <span class="fw-semi-bold"> Reports</span></h5>
                        <div class="widget-controls">
                            <a href="#"><i class="glyphicon glyphicon-cog"></i></a>
                            <a data-widgster="close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <!--h3>Share <span class="fw-semi-bold">Table</span></h3>
                        <p>Each row is highlighted. You will never lost there. Just <code>.table-striped</code> it.</p-->
                        <table class="table" style="border: medium none;">
                            <tr>
                                <th rowspan="2">Gender</th>
                                <td>Male :</td>
                                <td><?php echo $male;?></td>
                            </tr>
                            <tr>
                                <td style="border: medium none;">Female :</td>
                                <td style="border: medium none;"><?php echo $female;?></td>
                            </tr>
                            <?php if($tot_location>0)
                            {
                                $flag=0; $location_arr=array();
                                while($location_rec=mysql_fetch_array($location_sql))
                                {
                                    if($flag=="0")
                                    {
                                        ?>
                                        <tr>
                                            <th rowspan="<?php echo $tot_location;?>">Location</th>
                                            <td><?php echo $location_rec['location'];?></td>
                                            <td><?php echo $location_rec['tot_location'];?></td>
                                        </tr>
                                        <?php 
                                    }
                                    else 
                                    {
                                        ?>
                                        <tr>
                                            <td style="border: medium none;"><?php echo $location_rec['location'];?></td>
                                            <td style="border: medium none;"><?php echo $location_rec['tot_location'];?></td>
                                        </tr>
                                        <?php 
                                    }
                                    $flag++;
                                }
                            }?>
                            <?php if($tot_rel_status>0)
                            {
                                $flag=0; 
                                while($rel_status_rec=mysql_fetch_array($rel_status_sql))
                                {
                                    if($flag=="0")
                                    {
                                        ?>
                                        <tr>
                                            <th rowspan="<?php echo $tot_rel_status;?>">Relationship Status</th>
                                            <td><?php if($rel_status_rec['relationship_status']=="") { echo "N/A"; } else { echo $rel_status_rec['relationship_status']; }?></td>
                                            <td><?php echo $rel_status_rec['total_user'];?></td>
                                        </tr>
                                        <?php 
                                    }
                                    else 
                                    {
                                        ?>
                                        <tr>
                                            <td style="border: medium none;"><?php if($rel_status_rec['relationship_status']=="") { echo "N/A"; } else { echo $rel_status_rec['relationship_status']; }?></td>
                                            <td style="border: medium none;"><?php echo $rel_status_rec['total_user'];?></td>
                                        </tr>
                                        <?php 
                                    }
                                    $flag++;
                                }
                            }?>
                            <tr>
                                <th rowspan="4">Friends</th>
                                <td>Only 1 :</td>
                                <td><?php echo $tot_1;?></td>
                            </tr>
                            <tr>
                                <td style="border: medium none;">2 to 5 :</td>
                                <td style="border: medium none;"><?php echo $tot_1_5;?></td>
                            </tr>
                            <tr>
                                <td style="border: medium none;">6 to 15 :</td>
                                <td style="border: medium none;"><?php echo $tot_5_15;?></td>
                            </tr>
                            <tr>
                                <td style="border: medium none;">More then 15 :</td>
                                <td style="border: medium none;"><?php echo $tot_15;?></td>
                            </tr>
                            <?php if($tot_fb_age>0)
                            {
                                $flag=0;
                                $fb_datay=array();
                                while($fb_age_rec=mysql_fetch_array($fb_age_sql))
                                {
                                    $fb_datay[]=$fb_age_rec['tot_user'];
                                    if($flag=="0")
                                    {
                                        ?>
                                        <tr>
                                            <th rowspan="<?php echo $tot_fb_age;?>">Facebook User Age</th>
                                            <td><?php echo $fb_age_rec['age']."&nbsp;Year";?></td>
                                            <td><?php echo $fb_age_rec['tot_user'];?></td>
                                        </tr>
                                        <?php 
                                    }
                                    else 
                                    {
                                        ?>
                                        <tr>
                                            <td style="border: medium none;"><?php echo $fb_age_rec['age']."&nbsp;Year";?></td>
                                            <td style="border: medium none;"><?php echo $fb_age_rec['tot_user'];?></td>
                                        </tr>
                                        <?php 
                                    }
                                    $flag++;
                                }
                            }?>
                            <?php if($tot_li_age>0)
                            {
                                $flag=0; $li_datay[]=$fb_age_rec['tot_user'];
                                while($li_age_rec=mysql_fetch_array($li_age_sql))
                                {
                                    if($flag=="0")
                                    {
                                        $li_datay[]=$li_age_rec['tot_user'];
                                        ?>
                                        <tr>
                                            <th rowspan="<?php echo $tot_li_age;?>">LinkedIn User Age</th>
                                            <td><?php if($li_age_rec['age']>0) { echo $li_age_rec['age']."&nbsp;Year"; } else { echo "N/A"; }?></td>
                                            <td><?php echo $li_age_rec['tot_user'];?></td>
                                        </tr>
                                        <?php 
                                    }
                                    else 
                                    {
                                        ?>
                                        <tr>
                                            <td style="border: medium none;"><?php if($li_age_rec['age']>0) { echo $li_age_rec['age']."&nbsp;Year"; } else { echo "N/A"; }?></td>
                                            <td style="border: medium none;"><?php echo $li_age_rec['tot_user'];?></td>
                                        </tr>
                                        <?php 
                                    }
                                    $flag++;
                                }
                            }?>
                            <?php if($tot_common_age>0)
                            {
                                $flag=0;
                                while($common_age_rec=mysql_fetch_array($common_age_sql))
                                {
                                    if($flag=="0")
                                    {
                                        ?>
                                        <tr>
                                            <th rowspan="<?php echo $tot_common_age;?>">Age Reports</th>
                                            <td><?php if($common_age_rec['age']>0) { echo $common_age_rec['age']."&nbsp;Year"; } else { echo "N/A"; }?></td>
                                            <td><?php echo $common_age_rec['tot_user'];?></td>
                                        </tr>
                                        <?php 
                                    }
                                    else 
                                    {
                                        ?>
                                        <tr>
                                            <td style="border: medium none;"><?php if($common_age_rec['age']>0) { echo $common_age_rec['age']."&nbsp;Year"; } else { echo "N/A"; }?></td>
                                            <td style="border: medium none;"><?php echo $common_age_rec['tot_user'];?></td>
                                        </tr>
                                        <?php 
                                    }
                                    $flag++;
                                }
                            }?>
                        </table>
                    </div>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-5">
                <section class="widget">
                    <header>
                        <h4>
                            Gender <span class="fw-semi-bold">Reports</span>
                        </h4>
                        <div class="widget-controls">
                            <!--a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a-->
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <div id="morris2"></div>
                    </div>
                </section>
                <!--section class="widget">
                    <header>
                        <h4>
                            Location <span class="fw-semi-bold">Reports</span>
                        </h4>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <div id="morris1"></div>
                    </div>
                </section-->
            </div>
            <div class="col-md-6 col-lg-4">
                <section class="widget">
                    <header>
                        <h4>
                            Friends <span class="fw-semi-bold">Reports</span>
                        </h4>
                        <div class="widget-controls">
                            <!--a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a-->
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <div id="morris3"></div>
                    </div>
                </section>
            </div>
            <div class="col-md-6 col-lg-4">
                <section style="padding: 15px 10px;" class="widget">
                    <header>
                        <h4>
                            FB Users Age <span class="fw-semi-bold">Reports</span>
                        </h4>
                        <div class="widget-controls">
                            <!--a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a-->
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <!--iframe style="border: medium none; height: 220px; width: 425px;" src="<?php echo SITE_URL;?>test_bar.php?type=fb_user_age"></iframe-->
                        <img src="<?php echo SITE_URL;?>test_bar.php?type=fb_user_age" alt="" style="width: 100%;" />
                    </div>
                </section>
            </div>
            <div class="col-md-6 col-lg-4">
                <section style="padding: 15px 10px;" class="widget">
                    <header>
                        <h4>
                            LinkedIn Users Age<span class="fw-semi-bold"> Reports</span>
                        </h4>
                        <div class="widget-controls">
                            <!--a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a-->
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <!--iframe id="ifrm_cls" style="border: medium none; height: 220px; width: 425px;" src="<?php echo SITE_URL;?>test_bar.php?type=li_user_age"></iframe-->
                        <img src="<?php echo SITE_URL;?>test_bar.php?type=li_user_age" alt="" style="width: 100%;" />
                    </div>
                </section>
            </div>
            <div class="col-md-6 col-lg-4">
                <section style="padding: 15px 10px;" class="widget">
                    <header>
                        <h4>
                            Age<span class="fw-semi-bold"> Reports</span>
                        </h4>
                        <div class="widget-controls">
                            <!--a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a-->
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <!--iframe id="ifrm_cls" style="border: medium none; height: 220px; width: 425px;" src="<?php echo SITE_URL;?>test_bar.php?type=li_user_age"></iframe-->
                        <img src="<?php echo SITE_URL;?>test_bar.php?type=fb_li_user_age" alt="" style="width: 100%;" />
                    </div>
                </section>
            </div>
            <div class="col-md-6 col-lg-4">
                <section style="padding: 15px 10px;" class="widget">
                    <header>
                        <h4>
                            Relationship Status<span class="fw-semi-bold"> Reports</span>
                        </h4>
                        <div class="widget-controls">
                            <!--a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a-->
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <!--iframe id="ifrm_cls" style="border: medium none; height: 220px; width: 425px;" src="<?php echo SITE_URL;?>test_bar.php?type=li_user_age"></iframe-->
                        <img src="<?php echo SITE_URL;?>relationship_graph.php?type=relationship_status" alt="" style="width: 100%;" />
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

<!-- common app js -->
<script src="js/settings.js"></script>
<script src="js/app.js"></script>

<!-- page specific libs -->
<script src="vendor/jquery.sparkline/dist/jquery.sparkline.js"></script>
<script src="vendor/d3/d3.min.js"></script>
<script src="vendor/rickshaw/rickshaw.min.js"></script>
<script src="vendor/raphael/raphael-min.js"></script>
<script src="vendor/flot.animator/jquery.flot.animator.min.js"></script>
<script src="vendor/flot/jquery.flot.js"></script>
<script src="vendor/flot-orderBars/js/jquery.flot.orderBars.js"></script>
<script src="vendor/flot/jquery.flot.selection.js"></script>
<script src="vendor/flot/jquery.flot.time.js"></script>

<script src="vendor/nvd3/nv.d3.min.js"></script>
<script src="vendor/morris.js/morris.min.js"></script>
<script src="vendor/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>

<!-- page specific js -->
<!--script src="js/modified_charts.js"></script-->
<script type="text/javascript">
    
$(function(){

    function initMorris2(lbl1,val1,lbl2,val2){
        $('#morris2').css({height: 200});
        Morris.Donut({
            element: 'morris2',
            data: [
                {label: lbl1, value: val1},
                {label: lbl2, value: val2}
            ],
            colors: ['#F7653F', '#F8C0A2']
        });
    }

    function initMorris3(lbl1,val1,lbl2,val2,lbl3,val3,lbl4,val4){
        $('#morris3').css({height: 200});
        Morris.Donut({
            element: 'morris3',
            data: [
                {label: lbl1, value: val1},
                {label: lbl2, value: val2},
                {label: lbl3, value: val3},
                {label: lbl4, value: val4}
            ],
            colors: ['#F7653F', '#F8C0A2', '#e6e6e6', '#a6a6a6']
        });
    }
    


    function initMorris1(all_val){
        
        var all_val_arr=all_val.split("~!@#$$#@!~");
        var inner_data='';
        for(var i = 0; i < all_val_arr.length; i++)
        {
            var sub_all_val_arr = all_val_arr[i].split("~!##!~");
            if(((all_val_arr.length)-1)==i) {
                inner_data = inner_data+'{label: "'+sub_all_val_arr[0]+'", value: '+sub_all_val_arr[1]+'}';
            } else {
                inner_data = inner_data+'{label: "'+sub_all_val_arr[0]+'", value: '+sub_all_val_arr[1]+'},';
            }
        }


        
        $('#morris1').css({height: 180});
        Morris.Donut({
            element: 'morris1',
            data: [
                {label: "Not Define", value: 1},
                {label: "Rajkot, Gujarat", value: 2},
                {label: "Sydney, Australia", value: 1}
            ],
            colors: ['#F7653F', '#F8C0A2', '#e6e6e6', '#a6a6a6']
        });

    }



    function pageLoad(){
        //initMorris1('<?php echo implode('~!@#$$#@!~',$location_arr);?>');
        initMorris2('Male','<?php echo $male;?>','Female','<?php echo $female;?>');
        initMorris3('Only 1 Friend','<?php echo $tot_1;?>','2 to 5 Friends','<?php echo $tot_1_5;?>','6 to 15 Friends','<?php echo $tot_5_15;?>','Mote then 15 Friends','<?php echo $tot_15;?>');
    }
    pageLoad();
    SingApp.onPageLoad(pageLoad);
});
    
</script>
</body>
</html>