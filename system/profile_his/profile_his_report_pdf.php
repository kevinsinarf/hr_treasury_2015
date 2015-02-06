<?php 
if(($menu_name=="26")||($menu_name=="48")){
	ini_set('memory_limit', '2048M');
}else{
	ini_set("memory_limit","512M");
}


//ini_set('memory_limit', '-1');
 header ('Content-type: text/html; charset=utf-8');
 
$path = "../../";
$menu_name = (int)$_POST['report_id_is'];
define('FPDF_FONTPATH','font/');
include($path."include/config_header_top.php");


$AGE_IS_gen = $SEARCH_TYPE;
 
 
if($menu_name=="26"){
    $html_start = " <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' class='table table-bordered table-striped table-hover table-condensed' >
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
    $html_start = "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' class='table table-bordered table-striped table-hover table-condensed' >
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
    $html_start = " <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' class='table table-bordered table-striped table-hover table-condensed' >
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

include($path."include\MPDF53/mpdf.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$header = "";
$add_Apage_size = "";
if(($menu_name > 100)||($menu_name==8)||($menu_name==10)||($menu_name==16)||($menu_name==19)||($menu_name==20)||($menu_name==21)||($menu_name==22)||($menu_name==45)||($menu_name==61)||($menu_name==203)){
   $add_Apage_size = "-L";
}
 if($menu_name==203){
	$pdf = new mPDF('th', 'A4', '0', '0', 'THSaraban', 7, 7, 15,15, 4, 4);
	$font_size = 3;
 }else{
	$pdf = new mPDF('th', 'A4'.$add_Apage_size, '0', 'THSaraban', 7, 7, 15, 15, 4, 4);
	$font_size = 10;
 }

 $pdf->pagenumSuffix = '/';
 
 // echo "<pre>"; print_r($_POST); exit();

$name_2 = "";
$name_3 = "";
$SEARCH_TYPE = "";
if($_POST['SEARCH_TYPEr']!=""){
	$SEARCH_TYPE  = $_POST['SEARCH_TYPEr'];
}

 
if($_POST['report_print_name2'] != ""){ 
	$name_2 = $_POST['report_print_name2'];
	}
if($_POST['report_print_name3']!=""){	
	$name_3 = $_POST['report_print_name3'];
	}
	
if($name_2 !=""){
	if (strpos($array_attache_report["at"],$name_2) !== false) {
	 
	}else{
	   $name_2 = $array_attache_report["at"]." ".$name_2;
	}
}	

if($name_3 !=""){
	if (strpos($array_attache_report["sign_at"],$name_3) !== false) {
	
	}else{
	   $name_3 = $array_attache_report["sign_at"]." ".$name_3;
	}
}	

$report_print_name =  "<div align='center' ><strong>".$_POST['report_print_name']." ".$name_2." ".$name_3."</strong></div><br/>";


//$pdf ->AddPages('','', '','', '',7,7,7,7,'','','','', '', '', 0, 0, 0, 0, '','L');

  $html = "";


 
  $title_name_label = $report_menu[$menu_name]['name'];
  
  if(($menu_name==11)||($menu_name==12)||($menu_name==16)||($menu_name==42)||($menu_name==43)||($menu_name==55)||($menu_name==56)||($menu_name==58)){ 
     $title_name_label = $title_name_label." ".$SEARCH_TYPE;
  }  
  
  $title_name = "<div align='center'><strong> <span style='font-size:12pt;' >".$title_name_label."</span></strong></div><br/>"; 	
$html .=  "<style type='text/css'>
				.font_1 {
					font-size:20pt;
				}
				body{
					font-size:".$font_size."pt;
				}
				.nrmal_font{
					font-size:9pt;
				}
				table {
					border-collapse:collapse;
				}
				td {
					padding:5px;
				}
				
			</style>";
	if (!in_array($menu_name, $attached_report)) {  
		$html .=  $title_name;
	}

//POST
$PER_ID = $_POST['PER_ID'];

  if(isset($_POST['pdf_body'])){
  	   if(($menu_name==24)){
		  $html  .= " <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;'> ";
		  $html  .=  html_report_header($menu_name,$SEARCH_TYPE);
	   }else{  
			 if(($menu_name==26)||($menu_name==48)||($menu_name==64)){   
			 
					$html .= $html_start;
			  } else{
					$html  .=  html_report_header($menu_name,$SEARCH_TYPE);
			  }
		}
		
		
		
	// head

 
 
    $html = str_replace("<th style='", "<th style=' border:solid 1px #000000;   ", $html); 
    $html = str_replace("class='bgHead'", "    ", $html); 
	$html = str_replace(" table table-bordered table-striped table-hover table-condensed  " ," ", $html);
	// sub 
 
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
     $html_body = str_replace("XRXX", " style=' border:solid 1px #000000;   '", $html_body); 
     $html_body = str_replace("class='bgHead'", "    ", $html_body); 
	 $html_body = str_replace(" class='table table-bordered table-striped table-hover table-condensed'  " ," ", $html_body);
  
	 
	$html .=  $html_body;
	$html .= "</table>"; 
	if($menu_name==203){   $html = "<br/><br/><br/><br/><br/><br/>".$html; }
	$html  = "<html><head></head><body>".$html."</body></html>";
       //echo " On Debuging : ". $html; exit();
	$html = str_replace("table-condensed" ," ", $html); 
	$html = str_replace("table-hover" ," ", $html); 
	$html = str_replace("table-striped" ," ", $html); 
	$html = str_replace("table table-bordered" ," ", $html);     //echo " On Debuging : ".$menu_name. $html; exit();
   }else{
         exit();
   }
   // add report name if attache file report
	if (in_array($menu_name, $attached_report)) {
  	     //$html = $report_print_name.$html;
	}
	if (in_array($menu_name, $attached_report)) {
		$header = $report_print_name;
	}
//$footer = '<div  style="font-size:6pt; text-align:right;" >Print : '.$TIMESTAMP.' </div>';
$footer = '<table width="100%" style="font-size:7pt;"  cellspacing="0" cellpadding="0"  >
				<tr>
					<td align="left" style="border:solid 0px #FFFFFF;">Print : '.$TIMESTAMP.' </td> 
					<td align="right" style="border:solid 0px #FFFFFF;">{PAGENO}{nbpg}</td>
				</tr>
            </table>
			';
if($header!=""){
	$pdf->SetHTMLHeader($header);
}
$pdf->SetHTMLFooter($footer);
$pdf->WriteHTML($html);

$pdf->Output();
?>  