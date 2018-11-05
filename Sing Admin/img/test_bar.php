<?php // content="text/plain; charset=utf-8"
include("include/config.php");
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');


if(isset($_GET['type']))
{
    $datay=array(); $datax=array();
    if($_GET['type']=="fb_user_age")
    {
        $grph_title="Facebook Users Age Report";
        $age_qry="select b.age, count(b.age) as tot_user from (
        	           SELECT TIMESTAMPDIFF(YEAR,birthday,CURDATE()) AS age FROM cs_fb_share_users WHERE client_id='".$_SESSION['admin_id']."'
                    ) as b group by b.age order by b.age";
    }
    else if($_GET['type']=="li_user_age")
    {
        $grph_title="LinkedIn Users Age Report";
        $age_qry="select b.age, count(b.age) as tot_user from (
        	           SELECT if(byear!='0000', TIMESTAMPDIFF(YEAR,concat(byear,'-',bmonth,'-',bday),CURDATE()), '0') as age FROM cs_li_data as lid, cs_users as csu WHERE csu.id=lid.member_id and csu.client_id='".$_SESSION['admin_id']."' 
                  ) as b group by b.age order by b.age";
    }
    else if($_GET['type']=="fb_li_user_age")
    {
        $grph_title="Age Report";
        $age_qry="select a.age, count(a.age) as tot_user from 
                    ( 
                        select b.* from (
                            SELECT email, TIMESTAMPDIFF(YEAR,birthday,CURDATE()) AS age, 'fb' as type FROM cs_fb_share_users WHERE client_id='".$_SESSION['admin_id']."'
                            union
                            SELECT csu.email, if(byear!='0000', TIMESTAMPDIFF(YEAR,concat(byear,'-',bmonth,'-',bday),CURDATE()), '0') as age, 'li' as type FROM cs_li_data as lid, cs_users as csu WHERE csu.id=lid.member_id and csu.client_id='".$_SESSION['admin_id']."'
                        ) as b group by b.email 
                    ) as a group by a.age order by a.age";
    }
    

    $age_sql=mysql_query($age_qry);
    while($age_rec=mysql_fetch_array($age_sql))
    {
        $tot_user[]=$age_rec['tot_user'];
        $age[]=$age_rec['age'];
    }
    
    $max_val = max($age);
    $min_val = min($age);
    
    for($i=0; $i<=$max_val; $i=$i+5)
    {
        $data="";
        if($i=="0")
        {
            if($_GET['type']=="li_user_age" || $_GET['type']=="fb_li_user_age")
            {
                //$datax[]="N/A";
                foreach($age as $key => $val)
                {
                    if($val>=$i && $val<=($i+5)) {
                        $data_1=$data_1+$tot_user[$key];
                    }
                }
                //if($data_1=="") { $datay[]="0"; } else { $datay[]=$data_1; }
                if($data_1!="") 
                { 
                    $datax[]="N/A";
                    $datay[]=$data_1; 
                }

                //$datax[]=$i."-".($i+5);
                foreach($age as $key => $val)
                {
                    if($val>=($i+1) && $val<=($i+5)) {
                        $data=$data+$tot_user[$key];
                    }
                }
                //if($data=="") { $datay[]="0"; } else { $datay[]=$data; }
                if($data!="") 
                { 
                    $datax[]=$i."-".($i+5);
                    $datay[]=$data; 
                }
            }
            else 
            {
                //$datax[]=$i."-".($i+5);
                foreach($age as $key => $val)
                {
                    if($val>=$i && $val<=($i+5)) {
                        $data=$data+$tot_user[$key];
                    }
                }
                //if($data=="") { $datay[]="0"; } else { $datay[]=$data; }
                if($data!="") 
                { 
                    $datax[]=$i."-".($i+5);
                    $datay[]=$data; 
                }
            }
        }
        else
        {
            //$datax[]=($i+1)."-".($i+5);
            foreach($age as $key => $val)
            {
                if($val>=($i+1) && $val<=($i+5)) {
                    $data=$data+$tot_user[$key];
                }
            }
            //if($data=="") { $datay[]="0"; } else { $datay[]=$data; }
            if($data!="") 
            { 
                $datax[]=($i+1)."-".($i+5);
                $datay[]=$data; 
            }
        }
    }
}
else {
    $datay=array(12,8,19,3,10,5,15);
    $datax=array('0-5','6-10','11-15','16-20','21-25','26-30','31-35');
}




 
// Create the graph. These two calls are always required
$graph = new Graph(400,200);
$graph->SetScale('textint',0,max($tot_user)+5);
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
$graph->xaxis->title->Set('Year Rang');
$graph->yaxis->title->Set('Total User');
 
$graph->title->SetFont(FF_FONT1,FS_BOLD);
// Setup font for axis
$graph->xaxis->SetFont(FF_FONT1,FS_NORMAL,10);
$graph->yaxis->SetFont(FF_FONT1,FS_NORMAL,10);

 
// Display the graph
$graph->Stroke();

?>