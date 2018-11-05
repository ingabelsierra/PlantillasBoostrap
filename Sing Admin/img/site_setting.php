<?php 
include("include/config.php");
if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }


$error=array();
$id="";
$firstname="";
$lastname="";
$site_url="";
$site_admin="";
$fb_app_id="";
$twitter_app_id="";
$linkedin_app_id="";
$gplus_app_id="";
$yahoo_app_id="";
$insta_app_id="";
$email="";


if(isset($_POST['update_account']) && $_POST['update_account']=="Update Account")
{
    $id=re_db_input($_POST['id']);
    $api_key=re_db_input($_POST['api_key']);
    $api_secret=re_db_input($_POST['api_secret']);
    $firstname=re_db_input($_POST['firstname']);
    $lastname=re_db_input($_POST['lastname']);
    $site_url=re_db_input($_POST['site_url']);
    $site_admin=re_db_input($_POST['site_admin']);
    $fb_app_id=re_db_input($_POST['fb_app_id']);
    $twitter_app_id=re_db_input($_POST['twitter_app_id']);
    $linkedin_app_id=re_db_input($_POST['linkedin_app_id']);
    $gplus_app_id=re_db_input($_POST['gplus_app_id']);
    $yahoo_app_id=re_db_input($_POST['yahoo_app_id']);
    $yahoo_app_id=re_db_input($_POST['insta_app_id']);
    $email=re_db_input($_POST['admin_email']);

    if(isset($_POST['firstname']) && $_POST['firstname']=="") {
        $error[]="Please enter first name.";
    }
    if(isset($_POST['lastname']) && $_POST['lastname']=="") {
        $error[]="Please enter last name.";
    }
    if(isset($_POST['site_url']) && $_POST['site_url']=="") {
        $error[]="Please enter site url.";
    }
    if(isset($_POST['site_admin']) && $_POST['site_admin']=="") {
        $error[]="Please enter site admin.";
    }
    /*if(isset($_POST['fb_app_id']) && $_POST['fb_app_id']=="") {
        $error[]="Please enter Facebook Application ID.";
    }
    if(isset($_POST['twitter_app_id']) && $_POST['twitter_app_id']=="") {
        $error[]="Please enter Twitter Application ID.";
    }
    if(isset($_POST['linkedin_app_id']) && $_POST['linkedin_app_id']=="") {
        $error[]="Please enter Linkedin Application ID.";
    }
    if(isset($_POST['gplus_app_id']) && $_POST['gplus_app_id']=="") {
        $error[]="Please enter Google Client ID.";
    }
    if(isset($_POST['yahoo_app_id']) && $_POST['yahoo_app_id']=="") {
        $error[]="Please enter Yahoo Application ID";
    }*/
    if(isset($_POST['email']) && $_POST['email']=="") {
        $error[]="Please enter email.";
    }
    //if(isset($_POST['pass']) && $_POST['pass']=="") {
    //    $error[]="Please enter password.";
    //}
    
    if(count($error)<=0)
    {
        $sel_cs="UPDATE `cs_sites` SET 
                firstname='".$_POST['firstname']."',
                lastname='".$_POST['lastname']."',
                site_url='".$_POST['site_url']."', 
                site_admin='".$_POST['site_admin']."',
                fb_app_id='".$_POST['fb_app_id']."',
                twitter_app_id='".$_POST['twitter_app_id']."',
                linkedin_app_id='".$_POST['linkedin_app_id']."',
                gplus_app_id='".$_POST['gplus_app_id']."',
                yahoo_app_id='".$_POST['yahoo_app_id']."',
                insta_app_id='".$_POST['insta_app_id']."',
                admin_email='".$_POST['email']."' where id='".$_SESSION['admin_id']."'";
        re_db_query($sel_cs);
        
        if(isset($_POST['pass']) && $_POST['pass']!="") {
            $u_update="update cs_sites set admin_password='".md5($_POST['pass'])."' where id='".$_SESSION['admin_id']."'";
            re_db_query($u_update);
        }
        
        if($_FILES['admin_img']['name']!="")
        {
            $filename=basename($_FILES['admin_img']['name']);
            $ext=strtolower(getEXT($filename));
            $orgfilename="cs_admin_".$_SESSION['admin_id'].".".$ext;
            $uploaddir=DIR_FS."img/cs_admin/".$orgfilename;
            move_uploaded_file($_FILES['admin_img']['tmp_name'],$uploaddir);
    
            $u_update="update cs_sites set admin_img='".$orgfilename."' where id='".$id."'";
            re_db_query($u_update);
        }
        $_SESSION['msg']="update";
        header("location:site_setting.php"); exit;
    }
}


if(!isset($_POST['update_account']))
{
    $site_data_qry="select * from cs_sites where id='".$_SESSION['admin_id']."'";
    $site_data_sql=re_db_query($site_data_qry);
    
    if(re_db_num_rows($site_data_sql)>0)
    {
        $site_data_rec=re_db_fetch_array($site_data_sql);
        
        $id==$site_data_rec['id'];
        $api_key=$site_data_rec['api_key'];
        $api_secret=$site_data_rec['api_secret'];
        $firstname=$site_data_rec['firstname'];
        $lastname=$site_data_rec['lastname'];
        $site_url=$site_data_rec['site_url'];
        $site_admin=$site_data_rec['site_admin'];
        $admin_img=$site_data_rec['admin_img'];
        $fb_app_id=$site_data_rec['fb_app_id'];
        $twitter_app_id=$site_data_rec['twitter_app_id'];
        $linkedin_app_id=$site_data_rec['linkedin_app_id'];
        $yahoo_app_id=$site_data_rec['yahoo_app_id'];
        $insta_app_id=$site_data_rec['insta_app_id'];
        $gplus_app_id=$site_data_rec['gplus_app_id'];
        $email=$site_data_rec['admin_email'];
    }
}


if(isset($_SESSION['msg']) && $_SESSION['msg']=="update") 
{ 
    $msg="Account Updated Successfully.";
    unset($_SESSION['msg']); 
}

include("header.php");
?>
<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
        <ol class="breadcrumb">
            <li>YOU ARE HERE</li>
            <li class="active">Site Settings</li>
        </ol>
        <!--h1 class="page-title">Site - <span class="fw-semi-bold">Settings</span></h1-->
        <div class="row">
            <div class="col-md-7">
                <section class="widget widget-login animated fadeInUp">
                    <header>
                        <h5>Site <span class="fw-semi-bold"> Setting</span></h5>
                        <div class="widget-controls">
                            <a href="#"><i class="glyphicon glyphicon-cog"></i></a>
                            <a data-widgster="close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <form class="login-form mt-lg" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $id;?>" />
                            <?php if(count($error)>0)
                            {
                                foreach($error as $err) {
                                    ?><div class="form-group"><span style="color: red;" ><?php echo $err; ?></span></div><?php 
                                }
                            } if(isset($msg) && $msg!="") {?>
                                <div class="form-group"><span style="color: #008000;" ><?php echo $msg; ?></span></div>
                            <?php }?>
                            <div class="form-group">
                                <div><strong>Your API Key</strong></div>
                                <input type="text" name="api_key" class="form-control" id="api_key" value="<?php echo re_db_output($api_key); ?>" readonly="readonly" />
                            </div>
                            <div class="form-group">
                                <div><strong>Your Secret Key&nbsp;&nbsp;<a id="show_heid_a" href="javascript:void(0);" onclick="show_heid()">Show</a></strong></div>
                                <span id="secret_key_span" style="display: none;"><input type="text" name="api_secret" class="form-control" id="api_secret" value="<?php echo re_db_output($api_secret); ?>" readonly="readonly" /></span>
                            </div>
                            <script type="text/javascript">
                                function show_heid()
                                {
                                    if(document.getElementById('secret_key_span').style.display=="none")
                                    {
                                        document.getElementById('secret_key_span').style.display="block";
                                        document.getElementById('show_heid_a').innerHTML="Hide";
                                    }
                                    else
                                    {
                                        document.getElementById('secret_key_span').style.display="none";
                                        document.getElementById('show_heid_a').innerHTML="Show";
                                    }
                                }
                            </script>
                            <div class="form-group">
                                <div><strong>First Name</strong></div>
                                <input type="text" name="firstname" class="form-control" id="firstname" placeholder="First Name" value="<?php echo re_db_output($firstname); ?>" />
                            </div>
                            <div class="form-group">
                                <div><strong>Last Name</strong></div>
                                <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Last Name" value="<?php echo re_db_output($lastname); ?>" />
                            </div>
                            <div class="form-group" style="float: left;">
                                <div><strong>Admin Image</strong></div>
                                <div style="float: left;"><input style="height: auto;" type="file" name="admin_img" class="form-control" id="admin_img" value="" /></div>
                                <?php if($admin_img!="" && file_exists(DIR_FS."img/cs_admin/".$admin_img))
                                {
                                    $imagePath = DIR_FS."img/cs_admin/".$admin_img;
                                    list($width, $height, $type, $attr) = getimagesize($imagePath);
                                    $aspect = $width / $height;
                                    $newWidth = 50;
                                    $newHeight = $newWidth / $aspect;
                                    echo '<div style="float: left; margin-left: 10px;"><img src="'.SITE_URL."img/cs_admin/".$admin_img.'" height="'.$newHeight.'" width="'.$newWidth.'"alt=" image" style="padding:5px 5px 5px 5px;" ></div>';
                                    /*?><div style="float: left; margin-left: 10px;"><img src="<?php echo SITE_URL."img/cs_admin/".$admin_img;?>" alt="admin image" /></div><?php*/ 
                                }?>
                            </div>
                            <div style="clear: both;"></div>
                            
                            <div class="form-group">
                                <div><strong>Site url</strong></div>
                                <input type="text" name="site_url" class="form-control" id="site_url" placeholder="Site url" value="<?php echo re_db_output($site_url); ?>" />
                            </div>
                            <div class="form-group">
                                <div><strong>Site Admin</strong></div>
                                <input type="text" name="site_admin" class="form-control" id="site_admin" placeholder="Site Admin" value="<?php echo re_db_output($site_admin); ?>" />
                            </div>
                            <div class="form-group">
                                <div><strong>Facebook Application ID</strong></div>
                                <input type="text" name="fb_app_id" class="form-control" id="fb_app_id" placeholder="Facebook Application ID" value="<?php echo re_db_output($fb_app_id); ?>" />
                            </div>
                            <div class="form-group">
                                <div><strong>Twitter Application ID</strong></div>
                                <input type="text" name="twitter_app_id" class="form-control" id="twitter_app_id" placeholder="Twitter Application ID" value="<?php echo re_db_output($twitter_app_id); ?>" />
                            </div>
                            <div class="form-group">
                                <div><strong>Linkedin Application ID</strong></div>
                                <input type="text" name="linkedin_app_id" class="form-control" id="linkedin_app_id" placeholder="Linkedin Application ID" value="<?php echo re_db_output($linkedin_app_id); ?>" />
                            </div>
                            <div class="form-group">
                                <div><strong>Google+ Client ID</strong></div>
                                <input type="text" name="gplus_app_id" class="form-control" id="gplus_app_id" placeholder="Google+ Client ID" value="<?php echo re_db_output($gplus_app_id); ?>" />
                            </div>
                            <div class="form-group">
                                <div><strong>Yahoo Application ID</strong></div>
                                <input type="text" name="yahoo_app_id" class="form-control" id="yahoo_app_id" placeholder="Yahoo Application ID" value="<?php echo re_db_output($yahoo_app_id); ?>" />
                            </div>
                            <div class="form-group">
                                <div><strong>Instagram API Key</strong></div>
                                <input type="text" name="insta_app_id" class="form-control" id="insta_app_id" placeholder="Instagram API Key" value="<?php echo re_db_output($insta_app_id); ?>" />
                            </div>
                            
                            <div class="form-group">
                                <div><strong>Email</strong></div>
                                <input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" value="<?php echo re_db_output($email); ?>" />
                            </div>
                            <div class="form-group">
                                <div><strong>Password</strong></div>
                                <input class="form-control" name="pass" id="pswd" type="password" placeholder="Password" />
                            </div>
                            <div class="clearfix">
                                <div class="btn-toolbar pull-right">
                                    <input type="submit" name="update_account" class="btn btn-inverse btn-sm" value="Update Account" />
                                </div>
                            </div>
                        </form>
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