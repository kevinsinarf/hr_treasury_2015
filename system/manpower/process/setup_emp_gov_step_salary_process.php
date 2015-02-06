<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$proc = $_REQUEST['proc'];
$T_GROUP_ID = $_POST['T_GROUP_ID'];
$T_LINE_ID = $_POST['T_LINE_ID'];
$T_LEVEL_ID = $_POST['T_LEVEL_ID'];
$S_STEP = $_POST['S_STEP'];
$E_STEP = $_POST['E_STEP'];

$TYPE_ID = $_POST['TYPE_ID'];
$LG_ID = $_POST['LG_ID'];
$LINE_ID = $_POST['LINE_ID'];
$LEVEL_ID = $_POST['LEVEL_ID'];
$GROUP_ID = $_POST['GROUP_ID'];
$STEP_SEQ = $_POST['STEP_SEQ'];
$STEP_NO = $_POST['STEP_NO'];
$SAL_MONTH = $_POST['SAL_MONTH'];
$SAL_DAY = $_POST['SAL_DAY'];
$SAL_HOURS = $_POST['SAL_HOURS'];

$url_back="../setup_emp_gov_step_salary_disp.php";
$TB = "SETUP_POS_STEP_EMP_GOV_SALARY";

switch($proc){	
	case 'AddTransfer' :
	try{
		$db->query('BEGIN TRANSACTION');
		
		$query_line = $db->query("SELECT A.LINE_ID,  A.LG_ID, B.TYPE_ID  FROM SETUP_POS_LINE A JOIN SETUP_POS_LINE_GROUP B ON A.LG_ID = B.LG_ID WHERE A.LINE_ID = '".$T_LINE_ID."' ");
		$rec_line = $db->db_fetch_array($query_line);
		$sql_step = "SELECT A.LEVEL_SEQ,  B.STEP_NO, B.SAL_DAY, B.SAL_MONTH, B.SAL_HOURS
		                     FROM SAL_STEP A
							 JOIN SAL_STEP_DETAIL B ON A.STEP_ID = B.STEP_ID 
							 WHERE A.POSTYPE_ID = 5  AND A.ACTIVE_STATUS = 1 AND A.LEVEL_SEQ = '".$T_GROUP_ID."' AND B.STEP_NO BETWEEN ".$S_STEP." AND ".$E_STEP;
		$query_step = $db->query($sql_step);
		while($rec = $db->db_fetch_array($query_step)){
			  $query_chk = $db->query("SELECT COUNT(S_STEP_ID) AS NUM_STEP FROM SETUP_POS_STEP_EMP_GOV_SALARY WHERE LINE_ID = '".$T_LINE_ID."' AND GROUP_ID = '".$rec['LEVEL_SEQ']."' AND STEP_NO = '".$rec['STEP_NO']."'  ");
			  $rec_chk = $db->db_fetch_array($query_chk);
			  $num_chk = $rec_chk['NUM_STEP'];
			  
			  if($num_chk > 0){
				  $db->db_delete($TB,"  LINE_ID '".$T_LINE_ID."' AND GROUP_ID = '".$rec['LEVEL_SEQ']."' AND STEP_NO = '".$rec['STEP_NO']."' ");
			  }
			  $fields = array(
				  "TYPE_ID" => $rec_line['TYPE_ID'],
				  "LEVEL_ID" => $T_LEVEL_ID,
				  "LG_ID" => $rec_line['LG_ID'],
				  "LINE_ID" => $T_LINE_ID,
				  "GROUP_ID" => $rec['LEVEL_SEQ'],
				  "STEP_NO" => $rec['STEP_NO'],
				  "SAL_DAY" => $rec['SAL_DAY'],
				  "SAL_MONTH" => $rec['SAL_MONTH'],
				  "SAL_HOURS" => $rec['SAL_HOURS'],
				  "CREATE_BY" => $USER_BY,
				  "CREATE_DATE" => $TIMESTAMP
			  );
			  $db->db_insert($TB,$fields);
			
		}
		
		$db->query("COMMIT TRANSACTION");
		$LINE_ID = $T_LINE_ID;
		$LEVEL_ID = $T_LEVEL_ID; 
		$text= text('นำเข้าขั้นค่าจ้าง เรียบร้อยแล้ว');
	}catch(Exception $e){
			$db->query('ROLLBACK TRANSACTION');
			$text=$e->getMessage();
	}
	break;
	case 'add' :
		try{
			$db->query('BEGIN TRANSACTION');
			
			$db->db_delete($TB," LINE_ID = '".$LINE_ID."' ");
			if(count($STEP_NO) > 0){
				foreach($STEP_NO as $key => $no){
					$fields = array(
						"TYPE_ID" => $TYPE_ID,
				  		"LEVEL_ID" => $LEVEL_ID,
				  		"LG_ID" => $LG_ID,
				  		"LINE_ID" => $LINE_ID,
				  		"GROUP_ID" => $GROUP_ID[$key],
				 		"STEP_NO" => $no,
						"STEP_SEQ" => $STEP_SEQ[$key],
				       "SAL_MONTH" => str_replace(",","",$SAL_MONTH[$key]),
				       "SAL_DAY" => str_replace(",","",$SAL_DAY[$key]),
				       "SAL_HOURS" => str_replace(",","",$SAL_HOURS[$key]),
				       "CREATE_BY" => $USER_BY,
				       "CREATE_DATE" => $TIMESTAMP
					);	
					$db->db_insert($TB,$fields);
				}
			}
			$db->query("COMMIT TRANSACTION");
			$text=$save_proc;
		}catch(Exception $e){
			$db->query('ROLLBACK TRANSACTION');
			$text=$e->getMessage();
		}
	break;
	
	case 'edit' :
		try{
			$fields = array(
				"STEP_ACTIVE_DATE" => conv_date_db($S_STEP_ACTIVE_DATE),
				"LEVEL_SEQ" => $S_LEVEL_SEQ,
				"POSTYPE_ID" => 5,
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);
			$db->db_update($table, $fields, " STEP_ID = '".$STEP_ID."'");
			
			$db->db_delete($table2," STEP_ID = '".$STEP_ID."'");
			if(count($STEP_NO) > 0){
				foreach($STEP_NO as $key => $no){
					$fields_detail = array(
						"STEP_ID" => $STEP_ID,
						"STEP_NO" => $no,
						"SAL_MONTH" => str_replace(",","",$SAL_MONTH[$key]),
						"SAL_DAY" => str_replace(",","",$SAL_DAY[$key]),
						"SAL_HOURS" => str_replace(",","",$SAL_HOURS[$key]),
						"CREATE_BY" => $USER_BY,
						"CREATE_DATE" => $TIMESTAMP,
						"UPDATE_BY" => $USER_BY,
						"UPDATE_DATE" => $TIMESTAMP,
					);	
					$db->db_insert($table2,$fields_detail);
				}
			}
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}	
	break;
}
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="search" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
    <input type="hidden" id="LEVEL_ID" name="LEVEL_ID" value="<?php echo $LEVEL_ID; ?>">
    <input type="hidden" id="LINE_ID" name="LINE_ID" value="<?php echo $LINE_ID; ?>" >
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
