<?php 
include("include/config.php");
if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }

function generateRandomString($length,$api_key)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    $client_sql=re_db_query("SELECT * FROM cs_sites WHERE api_key='".$randomString."' OR api_secret='".$randomString."'");
    if(re_db_num_rows($client_sql)>0) {
        generateRandomString('10');
    } else if($api_key==$randomString) {
        generateRandomString('10');
    }
    else {
        return $randomString;
    }
}


if(isset($_GET['action']) && isset($_GET['id']))
{
    if($_GET['action']=="approve")
    {
        $api_key=generateRandomString('10','');
        $api_secret=generateRandomString('10',$api_key);
        
        $chk_sql=re_db_query("SELECT * FROM cs_sites WHERE id='".$_GET['id']."' and (ifnull(api_key,1)=1 or ifnulL(api_secret,1)=1)");
        
        if(re_db_num_rows($chk_sql)>0) {
            re_db_query("update cs_sites set is_approved='1', api_key='".$api_key."', api_secret='".$api_secret."' where id='".$_GET['id']."'");
        }
        else {
            re_db_query("update cs_sites set is_approved='1' where id='".$_GET['id']."'");
        }
        
        $_SESSION['msg']="approve";
    }
    else if($_GET['action']=="unapprove")
    {
        re_db_query("update cs_sites set is_approved='0' where id='".$_GET['id']."'");
        $_SESSION['msg']="unapprove";
    }
    header("location:cs_approve_client.php"); exit;
}


    $client_qry="SELECT * FROM cs_sites ";

	if(isset($_GET['header_search']) && $_GET['header_search']!='' )		
	{
		$client_qry.= " WHERE (site_url like '%".re_db_input($_GET['header_search'])."%' || admin_email like '%".re_db_input($_GET['header_search'])."%' || firstname like '%".re_db_input($_GET['header_search'])."%' || lastname like '%".re_db_input($_GET['header_search'])."%' )";
	}

	if(isset($_GET['orderby']) && $_GET['orderby']!='' && isset($_GET['order']) && $_GET['order']=="asc") {
		$client_qry.=" ORDER BY ". $_GET['orderby']." ".$_GET['order'];
	}
	else if(isset($_GET['orderby']) && $_GET['orderby']!='') {
		$client_qry.=" ORDER BY ". $_GET['orderby']." desc";
	}
    else {
        $client_qry.=" ORDER BY is_approved asc";
    }
    
    
    
	$extralink = re_get_all_get_params(array('action', 'id', 'pageno' ,'msg'));
	
	$href_url="cs_approve_client.php";
	$search_record=pagination($client_qry , $href_url, $extralink,isset($_GET['pageno'])?$_GET['pageno']:0, $rec_per_page=20, $style='', $separator='|', $get_var='pageno', $show_first_last_link=true);
	$client_sql=$search_record[0];
	$showingpage=$search_record[1];



if(isset($_SESSION['msg']) && ($_SESSION['msg']=="approve" || $_SESSION['msg']=="unapprove"))
{ 
    $msg="Changes Saved Successfully.";
    unset($_SESSION['msg']); 
}


include("header.php");
?>
<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
        <ol class="breadcrumb">
            <li>YOU ARE HERE</li>
            <li class="active">Client Approval</li>
        </ol>
        <!--h1 class="page-title">Site - <span class="fw-semi-bold">Settings</span></h1-->
        <div class="row">
            <div class="col-md-12">
                <section class="widget">
                    <header>
                        <h4>Approve <small>Client</small></h4>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <?php if(isset($msg) && $msg!="") {?>
                            <span style="text-align: center; color: #008000;"><?php echo $msg;?></span>
                        <?php }?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>URL</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(re_db_num_rows($client_sql)>0)
                                {
                                    while($client_rec=re_db_fetch_array($client_sql))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo re_db_output($client_rec['site_url']);?></td>
                                            <td><?php echo re_db_output($client_rec['firstname']);?></td>
                                            <td><?php echo re_db_output($client_rec['lastname']);?></td>
                                            <td><?php echo re_db_output($client_rec['admin_email']);?></td>
                                            <td>
                                                <?php 
                                                if($client_rec['is_approved']=="0") {
                                                    ?><a href="<?php echo SITE_URL;?>cs_approve_client.php?action=approve&id=<?php echo $client_rec['id'];?>">Approve</a><?php 
                                                } else if($client_rec['is_approved']=="1") {
                                                    ?><a href="<?php echo SITE_URL;?>cs_approve_client.php?action=unapprove&id=<?php echo $client_rec['id'];?>">Not Approve</a><?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php 
                                    }
                                }
                                else { ?>
                                    <tr><td style="text-align: center;" class="subheading" colspan="5">No Record Found</td></tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="5" style="text-align: center;"><?php echo isset($prev)?$prev:''; ?>&nbsp;&nbsp;<?php echo isset($showingpage)?$showingpage:''; ?>&nbsp;&nbsp;<?php echo isset($next)?$next:''; ?></td>
                                </tr>
                            </tbody>
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
<!--script src="js/share_setting.js"></script-->
</body>
</html>