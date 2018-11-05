<?php // content="text/plain; charset=utf-8"
include("include/config.php");
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');


if(isset($_GET['type']) && $_GET['type']=="relationship_status")
{
    $datay=array(); $datax=array();
    $grph_title="Relationship Status Report";
    //$rel_status_sql=mysql_query("SELECT relationship_status, count(relationship_status) as total_user FROM `cs_fb_share_users` WHERE client_id='".$_SESSION['admin_id']."' GROUP BY relationship_status");
    $rel_status_sql=mysql_query("SELECT relationship_status, count(*) as total_user FROM `cs_fb_share_users` WHERE client_id='".$_SESSION['admin_id']."' GROUP BY relationship_status ORDER BY relationship_status");

    while($rel_status_rec=mysql_fetch_array($rel_status_sql))
    {
        $datay[]=$rel_status_rec['total_user'];
        if($rel_status_rec['relationship_status']=="") {
            $datax[]="N/A";
        } else {
            $datax[]=$rel_status_rec['relationship_status'];
        }
    }
}
else {
    $datay=array(12,8,19,3,10,5,15);
    $datax=array('0-5','6-10','11-15','16-20','21-25','26-30','31-35');
}



 
// Create the graph. These two calls are always required
$graph = new Graph(400,200);
$graph->SetScale('textint',0,max($datay)+5);
$graph->SetFrame(false); // No border around the graph
  
// Adjust the margin a bit to make more room for titles
$graph->SetMargin(40,30,20,40);




// Setup X-axis
$graph->xaxis->SetTickLabels($datax);
//$graph->xaxis->SetLabelAngle(50);
$graph->xaxis->HideLine(false);
$graph->xaxis->HideTicks(false,false);
// Some extra margin looks nicer
$graph->xaxis->SetLabelMargin(4);

// Label align for X-axis
$graph->xaxis->SetLabelAlign('center');
 

// Add some grace to y-axis so the bars doesn't go
// all the way to the end of the plot area
$graph->yaxis->scale->SetGrace(20);

$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);
 


 
// Create a bar pot
$bplot = new BarPlot($datay);
 
// Adjust fill color
$bplot->SetFillColor('#007acf');
$bplot->SetColor("white");
$bplot->SetFillGradient("#007acf","white",GRAD_LEFT_REFLECTION);
//$bplot->SetWidth(45);

$graph->Add($bplot);

 
// Setup the titles
$graph->title->Set($grph_title);
$graph->xaxis->title->Set('Relationship Status');
$graph->yaxis->title->Set('Total User');
 
$graph->title->SetFont(FF_FONT1,FS_BOLD);
// Setup font for axis
$graph->xaxis->SetFont(FF_FONT1,FS_NORMAL,10);
$graph->yaxis->SetFont(FF_FONT1,FS_NORMAL,10);

 
// Display the graph
$graph->Stroke();

?>