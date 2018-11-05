<?php include("include/config.php"); ?>
<?php 
$error=array();


if(isset($_POST['create_an_account']) && $_POST['create_an_account']=="Create an Account")
{
    if(isset($_POST['firstname']) && $_POST['firstname']=="") {
        $error[]="Please enter first name.";
    }
    if(isset($_POST['lastname']) && $_POST['lastname']=="") {
        $error[]="Please enter last name.";
    }
    if($_FILES['admin_img']['name']=="") {
        $error[]="Please upload photo.";
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
        $error[]="Please enter Google+ Client ID.";
    }
    if(isset($_POST['yahoo_app_id']) && $_POST['yahoo_app_id']=="") {
        $error[]="Please enter Yahoo Application ID";
    }
    if(isset($_POST['insta_app_id']) && $_POST['insta_app_id']=="") {
        $error[]="Please enter Instagram Application ID";
    }*/
    if(isset($_POST['email']) && $_POST['email']=="") {
        $error[]="Please enter email.";
    }
    if(isset($_POST['pass']) && $_POST['pass']=="") {
        $error[]="Please enter password.";
    }
    
    if(count($error)<=0)
    {
        $sel_cs="INSERT INTO `cs_sites` SET 
                firstname='".$_POST['firstname']."',
                lastname='".$_POST['lastname']."',
                site_url='".$_POST['site_url']."', 
                site_admin='".$_POST['site_admin']."',
                fb_app_id='".$_POST['fb_app_id']."',
                twitter_app_id='".$_POST['twitter_app_id']."',
                linkedin_app_id='".$_POST['linkedin_app_id']."',
                gplus_app_id='".$_POST['gplus_app_id']."',
                yahoo_app_id='".$_POST['yahoo_app_id']."',
                admin_email='".$_POST['email']."',
                admin_password='".md5($_POST['pass'])."'";
        re_db_query($sel_cs);
        $last_id=re_db_insert_id();
        
        if($_FILES['admin_img']['name']!="")
        {
            $filename=basename($_FILES['admin_img']['name']);
            $ext=strtolower(getEXT($filename));
            $orgfilename="cs_admin_".$last_id.".".$ext;
            $uploaddir=DIR_FS."img/cs_admin/".$orgfilename;
            move_uploaded_file($_FILES['admin_img']['tmp_name'],$uploaddir);
    
            $u_update="update cs_sites set admin_img='".$orgfilename."' where id='".$last_id."'";
            re_db_query($u_update);
        }

        header("location:login.php?msg=reg"); exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sing Up</title>
    <link href="css/application.min.css" rel="stylesheet">
    <!-- as of IE9 cannot parse css files with more that 4K classes separating in two files -->
    <!--[if IE 9]>
        <link href="css/application-ie9-part2.css" rel="stylesheet">
    <![endif]-->
    <link rel="shortcut icon" href="img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
         chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
         https://code.google.com/p/chromium/issues/detail?id=332189
         */
    </script>
</head>
<body class="login-page">

<div class="container">
    <main id="content" class="widget-login-container" role="main" style="padding-top: 2%;" >
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-xs-10 col-lg-offset-4 col-sm-offset-3 col-xs-offset-1">
                <h4 class="widget-login-logo animated fadeInUp">
                    <i class="fa fa-circle text-gray"></i>
                    Coupay Social
                    <i class="fa fa-circle text-warning"></i>
                </h4>
                <section class="widget widget-login animated fadeInUp">
                    <header>
                        <h3>Create Account</h3>
                    </header>
                    <div class="widget-body">
                        <form class="login-form mt-lg" action="" method="post" enctype="multipart/form-data">
                            
                            <?php if(count($error)>0) {
                            foreach($error as $err) {
                            ?>
                            <div class="form-group">
                                <span style="color: red;" ><?php echo $err; ?></span>
                            </div>
                            <?php 
                                }
                            } ?>
                            <div class="form-group">
                                <input type="text" name="firstname" class="form-control" id="firstname" placeholder="First Name" value="<?php echo isset($_POST['firstname'])?$_POST['firstname']:''; ?>" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Last Name" value="<?php echo isset($_POST['lastname'])?$_POST['lastname']:''; ?>" />
                            </div>
                            <div class="form-group">
                                <input style="height: auto;" type="file" name="admin_img" class="form-control" id="admin_img" value="" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="site_url" class="form-control" id="exampleInputEmail1" placeholder="Site url" value="<?php echo isset($_POST['site_url'])?$_POST['site_url']:''; ?>" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="site_admin" class="form-control" id="exampleInputEmail1" placeholder="Site Admin" value="<?php echo isset($_POST['site_admin'])?$_POST['site_admin']:''; ?>" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="fb_app_id" class="form-control" id="exampleInputEmail1" placeholder="Facebook Application ID" value="<?php echo isset($_POST['fb_app_id'])?$_POST['fb_app_id']:''; ?>" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="twitter_app_id" class="form-control" id="exampleInputEmail1" placeholder="Twitter Application ID" value="<?php echo isset($_POST['twitter_app_id'])?$_POST['twitter_app_id']:''; ?>" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="linkedin_app_id" class="form-control" id="exampleInputEmail1" placeholder="Linkedin Application ID" value="<?php echo isset($_POST['linkedin_app_id'])?$_POST['linkedin_app_id']:''; ?>" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="gplus_app_id" class="form-control" id="gplus_app_id" placeholder="Google+ Client ID" value="<?php echo isset($_POST['gplus_app_id'])?$_POST['gplus_app_id']:''; ?>" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="yahoo_app_id" class="form-control" id="yahoo_app_id" placeholder="Yahoo Application ID" value="<?php echo isset($_POST['yahoo_app_id'])?$_POST['yahoo_app_id']:''; ?>" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="insta_app_id" class="form-control" id="insta_app_id" placeholder="Instagram API Key" value="<?php echo isset($_POST['insta_app_id'])?$_POST['insta_app_id']:'';?>" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" value="<?php echo isset($_POST['email'])?$_POST['email']:''; ?>" />
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="pass" id="pswd" type="password" placeholder="Password" />
                            </div>
                            <div class="clearfix">
                                <div class="btn-toolbar pull-right">
                                    <button type="button" class="btn btn-default btn-sm" onclick="javascript:window.location='login.php';" >Login</button>
                                    <input type="submit" name="create_an_account" class="btn btn-inverse btn-sm" value="Create an Account" />
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </main>
    <!--footer class="page-footer">
        2014 &copy; Sing. Admin Dashboard Template.
    </footer-->
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

<!-- common app js -->
<script src="js/settings.js"></script>
<script src="js/app.js"></script>

<!-- page specific libs -->
<!-- page specific js -->
</body>
</html>