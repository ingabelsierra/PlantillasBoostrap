<?php 
include("include/config.php");
if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }


$fb_data_qry="select * from cs_fb_share_users where member_id='".mysql_real_escape_string($_GET['mid'])."' and client_id='".$_SESSION['admin_id']."' ";
$fb_data_sql=re_db_query($fb_data_qry);


$li_data_qry="select lid.*, csu.email from cs_li_data as lid, cs_users as csu where csu.id=lid.member_id and csu.client_id='".$_SESSION['admin_id']."' and member_id='".mysql_real_escape_string($_GET['mid'])."' ";
$li_data_sql=re_db_query($li_data_qry);

$gp_data_qry="select * from cs_gp_users where member_id='".mysql_real_escape_string($_GET['mid'])."' and client_id='".$_SESSION['admin_id']."' ";
$gp_data_sql=re_db_query($gp_data_qry);


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
                        <h4>User's FB <small>Profile</small></h4>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <?php if(re_db_num_rows($fb_data_sql)>0)
                        {
                            $fb_data_rec=re_db_fetch_array($fb_data_sql);
                            ?>
                            <table class="table" style="border: medium none;">
                                <tr>
                                    <td colspan="4">
                                        <div>
                                            <?php if($fb_data_rec['profile_pic']!="") {?>
                                                <img style="float: left;" src="<?php echo $fb_data_rec['profile_pic'];?>" alt="Profile Image" title="Profile Image" /> 
                                            <?php } else {?>
                                                <img style="float: left; height: 50px; width: 50px;" src="<?php echo SITE_URL."img/avatar.png";?>" alt="No Profile Image" title="No Profile Image" />
                                            <?php }?>
                                            <p style="float: left; margin-left: 15px;">
                                                <strong><?php echo $fb_data_rec['uname'];?></strong><br />
                                                <strong>ID : </strong><?php echo $fb_data_rec['uid'];?><br />
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo $fb_data_rec['uname'];?></td>
                                    <th>Profile Link</th>
                                    <td><a href="<?php echo $fb_data_rec['username'];?>" target="_blank"><?php echo $fb_data_rec['username'];?></a></td>
                                </tr>
                                <tr>
                                    <th>Birth Date</th>
                                    <td><?php echo date('F d, Y', strtotime($fb_data_rec['birthday']));?></td>
                                    <th>Gender</th>
                                    <td><?php echo $fb_data_rec['gender'];?></td>
                                </tr>
                                <tr>
                                    <th>Relationship Status</th>
                                    <td><?php echo $fb_data_rec['relationship_status'];?></td>
                                    <th>Email</th>
                                    <td><?php echo $fb_data_rec['email'];?></td>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <td><?php echo $fb_data_rec['location'];?></td>
                                    <th>Home Town</th>
                                    <td><?php echo $fb_data_rec['hometown'];?></td>
                                </tr>
                                <tr>
                                    <th>Friends</th>
                                    <td><?php echo $fb_data_rec['friends'];?></td>
                                    <th>&nbsp;</th>
                                    <td>&nbsp;</td>
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
                                    <td><h2 style="text-align: center;">No FB Data Found</h2></td>
                                </tr>
                            </table>
                        <?php }?>
                    </div>
                </section>
                
                <section class="widget">
                    <header>
                        <h4>User's LinkedIn <small>Profile</small></h4>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <?php if(re_db_num_rows($li_data_sql)>0)
                        {
                            $li_data_rec=re_db_fetch_array($li_data_sql);
                            ?>
                            <table class="table" style="border: medium none;">
                                <tr>
                                    <td colspan="4">
                                        <div>
                                            <?php if($li_data_rec['pictureUrl']!="") {?>
                                                <img style="float: left;" src="<?php echo $li_data_rec['pictureUrl'];?>" alt="Profile Image" title="Profile Image" /> 
                                            <?php } else {?>
                                                <img style="float: left; height: 80px; width: 80px;" src="<?php echo SITE_URL."img/avatar.png";?>" alt="No Profile Image" title="No Profile Image" />
                                            <?php }?>
                                            <p style="float: left; margin-left: 15px;">
                                                <strong><?php echo $li_data_rec['firstname']." ".$li_data_rec['lastname'];?></strong><br />
                                                <strong>ID : </strong><?php echo $li_data_rec['profile_id'];?><br />
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo $li_data_rec['firstname']." ".$li_data_rec['lastname'];?></td>
                                    <th>Profile Link</th>
                                    <td><a href="<?php echo $li_data_rec['publicProfileUrl'];?>" target="_blank"><?php echo $li_data_rec['publicProfileUrl'];?></a></td>
                                </tr>
                                <tr>
                                    <th>Birth Date</th>
                                    <td><?php echo ($li_data_rec['byear']!='0000')?date('F d, Y',strtotime($li_data_rec['byear'].'-'.$li_data_rec['bmonth'].'-'.$li_data_rec['bday'])):date('F d',strtotime($li_data_rec['byear'].'-'.$li_data_rec['bmonth'].'-'.$li_data_rec['bday']));?></td>
                                    <th>Email</th>
                                    <td><?php echo $li_data_rec['email'];?></td>
                                </tr>
                                <tr>
                                    <th>Headline</th>
                                    <td><?php echo $li_data_rec['headline'];?></td>
                                    <th>Industry</th>
                                    <td><?php echo $li_data_rec['industry'];?></td>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <td><?php echo $li_data_rec['location'];?></td>
                                    <th>Connections</th>
                                    <td><?php echo $li_data_rec['numConnections'];?></td>
                                </tr>
                            </table>
                            <?php 
                        } else {?>
                            <table class="table" style="border: medium none;">
                                <tr>
                                    <td><h2 style="text-align: center;">No LinkedIn Data Found</h2></td>
                                </tr>
                            </table>
                        <?php }?>
                    </div>
                </section>
                
                 <section class="widget">
                    <header>
                        <h4>User's Google+ <small>Profile</small></h4>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <?php if(re_db_num_rows($gp_data_sql)>0)
                        {
                            $gp_data_rec=re_db_fetch_array($gp_data_sql);
                            ?>
                            <table class="table" style="border: medium none;">
                                <tr>
                                    <td colspan="4">
                                        <div>
                                            <?php if($gp_data_rec['profile_pic']!="") {?>
                                                <img style="float: left;" src="<?php echo $gp_data_rec['profile_pic'];?>" alt="Profile Image" title="Profile Image" /> 
                                            <?php } else {?>
                                                <img style="float: left; height: 50px; width: 50px;" src="<?php echo SITE_URL."img/avatar.png";?>" alt="No Profile Image" title="No Profile Image" />
                                            <?php }?>
                                            <p style="float: left; margin-left: 15px;">
                                                <strong><?php echo $gp_data_rec['name'];?></strong><br />
                                                <strong>ID : </strong><?php echo $gp_data_rec['profile_id'];?><br />
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo $gp_data_rec['name'];?></td>
                                    <th>Profile Link</th>
                                    <td><a href="<?php echo $gp_data_rec['username'];?>" target="_blank"><?php echo $gp_data_rec['username'];?></a></td>
                                </tr>
                                <tr>
                                    <th>Birth Date</th>
                                    <td><?php echo ($gp_data_rec['byear']!='0000')?date('F d, Y',strtotime($gp_data_rec['byear'].'-'.$gp_data_rec['bmonth'].'-'.$gp_data_rec['bday'])):($gp_data_rec['bmonth']!='0')?date('F d',strtotime($gp_data_rec['byear'].'-'.$gp_data_rec['bmonth'].'-'.$gp_data_rec['bday'])):'-';?></td>
                                    <th>Gender</th>
                                    <td><?php echo $gp_data_rec['gender'];?></td>
                                </tr>
                                <tr>
                                    <th>Relationship Status</th>
                                    <td><?php echo $gp_data_rec['relationship_status'];?></td>
                                    <th>Email</th>
                                    <td><?php echo $gp_data_rec['email'];?></td>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <td colspan="3"><?php echo $fb_data_rec['location'];?></td>
                                    
                                </tr>
                                <tr>
                                    <th>In circles</th>
                                    <td><?php echo intval($gp_data_rec['friends']);?> peoples</td>
                                    <th>&nbsp;</th>
                                    <td>&nbsp;</td>
                                </tr>
                                
                            </table>
                            <?php 
                        } else {?>
                            <table class="table" style="border: medium none;">
                                <tr>
                                    <td><h2 style="text-align: center;">No Google+ Data Found</h2></td>
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