<?php 
$menu_name = 208;
$menu_num = "5. ";
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
 
 $sql =  attached_sql("WHERE A.SAL_UP_TYPE = 1 AND A.CONFIRM_TYPE = 3 AND A.YEAR_BDG = '".$AGE_IS."' AND A.ROUND = '".$ROUND."'
 AND A.POSTYPE_ID = 1 AND A.SALARY_SPE_UP > 0 AND A.SAL_COM_SPE > 0");
 
 //" WHERE A.YEAR_BDG = '".$AGE_IS."' AND A.ROUND = '".$ROUND."' AND  A.SALARY_SPE_UP > 0 AND A.POSTYPE_ID = 1   AND A.CONFIRM_TYPE = 3 AND A.SAL_UP_TYPE = 2      AND  M.CONFIRM_TYPE = 2 ");
$query = $db->query($sql);
$nums = $db->db_num_rows($query);  


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
							$SALARY_NOW = $rec['SALARY_NOW'];
							$SALARY_NEW = $rec['SALARY_NEW'];
							$SALARY_SPE_UP = $rec['SALARY_SPE_UP'];
							$SAL_COMPENSATION_4 = $rec['SAL_COMPENSATION_4'];
							$LEVEL_SALARY_MID = $rec['LEVEL_SALARY_MID']; //ฐานในการคำนวณ
							$PER_NAME =   get_name_salup(text($rec['NAME']));
							$POSITION_NO = (trim($rec['POS_NO'])!='') ? $rec['POS_NO'] : '-';
							$TYPE_NAME_TH = text($rec['TYPE_NAME_TH']);
							$LINE_NAME = (trim($rec['LINE_NAME_TH']) != '') ? text($rec['LINE_NAME_TH']) : '-';
							$LEVEL_NAME = (trim($rec['LEVEL_NAME_TH']) != '') ? text($rec['LEVEL_NAME_TH']) : '-';
							$ORG_NAME = (trim($rec['ORG_NAME_3']) != '') ? text($rec['ORG_NAME_3']) : '-';
							$POSITION_NAME = '<strong>เลขที่ตำแหน่ง</strong> : '.$POSITION_NO.'<br><strong>ตำแหน่งในสายงาน</strong> : '.$LINE_NAME.'<br><strong>ระดับตำแหน่ง</strong> : '.$LEVEL_NAME.'<br><strong>กลุ่มงาน</strong> : '.$ORG_NAME;

						    $PERCENT = @($SALARY_UP/$SALARY_NOW)*100;
 
 
							
 
							$sql_org4 = "SELECT ORG_NAME_TH FROM SETUP_ORG WHERE  ORG_ID = '".$org4."' ";
							$query_org4 = $db->query($sql_org4);
							$rec_org4 = $db->db_fetch_array($query_org4);
							
							$sql_IDCARD = "SELECT PER_IDCARD FROM PER_PROFILE WHERE  PER_ID = '".$rec['PER_ID']."' ";
							$query_IDCARD = $db->query($sql_IDCARD);
							$IDCARD = $db->db_fetch_array($query_IDCARD);
							
							
							$q_edit = $db->query("SELECT LEVEL_SALARY_MAX,SCORE FROM SAL_UP_SALARY WHERE YEAR_BDG = '".$AGE_IS."' AND CONFIRM_TYPE = 2 AND ROUND = '".$ROUND."' AND PER_ID = '".$rec['PER_ID']."' ");
							$r_edit = $db->db_fetch_array($q_edit);
							
							if($r_edit['SCORE']>0){
								$final = $r_edit['SCORE'];
								$LEVEL_SALARY_MAX = $r_edit['LEVEL_SALARY_MAX'];
							}
								
							
							
							$all_sallary = $SAL_COMPENSATION_4+$SALARY_SPE_NEW;
							

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
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
									  </tr>";
							 
							$ORG_NAME_OLD = $ORG_NAME;				  
						  }			
						  
						  $all_salary = $SAL_COMPENSATION_4 + $SALARY_NEW;		
							
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
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
										<td CENTER_TOP >   </td>
									  </tr>";
							 
							$ORG_NAME_OLD = $ORG_NAME;				  
						  }							
							
						  $html .= "<tr style='background-color:#fff;'  > 
							<td CENTER_TOP >".toThaiNumber($i)."</td>
							<td CENTER_TOP >".toThaiNumber(get_idCard($IDCARD['PER_IDCARD']))."</td>
							<td LEFT_TOP >".$PER_NAME."</td>


							<td LEFT_TOP >".$LINE_NAME."</td>
							<td LEFT_TOP >".$TYPE_NAME_TH."</td>
							<td LEFT_TOP >".$LEVEL_NAME."</td>
							<td CENTER_TOP >".toThaiNumber($POSITION_NO)."</td>
							
							<td CENTER_TOP >".toThaiNumber($POSITION_NO)."</td>
							<td RIGHT_TOP >".toThaiNumber(number_format($SALARY_NOW,2))."</td>
							<td RIGHT_TOP >".toThaiNumber($LEVEL_SCORE_NAME)."</td>
							<td RIGHT_TOP >".toThaiNumber($SCORE_PERCENT)."</td>
							<td RIGHT_TOP >".toThaiNumber(number_format($PERCENT,2))."</td>
							<td RIGHT_TOP >".toThaiNumber(number_format($SALARY_UP,2))."</td>
							<td RIGHT_TOP >".toThaiNumber(number_format($SALARY_NEW,2))."</td>
							<td RIGHT_TOP >".toThaiNumber(number_format($LEVEL_SALARY_MAX,2))."</td>
							<td RIGHT_TOP >".toThaiNumber(number_format($SALARY_SPE_UP,2))."</td>
							<td RIGHT_TOP > ".$REMARKS." </td>
						
						  </tr>";
						  	$i++;
						}
	 				  }
	 
	 
include_once("inc_report_bottom.php"); 
// End report 1
?>