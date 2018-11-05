<?php 
include("include/config.php");
if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }


if(isset($_POST['btnsubmit']))
{
    if(isset($_POST['old_password']) && trim($_POST['old_password'])=="") { $err[]="Please enter your old password"; }
    if(isset($_POST['password']) && trim($_POST['password'])=="") { $err[]="Please enter a new password"; } 
    else if(isset($_POST['password-r']) && trim($_POST['password-r'])=="") { $err[]="Please enter confirm your password"; }
    else if(trim($_POST['password'])!=trim($_POST['password-r'])) { $err[]="Please enter the same password"; }
    else
    {
        $select_login_query="select count(*) as admin_cnt from cs_sites where admin_password='".md5($_POST['old_password'])."' and id='".$_SESSION['admin_id']."'";
    	$select_login=re_db_query($select_login_query);
    	$fetch_login=re_db_fetch_array($select_login);
        if($fetch_login['admin_cnt']=='0')
    	{
    	    $err[]="Your old password doesn't match.";  
        }
    }
    
    if(count($err)==0)
    {
        $update_login_query="UPDATE `cs_sites` SET `admin_password` = '".md5($_POST['password'])."' WHERE id='".$_SESSION['admin_id']."'";
    	re_db_query($update_login_query);
        
        $_SESSION['msg']="2";
        header("Location:change_password.php"); exit;
    }
}

if(isset($_SESSION['msg']) && $_SESSION['msg']=="2")
{
    $msg="Password changed successfully.";
    unset($_SESSION['msg']); 
}

include("header.php");
?>
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
        <div class="chat-sidebar-contacts chat-sidebar-panel open">
            <h5 class="sidebar-nav-title">Today</h5>
            <div class="list-group chat-sidebar-user-group">
                <a class="list-group-item" href="#chat-sidebar-user-1">
                    <i class="fa fa-circle text-success pull-right"></i>
                    <span class="thumb-sm pull-left mr">
                        <img class="img-circle" src="demo/img/people/a2.jpg" alt="..." />
                    </span>
                    <h5 class="message-sender">Chris Gray</h5>
                    <p class="message-preview">Hey! What's up? So many times since we</p>
                </a>
                <a class="list-group-item" href="#chat-sidebar-user-2">
                    <i class="fa fa-circle text-gray-light pull-right"></i>
                <span class="thumb-sm pull-left mr">
                    <img class="img-circle" src="img/avatar.png" alt="..." />
                </span>
                    <h5 class="message-sender">Jamey Brownlow</h5>
                    <p class="message-preview">Good news coming tonight. Seems they agreed to proceed</p>
                </a>
                <a class="list-group-item" href="#chat-sidebar-user-3">
                    <i class="fa fa-circle text-danger pull-right"></i>
                <span class="thumb-sm pull-left mr">
                    <img class="img-circle" src="demo/img/people/a1.jpg" alt="..." />
                </span>
                    <h5 class="message-sender">Livia Walsh</h5>
                    <p class="message-preview">Check out my latest email plz!</p>
                </a>
                <a class="list-group-item" href="#chat-sidebar-user-4">
                    <i class="fa fa-circle text-gray-light pull-right"></i>
                <span class="thumb-sm pull-left mr">
                    <img class="img-circle" src="img/avatar.png" alt="..." />
                </span>
                    <h5 class="message-sender">Jaron Fitzroy</h5>
                    <p class="message-preview">What about summer break?</p>
                </a>
                <a class="list-group-item" href="#chat-sidebar-user-5">
                    <i class="fa fa-circle text-success pull-right"></i>
                <span class="thumb-sm pull-left mr">
                    <img class="img-circle" src="demo/img/people/a4.jpg" alt="..." />
                </span>
                    <h5 class="message-sender">Mike Lewis</h5>
                    <p class="message-preview">Just ain't sure about the weekend now. 90% I'll make it.</p>
                </a>
            </div>
            <h5 class="sidebar-nav-title">Last Week</h5>
            <div class="list-group chat-sidebar-user-group">
                <a class="list-group-item" href="#chat-sidebar-user-6">
                    <i class="fa fa-circle text-gray-light pull-right"></i>
                <span class="thumb-sm pull-left mr">
                    <img class="img-circle" src="demo/img/people/a6.jpg" alt="..." />
                </span>
                    <h5 class="message-sender">Freda Edison</h5>
                    <p class="message-preview">Hey what's up? Me and Monica going for a lunch somewhere. Wanna join?</p>
                </a>
                <a class="list-group-item" href="#chat-sidebar-user-7">
                    <i class="fa fa-circle text-success pull-right"></i>
                <span class="thumb-sm pull-left mr">
                    <img class="img-circle" src="demo/img/people/a5.jpg" alt="..." />
                </span>
                    <h5 class="message-sender">Livia Walsh</h5>
                    <p class="message-preview">Check out my latest email plz!</p>
                </a>
                <a class="list-group-item" href="#chat-sidebar-user-8">
                    <i class="fa fa-circle text-warning pull-right"></i>
                <span class="thumb-sm pull-left mr">
                    <img class="img-circle" src="demo/img/people/a3.jpg" alt="..." />
                </span>
                    <h5 class="message-sender">Jaron Fitzroy</h5>
                    <p class="message-preview">What about summer break?</p>
                </a>
                <a class="list-group-item" href="#chat-sidebar-user-9">
                    <i class="fa fa-circle text-gray-light pull-right"></i>
                <span class="thumb-sm pull-left mr">
                    <img class="img-circle" src="img/avatar.png" alt="..." />
                </span>
                    <h5 class="message-sender">Mike Lewis</h5>
                    <p class="message-preview">Just ain't sure about the weekend now. 90% I'll make it.</p>
                </a>
            </div>
        </div>
        <div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-1">
            <h5 class="title">
                <a class="js-back" href="#">
                    <i class="fa fa-angle-left mr-xs"></i>
                    Chris Gray
                </a>
            </h5>
            <ul class="message-list">
                <li class="message">
                    <span class="thumb-sm">
                        <img class="img-circle" src="demo/img/people/a2.jpg" alt="..." />
                    </span>
                    <div class="message-body">
                        Hey! What's up?
                    </div>
                </li>
                <li class="message">
                    <span class="thumb-sm">
                        <img class="img-circle" src="demo/img/people/a2.jpg" alt="..." /> 
                    </span>
                    <div class="message-body">
                        Are you there?
                    </div>
                </li>
                <li class="message">
                    <span class="thumb-sm">
                        <img class="img-circle" src="demo/img/people/a2.jpg" alt="..." />
                    </span>
                    <div class="message-body">
                        Let me know when you come back.
                    </div>
                </li>
                <li class="message from-me">
                    <span class="thumb-sm">
                        <img class="img-circle" src="img/avatar.png" alt="..." />
                    </span>
                    <div class="message-body">
                        I am here!
                    </div>
                </li>
            </ul>
        </div>
        <div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-2">
            <h5 class="title">
                <a class="js-back" href="#">
                    <i class="fa fa-angle-left mr-xs"></i>
                    Jamey Brownlow
                </a>
            </h5>
            <ul class="message-list">
            </ul>
        </div>
        <div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-3">
            <h5 class="title">
                <a class="js-back" href="#">
                    <i class="fa fa-angle-left mr-xs"></i>
                    Livia Walsh
                </a>
            </h5>
            <ul class="message-list">
            </ul>
        </div>
        <div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-4">
            <h5 class="title">
                <a class="js-back" href="#">
                    <i class="fa fa-angle-left mr-xs"></i>
                    Jaron Fitzroy
                </a>
            </h5>
            <ul class="message-list">
            </ul>
        </div>
        <div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-5">
            <h5 class="title">
                <a class="js-back" href="#">
                    <i class="fa fa-angle-left mr-xs"></i>
                    Mike Lewis
                </a>
            </h5>
            <ul class="message-list">
            </ul>
        </div>
        <div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-6">
            <h5 class="title">
                <a class="js-back" href="#">
                    <i class="fa fa-angle-left mr-xs"></i>
                    Freda Edison
                </a>
            </h5>
            <ul class="message-list">
            </ul>
        </div>
        <div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-7">
            <h5 class="title">
                <a class="js-back" href="#">
                    <i class="fa fa-angle-left mr-xs"></i>
                    Livia Walsh
                </a>
            </h5>
            <ul class="message-list">
            </ul>
        </div>
        <div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-8">
            <h5 class="title">
                <a class="js-back" href="#">
                    <i class="fa fa-angle-left mr-xs"></i>
                    Jaron Fitzroy
                </a>
            </h5>
            <ul class="message-list">
            </ul>
        </div>
        <div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-9">
            <h5 class="title">
                <a class="js-back" href="#">
                    <i class="fa fa-angle-left mr-xs"></i>
                    Mike Lewis
                </a>
            </h5>
            <ul class="message-list">
            </ul>
        </div>
        <footer class="chat-sidebar-footer form-group">
            <input class="form-control input-dark fs-mini" id="chat-sidebar-input" type="text"  placeholder="Type your message">
        </footer>
    </div>
</div>

<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
        <ol class="breadcrumb">
            <li>YOU ARE HERE</li>
            <li class="active">Change Password</li>
        </ol>
        <h1 class="page-title">Change - <span class="fw-semi-bold">Password</span></h1>
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <section class="widget">
                    <header>
                        <!--h4>Dead simple validation<small>No JS needed to tune-up</small></h4-->
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <form id="validation-form" class="form-horizontal form-label-left" action="" method="post" data-parsley-priority-enabled="false" novalidate="novalidate">
                            <fieldset>
                                <legend>Change Password</legend>
                                <?php if(isset($err) && count($err)>0)
                                {
                                    ?>
                                    <ul style="padding-left: 160px;" class="parsley-errors-list filled">
                                        <?php foreach($err as $key => $val) {?>
                                            <li style="font-size: 14px; padding-bottom: 2px;" class="parsley-required"><?php echo $val;?></li>
                                        <?php }?>
                                    </ul>
                                    <?php 
                                }
                                if(isset($msg) && $msg!="") {
                                    ?><div style="color: #64bd63; text-align: center; font-size: 14; padding: 5px;"><?php echo $msg;?></div><?php 
                                }?>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="password">
                                        Old Password
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="password" id="old_password" name="old_password" class="form-control mb-sm" data-parsley-trigger="change" required="required" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="password">
                                        New Password
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="password" id="password" name="password" class="form-control mb-sm" data-parsley-trigger="change" data-parsley-minlength="6" required="required" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="password">
                                        Confirm Password
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="password" id="password-r" name="password-r" class="form-control" data-parsley-trigger="change" data-parsley-minlength="6" data-parsley-equalto="#password" required="required" />
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-actions">
                                <button type="submit" name="btnsubmit" class="btn btn-default btn-rounded">Update</button>
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