<?php 
include("include/config.php");
if(!isset($_SESSION['admin_id'])) { header("location:login.php"); exit; }




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
            <div class="col-md-12">
                <section class="widget">
                    <header>
                        <h4>Site <small>Setting</small></h4>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <table class="table">
                            <tr><td>Please use the form below to configure your social service implementation.</td></tr>
                            <tr><th style="border: medium none;">Site Description</th></tr>
                            <tr><td style="border: medium none;"><textarea id="default-textarea" name="site_desc" class="form-control" rows="3"></textarea></td></tr>
                            <tr><th>Approved URLs</th></tr>
                            <tr>
                                <td style="border: medium none;">
                                    Include the URLs that you would like to use in this domain (we will validate this as part of our security policy). Please use a wildcard (*) to 
                                    indicate sub-domains, e.g. *.domain.com, or sub directory paths, e.g. www.domain.com/site/*, that use the same configuration.
                                    <a href="javascript:void(0);">Read more</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: medium none;">
                                    <div style="float: left; padding: 6px 0px 6px 0px;"><strong>Add URL:</strong>&nbsp;&nbsp;http://</div>
                                    <div class="input-group" style="width: 150px;">
                                        <input style="width: 170px;" type="text" class="form-control" id="add_site_url" name="add_site_url" value="" />
                                        <span class="input-group-btn">
                                            <button type="button" name="add_url_btn" id="add_url_btn" class="btn btn-default">Add</button>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: medium none;">
                                    <table style="width: 70%;" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 80%;">URL</th>
                                                <th style="width: 20%;">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>shoppimgmania.com</td>
                                                <td><a href="javascript:void(0);" title="Delete"><i class="glyphicon glyphicon-remove"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>shoppimgmania.com</td>
                                                <td><a href="javascript:void(0);" title="Delete"><i class="glyphicon glyphicon-remove"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>shoppimgmania.com</td>
                                                <td><a href="javascript:void(0);" title="Delete"><i class="glyphicon glyphicon-remove"></i></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr><th>Domain Alias (CNAME)</th></tr>
                            <tr>
                                <td style="border: medium none;">
                                     Some social networks require a sub domain to which to make callbacks. We highly recommend specifying a sub domain in your site and 
                                     defining a CNAME entry in your DNS server that maps the sub domain to socialize.gigya.com. Read more
                                    <a href="javascript:void(0);">Read more</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: medium none;">
                                    <div style="float: left; padding: 6px 0px 6px 0px;">CNAME redirect (sub domain URL):&nbsp;&nbsp;</div>
                                    <div class="input-group" style="width: 150px;">
                                        <input style="width: 220px;" type="text" class="form-control" id="sub_domain_url" name="sub_domain_url" placeholder="(e.g. openid.cnn.com)" />
                                    </div>
                                </td>
                            </tr>
                            <tr><th>Custom URL Shortening</th></tr>
                            <tr>
                                <td style="border: medium none;">
                                    If you wish to setup a custom short URL that will be used when publishing content to Social Networks, please setup a cname in your domain 
                                    and redirect the calls to fw.to. Also, please input below your short URL domain:
                                    <a href="javascript:void(0);">Read more</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: medium none;">
                                    <div style="float: left; padding: 6px 0px 6px 0px;">Custom Short Domain:&nbsp;&nbsp;</div>
                                    <div class="input-group" style="width: 150px;">
                                        <input style="width: 220px;" type="text" class="form-control" id="custome_url_sorting" name="custome_url_sorting" placeholder="(i.e. short.cnn.com)" />
                                    </div>
                                </td>
                            </tr>
                            <tr><th>Redirect Method:</th></tr>
                            <tr>
                                <td style="border: medium none;">
                                    <select style="width: 220px;" data-placeholder="Which galaxy is closest to Milky Way?" data-width="auto" data-minimum-results-for-search="10" tabindex="-1" class="select2 form-control" id="default-select">
                                        <option value="">Hello</option>
                                        <option value="Magellanic">Large Magellanic Cloud</option>
                                        <option value="Andromeda">Andromeda Galaxy</option>
                                        <option value="Sextans">Sextans A</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: medium none;">
                                    <div class="btn-toolbar">
                                        <button type="button" class="btn btn-sm btn-default pull-right">Cancel</button>
                                        <button type="button" class="btn btn-sm btn-default pull-right">Save Settings</button>
                                    </div>
                                </td>
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