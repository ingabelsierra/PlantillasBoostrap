<?php 
include("include/config.php");
if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }

$select_all="select * from cs_fb_share_users where uid='".mysql_real_escape_string($_GET['uid'])."' and client_id='".$_SESSION['admin_id']."' ";
$res_data=re_db_query($select_all);
$row_data=re_db_fetch_array($res_data);

//echo"<pre>"; print_r($row_data); echo"</pre>";


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
                        <h4>User <small>Details</small></h4>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <table class="table" style="border: medium none;">
                            <tr>
                                <td colspan="4">
                                    <div>
                                        <?php if($row_data['profile_pic']!="") {?>
                                            <img style="float: left;" src="<?php echo $row_data['profile_pic'];?>" alt="Profile Image" title="Profile Image" /> 
                                        <?php } else {?>
                                            <img style="float: left; height: 50px; width: 50px;" src="<?php echo SITE_URL."img/avatar.png";?>" alt="No Profile Image" title="No Profile Image" />
                                        <?php }?>
                                        <p style="float: left; margin-left: 15px;">
                                            <strong><?php echo $row_data['uname'];?></strong><br />
                                            <strong>ID : </strong><?php echo $row_data['uid'];?><br />
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td><?php echo $row_data['uname'];?></td>
                                <th>Profile Link</th>
                                <td><a href="<?php echo $row_data['username'];?>" target="_blank"><?php echo $row_data['username'];?></a></td>
                            </tr>
                            <tr>
                                <th>Birth Day</th>
                                <td><?php echo $row_data['birthday'];?></td>
                                <th>Gender</th>
                                <td><?php echo $row_data['gender'];?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo $row_data['email'];?></td>
                                <th>Location</th>
                                <td><?php echo $row_data['location'];?></td>
                            </tr>
                            <tr>
                                <th>Home Town</th>
                                <td><?php echo $row_data['hometown'];?></td>
                                <th>Friends</th>
                                <td><?php echo $row_data['friends'];?></td>
                            </tr>
                            <tr>
                                <th>Likes</th>
                                <td colspan="3"><?php echo utf8_decode(re_db_output($row_data['likes']));?></td>
                            </tr>
                        </table>
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