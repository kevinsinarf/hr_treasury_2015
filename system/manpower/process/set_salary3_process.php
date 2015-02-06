<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$proc = $_REQUEST['proc'];
$STEP_ID = $_POST['STEP_ID'];
$S_STEP_ACTIVE_DATE = $_POST['S_STEP_ACTIVE_DATE'];
$S_LEVEL_SEQ = $_POST['S_LEVEL_SEQ'];
$ACTIVE_STATUS = $_POST['ACTIVE_STATUS'];

$STEP_NO = $_POST['STEP_NO'];
$SAL_MONTH = $_POST['SAL_MONTH'];
$SAL_DAY = $_POST['SAL_DAY'];
$SAL_HOURS = $_POST['SAL_HOURS'];

$url_back="../set_salary3_disp.php";
$table = "SAL_STEP";
$table2 = "SAL_STEP_DETAIL";

switch($proc){	
	case 'add' :
		try{
			$fields = array(
				"STEP_ACTIVE_DATE" => conv_date_db($S_STEP_ACTIVE_DATE),
				"LEVEL_SEQ" => $S_LEVEL_SEQ,
				"POSTYPE_ID" => 5,
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"CREATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);
			$db->db_insert($table,$fields);
			
			$STEP_ID = $db->get_data_field("SELECT MAX(STEP_ID) AS STEP_ID FROM ".$table." WHERE POSTYPE_ID = 5  AND STEP_ACTIVE_DATE = '".conv_date_db($S_STEP_ACTIVE_DATE)."' AND LEVEL_SEQ = '".$S_LEVEL_SEQ."'", "STEP_ID");
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
	<input type="hidden" id="S_STEP_ACTIVE_DATE" name="S_STEP_ACTIVE_DATE" value="<?php echo $S_STEP_ACTIVE_DATE;?>" />
	<input type="hidden" id="S_LEVEL_SEQ" name="S_LEVEL_SEQ" value="<?php echo $S_LEVEL_SEQ;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
