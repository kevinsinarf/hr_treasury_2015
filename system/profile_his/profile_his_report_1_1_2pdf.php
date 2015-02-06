<?php
$path = "../../";
define('FPDF_FONTPATH','font/');
include($path."include/config_header_top.php");
include($path."include\MPDF53/mpdf.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$pdf = new mPDF('th', 'A4', '0', 'THSaraban');
$pdf ->AddPage('','','','','',7,7,7,7,'4','4');

$mode = (int)$_GET['mode'];
//echo $mode;exit();
if($mode==0){
//POST
$PER_ID = $_POST['PER_ID'];
}else{
   $PER_ID = (int)$_SESSION["sys_id"]; //echo $PER_ID; exit();
}
 


//ข้อมูลส่วนตัว
  $sql_per = " SELECT A.PT_ID,A.PER_SALARY_POSITION,A.PER_SALARY,A.POS_NO,A.LINE_ID,A.PER_ID, A.PREFIX_ID, A.PER_FIRSTNAME_TH, A.PER_MIDNAME_TH, A.PER_LASTNAME_TH, A.PER_DATE_BIRTH, A.PER_DATE_ENTRANCE, A.POSTYPE_ID,
  A.PER_DATE_OCCUPLY, A.PER_DATE_RETIRE, B.ORG_NAME_TH AS ORG_NAME_1, C.ORG_NAME_TH AS ORG_NAME_2  , D.CV_NAME_TH ,A.PER_FILE_PIC ,E.TYPE_NAME_TH, A.PER_SALARY_POSITION, A.PER_IDCARD,A.ORG_ID_3, A.GPF_STATUS,A.PER_GPF_SDATE
  FROM PER_PROFILE A
  LEFT JOIN SETUP_ORG B ON A.ORG_ID_1 =  B.ORG_ID
  LEFT JOIN SETUP_ORG C ON A.ORG_ID_2 = C.ORG_ID
  LEFT JOIN ANNOUNCE_SETUP_CIVIL_TYPE D ON A.CV_ID = D.CV_ID
  LEFT JOIN SETUP_POS_TYPE E ON A.TYPE_ID = E.TYPE_ID
  WHERE A.PER_ID= '".$PER_ID."'   AND A.DELETE_FLAG = 0   ";
  
  $query_per = $db->query($sql_per);
  $num_per = $db->db_num_rows($query_per);
  $rec_per = $db->db_fetch_array($query_per);
  $PER_ID = $rec_per['PER_ID'];
  $PER_NAME = Showname($rec_per["PREFIX_ID"],$rec_per["PER_FIRSTNAME_TH"],$rec_per["PER_MIDNAME_TH"],$rec_per["PER_LASTNAME_TH"]);
  $POS_NO = (int)$rec_per["POS_NO"];
  $LINE_ID = (int)$rec_per["LINE_ID"];
  $PER_SALARY = number_format($rec_per['PER_SALARY'],2)." บาท";
  $PER_SALARY_POSITION = number_format($rec_per['PER_SALARY_POSITION'],2)." บาท";
  $postype_id = (int)$rec_per['POSTYPE_ID'];
  if( $postype_id > 0){
  
  }
  
  $per_pt_id = (int)$rec_per['PT_ID'];
  if($per_pt_id==1){
    $label_money = "เงินเดือน";
	$label_money_title = "ประวัติการเลื่อนขั้นเงินเดือน";
	$label_position = "ตำแหน่ง";
  
  }
  if($per_pt_id==2){
    $label_money = "ค่าตอบแทน";
	$label_money_title = "ประวัติการเลื่อนค่าตอบแทน";
	$label_position = "ตำแหน่ง กลุ่มงาน";
  }
  if($per_pt_id==3){
    $label_money = "ค่าจ้าง";
	$label_money_title = "ประวัติการเลื่อนขั้นค่าจ้าง";
	$label_position = "ตำแหน่งในสายงาน ระดับตำแหน่ง";
  }
/*
  	$GPF_STATUS = 'ไม่ได้ระบุสถานะ';
	if($rec_per['PER_SALARY_POSITION'] > 0){
	   if($rec_per['PER_SALARY_POSITION'] ==1){ $GPF_STATUS = "เป็นสมาชิก";  }
	   if($rec_per['PER_SALARY_POSITION'] ==1){ $GPF_STATUS = "ไม่เป็นสมาชิก";  }
	}
*/
    $GPF_STATUS = $rec_per['GPF_STATUS'];
    if($GPF_STATUS == 1){
			$GPF_STATUS = "เป็นสมาชิก"; 
	}else if($GPF_STATUS == 2){
	        $GPF_STATUS = "ไม่เป็นสมาชิก";
	}else{
	        $GPF_STATUS = "ไม่ได้ระบุสถานะ";
	}
	$PER_GPF_SDATE =  conv_date($rec_per['PER_GPF_SDATE'],'short');  
  
  $sql_position = " select Line_name_th from setup_pos_line where line_id = '".$LINE_ID."' ";
  $query_position = $db->query($sql_position);
  $rec_postion = $db->db_fetch_array($query_position);
  $line_name_th = text(wordwrap($rec_postion['Line_name_th']));
  
  $org_id_3 = (int)$rec_per['ORG_ID_3'];
  $sql_position = " select ORG_NAME_TH from SETUP_ORG where org_id = '".$org_id_3."' ";
  $query_position = $db->query($sql_position);
  $rec_postion = $db->db_fetch_array($query_position);
  $org_name_th = text(wordwrap($rec_postion['ORG_NAME_TH']));
  
 
  
  //คู่สมรส
  $sql_mate ="SELECT TOP 1 FAMILY_PREFIX_ID, FAMILY_FIRSTNAME_TH, FAMILY_MIDNAME_TH, FAMILY_LASTNAME_TH
  FROM PER_FAMILY  WHERE FAMILY_RELATIONSHIP = '3'   AND DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."'  
  ORDER BY MARRY_SEQ DESC ";
  $query_mate = $db->query($sql_mate);
  $rec_mate = $db->db_fetch_array($query_mate);
  $MATE_NAME = Showname($rec_mate["FAMILY_PREFIX_ID"],$rec_mate["FAMILY_FIRSTNAME_TH"],$rec_mate["FAMILY_MIDNAME_TH"],$rec_mate["FAMILY_LASTNAME_TH"]);
  
  //บิดา
  $sql_father ="SELECT TOP 1 FAMILY_PREFIX_ID, FAMILY_FIRSTNAME_TH, FAMILY_MIDNAME_TH, FAMILY_LASTNAME_TH
  FROM PER_FAMILY 
  WHERE FAMILY_RELATIONSHIP = '1' AND DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."'  ";
  
  $query_father = $db->query($sql_father);
  $rec_father = $db->db_fetch_array($query_father);
  $FATHER_NAME = Showname($rec_father["FAMILY_PREFIX_ID"],$rec_father["FAMILY_FIRSTNAME_TH"],$rec_father["FAMILY_MIDNAME_TH"],$rec_father["FAMILY_LASTNAME_TH"]);
  
  //มารดา
  $sql_mother ="SELECT TOP 1 FAMILY_PREFIX_ID, FAMILY_FIRSTNAME_TH, FAMILY_MIDNAME_TH, FAMILY_LASTNAME_TH
  FROM PER_FAMILY 
  WHERE FAMILY_RELATIONSHIP = '2'  AND DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."'  ";
  
  $query_mother = $db->query($sql_mother);
  $rec_mother = $db->db_fetch_array($query_mother);
  $MOTHER_NAME = Showname($rec_mother["FAMILY_PREFIX_ID"],$rec_mother["FAMILY_FIRSTNAME_TH"],$rec_mother["FAMILY_MIDNAME_TH"],$rec_mother["FAMILY_LASTNAME_TH"]);
  $gov_type = text($rec_per['CV_NAME_TH']);//= "ข้าราชการรัฐสภาสามัญ";
  
  
	 $sql_edu = " select a.ed_id,a.ins_id,b.ED_NAME_TH,c.INS_NAME_TH,d.EM_NAME_TH from PER_EDUCATEHIS a 
left JOIN SETUP_EDU_DEGREE b ON a.ed_id = b.ED_ID
left join SETUP_EDU_INSTITUTE c ON a.ins_id = c.ins_id 
left join SETUP_EDU_MAJOR d ON a.EM_id = d.EM_id 
where a.EDU_TYPE = 2  and a.DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."'
order by a.EDU_EDATE DESC  ";
	$query_edu = $db->query($sql_edu);
	$rec_edu = $db->db_fetch_array($query_edu);
	$edu1_degree = text(wordwrap($rec_edu['ED_NAME_TH']))." ";
	if($rec_edu['EM_NAME_TH']!=""){ 
		$edu1_degree .= " ( ".text(wordwrap($rec_edu['EM_NAME_TH']))." ) ";
	}
	$edu1_ins = text(wordwrap($rec_edu['INS_NAME_TH']));	


	
	 $sql_edu = " select a.ed_id,a.ins_id,b.ED_NAME_TH,c.INS_NAME_TH,d.EM_NAME_TH from PER_EDUCATEHIS a 
left JOIN SETUP_EDU_DEGREE b ON a.ed_id = b.ED_ID
left join SETUP_EDU_INSTITUTE c ON a.ins_id = c.ins_id 
left join SETUP_EDU_MAJOR d ON a.EM_id = d.EM_id 
where a.EDU_TYPE = 1 and a.DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."'
order by a.EDU_EDATE DESC  ";
	$query_edu = $db->query($sql_edu);
	$rec_edu = $db->db_fetch_array($query_edu);
	$edu2_degree = text(wordwrap($rec_edu['ED_NAME_TH']))." ";
	if($rec_edu['EM_NAME_TH']!=""){ 
		$edu2_degree .= "( ".text(wordwrap($rec_edu['EM_NAME_TH']))." ) ";
	}
	$edu2_ins = text(wordwrap($rec_edu['INS_NAME_TH']));	
	
$arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "  DELETE_FLAG='0'", "PROV_TH_NAME"); //จังหวัด	
$arr_tamb=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "  DELETE_FLAG='0'", "TAMB_NAME_TH"); //ตำบล
$arr_ampr=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "  DELETE_FLAG='0'", "AMPR_NAME_TH"); //อำเภอ
  
  
  $html = "";
$html .= "<style type='text/css'>
				.font_1 {
					font-size:15pt;
				}
				body{
					font-size:9pt;
				}
				.nrmal_font{
					font-size:9pt;
				}
				table {
					border-collapse:collapse;
				 
				}
				td {
					padding-left:3px;
					padding-bottom:2px; 		
					padding-top:2px;
				}
				
				
			</style>";
 

$html .=  "
	<table width='100%' border='1' style='border: 1px solid black;margin:0px; padding:0px;  ' cellspacing='0' cellpadding='0' >
	  <tr>
		<td width='100%'>
			<table width='100%' border='0' >
			<tr>
				<td   class='font_2' align='left' style='width:7cm;'><strong>กระทรวง</strong> ".text($rec_per['ORG_NAME_1'])."</td>
				<td   class='font_2' align='left' style='width:9cm;'><strong>กรม</strong> ".text($rec_per['ORG_NAME_2'])."</td>	
				<td   class='font_2' align='right' style='margin-right:0px;padding-right:0px;right:0px;width:3cm;'><strong>ก.พ. 7</strong> </td>
			</tr>
			</table>
		</td>
	  </tr>
	</table>
    <br/>
  <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:20px;'>
	<tr >
	  <td    ><strong>".$arr_txt['idcard']."</strong> ".get_idCard($rec_per['PER_IDCARD'])." </td>
	  <td   ><strong>ประเภท".$arr_personal_type[$per_pt_id]."</strong> ".$gov_type."</td>
	  <td rowspan='11' valign='top' align='right' >";
	  
	  
 
	$html .= showPic_per($rec_per['PER_FILE_PIC']);
 
	   
	$html .= "</td>
			</tr>
		  
			<tr >
			  <td   ><strong>ชื่อ-สกุล</strong> ".$PER_NAME."</td>
			  <td   ><strong>ชื่อ-สกุลคู่สมรส</strong> ".$MATE_NAME."</td>
			</tr>
			
			<tr >
			  <td   ><strong>ชื่อ-สกุลบิดา</strong> ".$FATHER_NAME."</td>
			  <td   ><strong>ชื่อ-สกุลมารดา</strong> ".$MOTHER_NAME."</td>
			</tr>
			<tr>
			  <td   ><strong>วัน เดือน ปี เกิด</strong> ".conv_date($rec_per['PER_DATE_BIRTH'],'short')."</td>
			  <td   ><strong>วันสั่งบรรจุ</strong> ".conv_date($rec_per['PER_DATE_ENTRANCE'],'short')."</td>
			</tr>
			<tr>
			  <td    ><strong>วันที่เริ่มปฏิบัติราชการ</strong> ".conv_date($rec_per['PER_DATE_ENTRANCE'],'short')."</td>
			  <td   >";
			   if($per_pt_id!=2){
			 $html .= " <strong>วันครบเกษียณอายุ</strong> ".conv_date($rec_per['PER_DATE_RETIRE'],'short');
			 }
			 $html .= "</td>
			</tr>
			
			 <tr>
			  <td   > </td>
			  <td></td>
			</tr>
				
			<tr >
			  <td  ><strong>กอง / สำนัก</strong> ".$org_name_th."</td>
			  <td   ></td>  
			</tr>

			<tr >
			  <td   ><strong>".$arr_txt['pos_no']."</strong> ".$POS_NO."</td>
			  <td   ><strong>ตำแหน่ง</strong> ".$line_name_th."</td>
			</tr>
			
			<tr >
			  <td   ><strong>".$label_money."</strong> ".$PER_SALARY."</td>
			  <td   >";
		 if($per_pt_id==1){
			 $html .= "<strong>เงินประจำตำแหน่ง</strong> ".$PER_SALARY_POSITION;
	     }
			 $html .= "</td>
			</tr>
			
			<tr >
			  <td   ><strong>วุฒิการศึกษาสูงสุด</strong> ".$edu1_degree."</td>
			  <td   ><strong>สถานศึกษา</strong> ".$edu1_ins."</td>
			</tr>
			
			<tr >
			  <td   ><strong>วุฒิการศึกษาในตำแหน่ง</strong> ".$edu2_degree."</td>
			  <td   ><strong>สถานศึกษา</strong> ".$edu2_ins."</td>
			</tr> ";
		 if($per_pt_id!=2){
			$html .= " <tr>
			  <td    ><strong>สถานะของการเป็นสมาชิก กบข.</strong> ".$GPF_STATUS."</td>
			  <td   ><strong>วันที่เป็นสมาชิก</strong> ".$PER_GPF_SDATE."</td>
			</tr>";
		 }
			
			$html .= "
			 <tr>
			  <td > </td>
			  <td></td>
			</tr>
		 		
		  </table>";
		  

	$sql_train = " 
		SELECT B.INS_NAME_TH, A.EDU_SDATE, A.EDU_EDATE, C.ED_NAME_TH, D.EM_NAME_TH  
		FROM PER_EDUCATEHIS  A 
		LEFT JOIN SETUP_EDU_INSTITUTE B ON A.INS_ID = B.INS_ID
		LEFT JOIN SETUP_EDU_DEGREE C ON A.ED_ID = C.ED_ID
		LEFT JOIN SETUP_EDU_MAJOR D ON A.EM_ID = D.EM_ID
		WHERE A.PER_ID = '".$PER_ID."' AND A.DELETE_FLAG = 0   ORDER BY A.EDU_SEQ ASC ";
	$query_train = $db->query($sql_train);
	$num_train = $db->db_num_rows($query_train);
	

$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' >
			<thead>
				<tr>
					<th colspan='3' align='center' style='height:0.6cm;font-size:10pt;' >ประวัติการศึกษา</th>
				</tr>
				<tr class='bgHead'>
					<th style='height:1cm; border:solid 1px #000000; width:7cm; ' ><div align='center'><strong>สถานศึกษา</strong></div></th>
					<th style='height:1cm; border:solid 1px #000000; width:4.7cm; ' ><div align='center'><strong>ตั้งแต่ - ถึง (วัน เดือน ปี)</strong></div></th>
					<th style='height:1cm; border:solid 1px #000000; ' ><div align='center'><strong>วุุฒิ ( สาขาวิชาเอก )</strong></div></th>
				</tr>
			</thead>
			<tbody>";

  if($num_train > 0){
      while($rec_train = $db->db_fetch_array($query_train)){
          $majar = "";
          if(trim($rec_train['EM_NAME_TH']) != ''){
               $majar = "(".$rec_train['EM_NAME_TH'] .")";
          }
		  $edu_majar = $rec_train['ED_NAME_TH']." ".$majar;
          $edu_start_date = ($rec_train['EDU_SDATE'] == "") ? "" : conv_date($rec_train['EDU_SDATE'],'short');
		  $edu_end_date = conv_date($rec_train['EDU_EDATE'],'short');
		 
		  $edu_date =  $edu_start_date." ถึง ".conv_date($rec_train['EDU_EDATE'],'short');
$html .= "<tr >
			  <td align='left' valign='top'  style=' border:solid 1px #000000; ' >".text(wordwrap($rec_train['INS_NAME_TH'],45, ' ',true))."</td>
			  <td align='left' valign='top' style=' border:solid 1px #000000;' >".$edu_date."</td>
			  <td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($edu_majar,47,' ', true))."</td>
			</tr>";

      }
  }else{
      $html .=   pdf_show_no_found($arr_txt['data_not_found'],3);  
  }

$html .= "</tbody>
            </table>";





// ประกอบวิชาชีพ

				$sql_professional = " select a.PER_ID,b.CERTIFICATE_BY as 'CERTIFICATE_BY',b.CERTIFICATE_NAME_TH as 'CERTIFICATE_NAME_TH' ,b.CERTIFICATE_NAME_EN as 'CERTIFICATE_NAME_EN' ,a.CERTHIS_ID as 'CERTHIS_ID' ,a.CERTHIS_DATE as 'CERTHIS_DATE' , a.CERTHIS_NO as 'CERTHIS_NO' from PER_CERTIFICATEHIS a left join SETUP_CERTIFICATE b on a.CERTIFICATE_ID = b.CERTIFICATE_ID where a.PER_ID =  '".$PER_ID."' ";
				$query_professional = $db->query($sql_professional);
				$num_professional = $db->db_num_rows($query_professional);



$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;' >
			<thead>
			   <tr >
					<th colspan='4' align='center' style='height:0.6cm; '   >ใบอนุญาตประกอบวิชาชีพ</th>
				</tr>
				<tr >
					<th style='height:1cm; border:solid 1px #000000; width:6cm;' ><div align='center'><strong>ชื่อใบอนุญาต</strong></div></th>
					<th style='height:1cm; border:solid 1px #000000; width:4cm;' ><div align='center'><strong>หน่วยงาน</strong></div></th>
					<th style='height:1cm; border:solid 1px #000000;width:2.5cm;' ><div align='center'><strong>เลขที่ใบอนุญาต</strong></div></th>
					<th style='height:1cm; border:solid 1px #000000;width:2cm;' ><div align='center'><strong>วันที่มีผลบังคับใช้ <br/>( วัน เดือน ปี )</strong></div></th>				</tr>
			</thead>
			<tbody>";
 
  if($num_professional > 0){
      while($rec_professional = $db->db_fetch_array($query_professional)){
       

$html .= "<tr bgcolor='#FFFFFF'>
			<td align='left' valign='top' style='border:solid 1px #000000;'>".text($rec_professional['CERTIFICATE_NAME_TH'])."</td>
			<td align='center' valign='top' style='border:solid 1px #000000;'>".text($rec_professional['CERTIFICATE_BY'])."</td> 
			<td align='center' valign='top' style='border:solid 1px #000000;'>".text($rec_professional['CERTHIS_NO'])."</td> 
			<td align='center' valign='top' style='border:solid 1px #000000;'>".conv_date($rec_professional['CERTHIS_DATE'],"short")."</td> 					   
		  </tr>";
   
      }
  }else{
      $html .=   pdf_show_no_found($arr_txt['data_not_found'],4);  
  }

$html .= "</tbody>
            </table>";

			//ประวัติการดำรงตำแหน่ง
 
				$sql_pos=" SELECT a.per_id ,a.POS_NO,b.LINE_NAME_TH,a.COM_SDATE , DATEADD(day,-1,a.COM_SDATE) AS end_date
				,d.ORG_NAME_TH ,d2.ORG_NAME_TH as dipartment2_name,e.OT_NAME_TH ,f.CT_NAME_TH,a.COM_NO,a.COM_DATE,g.LEVEL_NAME_TH,
				a.MOVEMENT_ID,h.MOVEMENT_NAME_TH
				from PER_POSITIONHIS  a
				LEFT JOIN SETUP_POS_LINE b ON a.LINE_ID = b.LINE_ID 
				LEFT JOIN SETUP_ORG d ON a.ORG_ID_3 = d.org_id
				LEFT JOIN SETUP_ORG d2 ON a.ORG_ID_2 = d2.org_id
				LEFT JOIN SETUP_ORG_TYPE e ON d.OT_ID = e.OT_ID
				LEFT JOIN SETUP_COMMAND_TYPE f ON a.CT_ID = f.CT_ID
				LEFT JOIN SETUP_POS_LEVEL g ON a.LEVEL_id = g.LEVEL_id
				LEFT JOIN SETUP_MOVEMENT h ON a.MOVEMENT_ID = h.MOVEMENT_ID
				where a.per_id = ".$PER_ID."
				ORDER BY COM_SDATE DESC , a.COM_DATE DESC";  
				$query_pos=$db->query($sql_pos);
				$poshis_nums=$db->db_num_rows($query_pos);
			 
				$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' >
							<thead>
								<tr>
									<th colspan='5' align='center' style='height:0.6cm;font-size:10pt;' >".$arr_txt['profile_history']."</th>
								</tr>
								<tr class='bgHead'>
									<th style='height:1cm; border:solid 1px #000000; width:3cm; ' ><div align='center'><strong>เริ่ม (วัน เดือน ปี)</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000;  width:3cm;' ><div align='center'><strong>ถึง (วัน เดือน ปี)</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000; width:2.5cm;' ><div align='center'><strong>".$arr_txt['pos_no']."</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000; width:5cm;' ><div align='center'><strong>".$label_position."</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000;width:4.5cm;  ' ><div align='center'><strong>คำสั่ง ลงวันที่ </strong></div></th>
								</tr>
							</thead>
							<tbody>";
 
  if($poshis_nums > 0){  $i=1;
      while($rec_pos = $db->db_fetch_array($query_pos)){
	         $end_date= conv_date($rec_pos['end_date'],'short');
	         $end_date_temp = conv_date($rec_pos['end_date'],'short');
			 if($i==1){  
			 	$end_date = "";  
			 }else{
			    $end_date = $end_date_temp2;
			 }//if
	  
	   $html .= " 						 
					<tr >
						 <td align='center' valign='top' style=' border:solid 1px #000000;' >".conv_date($rec_pos['COM_SDATE'],'short')."</td>
						 <td align='center' valign='top' style=' border:solid 1px #000000;' >".$end_date."</td>
						 <td align='center' valign='top' style=' border:solid 1px #000000; ' >".text(wordwrap($rec_pos['POS_NO'],45, ' ',true))."</td> 
						 <td align='left' valign='top' style=' border:solid 1px #000000; ' >
						 <p > <strong>ตำแหน่ง :</strong></p> 
						 
						 <p >".text(wordwrap($rec_pos['LINE_NAME_TH'],45, ' ',true))." ".text(wordwrap($rec_pos['LEVEL_NAME_TH'],45, ' ',true))."</p>
						 <p ><strong>สังกัด : </strong>
						 <br/>
						 ".text(wordwrap($rec_pos['dipartment2_name'],45, ' ',true))."
						 <br> ".text(wordwrap($rec_pos['ORG_NAME_TH'],45, ' ',true));
						 if($rec_pos['OT_NAME_TH']!=""){ 
						 $html .= " (".text(wordwrap($rec_pos['OT_NAME_TH'],45, ' ',true)).") ";
						 }
						 $html .= " </p>
					 				 
						 </td>
						
						 
						 <td align='left' valign='top' style=' border:solid 1px #000000; ' >
						 <p>(".text(wordwrap($rec_pos['MOVEMENT_NAME_TH'],45,' ',true))."</p>
						 <p>".text(wordwrap($rec_pos['CT_NAME_TH'],45, ' ',true))." </p>
						 <p>ที่ ".text($rec_pos['COM_NO'])." ลว. ".conv_date($rec_pos['COM_DATE'],'short')."  ) </td> 
					</tr> ";
		$i++;
		$end_date_temp2 = $end_date_temp;
	  
	  } //while 
	  
}else{
      $html .=   pdf_show_no_found($arr_txt['data_not_found'],5);  
}
				$html .= "</tbody>
							</table>";


			//ประวัติการเลื่อนขั้นเงินเดือน
			
		  $sql_salary_up =  " SELECT A.COM_NO, A.COM_DATE, A.COM_SDATE, A.SALARY, A.SALHIS_TYPE, A.SALHIS_UP, A.SALHIS_NOTE,  B.LEVEL_NAME, 
		  C.CT_NAME_TH, D.MOVEMENT_NAME_TH
		  FROM PER_SALARYHIS A 
		  LEFT JOIN SAL_LEVEL_SCORE B ON A.LV_SCORE_ID = B.LV_SCORE_ID 
		  LEFT JOIN SETUP_COMMAND_TYPE C  ON  A.CT_ID = C.CT_ID
		  LEFT JOIN SETUP_MOVEMENT D ON A.MOVEMENT_ID = D.MOVEMENT_ID
		  WHERE D.MOVE_PROCESS_ID = 8 AND A.PER_ID = '".$PER_ID."'
		 ORDER BY A.COM_SDATE DESC, SALHIS_ID DESC ";
		  $query_salary_up=$db->query($sql_salary_up);
		  $salary_up_nums = $db->db_num_rows($query_salary_up);
			
				$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' >
							<thead>
								<tr>
									<th colspan='5' align='center' style='height:0.6cm;font-size:10pt;' >".$label_money_title."</th>
								</tr>
								<tr class='bgHead'>
									<th style='height:1cm; border:solid 1px #000000;  width:2.5cm; ' ><div align='center'><strong>วัน เดือน ปี</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000;   ' ><div align='center'><strong> ขั้น</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000; width:2.5cm;  '  ><div align='center'><strong>อัตราเงินเดือน</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000; ' ><div align='center'><strong>คำสั่ง ลงวันที่</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000;width:3cm;  ' ><div align='center'><strong>หมายเหตุ</strong></div></th>
								</tr>
							</thead>
							<tbody>";
							
  if($salary_up_nums > 0){ 
      while($rec_salary_up = $db->db_fetch_array($query_salary_up)){
	   	$SALHIS_TYPE  = (int)$rec_salary_up['SALHIS_TYPE'];
	   	$SALHIS_UP  = (float)$rec_salary_up['SALHIS_UP'];
        $SALHIS_UP_is = "";
	    if($SALHIS_UP>0){
			if($SALHIS_TYPE > 0){
		 
				 if($SALHIS_TYPE == 1){ //ร้อยละ 
				    $SALHIS_UP_is = "ร้อยละ ".number_format($SALHIS_UP,3);  // %
				 }
				 if($SALHIS_TYPE == 2){ // ขั้น
				    $SALHIS_UP_is = "".number_format($SALHIS_UP,3)." ขั้น"; 
				 } 
				 if(trim($rec_salary_up['LEVEL_NAME']) != ''){
					$SALHIS_UP_is = $SALHIS_UP_is."<br> ( ".text(wordwrap($rec_salary_up['LEVEL_NAME'],45, ' ',true))." ) "; 
				 }
			}
	    }
	   
	   $html .= " <tr >
     				<td align='center' valign='top' style=' border:solid 1px #000000;' >".conv_date($rec_salary_up['COM_SDATE'],'short')."</td>
                    <td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_salary_up['MOVEMENT_NAME_TH'],45, ' ',true))." ".$SALHIS_UP_is." </td>";
	   $html .= " 	<td align='right' valign='top' style=' border:solid 1px #000000;' >".number_format($rec_salary_up['SALARY'],2)."</td> ";
	   $html .= " 	<td align='left' valign='top' style=' border:solid 1px #000000;' >(".text(wordwrap($rec_salary_up['CT_NAME_TH'],45, ' ',true));
	   if($rec_salary_up['COM_NO']!=""){
	   	$html .= " ที่<br/>".text($rec_salary_up['COM_NO']);
	   }
	   if($rec_salary_up['COM_DATE']!=""){
	   	$html .= " 	 ลว. ".conv_date($rec_salary_up['COM_DATE'],'short') ;
	   }
	  $html .= " 	 )</td> 
     			<td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_salary_up['SALHIS_NOTE'],45, ' ',true))." </td>		 
		</tr> "; 
	  
	  } //while 
	  
  }else{
      $html .=   pdf_show_no_found($arr_txt['data_not_found'],5);  
  }	
   $html .= "</tbody>
	</table>";






 //ประวัติการได้รับเงินรางวัลประจำปี 
			
				$sql_salary_up=" select  * from PER_BONUSHIS  A  
where A.DELETE_FLAG = 0 and per_id = ".$PER_ID."
ORDER BY a.COM_SDATE DESC
 ";
				$query_salary_up=$db->query($sql_salary_up);
				$salary_up_nums=$db->db_num_rows($query_salary_up);
			
				$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' >
							<thead>
								<tr>
									<th colspan='5' align='center' style='height:0.6cm;font-size:10pt;' >ประวัติการได้รับเงินรางวัลประจำปี</th>
								</tr>
								<tr class='bgHead'>
									<th style='height:1cm; border:solid 1px #000000;  width:2.5cm; ' ><div align='center'><strong>วัน เดือน ปี</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000;   ' ><div align='center'><strong> ขั้น</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000; width:2.5cm;  '  ><div align='center'><strong>อัตรา".$label_money."</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000; ' ><div align='center'><strong>คำสั่ง ลงวันที่</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000;width:3cm;  ' ><div align='center'><strong>หมายเหตุ</strong></div></th>
								</tr>
							</thead>
							<tbody>";
							
  if($salary_up_nums > 0){ 
      while($rec_salary_up = $db->db_fetch_array($query_salary_up)){
 
	   $html .= " <tr >
     				<td align='center' valign='top' style=' border:solid 1px #000000;' >".conv_date($rec_salary_up['COM_SDATE'],'short')."</td>
                    <td align='left' valign='top' style=' border:solid 1px #000000;' > ".text($arr_mov_type[$rec['MOVEMENT_ID']])."  </td>";
	   $html .= " 	<td align='right' valign='top' style=' border:solid 1px #000000;' >".number_format($rec_salary_up['SALARY'],2)."</td> ";
	   $html .= " 	<td align='left' valign='top' style=' border:solid 1px #000000;' >(".text(wordwrap($rec_salary_up['BOUNUSHIS_TITLE_NAME_TH'],45, ' ',true));
	   if($rec_salary_up['COM_NO']!=""){
	   	$html .= " ที่<br/>".text($rec_salary_up['COM_NO']);
	   }
	   if($rec_salary_up['COM_DATE']!=""){
	   	$html .= " 	 ลว. ".conv_date($rec_salary_up['COM_DATE'],'short') ;
	   }
	  $html .= " 	 )</td> 
     				<td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_salary_up['BOUNUSHIS_NOTE'],45, ' ',true))." </td>		
		</tr> "; 
	  
	  } //while 
	  
  }else{
      $html .=   pdf_show_no_found($arr_txt['data_not_found'],5);  
  }	
   $html .= "</tbody>
	</table>";





 			//เงินเพิ่มค่าครองชีพชั่วคราว
			
				$sql_salary_up="  select  a.COMPENSATION_4,a.SALHIS_TYPE,a.SALHIS_UP,a.COM_SDATE,a.SALARY,a.SALHIS_NOTE,a.COM_NO,b.CT_NAME_TH,a.COM_DATE ,c.MOVEMENT_NAME_TH
 from PER_SALARYHIS a 
LEFT JOIN SETUP_COMMAND_TYPE b ON  a.CT_ID = b.CT_ID
left join SETUP_MOVEMENT c ON a.MOVEMENT_ID = c.MOVEMENT_ID
where a.per_id = ".$PER_ID."  
AND COMPENSATION_4 > 0
ORDER BY a.COM_SDATE DESC
 ";
				$query_salary_up=$db->query($sql_salary_up);
				$salary_up_nums=$db->db_num_rows($query_salary_up);
			
				$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' >
							<thead>
								<tr>
									<th colspan='5' align='center' style='height:0.6cm;font-size:10pt;' >ประวัติเงินเพิ่มค่าครองชีพชั่วคราว</th>
								</tr>
								<tr class='bgHead'>
									<th style='height:1cm; border:solid 1px #000000;  width:2.5cm; ' ><div align='center'><strong>วัน เดือน ปี</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000;   ' ><div align='center'><strong> ขั้น</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000; width:2.5cm;  '  ><div align='center'><strong>อัตรา".$label_money."</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000; ' ><div align='center'><strong>คำสั่ง ลงวันที่</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000;width:3cm;  ' ><div align='center'><strong>หมายเหตุ</strong></div></th>
								</tr>
							</thead>
							<tbody>";
							
  if($salary_up_nums > 0){ 
      while($rec_salary_up = $db->db_fetch_array($query_salary_up)){
 
	   $html .= " <tr >
     				<td align='center' valign='top' style=' border:solid 1px #000000;' >".conv_date($rec_salary_up['COM_SDATE'],'short')."</td>
                    <td align='left' valign='top' style=' border:solid 1px #000000;' > ".text(wordwrap($rec_salary_up['MOVEMENT_NAME_TH'],45, ' ',true))."  </td>";
	   $html .= " 	<td align='right' valign='top' style=' border:solid 1px #000000;' >".number_format($rec_salary_up['COMPENSATION_4'],2)."</td> ";
	   $html .= " 	<td align='left' valign='top' style=' border:solid 1px #000000;' >(".text(wordwrap($rec_salary_up['CT_NAME_TH'],45, ' ',true));
	   if($rec_salary_up['COM_NO']!=""){
	   	$html .= " ที่<br/>".text($rec_salary_up['COM_NO']);
	   }
	   if($rec_salary_up['COM_DATE']!=""){
	   	$html .= " 	 ลว. ".conv_date($rec_salary_up['COM_DATE'],'short') ;
	   }
	  $html .= " 	 )</td> 
     				<td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_salary_up['SALHIS_NOTE'],45, ' ',true))." </td>		
		</tr> "; 
	  
	  } //while 
	  
  }else{
      $html .=   pdf_show_no_found($arr_txt['data_not_found'],5);  
  }	
   $html .= "</tbody>
	</table>";




// เงินเพิ่มพิเศษสำหรับการสู้รบ (พ.ส.ร.) 

				$sql_salary_up="  select  a.COMPENSATION_3,a.SALHIS_TYPE,a.SALHIS_UP,a.COM_SDATE,a.SALARY,a.SALHIS_NOTE,a.COM_NO,b.CT_NAME_TH,a.COM_DATE ,c.MOVEMENT_NAME_TH
 from PER_SALARYHIS a 
LEFT JOIN SETUP_COMMAND_TYPE b ON  a.CT_ID = b.CT_ID
left join SETUP_MOVEMENT c ON a.MOVEMENT_ID = c.MOVEMENT_ID
where a.per_id = ".$PER_ID."   
AND COMPENSATION_3 > 0
ORDER BY a.COM_SDATE DESC
 ";
				$query_salary_up=$db->query($sql_salary_up);
				$salary_up_nums=$db->db_num_rows($query_salary_up);
			
				$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' >
							<thead>
								<tr>
									<th colspan='5' align='center' style='height:0.6cm;font-size:10pt;' >ประวัติเงินเพิ่มพิเศษสำหรับการสู้รบ (พ.ส.ร.) </th>
								</tr>
								<tr class='bgHead'>
									<th style='height:1cm; border:solid 1px #000000;  width:2.5cm; ' ><div align='center'><strong>วัน เดือน ปี</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000;   ' ><div align='center'><strong> ขั้น</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000; width:2.5cm;  '  ><div align='center'><strong>อัตรา".$label_money."</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000; ' ><div align='center'><strong>คำสั่ง ลงวันที่</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000;width:3cm;  ' ><div align='center'><strong>หมายเหตุ</strong></div></th>
								</tr>
							</thead>
							<tbody>";
							
  if($salary_up_nums > 0){ 
      while($rec_salary_up = $db->db_fetch_array($query_salary_up)){
 
	   $html .= " <tr >
     				<td align='center' valign='top' style=' border:solid 1px #000000;' >".conv_date($rec_salary_up['COM_SDATE'],'short')."</td>
                    <td align='left' valign='top' style=' border:solid 1px #000000;' > ".text(wordwrap($rec_salary_up['MOVEMENT_NAME_TH'],45, ' ',true))."  </td>";
	   $html .= " 	<td align='right' valign='top' style=' border:solid 1px #000000;' >".number_format($rec_salary_up['COMPENSATION_3'],2)."</td> ";
	   $html .= " 	<td align='left' valign='top' style=' border:solid 1px #000000;' >(".text(wordwrap($rec_salary_up['CT_NAME_TH'],45, ' ',true));
	   if($rec_salary_up['COM_NO']!=""){
	   	$html .= " ที่<br/>".text($rec_salary_up['COM_NO']);
	   }
	   if($rec_salary_up['COM_DATE']!=""){
	   	$html .= " 	 ลว. ".conv_date($rec_salary_up['COM_DATE'],'short') ;
	   }
	  $html .= " 	 )</td> 
     				<td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_salary_up['SALHIS_NOTE'],45, ' ',true))." </td>		
		</tr> "; 
	  
	  } //while 
	  
  }else{
      $html .=   pdf_show_no_found($arr_txt['data_not_found'],5);  
  }	
   $html .= "</tbody>
	</table>";




//เงินเพิ่มสำหรับตำแหน่งที่มีเหตุพิเศษ

				$sql_salary_up="  select  a.COMPENSATION_5,a.SALHIS_TYPE,a.SALHIS_UP,a.COM_SDATE,a.SALARY,a.SALHIS_NOTE,a.COM_NO,b.CT_NAME_TH,a.COM_DATE ,c.MOVEMENT_NAME_TH
 from PER_SALARYHIS a 
LEFT JOIN SETUP_COMMAND_TYPE b ON  a.CT_ID = b.CT_ID
left join SETUP_MOVEMENT c ON a.MOVEMENT_ID = c.MOVEMENT_ID
where a.per_id = ".$PER_ID."  
AND COMPENSATION_5 > 0
ORDER BY a.COM_SDATE DESC
 ";
				$query_salary_up=$db->query($sql_salary_up);
				$salary_up_nums=$db->db_num_rows($query_salary_up);
			
				$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' >
							<thead>
								<tr>
									<th colspan='5' align='center' style='height:0.6cm;font-size:10pt;' >เงินเพิ่มสำหรับตำแหน่งที่มีเหตุพิเศษ </th>
								</tr>
								<tr class='bgHead'>
									<th style='height:1cm; border:solid 1px #000000;  width:2.5cm; ' ><div align='center'><strong>วัน เดือน ปี</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000;   ' ><div align='center'><strong> ขั้น</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000; width:2.5cm;  '  ><div align='center'><strong>อัตรา".$label_money."</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000; ' ><div align='center'><strong>คำสั่ง ลงวันที่</strong></div></th>
									<th style='height:1cm; border:solid 1px #000000;width:3cm;  ' ><div align='center'><strong>หมายเหตุ</strong></div></th>
								</tr>
							</thead>
							<tbody>";
							
  if($salary_up_nums > 0){ 
      while($rec_salary_up = $db->db_fetch_array($query_salary_up)){
 
	   $html .= " <tr >
     				<td align='center' valign='top' style=' border:solid 1px #000000;' >".conv_date($rec_salary_up['COM_SDATE'],'short')."</td>
                    <td align='left' valign='top' style=' border:solid 1px #000000;' > ".text(wordwrap($rec_salary_up['MOVEMENT_NAME_TH'],45, ' ',true))."  </td>";
	   $html .= " 	<td align='right' valign='top' style=' border:solid 1px #000000;' >".number_format($rec_salary_up['COMPENSATION_5'],2)."</td> ";
	   $html .= " 	<td align='left' valign='top' style=' border:solid 1px #000000;' >(".text(wordwrap($rec_salary_up['CT_NAME_TH'],45, ' ',true));
	   if($rec_salary_up['COM_NO']!=""){
	   	$html .= " ที่<br/>".text($rec_salary_up['COM_NO']);
	   }
	   if($rec_salary_up['COM_DATE']!=""){
	   	$html .= " 	 ลว. ".conv_date($rec_salary_up['COM_DATE'],'short') ;
	   }
	  $html .= " 	 )</td> 
     				<td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_salary_up['SALHIS_NOTE'],45, ' ',true))." </td>		
		</tr> "; 
	  
	  } //while 
	  
  }else{
      $html .=   pdf_show_no_found($arr_txt['data_not_found'],5);  
  }	
   $html .= "</tbody>
	</table>";





// ประวัติการฝึกอบรม

				$sql_dev = " SELECT TRAINHIS_COURSE_NAME,TRAINHIS_EDATE,TRAINHIS_ORG_NAME FROM PER_TRAINHIS WHERE PER_ID =  '".$PER_ID."' ";
				$query_dev = $db->query($sql_dev);
				$num_dev = $db->db_num_rows($query_dev);
		


$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;' >
			<thead>
			   <tr >
					<th colspan='3' align='center' style='height:0.6cm;' >ประวัติการฝึกอบรม</th>
				</tr>
				<tr >
					<th style='height:1cm; border:solid 1px #000000; width:6cm;' ><div align='center'><strong>หลักสูตรฝึกอบรม</strong></div></th>
					<th style='height:1cm; border:solid 1px #000000; width:3cm;' ><div align='center'><strong>ตั้งแต่ - ถึง <br/> ( วัน เดือน ปี ) </strong></div></th>
					<th style='height:1cm; border:solid 1px #000000; width:6cm;' ><div align='center'><strong>หน่วยงานที่จัดฝึกอบรม</strong></div></th>
		 
			</tr></thead>
			<tbody>";
 
  if($num_dev > 0){
      while($rec_dev = $db->db_fetch_array($query_dev)){
       

$html .= "<tr bgcolor='#FFFFFF'>
			<td align='left' valign='top' style='border:solid 1px #000000;'>".text($rec_dev['TRAINHIS_COURSE_NAME'])."</td>
			<td align='center' valign='top' style='border:solid 1px #000000;'>".conv_date($rec_dev['TRAINHIS_EDATE'],"short")."</td> 
			<td align='left' valign='top' style='border:solid 1px #000000;'>".text(trim($rec_dev['TRAINHIS_ORG_NAME']))."</td> 
		 					   
		  </tr>";
   
      }
  }else{
      $html .=   pdf_show_no_found($arr_txt['data_not_found'],3);  
  }

$html .= "</tbody>
      </table>";


	$sql_punis = " select * from PER_PUNISHMENT a
LEFT JOIN SETUP_CRIME_MAIN c on a.INFORM_CRIME_ID = c.CRIME_ID
LEFT JOIN SETUP_PUNNISH e on   a.FINAL_PUNISH_ID  = e.PUNISH_ID
  where a.DELETE_FLAG = 0 AND  a.PER_ID =  '".$PER_ID."' ";
	$query_punis = $db->query($sql_punis);
	$num_punis = $db->db_num_rows($query_punis);

$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;' >
			<thead>
			   <tr >
					<th colspan='3' align='center' style='height:0.6cm;' >การได้รับโทษทางวินัยและการนิรโทษกรรม</th>
				</tr>
				<tr >
					<th style='height:1cm; border:solid 1px #000000; width:2cm;' ><div align='center'><strong>พ.ศ.</strong></div></th>
					<th style='height:1cm; border:solid 1px #000000; width:12cm;' ><div align='center'><strong>รายการ</strong></div></th>
					<th style='height:1cm; border:solid 1px #000000;' ><div align='center'><strong>เอกสารอ้างอิง</strong></div></th>
				</tr>
			</thead>
			<tbody>";

  if($num_punis > 0){
      while($rec_punis = $db->db_fetch_array($query_punis)){
          //$detial = text($rec_punis['CRIME_NAME_TH'])." (".$arr_penalty_status[$rec_punis['PENALTY_STATUS']].")";

$html .= "<tr bgcolor='#FFFFFF'>
			<td align='center' valign='top' style='border:solid 1px #000000;'>".($rec_punis['FINAL_DATE']+543)."</td>
			<td align='left' valign='top' style='border:solid 1px #000000;' >".text($rec_punis['PUNISH_NAME_TH'])."</td>
			<td align='left' valign='top' style='border:solid 1px #000000;' >
			<div> <strong>เลขที่คำร้อง</strong> ".text($rec_punis['FINAL_NO'])." </div>
			<div> <strong>ลว.</strong> ".conv_date($rec_punis['FINAL_DATE'],'short')."</div>
		  </td>
		  </tr>";
  
      }
  }else{
      $html .=   pdf_show_no_found($arr_txt['data_not_found'],3);  
  }

$html .= "</tbody>
            </table>";

   $sql_position = "SELECT A.COM_DATE, A.COM_SDATE, A.COM_NO, B.MOVEMENT_TYPE, C.LINE_NAME_TH,  G.ORG_NAME_TH AS ORG_NAME_3, H.ORG_NAME_TH AS ORG_NAME_4,
   E.MANAGE_NAME_TH, A.POS_NO, B.MOVEMENT_NAME_TH, D.LEVEL_NAME_TH, A.SALARY
   FROM V_PROFILE_STORY A
   LEFT JOIN SETUP_MOVEMENT B ON A.MOVEMENT_ID = B.MOVEMENT_ID
   LEFT JOIN SETUP_POS_LINE C ON A.LINE_ID = C.LINE_ID
   LEFT JOIN SETUP_POS_LEVEL D ON A.LEVEL_ID = D.LEVEL_ID
   LEFT JOIN SETUP_POS_MANAGE E ON A.MANAGE_ID = E.MANAGE_ID
   LEFT JOIN SETUP_ORG G ON A.ORG_ID_3 = G.ORG_ID
   LEFT JOIN SETUP_ORG H ON A.ORG_ID_4 = H.ORG_ID
   WHERE PER_ID = '".$PER_ID."' ORDER BY COM_SDATE ASC ";
   $query_position = $db->query($sql_position);
   $num_position = $db->db_num_rows($query_position);


 $html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;' >
  <thead width='100%' border='0' cellspacing='0' cellpadding='0' >
  	<tr class='bgHead'>
          <th colspan='8' align='center'  style='height:0.6cm;' >ประวัติการได้รับเครื่องราชอิสริยาภรณ์</th>
      </tr>
      <tr >
          <th style='height:1cm; border:solid 1px #000000; width:3cm;' ><div align='center'><strong>วัน เดือน ปี</strong></div></th>
          <th style='height:1cm; border:solid 1px #000000; width:5cm;' ><div align='center'><strong>เครื่องราชอิสริยาภรณ์ที่ได้รับ</strong></div></th>
          <th style='height:1cm; border:solid 1px #000000; width:6cm;' ><div align='center'><strong>ตามประกาศราชกิจจา</strong></div></th>
          <th style='height:1cm; border:solid 1px #000000; width:2.5cm;' ><div align='center'><strong>วันเดือนปี ที่รับ</strong></div></th>
          <th style='height:1cm; border:solid 1px #000000; width:3cm;' ><div align='center'><strong>วันเดือนปี ที่ส่งคืน</strong></div></th>
      </tr>
  </thead>
  <tbody  >";

			$field=" a.DEH_ID, a.DEH_SEQ, a.DEH_GAZZETTE_DATE, a.DEH_RECEIVE_DATE, a.DEH_RETURN_DATE, b.DEF_NAME_TH, c.DEC_NAME_TH, a.ACTIVE_STATUS, a.DEH_GAZZETTE_BOOK, a.DEH_GAZZETTE_PART, a.DEH_GAZZETTE_PAGE, a.DEH_SEQ, a.DEH_RECEIVE_DATE, a.DEH_RETURN_DATE ";
			$table=" PER_DECORATEHIS  a
					 LEFT JOIN SETUP_DECORATION_FAMILY b ON a.DEF_ID=b.DEF_ID
					 LEFT JOIN SETUP_DECORATION c ON a.DEC_ID=c.DEC_ID ";
			$orderby=" order by c.DEC_LEVEL ASC ";
			
			$sql_decorate = "select ".$field." from ".$table." where a.PER_ID = '".$PER_ID."' AND a.DELETE_FLAG = '0' ".$orderby;
			$query_decorate = $db->query($sql_decorate);
			$num_decorate = $db->db_num_rows($query_decorate);

					if($num_decorate > 0){
						while($rec_decorate = $db->db_fetch_array($query_decorate)){
		                $book_detail = "เล่มที่  ".text($rec_decorate["DEH_GAZZETTE_BOOK"])." ตอนที่ ".text($rec_decorate["DEH_GAZZETTE_PART"])." หน้าที่ ".text($rec_decorate["DEH_GAZZETTE_PAGE"])." ลำดับที่ ".text($rec_decorate["DEH_SEQ"])."";
						
$html .= "<tr bgcolor='#FFFFFF'>
    <td align='center' valign='top' style='border:solid 1px #000000;' >".conv_date($rec_decorate["DEH_GAZZETTE_DATE"],'short')."</td>
    <td align='left' valign='top' style='border:solid 1px #000000;' >".text($rec_decorate["DEC_NAME_TH"])."</td>
    <td align='center' valign='top' style='border:solid 1px #000000;' >".$book_detail."</td>
    <td align='center' valign='top' style='border:solid 1px #000000;' >".conv_date($rec_decorate["DEH_RECEIVE_DATE"],'short')." </td>
    <td align='center' valign='top' style='border:solid 1px #000000;' >".conv_date($rec_decorate["DEH_RETURN_DATE"],'short')."</td>
  </tr>";
               }
				 }else{
      $html .=   pdf_show_no_found($arr_txt['data_not_found'],5);  
					}
 $html .= "</tbody></table>  ";
 
 
 
  $html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;' >
  <thead width='100%' border='0' cellspacing='0' cellpadding='0' >
  	<tr class='bgHead'>
          <th colspan='6' align='center'  style='height:0.6cm;'  >ประวัติการลา</th>
      </tr>
      <tr >
          <th style='height:1cm; border:solid 1px #000000; width:3.5cm;' ><div align='center'><strong>พ.ศ.</strong></div></th>
          <th style='height:1cm; border:solid 1px #000000; width:3.5cm;' ><div align='center'><strong>ลาป่วย</strong></div></th>
          <th style='height:1cm; border:solid 1px #000000; width:3.5cm;' ><div align='center'><strong>ลากิจแและพักผ่อน</strong></div></th>
          <th style='height:1cm; border:solid 1px #000000; width:3.5cm;' ><div align='center'><strong>มาสาย</strong></div></th>
          <th style='height:1cm; border:solid 1px #000000; width:3.5cm;' ><div align='center'><strong>ขาดราชการ</strong></div></th>
           <th style='height:1cm; border:solid 1px #000000; width:3.5cm;' ><div align='center'><strong>ลาศึกษาต่อ</strong></div></th>
      </tr>
  </thead>
  <tbody  >";
 
 			$field=" * ";
			$table=" PER_LEAVEHIS ";
			$pk_id="LEAVEHIS_ID";
			$wh=" PER_ID = '".$PER_ID."' {$filter} ";
			$orderby="order by LEVEHIS_ID DESC ";
			$notin = $wh;
			$sql_leave = "select top {$page_size} ".$field." from ".$table." where ".$notin;


			$query_leave = $db->query($sql_leave);
			$num_leave = $db->db_num_rows($query_leave);
 
		if($num_decorate > 0){
			while($rec_leave = $db->db_fetch_array($query_leave)){
			$private_relax = ($rec_leave["LEAVEHIS_PRIVATE_DAY"]+ $rec_leave["LEAVEHIS_RELAX_DAY"]);
$html .= "<tr bgcolor='#FFFFFF'>
    <td align='center' valign='top' style='border:solid 1px #000000;' >".text($rec_leave["LEAVEHIS_YEAR"])."</td>
    <td align='center' valign='top' style='border:solid 1px #000000;' >".number_format($rec_leave["LEAVEHIS_SICK_DAY"],2)."</td>
    <td align='center' valign='top' style='border:solid 1px #000000;' >".number_format($private_relax,2)."</td>
    <td align='center' valign='top' style='border:solid 1px #000000;' >".number_format($rec_leave["LEAVEHIS_LATE_DAY"],2)." </td>
    <td align='center' valign='top' style='border:solid 1px #000000;' >".number_format($rec_leave["LEAVEHIS_WITHOUT_DAY"],2)."</td>
    <td align='center' valign='top' style='border:solid 1px #000000;' >".number_format($rec_leave["LEAVEHIS_STUDY_DAY"],2)."</td>
  
  </tr>";

		      }
		}else{
      $html .=   pdf_show_no_found($arr_txt['data_not_found'],6);  
		}
					 
 $html .= "</tbody></table>  "; 
 
 
 			$field=" PADD_ID, PADD_TYPE, PADD_ROOM_NO, PADD_FLOOR, PADD_BUILDING, PADD_HOME_NO, PADD_MOO, PADD_VILLAGE, PADD_SOI, PADD_ROAD, 
					 PADD_TAMB_ID, PADD_AMPR_ID, PADD_PROV_ID, PADD_POSTCODE, PADD_TEL, PADD_TEL_EXT, PADD_FAX, PADD_FAX_EXT, PADD_MOBILE";	
			$table=" PER_ADDRESS";
			$orderby=" order by PADD_ID ASC";
			
			$sql = "select ".$field." from ".$table." where DELETE_FLAG = '0'  AND PER_ID = '".$PER_ID."'".$orderby; //echo $sql; exit();
			$query = $db->query($sql);
			$nums = $db->db_num_rows($query);
		  
			$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' >
							<thead>
								<tr>
									<th colspan='3' align='center' style='height:0.6cm;' >ประวัติข้อมูลส่วนบุคคล</th>
								</tr>
                                <tr class=bgHead>
                               
                                    <th style='height:1cm; border:solid 1px #000000;'><div align=center><strong>ประเภท</strong></div></th>
                                    <th style='height:1cm;width:60%; border:solid 1px #000000;'><div align=center><strong>ที่อยู่</strong></div></th>
                                    <th style='height:1cm; border:solid 1px #000000;'   ><div align=center><strong>หมายเลขติดต่อ</strong></div></th>
           
                                </tr>
							</thead>
							<tbody>";
		  
                          if($nums > 0){
                                $i=1;
                                while($rec = $db->db_fetch_array($query)){
                                    $PADD_ROOM_NO = (trim($rec['PADD_ROOM_NO']) != '') ? 'เลขที่ห้อง '.text($rec['PADD_ROOM_NO']) : '';
                                    $PADD_FLOOR = (trim($rec['PADD_FLOOR']) != '') ? ' ชั้น '.text($rec['PADD_FLOOR']) : '';
                                    $PADD_BUILDING = (trim($rec['PADD_BUILDING']) != '') ? ' อาคาร'.text($rec['PADD_BUILDING']) : '';
                                    $PADD_HOME_NO = (trim($rec['PADD_HOME_NO']) != '') ? '<br>บ้านเลขที่ '.text($rec['PADD_HOME_NO']) : '';
                                    $PADD_MOO = (trim($rec['PADD_MOO']) != '') ? ' หมู่ที่ '.text($rec['PADD_MOO']) : '';
                                    $PADD_VILLAGE = (trim($rec['PADD_VILLAGE']) != '') ? ' หมู่บ้าน'.text($rec['PADD_VILLAGE']) : '';
                                    $PADD_SOI = (trim($rec['PADD_SOI']) != '') ? ' ซอย '.text($rec['PADD_SOI']) : '';
                                    $PADD_ROAD = (trim($rec['PADD_ROAD']) != '') ? ' ถนน'.text($rec['PADD_ROAD']) : '';
									$PADD_TAMB_ID = (!empty($rec['PADD_TAMB_ID'])) ? '<br>ตำบล'.text($arr_tamb[$rec['PADD_TAMB_ID']]) : '';
									$PADD_AMPR_ID = (!empty($rec['PADD_AMPR_ID'])) ? ' อำเภอ'.text($arr_ampr[$rec['PADD_AMPR_ID']]) : '';
									$PADD_PROV_ID = (!empty($rec['PADD_PROV_ID'])) ? ' จังหวัด'.text($arr_prov[$rec['PADD_PROV_ID']]) : '';
									$PADD_POSTCODE = (trim($rec['PADD_POSTCODE']) != '') ? ' '.$rec['PADD_POSTCODE'] : '';
                                    
                                    $ADDRESS = $PADD_ROOM_NO.$PADD_FLOOR.$PADD_BUILDING.$PADD_HOME_NO.$PADD_MOO.$PADD_VILLAGE.$PADD_SOI.$PADD_ROAD.$PADD_TAMB_ID.$PADD_AMPR_ID.$PADD_PROV_ID.$PADD_POSTCODE;
                                    
                                    $PADD_TEL_EXT = (trim($rec['PADD_TEL_EXT']) != '') ? ' ต่อ '.text($rec['PADD_TEL_EXT']) : '';
                                    $PADD_FAX_EXT = (trim($rec['PADD_FAX_EXT']) != '') ? ' ต่อ '.text($rec['PADD_FAX_EXT']) : '';
									
	          $html .= '                                     <tr bgcolor="#FFFFFF">
                                  
                                        <td align="left" style="height:1cm; border:solid 1px #000000;">'.$arr_address[$rec['PADD_TYPE']].'</td>
                                        <td align="left"  style="height:1cm; border:solid 1px #000000;">'.$ADDRESS.'</td>
                                        <td align="left"  style="height:1cm; border:solid 1px #000000;">โทรศัพท์ '.text(wordwrap($rec['PADD_TEL'])).$PADD_TEL_EXT.'<br>โทรสาร '.$rec['PADD_FAX'].$PADD_FAX_EXT.'<br>โทรศัพท์เคลื่อนที่ '.$rec['PADD_MOBILE'].'</td>
                        
                                    </tr> ';							
		  
                                }
                            }else{
      $html .=   pdf_show_no_found($arr_txt['data_not_found'],3);   
                            }
							
				$html .= "</tbody>
							</table>";	
 
 
$footer = '<div  style="width:20cm; font-size:6pt; text-align:right;" >Print : '.$TIMESTAMP.'</div>';
$pdf->SetHTMLFooter($footer);
$pdf->WriteHTML($html);

$pdf->Output();
