<?php
//header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
$NoChk=1;
include($path."include/config_header_top.php");
include($path.'include/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set font
$pdf->SetFont('thsarabun', '', 16, '', true);

//set margins
$pdf->SetMargins(33, 10, 20);

// Add a page
$pdf->AddPage();
$sql_ss_number = "SELECT SAPA_NUMBER  FROM  SS_SETUP_SAPA WHERE  ACTIVE_STATUS='1'";
$query_ss_number = $db->query($sql_ss_number);
while($rec = $db->db_fetch_array($query_ss_number)){
	$ss_number = $rec['SAPA_NUMBER'];
}
$ss_num = "$ss_number";
$thainumber = array('๐','๑','๒','๓','๔','๕','๖','๗','๘','๙');
for($i=0;$i<strlen($ss_num);$i++){
	$ss_num_th .= $thainumber[$ss_num[$i]];
}

//DATA
 $sql1="select * from V_FORM_LIST where SSP_ID='".$SSP_ID."'";
$query1 = $db->query($sql1);
$num1 = $db->db_num_rows($query1);
if($num1>0){
	$table="V_FORM_LIST";
	$table2="SS_FORM_ADDRESS";
	//$f=",b.SSA_MOBILE,b.SSA_EMAIL";
}else{
	$table="V_SAPA_LIST";
	$table2="SS_ADDRESS";
	//$f=",b.SSA_MOBILE,b.SSA_EMAIL";
}

  $sql_ss_name = "SELECT TOP 1 g.SSP_PARENT_ID, e.SS_TYPE_ID,a.SSP_PARTY_LIST,SS_IDCARD,
a.PREFIX_ID,a.SSP_NUMBER,b.SSA_EMAIL,b.SSA_MOBILE,
a.SS_FIRSTNAME_TH,a.SS_MIDNAME_TH,a.SS_LASTNAME_TH,
a.SS_FIRSTNAME_EN,a.SS_MIDNAME_EN,a.SS_LASTNAME_EN,
a.SS_FIRSTNAME_SPELL,a.SS_MIDNAME_SPELL,a.SS_LASTNAME_SPELL,
a.PROV_ID,a.SSP_DISTRICT_ID,a.SSP_ID,a.SSP_ELECTION_DATE,a.PARTY_ID,a.SS_TYPE_ID,a.SS_ID,a.SAPA_NUMBER,
b.SSA_HOMENO,b.SSA_MOO,b.SSA_SOI, b.SSA_VILLAGE,b.SSA_ROAD,b.SSA_TAMB_ID,
b.SSA_AMPR_ID,b.SSA_PROV_ID,b.SSA_ZIPCODE,b.SSA_TEL,b.SSA_FAX,b.SSA_TYPE,
d.PROV_TH_NAME,e.SS_TYPE_NAME_TH,f.PARTY_NAME_TH
FROM ".$table." a
LEFT JOIN  ".$table2." b ON a.SS_ID = b.SS_ID AND (b.SSA_PUBLIC='1' OR b.SSA_TYPE='6')
LEFT JOIN  SETUP_PROV d ON a.PROV_ID = d.PROV_ID 
LEFT JOIN  SS_SETUP_TYPE_SS e ON a.SS_TYPE_ID = e.SS_TYPE_ID
INNER JOIN SS_SAPA_POSITION g ON g.SSP_ID=a.SSP_ID 
LEFT JOIN  SS_SETUP_PARTY f ON a.PARTY_ID = f.PARTY_ID ";
$sql_1=$sql_ss_name."WHERE a.SSP_ID = '".$SSP_ID."' ORDER BY SSA_TYPE ASC  ";
$query_1 = $db->query($sql_1);
$data =$db->db_fetch_array($query_1);
$arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME");
//อำเภอ/เขต
$arr_ampr=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
//ตำบล/แขวง
$arr_tamb=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", " ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");
//echo ShowPic_ss($data['SS_IDCARD']); exit();
if($data['SSP_PARENT_ID']!=''||$data['SSP_PARENT_ID']!=NULL){
	//DATA
	 $sql2="select * from V_FORM_LIST where SSP_ID='".$data['SSP_PARENT_ID']."'";
	$query2 = $db->query($sql2);
	$num2 = $db->db_num_rows($query2);
	if($num2>0){
		$table="V_FORM_LIST";
		$table2="SS_FORM_ADDRESS";
		//$f=",b.SSA_MOBILE,b.SSA_EMAIL";
	}else{
		$table="V_SAPA_LIST";
		$table2="SS_ADDRESS";
		//$f=",b.SSA_MOBILE,b.SSA_EMAIL";
	}
	 $sql_ss_name = "SELECT g.SSP_PARENT_ID, e.SS_TYPE_ID,a.SSP_PARTY_LIST,
	a.PREFIX_ID,a.SSP_NUMBER,
	a.SS_FIRSTNAME_TH,a.SS_MIDNAME_TH,a.SS_LASTNAME_TH,
	a.SS_FIRSTNAME_EN,a.SS_MIDNAME_EN,a.SS_LASTNAME_EN,
	a.SS_FIRSTNAME_SPELL,a.SS_MIDNAME_SPELL,a.SS_LASTNAME_SPELL,
	a.PROV_ID,a.SSP_DISTRICT_ID,a.SSP_ID,a.SSP_ELECTION_DATE,a.PARTY_ID,a.SS_TYPE_ID,a.SS_ID,a.SAPA_NUMBER,
	b.SSA_HOMENO,b.SSA_MOO,b.SSA_SOI, b.SSA_VILLAGE,b.SSA_ROAD,b.SSA_TAMB_ID,
	b.SSA_AMPR_ID,b.SSA_PROV_ID,b.SSA_ZIPCODE,b.SSA_TEL,b.SSA_FAX,b.SSA_TYPE,
	d.PROV_TH_NAME,e.SS_TYPE_NAME_TH,f.PARTY_NAME_TH
	FROM ".$table." a
	LEFT JOIN  ".$table2." b ON a.SS_ID = b.SS_ID AND (b.SSA_PUBLIC='1' OR b.SSA_TYPE='6')
	LEFT JOIN  SETUP_PROV d ON a.PROV_ID = d.PROV_ID 
	LEFT JOIN  SS_SETUP_TYPE_SS e ON a.SS_TYPE_ID = e.SS_TYPE_ID
	INNER JOIN SS_SAPA_POSITION g ON g.SSP_ID=a.SSP_ID 
	LEFT JOIN  SS_SETUP_PARTY f ON a.PARTY_ID = f.PARTY_ID ";
	$sql_2=$sql_ss_name."WHERE a.SSP_ID = '".$data['SSP_PARENT_ID']."' ORDER BY SSA_TYPE ASC ";
	$query_2 = $db->query($sql_2);
	$data2 =$db->db_fetch_array($query_2);
}
$pic="pdf_uncheck.jpg";
$pic2="pdf_check.jpg";

$name_en=Showname($data["PREFIX_ID"],$data["SS_FIRSTNAME_EN"],$data["SS_MIDNAME_EN"],$data["SS_LASTNAME_EN"],'en');

//เปลี่ยนรูปตามสถานะ
$type_pic1=$pic;
$type_pic2=$pic;
//แบบแบ่งเขต
$SSP_NUMBER='.....................';
$PARTY_NAME_TH='.....................................................';
$SSP_ELECTION_DATE='...................................';
//แบบบัญชีรายชื่อ

$PROV_TH_NAME_NVI='............................................';
$SSP_DISTRICT_ID_NVI='.....................................';
$PARTY_NAME_TH_NVI='..............................................';
$SSP_ELECTION_DATE_NVI='.............................................';
if($data['SSP_PARENT_ID']!=''||$data['SSP_PARENT_ID']!=NULL){
	$type_pic2=$pic2;
	$PROV_TH_NAME_NVI=text($data2['PROV_TH_NAME']);
	$SSP_DISTRICT_ID_NVI=text($data2['SSP_DISTRICT_ID']);
	$PARTY_NAME_TH_NVI=text($data2['PARTY_NAME_TH']);
	$SSP_ELECTION_DATE_NVI=Conv_date($data2["SSP_ELECTION_DATE"],'full');
        $SS_NO = "ข";
}else if ($data['SS_TYPE_ID']=='7' && $data['SSP_PARENT_ID']==''||$data['SSP_PARENT_ID']==NULL ){
        $type_pic1=$pic2;
	$SSP_NUMBER=$data['SSP_PARTY_LIST']!=''?text($data['SSP_PARTY_LIST']):'.....................................';
	$SSP_ELECTION_DATE=Conv_date($data['SSP_ELECTION_DATE'],'full');
	$PARTY_NAME_TH=text($data['PARTY_NAME_TH']);
        $SS_NO = "ก";
}else{	
	$type_pic1=$pic2;
	$SSP_NUMBER=$data['SSP_PARTY_LIST']!=''?text($data['SSP_PARTY_LIST']):'.....................................';
	$SSP_ELECTION_DATE=Conv_date($data['SSP_ELECTION_DATE'],'full');
	$PARTY_NAME_TH=text($data['PARTY_NAME_TH']);
	$SSP_DISTRICT_ID_NVI=text($data['SSP_DISTRICT_ID']);
	$PARTY_NAME_TH_NVI=text($data['PARTY_NAME_TH']);
	$SSP_ELECTION_DATE_NVI=Conv_date($data["SSP_ELECTION_DATE"],'full');
}
$SSA_HOMENO=trim($data['SSA_HOMENO'])!=''?'&nbsp;&nbsp;'.text($data['SSA_HOMENO']):'.............................';
$SSA_MOO=trim($data['SSA_MOO'])!=''?'&nbsp;&nbsp;'.text($data['SSA_MOO']):'.............................................';
$SSA_VILLAGE=trim($data['SSA_VILLAGE'])!=''?'&nbsp;&nbsp;'.text($data['SSA_VILLAGE']):'.........................................';

$SSA_SOI=trim($data['SSA_SOI'])!=''?'&nbsp;&nbsp;'.text($data['SSA_SOI']):'...................................';
$SSA_ROAD=trim($data['SSA_ROAD'])!=''?'&nbsp;&nbsp;'.text($data['SSA_ROAD']):'..................................';
$SSA_TAMB_ID=trim($data['SSA_TAMB_ID'])!=''?'&nbsp;&nbsp;'.text($arr_tamb[$data['SSA_TAMB_ID']]):'...................................................................';

$SSA_AMPR_ID=trim($data['SSA_AMPR_ID'])!=''&&$data['SSA_AMPR_ID']!=NULL?'&nbsp;&nbsp;'.text($arr_ampr[$data['SSA_AMPR_ID']]):'......................................';
$SSA_PROV_ID=trim($data['SSA_PROV_ID'])!=''&&$data['SSA_PROV_ID']!=NULL?'&nbsp;&nbsp;'.text($arr_prov[$data['SSA_PROV_ID']]):'...............................................';
$SSA_ZIPCODE=trim($data['SSA_ZIPCODE'])!=''?'&nbsp;&nbsp;'.text($data['SSA_ZIPCODE']):'....................................';

$SSA_TEL=trim($data['SSA_TEL'])!=''?'&nbsp;&nbsp;'.text($data['SSA_TEL']):'..........................................................................';
$SSA_FAX=trim($data['SSA_FAX'])!=''&&$data['SSA_FAX']!=NULL?'&nbsp;&nbsp;'.text($data['SSA_FAX']):'..............................................................................';
$SSA_MOBILE=trim($data['SSA_MOBILE'])!=''?text($data['SSA_MOBILE']):'...............................................................';

$SSA_EMAIL=trim($data['SSA_EMAIL'])!=''?text($data['SSA_EMAIL']):'...............................................................................';

$html = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
			<tr>
				<td colspan=\"3\" align=\"right\"><font size=\"17\">แบบ ส.ส. ๑ $SS_NO</font></td>
			</tr>
			<tr>
				<td width=\"20%\">&nbsp;</td>
				<td width=\"60%\" align=\"center\"><img src=\"".$path."images/garuda_emblem.jpg\" width=\"80\" height=\"80\"></td>
				<td align=\"center\" width=\"20%\"> สำหรับเจ้าหน้าที่ <br>
					<table border=\"1\">
						<tr>
							<td colspan=\"3\" height=\"25\" align=\"center\">เลขประจำตัว</td>
						</tr>
						<tr>
							<td  height=\"25\">&nbsp;</td>
							<td  height=\"25\">&nbsp;</td>
							<td  height=\"25\">&nbsp;</td>
						</tr>
					</table>
				
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align=\"center\" ><font size=\"20\" >แบบแสดงตนสมาชิกสภาผู้แทนราษฎร ชุดที่ ".$ss_num_th."</font></td>
				<td style=\"padding-bottom: 20px\">&nbsp;&nbsp;
					<table border=\"0\"><tr><td width=\"2.5cm\" height=\"3.25cm\" align=\"center\" valign=\"middle\" >1</td></tr></table>
				</td>
			</tr>
			</table><br><br>";
if($data['SSP_PARENT_ID'] == ''||$data['SSP_PARENT_ID'] == NULL){// if สส ก. else สส. ข
$A = "                  <tr>
				<td colspan=\"2\" align=\"left\"><font size=\"17\"><img src=\"".$path."images/".$type_pic2."\" width=\"10\" height=\"10\" > &nbsp;<b>ได้รับเลือกตั้งเป็นสมาชิกสภาผู้แทนราษฎรแทน</b></font>
				</td>
			</tr>
			<tr>
				<td colspan=\"2\"><dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				พรรค " .$PARTY_NAME_TH_NVI."  เขตเลือกตั้งที่ "  .$SSP_DISTRICT_ID_NVI."</dd></td>
			</tr>
			<tr>
				<td colspan=\"2\"><dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				จังหวัด ".$PROV_TH_NAME_NVI." เมื่อวันที่  "  .$SSP_ELECTION_DATE_NVI."</dd></td>
			</tr>
			<tr>
				<td colspan=\"2\" align=\"left\"><font size=\"17\"><img src=\"".$path."images/".$type_pic1."\" width=\"10\" height=\"10\" > &nbsp;<b>ได้รับการประกาศเลื่อนบัญชีรายชื่อแทน</b></font>
				</td>
			</tr>
			<tr>
				<td colspan=\"2\"><dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				พรรค "  .$PARTY_NAME_TH."</dd></td>
			</tr>
			<tr>
				<td colspan=\"2\"><dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				ลำดับที่ในบัญชีรายชื่อ ".$SSP_NUMBER." เมื่อวันที่ ".$SSP_ELECTION_DATE."</dd></td>
			</tr>";
}else{
$A = "                  <tr>
				<td colspan=\"2\" align=\"left\"><dl><dt><font size=\"17\"><b>ได้รับเลือกตั้งเป็นสมาชิกสภาผู้แทนราษฎร</b></font></dt></dl>
				</td>
			</tr>
			<tr>
				<td colspan=\"2\">
					<table border=\"0\" >
						<tr>
							<td width=\"15%\">&nbsp;</td>
							<td width=\"23%\"><img src=\"".$path."images/".$type_pic1."\" width=\"10\" height=\"10\" > &nbsp;แบบบัญชีรายชื่อ</td>
							<td width=\"62%\">พรรค "  .$PARTY_NAME_TH." <br>
							ลำดับที่ในบัญชีรายชื่อ ".$SSP_NUMBER." เมื่อวันที่  "  .$SSP_ELECTION_DATE." 
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><img src=\"".$path."images/".$type_pic2."\" width=\"10\" height=\"10\" > &nbsp;แบบแบ่งเขตเลือกตั้ง</td>
							<td>พรรค "  .$PARTY_NAME_TH_NVI."  เขตเลือกตั้งที่ "  .$SSP_DISTRICT_ID_NVI." <br>
							จังหวัด ".$PROV_TH_NAME_NVI." เมื่อวันที่  "  .$SSP_ELECTION_DATE_NVI." 
							
							</td>
						</tr>
					</table>
				
				</td>
			</tr>";
}
$html .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
			<tr>
				<td width=\"50%\">&nbsp;</td>
				<td  >&nbsp; วันที ........................................</td>
			</tr>
			<tr>
				<td colspan=\"2\"><dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				ชื่อ - ชื่อสกุล  " .Showname($data["PREFIX_ID"],$data["SS_FIRSTNAME_TH"],$data["SS_MIDNAME_TH"],$data["SS_LASTNAME_TH"],'th')."นายจิรพันธุ์ เปรื่องชนะ</dd></td>
			</tr>
			<tr>
				<td colspan=\"2\">ชื่อ - ชื่อสกุล (ภาษาอังกฤษ) " .$name_en."</td>
			</tr>
			<tr>
				<td colspan=\"2\"><b>(ให้ตรงกับหนังสือเดินทาง (พาสปอร์ต) ถ้ามี)</b></td>
			</tr>
			<tr>
				<td colspan=\"2\">(คำอ่าน) ชื่อ - ชื่อสกุล " .Showname('',$data["SS_FIRSTNAME_SPELL"],$data["SS_MIDNAME_SPELL"],$data["SS_LASTNAME_SPELL"])."</td>
			</tr>
			$A
			<tr>
				<td colspan=\"3\" align=\"left\"><font size=\"17\"><b>หลักฐานสำคัญที่แนบมาพร้อมนี้</b></font></td>
			</tr>
			
			<tr>
				<td colspan=\"3\"><dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					
								//หลักฐานสำคัญที่แนบ 

					$sql_envi = "select ENVI_ID, ENVI_NAME_TH from SETUP_EVNIDENCE where ACTIVE_STATUS='1' and DELETE_FLAG='0' order by ENVI_NAME_TH asc";
					$query_envi = $db->query($sql_envi);
					$nums_envi = $db->db_num_rows($query_envi);
					$columns=2;
					if($nums_envi > 0){
					$html .="<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
                             $i=0;
                        while($rec_envi = $db->db_fetch_array($query_envi)){
						$sql_envi_sub=$db->query("select * from SS_PRESENT_ENVI where SSP_ID='".$SSP_ID."' and ENVI_ID='".$rec_envi['ENVI_ID']."'");
							$num_envi = $db->db_num_rows($sql_envi_sub);
							if($i % $columns == 0){
								$html .= "<tr>";
							}
							$html .="
								<td width=\"50%\"><img src=\"".$path."images/".($num_envi=='1'?"pdf_check.jpg":"pdf_uncheck.jpg")."\" width=\"10\" height=\"10\" > &nbsp;".text($rec_envi['ENVI_NAME_TH'])."
								</td>
							";
							if(($i % $columns) == ($columns - 1) || ($i + 1) == $nums_envi){
								$html .= "</tr>";
							}
						$i++;
						}
					$html .="</table>";
					}else{
					$html .="<dd>ไม่มีข้อมูล</dd>";
					}
					
			
					
				$html .="</dd></td>
			</tr>
		</table>";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='',  $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
 
 
 $pdf->setXY(83,109); 
$pdf->Cell(60, 0, '...................................................................................................................', 0, 1, 'L', 0, '', 0, false, 'B', 'M'); 
 $pdf->setXY(83,117); 
$pdf->Cell(60, 0, '...................................................................................................................', 0, 1, 'L', 0, '', 0, false, 'B', 'M'); 
 
 
//echo $html;
// ---------------------------------------------------------
//echo $html;
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('sapa_form1_1_'.date("ymd").'.pdf', 'I');
?>