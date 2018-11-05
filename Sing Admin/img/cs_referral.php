<?php 
include("include/config.php");
if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }

$is_from_arr=array("","Facebook","LinkedIn","Twitter");

$err=array();

	$get_banner="SELECT csr.*, csu.email from `cs_referral` as csr, `cs_users` as csu WHERE csu.id=csr.ref_by and csu.client_id='".$_SESSION['admin_id']."' ";
	
	if(isset($_GET['header_search']) && $_GET['header_search']!='' )		
	{
		$get_banner.= " and (reg_user like '%".re_db_input($_GET['header_search'])."%' || email like '%".re_db_input($_GET['header_search'])."%' )";
	}

	if(isset($_GET['orderby']) && $_GET['orderby']!='' && isset($_GET['order']) && $_GET['order']=="asc") {
		$get_banner.=" ORDER BY ". $_GET['orderby']." ".$_GET['order'];
	}
	else if(isset($_GET['orderby']) && $_GET['orderby']!='') {
		$get_banner.=" ORDER BY ". $_GET['orderby']." desc";
	}
    else {
        $get_banner.=" ORDER BY id desc";
    }
    
	$extralink = re_get_all_get_params(array('action', 'pageno' ,'msg'));
	
	$href_url="cs_referral.php";
	$search_record=pagination($get_banner , $href_url, $extralink,isset($_GET['pageno'])?$_GET['pageno']:0, $rec_per_page=20, $style='', $separator='|', $get_var='pageno', $show_first_last_link=true);
	$res_banner=$search_record[0];
	$showingpage=$search_record[1];

include("header.php");
?>
<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
        <ol class="breadcrumb">
            <li>YOU ARE HERE</li>
            <li class="active">Referral</li>
        </ol>
        <h1 class="page-title">Referral</h1>
        <div class="row">
            <div class="col-md-12">
                <section class="widget">
                    <header>
                        <h5>Referral<span class="fw-semi-bold"> Listing</span></h5>
                        <div class="widget-controls">
                            <a href="#"><i class="glyphicon glyphicon-cog"></i></a>
                            <a data-widgster="close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <!--h3>Share <span class="fw-semi-bold">Links</span></h3>
                        <p>Each row is highlighted. You will never lost there. Just <code>.table-striped</code> it.</p-->
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <!--th>
                                    <div class="checkbox">
                                        <input id="checkbox1" type="checkbox" data-check-all>
                                        <label for="checkbox1"></label>
                                    </div>
                                </th-->
                                <th>Referred By</th>
                                <th>Registration By</th>
                                <th>Date Time</th>
                                <th>Referral Source</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if(re_db_num_rows($res_banner)>0)
                                {
                                    $i=1;
                                    while($row_banner=re_db_fetch_array($res_banner))
                                    {	 
                                        $i++;
                                        ?>
                                        <tr>
                                            <!--td>
                                                <div class="checkbox">
                                                    <input id="checkbox<?php //echo $i;?>" type="checkbox" />
                                                    <label for="checkbox<?php //echo $i;?>"></label>
                                                </div>
                                            </td-->
                                            <td><?php echo re_db_output($row_banner['email']); ?></td>
                                            <td><?php echo re_db_output($row_banner['reg_user']); ?></td>
                                            <td><?php echo re_db_output(date('m-d-Y H:i:s',strtotime($row_banner['date_time'])));; ?></td>
                                            <td><?php echo $is_from_arr[$row_banner['is_from']];?></td>
                                        </tr>
                                        <?php 
                                    }
                                }
                                else { ?>
                                    <tr><td style="text-align: center;" class="subheading" colspan="4">No Record Found</td></tr>
                                <?php } ?>                            
                                <tr>
                                    <td colspan="4" style="text-align: center;"><?php echo isset($prev)?$prev:''; ?>&nbsp;&nbsp;<?php echo isset($showingpage)?$showingpage:''; ?>&nbsp;&nbsp;<?php echo isset($next)?$next:''; ?></td>
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
<script src="vendor/jquery.sparkline/dist/jquery.sparkline.js"></script>
<!-- page specific js -->
<script src="js/tables-basic.js"></script>
</body>
</html>