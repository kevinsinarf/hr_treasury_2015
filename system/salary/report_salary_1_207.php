<?php 
$menu_name = 207;
$menu_num = "4. ";
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
 

 $sql =  attached_sql(" WHERE  A.SAL_UP_TYPE = 1 AND A.CONFIRM_TYPE = 3 AND A.YEAR_BDG = '".$AGE_IS."' AND A.ROUND = '".$ROUND."' AND A.POSTYPE_ID = 1 AND A.SALARY_NOW < 12285 
AND A.SAL_COMPENSATION_4 > 0 ");
 //" WHERE A.YEAR_BDG = '".$AGE_IS."' AND A.ROUND = '".$ROUND."' AND  A.SAL_COMPENSATION_4 > 0 AND A.POSTYPE_ID =1  AND A.CONFIRM_TYPE = 3 AND A.SAL_UP_TYPE = 2    AND  N.CONFIRM_TYPE = 2 " );
 
 /*
 SELECT B.PER_IDCARD,B.PREFIX_ID,B.PER_ID,B.PER_FIRSTNAME_TH,B.PER_MIDNAME_TH, B.PER_LASTNAME_TH ,B.POS_NO,
			A.SAL_COMPENSATION_4, A.SALARY_NEW, A.SALARY_NOW, A.SAL_UP_ID,	TYPE_NAME_TH,LEVEL_NAME_TH,LINE_NAME_TH, F.ORG_NAME_TH AS ORG_NAME_3, 
			G.MANAGE_NAME_TH, H.ORG_NAME_TH AS ORG_NAME_4
			FROM SAL_UP_SALARY A 
			INNER JOIN PER_PROFILE B ON A.PER_ID = B.PER_ID 
			LEFT  JOIN SETUP_POS_TYPE C ON A.TYPE_ID = C.TYPE_ID
			LEFT  JOIN SETUP_POS_LINE D ON A.LINE_ID = D.LINE_ID
			LEFT  JOIN SETUP_POS_LEVEL E ON A.LEVEL_ID = E.LEVEL_ID
			LEFT  JOIN SETUP_ORG F ON A.ORG_ID_3 = F.ORG_ID
			LEFT JOIN SETUP_ORG H ON A.ORG_ID_4 = H.ORG_ID
			LEFT  JOIN SETUP_POS_MANAGE G  ON A.MANAGE_ID = G.MANAGE_ID
			WHERE  SAL_UP_TYPE = 1 AND CONFIRM_TYPE = 3 AND A.YEAR_BDG = '2557' AND ROUND = '1' AND A.POSTYPE_ID = 1 AND A.SALARY_NOW < 12285 
AND SAL_COMPENSATION_4 > 0 */
 
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
							$SALARY_NOW = $rec['SALARY_NOW'];
							$SALARY_NEW = $rec['SALARY_NEW'];
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
							 
 
									  </tr>";
							 
							$ORG_NAME_OLD = $ORG_NAME;				  
						  }			
						  
						  $all_salary = $SAL_COMPENSATION_4 + $SALARY_NEW;				
							
						  $html .= "<tr style='background-color:#fff;'  > 
							<td CENTER_TOP >".toThaiNumber($i)."</td>
							<td CENTER_TOP >".toThaiNumber(get_idCard($IDCARD['PER_IDCARD']))."</td>	
							<td LEFT_TOP >".$PER_NAME."</td>


							<td LEFT_TOP >".$LINE_NAME."</td>
							<td LEFT_TOP >".$TYPE_NAME_TH."</td>
							<td LEFT_TOP >".$LEVEL_NAME."</td>
							<td CENTER_TOP >".toThaiNumber($POSITION_NO)."</td>
	 
							<td RIGHT_TOP >".toThaiNumber(number_format($SALARY_NEW,2))."</td>
							<td RIGHT_TOP >".toThaiNumber(number_format($SAL_COMPENSATION_4,2))."</td>
							<td RIGHT_TOP >".toThaiNumber(number_format($all_salary,2))."</td>

							<td RIGHT_TOP >".$REMARKS."</td>
						
						  </tr>";
						  	$i++;
						}
	 				  }
	 
	 
include_once("inc_report_bottom.php"); 
// End report 1
?>