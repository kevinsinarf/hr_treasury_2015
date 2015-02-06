<?php 
$menu_name = 302;
$menu_num = "12".$number_subfix;
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
 
$sql =  attached_sql(" WHERE A.YEAR_BDG = '".$AGE_IS."' AND A.ROUND = '".$ROUND."' AND  A.SALARY_UP > 0 AND   A.POSTYPE_ID =5  AND A.CONFIRM_TYPE = 3 AND A.SAL_UP_TYPE = 2    AND  K.CONFIRM_TYPE = 2    ");
   
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
							$PER_NAME =   get_name_salup(text($rec['NAME']));
							$POSITION_NO = (trim($rec['POS_NO'])!='') ? $rec['POS_NO'] : '-';
							$LINE_NAME = (trim($rec['LINE_NAME_TH']) != '') ? text($rec['LINE_NAME_TH']) : '-';
							$LEVEL_NAME = (trim($rec['LEVEL_NAME_TH']) != '') ? text($rec['LEVEL_NAME_TH']) : '-';
							$ORG_NAME = (trim($rec['ORG_NAME_3']) != '') ? text($rec['ORG_NAME_3']) : '-';
							$POSITION_NAME = '<strong>เลขที่ตำแหน่ง</strong> : '.$POSITION_NO.'<br><strong>ตำแหน่งในสายงาน</strong> : '.$LINE_NAME.'<br><strong>ระดับตำแหน่ง</strong> : '.$LEVEL_NAME.'<br><strong>กลุ่มงาน</strong> : '.$ORG_NAME;

							
							$LEVEL_SALARY_MID = $db->get_data_field("SELECT LEVEL_SALARY_MID FROM SETUP_POS_LEVEL_SALARY WHERE POSTYPE_ID = '1' AND TYPE_ID = '".$rec['TYPE_ID']."' AND LEVEL_ID = '".$rec['LEVEL_ID']."' AND '".$rec['PER_SALARY']."' BETWEEN LEVEL_SALARY_MIN AND LEVEL_SALARY_MAX", "LEVEL_SALARY_MID");
							$q_edit = $db->query("SELECT * FROM SAL_UP_SALARY WHERE YEAR_BDG = '".$S_YEAR_BDG."' AND CONFIRM_TYPE = 2 AND ROUND = '".$S_ROUND."' AND PER_ID = '".$rec['PER_ID']."' ");
							$r_edit = $db->db_fetch_array($q_edit);
							
							if($r_edit['SCORE']>0){
								$final = $r_edit['SCORE'];
							}
							$REMARKS = text($rec['REMARKS']);  
							$sql_org4 = "SELECT ORG_NAME_TH FROM SETUP_ORG WHERE  ORG_ID = '".$org4."' ";
							$query_org4 = $db->query($sql_org4);
							$rec_org4 = $db->db_fetch_array($query_org4);
							
							$sql_IDCARD = "SELECT PER_IDCARD FROM PER_PROFILE WHERE  PER_ID = '".$rec['PER_ID']."' ";
							$query_IDCARD = $db->query($sql_IDCARD);
							$IDCARD = $db->db_fetch_array($query_IDCARD);
							
							
                          if($ORG_NAME_OLD != $ORG_NAME){
						  if($ORG_NAME=="-"){ $ORG_NAME = "&nbsp;"; }
							  $html .= " <tr style='background-color:#fff;'  > 
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td  LEFT_TOP colspan=2  >".$ORG_NAME."</td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
									 

									  </tr>";
							 
							$ORG_NAME_OLD = $ORG_NAME;				  
						  }							
							
						  $html .= "<tr style='background-color:#fff;'  > 
							<td CENTER_TOP >".toThaiNumber($i)."</td>

							<td LEFT_TOP >".$PER_NAME."</td>
							<td CENTER_TOP >".toThaiNumber(get_idCard($IDCARD['PER_IDCARD']))."</td>
							<td LEFT_TOP >".$LINE_NAME."</td>
							<td LEFT_TOP >".$LEVEL_NAME."</td>
							<td CENTER_TOP >".toThaiNumber($POSITION_NO)."</td>
							<td RIGHT_TOP >".toThaiNumber(number_format($SALARY_NOW,2))."</td>
							<td RIGHT_TOP >".toThaiNumber(number_format($SALARY_NEW,2))."</td>
		 
 
							<td RIGHT_TOP > ".$REMARKS." </td>
						
						  </tr>";
						  	$i++;
						}
	 				  }
	 
	 
include_once("inc_report_bottom.php"); 
// End report 1
?>