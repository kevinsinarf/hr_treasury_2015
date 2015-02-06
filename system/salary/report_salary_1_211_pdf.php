<?php

$path = "../../";
define('FPDF_FONTPATH','font/');
include($path."include/config_header_top.php");
include($path."include\MPDF53/mpdf.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$pdf = new mPDF('th', 'A4', '0', 'THSaraban');
$pdf ->AddPage('','','','','',7,7,7,7,'4','4');
$unknow_tab = " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
// print per once.

$ROUND = (int)$_POST['ROUND'];
$AGE_IS = (int)$_POST['AGE_IS'];
$PER_NAME = $_POST['PER_NAME'];
$POSITION_NO = $_POST['POSITION_NO'];
$LINE_NAME = $_POST['LINE_NAME'];
$LEVEL_NAME = $_POST['LEVEL_NAME'];
$ORG_NAME_IS = $_POST['ORG_NAME_IS'];
$SALARY_NOW = $_POST['SALARY_NOW_is'];
$SALARY_UP = $_POST['SALARY_UP_is'];
$SALARY_NEW = $_POST['SALARY_NEW_is'];
$LEVEL_SALARY_MID = $_POST['LEVEL_SALARY_MID_is']; 
$SALARY_SPE_UP =  $_POST['SALARY_SPE_UP_is'];
$SCORE_PERCENT = $_POST['SCORE_PERCENT_is'];
$REMARK = $_POST['REMARK_IS'];
$UPDATE_DATE = $_POST['UPDATE_DATE'];
$SAL_UP_ID = (int)$_POST['SAL_UP_ID_is'];

   
  $UPDATE_DATE = update_date_name($UPDATE_DATE);
 

$file_name = $path . "cache-report/211-report/".$SAL_UP_ID."_".$UPDATE_DATE.".txt";
//$file_name_content = $path . "cache-report/211-report/".$SAL_UP_ID.".txt";
if (!file_exists($file_name)) {   
	                       
 include_once("report_salary_1_211_madetxtfile.php"); 
	
}else{ // have file
        $html_report = '';
		$fh = fopen($file_name,'r');
		while ($line = fgets($fh)) {
		  $html_report .= $line;
		   //echo($line);
		}//echo $html;
		fclose($fh);
//exit();
}	
 
 $footer = '<div  style="width:20cm; font-size:6pt; text-align:right;" >Print : '.$TIMESTAMP.'</div>';
$pdf->SetHTMLFooter($footer);
$pdf->WriteHTML($html_report);

$pdf->Output();

 exit();
 
 ?>