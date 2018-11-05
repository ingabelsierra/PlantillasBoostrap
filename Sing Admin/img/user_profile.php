<?php 
include("include/config.php");
if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }

$select_cu="select email from cs_users where id='".mysql_real_escape_string($_GET['mid'])."'";
$res_cu=re_db_query($select_cu);
$row_cu=re_db_fetch_array($res_cu);

$fb_data_qry="select * from cs_fb_share_users where member_id='".mysql_real_escape_string($_GET['mid'])."' and client_id='".$_SESSION['admin_id']."' ";
$fb_data_sql=re_db_query($fb_data_qry);


$li_data_qry="select lid.*, csu.email from cs_li_data as lid, cs_users as csu where csu.id=lid.member_id and csu.client_id='".$_SESSION['admin_id']."' and member_id='".mysql_real_escape_string($_GET['mid'])."' ";
$li_data_sql=re_db_query($li_data_qry);

$gp_data_qry="select * from cs_gp_users where member_id='".mysql_real_escape_string($_GET['mid'])."' and client_id='".$_SESSION['admin_id']."' ";
$gp_data_sql=re_db_query($gp_data_qry);

$yh_data_qry="select * from cs_yahoo_data where member_id='".mysql_real_escape_string($_GET['mid'])."' and client_id='".$_SESSION['admin_id']."' ";
$yh_data_sql=re_db_query($yh_data_qry);

$ig_data_qry="select * from cs_ig_data where member_id='".mysql_real_escape_string($_GET['mid'])."' and client_id='".$_SESSION['admin_id']."' ";
$ig_data_sql=re_db_query($ig_data_qry);


$is_profile=0;
if(re_db_num_rows($fb_data_sql)>0 || re_db_num_rows($gp_data_sql)>0 || re_db_num_rows($li_data_sql)>0 || re_db_num_rows($yh_data_sql)>0 || re_db_num_rows($ig_data_sql)>0  )
{
    $is_profile=1;
    $fb_data_rec=re_db_fetch_array($fb_data_sql);
    $li_data_rec=re_db_fetch_array($li_data_sql);
    $gp_data_rec=re_db_fetch_array($gp_data_sql);
    $yh_data_rec=re_db_fetch_array($yh_data_sql);
    $ig_data_rec=re_db_fetch_array($ig_data_sql);
    
    if($fb_data_rec['profile_pic'])
    {
        $profle_pic=$fb_data_rec['profile_pic'];
    }
    else if($li_data_rec['pictureUrl'])
    {
        $profle_pic=$li_data_rec['pictureUrl'];
        
    }
    else if($gp_data_rec['profile_pic'])
    {
        $profle_pic=$gp_data_rec['profile_pic'];
    }
    else if($yh_data_rec['profile_pic'])
    {
        $profle_pic=$yh_data_rec['profile_pic'];
    }
    else if($ig_data_rec['profile_pic'])
    {
        $profle_pic=$ig_data_rec['profile_pic'];
    }
    else
    {
        $profle_pic=SITE_URL."img/avatar.png";
    }
    if($fb_data_rec['uname'])
    {
        $profle_name=$fb_data_rec['uname'];
    }
    else if($li_data_rec['firstname'])
    {
        $profle_name=$li_data_rec['firstname']." ".$li_data_rec['lastname'];
        
    }
    else if($gp_data_rec['name'])
    {
        $profle_name=$gp_data_rec['name'];
    }
    else if($yh_data_rec['full_name'])
    {
        $profle_name=$yh_data_rec['full_name'];
    }
    else if($ig_data_rec['full_name'])
    {
        $profle_name=$ig_data_rec['full_name'];
    }
    else
    {
        $profle_name='N/A';
    }   
    $headline=($li_data_rec['headline'])?$li_data_rec['headline']:'N/A';
    
    $email=$row_cu['email'];
    
    if($fb_data_rec['birthday'])
    {
        $birth_day=date('F d, Y', strtotime($fb_data_rec['birthday']));
    }
    else if($li_data_rec['bday']!='0' && $li_data_rec['bmonth']!='0')
    {
       $birth_day=($li_data_rec['byear']!='0000')?date('F d, Y',strtotime($li_data_rec['byear'].'-'.$li_data_rec['bmonth'].'-'.$li_data_rec['bday'])):date('F d',strtotime($li_data_rec['byear'].'-'.$li_data_rec['bmonth'].'-'.$li_data_rec['bday']));   
    }
    else if($gp_data_rec['bday']!='0' && $gp_data_rec['bmonth']!='0')
    {
        $birth_day=($gp_data_rec['byear']!='0000')?date('F d, Y',strtotime($gp_data_rec['byear'].'-'.$gp_data_rec['bmonth'].'-'.$gp_data_rec['bday'])):date('F d',strtotime($gp_data_rec['byear'].'-'.$gp_data_rec['bmonth'].'-'.$gp_data_rec['bday']));
    }
    else
    {
        $birth_day='N/A';
    } 
    
    if($fb_data_rec['gender'])
    {
        $gender=$fb_data_rec['gender'];
    }
    else if($gp_data_rec['gender'])
    {
        $gender=$gp_data_rec['gender'];
    }
    else if($yh_data_rec['gender'])
    {
        
        $gender=($yh_data_rec['gender']=='M')?'Male':'Female';
    } 
    else
    {
        $gender='N/A';
    }
    
    if($fb_data_rec['location'])
    {
        $location=$fb_data_rec['location'];
    }
    else if($li_data_rec['location'])
    {
        $location=$li_data_rec['location'];
    }
    else if($gp_data_rec['location'])
    {
        $location=$gp_data_rec['location'];
    }
    else
    {
        $location='N/A';
    }
    
    $hometown=($fb_data_rec['hometown'])?$fb_data_rec['hometown']:'N/A';
    
    
    $industry=($li_data_rec['industry'])?$li_data_rec['industry']:'N/A';
    
    $timeZone=($fb_data_rec['timezone'])?'GMT '.$fb_data_rec['timezone'].'':'N/A';
    
    $fb_friends=($fb_data_rec['friends'])?$fb_data_rec['friends']:'N/A';
    $fb_link=($fb_data_rec['username'])?$fb_data_rec['username']:'#';
    
     $li_friends=($li_data_rec['numConnections'])?$li_data_rec['numConnections']:'N/A';
    $li_link=($li_data_rec['publicProfileUrl'])?$li_data_rec['publicProfileUrl']:'#';
    
    $gp_friends=($gp_data_rec['friends'])?$gp_data_rec['friends']:'N/A';
    $gp_link=($gp_data_rec['username'])?$gp_data_rec['username']:'#';
    
    if($fb_data_rec['relationship_status'])
    {
        $relationship_status=$fb_data_rec['relationship_status'];
    }
    else if($gp_data_rec['relationship_status'])
    {
        $relationship_status=$gp_data_rec['relationship_status'];
    }
    else
    {
        $relationship_status='N/A';
    }
    
    
    if($email=='scspl.dilip@gmail.com')
    {
        $tw_friends='3';
        $tw_link='https://twitter.com/scs_dilip';
    }
    else
    {
        $tw_friends='N/A';
        $tw_link='#';
    }
    
    $fb_likes=($fb_data_rec['likes'])?$fb_data_rec['likes']:'N/A';
    
    
    
}

include("header.php");
?>
<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
        <ol class="breadcrumb">
            <li>YOU ARE HERE</li>
            <li class="active">User Profile</li>
        </ol>
        <h1 class="page-title">User - <span class="fw-semi-bold">Profile</span></h1>
        <div class="row">
            <div class="col-md-12">
                <section class="widget">
                    <header>
                        <h4>User's Social <small>Profile</small></h4>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <?php if($is_profile>0)
                        {
                            
                            ?>
                            <table class="table" style="border: medium none;">
                                <tr>
                                    <td colspan="4">
                                        <div>
                                           
                                                <img style="float: left;" src="<?php echo $profle_pic;?>" alt="<?php echo $profle_name; ?>" title="<?php echo $profle_name; ?>" /> 
                                           
                                           
                                            <p style="float: left; margin-left: 15px;">
                                                <strong><?php echo $profle_name;?></strong><br />
                                                <strong><?php echo $headline;?></strong><br />
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo $profle_name;?></td>
                                    <th>Email</th>
                                    <td><?php echo $email; ?></td>
                                </tr>
                                <tr>
                                    <th>Birth Date</th>
                                    <td><?php echo $birth_day;?></td>
                                    <th>Gender</th>
                                    <td><?php echo $gender;?></td>
                                </tr>
                                <tr>
                                    <th>Relationship Status</th>
                                    <td><?php echo $relationship_status;?></td>
                                    <th>Time Zone</th>
                                    <td><?php echo $timeZone;?></td>
                                </tr>
                                
                                <tr>
                                    <th>Location</th>
                                    <td><?php echo $location;?></td>
                                    <th>Home Town</th>
                                    <td><?php echo $hometown;?></td>
                                </tr>
                                
                                <tr>
                                    <th>Industry</th>
                                    <td><?php echo $industry;?></td>                                    
                                </tr>
                                                                
                                <tr>
                                    <th>Facebook Friends</th>
                                    <td><?php echo $fb_friends;?></td>
                                    <th>Facebook Profile</th>
                                    <td><a href="<?php echo $fb_link;?>" target="_blank">View</a></td>
                                </tr>
                                
                                <tr>
                                    <th>LinkedIN Connections</th>
                                    <td><?php echo $li_friends;?></td>
                                    <th>LinkedIN Profile</th>
                                    <td><a href="<?php echo $li_link;?>" target="_blank">View</a></td>
                                </tr>
                                
                                <tr>
                                    <th>Persons in Google+ Circles</th>
                                    <td><?php echo $gp_friends;?></td>
                                    <th>Google+ Profile</th>
                                    <td><a href="<?php echo $gp_link;?>" target="_blank">View</a></td>
                                </tr>
                                
                                <tr>
                                    <th>Twitter Followers</th>
                                    <td><?php echo $tw_friends;?></td>
                                    <th>Twitter Profile</th>
                                    <td><a href="<?php echo $tw_link;?>" target="_blank">View</a></td>
                                </tr>                               
                                
                                <tr>
                                    <th>Likes</th>
                                    <td colspan="3"><?php echo utf8_decode(re_db_output($fb_data_rec['likes']));?></td>
                                </tr>
                            </table>
                            <?php 
                        } else {?>
                            <table class="table" style="border: medium none;">
                                <tr>
                                    <td><h2 style="text-align: center;">No Data Found</h2></td>
                                </tr>
                            </table>
                        <?php }?>
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
<script src="vendor/parsleyjs/dist/parsley.min.js"></script>
<!-- page specific js -->
<script src="js/form-validation.js"></script>
</body>
</html>