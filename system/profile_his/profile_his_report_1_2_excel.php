<?php header ('Content-type: text/html; charset=utf-8');
$path = "../../";
define('FPDF_FONTPATH','font/');
include($path."include/config_header_top.php");
//include($path."include\MPDF53/mpdf.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$menu_name = 2;
$report_name = $report_menu[$menu_name]['name'];
//$pdf = new mPDF('th', 'A4', '0', 'THSaraban');
//$pdf ->AddPage('','','','','',7,7,7,7,'','');


//POST
$PER_ID = $_POST['PER_ID'];

  if(isset($_POST['pdf_body'])){
  	 
		$html  .= html_report_header($menu_name);
	$html_body = $_POST['pdf_body'];
	
	$html_body =  str_replace("CENTER_TOP",$CENTER_TOP,$html_body);
	$html_body =  str_replace("LEFT_TOP",$LEFT_TOP,$html_body);
	$html_body =  str_replace(">  </td>",">&nbsp;</td>",$html_body);
       
     $html_body = str_replace(";\'", ";'", $html_body);
     $html_body = str_replace("<tr  style=\'height:0.7cm;'>", "<tr  style='height:0.7cm;'>", $html_body);	
     $html_body = str_replace("=\'center\'>", "='center'>", $html_body);	
     $html_body = str_replace("=\'height:", "='height:", $html_body);  
     $html_body = str_replace("colspan=\'2\' >", "colspan='2' >", $html_body); 	    
	 
	$html .= $html_body;
	$html .= "</table>";
	
	

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");;
    header("Content-Disposition: attachment;filename=$report_name-$sec.xls "); // 
    header("Content-Transfer-Encoding: binary ");

	
	
		 echo $html; exit();
   }else{
         exit();
   }
 
 
//$footer = '<div  style="width:20cm; font-size:6pt; text-align:right;" >Print : '.$TIMESTAMP.'</div>';
//$pdf->SetHTMLFooter($footer);
//$pdf->WriteHTML($html);

//$pdf->Output();
?>  