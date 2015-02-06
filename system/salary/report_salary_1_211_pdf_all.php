<?php
ini_set("memory_limit","256M");

$path = "../../";
define('FPDF_FONTPATH','font/');
include($path."include/config_header_top.php");
include($path."include\MPDF53/mpdf.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$pdf = new mPDF('th', 'A4', '0', 'THSaraban');
$pdf ->AddPage('','','','','',7,7,7,7,'4','4');

$SAL_UP_ID_all = $_POST['SAL_UP_ID_all'];

$file_add = explode(",", $SAL_UP_ID_all);
$html_report = "";
   //echo "<pre>"; print_r($file_add); 
$all_file = count($file_add); 
 
for($i=0; $i< $all_file;$i++){  
     //$html_report .= "<br/>".$i." = ".$file_add[$i]."<br/>";
	if (file_exists($file_add[$i])) {   
//echo $i." = ".$file_add[$i]; exit();
		$fh = fopen($file_add[$i],'r');
		while ($line = fgets($fh)) {
		  $html_report .= $line;
		   //echo($line);
		}//echo $html;
		$html_report .=  " <pagebreak />";
		fclose($fh);
        
	}
}
//echo $html_report; exit();
 
 $footer = '<div  style="width:20cm; font-size:6pt; text-align:right;" >Print : '.$TIMESTAMP.'</div>';
$pdf->SetHTMLFooter($footer);
$pdf->WriteHTML($html_report);

$pdf->Output();

 
exit();
?>