<?php header ('Content-type: text/html; charset=utf-8');
$path = "../../";
define('FPDF_FONTPATH','font/');
include($path."include/config_header_top.php");
//include($path."include\MPDF53/mpdf.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$menu_name = (int)$_POST['report_id_is'];
$report_name = $report_menu[$menu_name]['name'];
//$pdf = new mPDF('th', 'A4', '0', 'THSaraban');
//$pdf ->AddPage('','','','','',7,7,7,7,'','');
$headline_title =  $report_menu[$menu_name]['name'];
		
$SEARCH_TYPE = "";
if($_POST['SEARCH_TYPEr']!=""){
	$SEARCH_TYPE  = $_POST['SEARCH_TYPEr'];
}	
		
		
$AGE_IS_gen = $_POST['SEARCH_TYPEr'];
 
if($menu_name=="26"){  
    $html_start = " <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;font-family: TH SarabunPSK; font-size:16pt; ' class='table table-bordered table-striped table-hover table-condensed' >
	<thead width='100%' border='0' cellspacing='0' cellpadding='0' > <tr> ";
    for($i=1;$i<=45;$i++){ 
	    $title_name = $csv_tite_name[$i]['name'];
	    if(($i==27)||($i==29)){
		   $title_name = $title_name." ".($AGE_IS_gen-1);
		}
	    if(($i==28)||($i==30)){
		   $title_name = $title_name." ".$AGE_IS_gen;
		}
    	$html_start .= " <th style='  '   ><div align='center'><strong>".$title_name."</strong></div></th>
		";
		//$out_header .= $csv_tite_name[$i]['name'].","; //cache it.
	} // for 
	
    $html_start .= "</tr>
  </thead>";
}

if($menu_name=="48"){  
    $html_start = "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;font-family: TH SarabunPSK; font-size:16pt; ' class='table table-bordered table-striped table-hover table-condensed' >
	<thead width='100%' border='0' cellspacing='0' cellpadding='0' > <tr> ";
    for($i=1;$i<=23;$i++){ 
	    $title_name = $csv_tite_name2[$i]['name'];
	    if(($i==16)){
		   $title_name = $title_name." ".($AGE_IS_gen-1);
		}
	    if(($i==17)){
		   $title_name = $title_name." ".$AGE_IS_gen;
		}
    	$html_start .= " <th style='  '   ><div align='center'><strong>".$title_name."</strong></div></th>
		";
		//$out_header .= $csv_tite_name[$i]['name'].","; //cache it.
	} // for 
	
    $html_start .= "</tr>
  </thead>";
}
 
if($menu_name=="64"){
    $html_start = " <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; font-family: TH SarabunPSK; font-size:16pt;' class='table table-bordered table-striped table-hover table-condensed' >
	<thead width='100%' border='0' cellspacing='0' cellpadding='0' > <tr>";
    for($i=1;$i<=20;$i++){ 
	    $title_name = $csv_tite_name3[$i]['name'];
	    if(($i==11)||($i==13)){
		   $title_name = $title_name." ".($AGE_IS_gen-1);
		}
	    if(($i==12)||($i==14)){
		   $title_name = $title_name." ".$AGE_IS_gen;
		}
    	$html_start .= " <th style='  '   ><div align='center'><strong>".$title_name."</strong></div></th>
		";
		//$out_header .= $csv_tite_name[$i]['name'].","; //cache it.
	} // for 
	
    $html_start .= "</tr>
  </thead>";
}
 

//POST
$PER_ID = $_POST['PER_ID'];

  if(isset($_POST['pdf_body'])){
  	 
		$html  .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		 
		
  		 if(($menu_name==26)||($menu_name==48)||($menu_name==64)){   
		 
		        $html .= $html_start;
		  }  else{ // no table , add it first.
		      	if($menu_name=="24"){
					$html  .= " <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; font-family: TH SarabunPSK; font-size:16pt;'  class='table table-bordered table-striped table-hover table-condensed' >  ".html_report_header($menu_name);
				}else{
					$html  .= html_report_header($menu_name,$SEARCH_TYPE);
				}
		  }
		
        $html = str_replace("<th style='", "<th style=' border:solid 1px #000000;   ", $html);
		
		
	$html_body = $_POST['pdf_body'];
	
	$html_body =  str_replace("CENTER_TOP",$CENTER_TOP,$html_body);
	$html_body =  str_replace("LEFT_TOP",$LEFT_TOP,$html_body);
	$html_body =  str_replace("RIGHT_TOP",$RIGHT_TOP,$html_body);
	$html_body =  str_replace(">  </td>",">&nbsp;</td>",$html_body);
       
     $html_body = str_replace(";\'", ";'", $html_body);
     $html_body = str_replace("<tr  style=\'height:0.7cm;'>", "<tr  style='height:0.7cm;'>", $html_body);	
     $html_body = str_replace("=\'center\'>", "='center'>", $html_body);	
     $html_body = str_replace("=\'height:", "='height:", $html_body);  
     $html_body = str_replace("colspan=\'2\' >", "colspan='2' >", $html_body); 	 
     $html_body = str_replace(" class=\'bgHead\'   ", "  >", $html_body); 	
	  
	 
	$html .= $html_body;
	$html .= "</table>"; //ทดสอบ	
		// echo  "<center><h3>".$headline_title."</h3></center><br/>".$html; exit();	 
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment;filename="report_'.$menu_name.'.xls" '); //  ทดสอบ

  
	
		 echo  "<center><h3>".$headline_title."</h3></center><br/>".$html; exit();
   }else{
         exit();
   }
 
 
//$footer = '<div  style="width:20cm; font-size:6pt; text-align:right;" >Print : '.$TIMESTAMP.'</div>';
//$pdf->SetHTMLFooter($footer);
//$pdf->WriteHTML($html);

//$pdf->Output();
?>  