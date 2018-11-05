<?php
include("include/config.php");

// content="text/plain; charset=utf-8"
include ("jpgraph/jpgraph.php");
include ("jpgraph/jpgraph_pie.php");


if(isset($_GET['type']) && $_GET['type']=="dmg_age")
{
    $age_sql=mysql_query($_SESSION['select_age_main']);
    $age_rec=mysql_fetch_array($age_sql);

    $data=array(); $labels=array();
    if($age_rec['LT13']>"0") { $data[]=$age_rec['LT13']; $labels[]="Under 13\n(%.1f%%)"; } 
    if($age_rec['GT13_LT17']>"0") { $data[]=$age_rec['GT13_LT17']; $labels[]="14 - 17\n(%.1f%%)"; }
    if($age_rec['GT18_LT34']>"0") { $data[]=$age_rec['GT18_LT34']; $labels[]="18 - 34\n(%.1f%%)"; }
    if($age_rec['GT35_LT49']>"0") { $data[]=$age_rec['GT35_LT49']; $labels[]="35 - 49\n(%.1f%%)"; }
    if($age_rec['GT50']>"0") { $data[]=$age_rec['GT50']; $labels[]="50+\n(%.1f%%)"; }
    
    // Some data and the labels
    if(count($data)<=0)
    {
        $data   = array(19,12,4,7,3,12,3);
        $labels = array("First\n(%.1f%%)",
                        "Second\n(%.1f%%)","Third\n(%.1f%%)",
                        "Fourth\n(%.1f%%)","Fifth\n(%.1f%%)",
                        "Sixth\n(%.1f%%)","Seventh\n(%.1f%%)");
    }
     
    // Create the Pie Graph.
    $graph = new PieGraph(200,200);
    //$graph->SetShadow();
     
    // Set A title for the plot
    $graph->title->Set('New Users by Age');
    $graph->title->SetFont(FF_VERDANA,FS_BOLD,12);
    $graph->title->SetColor('black');
     
    // Create pie plot
    $p1 = new PiePlot($data);
    $p1->SetCenter(0.5,0.5);
    $p1->SetSize(0.3);
    $p1->SetSliceColors(array('#DC143C','#BA55D3','#1E90FF','#2E8B57'));
     
    // Setup the labels to be displayed
    $p1->SetLabels($labels);
     
    // This method adjust the position of the labels. This is given as fractions
    // of the radius of the Pie. A value < 1 will put the center of the label
    // inside the Pie and a value >= 1 will pout the center of the label outside the
    // Pie. By default the label is positioned at 0.5, in the middle of each slice.
    $p1->SetLabelPos(0.5);
     
    // Setup the label formats and what value we want to be shown (The absolute)
    // or the percentage.
    $p1->SetLabelType(PIE_VALUE_PER);
    $p1->value->Show();
    $p1->value->SetFont(FF_ARIAL,FS_NORMAL,9);
    $p1->value->SetColor('white');
     
    // Add and stroke
    $graph->Add($p1);
    $graph->Stroke();
}
else if(isset($_GET['type']) && $_GET['type']=="dmg_gen")
{
    $gen_sql=mysql_query($_SESSION['select_gen_main']);
    $gen_rec=mysql_fetch_array($gen_sql);

    $data=array(); $labels=array();
    $data[]=$gen_rec['Male']; $labels[]="Male\n(%.1f%%)"; 
    $data[]=$gen_rec['Female']; $labels[]="Female\n(%.1f%%)";
    
    
    // Some data and the labels
    if(count($data)<=0)
    {
        $data   = array(19,12);
        $labels = array("Male\n(%.1f%%)","Female\n(%.1f%%)");
    }
     
    // Create the Pie Graph.
    $graph = new PieGraph(200,200);
    //$graph->SetShadow();
     
    // Set A title for the plot
    $graph->title->Set('New Users by Gender');
    $graph->title->SetFont(FF_VERDANA,FS_BOLD,12);
    $graph->title->SetColor('black');
     
    // Create pie plot
    $p1 = new PiePlot($data);
    $p1->SetCenter(0.5,0.5);
    $p1->SetSize(0.3);
    $p1->SetSliceColors(array('#1E90FF','#2E8B57'));
     
    // Setup the labels to be displayed
    $p1->SetLabels($labels);
     
    // This method adjust the position of the labels. This is given as fractions
    // of the radius of the Pie. A value < 1 will put the center of the label
    // inside the Pie and a value >= 1 will pout the center of the label outside the
    // Pie. By default the label is positioned at 0.5, in the middle of each slice.
    $p1->SetLabelPos(0.5);
     
    // Setup the label formats and what value we want to be shown (The absolute)
    // or the percentage.
    $p1->SetLabelType(PIE_VALUE_PER);
    $p1->value->Show();
    $p1->value->SetFont(FF_ARIAL,FS_NORMAL,9);
    $p1->value->SetColor('white');
     
    // Add and stroke
    $graph->Add($p1);
    $graph->Stroke();
}
?>