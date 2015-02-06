<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$proc = $_REQUEST['proc'];
$STEP_ID = $_POST['STEP_ID'];
$S_STEP_ACTIVE_DATE = $_POST['S_STEP_ACTIVE_DATE'];
$LEVEL_ID = $_POST['S_LEVEL'];
$ACTIVE_STATUS = $_POST['ACTIVE_STATUS'];

$STEP_NO = $_POST['STEP_NO'];
$SAL_MONTH = $_POST['SAL_MONTH'];
$url_back="../set_salary2_disp.php";
$table = "SAL_STEP";
$table2 = "SAL_STEP_DETAIL";

switch($proc){	
	case 'add' :
		try{
			$fields = array(
				"STEP_ACTIVE_DATE" => conv_date_db($S_STEP_ACTIVE_DATE),
				"LEVEL_ID" => $LEVEL_ID,
				"POSTYPE_ID" => 3,
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"CREATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);
			$db->db_insert($table,$fields);
			
			$STEP_ID = $db->get_data_field("SELECT MAX(STEP_ID) AS STEP_ID FROM ".$table." WHERE POSTYPE_ID = 3 AND STEP_ACTIVE_DATE = '".conv_date_db($S_STEP_ACTIVE_DATE)."' AND LEVEL_ID = '".$LEVEL_ID."'", "STEP_ID");
			if(count($STEP_NO) > 0){
				foreach($STEP_NO as $key => $no){
					$fields_detail = array(
						"STEP_ID" => $STEP_ID,
						"STEP_NO" => $no,
						"SAL_MONTH" => str_replace(",","",$SAL_MONTH[$key]),
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
				"LEVEL_ID" => $LEVEL_ID,
				"POSTYPE_ID" => 3,
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
	<input type="hidden" id="S_LEVEL" name="S_LEVEL" value="<?php echo $LEVEL_ID;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
