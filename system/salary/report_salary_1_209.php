<?php 
$menu_name = 209;
 
$sum_all = 1;
$year_fillter_is = '';
$AGE_IS = (int)$_POST['AGE_IS']; 
if($AGE_IS > 0){
   $year_fillter_is = $AGE_IS;
}
$title_1 = $year_fillter_is;
// filter area
include_once("inc_report_top.php");
?>
<?php include_once("inc_year_round.php"); ?>
<?php  
   $arr_org = array();
 

	$MANAGE_NAME = $db->get_data_field("SELECT MT_NAME_TH FROM SETUP_POS_MANAGE_TYPE WHERE 1=1 ", "MT_NAME_TH");
	$ORG_NAME = $db->get_data_field("SELECT ORG_NAME_TH FROM SETUP_ORG WHERE ORG_ID = '".$ORG_ID."'", "ORG_NAME_TH");
	
	$field = "PER_ID, PREFIX_ID,PER_IDCARD , PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH, POS_ID, POS_NO, PER_PROFILE.TYPE_ID, TYPE_NAME_TH, PER_PROFILE.LEVEL_ID, LEVEL_NAME_TH, LINE_NAME_TH, ORG_NAME_TH, PER_SALARY, PER_COMPENSATION_2, ORG_ID_4";
	$table = "PER_PROFILE LEFT JOIN SETUP_POS_TYPE ON SETUP_POS_TYPE.TYPE_ID = PER_PROFILE.TYPE_ID
			  LEFT JOIN SETUP_POS_LEVEL ON SETUP_POS_LEVEL.LEVEL_ID = PER_PROFILE.LEVEL_ID
			  LEFT JOIN SETUP_POS_LINE ON SETUP_POS_LINE.LINE_ID = PER_PROFILE.LINE_ID
			  LEFT JOIN SETUP_ORG ON  PER_PROFILE.ORG_ID_3 = SETUP_ORG.ORG_ID ";
	$pk_id = "PER_ID";
	$wh = "PER_PROFILE.DELETE_FLAG = '0' AND PER_PROFILE.ACTIVE_STATUS = '1' 
	        AND PT_ID = '1' ";
	//$wh .= "			 AND ORG_ID_3 = '".$ORG_ID."'  ";
	$wh .= " AND (MANAGE_ID = '' OR MANAGE_ID IS NULL OR MANAGE_ID = '0') {$filter}";
	$orderby = "order by ORG_ID_3 ASC, TYPE_NAME_TH ASC ";
	$notin = $wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;
	
	$sql = "select ".$field." from ".$table." where ".$notin;
   
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));
	 //echo "<pre>"; print_r($row);
	 
	 
					if($nums > 0){
						$i = 1;
						$ORG_NAME_OLD = "";
						while($rec = $db->db_fetch_array($query)){
							$final = 0;
							$org4 = (int)$rec['ORG_ID_4'];
							$PER_IDCARD = (int)$rec['PER_IDCARD'];  
							$PER_NAME = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
							$POSITION_NO = (trim($rec['POS_NO'])!='') ? $rec['POS_NO'] : '-';
							$LINE_NAME = (trim($rec['LINE_NAME_TH']) != '') ? text($rec['LINE_NAME_TH']) : '-';
							$LEVEL_NAME = (trim($rec['LEVEL_NAME_TH']) != '') ? text($rec['LEVEL_NAME_TH']) : '-';
							$ORG_NAME = (trim($rec['ORG_NAME_TH']) != '') ? text($rec['ORG_NAME_TH']) : '-';
							$POSITION_NAME = '<strong>เลขที่ตำแหน่ง</strong> : '.$POSITION_NO.'<br><strong>ตำแหน่งในสายงาน</strong> : '.$LINE_NAME.'<br><strong>ระดับตำแหน่ง</strong> : '.$LEVEL_NAME.'<br><strong>กลุ่มงาน</strong> : '.$ORG_NAME;

							
							$LEVEL_SALARY_MID = $db->get_data_field("SELECT LEVEL_SALARY_MID FROM SETUP_POS_LEVEL_SALARY WHERE POSTYPE_ID = '1' AND TYPE_ID = '".$rec['TYPE_ID']."' AND LEVEL_ID = '".$rec['LEVEL_ID']."' AND '".$rec['PER_SALARY']."' BETWEEN LEVEL_SALARY_MIN AND LEVEL_SALARY_MAX", "LEVEL_SALARY_MID");
							$q_edit = $db->query("SELECT * FROM SAL_UP_SALARY WHERE YEAR_BDG = '".$S_YEAR_BDG."' AND CONFIRM_TYPE = 2 AND ROUND = '".$S_ROUND."' AND PER_ID = '".$rec['PER_ID']."' ");
							$r_edit = $db->db_fetch_array($q_edit);
							
							if($r_edit['SCORE']>0){
								$final = $r_edit['SCORE'];
							}
                             
							$sql_org4 = "SELECT ORG_NAME_TH FROM SETUP_ORG WHERE  ORG_ID = '".$org4."' ";
							$query_org4 = $db->query($sql_org4);
							$rec_org4 = $db->db_fetch_array($query_org4);
							
							$sql_IDCARD = "SELECT PER_IDCARD FROM PER_PROFILE WHERE  PER_ID = '".$rec['PER_ID']."' ";
							$query_IDCARD = $db->query($sql_IDCARD);
							$IDCARD = $db->db_fetch_array($query_IDCARD);
							
 					
							
						  $html .= "<tr style='background-color:#fff;'  > 
							<td CENTER_TOP >".$i."</td>
							<td CENTER_TOP >".$IDCARD['PER_IDCARD']."</td>	
							<td LEFT_TOP >".$PER_NAME."</td>

							<td LEFT_TOP >".$rec_org4['ORG_NAME_TH']."</td>
							<td RIGHT_TOP >   </td>
							<td RIGHT_TOP >   </td>
							<td CENTER_TOP >".$POSITION_NO."</td>
										<td CENTER_TOP >   </td>
							<td RIGHT_TOP >".number_format(0,2)."</td>
							<td RIGHT_TOP >".number_format(0,2)."</td>
							<td RIGHT_TOP >".number_format(0,2)."</td>
							<td RIGHT_TOP >".number_format(0,2)."</td>
							<td RIGHT_TOP >".number_format(0,2)."</td>
							<td RIGHT_TOP >".number_format(0,2)."</td>
							<td RIGHT_TOP >".number_format(0,2)."</td>
							<td RIGHT_TOP >".number_format(0,2)."</td>
							<td RIGHT_TOP >".number_format(0,2)."</td>
							<td RIGHT_TOP >".number_format(0,2)."</td>
							<td RIGHT_TOP >".number_format(0,2)."</td>
							<td RIGHT_TOP >".number_format(0,2)."</td>
							<td RIGHT_TOP >   </td>
						
						  </tr>";
						  	$i++;
						}
	 				  }
	 
	 
include_once("inc_report_bottom.php"); 
// End report 1
?>