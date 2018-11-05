<?php
if(isset($_SESSION['admin_type']) && $_SESSION['admin_type']=="master")
{
    $chl_app_sql=re_db_query("select * from cs_sites where is_approved='0'");
    $tot_app=re_db_num_rows($chl_app_sql);
} 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Coupay Social - Dashboard</title>
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
    
    <script type="text/javascript" language="javascript">
        var sitepath='http://www.coupay.com.sg/';		
    </script>
    <script type="text/javascript" src="js/spiffyCal/spiffyCal_v2_1.js"></script>
    <link rel="stylesheet" type="text/css" href="js/spiffyCal/spiffyCal_v2_1.css">
    
    

</head>
<body>

<!--
  Main sidebar seen on the left. may be static or collapsing depending on selected state.

    * Collapsing - navigation automatically collapse when mouse leaves it and expand when enters.
    * Static - stays always open.
-->
<nav id="sidebar" class="sidebar" role="navigation">
    <!-- need this .js class to initiate slimscroll -->
    <div class="js-sidebar-content">
        <header class="logo hidden-xs">
            <a href="index.php">Coupay Social</a>
        </header>
        <!-- seems like lots of recent admin template have this feature of user info in the sidebar.
             looks good, so adding it and enhancing with notifications -->
        <div class="sidebar-status visible-xs">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="thumb-sm avatar pull-right">
                    <img class="img-circle" src="demo/img/people/a5.jpg" alt="..." />
                </span>
                <!-- .circle is a pretty cool way to add a bit of beauty to raw data.
                     should be used with bg-* and text-* classes for colors -->
                <span class="circle bg-warning fw-bold text-gray-dark">
                    13
                </span>
                &nbsp;
                Philip <strong>Smith</strong>
                <b class="caret"></b>
            </a>
            <!-- #notifications-dropdown-menu goes here when screen collapsed to xs or sm -->
        </div>
        <!-- main notification links are placed inside of .sidebar-nav -->
        <ul class="sidebar-nav">
            <li<?php if($page_name=="index.php") { echo ' class="active"';}?>>
                <!-- an example of nested submenu. basic bootstrap collapse component -->
                <a href="index.php">
                    <span class="icon">
                        <i class="fa fa-desktop"></i>
                    </span>
                    Dashboard
                </a>
                <!--a href="#sidebar-dashboard" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon">
                        <i class="fa fa-desktop"></i>
                    </span>
                    Dashboard
                    <i class="toggle fa fa-angle-down"></i>
                </a>
                <ul id="sidebar-dashboard" class="collapse in">
                    <li<?php //if($page_name=="index.php") { echo ' class="active"';}?>><a href="index.php">Dashboard</a></li>
                    <li><a href="widgets.html">Widgets</a></li>
                </ul-->
            </li>
            <?php if(isset($_SESSION['admin_type']) && $_SESSION['admin_type']=="master")
            {
                ?>
                <li<?php if($page_name=="cs_approve_client.php") { echo ' class="active"';}?>>
                    <a href="cs_approve_client.php">
                        <span class="icon"><i class="fa fa-envelope"></i></span>
                        User Approval
                        <span class="label label-danger"><?php echo $tot_app;?></span>
                    </a>
                </li>
                <?php 
            }?>
            
            <!--li>
                <a href="charts.html">
                    <span class="icon">
                        <i class="glyphicon glyphicon-stats"></i>
                    </span>
                    Charts
                </a>
            </li-->
            <li<?php if(in_array($page_name,$social_user_pages)) { echo ' class="active"';}?>>
                <!-- an example of nested submenu. basic bootstrap collapse component -->
                <a href="#sidebar-social" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon">
                        <i class="fa fa-table"></i>
                    </span>
                    Social Users
                    <i class="toggle fa fa-angle-down"></i>
                </a>
                <ul id="sidebar-social" class="collapse in">
                    <li<?php if($page_name=="shareclicks.php") { echo ' class="active"';}?>><a href="<?php echo SITE_URL;?>shareclicks.php">Shared Clicked Links</a></li>
                    <li<?php if($page_name=="fbshares.php") { echo ' class="active"';}?>><a href="fbshares.php">FB Shared Links </a></li>
                    <li<?php if($page_name=="lishares.php") { echo ' class="active"';}?>><a href="lishares.php">Linkedin Shared Links </a></li>
                    <li<?php if($page_name=="fb_share_user.php") { echo ' class="active"';}?>><a href="fb_share_user.php">Users</a></li>
                    <li<?php if($page_name=="cs_referral.php") { echo ' class="active"';}?>><a href="cs_referral.php">Referrals</a></li>
                    <li<?php if($page_name=="cs_track_orders.php") { echo ' class="active"';}?>><a href="cs_track_orders.php">Track Order</a></li>
                    <li<?php if($page_name=="cs_like_unlike.php") { echo ' class="active"';}?>><a href="cs_like_unlike.php">Like Unlike</a></li>
                   
                </ul>
            </li>
            <li<?php if(in_array($page_name,$user_identy_pages)) { echo ' class="active"';}?>>
                <!-- an example of nested submenu. basic bootstrap collapse component -->
                <a href="#sidebar-useridenty" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon">
                        <i class="fa fa-table"></i>
                    </span>
                    User Identities
                    <i class="toggle fa fa-angle-down"></i>
                </a>
                <ul id="sidebar-useridenty" class="collapse in">
                    <li<?php if($utype=="nru") { echo ' class="active"';}?>><a href="<?php echo SITE_URL;?>useridenty.php?utype=nru">New Registered Users</a></li>
                    <li<?php if($utype=="dlu") { echo ' class="active"';}?>><a href="<?php echo SITE_URL;?>useridenty.php?utype=dlu">Daily Logins Users</a></li>                    
                    <!--li<?php if($utype=="lup") { echo ' class="active"';}?>><a href="<?php echo SITE_URL;?>useridenty.php?utype=lup">Logged-in Users by Provider</a></li-->
                    <li<?php if($utype=="dmg") { echo ' class="active"';}?>><a href="<?php echo SITE_URL;?>useridenty.php?utype=dmg">Demographics</a></li>
                    <li<?php if($utype=="rbp") { echo ' class="active"';}?>><a href="<?php echo SITE_URL;?>useridenty.php?utype=rbp">Revenue by Provider</a></li>
                </ul>
            </li>
            <li<?php if(in_array($page_name,$user_share_pages)) { echo ' class="active"';}?>>
                <!-- an example of nested submenu. basic bootstrap collapse component -->
                <a href="#sidebar-usershares" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon">
                        <i class="fa fa-table"></i>
                    </span>
                    Social Sharings
                    <i class="toggle fa fa-angle-down"></i>
                </a>
                <ul id="sidebar-usershares" class="collapse in">
                    <li<?php if($stype=="totalshare") { echo ' class="active"';}?>><a href="<?php echo SITE_URL;?>usersharing.php?stype=totalshare">Shares</a></li>
                    <li<?php if($stype=="sbp") { echo ' class="active"';}?>><a href="<?php echo SITE_URL;?>usersharing.php?stype=sbp">Shares By Providers</a></li>
                    <li<?php if($stype=="msu") { echo ' class="active"';}?>><a href="<?php echo SITE_URL;?>usersharing.php?stype=msu">Most Shared</a></li>
                    <li<?php if($stype=="trs") { echo ' class="active"';}?>><a href="<?php echo SITE_URL;?>usersharing.php?stype=trs">Traffic Referred</a></li>
                    <li<?php if($stype=="tlp") { echo ' class="active"';}?>><a href="<?php echo SITE_URL;?>usersharing.php?stype=tlp">Top Liked FB Pages</a></li>
                    
                </ul>
            </li>
            
        </ul>
        <!-- every .sidebar-nav may have a title -->
        <?php /*
        <h5 class="sidebar-nav-title">Template <a class="action-link" href="#"><i class="glyphicon glyphicon-refresh"></i></a></h5>
        <ul class="sidebar-nav">
            <li>
                <!-- an example of nested submenu. basic bootstrap collapse component -->
                <a class="collapsed" href="#sidebar-forms" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon">
                        <i class="glyphicon glyphicon-align-right"></i>
                    </span>
                    Forms
                    <i class="toggle fa fa-angle-down"></i>
                </a>
                <ul id="sidebar-forms" class="collapse">
                    <li><a href="form_elements.html">Form Elements</a></li>
                    <li><a href="form_validation.html">Form Validation</a></li>
                    <li><a href="form_wizard.html">Form Wizard</a></li>
                </ul>
            </li>
            <li>
                <a class="collapsed" href="#sidebar-ui" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon">
                        <i class="glyphicon glyphicon-tree-conifer"></i>
                    </span>
                    UI Elements
                    <i class="toggle fa fa-angle-down"></i>
                </a>
                <ul id="sidebar-ui" class="collapse">
                    <li><a href="ui_components.html">Components</a></li>
                    <li><a href="ui_notifications.html">Notifications</a></li>
                    <li><a href="ui_icons.html">Icons</a></li>
                    <li><a href="ui_buttons.html">Buttons</a></li>
                    <li><a href="ui_tabs_accordion.html">Tabs &amp; Accordion</a></li>
                    <li><a href="ui_list_groups.html">List Groups</a></li>
                </ul>
            </li>
            <li>
                <a href="grid.html">
                    <span class="icon">
                        <i class="glyphicon glyphicon-th"></i>
                    </span>
                    Grid
                </a>
            </li>
            <li>
                <a class="collapsed" href="#sidebar-maps" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon">
                        <i class="glyphicon glyphicon-map-marker"></i>
                    </span>
                    Maps
                    <i class="toggle fa fa-angle-down"></i>
                </a>
                <ul id="sidebar-maps" class="collapse">
                    <!-- data-no-pjax turns off pjax loading for this link. Use in case of complicated js loading on the
                         target page -->
                    <li><a href="maps_google.html" data-no-pjax>Google Maps</a></li>
                    <li><a href="maps_vector.html">Vector Maps</a></li>
                </ul>
            </li>
            <li>
                <!-- an example of nested submenu. basic bootstrap collapse component -->
                <a class="collapsed" href="#sidebar-tables" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon">
                        <i class="fa fa-table"></i>
                    </span>
                    Tables
                    <i class="toggle fa fa-angle-down"></i>
                </a>
                <ul id="sidebar-tables" class="collapse">
                    <li><a href="tables_basic.html">Tables Basic</a></li>
                    <li><a href="tables_dynamic.html">Tables Dynamic</a></li>
                </ul>
            </li>
            <li>
                <a class="collapsed" href="#sidebar-extra" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon">
                        <i class="fa fa-leaf"></i>
                    </span>
                    Extra
                    <i class="toggle fa fa-angle-down"></i>
                </a>
                <ul id="sidebar-extra" class="collapse">
                    <li><a href="calendar.html">Calendar</a></li>
                    <li><a href="invoice.html">Invoice</a></li>
                    <li><a href="login.html" target="_blank" data-no-pjax>Login Page</a></li>
                    <li><a href="error.html" target="_blank" data-no-pjax>Error Page</a></li>
                    <li><a href="gallery.html">Gallery</a></li>
                    <li><a href="search.html">Search Results</a></li>
                    <li><a href="time_line.html" data-no-pjax>Time Line</a></li>
                </ul>
            </li>
            <li>
                <a class="collapsed" href="#sidebar-levels" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon">
                        <i class="fa fa-folder-open"></i>
                    </span>
                    Menu Levels
                    <i class="toggle fa fa-angle-down"></i>
                </a>
                <ul id="sidebar-levels" class="collapse">
                    <li><a href="#">Level 1</a></li>
                    <li>
                        <a class="collapsed" href="#sidebar-sub-levels" data-toggle="collapse" data-parent="#sidebar-levels">
                            Level 2
                            <i class="toggle fa fa-angle-down"></i>
                        </a>
                        <ul id="sidebar-sub-levels" class="collapse">
                            <li><a href="#">Level 3</a></li>
                            <li><a href="#">Level 3</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
        
        <h5 class="sidebar-nav-title">Labels <a class="action-link" href="#"><i class="glyphicon glyphicon-plus"></i></a></h5>
        <!-- some styled links in sidebar. ready to use as links to email folders, projects, groups, etc -->
        <ul class="sidebar-labels">
            <li>
                <a href="#">
                    <!-- yep, .circle again -->
                    <i class="fa fa-circle text-warning mr-xs"></i>
                    <span class="label-name">My Recent</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-circle text-gray mr-xs"></i>
                    <span class="label-name">Starred</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-circle text-danger mr-xs"></i>
                    <span class="label-name">Background</span>
                </a>
            </li>
        </ul>
        <h5 class="sidebar-nav-title">Projects</h5>
        <!-- A place for sidebar notifications & alerts -->
        <div class="sidebar-alerts">
            <div class="alert fade in">
                <a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
                <span class="text-white fw-semi-bold">Sales Report</span> <br>
                <div class="progress progress-xs mt-xs mb-0">
                    <div class="progress-bar progress-bar-gray-light" style="width: 16%"></div>
                </div>
                <small>Calculating x-axis bias... 65%</small>
            </div>
            <div class="alert fade in">
                <a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
                <span class="text-white fw-semi-bold">Personal Responsibility</span> <br />
                <div class="progress progress-xs mt-xs mb-0">
                    <div class="progress-bar progress-bar-danger" style="width: 23%"></div>
                </div>
                <small>Provide required notes</small>
            </div>
        </div>
        */ ?>
    </div>
</nav>
<!-- This is the white navigation bar seen on the top. A bit enhanced BS navbar. See .page-controls in _base.scss. -->
<nav class="page-controls navbar navbar-default">
    <div class="container-fluid">
        <!-- .navbar-header contains links seen on xs & sm screens -->
        <div class="navbar-header">
            <ul class="nav navbar-nav">
                <li>
                    <!-- whether to automatically collapse sidebar on mouseleave. If activated acts more like usual admin templates -->
                    <a class="hidden-sm hidden-xs" id="nav-state-toggle" href="#" title="Turn on/off sidebar collapsing" data-placement="bottom">
                        <i class="fa fa-bars fa-lg"></i>
                    </a>
                    <!-- shown on xs & sm screen. collapses and expands navigation -->
                    <a class="visible-sm visible-xs" id="nav-collapse-toggle" href="#" title="Show/hide sidebar" data-placement="bottom">
                        <span class="rounded rounded-lg bg-gray text-white visible-xs"><i class="fa fa-bars fa-lg"></i></span>
                        <i class="fa fa-bars fa-lg hidden-xs"></i>
                    </a>
                </li>
                <li class="ml-sm mr-n-xs hidden-xs"><a href="#"><i class="fa fa-refresh fa-lg"></i></a></li>
                <li class="ml-n-xs hidden-xs"><a href="#"><i class="fa fa-times fa-lg"></i></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right visible-xs">
                <li>
                    <!-- toggles chat -->
                    <a href="#" data-toggle="chat-sidebar">
                        <span class="rounded rounded-lg bg-gray text-white"><i class="fa fa-globe fa-lg"></i></span>
                    </a>
                </li>
            </ul>
            <!-- xs & sm screen logo -->
            <a class="navbar-brand visible-xs" href="index.php">
                <i class="fa fa-circle text-gray mr-n-sm"></i>
                <i class="fa fa-circle text-warning"></i>
                &nbsp;
                Coupay Social
                &nbsp;
                <i class="fa fa-circle text-warning mr-n-sm"></i>
                <i class="fa fa-circle text-gray"></i>
            </a>
        </div>

        <!-- this part is hidden for xs screens -->
        <div class="collapse navbar-collapse">
            <!-- search form! link it to your search server -->
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <form name="hed_serc_frm" id="hed_serc_frm" action="" method="get">
                        <div class="input-group input-group-no-border">
                            <span class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </span>
                            <input class="form-control" type="text" name="header_search" id="header_search" value="<?php echo isset($_GET['header_search']) ? $_GET['header_search'] : '';?>" placeholder="Search Dashboard" />
                        </div>
                    </form>
                </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle dropdown-toggle-notifications" id="notifications-dropdown-toggle" data-toggle="dropdown">
                        <span class="thumb-sm avatar pull-left">
                            <?php if(isset($_SESSION['admin_img']) && $_SESSION['admin_img']!="" && file_exists(DIR_FS."img/cs_admin/".$_SESSION['admin_img'])) {?>
                                <img class="img-circle" src="<?php echo SITE_URL."img/cs_admin/".$_SESSION['admin_img'];?>" alt="..." />
                            <?php } else {?>
                                <img class="img-circle" src="<?php echo SITE_URL."img/cs_admin/avatar.png";?>" alt="..." />
                            <?php }?>
                        </span>
                        &nbsp;
                        <?php echo $_SESSION['firstname'];?> <strong><?php echo $_SESSION['lastname'];?></strong>&nbsp;
                        <!--span class="circle bg-warning fw-bold">
                            13
                        </span-->
                        <!--b class="caret"></b--></a>
                    <!-- ready to use notifications dropdown.  inspired by smartadmin template.
                         consists of three components:
                         notifications, messages, progress. leave or add what's important for you.
                         uses Sing's ajax-load plugin for async content loading. See #load-notifications-btn -->
                    
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-cog fa-lg"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <!--li><a href="#"><i class="glyphicon glyphicon-user"></i> &nbsp; My Account</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Calendar</a></li-->
                        <!--li><a href="#">Inbox &nbsp;&nbsp;<span class="badge bg-danger animated bounceIn">9</span></a></li-->
                        
                           <li<?php if($page_name=="site_setting.php") { echo ' class="active"';}?>><a href="site_setting.php">Site Setting</a></li>
                               <li class="divider"></li>
                    <li<?php if($page_name=="social_icon_setting.php") { echo ' class="active"';}?>><a href="social_icon_setting.php">Social Icon Setting</a></li>
                        <li class="divider"></li>
                    <li<?php if($page_name=="share_setting.php") { echo ' class="active"';}?>><a href="share_setting.php">Like Bar Setting</a></li>
                        <li class="divider"></li>
                    <li<?php if($page_name=="authorization_setting.php") { echo ' class="active"';}?>><a href="authorization_setting.php">Authorization Setting</a></li>
                        <li class="divider"></li>
                    <li<?php if($page_name=="follow_bar_setting.php") { echo ' class="active"';}?>><a href="follow_bar_setting.php">Follow Bar Setting</a></li>
                        <li class="divider"></li>
                    <li<?php if($page_name=="social_login_setting.php") { echo ' class="active"';}?>><a href="social_login_setting.php">Login Setting</a></li>
                    
                        <li class="divider"></li>
                        <li><a href="change_password.php">Change Password</a></li>
                        <li class="divider"></li>
                        <li><a href="logoff.php"><i class="fa fa-sign-out"></i> &nbsp; Log Out</a></li>
                    </ul>
                </li>
                <!--li>
                    <a href="#" data-toggle="chat-sidebar">
                        <i class="fa fa-globe fa-lg"></i>
                    </a>
                    <div id="chat-notification" class="chat-notification hide">
                        <div class="chat-notification-inner">
                            <h6 class="title">
                                <span class="thumb-xs">
                                    <img src="demo/img/people/a6.jpg" class="img-circle mr-xs pull-left" />
                                </span>
                                Jess Smith
                            </h6>
                            <p class="text">Hey! What's up?</p>
                        </div>
                    </div>
                </li-->
            </ul>
        </div>
    </div>
</nav>