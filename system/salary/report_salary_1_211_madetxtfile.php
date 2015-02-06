<?php  

$thaiyear = toThaiNumber($AGE_IS);
$thaiyear2 = toThaiNumber($AGE_IS -1);

if($ROUND==1){ 
    $na_date = " ณ ๑ เม.ย.".$thaiyear;
	$title_date = " ครั้งที่ ๑ ( ๑ ตุลาคม ".$thaiyear2." - ๓๑ มีนาคม ".$thaiyear." ) ";
}

if($ROUND==2){ 
    $na_date = " ณ ๑ ตุ.ค.".toThaiNumber($thaiyear);
	$title_date = " ครั้งที่ ๒ ( ๑ เมษายน ".$thaiyear2." - ๓๐ กันยายน ".$thaiyear2." ) ";
}

$chk_me = $SALARY_SPE_UP+$SALARY_UP;
if($chk_me > 0){
   $chk_img[0] = 1;
   $chk_img[1] = 0;
}else{
   $chk_img[0] = 0;
   $chk_img[1] = 1;
}


 $html_report =  "
<style type='text/css'>
				.font_1 {
					font-size:15pt;
				}
				body{
					font-size:12pt;
			 
				}
				.nrmal_font{
					font-size:12pt;
				}
				table {
					border-collapse:collapse;
				}
				td {
					padding:6px;
				}
				
			</style>
 ";
 $html_report .= toThaiNumber("<div align='center' style='text-align:center;' ><strong><p>".$report_menu[211]['name'].$arrCompenFor[1]."</p>
 <p>สำหรับรอบการประเมิน".$title_date."   </p>
 <p>".DEPARTMENT_OF_DISATER."</p> </strong>
 <p>---------------------</p>
 
 </div>");
 
 $html_report .= "  <div align='center' style='text-align:center;' ><table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; '     >
	<thead width='100%' border='0' cellspacing='0' cellpadding='0' >
  <tr   ><td style='width:5%'></td><td>
 <p><strong>ชื่อ - สกุล </strong>: ".$PER_NAME."</p><br/>
 <p><strong>ตำแหน่ง </strong>: ".$LINE_NAME."</p><br/>
 <p><strong>ระดับ </strong>: ".$LEVEL_NAME."</p><br/>
 <p><strong>หน่วยงานปฎิบัติ </strong>: ".$ORG_NAME_IS."</p><br/>
 <p><strong>ตำแหน่งเลขที่ </strong>: ".$POSITION_NO."</p><br/>
  <p><strong>เงินเดือนเดิม </strong>: ".toThaiNumber(number_format($SALARY_NOW,0))." บาท</p><br/>
</td></tr></table></div>";
 
  $html_report .= " 
 <div style='margin-left: auto; margin-right: auto; width: 90%'><table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; '     >
	<thead width='100%' border='0' cellspacing='0' cellpadding='0' >
  <tr   ><td style='width:5%'><img border=0 src='".$path."images/tick_me0".$chk_img[0].".png' style='width:30px;'></td><td>
   <span>ได้รับการเลื่อนเงินเดือน  :</span>
</td></tr></table>  </div>"; 
 $html_report .= " 
 
   <div style='margin-left: auto; margin-right: auto; width: 85%'>  <cente><table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; '  style='border: 1px solid black;margin:0px; padding:0px;'   >
	<thead width='100%' border='0' cellspacing='0' cellpadding='0' >
  <tr  style='height:1cm;text-align:center;'  >
    <td CENTER_TOP rowspan='2'  >ฐาน<br/>ในการคำนวณ<br/> ( บาท )</td>
    <td CENTER_TOP rowspan='2'  >ร้อยละ<br/>ที่ได้เลื่อน</td>
    <td CENTER_TOP colspan='2'  >จำนวนเงินที่ได้เลื่อน</td>
    <td CENTER_TOP rowspan='2'  >เงินเดือน<br/> ".$na_date."<br/>( บาท )</td>
    
  </tr>
  <tr   style='height:1cm;line-height:200%;text-align:center;'>
    <td CENTER_TOP  >เงินเดือน<br/>ที่ได้เลื่อน ( บาท ) </td>
    <td CENTER_TOP  >เงินค่าตอบแทน<br/>พิเศษ ( บาท )  </td>
 
  </tr>
 
  </thead> 
  
  <tr style='height:1cm;'>
     <td CENTER_TOP  >".toThaiNumber(number_format($LEVEL_SALARY_MID,0))."</td>
	 <td CENTER_TOP >".toThaiNumber(number_format($SCORE_PERCENT,3))."</td>
	 <td CENTER_TOP >".toThaiNumber(number_format($SALARY_UP,2))."</td>
	 <td CENTER_TOP >".toThaiNumber(number_format($SALARY_SPE_UP,2))."</td>
	 <td CENTER_TOP >".toThaiNumber(number_format($SALARY_NEW,0))."</td>
  </tr>
   
  </table> </center> </div>";
  
  $html_report .= "  <br/> <br/>
 <div style='margin-left: auto; margin-right: auto; width: 90%'><table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; '     >
	<thead width='100%' border='0' cellspacing='0' cellpadding='0' >
  <tr   ><td style='width:5%'><img border=0 src='".$path."images/tick_me0".$chk_img[1].".png' style='width:30px;'></td><td>
    
   <span>กรณีที่ไม่ได้รับการเลื่อนเงินเดือน เนื่องจาก ( เหตุุผล )  :</span>
   <br/> <u>".$REMARK."</u>
</td></tr> ";
  
  $remain_html = "";
  if(($SAL_COM_ID+$SAL_COM_SPE)>0){
     if($SAL_COM_ID > 0){ // เงินเดือน
		$sql_SAL_COM_ID = "SELECT SAL_COM_ID FROM SAL_COMMAND  WHERE  SAL_COM_ID = '".$SAL_COM_ID."' AND CONFIRM_TYPE = 2  ";
		$query_SAL_COM_ID = $db->query($sql_SAL_COM_ID);
		$nums_ID = (int)$db->db_num_rows($query_SAL_COM_ID);  
		
		if($nums_ID > 0){ // ถ้ามีอนุมัติแล้ว 
			$sql_SAL_COM_ID = "SELECT a.SAL_COM_ID , a.COM_NO , a.COM_DATE ,b.CT_NAME_TH FROM SAL_COMMAND a LEFT JOIN SETUP_COMMAND_TYPE b ON a.CT_ID = b.CT_ID  WHERE  a.SAL_COM_ID = '".$SAL_COM_ID."'   ";
			$query_SalComID = $db->query($sql_SAL_COM_ID);
			$rec_salID = $db->db_fetch_array($query_SalComID);
			$remain_html .= "<p><br/> คำสั่ง ".text($rec_salID['CT_NAME_TH'])." ที่ ".text($rec_salID['COM_NO'])." ลงวันที่  ".conv_date($rec_salID["COM_DATE"],'short')."</p>";
		}
	 }
     if($SAL_COM_SPE > 0){ // เงินค่าตอบแทน
		$sql_SAL_COM_ID = "SELECT SAL_COM_ID FROM SAL_COMMAND  WHERE  SAL_COM_ID = '".$SAL_COM_SPE."' AND CONFIRM_TYPE = 2  ";
		$query_SAL_COM_ID = $db->query($sql_SAL_COM_ID);
		$nums_SPE = (int)$db->db_num_rows($query_SAL_COM_ID);  
		
		if($nums_SPE > 0){ // ถ้ามีอนุมัติแล้ว 
			$sql_SAL_COM_SPE = "SELECT a.SAL_COM_ID , a.COM_NO , a.COM_DATE ,b.CT_NAME_TH FROM SAL_COMMAND a LEFT JOIN SETUP_COMMAND_TYPE b ON a.CT_ID = b.CT_ID  WHERE  a.SAL_COM_ID = '".$SAL_COM_SPE."'   ";
			$query_SPE = $db->query($sql_SAL_COM_SPE);
			$rec_SPE = $db->db_fetch_array($query_SPE);
			$remain_html .= "<p><br/> คำสั่ง ".text($rec_SPE['CT_NAME_TH'])." ที่ ".text($rec_SPE['COM_NO'])." ลงวันที่  ".conv_date($rec_SPE["COM_DATE"],'short')."</p>";
		}
	 }
  }

 $html_report .= " 
 
  <tr   ><td style='width:5%'></td><td>
   <strong>หมายเหตุ :</strong><br/>".$remain_html."
   
</td></tr></table>  </div>";

 //echo $html_report; exit();
 
 	$html_report =  str_replace("CENTER_TOP",$CENTER_TOP,$html_report);
	$html_report =  str_replace("LEFT_TOP",$LEFT_TOP,$html_report);		
	$html_report =  str_replace("RIGHT_TOP",$RIGHT_TOP,$html_report);	
	
	 
	$content = $html_report;
	$fp = fopen($file_name,"wb");
	fwrite($fp,$content);
	fclose($fp);
	?>