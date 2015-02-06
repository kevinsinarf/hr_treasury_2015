<?php 
$menu_name = 205;
$menu_num = "10. ";
 $sum_all = 1;
$year_fillter_is = '';
$AGE_IS = (int)$_POST['AGE_IS']; 
if($AGE_IS > 0){
   $year_fillter_is = $AGE_IS;
}
$title_1 = $year_fillter_is;
// filter area
include_once("inc_report_top.php");
include_once("inc_year_round.php");  
 
   $arr_org = array();
 

 $sql =  attached_sql("WHERE SAL_UP_TYPE = 1 AND A.CONFIRM_TYPE = 3 AND A.YEAR_BDG = '".$AGE_IS."' AND A.ROUND = '".$ROUND."' AND A.POSTYPE_ID = 3 AND A.SALARY_NEW < 12285");
 
 //" WHERE A.YEAR_BDG = '".$AGE_IS."' AND A.ROUND = '".$ROUND."' AND  A.SAL_COMPENSATION_4 > 0 AND A.POSTYPE_ID = 3  AND A.CONFIRM_TYPE = 3 AND A.SAL_UP_TYPE = 2   AND  N.CONFIRM_TYPE = 2  ");
  
$query = $db->query($sql);
$nums = $db->db_num_rows($query);  
 
	 //echo "<pre>"; print_r($row);
	 
	 
					if($nums > 0){
						$i = 1;
						$ORG_NAME_OLD = "";
						while($rec = $db->db_fetch_array($query)){
							$final = 0;
							$org4 = (int)$rec['ORG_ID_4'];
							$PER_IDCARD = (int)$rec['PER_IDCARD'];
							$SCORE = $rec['SCORE'];
							$SCORE_PERCENT = $rec['SCORE_PERCENT']." % ";
							$LEVEL_SCORE_NAME = text($rec['LEVEL_NAME']);
							$REMARKS = text($rec['REMARKS']);  
							$SALARY_UP = $rec['SALARY_UP'];
							$SALARY_SPE_NOW = $rec['SALARY_SPE_NOW'];
							$SALARY_SPE_NEW = $rec['SALARY_SPE_NEW'];
							$SAL_COMPENSATION_4 = $rec['SAL_COMPENSATION_4'];
							$LEVEL_SALARY_MID = $rec['LEVEL_SALARY_MID']; //ฐานในการคำนวณ
							$PER_NAME =   get_name_salup(text($rec['NAME']));
							$POSITION_NO = (trim($rec['POS_NO'])!='') ? $rec['POS_NO'] : '-';
							$LINE_NAME = (trim($rec['LINE_NAME_TH']) != '') ? text($rec['LINE_NAME_TH']) : '-';
							$LEVEL_NAME = (trim($rec['LEVEL_NAME_TH']) != '') ? text($rec['LEVEL_NAME_TH']) : '-';
							$ORG_NAME = (trim($rec['ORG_NAME_TH']) != '') ? text($rec['ORG_NAME_TH']) : '-';
							$POSITION_NAME = '<strong>เลขที่ตำแหน่ง</strong> : '.$POSITION_NO.'<br><strong>ตำแหน่งในสายงาน</strong> : '.$LINE_NAME.'<br><strong>ระดับตำแหน่ง</strong> : '.$LEVEL_NAME.'<br><strong>กลุ่มงาน</strong> : '.$ORG_NAME;

 
							$sql_org4 = "SELECT ORG_NAME_TH FROM SETUP_ORG WHERE  ORG_ID = '".$org4."' ";
							$query_org4 = $db->query($sql_org4);
							$rec_org4 = $db->db_fetch_array($query_org4);
							
							$sql_IDCARD = "SELECT PER_IDCARD FROM PER_PROFILE WHERE  PER_ID = '".$rec['PER_ID']."' ";
							$query_IDCARD = $db->query($sql_IDCARD);
							$IDCARD = $db->db_fetch_array($query_IDCARD);
							
							$all_sallary = $SAL_COMPENSATION_4+$SALARY_SPE_NEW;
 						
							
						  $html .= "<tr style='background-color:#fff;'  > 
							<td CENTER_TOP >".toThaiNumber($i)."</td>
							<td CENTER_TOP >".toThaiNumber(get_idCard($IDCARD['PER_IDCARD']))."</td>	
							<td LEFT_TOP >".$PER_NAME."</td>
							<td LEFT_TOP >".$LINE_NAME."</td>
							<td CENTER_TOP >".toThaiNumber($POSITION_NO)."</td>
 
						 
							<td RIGHT_TOP >".toThaiNumber(number_format($SALARY_SPE_NEW,2))."</td>
							<td RIGHT_TOP >".toThaiNumber(number_format($SAL_COMPENSATION_4,2))."</td>
							<td RIGHT_TOP >".toThaiNumber(number_format($all_sallary,2))."</td>
						
						  </tr>";
						  	$i++;
						}
	 				  }
	 
	 
include_once("inc_report_bottom.php"); 
// End report 1
?>