<?php 
include("include/config.php");
if(isset($_SESSION['admin_id'])) { header("location:index.php"); exit; } 

$error=array();
if(isset($_POST['sg_login']) && $_POST['sg_login']=="Login")
{
    if(isset($_POST['user']) && ($_POST['user']=="" || $_POST['pass']==""))
    {
        $error[]="Please enter username and password.";
    }
    
    if(count($error)<=0)
    {
        if($_POST['user']=="csadmin" && md5($_POST['pass'])=="29ad0e3fd3db681fb9f8091c756313f7")
        {
            $_SESSION['admin_type']="master";
            $_SESSION['admin_id']="1";
            $_SESSION['firstname']="Master";
            $_SESSION['lastname']="Admin";
            $_SESSION['admin_email']="admin@coupay.co.in";
            $_SESSION['admin_img']="admin_1.jpg";
            header("location:index.php"); exit;  
        }
        else
        {
        
            $sel_cs="select * from `cs_sites` where admin_email='".$_POST['user']."' and admin_password='".md5($_POST['pass'])."' and is_approved='1'";
            $rec_cs=re_db_query($sel_cs);
            if(re_db_num_rows($rec_cs)>0)
            {
                $row_cs=re_db_fetch_array($rec_cs);
                $_SESSION['admin_type']="client";
                $_SESSION['admin_id']=$row_cs['id'];
                $_SESSION['site_admin']=$row_cs['site_admin'];
                $_SESSION['firstname']=$row_cs['firstname'];
                $_SESSION['lastname']=$row_cs['lastname'];
                $_SESSION['admin_email']=$row_cs['admin_email'];
                $_SESSION['admin_img']=$row_cs['admin_img'];
                $_SESSION['fb_app_id']=$row_cs['fb_app_id'];
                $_SESSION['twitter_app_id']=$row_cs['twitter_app_id'];
                $_SESSION['linkedin_app_id']=$row_cs['linkedin_app_id'];
                header("location:index.php"); exit;
            }
            else
            {
                $error[]="Invalid username or password";    
            }
        }
    }
    
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Coupay Social - Login</title>
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
    <main id="content" class="widget-login-container" role="main">
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-xs-10 col-lg-offset-4 col-sm-offset-3 col-xs-offset-1">
                <h4 class="widget-login-logo animated fadeInUp">
                    <i class="fa fa-circle text-gray"></i>
                    Coupay Social
                    <i class="fa fa-circle text-warning"></i>
                </h4>
                <section class="widget widget-login animated fadeInUp">
                    <header>
                        <h3>Login to your Coupay Social App</h3>
                    </header>
                    <div class="widget-body">
                        <p class="widget-login-info">
                            Use Facebook, Twitter or your email to sign in.
                        </p>
                        <p class="widget-login-info">
                            Don't have an account? Sign up now!
                        </p>
                        <form class="login-form mt-lg" action="login.php" method="post" >
                            <?php if(count($error)>0) {
                            foreach($error as $err) {
                            ?>
                            <div class="form-group">
                                <span style="color: red;" ><?php echo $err; ?></span>
                            </div>
                            <?php 
                                }
                            } ?>
                            <?php if(isset($_GET['msg']) && $_GET['msg']=="reg") {
                            ?>
                            <div class="form-group">
                                <span style="color: green;" ><?php echo "Account created successfully, Please sing in."; ?></span>
                            </div>
                            <?php 
                            } ?>
                            <div class="form-group">
                                <input type="text" name="user" class="form-control" id="exampleInputEmail1" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="pass" id="pswd" type="password" placeholder="Password">
                            </div>
                            <div class="clearfix">
                                <div class="btn-toolbar pull-right">
                                    <button type="button" class="btn btn-default btn-sm" onclick="javascript:window.location='create_account.php';" >Create an Account</button>
                                    <input type="submit" name="sg_login" class="btn btn-inverse btn-sm" value="Login" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-sm-push-6">
                                    <div class="clearfix">
                                        <div class="checkbox widget-login-info pull-right ml-n-lg">
                                            <input type="checkbox" id="checkbox1" value="1" />
                                            <label for="checkbox1">Keep me signed in </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-sm-pull-6">
                                    <a class="mr-n-lg" href="#">Trouble with account?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </main>
    <footer class="page-footer">
        2014 &copy; Soclever.net. All right reserved.
    </footer>
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